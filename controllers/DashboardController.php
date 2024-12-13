<?php
require_once 'BaseController.php';

class DashboardController extends BaseController {
    public function __construct($db) {
        parent::__construct($db);
    }


public function adviserDashboard() {
    // Get the current grading from campus_info table
    $stmt = $this->db->prepare("SELECT function FROM campus_info WHERE id = 8");
    $stmt->execute();
    $campusInfoData = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentGrading = (int)$campusInfoData['function'];

    $stmt = $this->db->prepare("SELECT * FROM campus_info WHERE id = 6");
    $stmt->execute();
    $CampusInfoData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $present_school_year = (int) $CampusInfoData[0]['function'];

    // Get the adviser ID from the session
    $adviserId = $_SESSION['user_id'];

    // Get the current month
    $currentMonth = date('m'); // This gets the current month (01 to 12)
    
    // Get today's date in YYYY-MM-DD format
    $today = date('Y-m-d'); 

    try {
        // Fetch the adviser's section and related grade information
        $result = $this->getAdviserSectionAndGrade($adviserId);
        $_SESSION['section_id'] = $result['section_id']; // Store the section ID in session for future use

        // Fetch the top 10 students based on average grade in the current grading period
        $stmt = $this->db->prepare("
            SELECT 
                eh.user_id,
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
                COALESCE(p.lrn, 'No Data') AS lrn,
                p.sex,
                AVG(gr.grade) AS average_grade
            FROM grade_records gr
            LEFT JOIN enrollment_history eh ON gr.eh_id = eh.id
            LEFT JOIN profiles p ON eh.user_id = p.profile_id
            WHERE eh.section_id = :section_id AND gr.grading_id = :grading_id AND eh.adviser_id = :adviser_id AND academic_year_id = :academic_year_id
            GROUP BY eh.user_id
            ORDER BY average_grade DESC
            LIMIT 10
        ");
        
        // Bind values for section ID and current grading period
        $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
        $stmt->bindValue(':academic_year_id', $present_school_year, PDO::PARAM_INT);
        $stmt->bindValue(':section_id', $_SESSION['section_id'], PDO::PARAM_INT);
        $stmt->bindValue(':grading_id', $currentGrading, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the top 10 students
        $top10Students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch the top 1 student per subject
        $stmt = $this->db->prepare("
            SELECT 
                gr.subject_id,
                s.name AS subject_name,  -- Add the subject name
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
                COALESCE(p.lrn, 'No Data') AS lrn,
                p.sex,
                gr.grade
            FROM grade_records gr
            LEFT JOIN enrollment_history eh ON gr.eh_id = eh.id
            LEFT JOIN profiles p ON eh.user_id = p.profile_id
            LEFT JOIN subjects s ON gr.subject_id = s.id 
            WHERE gr.grade = (
                SELECT MAX(gr2.grade)
                FROM grade_records gr2
                WHERE gr2.subject_id = gr.subject_id
                AND eh.section_id = :section_id AND adviser_id = :adviser_id AND academic_year_id = :academic_year_id AND grading_id = :grading_id
            )
            ORDER BY gr.subject_id;
        ");
        
        // Bind values for section ID and current grading period
        $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
        $stmt->bindValue(':academic_year_id', $present_school_year, PDO::PARAM_INT);
        $stmt->bindValue(':section_id', $_SESSION['section_id'], PDO::PARAM_INT);
        $stmt->bindValue(':grading_id', $currentGrading, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the top 1 student per subject
        $topStudentsPerSubject = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch students with birthdays this month
        $stmt = $this->db->prepare("
            SELECT 
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
                p.birth_date
            FROM profiles p
            LEFT JOIN
            enrollment_history eh ON eh.user_id = p.profile_id
            WHERE 
            MONTH(p.birth_date) = :current_month
            AND eh.adviser_id = :adviser_id
            ORDER BY p.birth_date DESC
        ");
        
        // Bind the current month value
        $stmt->bindValue(':current_month', $currentMonth, PDO::PARAM_INT);
        $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the students with birthdays this month
        $studentsWithBirthday = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch students' attendance records for today
        $stmt = $this->db->prepare("
            SELECT 
                eh.user_id,
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
                ar.status
            FROM attendance_records ar
            LEFT JOIN enrollment_history eh ON ar.eh_id = eh.id
            LEFT JOIN profiles p ON eh.user_id = p.profile_id
            WHERE eh.section_id = :section_id AND ar.date = :today
        ");

        // Bind the current section ID and today's date
        $stmt->bindValue(':section_id', $_SESSION['section_id'], PDO::PARAM_INT);
        $stmt->bindValue(':today', $today, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the attendance data
        $attendanceData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Separate the attendance data into present and absent lists
        $presentStudents = [];
        $absentStudents = [];
        $tardyStudents = [];
        $exuseStudents = [];
        foreach ($attendanceData as $attendance) {
            if ($attendance['status'] === 'P') {
                $presentStudents[] = $attendance;
            }elseif ($attendance['status'] === 'T') {
               $tardyStudents[] = $attendance;
            }elseif ($attendance['status'] === 'E') {
               $exuseStudents[] = $attendance;
            } else {
                $absentStudents[] = $attendance;
            }
        }

        // Fetch the total number of male and female students enrolled in the section
        $stmt = $this->db->prepare("
            SELECT sex, COUNT(*) as count
            FROM profiles p
            LEFT JOIN enrollment_history eh ON p.profile_id = eh.user_id
            WHERE eh.section_id = :section_id
            GROUP BY sex
        ");
        $stmt->bindValue(':section_id', $_SESSION['section_id'], PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the count of male and female students
        $genderCounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $maleCount = 0;
        $femaleCount = 0;
        foreach ($genderCounts as $gender) {
            if ($gender['sex'] === 'M') {
                $maleCount = $gender['count'];
            } elseif ($gender['sex'] === 'F') {
                $femaleCount = $gender['count'];
            }
        }



    } catch (Exception $e) {
        // If there's any error, output the error message
        echo $e->getMessage();
        return;
    }

    // Include the dashboard view to display the data
    include 'views/dashboard/adviser_dashboard.php';
}



   
    private function studentDashboard() {
      
        include 'views/dashboard/student_dashboard.php';
    }

private function registrarDashboard() {
    $stmt = $this->db->prepare("
        SELECT 
            SUM(CASE WHEN u.role_id = 3 AND p.sex = 'M' THEN 1 ELSE 0 END) AS totalMale,
            SUM(CASE WHEN u.role_id = 3 AND p.sex = 'F' THEN 1 ELSE 0 END) AS totalFemale,
            SUM(CASE WHEN u.role_id = 2 THEN 1 ELSE 0 END) AS totalTeachers,
            SUM(CASE WHEN u.role_id = 6 THEN 1 ELSE 0 END) AS totalParents
        FROM users u
        LEFT JOIN profiles p ON u.user_id = p.profile_id
    ");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $totalMale = $result['totalMale'];
    $totalFemale = $result['totalFemale'];
    $totalTeachers = $result['totalTeachers'];
    $totalParents = $result['totalParents'];



    $stmt = $this->db->prepare("
 SELECT 
    gl.level,
    s.section_name AS section_name,
    s.adviser_id,
    CONCAT(p.first_name, ' ', p.last_name) AS adviser_name,
    SUM(CASE WHEN pr.sex = 'M' THEN 1 ELSE 0 END) AS total_male,
    SUM(CASE WHEN pr.sex = 'F' THEN 1 ELSE 0 END) AS total_female
FROM 
    grade_level gl
LEFT JOIN sections s ON FIND_IN_SET(s.id, gl.section_ids)
LEFT JOIN profiles p ON s.adviser_id = p.profile_id
LEFT JOIN enrollment_history eh ON eh.section_id = s.id
LEFT JOIN profiles pr ON eh.user_id = pr.profile_id
GROUP BY 
    gl.id, s.id
ORDER BY 
    gl.id, s.section_name;

");
$stmt->execute();
$registrarSummary = $stmt->fetchAll(PDO::FETCH_ASSOC);



#piegraph


    include 'views/dashboard/registrar_dashboard.php';
}



  private function parentDashboard() {
    $user_id = $_SESSION['user_id'];

    // Fetch role and assigned permissions
    $stmt = $this->db->prepare("SELECT children FROM parent_children WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $childrem = $stmt->fetch(PDO::FETCH_ASSOC);

    // Ensure children field is not empty before processing
    if (!empty($childrem['children'])) {
        // Split the comma-separated list of child IDs into an array
        $assigned_children = explode(',', $childrem['children']);

        // Clean up the array: remove any empty values, ensure numeric values
        $assigned_children = array_filter($assigned_children, 'is_numeric');
        $assigned_children = array_map('intval', $assigned_children);

        // If there are no valid children, exit early
        if (empty($assigned_children)) {
            // Handle no children assigned case (e.g., show message or return)
            dd('No assigned children for this user.');
            return;
        }

        // Convert array to a comma-separated string
        $placeholders = implode(',', array_fill(0, count($assigned_children), '?'));

        // Fetch all children (permissions) with role_id = 3
        $stmt = $this->db->prepare("SELECT
            u.user_id as id, 
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
            ) AS fullname
            FROM profiles p
            LEFT JOIN users u ON p.profile_id = u.user_id
            WHERE u.user_id IN ($placeholders)
            ORDER BY p.last_name ASC
        ");

        // Bind the values to the prepared statement (values for IN clause)
        $stmt->execute($assigned_children);

        $childrens = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    } else {
        // Handle the case where there are no assigned children
        dd('No children assigned to this parent.');
    }

    // Include the parent dashboard view
    include 'views/dashboard/parent_dashboard.php';
}




public function attendancegrade() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['child_id'])) {
        $child_id = $_POST['child_id'];

        // Fetch attendance records for the given child
        $stmt = $this->db->prepare("SELECT
                ar.id,
                ar.user_id,
                ar.date,
                ar.status,
                ar.remarks,
                ar.eh_id,
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
                ) AS name
            FROM attendance_records ar
            LEFT JOIN profiles p ON ar.user_id = p.profile_id
            WHERE ar.user_id = :child_id
            ORDER BY ar.date DESC");
        $stmt->bindParam(':child_id', $child_id, PDO::PARAM_INT);
        $stmt->execute();

        $attendance_records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get the child's grade level
        $stmt = $this->db->prepare("SELECT grade_level_id FROM enrollment_history WHERE id = :eh_id");
        $stmt->bindValue(':eh_id', $attendance_records[0]['eh_id'], PDO::PARAM_INT);
        $stmt->execute();
        $childgradeLevel = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get subjects for the child's grade level
        $stmt = $this->db->prepare("SELECT s.id AS subject_id, s.name AS subject_name FROM subjects s
            WHERE FIND_IN_SET(s.id, (
                SELECT gl.subject_ids FROM grade_level gl WHERE gl.id = :grade_level
            )) > 0");
        $stmt->bindValue(':grade_level', $childgradeLevel['grade_level_id'], PDO::PARAM_INT);
        $stmt->execute();
        $allSubjectInGrade = $stmt->fetchAll(PDO::FETCH_ASSOC);



        // Ensure that allSubjectInGrade is available
        if (empty($allSubjectInGrade)) {
            echo json_encode(['success' => false, 'message' => 'No subjects found for the child.']);
            return;
        }

        $subjectIds = array_column($allSubjectInGrade, 'subject_id');

        // Get grades for the subjects
        $gradesStmt = $this->db->prepare("SELECT gr.user_id, gr.subject_id, gr.grade, gr.grading_id
            FROM grade_records gr
            WHERE gr.user_id = :user_id AND gr.grading_id IN (1, 2, 3, 4)
            AND gr.subject_id IN (" . implode(',', array_map('intval', $subjectIds)) . ")");
        $gradesStmt->bindValue(':user_id', $child_id, PDO::PARAM_INT);
        $gradesStmt->execute();
        $grades = $gradesStmt->fetchAll(PDO::FETCH_ASSOC);

        // Organize grades by subject
        $gradeMap = [];
        foreach ($grades as $grade) {
            $gradeMap[$grade['subject_id']][$grade['grading_id']] = $grade['grade'];
        }




        // Return the results as JSON with both attendance records and subjects (grades)
        echo json_encode([
            'success' => true,
            'attendance_records' => $attendance_records,
            'grades' => $gradeMap,
            'subjects' => $allSubjectInGrade // Ensure subjects are included in the response
        ]);

// dd([
//     'success' => true,
//     'attendance_records' => $attendance_records,
//     'grades' => $gradeMap,
//     'subjects' => $allSubjectInGrade // Ensure subjects are included in the response
// ]);


    } else {
        echo json_encode(['success' => false]);
    }
}















    private function defaultDashboard() {
      
        include 'views/dashboard/default_dashboard.php';
    }








    public function showDashboard() {
        $userRole = $_SESSION['role_id'];

        switch ($userRole) {
            case 2: // Faculty
            $this->adviserDashboard();
            break;
            case 3: //Learners
                header("Location: learners-profile");
                exit();
            break;
            case 4: //Registrar
            $this->registrarDashboard();
            break;
                        case 6: //Parents
            $this->parentDashboard();
            break;
            default://admin
            $this->defaultDashboard();
            break;
        }
    }










}
?>
