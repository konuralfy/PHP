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
			die();
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
		<a href = "edit.php" style="float:left;margin-left:80px;margin-top:20px; width:100px;
								height:35px;
								text-decoration:none;
								font-family:Verdana, Geneva, sans-serif;
								font-size:17px;
								line-height:33px;
								text-align:center;
								display:block;
								background-color:rgb(77,77,77);
								border-radius:5px;
								color:White;
	box-shadow:3px 3px 3px 1px red;">Edit Profile </a>
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
			$resimm = mysqli_fetch_array($resim)[0];
			if(empty($resimm)){
				echo '<img src="img/default_user.png" class="photo"/>';
			}else{
				echo '<img src="'.$resimm.'" class="photo"/>';
			}
			?>
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
						$name = @mysqli_query($baglan,"select channelName from channels where channelID = '$row[0]'");
						$channelLink = @mysqli_query($baglan,"select channelLink from channels where channelID = '$row[0]'");
						$videosHTML = "https://www.youtube.com".mysqli_fetch_array($channelLink)[0]."/videos";
						$html = file_get_html($videosHTML);
						$video  = $html->find('div.yt-lockup-content')[0];
						$videoDetails = $video->find('a.yt-uix-sessionlink',0);
						$videoTitle = $videoDetails->title;
						$videoURL = 'https://www.youtube.com/embed/'.substr($videoDetails->href,9).'?rel=0';
						$fetch= mysqli_fetch_array($name)[0];
						@mysqli_query($baglan,"update channels set channelVid = '$videoURL' where channelName = '$fetch' ");
						?>
						
							<div class="channel-profiles">
								<img class="photo" src="<?php echo mysqli_fetch_array($picture)[0]?>"/>
								<span><?php echo $fetch ?></span>
							</div>
					<?php
					}
					?>
					
				</div>
			</div>
		</div>
		
		
		
		<div id="right-div">
			<?php
				$channelIDquery = mysqli_query($baglan,"select channelID from users_channels where userID= '$userID' ");
				while($row = mysqli_fetch_array($channelIDquery)){
					$picture = @mysqli_query($baglan,"select channelPicture from channels where channelID = '$row[0]'");
					$name = @mysqli_query($baglan,"select channelName from channels where channelID = '$row[0]'");
					$vid = @mysqli_query($baglan,"select channelVid from channels where channelID = '$row[0]'");?>
					<div class="post">
						<div class="post-pic-name">
							<img src="<?php echo mysqli_fetch_array($picture)[0]?>" class="photo"/><span><?php echo mysqli_fetch_array($name)[0]?></span>
						</div>
						<iframe width="560" height="315" src="<?php echo mysqli_fetch_array($vid)[0]?>" frameborder="0" allowfullscreen></iframe>
					</div>
					<?php
					}
					?>

		</div>
		<div class="clear"></div>
		
	</div>

</div>


</body>
</html>