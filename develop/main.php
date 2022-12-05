<?php
if(isset($_POST['user'])) {
$dsn='mysql:dbname=EC;charset=utf8';
$user='root';
$password='';
$dbh = new PDO($dsn,$user,$password);
$stmt = $dbh->prepare("INSERT INTO USER VALUES(:user,:password,:name,:address,:tel)");
$stmt->bindParam(':user', $_POST['user']);
$stmt->bindParam(':password', $_POST['password']);
$stmt->bindParam(':name', $_POST['name']);
$stmt->bindParam(':address', $_POST['address']);
$stmt->bindParam(':tel', $_POST['tel']);
$stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="confirm.php" method="post">
<h2>ログイン</h2>
<p>ID;<input type="text" name="user" required></p>
<p>パスワード:<input type="password" name="password" required></p>
<p><input type="submit" value="ログイン"></p>
</form>

<form action="main.php" method="post">
<h2> Twitter登録</h2>
<p>ID:<input type="text" name="user"></p>
<p>パスワード:<input type="password" name="password"></p>
<p>名前:<input type="text" name="name"></p>
<p>住所:<input type="text" name="address"></p>
<p>電話番号:<input type="tel" name="tel"></p>
<p><input type="submit" value="登録"></p>
</from>

</body>
</html>