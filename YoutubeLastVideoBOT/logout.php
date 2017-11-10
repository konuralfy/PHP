<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<title>Logout</title>
</head>
<?php
session_start();
session_destroy();
header("refresh:2;url=index.php");
?>
<body>
	<h1 style='text-align:center; color:red; font-size:40px; margin-top:70px;'>Oturumunuz sonlandirildi.</h1>
	<p style='text-align:center; color:white;'>Yonlendiriliyorsunuz...</p>

</body>
</html>
