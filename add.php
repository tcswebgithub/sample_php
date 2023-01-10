<?php

require_once __DIR__.'/inc/functions.php';
include __DIR__.'/inc/error_check.php';
require_once __DIR__.'/login_check.php';


if(empty($_POST['title'])) {
// 0と""(空文字は0バイトの文字列型)はtrue
// issetと似てるが真逆ではない 
    echo "タイトルは必須です。";
    exit;
}

if( !preg_match('/\A[[:^cntrl:]]{1,200}\z/u',$_POST['title'])) {  // !演算子はtrue←→falseを入れ替える ~じゃなければ
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
// strtostring() 組み込み関数でやってください
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

require_once 'functions.php'; //作成した関数の読み込み
var_dump($abc); // ↑こいつを読み込んでるのでそのまま使える変数

try {
    $dbh = db_open(); // ← ユーザー定義関数
    $sql ="INSERT INTO books (id, title, isbn, price, publish, author) VALUES (NULL, :title, :isbn, :price, :publish, :author)";
    $stmt = $dbh->prepare($sql);
    $price = (int) $_POST['price'];
    $stmt->bindParam(":title", $_POST['title'], PDO::PARAM_STR);
    $stmt->bindParam(":isbn", $_POST['isbn'], PDO::PARAM_STR);
    $stmt->bindParam(":price", $price, PDO::PARAM_INT);
    $stmt->bindParam(":publish", $_POST['publish'], PDO::PARAM_STR);
    $stmt->bindParam(":author", $_POST['author'], PDO::PARAM_STR);
    $stmt->execute();
    echo "データが追加されました。<br>";
    echo "<a href='list.php'>リストへ戻る</a>";
} catch (PDOException $e) {
    echo "エラー!: " . str2html($e->getMessage()) . "<br>";
    exit;
}