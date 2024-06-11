<?php
   include_once $_SERVER["DOCUMENT_ROOT"]."/conection_database.php";
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
    <link rel ="stylesheet" href="css/user_creation_form.css">

</head>
<body>
<main>
<!--    <a href="user_creation_form.php" class="btn btn-success create-button">Додати користувача</a>-->
    <button id="add-user-button" class="btn btn-success create-button shaded-button"> Додати користувача</button>
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
                   <div class='d-flex gap-2 justify-content-center'>
                     <button class='bi-pencil-square btn btn-success shaded-button' style='font-size: 1.2rem;'  data-edit-id = '$id'/>
                     <button class='bi-trash btn btn-danger shaded-button' data-delete-id ='$id' style='font-size: 1.2rem;' /> 
                   </div>
                </td>
            </tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <div class='modal fade ' id='delete-confirmation' tabindex='-1' aria-labelledby='deleteModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='deleteModalLabel'>Видалення користувача</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    Ви впевненні що бажаєте видалити цого користувача?
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary shaded-button' data-bs-dismiss='modal'>Ні</button>
                    <button type='button' id = 'delete-confirm-button' class='btn btn-primary  shaded-button'>Так</button>
                </div>
            </div>
        </div>
    </div>

    <div class='modal fade modal-lg' id='create-edit-modal' tabindex='-1'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='deleteModalLabel'>Редагування інформації користувача</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <div class="container w-100 ">
                        <form class="mt-5 p-4 border border-1 d-flex flex-column rounded-3 gap-3 main-form needs-validation" id="user-form" enctype="multipart/form-data" novalidate>
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
                        </form>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' id="cancel-button" class='btn btn-secondary shaded-button' data-bs-dismiss='modal'>Відмінити</button>
                    <button type="submit" form="user-form" id = 'edit-confirm-button' class='btn btn-primary shaded-button'>Зберегти</button>
                </div>
            </div>
        </div>
    </div>


</main>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/axios.min.js"></script>
 <script>
     const headers = {
         'Content-Type': 'multipart/form-data',
     };
      let deleteUserId = 0;
      let editUserId = 0;
      let user = null;
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




      document.addEventListener('DOMContentLoaded',() => {
          function editCreateModalShow(event) {
              editUserId = event.target.getAttribute('data-edit-id');
              createEditModal.show();
          }



          const userForm = document.getElementById('user-form');
          userForm.addEventListener('submit',(event)=>{
              userForm.classList.add('was-validated')
              if (!userForm.checkValidity()) {
                  event.preventDefault()
                  event.stopPropagation()

              }

          })


          // const forms = document.querySelectorAll('.needs-validation')
          // Array.from(forms).forEach(form => {
          //     form.addEventListener('submit', event => {
          //         if (!form.checkValidity()) {
          //             event.preventDefault()
          //             event.stopPropagation()
          //         }
          //         form.classList.add('was-validated')
          //     }, false)
          //
          //
          // })
          // axios.post("/get_user.php", {id:77}, { headers })
          //     .then(resp => {
          //         if(resp.status == 200){
          //             console.log(resp.data)
          //         }
          //
          //
          //     });
          const deleteModalElement = document.getElementById('delete-confirmation');
          const deleteModal = new bootstrap.Modal(deleteModalElement, {backdrop: false, keyboard: true, focus: true});
          const editModalElement = document.getElementById('create-edit-modal');
          const createEditModal = new bootstrap.Modal(editModalElement, {backdrop: false, keyboard: true, focus: true});
          const addUserButton = document.getElementById('add-user-button');
          addUserButton.addEventListener('click',editCreateModalShow);
          const editButtons = document.querySelectorAll('[data-edit-id]')
          editButtons.forEach((button)=>{
              button.addEventListener('click',editCreateModalShow);
          })
          // const editCreteButton = document.getElementById('edit-confirm-button');
          // editCreteButton.addEventListener('click',()=>{
          //
          // })
          const cancelButton = document.getElementById('cancel-button');

          const deleteConfirmButton = document.getElementById('delete-confirm-button');
          deleteConfirmButton.addEventListener('click',() => {
              axios.post("/delete.php", {id:deleteUserId}, { headers })
                  .then(resp => {
                       window.location.reload();
                  });

             // modal.hide();
          });
          const deleteButtons = document.querySelectorAll('[data-delete-id]')
          deleteButtons.forEach((button)=>{
              button.addEventListener('click',(event)=>{
                  deleteUserId = event.target.getAttribute('data-delete-id');
                  deleteModal.show();
              })
          })
      })



 </script>

</body>
</html>
