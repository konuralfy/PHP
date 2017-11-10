<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<title> Register</title>
</head>
<body>
<?php
include("sqlbaglantisi.php"); 
function Register($username,$password){
	global $baglan;
	global $veritabani;
	$username = $_POST["username"];
	$password = $_POST["password"];
	if(@mysqli_query($baglan,"insert into users(username,password) values('$username','$password')")){
		return true;
	}else{
		return false;
	}
	
	
}
if($_POST){
	if(empty($_POST["username"]) || empty($_POST["password"])){
		echo "<script type='text/javascript'> alert('Lutfen Bos Alan Birakmayiniz');</script>";
		header("refresh:0;url=index.php");
	}else{
		if(Register($_POST["username"],$_POST["password"])){
			echo "<h1 style='text-align:center;
			color:red;
			font-size:40px;
			margin-top:70px;'>Kayit Islemi Basariyla Gerceklesti</h1>";
			echo "<p style='text-align:center;'>Yonlendiriliyorsunuz...</p>";
			header("refresh:2;url=index.php");
		}else{
		echo "<script type='text/javascript'> alert('Bu kullanici adi zaten var.');</script>";
		header("refresh:0;url=register.php");
		}
	}
	
}else{
	echo '
	<h1 style="text-align:center;color:red;font-family:Arial Black">Sign Up!</h1>
	<form action ="" method="post">
		<div id="login">
			<div id="youtube">
				<img height="100" width ="200" src="img/youtube.png"/>
			</div>
			<div id="username">
				<img height="50" width ="50" src="img/user.png"/>
				<input type="text" name="username" class="user-password" placeholder="Username"/><br/>
			</div>
			<div id="password">
				<img height ="50" width="50" src="img/password.png"/>
				<input type="password" name="password" class="user-password" placeholder="Password"/>
			</div>
			<input style="width:80px;margin-top:20px; margin-left:110px; border-radius:8px; height:30px;box-shadow:0 0 3px 2px red; color:red; font-weight:bold; background-color:white;" type="submit" value="Sign Up"/><br/>
		</div>
	</form>
	';
	
}

?>
</body>
</html>