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

// SELECT 表示するカラム名 FROM テーブル名;
// 「*」で全て指定
// 複数カラム指定
// SELECT カラム１, カラム２ FROM todo_table;
$sql = 'SELECT * FROM Date_table';
$stmt = $pdo->prepare($sql);
// 「WHERE」を使用して値の条件を指定できる
// todo_tableの*『全てのデータ』WHERE『から』deadline='2021-12-31『であるデータの読み込む』
// SELECT * FROM todo_table WHERE deadline='2021-12-31'
// 並び替えには ORDER BY を使用する．
// 昇順（ASC）か降順（DESC）を指定する．
//  `deadline`カラムの値で降順に並び替え
// SELECT * FROM todo_table ORDER BY deadline DESC;
// LIMITで表示件数の制限
// SELECT * FROM todo_table LIMIT 5;

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
      <td>{$record["tweet"]}</td>
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