<html>
<head>
        <title>Gestione proposte Sisthema s.r.l.</title>
        <link rel="stylesheet" href="css/style_ie.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />

	<style type="text/css">
        tr:hover {
            background-color: #F5F5DC;
        }

    </style>

<script type="text/javascript">
var selected = 0;

function selectLine(x)
{
var currRow = document.getElementById("row"+x);
if (selected != 0)
{
var selectedRow = document.getElementById("row"+selected);
selectedRow.style.backgroundColor='#ccc777';
}

currRow.style.backgroundColor='#cccccc';
selected = x;
}
</script>

</head>

<center>
<body topmargin="0">

<div><img src=img/Header_sisthema.jpg width="100%" height="150">
</center>
<br>
<left>
<a href="index.html" class="linkmenu"><b>>> HOME</b></a>      <input type="button" value="indietro" onClick="javascript:history.back()">
</left>
<center>
<br><br>


<?php

include("db.php");
include("functions.php");

$data_odierna = date("Y-m-d");


echo "<form action=\"agenda_ts.php\" method=\"post\" name=\"form1\" id=\"form1\">";

echo "<table>";


$seleziona_tecnico = "SELECT id_tecnici,nome,cognome FROM tecnici WHERE stato_disponibilita <> 'NON ATTIVO'ORDER BY cognome ASC";
$ris_tecnico =  mysql_query ($seleziona_tecnico,$connection);
         echo "<tr><td class=\"TinyBlack\"><font face=\"Arial\" size=\"2\"><b>Seleziona tecnico</b></font></td> <td class=\"TinyBlack\" width=\"65%\"><select name=id_tecnici class=TinyBlack>";
         while ($riga_tecnico = mysql_fetch_array($ris_tecnico)){
         $id_tecnici=$riga_tecnico[0];
         $nome=$riga_tecnico[1];
         $cognome=$riga_tecnico[2];
        if ($nome == $riga_tecnico[1] )
        {
            echo "<option value=$id_tecnici selected >$id_tecnici - $nome $cognome";
        }
        else
        {
            echo "<option value=$id_tecnici>$id_tecnici - $nome $cognome";
        }
}
         echo "</select></td></tr>";

$seleziona_proposta = "SELECT id_proposte,nome_proposta,nome FROM proposte,clienti WHERE proposte.id_cliente = clienti.id_clienti ORDER BY nome ASC";
$ris_proposta =  mysql_query ($seleziona_proposta,$connection);
         echo "<tr><td class=\"TinyBlack\"><font face=\"Arial\" size=\"2\"><b>Seleziona proposta</b></font></td> <td class=\"TinyBlack\" width=\"65%\"><select name=id_proposte class=TinyBlack>";
         while ($riga_proposta = mysql_fetch_array($ris_proposta)){
         $id_proposte=$riga_proposta[0];
         $nome_proposta=$riga_proposta[1];
         $nome_cliente=$riga_proposta[2];
        if ($nome_proposta == $riga_proposta[0] )
        {
            echo "<option value=$riga_proposta[0] selected >$id_proposte - $nome_proposta - $nome_cliente";
        }
        else
        {
            echo "<option value=$riga_proposta[0]>$id_proposte - $nome_proposta - $nome_cliente";
        }
}
         echo "</select></td></tr>";

echo "<tr><td width=\"35%\"><font face=\"Arial\" size=\"2\"><b>Giorni stimati (*)</b></font></td><td width=\"65%\"> <input type=\"text\" name=\"giorni_stimati\" size=\"4\"></td></tr>";

echo "<tr><td height=\"20\"></td></tr></table>";

$seleziona_strumento = "SELECT id_registro,strumento,costruttore,codice_sisthema,numero_di_serie FROM registro_strumenti_sisthema WHERE status_strumento ='disponibile'  ORDER BY codice_sisthema ASC";
$ris =  mysql_query ($seleziona_strumento,$connection);
         
         echo "<font face=Arial size=2><b>Numero di strumenti disponibili per la prenotazione: ";
         $numero_righe = mysql_num_rows($ris);
         echo $numero_righe;
         echo "</b></font><br><br>";


?>
         <table border="1" width = "90%">
         <tr bgcolor="#737373" class="White">
         <th class="MediumWhite">Id registro</th>
         <th class="MediumWhite">Strumento</th>
         <th class="MediumWhite">Costruttore</th>
         <th class="MediumWhite">Codice Sisthema</th>
         <th class="MediumWhite">Numero di serie</th>
         <th class="MediumWhite">Seleziona</th>
         </tr> 

