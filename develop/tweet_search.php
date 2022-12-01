<?PHP
require_once 'function.php';

Call_DB()
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
  <form action="tweet_search_sever.php" method="post">
  <!-- 任意の<input>要素＝入力欄などを用意する -->
  <input type="text" name="search_word">
  <!-- 送信ボタンを用意する -->   
  <input type="submit" name="submit" value="送信">
</form>
<div class="search_result"></div>
</body>
</html>