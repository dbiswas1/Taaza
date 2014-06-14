<?php 
include('./mpdf/mpdf.php');


include 'db_config.php' ;

$conn=new createConnection();
$conn->connect();
$conn->selectdb();

$mpdf=new mPDF();
$mpdf->SetFooter('Taaza Tarkari Agro India PVT LTD ||Page {PAGENO} of {nb}');
$date=$_GET['date'];
$display_date=str_replace("-", "/", $_GET['date']);
$display_date=date('M-d-Y', strtotime($display_date));
list($m,$d,$y)=split('-',$display_date);


$total_sales_sum_query=mysql_query("select sum(amount) as totalsales from invoice where date_format(in_date,'%m-%d-%Y')='$date'");

$total_sales_sum_arr=mysql_fetch_assoc($total_sales_sum_query);

$total_sales_sum=$total_sales_sum_arr['totalsales'];




// Wastage Calculation

$total_wastage_query=mysql_query("select sum(price*qty) as totalwasatge  from wastage_history where date_format(date,'%m-%d-%Y')='$date'");

$total_wastage_arr=mysql_fetch_assoc($total_wastage_query);

$total_wastage=$total_wastage_arr['totalwasatge'];


//Closing Stock

$total_inventory_query=mysql_query("select sum(i.primary_stock*p.purchase) as totalstock from sc_price_list_history p, sc_inventory_history i where date_format(i.date,'%m-%d-%Y')=date_format(p.date,'%m-%d-%Y') and p.p_item_code=i.s_item_code and date_format(i.date,'%m-%d-%Y')='$date' and primary_stock > 0 ");

$total_inventory_arr=mysql_fetch_assoc($total_inventory_query);

$total_inventory=$total_inventory_arr['totalstock'];



