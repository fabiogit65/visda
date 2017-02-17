<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
        <title>Gestione proposte Sisthema s.r.l.</title>
	<link rel="stylesheet" href="css/style_ie.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />



</head>

<center>
<body topmargin="0">

<div><img src=img/Header_sisthema.jpg width="100%" height="150">
</center>
<br>
<left>
<a href="index.html" class="linkmenu"><b>>> HOME</b></a>
<input type="button" value="Indietro" onClick="javascript:history.back()" name="button">
</left>
<center>


<br>
<?php
include("db.php");
include("functions.php");

echo "<font face=\"arial\" size=\"4\"><b>Form di visualizzazione documentazione</b></font>";
echo "<br>";
echo "<br>";




echo"<br>";

//sezione visualizzazione proposte

include("db.php");

$query = "SELECT distinct(descrizione_directory), id_directory_da FROM `documentazione_aziendale`, directory, sottodirectory WHERE id_directory = `id_directory_da` ORDER BY descrizione_directory ASC";

$result = mysql_query($query);
?>

<table width = "30%" bordercolor=\"ffffff\">

<?php
while($query_data = mysql_fetch_array($result)){
    $descrizione_directory      = $query_data["descrizione_directory"];
    $id_directory_da      = $query_data["id_directory_da"];
     
    echo "<tr>\n";
    echo "<td width=30% align=center class=\"black\"><b><img src=\"img/icona_folder.png\"></b></td>\n"; 
    echo "</tr>\n";

    echo "<tr>\n";
    echo "<td width=30% align=center class=\"black\"><b><a href=\"visualizza_sottodir.php?id_directory_da=$id_directory_da\" class=\"Black\">$descrizione_directory</a></b></td>\n"; 
    echo "</tr>\n";
  }
?>
</td>
</tr>
</table>
</body>
</html>

