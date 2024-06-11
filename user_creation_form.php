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
    <form class="mt-5 p-4 border border-1 d-flex flex-column rounded-3 gap-3 main-form needs-validation"  method = "POST" enctype="multipart/form-data" novalidate>
        <div class="d-flex gap-3" >
            <div class="d-flex flex-column flex-fill w-25">
                <label id="image-label" for="image" class="form-label">
                    <img class="img-thumbnail rounded w-100"  id="photo" src="/images/no-photo.png" alt="фото"  >
                    <button onclick="removeImage()" id="image-remove"  class='btn btn-link' type="button">
                        <i class='bi bi-x-circle-fill' style='font-size: 1.1rem; '></i>
                    </button>
                </label>
                <input style="display: none" type="file" class="form-control" id="image" name="image" onchange="changeImage(this)"  accept="image/png, image/gif, image/jpeg" required>
                <div class="invalid-feedback">
                    Оберіть фото
                </div>
           </div>
            <div class="flex-fill">
                <div >
                    <label for="name" class="form-label">Ім'я та прізвище</label>
                    <input type="text" class="form-control" id="name" name = "name" required>
                    <div class="invalid-feedback">
                        Введіть ім'я та прізвище
                    </div>
                </div>
                <div>
                    <label for="email" class="form-label">Електронна пошта</label>
                    <input type="email" class="form-control" id="email" name = "email" required>
                    <div class="invalid-feedback">
                        Введіть електронну пошту
                    </div>
                </div>
                <div>
                    <label for="phone" class="form-label">Телефон</label>
                    <input type="text" class="form-control" id="phone" name = "phone" required>
                    <div class="invalid-feedback">
                        Введіть тедефон
                    </div>
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

<script type="text/javascript">
     (() => {
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()

    function changeImage(data){
       if (FileReader && data != null && data.files && data.files.length) {
            const fr = new FileReader();
            fr.readAsDataURL(data.files[0]);
            fr.onload = function () {
                document.querySelector("#photo").src= fr.result;
            }
        }
         else
           document.querySelector("#photo").src= '/images/no-photo.png';
    }

    function removeImage(){
        document.getElementById('image').value ='';
        document.querySelector("#photo").src= '/images/no-photo.png';
    }

</script>