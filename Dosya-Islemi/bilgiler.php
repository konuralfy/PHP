<html>

<?php $ac=@fopen("bilgiler.txt","r"); ?>

<table border="1" width="50%" align="center">
	<tr>
		<td align="center"><h3><u>Ad Soyad</u></h3></td>
		<td align="center"><h3><u>Yaş</u></h3></td>
		<td align="center"><h3><u>Cinsiyet</u></h3></td>
		<td align="center"><h3><u>Şehir</u></h3></td>
	</tr>
	<?php
		while($goster = @fgetcsv($ac,999,"\t")){
		echo '<tr>';
		$say = count($goster);
		for($i = 0; $i<$say;$i++){
			echo '<td>'.$goster[$i].'</td>';
		}
		echo '</tr>';
	}
	?>
</table>
<br><br>
<form action="kayit.php" align="center"><input type="submit" value="Kayıt Yap"></form>

<form action="" method="post" align="center">
<input type="text" name="sil"/>
<input type="submit" value="Kişiyi Sil"/>
	<?php
		if($_POST){
			foreach(file('bilgiler.txt') as $line){
				$a = explode("\t",$line);
				if ($a[0] == $_POST["sil"]){
					$contents = file_get_contents('bilgiler.txt');
					$contents = str_replace($line, '', $contents);
					file_put_contents('bilgiler.txt', $contents);
				}
			}
			
		}
	
	?>
</form>


</html>