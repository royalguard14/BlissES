<?php 
require_once 'BaseController.php'; 
class AdviserMngtController extends BaseController { 
    public function __construct($db) { 
        parent::__construct($db, ['9','8','7']);  
    } 
    public function show() {

       $adviserId = $_SESSION['user_id'];
       try {
        $result = $this->getAdviserSectionAndGrade($adviserId);
        $_SESSION['section_id'] = $result['section_id'];
        $stmt = $this->db->prepare("
            SELECT 
            s.id as section_id, 
            s.section_name, 
            s.daytime, 
            COALESCE(p.lrn, 'No Data') AS lrn, 
            CONCAT(
                COALESCE(p.last_name, ''), ', ',
                COALESCE(p.first_name, ''), ' ',
                COALESCE(
                    CASE
                    WHEN p.middle_name IS NOT NULL AND p.middle_name != '' 
                    THEN CONCAT(SUBSTRING(p.middle_name, 1, 1), '.')
                    ELSE ''
                    END, 
                    '') 
                ) AS fullname,
            p.profile_id, 
            p.sex
            FROM sections s
            LEFT JOIN enrollment_history eh ON eh.section_id = s.id
            LEFT JOIN profiles p ON eh.user_id = p.profile_id
            WHERE s.adviser_id = :adviser_id
            ");
        $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
        $stmt->execute();
        $advisoryClass = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Include the view and pass the data


        // Query to get unenrolled students
        $stmt = $this->db->prepare("
            SELECT 
                COALESCE(p.lrn, 'No Data') AS lrn, 
                CONCAT(
                    COALESCE(p.last_name, ''), ', ',
                    COALESCE(p.first_name, ''), ' ',
                    COALESCE(
                        CASE
                        WHEN p.middle_name IS NOT NULL AND p.middle_name != '' 
                        THEN CONCAT(SUBSTRING(p.middle_name, 1, 1), '.')
                        ELSE ''
                        END, 
                        '') 
                    ) AS fullname,
                u.user_id, 
                p.sex as gender
            FROM users u
            LEFT JOIN profiles p ON u.user_id = p.profile_id
            LEFT JOIN enrollment_history eh ON eh.user_id = u.user_id AND eh.academic_year_id = :acads
            WHERE u.role_id = 3 AND eh.user_id IS NULL
        ");
        $stmt->bindValue(':acads', $this->acadsyear, PDO::PARAM_INT);
        $stmt->execute();
        $unenrolledStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);

     


    } catch (Exception $e) {
        echo $e->getMessage();
        return;
    }
    include 'views/adviser/advisoryClass.php';
}
public function enroll() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['students']) && isset($_SESSION['section_id'])) {
            $studentIds = $_POST['students']; 
            $sectionId = (int) $_SESSION['section_id']; 
            // Fetch section data to ensure the adviser is correct
            $stmt = $this->db->prepare("SELECT adviser_id FROM sections WHERE id = :section_id");
            $stmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
            $stmt->execute();
            $sectionData = $stmt->fetch(PDO::FETCH_ASSOC);
            // Fetch campus information (assuming this holds academic year info)
            $stmt = $this->db->prepare("SELECT * FROM campus_info WHERE id = 6");
            $stmt->execute();
            $CampusInfoData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $present_school_year = (int) $CampusInfoData[0]['function'];
            // Fetch grade level for the section
            $stmt = $this->db->prepare("SELECT id, level FROM grade_level WHERE FIND_IN_SET(:section_id, section_ids)");
            $stmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
            $stmt->execute();
            $gradeLevelData = $stmt->fetch(PDO::FETCH_ASSOC);
            $gradeLevelId = $gradeLevelData['id'];
            // Ensure the adviser is allowed to enroll students in the selected section
            if ($sectionData && $sectionData['adviser_id'] == $_SESSION['user_id']) {
                // Loop through all selected students to check if they are already enrolled
                foreach ($studentIds as $studentId) {
                    // Check if the student is already enrolled for this section and academic year
                    $checkEnrollmentStmt = $this->db->prepare("
                        SELECT COUNT(*) 
                        FROM enrollment_history 
                        WHERE user_id = :student_id 
                        AND grade_level_id = :grade_level_id 
                        AND section_id = :section_id 
                        AND academic_year_id = :academic_year_id
                        ");
                    $checkEnrollmentStmt->bindValue(':student_id', (int) $studentId, PDO::PARAM_INT);
                    $checkEnrollmentStmt->bindValue(':grade_level_id', $gradeLevelId, PDO::PARAM_INT);
                    $checkEnrollmentStmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
                    $checkEnrollmentStmt->bindValue(':academic_year_id', $present_school_year, PDO::PARAM_INT);
                    $checkEnrollmentStmt->execute();
                    $enrollmentExists = $checkEnrollmentStmt->fetchColumn();
                    if ($enrollmentExists > 0) {
                        // If the student is already enrolled, skip this student
                        echo "Student with ID $studentId is already enrolled in this section for the current academic year. Skipping enrollment.";
                        continue;
                    }
                    // If the student is not enrolled, proceed with enrollment
                    $stmt = $this->db->prepare("
                        INSERT INTO enrollment_history (user_id, grade_level_id, section_id, adviser_id, academic_year_id, enrollment_date)
                        VALUES (:student_id, :grade_level_id, :section_id, :adviser_id, :academic_year_id, :enrollment_date)
                        ");
                    $stmt->bindValue(':student_id', (int) $studentId, PDO::PARAM_INT);
                    $stmt->bindValue(':grade_level_id', $gradeLevelId, PDO::PARAM_INT);
                    $stmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
                    $stmt->bindValue(':adviser_id', $_SESSION['user_id'], PDO::PARAM_INT);
                    $stmt->bindValue(':academic_year_id', $present_school_year, PDO::PARAM_INT);
                    $stmt->bindValue(':enrollment_date', date('Y-m-d'), PDO::PARAM_STR);
                    $stmt->execute();
                }
                // Redirect to advisers page after enrollment
                header("Location: /BlissES/myclass-list");
                exit();
            } else {
                echo "Error: You do not have permission to enroll students in this section.";
            }
        } else {
            echo "Error: No students selected or invalid section.";
        }
    }
}
public function update() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id']) && isset($_POST['section_id'])) {
        $studentId = (int) $_POST['student_id'];
        $sectionId = (int) $_POST['section_id'];
        $stmt = $this->db->prepare("
            UPDATE enrollment_history 
            SET section_id = :section_id 
            WHERE user_id = :student_id
            ");
        $stmt->bindValue(':student_id', $studentId, PDO::PARAM_INT);
        $stmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header("Location: /BlissES/advisers");
            exit();
        } else {
            echo "Error: Could not update enrollment.";
        }
    }
}
public function unenroll() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
        // Fetch campus information (assuming id = 6 is specific to present school year)
        $stmt = $this->db->prepare("SELECT function FROM campus_info WHERE id = 6");
        $stmt->execute();
        $campusInfoData = $stmt->fetch(PDO::FETCH_ASSOC);
        // Ensure valid data was retrieved
        if (!$campusInfoData) {
            echo "Error: Unable to fetch campus information.";
            return;
        }
        // Extract present school year
        $presentSchoolYear = (int) $campusInfoData['function'];
        // Get current section ID and adviser ID from the session
        $sectionId = isset($_SESSION['section_id']) ? (int) $_SESSION['section_id'] : 0;
        $adviserId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;
        // Validate section ID and adviser ID
        if ($sectionId === 0 || $adviserId === 0) {
            echo "Error: Missing section or adviser information.";
            return;
        }
        // Fetch grade level based on section ID
        $stmt = $this->db->prepare("SELECT id, level FROM grade_level WHERE FIND_IN_SET(:section_id, section_ids)");
        $stmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
        $stmt->execute();
        $gradeLevelData = $stmt->fetch(PDO::FETCH_ASSOC);
        // Ensure valid grade level data was retrieved
        if (!$gradeLevelData) {
            echo "Error: Unable to fetch grade level data.";
            return;
        }
        $gradeLevelId = (int) $gradeLevelData['id'];
        // Unenroll the student by deleting their enrollment history
        $studentId = (int) $_POST['student_id'];
        $stmt = $this->db->prepare("
            DELETE FROM enrollment_history 
            WHERE user_id = :student_id 
            AND section_id = :section_id 
            AND grade_level_id = :grade_level_id 
            AND academic_year_id = :present_school_year
            AND adviser_id = :adviser_id
            ");
        $stmt->bindValue(':student_id', $studentId, PDO::PARAM_INT);
        $stmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
        $stmt->bindValue(':grade_level_id', $gradeLevelId, PDO::PARAM_INT);
        $stmt->bindValue(':present_school_year', $presentSchoolYear, PDO::PARAM_INT);
        $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header("Location: /BlissES/myclass-list");
            exit();
        } else {
         echo "Error: Unable to unenroll the student.";
     }
 } else {
    echo "Invalid request.";
}
}
public function showschoolform1() {
    // Get the adviser's user_id
    $adviserId = $_SESSION['user_id'];
    try {
        $result = $this->getAdviserSectionAndGrade($adviserId);
        $_SESSION['section_id'] = $result['section_id'];
    // Fetch the advisory class information
        $stmt = $this->db->prepare("
            SELECT 
            p.lrn,
            CONCAT(p.last_name, ', ', p.first_name, ' ', COALESCE(p.middle_name, '')) AS full_name,
            p.sex,
            DATE_FORMAT(p.birth_date, '%m/%d/%Y') AS birth_date,
            TIMESTAMPDIFF(YEAR, p.birth_date, '2024-10-31') - 
            (DATE_FORMAT(p.birth_date, '%m-%d') > '10-31') AS age,
            COALESCE(p.mother_tongue, 'Not Specified') AS mother_tongue,
            COALESCE(p.ip_ethnic_group, 'Not Specified') AS ethnic_group,
            COALESCE(p.religion, 'Not Specified') AS religion,
            COALESCE(p.fathers_name, 'Not Specified') AS fathers_name,
            COALESCE(p.mother_name, 'Not Specified') AS mother_name,
            COALESCE(p.guardian_name, 'Not Specified') AS guardian_name,
            COALESCE(p.contact_number, 'Not Specified') AS contact_number,
            COALESCE(p.house_street_sitio_purok, 'Not Specified') AS house_street_sitio_purok,
            COALESCE(p.barangay, 'Not Specified') AS barangay,
            COALESCE(p.municipality_city, 'Not Specified') AS municipality_city,
            COALESCE(p.province, 'Not Specified') AS province,
            COALESCE(p.relationship, 'Not Specified') AS relationship
            FROM 
            sections s
            LEFT JOIN 
            enrollment_history eh ON eh.section_id = s.id
            LEFT JOIN 
            profiles p ON eh.user_id = p.profile_id
            WHERE 
            s.adviser_id = :adviser_id;
            ");
        $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
        $stmt->execute();
        $advisoryClass = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo $e->getMessage();
        return;
    }
    // Include the view and pass the data
    include 'views/adviser/schoolform1.php';
}
public function showAttendance(){
    $adviserId = $_SESSION['user_id'];
    // Get today's date for comparison
    date_default_timezone_set('Asia/Manila');
    $todayDate = date('Y-m-d');
    $sectionCheckStmt = $this->db->prepare("
        SELECT id FROM sections WHERE adviser_id = :adviser_id
        ");
    $sectionCheckStmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
    $sectionCheckStmt->execute();
    $assignedSection = $sectionCheckStmt->fetch(PDO::FETCH_ASSOC);
    // If no section is assigned, show an error
    if (!$assignedSection) {
        echo "Error: You are not assigned to a section. Please contact the admin.";
        return;
    }
    // Query to fetch students from the sections the adviser is assigned to
    $stmt = $this->db->prepare(" 
        SELECT 
        eh.id as ehID,
        p.profile_id,
        COALESCE(p.lrn, 'No Data') AS lrn, 
        CONCAT(
            COALESCE(p.last_name, ''), ', ', 
            COALESCE(p.first_name, ''), ' ',
            COALESCE(
                CASE 
                WHEN p.middle_name IS NOT NULL AND p.middle_name != '' 
                THEN CONCAT(SUBSTRING(p.middle_name, 1, 1), '.')
                ELSE '' 
                END, '') 
            ) AS fullname
        FROM sections s
        LEFT JOIN enrollment_history eh ON eh.section_id = s.id
        LEFT JOIN profiles p ON eh.user_id = p.profile_id
        WHERE s.adviser_id = :adviser_id
        Order by p.sex ASC, p.last_name ASC;
     
        ");
    $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
    $stmt->execute();
    $advisoryClass = $stmt->fetchAll(PDO::FETCH_ASSOC);




    // Initialize an array to hold attendance data for the view
    $attendanceData = [];
    // Now check the attendance and remarks for each student for today's date
    foreach ($advisoryClass as $student) {
        $profileId = $student['profile_id'];
        // Check if attendance record exists for the student for today
        $attendanceStmt = $this->db->prepare(" 
            SELECT id, status, remarks FROM attendance_records 
            WHERE user_id = :profile_id AND date = :today_date
            ");
        $attendanceStmt->bindValue(':profile_id', $profileId, PDO::PARAM_INT);
        $attendanceStmt->bindValue(':today_date', $todayDate, PDO::PARAM_STR);
        $attendanceStmt->execute();
        // If attendance record exists, store the attendance data
        if ($attendanceStmt->rowCount() > 0) {
            $attendanceRecord = $attendanceStmt->fetch(PDO::FETCH_ASSOC);
            $student['attendanceChecked'] = true;
            $student['status'] = $attendanceRecord['status']; // Store the status for later use in the view
            $student['remarks'] = $attendanceRecord['remarks']; // Store the remarks for later use in the view
        } else {
            $student['attendanceChecked'] = false;
            $student['status'] = null; // No attendance record yet
            $student['remarks'] = ''; // No remarks yet
        }
        // Add the updated student data to the attendanceData array
        $attendanceData[] = $student;
    }
    // Pass the data to the view
    include 'views/adviser/schoolform2.php';
}
public function submitAttendance() {
    // Get the data from the AJAX request
    $profileId = $_POST['profile_id'];
    $status = $_POST['status'];
    $eID = $_POST['eid'];
    // Get today's date for comparison
    date_default_timezone_set('Asia/Manila');
    $todayDate = date('Y-m-d');
    // Check if the attendance record already exists for the current user and today's date
    $stmt = $this->db->prepare("
        SELECT id FROM attendance_records 
        WHERE user_id = :profile_id AND date = :today_date AND eh_id = :eid
        ");
    $stmt->bindValue(':profile_id', $profileId, PDO::PARAM_INT);
    $stmt->bindValue(':today_date', $todayDate, PDO::PARAM_STR);
    $stmt->bindValue(':eid', $eID, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        // Record exists, so update it
        $stmt = $this->db->prepare("
            UPDATE attendance_records
            SET status = :status, eh_id = :eid, date = NOW()
            WHERE user_id = :profile_id AND date = :today_date
            ");
        // Bind parameters for update
        $stmt->bindValue(':profile_id', $profileId, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':today_date', $todayDate, PDO::PARAM_STR);
        $stmt->bindValue(':eid', $eID, PDO::PARAM_INT);
    } else {
        // Record does not exist, insert a new record
        $stmt = $this->db->prepare("
            INSERT INTO attendance_records (user_id, status, date, eh_id)
            VALUES (:profile_id, :status, NOW(), :eid)
            ");
        // Bind parameters for insert
        $stmt->bindValue(':profile_id', $profileId, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':eid', $eID, PDO::PARAM_INT);
    }
    $stmt->execute();
    // Send response back (optional)
    echo json_encode(['success' => true]);
}
public function updateRemark() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $profileId = $_POST['profile_id'];
        $remarks = $_POST['remarks'];
        $ehId = $_POST['eid'];
            // Get today's date for comparison
        date_default_timezone_set('Asia/Manila');
        $todayDate = date('Y-m-d');
        // Prepare the query to update the remarks
        $stmt = $this->db->prepare("
            UPDATE attendance_records
            SET remarks = :remarks 
            WHERE user_id = :profile_id AND date = :today_date AND eh_id = :eid
            ");
        $stmt->bindParam(':remarks', $remarks, PDO::PARAM_STR);
        $stmt->bindValue(':today_date', $todayDate, PDO::PARAM_STR);
        $stmt->bindParam(':profile_id', $profileId, PDO::PARAM_INT);
        $stmt->bindParam(':eid', $ehId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo 'Remark updated successfully';
        } else {
            echo 'Error updating remark';
        }
    }
}
public function showClassRecord() {
    $adviserId = $_SESSION['user_id'];
    try {
        // Get section and grade level info
        $result = $this->getAdviserSectionAndGrade($adviserId);
        $_SESSION['section_id'] = $result['section_id'];



    $stmt = $this->db->prepare("SELECT function FROM campus_info WHERE id = 8");
    $stmt->execute();
    $campusInfoData = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentGrading = (int)$campusInfoData['function'];
   

        // Fetch advisory class information
        $stmt = $this->db->prepare("
            SELECT 
            s.id AS section_id, 
            s.section_name, 
            s.daytime, 
            COALESCE(p.lrn, 'No Data') AS lrn, 
            CONCAT(
                COALESCE(p.last_name, ''), ', ',
                COALESCE(p.first_name, ''), ' ',
                COALESCE(
                    CASE
                    WHEN p.middle_name IS NOT NULL AND p.middle_name != '' 
                    THEN CONCAT(SUBSTRING(p.middle_name, 1, 1), '.')
                    ELSE ''
                    END, 
                    '') 
                ) AS fullname,
            p.profile_id, 
            p.sex,
            eh.id AS eh_id 
            FROM 
            sections s
            LEFT JOIN 
            enrollment_history eh ON eh.section_id = s.id
            LEFT JOIN 
            profiles p ON eh.user_id = p.profile_id
            WHERE 
            s.adviser_id = :adviser_id
            Order by p.last_name ASC
        ");
        $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
        $stmt->execute();
        $advisoryClass = $stmt->fetchAll(PDO::FETCH_ASSOC);



        // Fetch all subjects in the grade level
        $stmt = $this->db->prepare("
            SELECT 
            s.id AS subject_id,
            s.name AS subject_name
            FROM 
            subjects s
            WHERE 
            FIND_IN_SET(s.id, (
                SELECT 
                gl.subject_ids
                FROM 
                grade_level gl
                WHERE 
                gl.id = :grade_level
            )) > 0
        ");
        $stmt->bindValue(':grade_level', $result['grade_level_id'], PDO::PARAM_INT);
        $stmt->execute();
        $allSubjectInGrade = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Sanitize and check if arrays are empty before querying grades
        $studentIds = array_column($advisoryClass, 'profile_id');
        $subjectIds = array_column($allSubjectInGrade, 'subject_id');
        
        if (empty($studentIds) || empty($subjectIds)) {
            throw new Exception('No students or subjects found');
        }

// Fetch grades for students
$gradesStmt = $this->db->prepare("
    SELECT 
        gr.user_id, 
        gr.subject_id, 
        gr.grade 
    FROM 
        grade_records gr
    WHERE 
        gr.user_id IN (" . implode(',', array_map('intval', $studentIds)) . ")
        AND gr.subject_id IN (" . implode(',', array_map('intval', $subjectIds)) . ")
        AND gr.grading_id = :grading_id
");
$gradesStmt->bindValue(':grading_id', $currentGrading, PDO::PARAM_INT); 
$gradesStmt->execute();
$grades = $gradesStmt->fetchAll(PDO::FETCH_ASSOC);






        // Transform grades into an associative array for easier lookup
        $gradeMap = [];
        foreach ($grades as $grade) {
            $gradeMap[$grade['user_id']][$grade['subject_id']] = $grade['grade'];
        }

    } catch (Exception $e) {
        echo $e->getMessage();
        return;
    }




    // Include the view for the class record
    include 'views/adviser/class-record.php';
}



public function addOrUpdateClassRecord() {

    $stmt = $this->db->prepare("SELECT function FROM campus_info WHERE id = 8");
    $stmt->execute();
    $campusInfoData = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentGrading = (int)$campusInfoData['function'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate the input data
        $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : null;
        $subjectId = isset($_POST['subject_id']) ? (int)$_POST['subject_id'] : null;
        $grade = isset($_POST['grade']) ? $_POST['grade'] : null;
        $ehId = isset($_POST['eh_id']) ? (int)$_POST['eh_id'] : null;

        if ($userId && $subjectId && $grade !== null && $ehId) {
            try {

                // Check if the record exists
                $stmt = $this->db->prepare("SELECT id FROM grade_records WHERE user_id = :user_id AND eh_id = :eh_id AND subject_id = :subject_id AND grading_id = :grading_id");
                $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
                $stmt->bindValue(':eh_id', $ehId, PDO::PARAM_INT);
                $stmt->bindValue(':subject_id', $subjectId, PDO::PARAM_INT);
                $stmt->bindValue(':grading_id', $currentGrading, PDO::PARAM_INT);
                $stmt->execute();
                $existingGrade = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($existingGrade) {
                    // Update the existing record
                    $updateStmt = $this->db->prepare("UPDATE grade_records SET grade = :grade WHERE id = :id");
                    $updateStmt->bindValue(':grade', $grade, PDO::PARAM_STR);
                    $updateStmt->bindValue(':id', $existingGrade['id'], PDO::PARAM_INT);
                    $updateStmt->execute();
                } else {
                    // Insert a new grade record
                    $insertStmt = $this->db->prepare("INSERT INTO grade_records (user_id, eh_id, subject_id, grade, grading_id) VALUES (:user_id, :eh_id, :subject_id, :grade, :grading_id)");
                    $insertStmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
                    $insertStmt->bindValue(':eh_id', $ehId, PDO::PARAM_INT);
                    $insertStmt->bindValue(':subject_id', $subjectId, PDO::PARAM_INT);
                    $insertStmt->bindValue(':grade', $grade, PDO::PARAM_STR);
                    $insertStmt->bindValue(':grading_id', $currentGrading, PDO::PARAM_INT);
                    $insertStmt->execute();
                }

                // Return a success response
                echo 'Grade updated successfully';
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        } else {
            echo 'Invalid data received';
        }
    }
}





}