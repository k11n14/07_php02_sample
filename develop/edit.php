<?php

// id受け取り
include("function.php");

$id = $_GET['id'];

$pdo = connect_to_db();

$sql = 'SELECT * FROM Date_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB連携型todoリスト（編集画面）</title>
</head>

<body>
 <form action="update.php" method="POST">
    <fieldset>
      <legend>編集</legend>
      <div>
        一言: <input type="text" name="A_word">
      </div>
      <!-- <div>
        検索: <input type="text" name="search_word">
      </div> -->
    </fieldset>
  </form>

</body>

</html>