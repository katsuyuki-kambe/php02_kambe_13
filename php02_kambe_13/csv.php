<?php
$dsn = "mysql:dbname=gs_kadai_02;host=localhost";
// $dsn = "mysql:dbname={$dbname};host={$dbhost}";
$dbuser = "root";//データベースユーザー名
$dbpassword = "root";//データベースユーザーパスワード


 if (isset($_POST["button"])) {
   try {
     //DB検索処理
     $pdo = new PDO($dsn, $dbuser, $dbpassword,
              array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
     $sql = "SELECT * FROM gs_bm_table";
     $stmt = $pdo->prepare($sql);
     $stmt->execute();

     //CSV文字列生成
     $csvstr = "";
     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       $csvstr .= $row['datetime'] . ",";
       $csvstr .= $row['name'] . ",";
       $csvstr .= $row['salary'] . ",";
       $csvstr .= $row['money'] . ",";
       $csvstr .= $row['email'] . ",";
       $csvstr .= $row['meetdate'] . ",";
       $csvstr .= $row['text'] . "\r\n";
     }

     //CSV出力
     $fileNm = "customer.csv";
     header('Content-Type: text/csv');
     header('Content-Disposition: attachment; filename='.$fileNm);
     echo mb_convert_encoding($csvstr, "SJIS", "UTF-8"); //Shift-JISに変換したい場合のみ
     exit();

   }catch(ErrorException $ex){
     print('ErrorException:' . $ex->getMessage());
   }catch(PDOException $ex){
     print('PDOException:' . $ex->getMessage());
   }
 }