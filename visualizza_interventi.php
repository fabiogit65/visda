<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Gestione interventi Sisthema s.r.l.</title>
	<link rel="stylesheet" href="css/style_ie.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />

        <link rel="stylesheet" href="reset.css" type="text/css" />
        <link rel="stylesheet" href="base.css" type="text/css" />

        <link rel="stylesheet" href="css/smoothness/jquery-ui-1.7.2.custom.css" type="text/css" />
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
        <script type="text/javascript" src="scripts/jquery.ui.datepicker-it.js"></script>
        

        <script type="text/javascript">
        $().ready(function(){
                var oggi=new Date();
                var anno=oggi.getFullYear();
                var da=parseInt(anno-5);
                var a=parseInt(anno+2);
                var dates1 = $( "#data" ).datepicker({
                        changeMonth:true,
                        changeYear:true,
                        yearRange: da+':'+a
                        });
                 })
       </script>

</head>
<br>
<center>
<body topmargin="0">

<div><img src=img/Header_sisthema.jpg width="100%" height="150">
</center>
<br>
<left>
<a href="index.html" class="linkmenu"><b>>> Indietro</b></a>
</left>
<center>
<br><br>
<font face=Arial size=4><b>Report anno 2016<br><br>Visualizza e gestisci report</b></font>
<br><br>

<br>
<?php
include("db.php");
include("functions.php");



//sezione visualizzazione interventi


$query = "SELECT MIN(id_interventi) as id_interventi, MIN(data_intervento) as data_intervento, id_proposta,id_cliente,id_tecnico,durata_intervento,sede_intervento,motivo_intervento,status_intervento,chiave_univoca FROM `Interventi` WHERE data_intervento > '2015-12-31' GROUP BY chiave_univoca";
$result = mysql_query($query);
?>

<table border="1" width = "100%">
<tr bgcolor="#737373" class="White">
<th class="MediumWhite">Modifica intervento</th>
<th class="MediumWhite">Cliente</th>
<th class="MediumWhite">Proposta</th>
<th class="MediumWhite">Note</th>
<th class="MediumWhite">Giorni stimanti</th>
<th class="MediumWhite">Giornate in campo</th>
<th class="MediumWhite">Giornate in ufficio</th>
<th class="MediumWhite">Tecnico</th>
<th class="MediumWhite">Data chiusura intervento in campo</th>
<th class="MediumWhite">Consegna prevista</th>
<th class="MediumWhite">Giorni trascorsi da fine intervento</th>
<th class="MediumWhite">Consegna reale</th>
<th class="MediumWhite">Note report</th>
</tr>


<?php

    $data_oggi = date("Y-m-d");
