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
        
            $gradeMap = [];
            foreach ($grades as $grade) {
    
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
    $month = $record['month']; 
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
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
        $userId = (int) $_SESSION['user_id'];

        // Fetch user profile information
        $stmt = $this->db->prepare("SELECT photo_path, lrn FROM profiles WHERE profile_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$profile) {
            echo json_encode(['success' => false, 'message' => 'User profile not found.']);
            return;
        }

        $lrn = $profile['lrn'];

        // Check for file upload errors
        if ($_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['profile_pic']['tmp_name'];
            $fileName = $_FILES['profile_pic']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Allowed file extensions
            $allowedExtensions = ['jpg', 'jpeg', 'png'];

            if (in_array($fileExtension, $allowedExtensions)) {
                $uploadDir = 'assets/img/profile/';
                $newFileName = $lrn . '.' . $fileExtension;
                $destPath = $uploadDir . $newFileName;

                // Resize the image
                $resizedImage = $this->resizeImage($fileTmpPath, 128, 128, $fileExtension);

                if ($resizedImage) {
                    if (imagejpeg($resizedImage, $destPath, 90)) {
                        // Update the database with the new file path
                        $stmt = $this->db->prepare("UPDATE profiles SET photo_path = :photo_path WHERE profile_id = :user_id");
                        $stmt->bindParam(':photo_path', $destPath);
                        $stmt->bindParam(':user_id', $userId);

                        if ($stmt->execute()) {
                            echo json_encode(['success' => true, 'newPhotoPath' => $destPath]);
                            return;
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Error updating profile photo in the database.']);
                            return;
                        }
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error saving the resized image.']);
                        return;
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error resizing the image.']);
                    return;
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid file type. Please upload a .jpg, .jpeg, or .png file.']);
                return;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error uploading the file. Error code: ' . $_FILES['profile_pic']['error']]);
            return;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No file uploaded or wrong request method.']);
        return;
    }
}


private function resizeImage($fileTmpPath, $width, $height, $extension) {
    
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

    
    list($origWidth, $origHeight) = getimagesize($fileTmpPath);

    
    $resizedImage = imagecreatetruecolor($width, $height);

    
    imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $width, $height, $origWidth, $origHeight);

    
    return $resizedImage;
}



public function updateuserpass() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $studentId = (int) $_SESSION['user_id']; 
        $username = $_POST['username'];
        $password = $_POST['passwd'];

        if (!empty($password)) {
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            
            $stmt = $this->db->prepare("
                UPDATE users 
                SET 
                username = :username,
                password = :password
                WHERE user_id = :student_id
                ");
            $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        } else {
            
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
            header("Location: /BlissES/learners-profile");
            exit();
        } else {
            echo "Error: Could not update user credentials.";
        }
    }
}





public function myAttendance() {
    
    $myID = (int) $_SESSION['user_id'];

    try {
        
        $stmt = $this->db->prepare("
            SELECT
            ar.eh_id, 
            ar.date,
            ar.status,
            ar.remarks,
            gl.level,
            s.section_name,
            concat(ay.start,'-',ay.end) as sy
            FROM attendance_records ar
            LEFT JOIN
            enrollment_history eh ON ar.eh_id = eh.id
            LEFT JOIN
            grade_level gl ON eh.grade_level_id = gl.id
            LEFT JOIN
            sections s ON eh.section_id = s.id
            LEFT JOIN
            academic_year ay ON eh.academic_year_id = ay.id
            WHERE ar.user_id = :myID
            Order by ar.date DESC
        ");
        
        $stmt->bindValue(':myID', $myID, PDO::PARAM_INT);
        $stmt->execute();
        $myAttendance = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return;
    }

    


    
    include 'views/student/myAttendance.php';
}

public function enrollmentHistory(){


        $myID = (int) $_SESSION['user_id'];

    try {
        
        $stmt = $this->db->prepare("
            SELECT
            gl.level,
            s.section_name,
            eh.enrollment_date as date,
            CONCAT(COALESCE(p.last_name, ''), ', ',COALESCE(p.first_name, ''), ' ',COALESCE(
            CASE
            WHEN p.middle_name IS NOT NULL AND p.middle_name != '' 
            THEN CONCAT(SUBSTRING(p.middle_name, 1, 1), '.')
            ELSE ''
            END, '') ) AS adviser,
            concat(ay.start,'-',ay.end) as sy

            FROM enrollment_history eh
       
            LEFT JOIN
            grade_level gl ON eh.grade_level_id = gl.id
            LEFT JOIN
            sections s ON eh.section_id = s.id
            LEFT JOIN
            academic_year ay ON eh.academic_year_id = ay.id
            LEFT JOIN
            profiles p ON p.profile_id = eh.adviser_id
            WHERE eh.user_id = :myID
            
        ");
        
        $stmt->bindValue(':myID', $myID, PDO::PARAM_INT);
        $stmt->execute();
        $myEHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return;
    }

    

    
    
   include 'views/student/myEnrollmentHistory.php';
}


public function academicHistory(){


 $user_id = (int) $_SESSION['user_id']; // Current logged-in user

try {

    $stmt = $this->db->prepare("
    SELECT 
        s.name AS subject_name,
        MAX(CASE WHEN gr.grading_id = 1 THEN gr.grade ELSE '' END) AS first_grading,
        MAX(CASE WHEN gr.grading_id = 2 THEN gr.grade ELSE '' END) AS second_grading,
        MAX(CASE WHEN gr.grading_id = 3 THEN gr.grade ELSE '' END) AS third_grading,
        MAX(CASE WHEN gr.grading_id = 4 THEN gr.grade ELSE '' END) AS fourth_grading,
        CASE 
            WHEN COUNT(CASE WHEN gr.grading_id IN (1, 2, 3, 4) THEN gr.grade ELSE NULL END) = 4 THEN 
                ROUND(AVG(CASE WHEN gr.grading_id IN (1, 2, 3, 4) THEN gr.grade END), 2)
            ELSE ''
        END AS general_average,
        CASE 
            WHEN COUNT(CASE WHEN gr.grading_id IN (1, 2, 3, 4) THEN gr.grade ELSE NULL END) = 4 AND 
                 ROUND(AVG(CASE WHEN gr.grading_id IN (1, 2, 3, 4) THEN gr.grade END), 2) >= 75 THEN 'Passed'
            WHEN COUNT(CASE WHEN gr.grading_id IN (1, 2, 3, 4) THEN gr.grade ELSE NULL END) = 4 THEN 'Failed'
            ELSE ''
        END AS status
    FROM 
        subjects s
    LEFT JOIN 
        grade_records gr ON s.id = gr.subject_id AND gr.user_id = :user_id
    GROUP BY 
        s.id;
    ");

    // Bind parameters
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // Execute and fetch results
    $stmt->execute();
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);



} catch (Exception $e) {
    echo $e->getMessage();
    return;
}

   include 'views/student/myAcademicHistory.php';
}


public function storage()
{
    $myID = (int)$_SESSION['user_id'];
    $stmt = $this->db->prepare("
        SELECT
            p.lrn
        FROM 
            profiles p
        LEFT JOIN 
            users u ON u.user_id = p.profile_id
        WHERE 
            u.user_id = :myID;
    ");
    $stmt->bindValue(':myID', $myID, PDO::PARAM_INT);
    $stmt->execute();
    $myLRN = $stmt->fetch(PDO::FETCH_ASSOC)['lrn'];
    $uploadDir = "assets/documents/" . $myLRN . "/";

    // Scan files if directory exists
    $files = [];
    if (is_dir($uploadDir)) {
        $files = array_diff(scandir($uploadDir), array('.', '..'));
    }

    // Pass files to the view
    include 'views/student/myStorage.php';
}



public function uploadDocs(){
// Ensure the target directory exists
function createDirectory($path) {
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$myID = (int) $_SESSION['user_id'];
 $stmt = $this->db->prepare("
                SELECT
                p.lrn
                FROM 
                profiles p
                LEFT JOIN 
                users u ON u.user_id = p.profile_id
                WHERE 
                u.user_id = :myID;
                ");
            $stmt->bindValue(':myID', $myID, PDO::PARAM_INT);
            $stmt->execute();
            $myLRN = $stmt->fetch(PDO::FETCH_ASSOC)['lrn'];
    $uploadDir = "assets/documents/" . $myLRN . "/";
    // Ensure upload directory exists
    createDirectory($uploadDir);
    // Handle uploaded file
    if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['document']['tmp_name'];
        $fileName = basename($_FILES['document']['name']);
        $fileDestination = $uploadDir . $fileName;
        // Move uploaded file
        if (move_uploaded_file($fileTmpPath, $fileDestination)) {
             $_SESSION['success'] = "File Uploaded Successfully";
            header("Location: /BlissES/learners-storage");
            exit();
        } else {
            $_SESSION['error'] = "Error: Failed to move uploaded file.";
        }
    } else {
        $_SESSION['error'] = "Error: No file uploaded or there was an upload error.";
    }
}



}





public function deleteFile(){
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['file'])) {
    $myID = (int) $_SESSION['user_id'];
 $stmt = $this->db->prepare("
                SELECT
                p.lrn
                FROM 
                profiles p
                LEFT JOIN 
                users u ON u.user_id = p.profile_id
                WHERE 
                u.user_id = :myID;
                ");
            $stmt->bindValue(':myID', $myID, PDO::PARAM_INT);
            $stmt->execute();
            $myLRN = $stmt->fetch(PDO::FETCH_ASSOC)['lrn'];
            
    $file = basename($_POST['file']); // Ensure no directory traversal
    $uploadDir = "assets/documents/" . $myLRN . "/";
    $filePath = $uploadDir . $file;

    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            $_SESSION['success'] = "File deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete the file.";
        }
    } else {
        $_SESSION['error'] = "File does not exist.";
    }
}
        header("Location: /BlissES/learners-storage");
exit();
    
}



















} 
