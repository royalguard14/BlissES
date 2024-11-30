<?php 
require_once 'BaseController.php'; 
 
class MsgManagementController extends BaseController { 
    public function __construct($db) { 
        parent::__construct($db, ['12']);  
    } 



public function sendMessage() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sender_id = (int) $_POST['sender_id'];
        $receiver_id = (int) $_POST['receiver_id'];
        $content = trim($_POST['content']);

        if (empty($content)) {
            echo json_encode(['status' => 'error', 'message' => 'Message content cannot be empty.']);
            return;
        }

        $stmt = $this->db->prepare("INSERT INTO messages (sender_id, receiver_id, content, is_read, sent_at) VALUES (:sender_id, :receiver_id, :content, 0, NOW())");
        $stmt->bindParam(':sender_id', $sender_id, PDO::PARAM_INT);
        $stmt->bindParam(':receiver_id', $receiver_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Message sent successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send message.']);
        }
    }
}









 
} 
