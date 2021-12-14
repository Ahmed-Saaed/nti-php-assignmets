<?php 
  require '../helpers.php';
  require '../dbConnection.php';
  require '../checkLogin.php';


  $id = $_GET['id'];

  if(!validate($id, 4)){
    $message = 'invalid Number';
  }else{
    $sql = "select * from todo where id= $id";
    $op = mysqli_query($conn , $sql);

      if (mysqli_num_rows($op)==1){

        $sql = "delete from todo where id = $id";
        $op = mysqli_query($conn, $sql);

          if($op){
            $message = 'raw deleted';
          }else{
            $message = 'Error occured try again later';
          }
      }else{
        $message = 'Error in todo id';
      }
  }

  $_SESSION['message'] = $message;
  header('Location: read.php');


?> 