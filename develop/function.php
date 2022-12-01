<?php
function Call_DB(){
$dbn ='mysql:dbname=Twitter;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

try{
  $pdo = new PDO ($dbn,$user,$pwd);
  echo 'dbOK';
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}
}

function Cheack_sql (){
try {
  $status = $stmt->execute();
  // echo 'sqlOK';
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
}

function tweet_preview (){
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $output = "";
  foreach ($result as $record) {
  $output .= "
  <div class='Tweet_div'>
  <div>{$record["user_name"]}さん {$record["tweet"]}</div>
  <div>{$record["created_at"]}</div>
  </div>
  ";

}

?>