<?php 
session_start()



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
  <div class="card m-5 center" style="width: 18rem;">
  <img src="<?php echo $_SESSION['user']['desPath'];?>" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?php echo $_SESSION['user']['name'];?></h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item"><?php echo $_SESSION['user']['email'];?></li>
      <li class="list-group-item"><?php echo $_SESSION['user']['address'];?></li>
      <li class="list-group-item"><?php echo $_SESSION['user']['linkedin'];?></li>
      <li class="list-group-item"><?php echo $_SESSION['user']['name'];?></li>
      <li class="list-group-item"></li>
    </ul>
  </div>
  </div>
</body>
</html>