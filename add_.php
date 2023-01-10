<?php
require_once 'functions.php'; //作成した関数の読み込み
if(empty($_POST['title'])) {
    echo "タイトルは必須です。";
    exit;
}
if(!preg_match('/\A[[:^cntrl:]]{1,200}\z/u',$_POST['title'])) {
    echo "タイトルは200文字までです。";
    exit;
}
if(!preg_match('/\A\d{0,13}\z/', $_POST['isbn'])) {
    echo "ISBN は数字13桁までです。";
    exit;
}
if(!preg_match('/\A\d{0,6}\z/u', $_POST['price'])) {
    echo "価格は数字6桁までです。";
    exit;
}
if(empty($_POST['publish'])) {
    echo "日付は必須です。";
    exit;
}
if(!preg_match('/\A\d{4}-\d{1,2}-\d{1,2}\z/u', $_POST['publish'])) {
    echo "日付のフォーマットが違います。";
    exit;
}
$date = explode('-', $_POST['publish']);
if(!checkdate($date[1], $date[2], $date[0])) {
    echo "正しい日付を入力してください。";
    exit;
}
if(!preg_match('/\A[[:^cntrl:]]{0,80}\z/u', $_POST['author'])) {
    echo " 著者名は80文字以内で入力してください。";
    exit;
}
try {
    $dbh = db_open();
    $sql ="INSERT INTO books VALUES (NULL,?,?,?,?,?)";
    $stmt = $dbh->prepare($sql);
    
    // $price = (int) $_POST['price'];
    
$i=0;
/*
$stmt->bindparam(++$i,$_POST['title'],PDO::PARAM_STR);//←ここにPOSTを書かない
*/

$i = 0;
    $stmt->bindParam( ++$i, $post['title'], PDO::PARAM_STR);
    $stmt->bindParam( ++$i, $post['isbn'], PDO::PARAM_STR);
    $stmt->bindParam( ++$i, $post['price'], PDO::PARAM_INT);
    $stmt->bindParam( ++$i, $post['publish'], PDO::PARAM_STR);
    $stmt->bindParam( ++$i, $post['author'], PDO::PARAM_STR);
    

    /*
    $stmt->bindParam(":title", $_POST['title'], PDO::PARAM_STR);
    $stmt->bindParam(":isbn", $_POST['isbn'], PDO::PARAM_STR);
    $stmt->bindParam(":price", $price, PDO::PARAM_INT);
    $stmt->bindParam(":publish", $_POST['publish'], PDO::PARAM_STR);
    $stmt->bindParam(":author", $_POST['author'], PDO::PARAM_STR);
    */
    
    $stmt->execute();
    echo "データが追加されました。<br>";
    echo "<a href='list.php'>リストへ戻る</a>";
} catch (PDOException $e) {
    echo "エラー!: " . str2html($e->getMessage()) . "<br>";
    exit;
}