<?php
session_start();

echo ('<pre>');
var_dump($_SESSION);
echo ('</pre>');

include("function.php");
$pdo = connect_to_db();

$sql = 'SELECT * FROM Date_table 
LEFT OUTER JOIN (SELECT todo_id, COUNT(id) AS like_count FROM like_table GROUP BY todo_id) AS result_table ON  Date_table.id = result_table.todo_id ORDER BY created_at DESC';
  
  $stmt = $pdo->prepare($sql);

  try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo ('<pre>');
var_dump($result);
echo ('</pre>');


?>


<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta charset="utf-8" />
  <title>Gamedev Canvas Workshop</title>
  <style>
    * { padding: 0; margin: 0; }
    canvas { background: #eee; display: block; margin: 0 auto; }
  </style>
</head>
<body>

<canvas id="myCanvas" width="480" height="320"></canvas>

<script>
  // JavaScript のコードはここ
  const canvas = document.getElementById("myCanvas");
const ctx = canvas.getContext("2d");

ctx.beginPath();
ctx.rect(20, 40, 50, 50);
ctx.fillStyle = "#FF0000";
ctx.fill();
ctx.closePath();

</script>

</body>
</html>