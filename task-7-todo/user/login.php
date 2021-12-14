<?php 

require '../dbConnection.php';
include '../helpers.php';

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $email = clean($_REQUEST['email']);
  $password = clean($_REQUEST['password']);

  if(!validate($email , 1)){
    $errors['email'] = 'please enter the email';
  }elseif(!validate($email ,2)){
    $errors['email'] = 'enter valid email';
  }

  if(!validate($password , 1)){
    $errors['email'] = 'please enter your password';
  }elseif(!validate($password ,3 , 6)){
    $errors['email'] = 'enter a valied password';
  }

  $hpassword = md5($password);

    if (count($errors) > 0){
      foreach($errors as $error => $value){
        echo '<div class="alert alert-danger" role="alert">'.$error.' : '.$value.'</div>';
      }
    }else{

      $sql =  "select * from users where email = '$email' and password = '$hpassword'" ;
      $op = mysqli_query($conn , $sql);

      if (mysqli_num_rows($op) == 1){

        $sql =  "select * from users where email = '$email' and password = '$hpassword'" ;
        $op = mysqli_query($conn , $sql);

        $data = mysqli_fetch_assoc($op);

        $_SESSION['user'] = $data;

        $user = $data['title'];

        header("Location: read.php?title=$user");
      }else{
        echo '<div class="alert alert-danger" role="alert">'.'user is not registered'.'</div>';
      }
    }
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>
  <div class="container">

    <h2>login</h2>
    <form action="<?php $_SERVER['PHP_SELF'];?>" method= "POST"  enctype="multipart/form-data">  

        <div class="form-group">
          <label for="Email">Email</label>
          <input type="textarea" name= "email"   class="form-control" id="Email" aria-describedby="" placeholder="enter your email" >
        </div>

        <div class="form-group">
          <label for="password">password</label>
          <input type="password" name= "password"  class="form-control" id="password" aria-describedby="" placeholder="enter your password" >
        </div>

        <button type="submit" class="btn btn-primary my-3">login</button>
    </form>


  </div>
</body>
</html>