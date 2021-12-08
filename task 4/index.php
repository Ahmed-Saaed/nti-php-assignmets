<?php 

session_start();

  include 'helper.php';
$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = clean($_REQUEST['name']);
    $email = clean($_REQUEST['email']);
    $password = $_REQUEST['password'];
    $address = clean($_REQUEST['address']);
    $linkedin = $_REQUEST['linkedin'];

    

    if(empty($name) || !filter_var($name,FILTER_SANITIZE_STRING)){
      $errors['name'] = 'required field ';
    }
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
      $errors['email'] = ' enter valid email ';
    }
    if(strlen($password) < 6){
      $errors['password'] = 'enter password atleast 6 characters';
    }
    if(strlen($address) < 10){
      $errors['address'] = 'adress has to be exactly 10 char';
    }
    if(empty($linkedin) || !filter_var($linkedin,FILTER_VALIDATE_URL)){
      $errors['linkedin'] = 'enter valid url';
    }

    if(!empty($_FILES['image']['name'])){
          $tmpPath = $_FILES['image']['tmp_name'];
          $imageName = $_FILES['image']['name'];
          $imageSize = $_FILES['image']['size'];
          $imageType = $_FILES['image']['type'];
          
          $ex = explode('.',$imageName);
          $extension = end($ex);
          $fileName = rand().time().'.'.$extension;

          $allowedEx = ['jpg' , 'png'];

          
          if(in_array($extension,$allowedEx)){
            $desPath = 'upload/'.$fileName;

              if(move_uploaded_file($tmpPath,$desPath)){
                echo 'file uploaded';
              }else{
                echo 'error occured while uploading file' ;
              }
          }
        }else{
          $errors['image'] = ' upload image file ' ;
        }

    if (count($errors) > 0){
      foreach($errors as $error => $value){
        echo $error. ' : '.$value.', ';
      }
    }else{
      $_SESSION['user']= ['name' => $name,
                          'email' => $email,
                          'password' => $password,
                          'linkedin' => $linkedin,
                          'address' => $address,
                          'image' => $desPath];

      echo 'Date saved in session';
      header('Location: profile.php');
      
    }
  }
  
?> 



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Register</h2>
  <form action="<?php $_SERVER['PHP_SELF'];?>" method= "POST"  enctype="multipart/form-data">  
      <div class="form-group">
        <label for="exampleInputName">name</label>
        <input type="text" name= "name" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter your name" >
      </div>

      <div class="form-group">
        <label for="Email">Email</label>
        <input type="textarea" name= "email"   class="form-control" id="Email" aria-describedby="" placeholder="enter your email" >
      </div>

      <div class="form-group">
        <label for="password">password</label>
        <input type="password" name= "password"   class="form-control" id="password" aria-describedby="" placeholder="enter your password" >
      </div>

      <div class="form-group">
        <label for="address">address</label>
        <input type="text" name= "address"   class="form-control" id="address" aria-describedby="" placeholder="enter your address" >
      </div>

      <div class="form-group">
        <label for="linkedin">linkedin</label>
        <input type="text" name= "linkedin"   class="form-control" id="linkedin" aria-describedby="" placeholder="enter your linkedin url" >
      </div>

      <div class="form-group">
        <label for="formFile" class="form-label">profile picture</label>
        <input class="form-control" name="image" type="file" id="formFile" enctype="multipart/form-data">
      </div>



      <button type="submit" class="btn btn-primary my-3">Submit</button>

</form>
</div>

</body>
</html>