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
<a href="index.html" class="linkmenu"><b>>> HOME </b></a>
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

$QSTRING = $_GET['id_directory_da'];



echo"<br>";

//sezione visualizzazione proposte

include("db.php");

$query = "SELECT distinct(descrizione_sottodirectory), id_sottodirectory_da  FROM `documentazione_aziendale`, sottodirectory WHERE id_directory_da = $QSTRING  and id_sottodirectory = id_sottodirectory_da ORDER BY descrizione_sottodirectory ASC ";

$result = mysql_query($query);
?>

<table  width = "30%">

<?php
while($query_data = mysql_fetch_array($result)){
    $descrizione_sottodirectory = $query_data["descrizione_sottodirectory"];
    $id_sottodirectory_da = $query_data["id_sottodirectory_da"];

    echo "<tr>\n";
    echo "<td width=30% align=center class=\"black\"><b><img src=\"img/icona_folder.png\"</b></td>\n";
    echo "</tr>\n";

    echo "<tr>\n";
    echo "<td width=30% align=center class=\"black\"><a href=\"visualizza_documenti_interni.php?id_sottodirectory_da=$id_sottodirectory_da\"><b>$descrizione_sottodirectory</b></a></td>\n";
    echo "</tr>\n";

  }
?>
</td>
</tr>
</table>
</body>
</html>

