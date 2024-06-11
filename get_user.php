<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    include_once $_SERVER["DOCUMENT_ROOT"]."/conection_database.php";
    $id = $_POST["id"];
    try {
        $sql = 'SELECT * FROM tbl_users WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchObject();
        if ($result) {
            echo json_encode($result);
        }
        else
            throw new Exception('No data found');
    } catch (PDOException $e)  {
        echo "Error: " . $e->getMessage();
    }
}
