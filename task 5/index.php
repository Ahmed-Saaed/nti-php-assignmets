<?php 

$getProducts = file_get_contents('http://shopping.marwaradwan.org/api/Products/1/1/0/100/atoz');

$productsArr = json_decode($getProducts,true); //array of data and count

$products = $productsArr['data']; //data

// print_r($products[0]['products_name']);

$prodFile = fopen("products.txt", "w") or die("Unable to open file!");


foreach($products as $product){
  $text ='id: '.$product['products_id'].'<br>';
  fwrite($prodFile,$text);
  $text ='name : '.$product['products_name'].'<br>';
  fwrite($prodFile,$text);
  $text ='description : '.$product['products_description'].'<br>';
  fwrite($prodFile,$text);
  $text ='quantity : '.$product['products_quantity'].'<br>';
  fwrite($prodFile,$text);
  $text ='model : '.$product['products_model'].'<br>';
  fwrite($prodFile,$text);
  $text ='image : '.$product['products_image'].'<br>';
  fwrite($prodFile,$text);
  $text ='date_added : '.$product['products_date_added'].'<br>';
  fwrite($prodFile,$text);
  $text ='liked : '.$product['products_liked'].'<br>';
  fwrite($prodFile,$text);
  $text ='*********************************'.'<br>';
  fwrite($prodFile,$text);
}

fclose($prodFile);
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
    <a class="btn btn-primary d-grid gap-2 col-6 m-auto my-3 " href="/nti-php/profile.php">go to products</a>
  </div>
</body>
</html>