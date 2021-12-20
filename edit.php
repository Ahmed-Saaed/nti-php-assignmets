<?php

require '../helpers/dbConnection.php';
require '../helpers/functions.php';

# Fetch Roles .....
$sql = 'select * from category';
$categories = mysqli_query($con, $sql);

$id = $_GET['id'];

$sqlb = "select * from blog where id = '$id'";
$opb = mysqli_query($con , $sqlb);
$blogData = mysqli_fetch_assoc($opb);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // CODE ......
    $title   = Clean($_POST['title']);
    $content = Clean($_POST['content']);
    $date    = Clean($_POST['date']);
    $cat_id  = $_POST['cat_id'];

    # Validation ......
    $errors = [];

    # Validate Name
    if (!validate($title, 1)) {
        $errors['Title'] = 'Field Required';
    } elseif (!validate($title, 7)) {
        $errors['Title'] = 'Invalid String';
    }

    # Validate Email
    if (!validate($content, 1)) {
        $errors['Content'] = 'Field Required';
    }  elseif (!validate($content, 3, 10)) {
        $errors['Content'] = 'Length Must >= 10 chs';
    }



    # Validate cat_id
    if (!validate($cat_id, 4)) {
        $errors['Category'] = 'Invalid Category';
    }

    
            // validate date : $date_arr  = explode('/', $date_str):if (!checkdate($date_arr[0], $date_arr[1], $date_arr[2]))
    # Validate date
    if (!validate($date, 1)) {
        $errors['date'] = 'Field Required';
    }elseif(!validate($date,8)){
        $errors['date'] = 'enter valied date';
    }


    # Validate image
    if (validate($_FILES['image']['name'], 1)) {
        $tmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageType = $_FILES['image']['type'];

        $exArray = explode('.', $imageName);
        $extension = end($exArray);

        $FinalName = rand().time().'.'.$extension;

        $allowedExtension = ['png', 'jpg'];

        if (!validate($extension, 5)) {
            $errors['Image'] = 'Error In Extension';
        }
    }

    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {
        // db ..........

        // old Image
        $OldImage = $blogData['image'];

        if (validate($_FILES['image']['name'], 1)) {
            $desPath = './uploads/' . $FinalName;

            if (move_uploaded_file($tmpPath, $desPath)) {
                unlink('./uploads/' . $OldImage);
            }
        } else {
            $FinalName = $OldImage;
        }

        $sql = "update blog set title = '$title' , content = '$content', image = '$FinalName' , date = '$date' , cat_id = '$cat_id'  where id = '$id'";
        $op = mysqli_query($con, $sql);

  

        if ($op) {
            $_SESSION['Message'] = ['message' => 'Raw Updated'];
            

            header('Location: ' . url('Articles/index.php'));
            exit();
        } else {
          echo '<br>';
          echo '<br>';
            echo mysqli_error($con);
            $_SESSION['Message'] = ['message' => 'Error Try Again'];
        }
    }
}
require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>


<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid">




      <h1 class="mt-4">Dashboard</h1>
      <ol class="breadcrumb mb-4">

        <?php 
                            
                              if(isset($_SESSION['Message'])){
                                foreach($_SESSION['Message'] as $key => $val){
                                echo '* '.$key.' : '.$val.'<br>';
                                }
                                unset($_SESSION['Message']); 
                            }else{
                            
                            ?>

        <li class="breadcrumb-item active">Dashboard/Add User</li>

        <?php } ?>
      </ol>






      <div class="card-body">


        <div class="container">



          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
            enctype="multipart/form-data">



            <div class="form-group">
              <label for="exampleInputName">Title</label>
              <input type="text" class="form-control" id="exampleInputName" name="title" aria-describedby=""
                placeholder="Enter Title" value="<?php echo $blogData['title']; ?>">
            </div>


            <div class="form-group">
              <label for="exampleInputEmail">Content</label>
              <textarea type="text" class="form-control" name="content"
                placeholder="Enter your content"><?php echo $blogData['content'];?></textarea>
            </div>

            <div class="form-group">
              <label for="exampleInputPassword">date</label>
              <input type="date" class="form-control" id="exampleInputPassword1" name="date" placeholder="date"
                value="<?php echo date("Y/m/d",$blogData['date']); ?>">
            </div>





            <div class="form-group">
              <label for="exampleInputPassword">Category</label>

              <select class="form-control" name="cat_id">
                <?php
                                while($data = mysqli_fetch_assoc($categories)){
                                ?>
                <option value="<?php echo $data['id']; ?>"><?php echo $data['title']; ?></option>
                <?php } ?> ?>
              </select>
            </div>



            <div class="form-group">
              <label for="exampleInputPassword">Image</label><br>
              <input type="file" name="image">
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
          </form>







        </div>
      </div>


    </div>
  </main>


  <?php
    
    require '../layouts/footer.php';
    ?>