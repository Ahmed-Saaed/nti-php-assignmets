<?php

    require '../helpers.php';
    require '../dbConnection.php';

        // get data related to the url

    $id = $_GET['id'];

    $sql = "select * from users where id = $id";
    $op = mysqli_query($conn, $sql);

    if(mysqli_num_rows($op) == 1){
        $data = mysqli_fetch_assoc($op);
    }else{
        $_SESSION['message'] = 'access denied';
        header("Location: index.php");
    }

    $errors = [];
        
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $title = clean($_REQUEST['title']);
        $content = clean($_REQUEST['content']);
    }


    if(!validate($title , 1)){
        $errors['title'] = 'you have to enter your title';
    }

    if(!validate($content , 1)){
    $errors['content'] = 'please enter the content';
    }elseif(!validate($content , 3 , 20)){
        $errors['content'] = 'your content must be at least 30 char';


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
                }else{
                    echo 'error occured while uploading file';
                }
            }
            }else{
            $errors['image'] = ' upload image file ';
            }
        if (count($errors) > 0){
            foreach($errors as $error => $value){
                echo '<div class="alert alert-danger" role="alert">'.$error.' : '.$value.'</div>';
            }
        }else{
                $sql = "update users set title = '$title' , content = '$content', image = '$desPath' where id=$id";
                $op = mysqli_query($conn,$sql);
        if($op){
            $message = '|| data updated';
        }else{
            $message = 'Error try again'.mysqli_error($conn);
        }
    }
    $_SESSION['message'] = $message;
    header("Location: index.php");
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
    <div class="container">
        <h2>what do you want to edit</h2>

        <form action="edit.php?id=<?php echo $data['title']; ?>" method= "POST"  enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputName">title</label>
                <input type="text" name= "title" class="form-control" id="exampleInputtitle" aria-describedby="" placeholder="Enter your title" value = "<?php echo $data['title']; ?>" >
            </div>

            <div class="form-group">
                <label for="content">content</label>
                <input type="textarea" name= "content"  class="form-control" id="content" aria-describedby="" placeholder="enter your content" value = "<?php echo $data['content']; ?>" >
            </div>

            <div class="form-group">
                <label for="formFile" class="form-label">image</label>
                <input class="form-control" name="image" type="file" id="formFile" value = "<?php echo $data['image']; ?>">
            </div>


            <button type="submit" class="btn btn-primary my-3">Submit</button>

        </form>
    </div>
</body>
</html>