<!DOCTYPE html>

 <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_3-5</title>
    </head>
    <body>

    <?php
        $filename="mission_3-5.txt";
        $date=date("Y/m/d H:i:s");
        $num=count(file($filename))+1;
        
        //新規投稿
        if(!empty($_POST["name"]) && !empty($_POST["str"]) && !empty($_POST["password"])){
            $name=$_POST["name"];
            $str=$_POST["str"];
            $password=$_POST["password"];
            if(empty($_POST["editnum"])){
            $fp=fopen($filename,"a");
            fwrite($fp,$num."<>".$name."<>".$str."<>".$date."<>".$password.PHP_EOL);
            fclose($fp);
        }
        }
        
        
        //編集
        if(!empty($_POST["name"]) && !empty($_POST["str"]) && !empty($_POST["editnum"]) && !empty($_POST["password"])){
            $name=$_POST["name"];
            $str=$_POST["str"];
            $editnum=$_POST["editnum"];
            $password=$_POST["password"];
            $lines=file($filename,FILE_IGNORE_NEW_LINES);
            file_put_contents($filename,"");
            foreach($lines as $line){
                $data=explode("<>",$line);
                if($editnum==$data[0] && $password==$data[4]){
                    $fp=fopen($filename,"a");
                    fwrite($fp,$editnum."<>".$name."<>".$str."<>".$date."<>".$password.PHP_EOL);
                    fclose($fp);
                }else{
                    $fp=fopen($filename,"a");
                    fwrite($fp,$line.PHP_EOL);
                    fclose($fp);
                }
            }
        }    
        
        //削除
        if(!empty($_POST["del"]) && !empty($_POST["password"])){
            $del=$_POST["del"];
            $password=$_POST["password"];
            $lines=file($filename,FILE_IGNORE_NEW_LINES);
            file_put_contents($filename,"");
            foreach($lines as $line){
                $data=explode("<>",$line);
                if($del!=$data[0]){
                    $fp=fopen($filename,"a");
                    fwrite($fp,$line.PHP_EOL);
                    fclose($fp);
                }elseif($password!=$data[4]){
                    $fp=fopen($filename,"a");
                    fwrite($fp,$line.PHP_EOL);
                    fclose($fp);
                }
            }
        }
        
        
        //編集対象をフォームに表示
        if(!empty($_POST["ed"]) && !empty($_POST["password"])){
            $edit=$_POST["ed"];
            $password=$_POST["password"];
            $lines=file($filename,FILE_IGNORE_NEW_LINES);
            foreach($lines as $line){
                $data=explode("<>",$line);
                if($edit==$data[0] && $password==$data[4]){
                    $editnum=$data[0];
                    $editname=$data[1];
                    $editstr=$data[2];
                    $editpass=$data[4];
                }
            }
        }
        
       
        ?>
        
   
        <form action="" method="post">
            <input type="name" name="name" placeholder="名前"
                   value="<?php if(!empty($editname)){echo $editname;} ?>">
            <input type="text" name="str" size="40" placeholder="コメント"
                   value="<?php if(!empty($editstr)){echo $editstr;} ?>">
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
        
        //ファイルに書き込み
        if(file_exists($filename)){
            $lines=file($filename,FILE_IGNORE_NEW_LINES);
            foreach($lines as $line){
                $data=explode("<>" , $line);
                $displays=array($data[0],$data[1],$data[2],$data[3]);
                foreach($displays as $display){
                    echo $display." ";
                }
                echo "<br>";
            }
        }
        
        ?>
        
    </body>
</html>