<?php 
require_once 'BaseController.php'; 
use PhpOffice\PhpSpreadsheet\IOFactory;
class RegistrarMngtController extends BaseController { 
    public function __construct($db) { 
        parent::__construct($db, ['5','6','10','7']);  
    }
    // Move this function above the methods that use it
    function generateRandomUsername($length = 8) {
        // Define the characters that can be used in the username
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
        // Loop to generate a string of the specified length
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
    public function showTeacherList() {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                COALESCE(u.email, 'No Data') AS email, 
                COALESCE(u.user_id, 'No Data') AS user_id, 
                COALESCE(u.role_id, 'No Data') AS role_id, 
                COALESCE(p.last_name, 'No Data') AS last_name, 
                COALESCE(p.first_name, 'No Data') AS first_name, 
                COALESCE(p.middle_name, 'No Data') AS middle_name, 
                COALESCE(p.sex, 'No Data') AS sex, 
                COALESCE(p.birth_date, 'No Data') AS birth_date, 
                COALESCE(p.mother_tongue, 'No Data') AS mother_tongue, 
                COALESCE(p.ip_ethnic_group, 'No Data') AS ip_ethnic_group, 
                COALESCE(p.religion, 'No Data') AS religion, 
                COALESCE(p.house_street_sitio_purok, 'No Data') AS house_street_sitio_purok, 
                COALESCE(p.barangay, 'No Data') AS barangay, 
                COALESCE(p.municipality_city, 'No Data') AS municipality_city, 
                COALESCE(p.province, 'No Data') AS province,
                COALESCE(p.profile_id, 'No Data') AS profile_id
                FROM users u
                LEFT JOIN profiles p ON u.user_id = p.profile_id
                WHERE u.isDelete = 0 AND u.role_id = 2;
                ");
            $stmt->execute();
            $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            include 'views/registrar/teacher-list.php';
        } catch (Exception $e) {
        // Handle error gracefully
            echo "An error occurred: " . $e->getMessage();
        }
    }
    public function showsStudentList() {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                COALESCE(u.email, 'No Data') AS email, 
                COALESCE(u.user_id, 'No Data') AS user_id, 
                COALESCE(u.role_id, 'No Data') AS role_id, 
                COALESCE(p.lrn, 'No Data') AS lrn, 
                COALESCE(p.last_name, 'No Data') AS last_name, 
                COALESCE(p.first_name, 'No Data') AS first_name, 
                COALESCE(p.middle_name, 'No Data') AS middle_name, 
                COALESCE(p.sex, 'No Data') AS sex, 
                COALESCE(p.birth_date, 'No Data') AS birth_date, 
                COALESCE(p.mother_tongue, 'No Data') AS mother_tongue, 
                COALESCE(p.ip_ethnic_group, 'No Data') AS ip_ethnic_group, 
                COALESCE(p.religion, 'No Data') AS religion, 
                COALESCE(p.house_street_sitio_purok, 'No Data') AS house_street_sitio_purok, 
                COALESCE(p.barangay, 'No Data') AS barangay, 
                COALESCE(p.municipality_city, 'No Data') AS municipality_city, 
                COALESCE(p.province, 'No Data') AS province,
                COALESCE(p.fathers_name, 'No Data') AS fathers_name,
                COALESCE(p.mother_name, 'No Data') AS mother_name,
                COALESCE(p.guardian_name, 'No Data') AS guardian_name,
                COALESCE(p.relationship, 'No Data') AS relationship,
                COALESCE(p.contact_number, 'No Data') AS contact_number,
                COALESCE(p.profile_id, 'No Data') AS profile_id
                FROM users u
                LEFT JOIN profiles p ON u.user_id = p.profile_id
                WHERE u.isDelete = 0 AND u.role_id = 3;
                ");
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
            include 'views/registrar/students-list.php';
        } catch (Exception $e) {
        // Handle error gracefully
            echo "An error occurred: " . $e->getMessage();
        }
    }




  public function addOrUploadTeacher() {
    // Handle POST requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Fetch institutional email extension
        $stmt = $this->db->prepare("SELECT function FROM campus_info WHERE id = 7");
        $stmt->execute();
        $institutional = $stmt->fetch(PDO::FETCH_ASSOC);
        $email_extension = $institutional['function'];
        $role_id = 2; // Teacher role

        // Check if it's an Excel upload or single teacher addition
        if (isset($_FILES['teacher_excel'])) {
            // Handle Excel file upload
            $file = $_FILES['teacher_excel']['tmp_name'];
            try {
                $spreadsheet = IOFactory::load($file);
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray();

                foreach ($rows as $index => $row) {
                    if ($index === 0) continue; // Skip header row
                    
                    // Extract data from each row (Excel upload)
                    $firstName = trim($row[0]);
                    $lastName = trim($row[1]);
                    $middleName = trim($row[2]);
                    $sex = trim($row[3]);
                    $birthDate = trim($row[4]);
                    $motherTongue = trim($row[5]) ?: null;
                    $ip = trim($row[6]) ?: null;
                    $religion = trim($row[7]) ?: null;
                    $house = trim($row[8]) ?: null;
                    $brgy = trim($row[9]) ?: null;
                    $city = trim($row[10]) ?: null;
                    $province = trim($row[11]) ?: null;

                    $username = $this->generateRandomUsername(8);
                    $email = strtolower($firstName . '.' . $lastName . $email_extension);
                    $password = 'password';
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                    // Skip rows with missing required fields
                    if (empty($firstName) || empty($lastName)) continue;

                    // Ensure email is unique
                    $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->execute();
                    if ($stmt->fetchColumn() > 0) continue;

                    // Insert into users and profiles tables
                    $this->insertUserAndProfile(
                        $email, 
                        $username, 
                        $hashed_password, 
                        $lastName, 
                        $firstName, 
                        $middleName, 
                        $birthDate, 
                        $sex, 
                        $motherTongue, 
                        $ip, 
                        $religion, 
                        $house, 
                        $brgy, 
                        $city, 
                        $province, 
                        $role_id
                    );
                }

                header("Location: /schoolsystem/teacher-list");
                exit;
            } catch (Exception $e) {
                echo "Error processing Excel file: " . $e->getMessage();
            }
        } else {
            // Handle single teacher addition (manual)
            try {
                $lastName = $_POST['last_name'];
                $firstName = $_POST['first_name'];
                $middleName = $_POST['middle_name'];
                $birthDate = $_POST['birth_date'];
                $sex = $_POST['sex'];
                $username = $this->generateRandomUsername(8);
                $email = strtolower($firstName . '.' . $lastName . $email_extension);
                $password = 'password';
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Insert into users and profiles tables with missing optional fields as null
                $this->insertUserAndProfile(
                    $email, 
                    $username, 
                    $hashed_password, 
                    $lastName, 
                    $firstName, 
                    $middleName, 
                    $birthDate, 
                    $sex, 
                    null,   // motherTongue
                    null,   // ip
                    null,   // religion
                    null,   // house
                    null,   // brgy
                    null,   // city
                    null,   // province
                    $role_id
                );

                header("Location: /schoolsystem/teacher-list");
                exit;
            } catch (Exception $e) {
                echo "Error adding teacher: " . $e->getMessage();
            }
        }
    }
}











