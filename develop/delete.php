<?php
// データ受け取り
$id = $_GET['id'];

// DB接続


// SQL実行



include('function.php');
$pdo = connect_to_db();


$sql = 'DELETE FROM Date_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header('Location:Twitter_main.php');
exit();


?>