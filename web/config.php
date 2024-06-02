<?php

$conn = new mysqli("localhost", "root", "", "ar-web") or die("Couldn't connect");

/*class UserLogs {

    private $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function create(
        string $page,
        string $action,
        int $user_id,
        int $student_id
    ){
        $logQuery = "INSERT INTO tbl_logs (page, action, user_id, student_id) VALUES (?,?,?,?)";
        $user = $this->conn->execute_query($logQuery, [$page, $action, $user_id, $student_id]);
    }
}
*/
?>