<?php
session_start();
  echo 'prueba';
  
  setcookie($_COOKIE['name'],'a',time()-1);
  setcookie('name','a',time()-1);
  header('Location: index.php');
session_destroy();
