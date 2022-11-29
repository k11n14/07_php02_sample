<?php
// DB接続
$dbn ='mysql:dbname=Twitter;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';
// DBに接続出来ているかの確認。おk
try{
  $pdo = new PDO ($dbn,$user,$pwd);
  // echo 'dbOK';
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

$sql = 'SELECT * FROM Date_table';
$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
  // echo 'sqlOK';
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";

echo('<pre>');
var_dump($result);
echo('</pre>');

foreach ($result as $record) {
  $output .= "
    <tr>
      <td>{$record["A_word"]}</td>
    </tr>
  ";
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ツイッターアプリ</title>
</head>
<body>
  <form action="Twitter_server.php" method="POST">
    <fieldset>
      <legend>ツイッター</legend>
      <div>
        一言: <input type="text" name="A_word">
      </div>
    </fieldset>
  </form>
  <div class="tweet_area"><?= $output ?></div>
</body>
</html>