public function addOrUploadStudent() {
    // Handle POST requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Fetch institutional email extension
        $stmt = $this->db->prepare("SELECT function FROM campus_info WHERE id = 7");
        $stmt->execute();
        $institutional = $stmt->fetch(PDO::FETCH_ASSOC);
        $email_extension = $institutional['function'];
        $role_id = 3;

        // Check if it's an Excel upload or single student addition
        if (isset($_FILES['student_excel'])) {
            // Handle Excel file upload
            $file = $_FILES['student_excel']['tmp_name'];

            // Debug: Check for file upload errors
            if ($_FILES['student_excel']['error'] !== UPLOAD_ERR_OK) {
                echo "File upload error: " . $_FILES['student_excel']['error'];
                return;
            }

            try {
                $spreadsheet = IOFactory::load($file);
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray();

                foreach ($rows as $index => $row) {
                    if ($index === 0) continue; // Skip header row

                    // Extract data from each row
                    $lrn = trim($row[0]);
                    
                    // Split "Last Name, First Name, Middle Name"
                    $name = explode(',', $row[1]);
                    $lastName = isset($name[0]) ? trim($name[0]) : '';
                    $firstName = isset($name[1]) ? trim($name[1]) : '';
                    $middleName = isset($name[2]) ? trim($name[2]) : '';

                    // Ensure the name is properly split
                    if (empty($lastName) || empty($firstName)) continue; // Skip if name fields are missing

                    $sex = trim($row[2]);
                    $birthDate = trim($row[3]);
                    $motherTongue = trim($row[4]);
                    $religion = trim($row[5]);
                    $house = trim($row[6]);
                    $brgy = trim($row[7]);
                    $city = trim($row[8]);
                    $province = trim($row[9]);
                    $fathers_name = trim($row[10]);
                    $mothers_name = trim($row[11]);

                    // Handle default values if fields are empty
                    $house = empty($house) ? null : $house;
                    $brgy = empty($brgy) ? null : $brgy;
                    $city = empty($city) ? null : $city;
                    $province = empty($province) ? null : $province;

                   

                    // Validate required fields
                    if (empty($firstName) || empty($lastName)) continue; // Skip if name is missing

                    // Generate email (ensure it's unique)
                    $email = strtolower($firstName . '.' . $lastName . $email_extension);
                    $username = $this->generateRandomUsername(8);
                    $password = 'password';
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                    // Ensure email is unique
                    $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->execute();
                    if ($stmt->fetchColumn() > 0) continue; // Skip if email already exists

                    $this->insertUserAndProfile(
                        $email, 
                        $username, 
                        $hashed_password, 
                        $lastName, 
                        $firstName, 
                        $middleName, 
                        $birthDate, 
                        $sex, 
                        $motherTongue, 
                        null,  
                        $religion, 
                        $house, 
                        $brgy, 
                        $city, 
                        $province, 
                        $role_id,
                        $lrn, 
                        $fathers_name, 
                        $mothers_name
                    );
      
                }

                header("Location: /schoolsystem/student-list"); 
                exit;
            } catch (Exception $e) {
                echo "Error processing Excel file: " . $e->getMessage();
            }
        } else {
            // Handle single student addition (manual)
        }
    }
}






