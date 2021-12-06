<?php 

  function nextChar($char){

    if ($char === 'z') {
      echo 'a';
    }else{ 
      $nextChara = bin2hex($char) + 1 ;
      echo hex2bin($nextChara);
    }
  };

  nextChar('h');
?>