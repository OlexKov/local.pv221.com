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
                                        <input style="display: none" name="oldImage" id="oldImage"/>
                                        <input style="display: none" name="id" id="id"/>
                                        <img class="img-thumbnail rounded w-100"  id="photo" src="/images/no-photo.png" alt="фото"  >
                                        <button id="image-remove"  class='btn btn-link' type="button">
                                            <i class='bi bi-x-circle-fill' style='font-size: 1.1rem; '></i>
                                        </button>
                                    </label>
                                    <input style="display: none" type="file" class="form-control" id="image" name="image"   accept="image/png, image/gif, image/jpeg">
                                    <div class="invalid-feedback">
                                        Оберіть фото
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-3 flex-fill">
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
                    <button type='button' id="cancel-button" class='btn btn-secondary shaded-button'>Відмінити зміни</button>
                    <button type="button" form="user-form" id = 'edit-confirm-button' class='btn btn-primary shaded-button'>Зберегти</button>
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

      function setFormValues(user){
          document.querySelector("#id").value = user ? user.id:'';
          document.querySelector("#name").value = user ? user.name:'';
          document.querySelector("#email").value = user ? user.email:'';
          document.querySelector("#phone").value = user ? user.phone:'';
          document.querySelector("#photo").src= user ? ('images/'+user.image):'/images/no-photo.png';
          document.querySelector("#oldImage").value= user ? user.image : '';
          document.querySelector("#image").value = '';
      }

      document.addEventListener('DOMContentLoaded',() => {
          function editCreateModalShow(event) {
              editUserId = event.target.getAttribute('data-edit-id');
              const modalTitle = editModalElement.querySelector('.modal-title')
              if(event.target.id === 'add-user-button'){
                  user = null;
                  modalTitle.textContent='Новий користувач';
                  setFormValues();
              }
              else{
                  modalTitle.textContent='Редагування інформації користувача';
                  axios.post("/get_user.php", {id:editUserId}, { headers })
                      .then(resp => {
                          if(resp.status === 200){
                              user = resp.data;
                              setFormValues(user);
                          }
                      });
              }
              setImageValid(true);
              userForm.classList.remove('was-validated')
              createEditModal.show();
          }

          function imageValidator(){
              const imageValid =  ((document.querySelector("#photo").src !== 'http://local.pv221.com/images/no-photo.png') || userImage.value );
              setImageValid(imageValid);
              return  imageValid;
          }

          function setImageValid(isValid){
              if(isValid){
                  userImage.classList.remove("is-invalid")
                  userImage.classList.add("is-valid")
              }else{
                  userImage.classList.remove("is-valid")
                  userImage.classList.add("is-invalid")
              }
          }

          const confirmModalElement = document.getElementById('delete-confirmation');
          const confirmModal = new bootstrap.Modal(confirmModalElement, {backdrop: false, keyboard: true, focus: true});
          const editModalElement = document.getElementById('create-edit-modal');
          const createEditModal = new bootstrap.Modal(editModalElement, {backdrop: false, keyboard: true, focus: true});

          const addUserButton = document.getElementById('add-user-button');
          addUserButton.addEventListener('click',editCreateModalShow);

          const editButtons = document.querySelectorAll('[data-edit-id]')
          editButtons.forEach((button)=>{
              button.addEventListener('click',editCreateModalShow);
          })

          const deleteImageButton = document.getElementById('image-remove');
          deleteImageButton.addEventListener('click',()=>{
              document.getElementById('image').value ='';
              document.querySelector("#photo").src= '/images/no-photo.png';
          })

          const userImage = document.getElementById('image');
          userImage.addEventListener('change',(event)=>{
               if (FileReader && event.target != null && event.target.files && event.target.files.length) {
                  const fr = new FileReader();
                  fr.readAsDataURL(event.target.files[0]);
                  fr.onload = function () {
                      document.querySelector("#photo").src= fr.result;
                  }
                  setImageValid(true);
              }
              else
                  document.querySelector("#photo").src= '/images/no-photo.png';
          })

          const userForm = document.getElementById('user-form');
          const editCreteButton = document.getElementById('edit-confirm-button');
          editCreteButton.addEventListener('click',()=>{
              userForm.classList.add('was-validated')
              if (imageValidator() && userForm.checkValidity() ) {
                  const formData = new FormData(userForm);
                  if(user){
                      axios.post('/update.php',formData,{headers})
                          .then(res=>{
                              console.log(res)
                              if(res.status===200){
                                  window.location.reload();
                              }
                          })
                   user = null;
                  }else{
                      axios.post('/create.php',formData,{headers})
                          .then(res=>{
                              if(res.status===200){
                                  window.location.reload();
                              }
                          })
                  }
              }
          });

          const cancelButton = document.getElementById('cancel-button');
          cancelButton.addEventListener('click',()=>{
              setFormValues(user);
              console.log(user)
              console.log(document.getElementById("name").value)
          })

          const deleteConfirmButton = document.getElementById('delete-confirm-button');
          deleteConfirmButton.addEventListener('click',() => {
              axios.post("/delete.php", {id:deleteUserId}, { headers })
                  .then(resp => {
                       window.location.reload();
                  });
          });

          const deleteButtons = document.querySelectorAll('[data-delete-id]')
          deleteButtons.forEach((button)=>{
              button.addEventListener('click',(event)=>{
                  deleteUserId = event.target.getAttribute('data-delete-id');
                  confirmModal.show();
              })
          })
      })

 </script>
</body>
</html>
