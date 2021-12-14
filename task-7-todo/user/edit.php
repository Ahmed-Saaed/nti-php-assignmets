<?php

    require '../dbConnection.php';
    require '../helpers.php';
    include '../checkLogin.php';


        // get the data

    $id = $_GET['id'];

    $sql = "select * from todo where id = $id";
    $op = mysqli_query($conn, $sql);

    if(mysqli_num_rows($op) == 1){
        $data = mysqli_fetch_assoc($op);
    }else{
        $_SESSION['message'] = 'access denied';
        header("Location: read.php");
    }

     // validate 
    
    $errors = [];
        
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $task = clean($_REQUEST['task']);
        $desc = clean($_REQUEST['description']);
        $startDate = $_REQUEST['startDate'];
        $endDate = $_REQUEST['endDate'];
        
        if(!validate($task , 1)){
          $errors['task'] = 'you have to enter your task';
        }
        
        if(!validate($desc , 1)){
          $errors['description'] = 'you have to enter your description';
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
                    $desPath = '../image/'.$fileName;
                
                    if(move_uploaded_file($tmpPath,$desPath)){
                        echo 'file uploaded ';
                        unlink($data['image']);
                    }else{
                        echo 'error occured while uploading file';
                    }
                }
            }else{
                $desPath = $data['image'];
            }
        
        
        //handle the error or execute

        if (count($errors) > 0){
            foreach($errors as $error => $value){
                echo '<div class="alert alert-danger" role="alert">'.$error.' : '.$value.'</div>';
            }
        }else{
                $sql = "update todo set task = '$task' , description = '$desc' , start = '$startDate' , end = '$endDate' , image = '$desPath' where id ='$id'";

                $op = mysqli_query($conn,$sql);
                if($op){
                    $message = '|| data updated';
                }else{
                    $message = 'Error try again'.mysqli_error($conn);
                }
                $_SESSION['message'] = $message;
                $_SESSION['data'] = $data;

                $user = $_SESSION['user']['title'];

                header("Location: read.php?title=$user");
                
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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

</head>
<body>
    <div class="container my-5">
        <h2>what do you want to edit?</h2>

            <form action="<?php $_SERVER['PHP_SELF'];?>" method= "POST"  enctype="multipart/form-data">
            <div class="form-group my-2">
                <label for="Name">task</label>
                <input type="text" name= "task" class="form-control" id="task" aria-describedby="" placeholder="Enter your task" value = "<?php echo $data['task']; >
            </div>

            <div class="form-group my-2">
                <label for="description">description</label>
                <input type="text" name= "description" class="form-control" id="description" aria-describedby="" placeholder="Enter your description" value = "<?php echo $data['description'];>
            </div>


            <div class="form-group my-2">
                <label for="startDate">start date</label>
                <input type="date" name= "startDate" class="form-control" id="date" aria-describedby="" placeholder="start date" value = "<?php echo $data['start']; >
            </div>

            <div class="form-group my-2">
                <label for="endDate">end date</label>
                <input type="date" name= "endDate" class="form-control" id="endDate" aria-describedby="" placeholder="end date"  value = "<?php echo $data['end'];>
            </div>

            <div class="form-group my-2">
                <label for="image">upload your image</label>
                <input type="file" name= "image" class="form-control" id="image" aria-describedby="" placeholder="upload an image" value = "<?php echo $data['image'];>
            </div>

            <button type="submit" class="btn btn-primary my-3">update</button>
        </form>
    </div>
</body>
</html>