// Reusable method to insert into users and profiles tables
private function insertUserAndProfile($email, $username, $hashed_password, $lastName, $firstName, $middleName, $birthDate, $sex, $motherTongue = null, $ip = null, $religion = null, $house = null, $brgy = null, $city = null, $province = null,$role_id,$lrn=null, $fathers_name = null,  $mother_name = null) {
    try {

        $stmt = $this->db->prepare("
            INSERT INTO users (email, password, username, role_id, isDelete) 
            VALUES (:email, :password, :username, :role_id, 0)
            ");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
        $stmt->execute();
        $userId = $this->db->lastInsertId();
        // Insert into profiles table
        $stmt = $this->db->prepare("
            INSERT INTO profiles (
                profile_id, last_name, first_name, middle_name, birth_date, sex, 
                mother_tongue, ip_ethnic_group, religion, house_street_sitio_purok, barangay, municipality_city, province, lrn, mother_name,fathers_name 
                ) VALUES (
                :profile_id, :last_name, :first_name, :middle_name, :birth_date, :sex, 
                :mother_tongue, :ip_address, :religion, :house, :brgy, :city, :province, :lrn, :fathers_name, :mother_name
                )
                ");
        $stmt->bindParam(':profile_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':middle_name', $middleName, PDO::PARAM_STR);
        $stmt->bindParam(':birth_date', $birthDate, PDO::PARAM_STR);
        $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
        $stmt->bindParam(':mother_tongue', $motherTongue, PDO::PARAM_STR);
        $stmt->bindParam(':ip_address', $ip, PDO::PARAM_STR);
        $stmt->bindParam(':religion', $religion, PDO::PARAM_STR);
        $stmt->bindParam(':house', $house, PDO::PARAM_STR);
        $stmt->bindParam(':brgy', $brgy, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':province', $province, PDO::PARAM_STR);
        $stmt->bindParam(':lrn', $lrn, PDO::PARAM_STR);
        $stmt->bindParam(':fathers_name', $fathers_name, PDO::PARAM_STR);
        $stmt->bindParam(':mother_name', $mother_name, PDO::PARAM_STR);
        $stmt->execute();
    } catch (Exception $e) {
        throw $e;
    }
}
public function updateTeacher() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
        $teacher_id = (int) $_POST['user_id'];
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $middle_name = trim($_POST['middle_name']);
        $email = trim($_POST['email']);
        $sex = $_POST['sex'];
        $birth_date = $_POST['birth_date'];
        $mother_tongue = trim($_POST['mother_tongue']);
        $ethnic_group = trim($_POST['ip_ethnic_group']);
        $religion = trim($_POST['religion']);
        $house_street_sitio = trim($_POST['house_street_sitio_purok']);
        $barangay = trim($_POST['barangay']);
        $municipality_city = trim($_POST['municipality_city']);
        $province = trim($_POST['province']);
        // Validation (Optional): Ensure that email is unique and not already in use
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = :email AND user_id != :teacher_id");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt->execute();
        $emailCount = $stmt->fetchColumn();
        if ($emailCount > 0) {
            echo "Error: This email is already in use.";
            return;
        }
        try {
            // Update users table
            $stmt = $this->db->prepare("UPDATE users SET email = :email WHERE user_id = :teacher_id");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
            $stmt->execute();
            // Update profiles table
            $stmt = $this->db->prepare("UPDATE profiles SET
                first_name = :first_name,
                last_name = :last_name,
                middle_name = :middle_name,
                sex = :sex,
                birth_date = :birth_date,
                mother_tongue = :mother_tongue,
                ip_ethnic_group = :ethnic_group,
                religion = :religion,
                house_street_sitio_purok = :house_street_sitio,
                barangay = :barangay,
                municipality_city = :municipality_city,
                province = :province
                WHERE profile_id = :teacher_id");
            // Bind the parameters to the SQL query
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
            $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
            $stmt->bindParam(':birth_date', $birth_date, PDO::PARAM_STR);
            $stmt->bindParam(':mother_tongue', $mother_tongue, PDO::PARAM_STR);
            $stmt->bindParam(':ethnic_group', $ethnic_group, PDO::PARAM_STR);
            $stmt->bindParam(':religion', $religion, PDO::PARAM_STR);
            $stmt->bindParam(':house_street_sitio', $house_street_sitio, PDO::PARAM_STR);
            $stmt->bindParam(':barangay', $barangay, PDO::PARAM_STR);
            $stmt->bindParam(':municipality_city', $municipality_city, PDO::PARAM_STR);
            $stmt->bindParam(':province', $province, PDO::PARAM_STR);
            $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);  // Profile ID should be teacher_id as per your logic
            // Execute the query
            if ($stmt->execute()) {
                header("Location: /schoolsystem/teacher-list"); // Redirect to teacher list
                exit();
            } else {
                echo "Error: Could not update teacher details.";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
public function updateStudent() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
        $teacher_id = (int) $_POST['user_id'];
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $middle_name = trim($_POST['middle_name']);
        $email = trim($_POST['email']);
        $sex = $_POST['sex'];
        $birth_date = $_POST['birth_date'];
        $mother_tongue = trim($_POST['mother_tongue']);
        $ethnic_group = trim($_POST['ip_ethnic_group']);
        $religion = trim($_POST['religion']);
        $house_street_sitio = trim($_POST['house_street_sitio_purok']);
        $barangay = trim($_POST['barangay']);
        $municipality_city = trim($_POST['municipality_city']);
        $province = trim($_POST['province']);
        $fathers_name = trim($_POST['fathers_name']);
        $mother_name = trim($_POST['mother_name']);
        $guardian_name = trim($_POST['guardian_name']);
        $relationship = trim($_POST['relationship']);
        $contact_number = trim($_POST['contact_number']);
        // Validation (Optional): Ensure that email is unique and not already in use
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = :email AND user_id != :teacher_id");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt->execute();
        $emailCount = $stmt->fetchColumn();
        if ($emailCount > 0) {
            echo "Error: This email is already in use.";
            return;
        }
        try {
            // Update users table
            $stmt = $this->db->prepare("UPDATE users SET email = :email WHERE user_id = :teacher_id");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
            $stmt->execute();
            // Update profiles table
            $stmt = $this->db->prepare("UPDATE profiles SET
                first_name = :first_name,
                last_name = :last_name,
                middle_name = :middle_name,
                sex = :sex,
                birth_date = :birth_date,
                mother_tongue = :mother_tongue,
                ip_ethnic_group = :ethnic_group,
                religion = :religion,
                house_street_sitio_purok = :house_street_sitio,
                barangay = :barangay,
                municipality_city = :municipality_city,
                province = :province,
                fathers_name = :fathers_name,
                mother_name = :mother_name,
                guardian_name = :guardian_name,
                relationship = :relationship,
                contact_number = :contact_number
                WHERE profile_id = :teacher_id");
            // Bind the parameters to the SQL query
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
            $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
            $stmt->bindParam(':birth_date', $birth_date, PDO::PARAM_STR);
            $stmt->bindParam(':mother_tongue', $mother_tongue, PDO::PARAM_STR);
            $stmt->bindParam(':ethnic_group', $ethnic_group, PDO::PARAM_STR);
            $stmt->bindParam(':religion', $religion, PDO::PARAM_STR);
            $stmt->bindParam(':house_street_sitio', $house_street_sitio, PDO::PARAM_STR);
            $stmt->bindParam(':barangay', $barangay, PDO::PARAM_STR);
            $stmt->bindParam(':municipality_city', $municipality_city, PDO::PARAM_STR);
            $stmt->bindParam(':province', $province, PDO::PARAM_STR);
            $stmt->bindParam(':fathers_name', $fathers_name, PDO::PARAM_STR);
            $stmt->bindParam(':mother_name', $mother_name, PDO::PARAM_STR);
            $stmt->bindParam(':guardian_name', $guardian_name, PDO::PARAM_STR);
            $stmt->bindParam(':relationship', $relationship, PDO::PARAM_STR);
            $stmt->bindParam(':contact_number', $contact_number, PDO::PARAM_STR);
            $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT); 
            // Execute the query
            if ($stmt->execute()) {
                header("Location: /schoolsystem/students-list"); // Redirect to teacher list
                exit();
            } else {
                echo "Error: Could not update teacher details.";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
public function updateUser() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
        $user_id = (int) $_POST['user_id'];
        $role = (int) $_POST['role_id']; // Ensure role is an integer
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $middle_name = trim($_POST['middle_name']);
        $email = trim($_POST['email']);
        $sex = $_POST['sex'];
        $birth_date = $_POST['birth_date'];
        $mother_tongue = trim($_POST['mother_tongue']);
        $ethnic_group = trim($_POST['ip_ethnic_group']);
        $religion = trim($_POST['religion']);
        $house_street_sitio = trim($_POST['house_street_sitio_purok']);
        $barangay = trim($_POST['barangay']);
        $municipality_city = trim($_POST['municipality_city']);
        $province = trim($_POST['province']);
        // Student-specific fields
        $fathers_name = isset($_POST['fathers_name']) ? trim($_POST['fathers_name']) : null;
        $mother_name = isset($_POST['mother_name']) ? trim($_POST['mother_name']) : null;
        $guardian_name = isset($_POST['guardian_name']) ? trim($_POST['guardian_name']) : null;
        $relationship = isset($_POST['relationship']) ? trim($_POST['relationship']) : null;
        $contact_number = isset($_POST['contact_number']) ? trim($_POST['contact_number']) : null;
        // Validation: Ensure email is unique
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = :email AND user_id != :user_id");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $emailCount = $stmt->fetchColumn();
        if ($emailCount > 0) {
            echo "Error: This email is already in use.";
            return;
        }
        try {
            // Update `users` table
            $stmt = $this->db->prepare("UPDATE users SET email = :email WHERE user_id = :user_id");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            // Update `profiles` table
            $query = "UPDATE profiles SET 
            first_name = :first_name,
            last_name = :last_name,
            middle_name = :middle_name,
            sex = :sex,
            birth_date = :birth_date,
            mother_tongue = :mother_tongue,
            ip_ethnic_group = :ethnic_group,
            religion = :religion,
            house_street_sitio_purok = :house_street_sitio,
            barangay = :barangay,
            municipality_city = :municipality_city,
            province = :province";
            // Add student-specific fields if the role is 3 (student)
            if ($role == 3) {
                $query .= ",
                fathers_name = :fathers_name,
                mother_name = :mother_name,
                guardian_name = :guardian_name,
                relationship = :relationship,
                contact_number = :contact_number";
            }
            $query .= " WHERE profile_id = :user_id";
            $stmt = $this->db->prepare($query);
            // Bind shared parameters
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
            $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
            $stmt->bindParam(':birth_date', $birth_date, PDO::PARAM_STR);
            $stmt->bindParam(':mother_tongue', $mother_tongue, PDO::PARAM_STR);
            $stmt->bindParam(':ethnic_group', $ethnic_group, PDO::PARAM_STR);
            $stmt->bindParam(':religion', $religion, PDO::PARAM_STR);
            $stmt->bindParam(':house_street_sitio', $house_street_sitio, PDO::PARAM_STR);
            $stmt->bindParam(':barangay', $barangay, PDO::PARAM_STR);
            $stmt->bindParam(':municipality_city', $municipality_city, PDO::PARAM_STR);
            $stmt->bindParam(':province', $province, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            // Bind student-specific parameters
            if ($role === 3) { // Check if role is 'student' (3)
            $stmt->bindParam(':fathers_name', $fathers_name, PDO::PARAM_STR);
            $stmt->bindParam(':mother_name', $mother_name, PDO::PARAM_STR);
            $stmt->bindParam(':guardian_name', $guardian_name, PDO::PARAM_STR);
            $stmt->bindParam(':relationship', $relationship, PDO::PARAM_STR);
            $stmt->bindParam(':contact_number', $contact_number, PDO::PARAM_STR);
        }
            // Execute query
        if ($stmt->execute()) {
            $redirectPath = ($role === 3) ? "/schoolsystem/students-list" : "/schoolsystem/teacher-list";
            header("Location: $redirectPath");
            exit();
        } else {
            echo "Error: Could not update user details.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
}
public function deleteUser() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['paths'])) {
        $user_id = (int) $_POST['user_id'];
        $paths = $_POST['paths'];
        // Validate paths
        $allowedPaths = ['students-list', 'teacher-list'];
        if (!in_array($paths, $allowedPaths)) {
            echo "Invalid path.";
            return;
        }
        // Ensure user_id is valid
        if ($user_id <= 0) {
            echo "Invalid user ID.";
            return;
        }
        // Start a transaction to ensure both delete operations happen together
        try {
            $this->db->beginTransaction();
            // Delete the user's profile
            $stmt = $this->db->prepare("DELETE FROM profiles WHERE profile_id = :user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            if (!$stmt->execute()) {
                throw new Exception("Error: Could not delete profile.");
            }
            // Delete the user from the users table
            $stmt = $this->db->prepare("DELETE FROM users WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            if (!$stmt->execute()) {
                throw new Exception("Error: Could not delete user.");
            }
            // Commit the transaction
            $this->db->commit();
            // Redirect after successful deletion
            header("Location: /schoolsystem/$paths");
            exit();
        } catch (Exception $e) {
            // Rollback in case of an error
            $this->db->rollBack();
            echo $e->getMessage();
        }
    } else {
        echo "Error: Invalid request or missing parameters.";
    }
}
}