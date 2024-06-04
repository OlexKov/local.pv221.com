<?php
// Database credentials
$uploaddir = 'images/';
$host = 'localhost';
$dbname = 'local.pv221.com';
$username = 'root';
$password = '';

// Connection string
$dsn = "mysql:host=$host;dbname=$dbname";

// Attempt to connect
try {
    $pdo = new PDO($dsn, $username, $password);
    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if(isset($_POST["delete"]))
{
    $id = $_POST["id"];
    $image = $_POST["image"];
    $sql = "DELETE FROM tbl_users WHERE id = $id";
    $pdo->query($sql);
    $path = parse_url($image, PHP_URL_PATH);
    echo $path ;
    unlink($uploaddir.basename($path));

}else if(isset($_POST["create"]))
{
    $protocol = isset($_SERVER['HTTPS']) &&
    $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $base_url = $protocol . $_SERVER['HTTP_HOST'] . '/';
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $uploadfile = $uploaddir . uniqid() . '.' .$ext;
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
    $name =  $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sql = "INSERT INTO tbl_users (name, image, email,phone) 
            VALUES ('$name','$base_url$uploadfile','$email','$phone')";
    $pdo->query($sql);
}
if(isset($_POST["delete"]) || isset($_POST["create"])){
    $success = "true";
    header( 'Location: http://local.pv221.com/index.php?success='.$success);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Користувачі</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel ="stylesheet" href="css/bootstrap.min.css">
    <link rel ="stylesheet" href="css/index.css">

</head>
<body>
<main>
    <a href="user_creation_form.php" class="btn btn-success create-button">Додати користувача</a>
    <div class="container text-center add-user-button mt-5">
       <h1 >Користувачі</h1>
       <table  class="table p-3 border border-2  table-hover mt-4">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Фото</th>
                <th scope="col">ПІБ</th>
                <th scope="col">Телефон</th>
                <th scope="col">Email</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            function familyName($fname, $year) {
                echo "$fname Refsnes. Born in $year <br>";
            }
            $sql = "SELECT * FROM tbl_users";
            foreach ($pdo->query($sql) as $row) {
                $id = $row['id'];
                $name = $row['name'];
                $image = $row['image'];
                $email = $row['email'];
                $phone = $row['phone'];
                echo "
            <tr class='align-middle'>
                <th scope='row'>$id</th>
                <td>
                    <img src='$image'
                         width='100'
                         alt='$name'>
                </td>
                <td>$name</td>
                <td>$phone</td>
                <td>$email</td>
                <td>
                <form action = 'index.php' method = 'POST'>
                <input name = 'id' type = 'hidden' value = '$id'>
                <input name = 'image' type = 'hidden' value = '$image'>
                  <button class='btn btn-danger' name='delete' type = 'submit'>
                       <i class='bi-trash' style='font-size: 2rem;  '></i>
                  </button>  
                </form>
                
            </tr>
                ";
            }
            ?>
            </tbody>
        </table>
    </div>
</main>
<script src="js/bootstrap.bundle.min.js">
</body>
</html>
