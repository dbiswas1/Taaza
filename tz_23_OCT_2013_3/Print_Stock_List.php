<?php 
include('./mpdf/mpdf.php');

$stock_details="primary_stock";
if($_GET['stockval'] == 0){
	
	$stock_Text="PRIMARY";
	$stock_details="primary_stock";
}
if($_GET['stockval'] == 1){
	$stock_details="secondary_stock";
	$stock_Text="SECONDARY";
}
if($_GET['stockval'] == 2){
	$stock_details="waste_stock";
	$stock_Text="WASTAGE";
}


include 'db_config.php' ;

$conn=new createConnection();
$conn->connect();
$conn->selectdb();
$mpdf=new mPDF();
$mpdf->SetFooter('Taaza Tarkari Agro India PVT LTD ||Page {PAGENO} of {nb}');




$item_count1 = mysql_query("select date_format(now(),'%b-%D-%Y') as datef,count(*) as c from item_master");
$item_count2 = mysql_fetch_assoc($item_count1);
$item_count=0;
$item_count=$item_count2['c'];

$row_count=ceil($item_count/3);
$limit=0;

list($m,$d,$y)=split('-',$item_count2['datef']);


$stock_txt = '
<html>
<head>
<title>Print Stock_List
</title>
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<style type="text/css">ol{margin:0;padding:0}.c6{vertical-align:top;width:135.8pt;border-style:solid;background-color:#f1f1f2;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c1{vertical-align:baseline;color:#7e8076;font-size:10pt;font-style:normal;font-family:"Arial";text-decoration:none;font-weight:normal}.c33{vertical-align:top;width:90pt;border-style:solid;background-color:#e4e4e6;border-color:#ffffff;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c5{vertical-align:top;width:482.2pt;border-style:solid;background-color:#9aa9a1;border-color:#ffffff;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c20{vertical-align:top;width:135.7pt;border-style:solid;background-color:#f1f1f2;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c0{vertical-align:top;width:54.4pt;border-style:solid;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c4{line-height:1.0;padding-top:0pt;text-align:center;direction:ltr;margin-left:0.8pt;padding-bottom:0pt}.c16{vertical-align:top;width:135.8pt;border-style:solid;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c18{vertical-align:top;width:53.6pt;border-style:solid;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c27{vertical-align:top;width:135.7pt;border-style:solid;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c29{line-height:1.0;padding-top:0pt;text-align:left;margin-left:0.8pt;padding-bottom:0pt}.c13{vertical-align:baseline;font-style:normal;font-family:"Arial";text-decoration:none}.c9{line-height:1.0;padding-top:0pt;text-align:right;padding-bottom:0pt}.c23{line-height:1.15;padding-top:0pt;text-align:left;padding-bottom:0pt}.c12{margin-right:auto;border-collapse:collapse}.c37{line-height:1.0;padding-top:0pt;padding-bottom:0pt}.c2{max-width:552.1pt;background-color:#ffffff;padding:50.4pt 21.6pt 50.4pt 21.6pt}.c39{color:#c2c2c4;font-family:"Verdana"}.c38{color:#ffffff;font-size:8pt}.c3{height:10pt;direction:ltr}.c19{color:#e4e4e6;font-size:30pt}.c7{text-align:right;direction:ltr}.c34{color:#e4e4e6;background-color:#9aa9a1}.c17{color:#c2c2c4;font-size:30pt}.c10{color:#7e8076;font-size:8pt}.c15{height:0pt}.c11{color:#7e8076}.c22{direction:ltr}.c40{height:34pt}.c24{font-size:12pt}.c25{background-color:#f1f1f2}.c32{font-size:24pt}.c36{margin-left:0.8pt}.c28{font-weight:normal}.c30{text-align:center}.c31{text-align:left}.c14{font-style:normal}.c35{height:8pt}.c21{text-align:right}.c8{font-weight:bold}.c26{line-height:1.15}.title{padding-top:0pt;line-height:1.15;text-align:left;color:#c2c2c4;font-size:48pt;font-family:"Arial";padding-bottom:0pt}.subtitle{padding-top:0pt;line-height:1.0;text-align:right;color:#ffffff;font-size:24pt;background-color:#9aa9a1;font-family:"Arial";font-weight:bold;padding-bottom:0pt}li{color:#7e8076;font-size:10pt;font-family:"Arial"}p{color:#7e8076;font-size:10pt;margin:0;font-family:"Arial"}h1{padding-top:0pt;line-height:1.0;text-align:left;color:#7e8076;font-size:8pt;font-family:"Arial";font-weight:bold;padding-bottom:0pt}h2{padding-top:0pt;line-height:1.0;text-align:right;color:#7e8076;font-size:8pt;font-family:"Arial";padding-bottom:0pt}h3{padding-top:0pt;line-height:1.5;text-align:left;color:#7e8076;font-size:9pt;font-family:"Arial";padding-bottom:0pt}h4{padding-top:0pt;line-height:1.5;text-align:left;color:#434343;font-size:8pt;font-family:"Arial";padding-bottom:0pt}h5{padding-top:0pt;line-height:1.0;text-align:right;color:#ffffff;font-size:10pt;background-color:#9aa9a1;font-family:"Arial";padding-bottom:0pt}h6{padding-top:0pt;line-height:1.0;text-align:left;color:#666666;font-size:8pt;background-color:#e4e4e6;font-family:"Arial";padding-bottom:0pt}</style></head>
<body class="c2"><div><p class="c22"><img height="52" src="images/image00.jpg" width="53"><span class="c17">&nbsp;</span>
<span class="c24 c8 c39">TAAZA TARKARI AGRO INDIA PVT LTD </span></p></div><p class="c3 c26 c31 title"><a name="h.9ryq27p4pmwc"></a></p><a href="#" name="8202b091a3af3c745dfa00ef601c30306eb5c90f"></a><a href="#" name="0"></a><table cellpadding="0" cellspacing="0" class="c12"><tbody><tr class="c40"><td class="c33"><p class="c3 c21"><span class="c38"></span></p><h6 class="c7"><a name="h.4ms4pjdvvcn5"></a>
<span class="c8">'.$m.'    '.$d.', '.$y.'</span><span><br></span></h6>
<h6 class="c7 c35"><a name="h.4ms4pjdvvcn5"></a></h6></td><td class="c5"><h5 class="c22 c30"><a name="h.pjxe0e68da60"></a><span class="c8 c32">'.$stock_Text.' STOCK LIST</span></h5><p class="c3 c9"><span></span></p></td></tr></tbody></table>
<p class="c3"><span class="c11"></span></p><a href="#" name="42d0690ecc2f1d6e44a5d0b50d710308e7b7ea9e"></a><a href="#" name="1"></a>
 
<table cellpadding="0" cellspacing="0" class="c12">
<tbody>
<tr class="c15">
	<td class="c6"><h1 class="c22"><a name="h.8qi986j2qqlt"></a><span>ITEMS</span></h1></td>
	<td class="c18 c25"><h2 class="c22 c30"><a name="h.rmx9glyl9qk1"></a><span class="c10 c8 c14">QTY</span></h2></td>
	<td class="c20"><h2 class="c22 c31"><a name="h.rmx9glyl9qk1"></a><span class="c8">ITEMS</span></h2></td>
	<td class="c18 c25"><h2 class="c4"><a name="h.rmx9glyl9qk1"></a><span class="c8">QTY</span></h2></td>
	<td class="c20"><h2 class="c22 c29"><a name="h.rmx9glyl9qk1"></a><span class="c8">ITEMS</span></h2></td>
	<td class="c0 c25"><h2 class="c4"><a name="h.rmx9glyl9qk1"></a><span class="c8">QTY</span></h2></td>
</tr>';

for ($i=0 ; $i<$row_count ; $i++){ 
	
	
	$stock_report_query=mysql_query("select i.item, w.$stock_details from item_master i , inventory w where i.item_code=w.s_item_code limit $limit,3" );
	
	$stock_txt.='<tr class="c15">';
		while($stock_arr=mysql_fetch_array($stock_report_query)) {
			
		
    $stock_txt.=' 
	<td class="c16"><p class="c22"><span> '.$stock_arr[item].'</span></p></td>
	<td class="c18"><p class="c7"><span>'. $stock_arr[$stock_details].'</span></p></td>';
		}
		

$stock_txt.='</tr>';
$limit=$limit+3;
}$conn->close();

$stock_txt.='</tbody>
</table>
<p class="c3"><span class="c11"></span></p><p class="c3"><span class="c11"></span></p><a href="#" name="fb9fb93011ad78ca1e36c4c1e56fdf04d009bd67"></a><a href="#" name="2"></a><table cellpadding="0" cellspacing="0" class="c12"><tbody></tbody></table><p class="c3"><span></span></p><div><p class="c3 c26"><span class="c34"></span></p><a href="#" name="fb9fb93011ad78ca1e36c4c1e56fdf04d009bd67"></a><a href="#" name="3"></a><table cellpadding="0" cellspacing="0" class="c12"><tbody></tbody></table><p class="c3 c23"><span></span></p></div></body></html>

';

$mpdf->WriteHTML($stock_txt);

$mpdf->Output();
exit;

?>