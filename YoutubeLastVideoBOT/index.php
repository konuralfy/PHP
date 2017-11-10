<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<?php session_start();?>
</head>
<body>
<?php
include("sqlbaglantisi.php"); 
function Login($username, $password){
	global $baglan;
	global $veritabani;
	$passSelect = @mysqli_query($baglan,"SELECT password FROM users WHERE username = '$username'");
	if($password == mysqli_fetch_array($passSelect)[0]){
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
		if(Login($_POST["username"],$_POST["password"])){
			$_SESSION['Logged'] = $_POST["username"];
			$_SESSION['expire'] = time() + (15*30);
			echo "<h1 	style='text-align:center;
			color:red;
			font-size:40px;
			margin-top:70px;'>Hosgeldiniz ".$_POST["username"]."</h1>";
			echo "<p style='text-align:center;color:white;'>Yonlendiriliyorsunuz...</p>";
			header("refresh:2;url=main.php");
		}else{
		echo "<script type='text/javascript'> alert('Hatali Giris');</script>";
		header("refresh:0;url=index.php");
		}
	}
	
}else{
	if(isset($_SESSION['Logged'])){
		header("refresh:0;url=main.php");
	}else{
		echo '
		<form action ="" method="post">
			<div id="login" style="background-color:rgb(77,77,77);">
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
				<input style="width:80px;margin-top:20px; margin-left:110px; border-radius:8px; height:30px;box-shadow:0 0 3px 2px red; color:red; font-weight:bold; background-color:white;" type="submit" value="Login"/><br/>
				<a href="register.php" style="float:right;">Sign Up</a>
			</div>
		</form>
	';}
	
}

?>
</body>
</html>