while($query_data = mysql_fetch_array($result)){

    $id_interventi = $query_data["id_interventi"];

    $id_tecnico = $query_data["id_tecnico"];
    $chiave_univoca = $query_data["chiave_univoca"];

    $referente_tecnico = "SELECT nome,cognome FROM tecnici WHERE id_tecnici = $id_tecnico";
    $tecnico_record =  mysql_query ($referente_tecnico,$connection);
    $dati_tecnico = mysql_fetch_array($tecnico_record);
    $nome_tecnico = $dati_tecnico[0];
    $cognome_tecnico = $dati_tecnico[1];

    $id_cliente = $query_data["id_cliente"];
    $referente_cliente = "SELECT nome FROM clienti WHERE id_clienti = $id_cliente";
    $cliente_record =  mysql_query ($referente_cliente,$connection);
    $dati_cliente = mysql_fetch_array($cliente_record);
    $nome_cliente = $dati_cliente[0];

    $id_proposta = $query_data["id_proposta"];
    $nome_proposta = "SELECT nome_proposta, proposta_in_pdf,note,giorni_previsti FROM proposte WHERE id_proposte = $id_proposta";
    $proposta_record =  mysql_query ($nome_proposta,$connection);
    $righe_proposta  = mysql_fetch_array($proposta_record);
    $nomeproposta    = $righe_proposta[0];
    $nomedocpdf      = $righe_proposta[1];
    $note            = $righe_proposta[2];
    $giorni_previsti = $righe_proposta[3];

    $durata_intervento   = $query_data["durata_intervento"];
    $sede_intervento     = $query_data["sede_intervento"];
    $motivo_intervento   = $query_data["motivo_intervento"];
    $giornate_intervento = $query_data["giornate_intervento"];
    $note                = $query_data["note"];

    $data_intervento = $query_data["data_intervento"];

    $days =substr($data_intervento,8,2);
    $month = substr($data_intervento,5,2);
    $year = substr($data_intervento,2,2);
    $weekday =  date ('w', mktime(0,0,0,$month,$days,$year));

    $data_intervento_it = giradataMySQL_IT($data_intervento);

    $status_intervento = $query_data["status_intervento"];

    $trova_dettaglio_intervento = "SELECT id_dettagli_interventi,data_chiusura_intervento,giornate_in_ufficio,data_chiusura_report,note_report FROM dettagli_interventi WHERE id_intervento = $id_interventi";
    $trova_record =  mysql_query ($trova_dettaglio_intervento,$connection);
    $righe_trovate = mysql_fetch_array($trova_record);
    $recordtrovato             = $righe_trovate[0];
    $data_chiusura_intervento  = $righe_trovate[1];
    $giornate_in_ufficio       = $righe_trovate[2];
    $data_chiusura_report      = $righe_trovate[3];
    $note_report               = $righe_trovate[4];

    $data_oggi = date("Y-m-d");
    $data_oggi_perdiff = giradataMySQL_IT_new($data_oggi);

//  15 gg aggiunti alla data chiusura intervento per confronto con data_oggi
    if ($data_chiusura_intervento){
    $data_modificata = sommaGiorni($data_chiusura_intervento,"-",15);
    }
    else {
    $data_modificata = '00-00-0000';
    }

    if ($data_chiusura_intervento){
    $data_chiusura_intervento_perdiff = giradataMySQL_IT_new($data_chiusura_intervento);
    $differenza_giorni =  diff_date_ingiorni($data_oggi_perdiff,$data_chiusura_intervento_perdiff);
    }
     
    $data_chiusura_intervento_it =  giradataMySQL_IT($data_chiusura_intervento);
    $data_modificata_it          =  giradataMySQL_IT($data_modificata);
    $data_chiusura_report_it     =  giradataMySQL_IT($data_chiusura_report);
 
     
    echo "<tr>\n";
    echo "<td width=2% align=center><a href=mod_det_int.php?id_dettagli_interventi=$recordtrovato target=\"_parent\"><img src=img/b_edit.png border=0></a></td>\n";
    echo "<td width=8% align=left class=\"black\"><b>$nome_cliente</b></td>\n";
    echo "<td width=8% align=left class=\"black\"><b><a href=\"../proposte_inserite/$nomedocpdf\" target=\"_blank\" class=\"Black\">$nomeproposta</b></a></td>\n";
    echo "<td width=8% align=left class=\"black\"><b>$note</b></td>\n";
    echo "<td width=8% align=left class=\"black\"><b>$giorni_previsti</b></td>\n";
    echo "<td width=8% align=left class=\"black\"><b>$durata_intervento</b></td>\n";
    echo "<td width=8% align=left class=\"black\"><b>$giornate_in_ufficio</b></td>\n";
    echo "<td width=8% align=left class=\"black\"><b>$nome_tecnico $cognome_tecnico</b></td>\n";
    echo "<td width=8% align=left class=\"black\"><b>$data_chiusura_intervento_it</b></td>\n";
    if ($data_oggi > $data_modificata) {    
    echo "<td width=8% align=left class=\"regis\" bgcolor=\"red\"><b>$data_modificata_it</b></td>\n";
    } else {
    echo "<td width=8% align=left class=\"black\"><b>$data_modificata_it</b></td>\n";
    }
    if (($data_chiusura_intervento) && ($data_chiusura_intervento !='0000-00-00')){
    echo "<td width=8% align=left class=\"black\"><b>$differenza_giorni</b></td>\n";
    }
    else {
    echo "<td width=8% align=left class=\"black\" bgcolor=\"#FFFF00\"><b>Non calcolabile</b></td>\n";
    }
    echo "<td width=8% align=left class=\"black\"><b>$data_chiusura_report_it</b></td>\n";
    echo "<td width=8% align=left class=\"black\"><b>$note_report</b></td>\n";

    echo "</tr>\n";

} // chiusura while


    echo "</tr>\n";

?>
</td>
</tr>
</table>
</body>
</html>

