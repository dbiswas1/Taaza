<?php 
include('./mpdf/mpdf.php');


include 'db_config.php' ;

$conn=new createConnection();
$conn->connect();
$conn->selectdb();

$mpdf=new mPDF();
$mpdf->SetFooter('Taaza Tarkari Agro India PVT LTD ||Page {PAGENO} of {nb}');
list($m,$d,$y)=split('-',$_GET['date']);
$client_details=mysql_query("select dues,shop_name,client_name,ph_num from client where c_id='$_GET[cid]'");
$client_arr=mysql_fetch_assoc($client_details);
$invoice_report=mysql_query("select it.item,ino.qty,in_h_price from invoice_history ih, indent_order ino, item_master it where it.item_code=in_h_item_code and ih.in_h_item_code=ino.i_item_code and ih.in_h_indent_no=ino.i_indent_no and ih.in_h_invoice_no=$_GET[invoice_no]");
$last_bill_query=mysql_query("select  date_format(in_date,'%b-%d-%Y') as in_date,amount from invoice where in_c_id='$_GET[cid]' and invoice_no <= '$_GET[invoice_no]' order by invoice_no desc  limit 2");
$last_bill=0;
$last_bill_date=0;
$count_last_bill=0;
while ($last_bill_arr=mysql_fetch_array($last_bill_query))
{
	$count_last_bill++;
	$last_bill=$last_bill_arr['amount'];
	$last_bill_date=$last_bill_arr['in_date'];
}
if ($count_last_bill <= 1)
		$last_bill = 0;

$due_string="select pay_id,date_format(date,'%b-%d-%Y') as date, dues from payment_master where pay_c_id=".$_GET['cid']." and date <= DATE_SUB(STR_TO_DATE('".$m."-".$d."-".$y."','%b-%d-%Y'),INTERVAL 1 DAY) order by pay_id desc limit 1";
$last_pay_string="select pay_id,date_format(date,'%b-%d-%Y') as date, paid from payment_master where pay_c_id=".$_GET['cid']." and date <= DATE_SUB(STR_TO_DATE('".$m."-".$d."-".$y."','%b-%d-%Y'),INTERVAL 1 DAY) and paid != 0 order by pay_id desc limit 1";


$last_pay_query=mysql_query($last_pay_string);
$last_pay_arr=mysql_fetch_assoc($last_pay_query);
$last_pay=$last_pay_arr['paid'];
$last_pay_date=$last_pay_arr['date'];
$total=0;
$dues=$client_arr['dues'];

$dues2_query=mysql_query($due_string);
$due2_arr=mysql_fetch_assoc($dues2_query);

$dues2=$due2_arr['dues'];
$dues2_date=$due2_arr['date'];

/*if(strlen($dues2) == 0 )
{
	$dues2=0;
	$dues2_date=0;
}

if (strlen($last_pay == 0))
{
	$last_pay=0;
	$last_pay_date=0;
}*/


