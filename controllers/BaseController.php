<?php 


// Autoload the composer packages
require 'vendor/autoload.php';
use Faker\Factory as Faker;





function dd($data) {
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
    die();  
}
class BaseController {
    protected $db;
    protected $timeoutDuration = 10;  
    protected $name; 
    protected $roleid;
    protected $title;
    protected $devname;
    protected $system;
    protected $acadsyear;
    protected $faker;




    public function __construct($db, $permissions = []) {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->faker = Faker::create();
        $this->db = $db;
        $this->checkLoginStatus();
        $this->checkSessionTimeout();
        $this->initializeUserDetails();
        $this->websiteDetails();
        if (!empty($permissions)) {
            $this->checkPermissions($permissions);
        }
    }
    



    protected function websiteDetails(){





        $stmt = $this->db->prepare("SELECT function, name FROM campus_info WHERE id IN (9,10,11) ORDER BY FIELD(id, 9,10,11);");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->timeoutDuration = (int) $result[0]['function'];
        $this->title = $result[1]['function'];
        $this->system = $result[2]['function'];















        $stmt = $this->db->prepare("SELECT function FROM campus_info WHERE id = 6");

        $stmt->execute();
        $this->acadsyear = (int) $stmt->fetch(PDO::FETCH_ASSOC)['function'];



    }

    protected function initializeUserDetails() {
        if (isset($_SESSION['user_id'])) {
            $stmt = $this->db->prepare("
                SELECT 
                u.role_id as roleID,
                CONCAT(
                    COALESCE(p.last_name, ''), ', ', 
                    COALESCE(p.first_name, ''), ' ', 
                    COALESCE(
                        CASE 
                        WHEN p.middle_name IS NOT NULL AND p.middle_name != '' 
                        THEN CONCAT(SUBSTRING(p.middle_name, 1, 1), '.')
                        ELSE '' 
                        END, ''
                        )
                    ) AS name
                FROM users u 
                LEFT JOIN 
                profiles p ON p.profile_id = u.user_id
                WHERE u.user_id = :user_id
                ");
            $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->name = $user && !empty($user['name']) ? $user['name'] : "James Reid";
            $this->roleid = $user['roleID'];
        } else {
            throw new Exception("Error: User ID is not set in the session.");
        }
    }
    

    protected function checkLoginStatus() {
        if (!isset($_SESSION['log_in'])) {
            header('Location: /BlissES/login');
            exit();
        }
    }
    

    protected function checkPermissions($permissions) {
        foreach ($permissions as $permission) {
            $this->checkPermission($permission);
        }
    }
    

    protected function checkPermission($permissionId) {
        $roleId = $_SESSION['role_id'];
        $stmt = $this->db->prepare("SELECT permission_id FROM roles WHERE role_id = :role_id");
        $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
        $stmt->execute();
        $role = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($role) {
            $permissions = explode(',', $role['permission_id']);
            if (!in_array($permissionId, $permissions)) {
                header('Location: /BlissES/unauthorized');
                exit();
            }
        } else {
            header('Location: /BlissES/unauthorized');
            exit();
        }
    }

    public function errors() {
        include 'views/error.php';
    }
    

    protected function checkSessionTimeout() {
        if (isset($_SESSION['last_activity'])) {
            $elapsedTime = time() - $_SESSION['last_activity'];
            if ($elapsedTime > $this->timeoutDuration) {
                session_unset();
                session_destroy();
                header('Location: /BlissES/login');
                exit();
            }
        }
        $_SESSION['last_activity'] = time();
    }
    

    protected function getAdviserSectionAndGrade($adviserId) {
        $stmt = $this->db->prepare("
            SELECT 
            s.id AS section_id,
            gl.id AS grade_level_id
            FROM 
            sections s
            INNER JOIN 
            grade_level gl 
            ON 
            FIND_IN_SET(s.id, gl.section_ids)
            WHERE 
            s.adviser_id = :adviser_id
            ");
        $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result || !$result['section_id']) {
            throw new Exception("Error: You are not assigned to a section. Please contact the admin.");
        }
        return $result;
    }
    

    protected function checkEnrollmentStatus($userId, $currentYear) {
        $stmt = $this->db->prepare("
            SELECT * 
            FROM enrollment_history 
            WHERE user_id = :user_id 
            AND academic_year_id = :current_year
            ");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':current_year', $currentYear, PDO::PARAM_STR); 
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
}
?>