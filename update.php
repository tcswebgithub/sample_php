<?php
require_once __DIR__.'/inc/functions.php';
include __DIR__.'/inc/error_check.php';

if (empty($_POST['id'])){
  echo "IDを指定せよ";
  exit;
}
if (!preg_match('/\A\d{0,11}\z/u',$_POST['id'])){
  echo "IDが不正";
exit;
}



try {
  $dbh = db_open();

  $sql = "UPDATE books SET title=:title,isbn=:isbn,price=:price,publish=:publish,author=:author WHERE id=:id";
  $stmt = $dbh->prepare($sql);

  $price = (int) $_POST['price'];
  $id = (int) $_POST['id'];
  $stmt->bindParam(":title", $_POST['title'], PDO::PARAM_STR);
  $stmt->bindParam(":isbn", $_POST['isbn'], PDO::PARAM_STR);
  $stmt->bindParam(":publish", $_POST['publish'], PDO::PARAM_STR);
  $stmt->bindParam(":price", $_POST['price'], PDO::PARAM_STR);
  $stmt->bindParam(":author", $_POST['author'], PDO::PARAM_STR);
  $stmt->bindParam(":id", $_POST['id'], PDO::PARAM_STR);
  $stmt->execute();

echo "データ更新完了";
echo "<a href ='list.php'>リストへ戻る</a>";
}

catch (PDOException $e){
  echo "エラー！：　" . str2html($e->getMessage()) . "<BR>";
  exit;
}