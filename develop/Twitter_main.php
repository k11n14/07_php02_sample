<?php
include("function.php");
session_start();
check_session_id();
$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];

// echo('<pre>');
// var_dump($_SESSION);
// echo $_SESSION["username"];
// echo('</pre>');


// // DB接続
// $dbn ='mysql:dbname=Twitter;charset=utf8mb4;port=3306;host=localhost';
// $user = 'root';
// $pwd = '';
// // DBに接続出来ているかの確認。おk
// try{
//   $pdo = new PDO ($dbn,$user,$pwd);
//   // echo 'dbOK';
// } catch (PDOException $e) {
//   echo json_encode(["db error" => "{$e->getMessage()}"]);
//   exit();
// }

// SELECT 表示するカラム名 FROM テーブル名;
// 「*」で全て指定
// 複数カラム指定
// SELECT カラム１, カラム２ FROM todo_table;
$sql = 'SELECT
  *
FROM
  Date_table
  LEFT OUTER JOIN
    (
      SELECT
        todo_id,
        COUNT(id) AS like_count
      FROM
        like_table
      GROUP BY
        todo_id
    ) AS result_table
  ON  Date_table.id = result_table.todo_id ORDER BY created_at DESC';
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
            <td><a href='like_create.php?user_id={$user_id}&todo_id={$record["id"]}'>like {$record["like_count"]}</a></td>

    </tr>
  ";
}

$search_result = "";
if(
  isset($_POST["search_word"])
){
$output = "";


$search_word = $_POST["search_word"];



// // echo('<pre>');
// // var_dump($search_word) ;
// // echo('</pre>');

// // echo('<pre>');
// // echo $search_word ;
// // echo('</pre>');

// // DBに接続出来ているかの確認。おk
// try{
//   $pdo = new PDO ($dbn,$user,$pwd);
//   echo 'dbOK';
// } catch (PDOException $e) {
//   echo json_encode(["db error" => "{$e->getMessage()}"]);
//   exit();
// }
// あ〜てすとだよ 	かいけつしたで！

// include ("function.php");
// $pdo=connect_to_db();

// 'SELECT『参照』。*『全データ』。FROM テーブル名『テーブル名を指定』。WHERE カラム名=『完全一致』検索したいワード『検索』。ORDER BY カラム名 ASCかDESC=（昇順）（降順）『並び替え』。DESC LIMIT 数字 『表示制限』';
// $sql = 'SELECT * FROM Date_table WHERE tweet = :word ORDER BY created_at DESC LIMIT 10';
$sql = 'SELECT * FROM Date_table WHERE user_name LIKE :word ||tweet LIKE :word ORDER BY created_at DESC LIMIT 10';

  // PDO（PHP Data Objects）=異なるデータベースでも同じ命令で操作できるようにする
$stmt = $pdo->prepare($sql);

// 直接変数を打ち込んでもエラーは出ないけど結果が帰ってこなかった。
$stmt->bindValue(':word', "%$search_word%", PDO::PARAM_STR);

try {
  $status = $stmt->execute();
  echo 'sqlOK';
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $search_result = "";

// echo('<pre>');
// var_dump($result);
// echo('</pre>');

foreach ($result as $record) {
  $search_result .= "
  <div class='Tweet_div'>
  <div>{$record["user_name"]}さん {$record["tweet"]}</div>
  <div>{$record["created_at"]}</div>
  <td>
        <a href='edit.php?id={$record["id"]}'>edit</a>
      </td>
      <td>
        <a href='delete.php?id={$record["id"]}'>delete</a>
      </td>
  </div>
  
  ";
}
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
      <legend>ツイッター <?= $_SESSION["username"]?></legend>
      <div>
        一言: <input type="text" name="A_word">
      </div>
      <!-- <div>
        検索: <input type="text" name="search_word">
      </div> -->
    </fieldset>
  </form>
 <form action="Twitter_main.php" method="post">
  <!-- 任意の<input>要素＝入力欄などを用意する -->
  <input type="text" name="search_word">
  <!-- 送信ボタンを用意する -->   
  <input type="submit" name="submit" value="検索">
</form>
<div class="search_result"><?= $search_result ?></div>
<div class="tweet_area"><?= $output ?></div>

  
</body>
</html>