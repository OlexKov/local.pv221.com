<?php
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    include_once $_SERVER["DOCUMENT_ROOT"]."/conection_database.php";
    $folderName = $_SERVER['DOCUMENT_ROOT'].'/'. UPLOADDIR;
    if (!file_exists($folderName)) {
        mkdir($folderName, 0777); // Створити папку з правами доступу 0777
    }
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . '.' .$ext;
    $uploadfile = $folderName ."/". $fileName;
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sql = 'INSERT INTO tbl_users (name, email, phone, image) VALUES (:name, :email, :phone, :image)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'image' => $fileName]);
    header('Location: /');
    exit();
}
?>
