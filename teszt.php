<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_PARSE);
$kapcsolat = mysqli_connect("localhost","root","");
mysqli_select_db($kapcsolat,"adatok");
?>

<!DOCTYPE html">
<html>

<head>
<title>Feladat</title>
<style>

#usernamerow {
	color: black;
	margin-left: 80px;
	font-style: bold;
	font-size: 24px;
}

#passwordrow {
	color: black;
	margin-left: 80px;
	font-style: bold;
	font-size: 24px;
}

#kotelezo{
	font-size: 22px;
	font-family: Arial;
	text-align: center;
	color: orange;
}

fieldset{
	background-color:red;
}

#elkuldes{
	border:6px solid brown;
	background-color:blue;
	color:white;
	font-style: bold;
	font-size: 24px;
	margin-left: 100px;
	cursor:pointer;
	width: 180px;
	height: 50px;
}

#adataim {
	font-size: 30px;
	color: red;
}

</style>
</head>
<?php
$file = fopen("password.txt", "r");
$emailek = [];
$jelszavak = [];
$emailindex = 0;
$jelszoindex = 0;
while(!feof($file))
	{
$sor=fgets($file);
$decode=array(5,-14,31,-9,3);
$i=0;
$j=0;
$dekodoltszoveg = []; 
$index=0;
	while($sor[$i])
	{
		$karakter=ord($sor[$i]);
		$karakter-=$decode[$j];
		
		$dekodoltszoveg[$index] = chr($karakter);
		$index++;		
		
		$i++;
		$j++;
		if ($j==5)
		$j=0;
	}
	$email = '';
	$jelszo = '';
	for($i = 0; $i < count($dekodoltszoveg); $i++) {
		if($dekodoltszoveg[$i] == '*') {
			for($j = $i+1; $j < count($dekodoltszoveg); $j++) {
				$jelszo .= $dekodoltszoveg[$j];	
			}
			break;
		}
		$email .= $dekodoltszoveg[$i];
	}	
	$emailek[$emailindex] = $email;
	$emailindex++;
	$igazijelszo = mb_substr($jelszo, 0, -1);
	$jelszavak[$jelszoindex] = $igazijelszo;
	$jelszoindex++;
	$email = '';
	$jelszo = '';
}
$beirtemailindex;
	if(in_array($_POST['username'], $emailek)) {
		$beirtemailindex = array_search($_POST['username'], $emailek);
		$seged = 0;		
		if($jelszavak[$beirtemailindex] == $_POST['password']) 
		{			
			$res = mysqli_query($kapcsolat, "SELECT username, titkos FROM adatok.tabla");
					while($row=mysqli_fetch_row($res)){
								
								if($_POST['username']==$row[0]){
									
									switch ($row[1]) {
										case "piros":
											print '<body style="background-color:red">';
											break;
										case "zold":
											print '<body style="background-color:green">';
											break;
										case "sarga":
											print '<body style="background-color:yellow">';
											break;
										case "kek":
											print '<body style="background-color:blue">';
											break;
										case "fekete":
											print '<body style="background-color:black">';
											break;
										case "feher":
											print '<body style="background-color:white">';
											break;
										default:
											print "Nem szerepel ez a szin az adatbazisban!";
									}
									break;
								}
					}
		}
		else 
		{
			print '<meta http-equiv="refresh" content="3;url=http://www.police.hu/">'; 
		}
	}
	else {
		print "<p>nincs ilyen felhasznalo</p>";
	}
fclose($file);
?>

<body>
<p id="adataim"> Kiss Dániel Erik,WAMCFZ</p>
<form method="post" action="teszt.php">
				<fieldset>
						<?php
						if((empty($_POST['username']) || empty($_POST['password']))){
							print "<p id=kotelezo>Minden mező kitöltése kötelező!</p>";
						}
						?>
					<table>
						<tr id=usernamerow>
							<td><label for="username">Felhasználónév</label></td>
							<td><input type="textfield" name="username" id="username" maxlength="40" /></td>
						</tr>
						<tr id=passwordrow>
							<td><label for="password">Jelszó</label></td>
							<td><input type="password" name="password" id="password" maxlength="40" /></td>
						</tr>
						<tr>
							<td><input class="gomb" type="submit" name="elkuldes" id="elkuldes" value="Felküld" /></td>
						</tr>
					</table>
				</fieldset>
</form>
</body>
</html>