<?php 
  require '../helpers.php';
  require '../dbConnection.php';

  $id = $_GET['id'];

  if(!validate($id, 4)){
    $message = 'invalid Number';
  }else{
    $sql = "select * from users where id= $id";
    $op = mysqli_query($conn , $sql);

      if (mysqli_num_rows($op)==1){

        $sql = "delete from users where id = $id";
        $op = mysqli_query($conn, $sql);

          if($op){
            $message = 'raw deleted';
          }else{
            $message = 'Error occured try again later';
          }
      }else{
        $message = 'Error in user id';
      }
  }

  $_SESSION['message'] = $message;
  header('Location: index.php')


?> 