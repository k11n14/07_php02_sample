<?php
echo('<pre>');
var_dump($_POST);
echo('</pre>');

echo('<pre>');
var_dump($_POST["search_word"]);
echo('</pre>');

// DB接続
$dbn ='mysql:dbname=Twitter;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';
$search_word = $_POST["search_word"];



echo('<pre>');
var_dump($search_word) ;
echo('</pre>');

echo('<pre>');
echo $search_word ;
echo('</pre>');

// DBに接続出来ているかの確認。おk
try{
  $pdo = new PDO ($dbn,$user,$pwd);
  echo 'dbOK';
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}
// あ〜てすとだよ 	かいけつしたで！

// 'SELECT『参照』。*『全データ』。FROM テーブル名『テーブル名を指定』。WHERE カラム名=検索したいワード『検索』。ORDER BY カラム名 ASCかDESC=（昇順）（降順）『並び替え』。DESC LIMIT 数字 『表示制限』';
$sql = 'SELECT * FROM Date_table WHERE tweet= :word ORDER BY created_at DESC LIMIT 10';

  // PDO（PHP Data Objects）=異なるデータベースでも同じ命令で操作できるようにする
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':word', $search_word, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
  echo 'sqlOK';
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = "";

echo('<pre>');
var_dump($result);
echo('</pre>');

?>