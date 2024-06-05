<?php
include_once ("conection_database.php");

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $id = $_POST["id"];
    $image = $_POST["image"];
    $sql = "DELETE FROM tbl_users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id'=>$id]);
    unlink(UPLOADDIR."/".$image);
    $success = "true";
    header( 'Location: /?success='.$success);
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
                $image =  $row['image'];
                $image_path =  UPLOADDIR ."/".$image;
                $email = $row['email'];
                $phone = $row['phone'];
                echo "
            <tr class='align-middle'>
                <th scope='row'>$id</th>
                <td>
                    <img src='$image_path'
                         width='100'
                         alt='$name'>
                </td>
                <td>$name</td>
                <td>$phone</td>
                <td>$email</td>
                <td>
                <form  method = 'POST'>
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
