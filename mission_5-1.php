<?php
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	
	$sql = "CREATE TABLE IF NOT EXISTS mission51"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "pPassword char(32),"
	. "date TEXT"
	.");";
	$stmt=$pdo->query($sql);
	
    $sql = 'SELECT * FROM mission51';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	   $editNumber=null;
       $editName=null;
       $editComment=null;
       
	foreach ($results as $row){
	    if($row['id']==$_POST["eNumber"]&$row['pPassword']==$_POST["ePassword"]){
	            $editNumber=$row['id'];
	            $editName=$row['name'];
                $editComment=$row['comment'];   
	    }
	}

?>
  
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission5-1</title>
    </head>
<body>
    <form action="" method="POST">
        <input type="hidden" name="edit_post" value="<?php echo $editNumber;?>">
        <input type="string" name="name" placeholder="名前" value="<?php echo $editName;?>">
        <br>
        <input type="comment" name="cmt" size="50" placeholder="コメント"value="<?php echo $editComment;?>">
        <br>
        <input type="string" name="password" placeholder="パスワードを設定">       
        <br>
        <input type="submit" name="submit">
        <br>
        <hr>
        <input type="number" name="eNumber" placeholder="編集したい投稿番号">
        <input type="string" name="ePassword" placeholder="パスワードを入力">
        <input type="submit" name="edit" value="編集">
        <br>
        <input type="number" name="dNumber" placeholder="削除したい投稿番号">
        <input type="string" name="dPassword" placeholder="パスワードを入力">
        <input type="submit" name="delete" value="削除">
        <hr>
        
    </form>
       <p>♪投稿一覧♪<p>

<?php

	
	$name = $_POST["name"];
	$comment = $_POST["cmt"]; 
	$pPassword=$_POST["password"];
    $date=date("Y/m/d H:i:s");
	
	          $dsn = 'mysql:dbname=tb220811db;host=localhost';
   	          $user = 'tb-220811';
	          $password = 'HeT7SUjypm';
	          $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
  if(isset($_POST["submit"]) ){

         if($name!=null||$comment!=null||$pPassword!=null){
         if($_POST["edit_post"]!=null){
             $editid =$_POST["edit_post"]; //変更する投稿番号

	         $sql = 'UPDATE mission51 SET name=:name,comment=:comment,pPassword=:pPassword,date=:date WHERE id=:id';
             $stmt = $pdo->prepare($sql);
	         $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	         $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	         $stmt->bindParam(':pPassword',$pPassword, PDO::PARAM_STR);
	         $stmt->bindParam(':date',$date, PDO::PARAM_STR);
	         $stmt->bindParam(':id', $editid, PDO::PARAM_INT);
	         $stmt->execute();
             
         }
         else{
             $sql = $pdo -> prepare("INSERT INTO mission51 (name, comment,pPassword,date) VALUES (:name, :comment,:pPassword,:date)");
    	      $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	          $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	          $sql -> bindParam(':pPassword', $pPassword, PDO::PARAM_STR);
	          $sql -> bindParam(':date', $date, PDO::PARAM_STR);

	          $sql -> execute();
         }
     }
  }
     
     elseif(isset($_POST["delete"]) ){
            
               $sql = 'SELECT * FROM mission51';
	            $stmt = $pdo->query($sql);
            	$results = $stmt->fetchAll(); 
            	foreach ($results as $drow){
            	    if($drow['id']==$_POST["dNumber"]&$drow['pPassword']==$_POST["dPassword"]){

                         $did=$_POST["dNumber"];
                         $sql = 'delete from mission51 where id=:id';
	                     $stmt = $pdo->prepare($sql);
	                     $stmt->bindParam(':id', $did, PDO::PARAM_INT);
                    $stmt->execute();
            	    }
            	}            	

     }

                  
                  
                  
  	$sql = 'SELECT * FROM mission51';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $pRow){
		//$rowの中にはテーブルのカラム名が入る
		echo $pRow['id'].'  ';
		echo $pRow['name'].'  ';
		echo $pRow['comment'].'  ';
		echo '<'.$pRow['date'].'>'.'<br>';
	}
	
	?>
	
	</body>
</html>