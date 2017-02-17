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

$QSTRING = $_GET['id_sottodirectory_da'];



echo"<br>";

//sezione visualizzazione proposte

include("db.php");

$query = "SELECT id_directory_da, id_sottodirectory_da, nome_documento, data_inserimento FROM `documentazione_aziendale` WHERE id_sottodirectory_da = $QSTRING ORDER BY nome_documento ASC";

$query_directory = "";

$query_sottodirectory = "";


$result = mysql_query($query);
?>

<table border="1" width = "40%">
<tr bgcolor="#737373" class="White">
<th class="MediumWhite">Nome documento</th>
<th class="MediumWhite">Invia documento</th>

</tr>


<?php
while($query_data = mysql_fetch_array($result)){

    $id_directory_da             = $query_data["id_directory_da"];
    $id_sottodirectory_da             = $query_data["id_sottodirectory_da"];

    $descr_dir = "SELECT descrizione_directory FROM directory WHERE id_directory = $id_directory_da";
    $descrizione_dir =  mysql_query ($descr_dir,$connection);
    $descrizione_direct = mysql_fetch_array($descrizione_dir);
    $descrizione_directory = $descrizione_direct[0];

    $descr_sottodir = "SELECT descrizione_sottodirectory FROM sottodirectory WHERE id_sottodirectory = $id_sottodirectory_da";
    $descrizione_sottodir =  mysql_query ($descr_sottodir,$connection);
    $descrizione_sottodirect = mysql_fetch_array($descrizione_sottodir);
    $descrizione_sottodirectory = $descrizione_sottodirect[0];

    $nome_documento             = $query_data["nome_documento"];
     
    $data_inserimento           = $query_data["data_inserimento"];
    $data_inserimento_it        = giradataMySQL_IT($data_inserimento);

    $dir_da_upload              = $descrizione_directory."/".$descrizione_sottodirectory;
    $link_documento             = "http://www.sisthema.biz/gestdoc/".$descrizione_directory."/".$descrizione_sottodirectory."/".$nome_documento;


    echo "<tr>\n";
    echo "<td width=40% align=left class=\"black\"><a href=\"http://www.sisthema.biz/gestdoc/$dir_da_upload/$nome_documento\" class=\"TinyBlack\" target=\"blank\"><b>$nome_documento</b></a></td>\n";
    echo "<td width=15% align=center class=\"TinyBlack\"><a href=\"mailto:info@sisthema.biz?subject=Invio link documento&body=Questo è il link al documento $link_documento\"><img src=\"img/b_edit.png\"</a></td>\n";
 
    echo "</tr>\n";
  }
?>
</td>
</tr>
</table>
</body>
</html>

