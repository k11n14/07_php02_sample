<?php
include(function.php);
session_start();

echo('<pre>');
var_dump($_SESSION);
echo('</pre>');
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
$sql = 'SELECT * FROM Date_table ORDER BY created_at DESC';
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

// sqlが実行出来ているか確認する所。
try {
  $status = $stmt->execute();
  // echo 'sqlOK';
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
// ようわからんけど$resultの中に選択して取ってきたデータが配列っぽい形で入ってる。
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = "";

// echo('<pre>');
// var_dump($result);
// echo('</pre>');

// array(5) {
//   [0]=>
//   array(4) {
//     ["id"]=>
//     string(1) "4"
//     ["user_name"]=>
//     string(4) "hoge"
//     ["tweet"]=>
//     string(12) "ほごーと"
//     ["created_at"]=>
//     string(19) "2022-11-29 17:48:24"
//   }

// foreach ($result as $record) {
//   $output .= "
//   <div class='Tweet_div'>
//   <div>{$record["user_name"]}さん {$record["tweet"]}</div>
//   <div>{$record["created_at"]}</div>
//   </div>
//   ";
// }

foreach ($result as $record) {
  $output .= "
    <tr>
      <td>{$record["user_name"]}</td>
      <td>{$record["tweet"]}</td>
      <td>{$record["created_at"]}</td>
      <td>
        <a href='edit.php?id={$record["id"]}'>edit</a>
      </td>
      <td>
        <a href='delete.php?id={$record["id"]}'>delete</a>
      </td>
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
  <link rel="stylesheet" href="./css/Twitter.css">
</head>
<body>
  <form action="Twitter_main_server.php" method="POST">
    <fieldset>
      <legend>ツイッター</legend>
      <div>
        一言: <input type="text" name="A_word">
      </div>
      <!-- <div>
        検索: <input type="text" name="search_word">
      </div> -->
    </fieldset>
  </form>
  <div class="tweet_area"><?= $output ?></div>
</body>
</html>