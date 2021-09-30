<?php

function h($str){
return htmlspecialchars($str, ENT_QUOTES);
}

//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_kadai_02;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError'.$e->getMessage());
}

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= "<table>";
    $view .= h($result['datetime']) 
          . ' / ' . h($result['name'] )
          . ' / ' . h($result['salary'] )
          . ' / ' . h($result['money'] )
          . ' / ' . h($result['email'] )
          . ' / ' . h($result['meetdate'] )
          . ' / ' . h($result['text']);
    $view .= "</table>";
  }
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>申請一覧表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>

<body id="main">
<div>
    <div class="container jumbotron"><?= $view ?></div>
</div>
<button><a href="posts/csv" name="button">csvダウンロード<a></button>

<!-- Main[End] -->
</body>
</html>
