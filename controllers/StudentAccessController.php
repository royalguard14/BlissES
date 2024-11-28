<?php 
require_once 'BaseController.php'; 

class StudentAccessController extends BaseController { 
    public function __construct($db) { 
        parent::__construct($db, ['11']);  
    } 


    public function showProfile()
    {
        $myID = (int) $_SESSION['user_id'];
        try {
            $stmt = $this->db->prepare("
                SELECT
                COALESCE(gl.level, 'Not Enrolled') AS grade,
                COALESCE(s.section_name, 'Not Enrolled') AS section,
                u.email,
                u.username,
                p.lrn,
                p.sex,
                p.photo_path,
                COALESCE(p.first_name, 'No Data') AS first_name,
                COALESCE(p.last_name, 'No Data') AS last_name,
                COALESCE(p.middle_name, 'No Data') AS middle_name,
                DATE_FORMAT(p.birth_date, '%m/%d/%Y') AS birth_date,
                TIMESTAMPDIFF(YEAR, p.birth_date, '2024-10-31') - 
                (DATE_FORMAT(p.birth_date, '%m-%d') > '10-31') AS age,
                COALESCE(p.mother_tongue, '') AS mother_tongue,
                COALESCE(p.ip_ethnic_group, '') AS ethnic_group,
                COALESCE(p.religion, '') AS religion,
                COALESCE(p.fathers_name, '') AS fathers_name,
                COALESCE(p.mother_name, '') AS mother_name,
                COALESCE(p.guardian_name, '') AS guardian_name,
                COALESCE(p.contact_number, '') AS contact_number,
                COALESCE(p.house_street_sitio_purok, '') AS house_street_sitio_purok,
                COALESCE(p.barangay, '') AS barangay,
                COALESCE(p.municipality_city, '') AS municipality_city,
                COALESCE(p.province, '') AS province,
                COALESCE(p.relationship, '') AS relationship
                FROM 
                profiles p
                LEFT JOIN 
                users u ON u.user_id = p.profile_id
                LEFT join
                enrollment_history eh ON eh.user_id = u.user_id 
                LEFT JOIN
                grade_level gl ON  eh.grade_level_id = gl.id 
                LEFT JOIN 
                sections s ON eh.section_id = s.id
                WHERE 
                u.user_id = :myID;
                ");
            $stmt->bindValue(':myID', $myID, PDO::PARAM_INT);
            $stmt->execute();
            $myInfo = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = $this->db->prepare("SELECT function FROM campus_info WHERE id = 6");
            $stmt->execute();
            $CampusInfoData = $stmt->fetch(PDO::FETCH_ASSOC);
            $present_school_year = (int) $CampusInfoData['function'];
            $stmt = $this->db->prepare("
                SELECT * 
                FROM enrollment_history 
                WHERE user_id = :user_id 
                AND academic_year_id = :academic_year_id
                ");
            $stmt->bindValue(':user_id', $myID, PDO::PARAM_INT);
            $stmt->bindValue(':academic_year_id', $present_school_year, PDO::PARAM_INT);
            $stmt->execute();
            $myenrollment_history = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$myenrollment_history) {
                throw new Exception('You are not enrolled for the current academic year.');
            }
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
            $stmt->bindValue(':grade_level', $myenrollment_history['grade_level_id'], PDO::PARAM_INT);
            $stmt->execute();
            $allSubjectInGrade = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $subjectIds = array_column($allSubjectInGrade, 'subject_id');
            if (empty($subjectIds)) {
                throw new Exception('No subjects found!!');
            }
        // Fetch grades for the logged-in student
            $gradesStmt = $this->db->prepare("
                SELECT 
                gr.user_id, 
                gr.subject_id, 
                gr.grade,
                gr.grading_id
                FROM 
                grade_records gr
                WHERE 
                gr.user_id = :user_id 
                AND gr.grading_id IN (1, 2, 3, 4)
                AND gr.subject_id IN (" . implode(',', array_map('intval', $subjectIds)) . ")
                ");
            $gradesStmt->bindValue(':user_id', $myID, PDO::PARAM_INT);
            $gradesStmt->execute();
            $grades = $gradesStmt->fetchAll(PDO::FETCH_ASSOC);
        // Transform grades into an associative array for easier lookup
            $gradeMap = [];
            foreach ($grades as $grade) {
    // Group by subject_id first, then by grading_id
                $gradeMap[$grade['subject_id']][$grade['grading_id']] = $grade['grade'];
            }


            $stmt = $this->db->prepare("
                SELECT 
                ar.date, 
                ar.status,
                MONTH(ar.date) AS month,
                YEAR(ar.date) AS year
                FROM 
                attendance_records ar
                LEFT JOIN 
                enrollment_history eh ON ar.user_id = eh.user_id
                WHERE 
                ar.user_id = :user_id
                AND eh.academic_year_id = :academic_year_id
                Order by ar.date DESC
                ");
            $stmt->bindValue(':user_id', $myID, PDO::PARAM_INT);
            $stmt->bindValue(':academic_year_id', $present_school_year, PDO::PARAM_INT);
            $stmt->execute();
            $myAttendance = $stmt->fetchAll(PDO::FETCH_ASSOC);


            $attendanceByMonth = [];

            foreach ($myAttendance as $record) {
    $month = $record['month']; // Extract the month from the record
    $attendanceByMonth[$month][] = [
        'date' => $record['date'],
        'status' => $record['status'],
    ];
}


} catch (Exception $e) {
    echo $e->getMessage();
    return;
}
include 'views/student/myProfile.php';
}




public function uploadprofile() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
        $userId = (int) $_SESSION['user_id']; // Get user ID from session

        // Fetch current profile picture path and LRN from the database
        $stmt = $this->db->prepare("SELECT photo_path, lrn FROM profiles WHERE profile_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$profile) {
            echo "User profile not found.";
            return;
        }

        $lrn = $profile['lrn'];

        // Check if file was uploaded successfully
        if ($_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            // Get file details
            $fileTmpPath = $_FILES['profile_pic']['tmp_name'];
            $fileName = $_FILES['profile_pic']['name'];
            $fileSize = $_FILES['profile_pic']['size'];
            $fileType = $_FILES['profile_pic']['type'];

            // Extract file extension
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Define allowed file extensions
            $allowedExtensions = ['jpg', 'jpeg', 'png'];

            // Validate file extension
            if (in_array($fileExtension, $allowedExtensions)) {
                // Create a new file name based on the LRN
                $uploadDir = 'assets/img/profile/';
                $newFileName = $lrn . '.' . $fileExtension;
                $destPath = $uploadDir . $newFileName;

                // Resize the image
                $resizedImage = $this->resizeImage($fileTmpPath, 128, 128, $fileExtension);

                if ($resizedImage) {
                    // Save the resized image
                    if (imagejpeg($resizedImage, $destPath, 90)) {  // Save as JPEG (quality 90)
                        // Update the database with the new file path
                        $stmt = $this->db->prepare("UPDATE profiles SET photo_path = :photo_path WHERE profile_id = :user_id");
                        $stmt->bindParam(':photo_path', $destPath);
                        $stmt->bindParam(':user_id', $userId);

                        if ($stmt->execute()) {
                                header("Location: /schoolsystem/learners-profile");
            exit();
                        } else {
                            echo "Error updating profile photo in the database.";
                        }
                    } else {
                        echo "Error saving the resized image.";
                    }
                } else {
                    echo "Error resizing the image.";
                }
            } else {
                echo "Invalid file type. Please upload a .jpg, .jpeg, or .png file.";
            }
        } else {
            echo "Error uploading the file. Error code: " . $_FILES['profile_pic']['error'];
        }
    } else {
        echo "No file uploaded or wrong request method.";
    }
}

private function resizeImage($fileTmpPath, $width, $height, $extension) {
    // Create a new image from the uploaded file
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            $image = imagecreatefromjpeg($fileTmpPath);
            break;
        case 'png':
            $image = imagecreatefrompng($fileTmpPath);
            break;
        default:
            return false;
    }

    if ($image === false) {
        return false;
    }

    // Get current dimensions of the image
    list($origWidth, $origHeight) = getimagesize($fileTmpPath);

    // Create a new blank image with the desired size
    $resizedImage = imagecreatetruecolor($width, $height);

    // Resize the image
    imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $width, $height, $origWidth, $origHeight);

    // Return the resized image
    return $resizedImage;
}



public function updateuserpass() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $studentId = (int) $_SESSION['user_id']; // Retrieve the user ID from the session
        $username = $_POST['username'];
        $password = $_POST['passwd'];

        if (!empty($password)) {
            // Hash the password if a new password is provided
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Update both username and password
            $stmt = $this->db->prepare("
                UPDATE users 
                SET 
                username = :username,
                password = :password
                WHERE user_id = :student_id
                ");
            $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        } else {
            // Update only the username
            $stmt = $this->db->prepare("
                UPDATE users 
                SET 
                username = :username
                WHERE user_id = :student_id
                ");
        }

        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':student_id', $studentId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: /schoolsystem/learners-profile");
            exit();
        } else {
            echo "Error: Could not update user credentials.";
        }
    }
}



















public function myAttendance()
{
   include 'views/student/myAttendance.php';
}

public function enrollmentHistory()
{
   include 'views/student/myEnrollmentHistory.php';
}


public function academicHistory()
{
   include 'views/student/myAcademicHistory.php';
}


public function storage()
{
   include 'views/student/myStorage.php';
}


























} 
