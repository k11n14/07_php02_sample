<?php
session_start();
include('function.php');

echo('<pre>');
var_dump($_GET);
echo('</pre>');

$user_id = $_GET['user_id'];
$todo_id = $_GET['todo_id'];

echo('<pre>');
echo $user_id;
echo $todo_id;
echo('</pre>');

$pdo = connect_to_db();

$sql = 'SELECT COUNT(*) FROM like_table WHERE user_id=:user_id AND todo_id=:todo_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':todo_id', $todo_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$like_count = $stmt->fetchColumn();
// まずはデータ確認
echo('<pre>');
var_dump($like_count);
echo($like_count);
echo('</pre>');
// exit();

if ($like_count !== '0') {
  // いいねされている状態
  $sql = 'DELETE FROM like_table WHERE user_id=:user_id AND todo_id=:todo_id';
  echo('OK');
} else {
  echo('OK?');
  // いいねされていない状態
  $sql = 'INSERT INTO like_table (id, user_id, todo_id, created_at) VALUES (NULL, :user_id, :todo_id, now())';
}

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':todo_id', $todo_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$_SESSION['like_p'] = $like_count;
header("Location:Twitter_main.php");
?>