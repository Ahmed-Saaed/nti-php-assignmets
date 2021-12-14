
<?php
// clean function 

  function clean($input){
    return strip_tags(trim($input));
  }


  // validation function
  
  function validate($input , $flag , $length = 6){

    $status = true;

    switch($flag){
      case 1:
        if(empty($input)){
          $status = false;
        }
        break;
      case 2:
        if(!filter_var($input,FILTER_VALIDATE_EMAIL)){
          $status = false;
        }
        break;
      case 3:
        if(strlen($input) < $length){
          $status = false;
        }
        break;
      case 4:
        if(!filter_var($input,FILTER_VALIDATE_INT)){
          $status = false;
        }
        break;
    }
    return $status;
  }

  // function validateImage($input){
  //   $stat = true;



  // }
?>


