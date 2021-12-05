<?php 
  $units = 300;
  $bill = 0;

  if($units <= 50){
    $bill = $units * 3.50;
  }elseif($units > 50 && $units <= 150){
    $unitAbove50 = $units - 50;
    $bill = (50 * 3.50) + ($unitAbove50 * 4);
  }else{
    $unitAbove50 = $units - 50;
    $unitAbove150 = $unitAbove50 - 100;
    $bill = (50 * 3.50) + ($unitAbove50 * 4) + ($unitAbove150 * 6.50);
  }

  echo "$bill"

?>