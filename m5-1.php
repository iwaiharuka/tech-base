<!DOCTYPE html>

<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_5-1</title>
    </head>
    <body>

<?php

//データベース接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//テーブル作成
$sql="CREATE TABLE IF NOT EXISTS mission5"
    ." ("
    ."id INT AUTO_INCREMENT PRIMARY KEY,"
    ."name char(32),"
    ."comment TEXT,"
    ."password TEXT,"
    ."date DATETIME"
    .");";
    $stmt = $pdo->query($sql);

//新規投稿
if(!empty($_POST["name"]) && !empty($_POST["comment"] 
   && empty($_POST["editnum"]) && !empty($_POST["password"]))){
    $sql=$pdo -> prepare("INSERT INTO mission5 (name, comment, password, date) VALUES (:name, :comment, :password, :date)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $name=$_POST["name"];
    $comment=$_POST["comment"];
    $password=$_POST["password"];
    $date=date("Y-m-d H:i:s");
    $sql -> execute();
}

//編集
if(!empty($_POST["editnum"]) && !empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])){
    $editnum=$_POST["editnum"];
    $password=$_POST["password"];
    //編集対象のデータを抽出
    $id=$_POST["editnum"];
    $sql = 'SELECT * FROM mission5 WHERE id=:id ';
    $stmt = $pdo->prepare($sql);                  
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(); 
    foreach ($results as $row){
    //IDと編集番号、パスワードが一致していたら編集実行
        if($row['id']==$editnum && $row['password']==$password){
            $id=$_POST["editnum"];
            $name=$_POST["name"];
            $comment=$_POST["comment"];
            $password=$_POST["password"];
            $date=date("Y-m-d H:i:s");
            $sql = 'UPDATE mission5 SET name=:name,comment=:comment,password=:password,date=:date WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt ->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt ->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
    }
}

//削除 
if(!empty($_POST["del"]) && !empty($_POST["password"])){
    $del=$_POST["del"];
    $password=$_POST["password"];
    //削除対象を抽出
    $id=$_POST["del"];
    $sql = 'SELECT * FROM mission5 WHERE id=:id ';
    $stmt = $pdo->prepare($sql);                  
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(); 
    foreach ($results as $row){
    //IDと削除番号、パスワードが一致しているか
        if($row['id']==$del && $row['password']==$password){
            $id=$_POST["del"];
            $sql = 'delete from mission5 where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();  
            }
        }
}

//編集対象をフォームに表示
if(!empty($_POST["ed"]) && !empty($_POST["password"])){
    $ed=$_POST["ed"];
    $password=$_POST["password"];
    //編集対象を抽出
    $id=$_POST["ed"];
    $sql = 'SELECT * FROM mission5 WHERE id=:id ';
    $stmt = $pdo->prepare($sql);                  
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //編集対象とID、パスワードが合っていたら表示
        if($row['id']==$ed && $row['password']==$password){
            $editnum=$row['id'];
            $editname=$row['name'];
            $editcomment=$row['comment'];
            $editpass=$row['password'];
        }
    }   
}

?>

<form action="" method="post">
    <input type="name" name="name" placeholder="名前"
        　 value="<?php if(!empty($editname)){echo $editname;} ?>">
    <input type="text" name="comment" size="40" placeholder="コメント"
        　 value="<?php if(!empty($editcomment)){echo $editcomment;} ?>">
    <input type="hidden" name="editnum"
           value="<?php if(!empty($_POST["edit"])){echo $editnum;} ?>">
    <input type="password" name="password" placeholder="パスワード"
           value="<?php if(!empty($editpass)){echo $editpass;} ?>"> 
    <input type="submit" name="submit" value="送信">
</form>
<br>
<form action="" method="post">
    <input type="number" name="del" placeholder="削除対象番号" >
    <input type="password" name="password" placeholder="パスワード">
    <input type="submit" name="delate" value="削除">
</form>
<br>
<form action="" method="post">
    <input type="number" name="ed" placeholder="編集対象番号">
    <input type="password" name="password" placeholder="パスワード">
    <input type="submit" name="edit" value="編集">
</form>
<br>

<?php

//ブラウザに表示
$sql = 'SELECT * FROM mission5';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
    echo $row['id'].',';
    echo $row['name'].',';
    echo $row['comment'].',';
    echo $row['date'].'<br>';
    echo "<hr>";
    }

?>

    </body>
</html>