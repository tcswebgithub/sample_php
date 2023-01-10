<?php
include __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/functions.php'; // この行を変更

if(empty($_GET['id'])) {
    echo "idを指定してください";
    exit;
}
if(!preg_match('/\A\d{1,11}+\z/u', $_GET['id'])) {
    echo "idが正しくありません。";
    exit;
}
$id = (int) $_GET['id'];

$dbh = db_open();
$sql = "SELECT id, title, isbn, price, publish, author FROM books WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$result) {
    echo "指定したデータはありません。";
    exit;
}

$title = str2html($result['title']);
$isbn = str2html($result['isbn']);
$price = str2html($result['price']);
$publish = str2html($result['publish']);
$author = str2html($result['author']);
$id = str2html($result['id']);

// $html_form = <<<EOD
?>
<form action='update.php' method='post'  >

<?php include 'inc/input-form.php' ?>

</form>
<?php
//EOD;


// echo $html_form;
include __DIR__ . '/inc/footer.php';