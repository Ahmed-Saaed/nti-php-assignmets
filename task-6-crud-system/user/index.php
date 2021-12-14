<!-- read  r from the crud -->

<?php 
require '../helpers.php';
require '../dbConnection.php';


$sql = "select * from users";

$op = mysqli_query($conn, $sql);


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
      <h1>Read users</h1>
      <br>
    </div>

    <?php 
      if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['Message']);
      }
    ?>

    <table class="table table-dark table-hover table_bordered">
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
                <a href="delete.php?id=<?php echo $data['id']?>" class = 'btn btn-danger '> <span style="color: white"> Delete <i class="fas fa-trash-alt"></i></span></a>
                <a href="edit.php?id=<?php echo $data['id']?>" class = 'btn btn-primary m-2'> Edit <i class="fas fa-edit"></i></a>
              </td>
            </tr>

        <?php } ?>

    </table>
  </div>
</body>
</html>
