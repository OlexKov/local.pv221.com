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
    <form class="mt-5 p-4 border border-1 d-flex flex-column rounded-3 gap-3 main-form" action = "index.php" method = "POST" enctype="multipart/form-data">
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
        <div>
            <label for="image" class="form-label">Фото</label>
            <input type="file" class="form-control" id="i" name = "image" required>
        </div>
        <div class="d-flex gap-3 mt-3 form-buttons">
            <a class='btn btn-outline-dark w-50' href="index.php">Повернутися</a>
            <button class='btn btn-success w-50 ' name='create' type = 'submit'>Створити</button>
        </div>
    </form>
</div>
</body>
</html>