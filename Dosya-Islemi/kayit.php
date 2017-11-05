<?php

echo '
<form action="" method="post">
<table cellpadding="5"cellspacing="5" align="center">
	<h1 align="center">Kayıt Formu</h1>
	<tr>
		<td>Ad Soyad:</td>
		<td><input type="text" name="adsoyad"/></td>
	</tr>
	<tr>
		<td>Yaş:</td>
		<td><input type="text" name="yas"/></td>
	</tr>
	<tr>
		<td>Şehir:</td>
				<td><select name="sehir">
			<option value="Istabul">İstanbul</option>
			<option value="Izmir">İzmir</option>
			<option value="Ankara">Ankara</option>
			<option value="Eskisehir">Eskişehir</option>
		</select></td>
	</tr>
	<tr>
		<td>Cinsiyet:</td>
		<td>
			<input type="radio" name="cinsiyet" value="Erkek"/>Erkek
			<input type="radio" name="cinsiyet" value="Kadin"/>Kadın
		</td>
	</tr>
	<tr>
		<td></td>
		<td align="left"><input type="submit" name="gonder" value="Kaydet"/></td>
	</tr>
</table>
</form>
<form action="bilgiler.php" align="center"><input type="submit" value="Bilgileri Göster"></form>
';

if($_POST){
	$adsoyad= $_POST["adsoyad"];
	$yas = $_POST["yas"];
	$cinsiyet = $_POST["cinsiyet"];
	$sehir = $_POST["sehir"];
	
	$ac = fopen("bilgiler.txt","a");
	fwrite($ac,$adsoyad."\t".$yas."\t".$cinsiyet."\t".$sehir."\r\n");
	fclose($ac);
}










?>