<?php
// develop.phpからデータが飛んできているか確認。
// var_dump($_POST);

// ユーザーが一言を書いているかの確認。おk
if(
  // $_POST['A_word']がないか、$_POST['A_word']が空白なら
  !isset($_POST['A_word']) || $_POST['A_word']==''
){
  // エラーメッセージ
  echo "ひと言がありませんよ！！";
  // 上と同じ＊exit('ひと言がありませんよ！！');
}

// 変数宣言
$Tweet = $_POST['A_word'];

// DB接続
$dbn ='mysql:dbname=Twitter;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// DBに接続出来ているかの確認。おk
try{
  $pdo = new PDO ($dbn,$user,$pwd);
  echo 'dbOK';
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

// INSERT（データの作成）部分
// INSERT INTO テーブル名
$sql = 'INSERT INTO Date_table 
-- (カラム1, カラム2, ...)
(id,user_name, tweet, created_at) 
-- VALUES (値1, 値2, ...);
VALUES (NULL, "あかさん", :Tweet, now())';

// ↓何やってるかわkらん
$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(
  // ':Tweet',は$Tweet,。PDO::PARAM_STRはわからん
  ':Tweet', $Tweet, PDO::PARAM_STR
);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
  echo 'sqlOK';
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
header('Location:Twitter_main.php')

?>