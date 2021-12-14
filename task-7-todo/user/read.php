<!-- read  r from the crud -->

<?php 
require '../helpers.php';
require '../dbConnection.php';
include '../checkLogin.php';


$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
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

  
  if(in_array($extension, $allowedEx)){
    $desPath = '../image/'.$fileName;

      if(move_uploaded_file($tmpPath,$desPath)){
        echo 'file uploaded ';
      }else{
        echo 'error occured while uploading file' ;
      }
  }else{
    $errors['image'] = ' wrong extension' ;
  }
}else{
  $errors['image'] = ' upload image file ' ;
}

if (count($errors) > 0){
  foreach($errors as $error => $value){
    echo '<div class="alert alert-danger" role="alert">'.$error.' : '.$value.'</div>';
  }
}else{
  $sql = "insert into todo(task , description , start , end , image) values ('$task','$desc','$startDate','$endDate','$desPath')";
  $op = mysqli_query($conn,$sql);
      if($op){
        echo '|| data inserted';
          
          // if(mysqli_num_rows($op) > 0){

          // }
      }else{
        echo 'Error try again'.mysqli_error($conn);
      }
}

}

$sql = "select * from todo";
$op = mysqli_query($conn , $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
  <div class="container">

    <div class="page-header">
      <h1>My Tasks</h1>
      <br>
      <span>welcome, <?php echo $_SESSION['user']['title']; ?></span>
    </div>


    <?php 
      if(isset($_SESSION['message'])){

        echo $_SESSION['message'];
        unset($_SESSION['Message']);

      }
    ?>


<div class="container">
  <div class="row">
    <div class="col">
      <form action="<?php $_SERVER['PHP_SELF'];?>" method= "POST"  enctype="multipart/form-data">
          <div class="form-group my-2">
            <label for="Name">task</label>
            <input type="text" name= "task" class="form-control" id="task" aria-describedby="" placeholder="Enter your task" >
          </div>

          <div class="form-group my-2">
            <label for="description">description</label>
            <input type="text" name= "description" class="form-control" id="description" aria-describedby="" placeholder="Enter your description" >
          </div>


          <div class="form-group my-2">
            <label for="startDate">start date</label>
            <input type="date" name= "startDate" class="form-control" id="date" aria-describedby="" placeholder="start date" >
          </div>

          <div class="form-group my-2">
            <label for="endDate">end date</label>
            <input type="date" name= "endDate" class="form-control" id="endDate" aria-describedby="" placeholder="end date" >
          </div>

          <div class="form-group my-2">
            <label for="image">upload your image</label>
            <input type="file" name= "image" class="form-control" id="image" aria-describedby="" placeholder="upload an image" >
          </div>

          <button type="submit" class="btn btn-primary my-3">ADD</button>
      </form>

      <a href="logout.php" class="btn btn-danger btn-sm m-3">LOG OUT</a>
    </div>


    <div class="col">
        <div class="row">
          <div class="col-12">
      <?php while($data = mysqli_fetch_assoc($op)){ ?>

        <div class="card my-4" style="width: 18rem;">
            <img src="<?php echo $data['image']; ?>" class="card-img-top" alt="error loading the image">
          <div class="card-body">
            <h5 class="card-title"><?php echo $data['task']; ?></h5>
            <p class="card-text"><?php echo $data['description']; ?></p>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item"> <?php echo $data['start'];?></li>
              <li class="list-group-item"> <?php echo $data['end'];?></li>
            </ul>
            <div class="card-body">
            <a href="delete.php?id=<?php echo $data['id']?>" class = 'btn btn-danger btn-md '> <span style="color: white"> Delete <i class="fas fa-trash-alt"></i></span></a>
            <a href="edit.php?id=<?php echo $data['id']?>" class = 'btn btn-primary m-2'> Edit <i class="fas fa-edit"></i></a>
            </div>
          </div>
          </div>

      <?php }?>
      </div>
    </div>
  </div>
</div>

    <!-- <table class="table table-dark table-hover table_bordered">
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>Image</th>
      </tr>

        <?php while($data = mysqli_fetch_assoc($op)){?>
            <tr>
              <td><?php echo $data['id']; ?></td>
              <td><?php echo $data['title']; ?></td>
              <td><?php echo $data['content']; ?></td>
              <td> <img src="<?php echo $data['image']; ?>" alt="error loading image" style="width: 50px ; height: 50px"> <?php echo $data['image'];?></td>
              <td>
                <a href="delete.php?id=<?php echo $data['id']?>" class = 'btn btn-danger btn-md '> <span style="color: white"> Delete <i class="fas fa-trash-alt"></i></span></a>
                <a href="edit.php?id=<?php echo $data['id']?>" class = 'btn btn-primary m-2'> Edit <i class="fas fa-edit"></i></a>
              </td>
            </tr>

        <?php } ?>

    </table> -->
  </div>
</body>
</html>