$invoice_txt = '
<html><head><title>INVOICE_master</title>
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<style type="text/css">ol{margin:0;padding:0}.ct5{color:#666666}.c28{vertical-align:top;width:285pt;border-style:solid;background-color:#e4e4e6;border-color:#f1f1f2;border-width:0.5pt;padding:5pt 5pt 5pt 5pt}.c2{vertical-align:top;width:90pt;border-style:solid;background-color:#e4e4e6;border-color:#ffffff;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c38{vertical-align:top;width:103.5pt;border-style:solid;background-color:#e4e4e6;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c36{vertical-align:top;width:105.8pt;border-style:solid;background-color:#e4e4e6;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c9{vertical-align:top;width:103.5pt;border-style:solid;background-color:#f1f1f2;border-color:#7C7C85;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c40{vertical-align:top;width:58.5pt;border-style:solid;border-color:#000000;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c19{vertical-align:top;width:112.5pt;border-style:solid;border-color:#7C7C85;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c25{vertical-align:top;width:285.8pt;border-style:solid;border-color:#f1f1f2;border-width:0.5pt;padding:5pt 5pt 5pt 5pt}.c11{vertical-align:baseline;font-size:10pt;font-style:normal;font-family:"Arial";text-decoration:none;font-weight:normal}.c37{vertical-align:top;width:136.5pt;border-style:solid;border-color:#000000;border-width:0pt;padding:5pt 5pt 5pt 5pt}.c42{vertical-align:top;width:18pt;border-style:solid;border-color:#000000;border-width:0pt;padding:5pt 5pt 5pt 5pt}.c34{vertical-align:top;width:482.2pt;border-style:solid;border-color:#ffffff;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c32{vertical-align:top;width:194.2pt;border-style:solid;border-color:#000000;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c39{vertical-align:top;width:105.8pt;border-style:solid;border-color:#7C7C85;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c0{vertical-align:top;width:250.5pt;border-style:solid;border-color:#7C7C85;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c21{line-height:1.15;padding-top:0pt;text-align:left;padding-bottom:0pt}.c15{vertical-align:baseline;font-style:normal;font-family:"Arial";text-decoration:none}.c3{margin-right:auto;border-collapse:collapse}.c8{line-height:1.0;padding-top:0pt;padding-bottom:0pt}.c4{max-width:552.1pt;background-color:#ffffff;padding:50.4pt 21.6pt 50.4pt 21.6pt}.c17{line-height:1.0;text-align:left}.c1{text-align:right;direction:ltr}.c41{font-size:12pt;font-family:"Verdana"}.c14{line-height:1.5;direction:ltr}.c18{font-size:8pt;font-style:normal}.c22{color:#ffffff;font-size:8pt}.c6{height:10pt;direction:ltr}.c13{text-align:left;margin-left:0.8pt}.c26{line-height:1.15}.c29{color:#c2c2c4}.c20{height:0pt}.c33{background-color:#9aa9a1}.c43{margin-left:0.8pt}.c10{background-color:#f1f1f2}.c12{height:61pt}.c35{font-size:8pt}.c16{font-weight:normal}.c31{color:#e4e4e6}.c5{color:#000000}.c23{direction:ltr}.c24{height:10pt}.c30{text-align:left}.c45{font-size:12pt}.c7{font-weight:bold}.c27{font-size:30pt}.c44{line-height:1.0}.title{padding-top:0pt;line-height:1.15;text-align:left;color:#c2c2c4;font-size:48pt;font-family:"Arial";padding-bottom:0pt}.subtitle{padding-top:0pt;line-height:1.0;text-align:right;color:#ffffff;font-size:24pt;background-color:#9aa9a1;font-family:"Arial";font-weight:bold;padding-bottom:0pt}li{color:#7e8076;font-size:10pt;font-family:"Arial"}p{color:#7e8076;font-size:10pt;margin:0;font-family:"Arial"}h1{padding-top:0pt;line-height:1.0;text-align:left;color:#7e8076;font-size:8pt;font-family:"Arial";font-weight:bold;padding-bottom:0pt}h2{padding-top:0pt;line-height:1.0;text-align:right;color:#7e8076;font-size:8pt;font-family:"Arial";padding-bottom:0pt}h3{padding-top:0pt;line-height:1.5;text-align:left;color:#7e8076;font-size:9pt;font-family:"Arial";padding-bottom:0pt}h4{padding-top:0pt;line-height:1.5;text-align:left;color:#434343;font-size:8pt;font-family:"Arial";padding-bottom:0pt}h5{padding-top:0pt;line-height:1.0;text-align:right;color:#ffffff;font-size:10pt;background-color:#9aa9a1;font-family:"Arial";padding-bottom:0pt}h6{padding-top:0pt;line-height:1.0;text-align:left;color:#666666;font-size:8pt;background-color:#e4e4e6;font-family:"Arial";padding-bottom:0pt}</style>
</head><body class="c4">
<div><p class="c23"><img height="52" src="images/image00.jpg" width="53"><span class="c27 c29">&nbsp;</span><span class="c29 c7 c41 ct5">TAAZA TARKARI AGRO INDIA PVT LTD </span></p></div> 
<p class="c26 c23 c30 title"><a name="h.9ryq27p4pmwc"></a><span class="c27">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></p>
<a href="#" name="9f7713ad245e8a357a6ce4d5f2ac972b27d7afab"></a><a href="#" name="0"></a>
	<table cellpadding="0" cellspacing="0" class="c3" >
	<tbody>
	<tr class="c12">
		
		<td class="c2"><p class="c1 c24"><span class="c22"></span></p><h6 class="c1"><a name="h.4ms4pjdvvcn5"></a><span class="c5">'.$m.'&nbsp;'.$d.', &nbsp;'.$y.'<br></span></h6><h6 class="c1"><a name="h.4ms4pjdvvcn5"></a><span class="c5">Invoice No. 00'.$_GET[invoice_no].'</span></h6></td>
		<td class="c33 c34" align="right"><p class="c23 subtitle"><a name="h.f9dtygnsfopk"></a><span>INVOICE</span></p><h5 class="c23"><a name="h.rm9y3hcs0pf"></a><span class="c16">Prepared for </span><span>'.$client_arr[shop_name].'</span></h5><h5 class="c23"><a name="h.pjxe0e68da60"></a><span class="c16">'.$client_arr[client_name].',&nbsp;  '.$client_arr[ph_num].'</span></h5><p class="c8 c1 c24"><span></span></p></td>
		
	</tr>
	</tbody>
	</table>
	<p class="c6"><span class="c5"></span></p><a href="#" name="dba8ca4f4bf2cf451b6c3f15600cc260b2a622fa"></a><a href="#" name="1"></a>
	<table cellpadding="0" cellspacing="0" class="c3">
	<tbody>
		<tr class="c20">
			
			<td class="c0 c10" align="left"><h1 class="c23"><a name="h.8qi986j2qqlt"></a><span class="c5">ITEMS</span></h1></td>
			<td class="c19 c10" align="right"><h2 class="c1"><a name="h.rmx9glyl9qk1"></a><span class="c18 c5  c7">QTY</span></h2></td>
			<td class="c10 c39" align="right"><h2 class="c1"><a name="h.rmx9glyl9qk1"></a><span class="c5 c7  c18">UNIT PRICE</span></h2></td>
			<td class="c9" align="right"><h2 class="c1"><a name="h.rmx9glyl9qk1"></a><span class="c18 c5  c7">SUB TOTAL</span></h2></td>
			
			</tr> ';
			$sl_no=0;$total=0;$pg=1;
			while($invoice_report_arr=mysql_fetch_array($invoice_report)){
				
				$sl_no++;
				$invoice_txt.='<tr class="c20">
				
				<td class="c0" ><p class="c23"><span class="c5">  '.$invoice_report_arr[item].'  </span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span class="c5"></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span class="c5"></span></p><p class="c6"><span class="c5"></span></p></td>
				<td class="c19" align="right"><p class="c1" ><span class="c5">'.$invoice_report_arr[qty].'</span><span class="c5"></span></p></td>
				<td class="c39" align="right"><p class="c1" ><span class="c5">'.$invoice_report_arr[in_h_price].'</span></p></td>
				<td class="c9" align="right"><p class="c1" ><span class="c5">'.number_format(($invoice_report_arr[in_h_price]*$invoice_report_arr[qty]) ,2 ).'</span></p></td>
				</tr>
				';
				
				$total=($total)+($invoice_report_arr['in_h_price']*$invoice_report_arr['qty']) ;
				}$conn->close();
				
				
				
				
				$dues= $dues - $total;
				
				$grand_total=$dues+$total;
				
				$invoice_txt.='<tr class="c20">
					<td class="c0 c38" align="center"><p class="c8 c6 c30"><h1 class="c8 c1 c43"><span class="c5">Total Items = '.$sl_no.'</span></h1></p></td>
					<td class="c19 c38"><p class="c8 c6 c13"><span class="c11 c5"></span></p></td>
					<td class="c36" align="right"><h1 class="c8 c1 c43"><a name="h.yg9sa2ezkvpj"></a><span class="c5">SUB TOTAL</span></h1></td>
					<td class="c38" align="right"><p class="c8 c6 c13"><h1 class="c8 c1 c43"><span class="c5 ">'.number_format($total,2).'</span></h1></p></td>
					
				</tr>
				
				
				</tbody>
			</table>
			
			
			
			<p class="c6"><span class="c5"></span></p><p class="c6"><span class="c5"></span></p><a href="#" name="418fbd276a6087ce5dbcca7eaff3cfd3cbefbc89"></a><a href="#" name="2"></a>
			
			
			<table cellpadding="0" cellspacing="0" class="c3">
			<tbody>
			<tr class="c20">
				<td class="c25"><h3 class="c14"><a name="h.ifr7ajoyoea7"></a><span class="c5 c7">PAYMENT TERMS </span></h3><p class="c8 c23"><br><br><span class="c5">To be paid in full. </span></p><p class="c6 c8"><span></span></p><p class="c8 c23"><span class="c5">Thanks for doing business with us</span></p><p class="c8 c6"><span></span></p><p class="c8 c6"><span></span></p><p class="c8 c6"><span></span></p></td><td class="c28"><p class="c1 c24 c44"><span class="c7"></span></p><a href="#" name="a493544ab5b91c6f55868936d0ba55a99f78f3fc"></a><a href="#" name="3"></a><table cellpadding="0" cellspacing="0" class="c3"><tbody>
				
				<tr>
					<td class="c32" align="right"><p class="c8 c1"><span class="c7 c5">LAST BILL ('.$last_bill_date.'):</span></p><p class="c8 c1"><span class="c7 c5">LAST PAYMENT ('.$last_pay_date. '): </span></p><p class="c8 c1"><span class="c7 c5">CREDIT  ('.$dues2_date.'):</span></p></td>
					
					
					<td class="c40" align="right"><p class="c8 c1"><span class="c7 c5">'.number_format($last_bill,2).'</span></p><p class="c8 c1"><span class="c7 c5">'.number_format($last_pay,2).'</span></p><p class="c8 c1"><span class="c7 c5">'.number_format($dues2,2).'</span></p></td>
					
				</tr>
				
				<tr class="c20"><td class="c32" align="right"><p class="c8 c1"><span class="c7 c5">GRAND TOTAL ('.$m.'-'.$d.'-'.$y. '):</span></p></td><td class="c40" align="right"><p class="c8 c1"><span class="c7 c5">'.number_format($grand_total,2).'</span></p></td></tr>
				
				
</tbody></table><p class="c17 c6"><span class="c7"></span></p><a href="#" name="de88862835c008cbf721407b29643cf0ef46e543"></a><a href="#" name="4"></a><table cellpadding="0" cellspacing="0" class="c3"><tbody><tr><td class="c42"><p class="c8 c6 c30"><span class="c7"></span></p></td><td class="c37"><p class="c8 c6 c30"><span class="c7"></span></p></td></tr></tbody></table><p class="c6 c17"><span class="c7"></span></p></td></tr></tbody></table><p class="c6"><span></span></p><div><p class="c6 c26"><span class="c31 c33"></span></p><a href="#" name="fb9fb93011ad78ca1e36c4c1e56fdf04d009bd67"></a><a href="#" name="5"></a><table cellpadding="0" cellspacing="0" class="c3"><tbody></tbody></table><p class="c6 c21"><span></span></p></div>

</body></html>
';

$mpdf->WriteHTML($invoice_txt);

$mpdf->Output();
exit;

?>