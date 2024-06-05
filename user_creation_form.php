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
    $name =  $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sql = 'INSERT INTO tbl_users (name, email, phone, image) VALUES (:name, :email, :phone, :image)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'image' => $fileName]);
    header('Location: /');
    exit();
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel ="stylesheet" href="css/bootstrap.min.css">
    <link rel ="stylesheet" href="css/user_creation_form.css">
    <title>Новий користувач</title>
</head>
<body>
<div class="container w-50 mt-5">
    <h1> Новий користувач</h1>
    <form class="mt-5 p-4 border border-1 d-flex flex-column rounded-3 gap-3 main-form"  method = "POST" enctype="multipart/form-data">
        <div >
            <label for="name" class="form-label">Ім'я та прізвище</label>
            <input type="text" class="form-control" id="name" name = "name" required>
        </div>
        <div>
            <label for="email" class="form-label">Електронна пошта</label>
            <input type="email" class="form-control" id="email" name = "email" required>
        </div>
        <div>
            <label for="phone" class="form-label">Телефон</label>
            <input type="text" class="form-control" id="phone" name = "phone" required>
        </div>
        < <div class="mt-4">
            <div class="row d-flex align-items-center">
                <div class="col-md-3">
                    <label for="image" class="form-label">
                        <img src="/images/no-photo.png" alt="фото" width="100%">
                    </label>
                </div>
                <div class="mb-3 col-md-9">
                    <input type="file" class="form-control" id="image" name="image"  required>
                </div>
            </div>
        </div>
        <div class="d-flex gap-3 mt-3 form-buttons">
            <a class='btn btn-outline-dark w-50' href="index.php">Повернутися</a>
            <button class='btn btn-success w-50 ' name='create' type = 'submit'>Створити</button>
        </div>
    </form>
</div>
</body>
</html>