<?php
// データがそもそも送られてきてるか
// echo('<pre>');
// var_dump($_POST);
// echo('</pre>');

// echo('<pre>');
// var_dump($_POST["search_word"]);
// echo('</pre>');

// DB接続
$dbn ='mysql:dbname=Twitter;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';
$search_word = $_POST["search_word"];



// echo('<pre>');
// var_dump($search_word) ;
// echo('</pre>');

// echo('<pre>');
// echo $search_word ;
// echo('</pre>');

// DBに接続出来ているかの確認。おk
try{
  $pdo = new PDO ($dbn,$user,$pwd);
  echo 'dbOK';
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}
// あ〜てすとだよ 	かいけつしたで！

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

$search_result = "";

echo('<pre>');
var_dump($result);
echo('</pre>');

foreach ($result as $record) {
  $search_result .= "
  <div class='Tweet_div'>
  <div>{$record["user_name"]}さん {$record["tweet"]}</div>
  <div>{$record["created_at"]}</div>
  </div>
  ";
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
  <form action="tweet_search.php" method="post">
  <!-- 任意の<input>要素＝入力欄などを用意する -->
  <input type="text" name="search_word">
  <!-- 送信ボタンを用意する -->   
  <input type="submit" name="submit" value="送信">
</form>
<div class="search_result"><?= $search_result ?></div>
</body>
</html>