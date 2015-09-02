<?php

echo"
<table align='center' class='border' border='1' width='60%' cellpadding='0' cellspacing='0'>
 <tr>
   <td width='30%'>Server Online:</td>
   <td>".mysql_ping($db)."</td>
 </tr>
 <tr>
   <td>Datenbank:</td>
   <td>$datenbank</td>
 </tr>
</table>
<br><br>
<table align='center' class='border' border='1' width='98%' cellpadding='0' cellspacing='0'>
 <tr>
   <td>Tabellenname</td>
   <td>Einträge</td>
   <td>Größe</td>
   <td>Überhang</td>
 </tr>
";
$sql = mysql_query("SHOW TABLES FROM ".DB_DATABASE);
while ($row = mysql_fetch_row($sql)){
  $abfrage = mysql_query("SHOW TABLE STATUS FROM $datenbank LIKE '".$row[0]."'");
  $status = mysql_fetch_array($abfrage);
  echo "
   <tr>
     <td>$row[0]</td>
     <td>$status[Rows]</td>
     <td>$status[Data_length]</td>
     <td>$status[Data_free]</td>
   </tr>
 ";
}
echo"
</table>
";



function tableme($result){

$row = mysql_fetch_assoc($result);

$header='';
$header.='<tr>';
            foreach ($row as $col => $value) {
                $header.= "<th>";
                $header.= $col;
                $header.= "</th>";
            }
$header.='</tr>';


mysql_data_seek($result, 0);


    $rows='';
    while ($row = mysql_fetch_assoc($result)) { 
            $rows.='<tr>'; 
            foreach($row as $key => $value){ 
                $rows.='<td>'.$value.'</td>'; 
            } 
            $rows.='</tr>';
    } 
    return '<table align="center" class="border" border="1" width="60%" cellpadding="0" cellspacing="0">'.$header.$rows.'</table>';
}

$result = mysql_query("SELECT * FROM st2_login");
echo tableme($result);






?>
