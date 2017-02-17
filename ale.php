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


echo "<form action=\"ale.php\" method=\"post\" name=\"form1\" id=\"form1\">";

echo "<table>";


    $QSTRING = $_GET['id'];

    if ($QSTRING){
    $seleziona_key = "SELECT id_tecnici,nome,cognome FROM tecnici WHERE key_unique = $QSTRING";
    $key_record =  mysql_query ($seleziona_key,$connection);
    $dati_key = mysql_fetch_array($key_record);
    $id_tecnici = $dati_key[0];
    $nome       = $dati_key[1];
    $cognome    = $dati_key[2];
    echo $id_tencici;
    }
echo "<tr><td class=\"TinyBlack\"><font face=\"Arial\" size=\"2\"><b>Nome tecnico</b></td><td class=\"TinyBlack\"><b>$nome $cognome</b></td>";

//************************************************************
$seleziona_cliente = "SELECT id_clienti,nome FROM clienti ORDER BY nome ASC";
$ris =  mysql_query ($seleziona_cliente,$connection);
         echo "<tr><td class=TinyBlack width=\"35%\" align=\"right\">Cliente</td><td class=\"TinyBlack\" width=\"65%\"><select name=id_clienti class=TinyBlack>";
         while ($riga = mysql_fetch_array($ris)){
         $nome=$riga[1];
        if ($id_clienti == $riga[0] )
        {
            echo "<option value=$riga[0] selected >$nome";
        }
        else
        {
            echo "<option value=$riga[0]>$nome";
        }
}
         echo "</select></td></tr>";


echo "<tr><td class=\"TinyBlack\" width=\"35%\" align=\"right\"><b></b></td><td width=\"65%\"> <input type=\"submit\" name=\"seleziona\" value=\"Seleziona proposta\"></td></tr>";

 $seleziona = $_POST['seleziona'];
 $id_cliente_sel = $_POST['id_clienti'];
 $id_tecnico_sel = $_POST['id_tecnici'];
if ($seleziona){

    $id_cliente_sel = $_POST['id_clienti'];
    $id_tecnico_sel = $_POST['id_tecnici'];

    $ref_tecnico       = "SELECT nome,cognome FROM tecnici WHERE id_tecnici = $id_tecnico_sel";
    $tecnico_rec       =  mysql_query ($ref_tecnico,$connection);
    $dati_tec          = mysql_fetch_array($tecnico_rec);
    $nome_tec          = $dati_tec[0];
    $cognome_tec       = $dati_tec[1];

    $ref_cliente       = "SELECT nome FROM clienti WHERE id_clienti = $id_cliente_sel";
    $cliente_rec       =  mysql_query ($ref_cliente,$connection);
    $dati_cli          = mysql_fetch_array($cliente_rec);
    $nome_cli          = $dati_cli[0];

echo "<tr><td class=\"TinyBlack\" width=\"35%\" align=\"right\"><b>Tecnico selezionato</b></td><td width=\"65%\"> <input type=\"text\" value=\"$nome_tec $cognome_tec\" size=\"20\" readonly></td></tr>";
echo "<tr><td class=\"TinyBlack\" width=\"35%\" align=\"right\"><b>Cliente selezionato</b></td><td width=\"65%\"> <input type=\"text\" value=\"$nome_cli\" size=\"30\" readonly></td></tr>";

$seleziona_proposta = "SELECT id_proposte,nome_proposta,id_cliente FROM proposte WHERE id_cliente = $id_cliente_sel";
$ris_proposta =  mysql_query ($seleziona_proposta,$connection);
         echo "<tr><td class=\"TinyBlack\"><font face=\"Arial\" size=\"2\"><b>Seleziona proposta</b></font></td> <td class=\"TinyBlack\" width=\"65%\"><select name=id_proposte class=TinyBlack>";
         while ($riga_proposta = mysql_fetch_array($ris_proposta)){
         $id_proposte=$riga_proposta[0];
         $nome_proposta=$riga_proposta[1];
         $nome_cliente=$riga_proposta[2];
         $estrazionedaticliente = "SELECT nome  FROM clienti WHERE id_clienti  = $nome_cliente ";
$estrazione_record_cliente = mysql_query($estrazionedaticliente,$connection);
$riga_record_cliente = mysql_fetch_array($estrazione_record_cliente);
$nome_cliente = $riga_record_cliente["nome"];

        if ($nome_proposta == $riga_proposta[0] )
        {
            echo "<option value=$id_proposte selected >$id_proposte - $nome_proposta - $nome_cliente";
        }
        else
        {
            echo "<option value=$id_proposte>$id_proposte - $nome_proposta - $nome_cliente";
        }
}
         echo "</select></td></tr>";
}

//fine codifica nome proposta
echo "<div><input type=hidden name=id_tecnico_sel value=$id_tecnico_sel></div>";
echo "<div><input type=hidden name=id_cliente_sel value=$id_cliente_sel></div>";




//************************************************************



/*
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

*/

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
echo "<tr><td width=\"35%\"><font face=\"Arial\" size=\"2\"><input type=\"button\" value=\"indietro\" onClick=\"javascript:history.back()\">   <input type=\"submit\" name=\"salva\" value=\"inserisci correlazione\"></td></tr>";
echo "<tr><td colspna=\"2\"><input type=hidden name=id_key value=$QSTRING></td></tr>";
echo "<tr><td colspna=\"2\"><input type=hidden name=id_tecnici value=$id_tecnici></td></tr></form>";


$salva                 = $_POST[salva];
$selected              = $_POST['selected'];
$piace                 = $_POST['piace'];
$giorni_stimati        = $_POST[girni_stimati];
$id_strumento          = $_POST[id_registro];
$id_tecnico            = $_POST[id_tecnico_sel];
$id_proposta           = $_POST[id_proposte];
$data_richiesta        = date("Y-m-d");
$giorni_stimati        = $_POST[giorni_stimati];
$id_registro_strumento = $id_strumento;
$unique                = $_POST[id_key];


if ($salva && $giorni_stimati !=''){

$seleziona_nome_tecnico = "SELECT nome,cognome FROM tecnici WHERE id_tecnici = $id_tecnico_sel";
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
//mysql_query($dati,$connection)
//or die ("non sono riuscito " );


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


//mysql_query($aggiornamento_status_strumento,$connection)
//or die ("non sono riuscito " );
} //Chiudo il for
} //Chiudo l'if

//mysql_close ($connection);

//echo  "<meta http-equiv=refresh content=0;url=arrivo.php?id=$unique>";
}
 
echo "</table>";
echo"<br><br>";

?>

</body>
</html>

