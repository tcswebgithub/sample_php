<?php
require_once __DIR__.'/login_check.php';

if(!isset($_SESSION)){
  session_start();
}
if(empty($_SESSION['login'])){
  echo "このページにアクセスするには<a href='login.php'>ログイン</a>が必要";
  var_dump($_SESSION);
exit;
}
echo 'ログイン中';