$daily_txt = '
<html>
<head>
<title>MIS Report</title>
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<style type="text/css">ol{margin:0;padding:0}.c25{vertical-align:top;width:460.5pt;border-style:solid;background-color:#9aa9a1;border-color:#ffffff;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c35{vertical-align:top;width:90pt;border-style:solid;background-color:#e4e4e6;border-color:#ffffff;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c7{vertical-align:top;width:123pt;border-style:solid;border-color:#434343;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c18{vertical-align:top;width:243.7pt;border-style:solid;border-color:#434343;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c8{vertical-align:top;width:243.8pt;border-style:solid;border-color:#434343;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c5{vertical-align:top;width:141pt;border-style:solid;border-color:#434343;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c6{vertical-align:top;width:271pt;border-style:solid;border-color:#000000;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c12{vertical-align:baseline;font-size:10pt;font-style:normal;font-family:"Arial";text-decoration:none;font-weight:normal}.c26{vertical-align:top;width:33pt;border-style:solid;border-color:#434343;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c0{vertical-align:top;width:552pt;border-style:solid;border-color:#000000;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c17{color:#666666;font-size:12pt;font-family:"Verdana";font-weight:bold}.c10{line-height:1.0;padding-top:0pt;height:10pt;padding-bottom:0pt}.c24{padding-top:0pt;height:10pt;padding-bottom:0pt}.c34{max-width:552.1pt;background-color:#ffffff;padding:50.4pt 21.6pt 50.4pt 21.6pt}.c15{margin-right:auto;border-collapse:collapse}.c16{line-height:1.0;padding-top:0pt;padding-bottom:0pt}.c22{color:#666666;font-size:12pt;font-weight:bold}.c33{color:#e4e4e6;font-size:30pt}.c9{text-align:left;direction:ltr}.c30{font-size:9pt;font-weight:bold}.c28{font-size:11pt;font-weight:bold}.c3{height:10pt;direction:ltr}.c27{font-size:8pt;font-weight:bold}.c31{height:8pt;text-align:center}.c23{color:#c2c2c4;font-size:30pt}.c32{color:#e4e4e6;background-color:#9aa9a1}.c2{text-align:right;direction:ltr}.c4{height:0pt}.c20{color:#7e8076}.c29{height:24pt}.c14{line-height:1.15}.c38{height:8pt}.c1{color:#000000}.c11{color:#434343}.c21{background-color:#999999}.c36{text-align:center}.c37{height:10pt}.c13{height:57pt}.c19{direction:ltr}.title{padding-top:0pt;line-height:1.15;text-align:left;color:#c2c2c4;font-size:48pt;font-family:"Arial";padding-bottom:0pt}.subtitle{padding-top:0pt;line-height:1.0;text-align:right;color:#ffffff;font-size:24pt;background-color:#9aa9a1;font-family:"Arial";font-weight:bold;padding-bottom:0pt}li{color:#7e8076;font-size:10pt;font-family:"Arial"}p{color:#7e8076;font-size:10pt;margin:0;font-family:"Arial"}h1{padding-top:0pt;line-height:1.0;text-align:left;color:#7e8076;font-size:8pt;font-family:"Arial";font-weight:bold;padding-bottom:0pt}h2{padding-top:0pt;line-height:1.0;text-align:right;color:#7e8076;font-size:8pt;font-family:"Arial";padding-bottom:0pt}h3{padding-top:0pt;line-height:1.5;text-align:left;color:#7e8076;font-size:9pt;font-family:"Arial";padding-bottom:0pt}h4{padding-top:0pt;line-height:1.5;text-align:left;color:#434343;font-size:8pt;font-family:"Arial";padding-bottom:0pt}h5{padding-top:0pt;line-height:1.0;text-align:right;color:#ffffff;font-size:10pt;background-color:#9aa9a1;font-family:"Arial";padding-bottom:0pt}h6{padding-top:0pt;line-height:1.0;text-align:left;color:#666666;font-size:8pt;background-color:#e4e4e6;font-family:"Arial";padding-bottom:0pt}</style>
</head>
<body class="c34">
<div>
<p class="c19"><img height="52" src="images/image00.jpg" width="53"><span class="c23">&nbsp;</span><span class="c17">TAAZA TARKARI AGRO INDIA PVT LTD </span></p>
</div>
<p class="c9 c14 c37 title"><a name="h.9ryq27p4pmwc"></a></p><a href="#" name="a38856f6c2d5eb9202c50595aec1ea211082df08"></a><a href="#" name="0"></a>
<table cellpadding="0" cellspacing="0" class="c15">
<tbody>
<tr class="c29">
<td class="c35"><h6 class="c9 c38"><a name="h.hdys48h878x9"></a></h6><h6 class="c9"><a name="h.4ms4pjdvvcn5"></a>
<span class="c30 c1">'.$m.'&nbsp;'.$d.', '.$y.'</span><span class="c1 c28"><br></span></h6><h6 class="c19 c31">
<a name="h.4ms4pjdvvcn5"></a></h6>
</td>
<td class="c25"><p class="c19 subtitle"><a name="h.f9dtygnsfopk"></a><span>DAILY MIS REPORT</span></p></td>
</tr>
</tbody>
</table>
<p class="c3"><span></span></p><a href="#" name="6b0f16fa3e6144c49f76bfa9fc181c8d6b525522"></a><a href="#" name="1"></a>

<table cellpadding="0" cellspacing="0" class="c15">
	<tbody>
	<tr class="c4">
	<td class="c0 c21"><h1 class="c19"><a name="h.iscnhzafokvq"></a><span class="c1">TOTAL CASH INFLOW : RS '.number_format($total_sales_sum,2).'</span></h1></td>
	</tr>
	<tr class="c13">
	<td class="c0"><p class="c3"><span></span></p><a href="#" name="325ff26a9b4da85d1af551f9ee0020d8f93a6f8f"></a><a href="#" name="4"></a><table cellpadding="0" cellspacing="0" class="c15">
	<tbody>
	<tr class="c4">
	<td class="c26"><p class="c19 c36"><span class="c11"><b>SL#</b></span></p></td>
	<td class="c18"><p class="c19"><span class="c11"><b>SHOP NAME</b></span></p></td>
	<td class="c18" align="center"><p class="c19"><span class="c11"><b>COMMENTS</b></span></p></td>

	<td class="c7" align="right"><p class="c2"><span class="c11"><b>AMOUNT</b></span></p></td>
	</tr>';
	
	$total_sales_query=mysql_query("select i.invoice_no,c.shop_name,i.amount from client c, invoice i where i.in_c_id=c.c_id and date_format(in_date,'%m-%d-%Y')='$date' order by amount desc");

	$tslno=0;

	while($total_sales_arr=mysql_fetch_array($total_sales_query)){

	++$tslno;
	
	$daily_txt.='<tr class="c4">
	<td class="c26"><p class="c19"><span class="c11">'.$tslno.'</span></p></td>
	</td><td class="c18"><p class="c19"><span class="c11">'.$total_sales_arr['shop_name'].'</span></p></td>
		</td><td class="c18"><p class="c19"><span class="c11"></span></p></td>

	<td class="c7" align="right"><p class="c2"><span class="c11">'.number_format($total_sales_arr['amount'],2).'</span></p></td>
	</tr>'; }
	
				$total_pur_sum_query=mysql_query("select sum(p_price) as totalpurchase from purchase_order where date_format(p_date,'%m-%d-%Y')='$date'");
				$tota_pur_sum_arr=mysql_fetch_array($total_pur_sum_query);
				$total_pur_sum=$tota_pur_sum_arr['totalpurchase'];
	
		
       			$exp_sum_query=mysql_query("select sum(ex_amount) as totalexpense from expense where date_format(exp_date,'%m-%d-%Y')='$date'");
       			$exp_sum_arr=mysql_fetch_assoc($exp_sum_query);
       			$exp_sum=$exp_sum_arr['totalexpense'];
       			
       			
       			$total_wastage_query=mysql_query("select sum(price*qty) as totalwasatge  from wastage_history where date_format(date,'%m-%d-%Y')='$date'");
                $total_wastage_arr=mysql_fetch_assoc($total_wastage_query);
                $total_wastage=$total_wastage_arr['totalwasatge'];
       			
       			$total_COF=$total_pur_sum + $exp_sum + $total_wastage;
	
	
	$daily_txt.='</tbody>
	</table><p class="c3"><span></span></p></td>
	</tr>
	</tbody>
	</table>
	<p class="c3"><span></span></p></td></tr></tbody></table><p class="c3"><span></span></p><a href="#" name="37f5b8cb45d851e9f4358440a02d0cd6b1accfa7"></a><a href="#" name="3"></a>


<table cellpadding="0" cellspacing="0" class="c15">
	<tbody>
	<tr class="c4">
	<td class="c0 c21"><h1 class="c19"><a name="h.iscnhzafokvq"></a><span class="c1">TOTAL CASH OUTFLOW : RS '.number_format($total_COF,2).'</span></h1></td>
	</tr>
	<tr class="c13">
	<td class="c0"><p class="c3"><span></span></p><a href="#" name="325ff26a9b4da85d1af551f9ee0020d8f93a6f8f"></a><a href="#" name="4"></a><table cellpadding="0" cellspacing="0" class="c15">
	<tbody>
	<tr class="c4">
	<td class="c26"><p class="c19 c36"><span class="c11"><b>SL#</b></span></p></td>
	<td class="c5"><p class="c19"><span class="c11"><b>Particulars</b></span></p></td>
	<td class="c18" align="center"><p class="c19"><span class="c11"><b>Comments</b></span></p></td>
	<td class="c7" align="right"><p class="c2"><span class="c11"><b>AMOUNT</b></span></p></td>

	</tr>
	<tr class="c4">
	<td class="c26"><p class="c19"><span class="c11">1</span></p></td>
	<td class="c5"><p class="c19"><span class="c11">Payments for Purchase </span></p>
	<td class="c7" align="right"><p class="c2"><span class="c11"></span></p></td>

	</td><td class="c18" align="right"><p class="c19"><span class="c11">'.$total_pur_sum.'</span></p></td>
	</tr> ';
	
	
				$coflw=1; 
               	$cash_outflow_1=mysql_query("select et.ex_type,sum(ex.ex_amount) as sum_exp from expense_type et, expense ex where date_format(ex.exp_date,'%m-%d-%Y')='$date' and ex.exp_ex_id=et.ex_id group by et.ex_id");
				while($cash_outflow_rr=mysql_fetch_array($cash_outflow_1)){ 
				++$coflw;
				

	
	$daily_txt.='<tr class="c4">
	<td class="c26"><p class="c19"><span class="c11">'.$coflw.'</span></p></td>
	<td class="c5"><p class="c19"><span class="c11">'.$cash_outflow_rr['ex_type'].'</span></p>
	<td class="c7"><p class="c2"><span class="c11"></span></p></td>

	</td><td class="c18" align="right"><p class="c19"><span class="c11">'.$cash_outflow_rr['sum_exp'].'</span></p></td>
	</tr>';}
	
	
	
	
	
	
	
	$daily_txt.='
	
	<tr class="c4">
	<td class="c26"><p class="c19"><span class="c11">'.++$coflw.'</span></p></td>
	<td class="c5"><p class="c19"><span class="c11">Total Wastage</span></p>
		<td class="c7" align="right"><p class="c2"><span class="c11"></span></p></td>

	</td><td class="c18" align="right"><p class="c19"><span class="c11">'.$total_wastage.'</span></p></td>
	</tr>
	
	
	
	
	</tbody></table><p class="c3"><span></span></p></td>
	</tr>
	</tbody>
	</table>
	

	
	<p class="c3"><span></span></p><p class="c3"><span></span></p><a href="#" name="3cc46e1d6075833d07f4eb670ad9fbf67bb58229"></a><a href="#" name="9"></a>
	
	<table cellpadding="0" cellspacing="0" class="c15"><tbody><tr class="c4">
	<td class="c0 c21"><h1 class="c19"><a name="h.vbfc24hyqdle"></a><span class="c1">DAY&rsquo;s SUMMARY</span></h1></td>
	</tr><tr class="c13"><td class="c0"><p class="c3"><span></span></p><a href="#" name="a75141bc368a5b165ccce81b24f9aabaf2d58865"></a><a href="#" name="10"></a><table cellpadding="0" cellspacing="0" class="c15"><tbody><tr>
	<td class="c6" align="right"><p class="c16 c19"><span class="c1">TOTAL CASH INFLOW</span></p></td>
	<td class="c6" align="right"><p class="c16 c19"><span class="c1">'.number_format($total_sales_sum,2).'</span></p></td>
	</tr><tr class="c4">
	<td class="c6" align="right"><p class="c16 c9"><span class="c1">TOTAL CASH OUTFLOW</span></p></td>
	<td class="c6" align="right"><p class="c10 c9"><span class="c1">'.number_format($total_COF,2).'</span></p></td></tr>
	<tr class="c4">
	<td class="c6" align="right"><p class="c16 c9"><span class="c1">COLSING CASH BALANCE </span></p></td>
	<td class="c6" align="right"><p class="c10 c9"><span class="c1">'.number_format(($total_sales_sum - $total_COF),2).'</span></p></td></tr>
	

	<tr class="c4">
	<td class="c6" align="right"><p class="c19"><span class="c1">CLOSING STOCK VALUE </span></p></td>
	<td class="c6" align="right"><p class="c10 c9"><span class="c1">'.number_format($total_inventory,2).'</span></p></td></tr>
	
	</tbody></table><p class="c3"><span></span></p></td></tr></tbody></table><p class="c3"><span></span></p><div><p class="c3 c14"><span class="c32"></span></p><a href="#" name="fb9fb93011ad78ca1e36c4c1e56fdf04d009bd67"></a><a href="#" name="11"></a><table cellpadding="0" cellspacing="0" class="c15"><tbody></tbody></table><p class="c9 c14 c24"><span></span></p></div></body></html>


';



$mpdf->WriteHTML($daily_txt);



$mpdf->Output();

exit;



?>