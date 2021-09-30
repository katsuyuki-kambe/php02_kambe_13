<?php

//1. POSTデータ取得
$name = $_POST['name'];
$salary = $_POST['salary'];
$money = $_POST['money'];
$email = $_POST['email'];
$meetdate = $_POST['meetdate'];
$text = $_POST['text'];

//2. DB接続します
try {
  //ID:'root', Password: 'root'
  $pdo = new PDO('mysql:dbname=gs_kadai_02;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成
// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, name, salary, money, email, meetdate, text, datetime)
VALUES(NULL, :name, :salary, :money, :email, :meetdate, :text, sysdate())");

//  2. バインド変数を用意
$stmt->bindValue(':name', $name, PDO::PARAM_STR); 
$stmt->bindValue(':salary', $salary, PDO::PARAM_STR); 
$stmt->bindValue(':money', $money, PDO::PARAM_STR); 
$stmt->bindValue(':email', $email, PDO::PARAM_STR);  
$stmt->bindValue(':meetdate', $meetdate, PDO::PARAM_STR); 
$stmt->bindValue(':text', $text, PDO::PARAM_STR);  

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMessage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('location: index.php');
}
?>
