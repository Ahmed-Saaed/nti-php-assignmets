<!-- create c from crud -->

<?php 
require '../user/dbConnection.php';
require '../user/helpers.php';
include '../user/checkLogin.php';




    
    $errors = [];
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $title = clean($_REQUEST['title']);
        $email = clean($_REQUEST['email']);
        $password = clean($_REQUEST['password']);

    

    
        
    
      if(!validate($title , 1)){
        $errors['title'] = 'you have to enter your title';
      }


      
      if(!validate($email , 1)){
        $errors['email'] = 'please enter the email';
      }elseif(!validate($email ,2)){
        $errors['email'] = 'your email must be at least 30 char';
      }

      if(!validate($password , 1)){
        $errors['password'] = 'please enter your password';
      }elseif(!validate($password ,3 , 6)){
        $errors['password'] = 'enter a valied password';
      }


      $hpassword = md5($password);
    
    
        if (count($errors) > 0){
          foreach($errors as $error => $value){
            echo '<div class="alert alert-danger" role="alert">'.$error.' : '.$value.'</div>';
          }
        }else{
          $sql = "insert into users(title , email , password , image) values ('$title','$email','$hpassword','$desPath')";
          $op = mysqli_query($conn,$sql);
              if($op){
                echo '|| data inserted';
              }else{
                echo 'Error try again'.mysqli_error($conn);
              }
        }
      }
?> 



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
  <div class="container">
      <h2>Register</h2>

      <form action="<?php $_SERVER['PHP_SELF'];?>" method= "POST"  enctype="multipart/form-data">  
          <div class="form-group">
            <label for="exampleInputName">title</label>
            <input type="text" name= "title" class="form-control" id="exampleInputtitle" aria-describedby="" placeholder="Enter your title" >
          </div>

          <div class="form-group">
            <label for="email">email</label>
            <input type="textarea" name= "email"  class="form-control" id="email" aria-describedby="" placeholder="enter your email" >
          </div>

          <div class="form-group">
          <label for="password">password</label>
          <input type="password" name= "password"   class="form-control" id="password" aria-describedby="" placeholder="enter your password" >
        </div>


          <button type="submit" class="btn btn-primary my-3">Submit</button>

    </form>
  </div>
</body>
</html>