<!-- create c from crud -->

<?php 
require '../helpers.php';
require '../dbConnection.php';



    
    $errors = [];
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $title = clean($_REQUEST['title']);
        $content = clean($_REQUEST['content']);

    

    
        
    
      if(!validate($title , 1)){
        $errors['title'] = 'you have to enter your title';
      }
      
      if(!validate($content , 1)){
        $errors['content'] = 'please enter the content';
      }elseif(!validate($content , 3 , 20)){
        $errors['content'] = 'your content must be at least 30 char';
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
            }else{
              echo 'error occured while uploading file' ;
            }
        }
      }else{
        $errors['image'] = ' upload image file ' ;
      }


    
    
        if (count($errors) > 0){
          foreach($errors as $error => $value){
            echo '<div class="alert alert-danger" role="alert">'.$error.' : '.$value.'</div>';
          }
        }else{
          $sql = "insert into users(title , content , image) values ('$title','$content','$desPath')";
          $op = mysqli_query($conn,$sql);
              if($op){
                echo '|| data inserted';
              }else{
                echo 'Error try again'.mysqli_error($conn);
              }
          header("Location: index.php");
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
            <label for="content">content</label>
            <input type="textarea" name= "content"  class="form-control" id="content" aria-describedby="" placeholder="enter your content" >
          </div>

          <div class="form-group">
            <label for="formFile" class="form-label">image</label>
            <input class="form-control" name="image" type="file" id="formFile">
          </div>


          <button type="submit" class="btn btn-primary my-3">Submit</button>

    </form>
  </div>
</body>
</html>