<?php

// var_dump($_POST);
// exit('OK');
// 入力項目のチェック
// if (
//   !isset($_POST['todo']) || $_POST['todo'] == '' ||
//   !isset($_POST['deadline']) || $_POST['deadline'] == '' ||
//   !isset($_POST['id']) || $_POST['id'] == ''
// ) {
//   exit('paramError');
// }

$tweet = $_POST['A_word'];
// $deadline = $_POST['deadline'];
$id = $_POST['id'];



// DB接続

include('function.php');
$pdo = connect_to_db();
// SQL実行

$sql = 'UPDATE Date_table SET tweet=:tweet WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue('tweet', $tweet, PDO::PARAM_STR);
// $stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);



try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header('Location:Twitter_main.php');
exit();

