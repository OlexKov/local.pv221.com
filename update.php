<?php
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    include_once $_SERVER["DOCUMENT_ROOT"]."/conection_database.php";
    $folderName = $_SERVER['DOCUMENT_ROOT'].'/'. UPLOADDIR;
try {

    $oldImage = $_POST['oldImage'];

    if($_FILES["image"]["tmp_name"]!=''){
        $filePath = $folderName . "/" .$oldImage;
        if (file_exists($filePath)) {
           unlink($filePath);
        }
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $oldImage = uniqid() . '.' .$ext;
        $uploadfile = $folderName ."/". $oldImage;
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
    }

    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "UPDATE tbl_users SET name=:name, image=:image, email=:email, phone=:phone WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'image' => $oldImage, 'id' => $id]);
} catch (PDOException $e)  {
    echo "Error: " . $e->getMessage();
}
    //header('Location: /');
    exit();
}
?>
