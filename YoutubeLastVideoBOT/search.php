<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<?php session_start(); include("sqlbaglantisi.php"); require('simple_html_dom.php');?>
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
function Subscribe($channelName,$channelLink,$channelPic){
	global $baglan;
	global $veritabani;
	$userID = $_SESSION['Logged'];
	$videosHTML = "https://www.youtube.com".$channelLink."/videos";
	$html = file_get_html($videosHTML);
	$video  = $html->find('div.yt-lockup-content')[0];
	$videoDetails = $video->find('a.yt-uix-sessionlink',0);
	$videoTitle = $videoDetails->title;
	$videoURL = 'https://www.youtube.com/embed/'.substr($videoDetails->href,9).'?rel=0';
	@mysqli_query($baglan,"insert into channels(channelName,channelLink,channelPicture,channelVid) values('$channelName','$channelLink','$channelPic','$videoURL')");
	@mysqli_query($baglan,"insert into users_channels(userID,channelID) values(
	(select userID from users where username = '$userID'),(select channelID from channels where channelName = '$channelName')
	)");
	
}

function Search($searchtext){
$get = str_replace(" ","+",$searchtext);
$search = "https://www.youtube.com/results?sp=EgIQAlAU&search_query=".$get;
$html = file_get_html($search);

$channelInfos = [];
	
$thumb = "data-thumb";
$i = 0;
foreach ($html->find("div.yt-lockup-content") as $channel){
	if ($i > 10){break;}
	
	$picture = $html->find('*[class="yt-thumb video-thumb"]')[$i];
	$img = $picture->find('img',0);
	$imglink = $img->src;
	if(substr($imglink,0,4) == "/yts"){
		$imglink = $img->$thumb;
	}
	$a = $channel->find('a.yt-uix-tile-link',0);
	$channelName = $a->title;
	$channelLink = $a->href;

	?>
	
		<div class="result">
			<form action ="" method="post">
			<img class="photo" src="<?php echo $imglink?>"/>
			<span><?php echo $channelName?> </span>
			<button name="gonder" value="<?php echo $channelName."|".$channelLink."|".$imglink?>"/>Subscribe</button>
			</form>
		</div>
<?php
	$i++;}
	
}
?>

<div id="wrapper">
	<div id="top">
		<div id="logo">
			<a href="main.php"><img src="img/youtube.png"/></a>
		</div>
		<div id="searchbox">
			<form action="search.php" method="get">
				<input type="text" name="searchtext" placeholder="Search a channel"/>
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
			$resimm = mysqli_fetch_array($resim)[0];
			if(empty($resimm)){
				echo '<img src="img/default_user.png" class="photo"/>';
			}else{
				echo '<img src="'.$resimm.'" class="photo"/>';
			}
			?>
				<span class="name"><?php echo ucfirst($_SESSION['Logged']) ?></span>
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
			//@Subscribe($_POST["gonder"]);
			$dd = explode("|",$_POST["gonder"]);
			@Subscribe($dd[0],$dd[1],$dd[2]);
			
		}elseif($_GET){
			@Search($_GET["searchtext"]);
		}else{
			echo "<h1>Lutfen arama yapiniz</h1>";
			//header("refresh:0;url=main.php");
		}
		?>
		</div>
		<div class="clear"></div>
		
	</div>

</div>


</body>
</html>