<?php

         while($riga = mysql_fetch_array($ris)){;
         $id_registro=$riga[0];
         $strumento=$riga[1];
         $costruttore=$riga[2];
         $codice_sisthema=$riga[3];
         $numero_di_serie=$riga[4];

//         echo "<tr onclick=\"this.style.backgroundColor=\'#fffddd\',onblur=\"this.style.backgroundColor=\'#ccccc\'>\n";

         echo "<tr>\n";
         echo "<td class=\"TinyBlack\">$id_registro</td>";
         echo "<td class=\"TinyBlack\">$strumento</td>";
         echo "<td class=\"TinyBlack\">$costruttore</td>";
         echo "<td class=\"TinyBlack\">$codice_sisthema</td>";
         echo "<td class=\"TinyBlack\">$numero_di_serie</td>";
         echo "<td><input type=checkbox name=selected[] value=$id_registro onclick=\"selectLine(this.id);\">";

         echo "</tr>\n";
         
}

echo "</table>";


echo "<tr><td height=\"20\"></td></tr><br>";
echo "<tr><td width=\"35%\"><font face=\"Arial\" size=\"2\"><input type=\"button\" value=\"indietro\" onClick=\"javascript:history.back()\">   <input type=\"submit\" name=\"salva\" value=\"inserisci correlazione\"></td></tr></form>";

$salva = $_POST[salva];
$selected = $_POST['selected'];
$piace = $_POST['piace'];
$giorni_stimati = $_POST[girni_stimati];
$id_strumento = $_POST[id_registro];
$id_tecnico = $_POST[id_tecnici];
$id_proposta = $_POST[id_proposte];
$data_richiesta = date("Y-m-d");
$giorni_stimati = $_POST[giorni_stimati];
$id_registro_strumento = $id_strumento;


if ($salva && $giorni_stimati !=''){

$seleziona_nome_tecnico = "SELECT nome,cognome FROM tecnici WHERE id_tecnici = $id_tecnico";
$ris_nome_tecnico =  mysql_query ($seleziona_nome_tecnico,$connection);
$riga = mysql_fetch_array($ris_nome_tecnico);
$nome_tecnico = $riga["nome"];
$cognome_tecnico = $riga["cognome"];
$nominativo_tecnico = $nome_tecnico." ".$cognome_tecnico;

if(!($selected)){ 
//Vedo se ha cliccato su qualche checkbox;

echo "Vai a farti un giro in bicicletta."; //In caso positivo lo mando a farsi un giro in bicicletta
 } else { //Sennò
$nselected = count ($selected); //Utilizzo count per contare il numero di valori contenuti nell'array
for($i=0; $i<$nselected; $i++){
echo('id_strumento ' . $selected[$i]);

$dati = " INSERT INTO agenda_strumento_tecnico VALUES ('','$id_tecnico','$selected[$i]','$id_proposta','$data_richiesta','$giorni_stimati')";
echo $dati;
mysql_query($dati,$connection)
or die ("non sono riuscito " );


//} //Chiudo il for
//} //Chiudo l'if


if ($nome_tecnico == 'MANUTENZIONE'){
$aggiornamento_status_strumento = "UPDATE registro_strumenti_sisthema set status_strumento = 'Manutenzione',luogo_strumento = '$nominativo_tecnico' WHERE id_registro = $selected[$i]";
}

if ($nome_tecnico == 'TARATURA'){
$aggiornamento_status_strumento = "UPDATE registro_strumenti_sisthema set status_strumento = 'Prenotato',luogo_strumento = '$nominativo_tecnico' WHERE id_registro = $selected[$i]";
}

if (($nome_tecnico != 'TARATURA') && ($nome_tecnico !='MANUTENZIONE')){
$aggiornamento_status_strumento = "UPDATE registro_strumenti_sisthema set status_strumento = 'Prenotato',luogo_strumento = '$nominativo_tecnico' WHERE id_registro = $selected[$i]";
}

//echo $aggiornamento_status_strumento;


mysql_query($aggiornamento_status_strumento,$connection)
or die ("non sono riuscito " );
} //Chiudo il for
} //Chiudo l'if

//mysql_close ($connection);

echo  "<meta http-equiv=refresh content=0;url=controlla_tec_strumenti.php?id_tecnico=$id_tecnico>";
}
 
echo "</table>";
echo"<br><br>";

?>

</body>
</html>

