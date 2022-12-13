<?php
// if(isset($_POST['user'])) {
// $dsn='mysql:dbname=Twitter;charset=utf8';
// $user='root';
// $password='';
// $dbh = new PDO($dsn,$user,$password);

// $stmt = $dbh->prepare("SELECT * FROM users WHERE id=:user");
// $stmt->bindParam(':user', $_POST['user']);
// $stmt->execute();
// if($rows = $stmt->fetch()) {
// if($rows["password"] ==  $_POST['password']) {
// // print "<p>ログイン成功</p>";
// header('Location:Twitter_main.php');


// }else {
// $alert = "<script type='text/javascript'>alert('ログインに失敗しました');</script>";
// echo $alert;
// // header('main.php');
// echo '<script>location.href = "main.php" </script>';
// }
// }else {
// print "<p>ログイン失敗</p>";

// }
// }
// if(
//   !isset($_POST['todo'])||$_POST['todo']==''||!isset($_POST['deadline'])||$_POST['deadline']==''
// ){
//   exit('ParamError');
// }

if(
  !isset($_POST['user'])||$_POST['user']==''||!isset($_POST['password'])||$_POST['password']==''
){
  $alert = "<script type='text/javascript'>alert('記入漏れがあります。');</script>";
  echo $alert;
  // header('Location:main.php');
  echo '<script>location.href = "main.php" </script>';
  exit();
} 

session_start();
echo('<pre>');
var_dump ($_SESSION);
echo('</pre>');

include('function.php');


$username = $_POST['user'];
$password = $_POST['password'];


echo $username;
echo $password;

$pdo = connect_to_db();

$sql = 'SELECT * FROM users WHERE id=:username AND password=:password ';

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$val = $stmt->fetch(PDO::FETCH_ASSOC);

echo('<pre>');
var_dump($val );
echo('</pre>');

if (!$val) {
  $alert = "<script type='text/javascript'>alert('ログインに失敗しました。');</script>";
  echo $alert;
  // header('Location:main.php');
  echo '<script>location.href = "main.php" </script>';
  exit();
} else {


  $_SESSION = array();
  $_SESSION['session_id'] = session_id();
   $_SESSION['user_id'] = $val['id'];
  // $_SESSION['is_admin'] = $val['is_admin'];
  $_SESSION['username'] = $val['id'];
  $_SESSION['password'] = $val['password'];
  header("Location:Twitter_main.php");
  exit();
}




?>