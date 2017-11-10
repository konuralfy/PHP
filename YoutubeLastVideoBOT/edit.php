<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<?php session_start(); include("sqlbaglantisi.php"); include("simple_html_dom.php"); ?>
</head>
<body>
	<?php
	if(!isset($_SESSION['Logged'])) {
		echo "<h1 	style='text-align:center;
				color:red;
				font-size:40px;
				margin-top:70px;'>Lutfen ilk once giris yapiniz.</h1>";
				echo "<p style='text-align:center; color:white;'>Yonlendiriliyorsunuz...</p>";
				header("refresh:2;url=index.php");
	  die(); 
	}else{
		$now = time();
		if ($now > $_SESSION['expire']){
			session_destroy();
			echo "<h1 	style='text-align:center;
			color:red;
			font-size:40px;
			margin-top:70px;'>Oturumunuz sona erdi. Lutfen giris yapiniz</h1>";
			echo "<p style='text-align:center;color:white;'>Yonlendiriliyorsunuz...</p>";
			header("refresh:2;url=index.php");	
			die('');
		}
	}
	?>
<div id="wrapper">
	<div id="top">
		<div id="logo">
			<a href="main.php"><img src="img/youtube.png"/></a>
		</div>
		<div id="searchbox">
			<form action="search.php" method="get">
				<input type="text" name="searchtext"/>
			</form>
		</div>
		<div id="exit">
			<a href="logout.php">Logout</a>
		</div>
	</div>
	<div id="content">
	
	
		<div id="left-div">
			<div id="pic-name">
				<?php 
				$ad = $_SESSION['Logged']; 
				global $baglan;
				global $veritabani; 
				$resim  = @mysqli_query($baglan,"select userPicture from users where username = '$ad' ");
				?>
				<img  src="<?php echo mysqli_fetch_array($resim)[0]?>" class="photo"/>
				<span class="name"><?php echo ucfirst($_SESSION['Logged'])?></span>
			</div><hr style="border-color:red;"/>
			<span class="name" style="color:grey;">Subscriptions</span>
			<div id="Subscriptions">
				<div id="miniphotos">
					<?php
					global $baglan;
					global $veritabani;
					$Logged = $_SESSION['Logged'];
					$userIDquery  = @mysqli_query($baglan, "select userID from users where userName= '$Logged' ");
					$userID = mysqli_fetch_array($userIDquery)[0];
					$channelIDquery = mysqli_query($baglan,"select channelID from users_channels where userID= '$userID' ");
					while($row = mysqli_fetch_array($channelIDquery)){
						$picture = @mysqli_query($baglan,"select channelPicture from channels where channelID = '$row[0]'");
						$name = @mysqli_query($baglan,"select channelName from channels where channelID = '$row[0]'");?>
						
							<div class="channel-profiles">
								<img class="photo" src="<?php echo mysqli_fetch_array($picture)[0]?>"/>
								<span><?php echo mysqli_fetch_array($name)[0] ?></span>
							</div>
					<?php
					}
					?>
					
				</div>
			</div>
		</div>
		
		
		
		<div id="right-div">
			<?php
			if($_POST){
				$session = $_SESSION['Logged'];
				if(!empty($_POST["username"])){
					$isim = $_POST["username"];
					@mysqli_query($baglan,"update users set username='$isim' where username = '$session' ");
					$_SESSION['Logged'] = $isim;
					$session = $isim;
				}
				if(!empty($_POST["password"])){
					$pass = $_POST['password'];
					@mysqli_query($baglan,"update users set password='$pass' where username = '$session'");
				}
				if(!empty($_POST["delete"])){
					foreach($_POST['delete'] as $ch){
						@mysqli_query($baglan,"delete from users_channels where channelID = (select channelID from channels where channelname = '$ch') and userID = (select userID from users where username='$session')");
					}
				}
				if(!empty($_FILES["profilepicture"]["name"])){
					$dosyaUzantisi = substr($_FILES["profilepicture"]["name"],-4,4);
					$dosyaAdi = $session.$dosyaUzantisi;
					$dosyaYolu = "img/profile_pictures/".$dosyaAdi;
					$type= $_FILES["profilepicture"]["type"];
					if ($type == "image/jpeg" || $type=="image/png" || $type=="image/gif"){
						move_uploaded_file($_FILES["profilepicture"]["tmp_name"],$dosyaYolu);
					}
					@mysqli_query($baglan,"update users set userPicture='$dosyaYolu' where username='$session'");
				}
			}else{?>
			<form action="" method="post" enctype="multipart/form-data">
				<div id="edit">
					<div class="edit1">
					<span>Change Username</span><br/><input type="text" name="username"/>
					</div>
					<div class="edit1">
					<span>Change Password</span><br/><input type="text" name="password"/>
					</div>
					<div class="edit1">
					<label for="profilepicture"><span>Choose Picture</span></label><br/><input type="file" id="profilepicture" name="profilepicture" style="display:none;"/>
					</div>
				</div>
				<span class="name" style="color:grey;clear:both; margin-left:270px;">Delete Channels</span>
				<div id="miniphotos" style="overflow-y: scroll; height:350px; width:300px; background-color:rgb(33,33,33);margin-left:200px;">
					<?php
					global $baglan;
					global $veritabani;
					$Logged = $_SESSION['Logged'];
					$userIDquery  = @mysqli_query($baglan, "select userID from users where userName= '$Logged' ");
					$userID = mysqli_fetch_array($userIDquery)[0];
					$channelIDquery = mysqli_query($baglan,"select channelID from users_channels where userID= '$userID' ");
					while($row = mysqli_fetch_array($channelIDquery)){
						$picture = @mysqli_query($baglan,"select channelPicture from channels where channelID = '$row[0]'");
						$name = @mysqli_query($baglan,"select channelName from channels where channelID = '$row[0]'");
						$isim = mysqli_fetch_array($name)[0];
						?>
							<div class="channel-profiles">
								<img class="photo" src="<?php echo mysqli_fetch_array($picture)[0];?>"/>
								<span><?php echo $isim ?></span>
								<input type="checkbox" name="delete[]" value="<?php echo $isim ?>" style="float:right;margin-top:13px;"/>
							</div>
					<?php
					}
					?>
					
				</div>
				<input type="submit" value="Save Changes" style="float:right;margin-right:345px;margin-top:40px;height:34px;border-radius:7px; border:1px solid RGB(33,33,33);color:white;background-color:rgb(33,33,33);box-shadow:3px 3px 3px 3px black;"/>
			</form>
			<?php } ?>
		</div>
		<div class="clear"></div>
		
	</div>

</div>


</body>
</html>