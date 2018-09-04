 	<?php

header("Content-Type: text/html; charset=UTF-8");
ini_set('display_errors', "On");

	$dsn = "bt";
	$user = "todotaro";
	$password = "a";
	$pdo = new PDO($dsn,$user,$password);

	$sql = "CREATE TABLE sample8"
	."("
	."id INT AUTO_INCREMENT PRIMARY KEY,"
	."name char(32),"
	."comment TEXT,"
	."password TEXT,"
	."created_on DATETIME"
	.");";
	$stmt = $pdo->query($sql);

	$sql = "SHOW TABLES";
	$result = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row){
		echo $row[0];
		echo "<br>";
	}
	echo "<hr>";

	$sql = "SHOW CREATE TABLE sample8";
	$result = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	foreach((array)$result as $row){
		print_r($row);
	}
	echo "<hr>";
        
	
        $DATETIME = new DateTime();
	$DATETIME = $DATETIME->format('Y-m-d H:i:s');
	$edit = $_POST['edino2'];
	$edit2 = $_POST['edino2'];
	
	 
	if ($_POST['name'] && empty($edit2) ) {

	$id = NULL;
	$sql = $pdo->prepare("INSERT INTO sample8(id,name,comment,created_on,password) VALUES (:id,:name,:comment,:created_on,:password)");
	$sql->bindParam(":name",$_POST['name'],PDO::PARAM_STR);
	$sql->bindParam(":comment",$_POST['comment'],PDO::PARAM_STR);
	$sql->bindParam(":password",$_POST['pass'],PDO::PARAM_STR);
	$sql->bindValue(":created_on",$DATETIME,PDO::PARAM_STR);
	$sql->bindValue(':id', $id, PDO::PARAM_INT);
	$sql -> execute();
	 }

	

	if ($_POST['pass'])  {
	$sql = 'SELECT*FROM sample8 where id = :pass_id';
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(':pass_id', $id, PDO::PARAM_INT);
	$stmt -> execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	$normal_pass = $result['password'];
	//var_dump($normal_pass);
	}



		
	$sql = 'SELECT*FROM sample8 where id = :edit_id';
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(':edit_id', $_POST['edino2'], PDO::PARAM_INT);
	$stmt -> execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	$edit3 = $result['password'];
	//var_dump($edit3);
	
	
		
	$sql = 'SELECT*FROM sample8 where id = :delete_id';
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(':delete_id', $_POST['delete'], PDO::PARAM_INT);
	$stmt -> execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	$del_target_pass = $result['password'];
	


		if ($_POST['edino'])  {
	$sql = 'SELECT*FROM sample8 where id = :normal_id';
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(':normal_id', $_POST['edino'], PDO::PARAM_INT);
	$stmt -> execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	$edit_name = $result['name'];
	$edit_comment = $result['comment'];
	$edit_password = $_POST['edikey'];

	}

	


	if ($_POST['delete'] && $del_target_pass == $_POST['delkey'])  {
	$sql = 'DELETE FROM sample8 where id = :delete_id';
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(':delete_id', $_POST['delete'], PDO::PARAM_INT);
	$stmt -> execute();
	 
	

	}
	
	if ( $_POST['pass'] == $edit3  && $_POST['mode'] == 'editmode') {
	$sql = 'update sample8 set name =:name, comment =:comment   where id = :value';
	$stmt = $pdo -> prepare($sql);
	$stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
	$stmt->bindParam(':comment', $_POST['comment'], PDO::PARAM_STR);
	$stmt->bindValue(':value',$_POST['edino2'], PDO::PARAM_INT);
	$stmt->execute();
	}




	 
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="uft-8">
<title>POST_SAMPLE</title>
</head>
<body>
<form method="POST" action="mission_4-1.php">
	名前：<input type="text" name="name" value="<?php echo $edit_name; ?>" />
<br/>
コメント：<input type="text" name="comment" value="<?php echo $edit_comment; ?>" />
<br/>
<?php
if($_POST['edino']){
  $edino = $_POST['edino'];
  $edit_editer = $_POST['edino'];
echo '<input type="hidden" name="mode" value="editmode">';
echo '編集番号<input type="text" name="edino2" value ="'.$edit_editer.'"> ';
}
?>
パスワード：<input type="password" name="pass" value="<?php echo $edit_password; ?>" >	
<input type="submit" value="送信" /></br>


  

<br/><br/>削除指定番号：<input type="text" name="delete" >
パスワード: <input type="password" name="delkey">
<input type="submit" value="削除"><br/>



編集指定番号：<input type="text" name="edino">
　パスワード: <input type="password" name="edikey">
　<input type="submit" name="edit" value="編集">
</form>




<?php
	$sql = "SELECT*FROM sample8";
	$results = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	foreach((array)$results as $row){
		echo $row['id'].",";
		echo $row['name'].",";
		echo $row['comment'].",";
		echo $row['created_on'].'<br>';
		
	}




?>