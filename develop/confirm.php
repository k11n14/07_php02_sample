<?php
if(isset($_POST['user'])) {
$dsn='mysql:dbname=Twitter;charset=utf8';
$user='root';
$password='';
$dbh = new PDO($dsn,$user,$password);

$stmt = $dbh->prepare("SELECT * FROM users WHERE id=:user");
$stmt->bindParam(':user', $_POST['user']);
$stmt->execute();
if($rows = $stmt->fetch()) {
if($rows["password"] ==  $_POST['password']) {
// print "<p>ログイン成功</p>";
header('Location:Twitter_main.php');


}else {
$alert = "<script type='text/javascript'>alert('ログインに失敗しました');</script>";
echo $alert;
// header('main.php');
echo '<script>location.href = "main.php" ;</script>';
}
}else {
print "<p>ログイン失敗</p>";

}
}
?>