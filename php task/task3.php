<?php 

$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$address = $_REQUEST['address'];
$linkedin = $_REQUEST['linkedin'];

$errors = [];

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(empty(trim($name))){
      $errors['name'] = 'required field ';
    }
    if(empty($email) || !strstr($email,'@') || !strstr($email ,'.com')){
      $errors['email'] = ' enter valid email ';
    }
    if(strlen($password) < 6){
        $errors['password'] = ' minimum password length is 6 ' ;
    }
    if(strlen($address) !== 10) {
      $errors['address'] = ' your addres has to be exactly 10 characters ' ;
    }
    if(empty($linkedin)|| !strstr($linkedin,"www.linkedin.com/in/")){
      $errors['linkedin'] = ' please enter a valid linkedin url';
    }
    
    if (count($errors) > 0){
      foreach($errors as $error => $value){
        echo $error. ' : '.$value.', ';
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Register</h2>
  <form action="<?php $_SERVER['PHP_SELF']; ?>" method= "POST">  
      <div class="form-group">
        <label for="exampleInputName">name</label>
        <input type="text" name= "name" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter your name" required>
      </div>

      <div class="form-group">
        <label for="Email">Email</label>
        <input type="textarea" name= "email"   class="form-control" id="Email1" aria-describedby="" placeholder="enter your email" required>
      </div>
      
      <div class="form-group">
        <label for="password">password</label>
        <input type="password" name= "password"   class="form-control" id="password" aria-describedby="" placeholder="your password goes here" required>
      </div>
      
      <div class="form-group input-group-text">
        <label for="address">address</label>
        <input type="text" name= "address"   class="form-control" id="address" aria-describedby="basic-addon3" placeholder="enter your address" required>
      </div>

      <div class="form-group input-group-text">
        <label for="linkedin">linkedin</label>
        <input type="text" name= "linkedin"   class="form-control" id="linkedin" aria-describedby="basic-addon3" placeholder="linkedin url" required>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>

</form>
</div>

</body>
</html>