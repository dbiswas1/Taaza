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

// Total Dues to be Paid

$p_due_total=0;
$p_biller_query=mysql_query("select b_id,market_name,dues from biller");
while ($p_biller_arr=mysql_fetch_array($p_biller_query)){
	$p_due_query=mysql_query("select bill_b_id,paid,dues,date from bill_payment_master where bill_b_id='$p_biller_arr[b_id]' and date=STR_TO_DATE('$date','%m-%d-%Y') order by bl_id desc limit 1");
	$p_due_arr=mysql_fetch_assoc($p_due_query);
	if(isset($p_due_arr['dues'])){
		$p_due_total+=$p_due_arr['dues'];
	}
	else{
		$p_dues_not_found_query=mysql_query("select dues from bill_payment_master where bill_b_id='$p_biller_arr[b_id]' and date<=STR_TO_DATE('$date','%m-%d-%Y') order by bl_id desc limit 1");
		$p_dues_not_found_arr=mysql_fetch_assoc($p_dues_not_found_query);
		if(isset($p_dues_not_found_arr['dues'])){
			$p_due_total+=$p_dues_not_found_arr['dues'];
		}
		else{
			$biller_due_query=mysql_query("select dues from biller where b_id='$p_biller_arr[b_id]'");
			$biller_due_arr=mysql_fetch_assoc($biller_due_query);
			$p_due_total+=$biller_due_arr['dues'];
			 
		}
	}
	 
}

//Total Dues To be Recieved

$get_cl_id_query=mysql_query("select shop_name,dues,c_id from client");
 
while($get_cl_id_arr=mysql_fetch_array($get_cl_id_query)){
	 
	$ctotal_due_query=mysql_query("select dues from payment_master where pay_c_id='$get_cl_id_arr[c_id]' and date =STR_TO_DATE('$date','%m-%d-%Y') order by pay_id desc limit 1");
	$ctotal_due_arr=mysql_fetch_assoc($ctotal_due_query);
	if(isset($ctotal_due_arr['dues'])){
		$ctotal_due+=$ctotal_due_arr['dues'];
		//echo "isiset=".$get_cl_id_arr['shop_name'].$ctotal_due_arr['dues']."e ---d  ";
	}
	else
	{
		//$ctotal_due+=$get_cl_id_arr['dues'];
		$due_not_found_query=mysql_query("select dues from payment_master where pay_c_id='$get_cl_id_arr[c_id]' and date <=STR_TO_DATE('$date','%m-%d-%Y') order by pay_id desc limit 1");
		$due_not_found_arr=mysql_fetch_assoc($due_not_found_query);
		if(isset($due_not_found_arr['dues'])){
			$ctotal_due+=$due_not_found_arr['dues'];
			//echo "Not Isset if place=".$get_cl_id_arr['shop_name'].$due_not_found_arr['dues']."e ---d  ";
		}
		else
		{
			//echo "else part of not found Not Isset=".$get_cl_id_arr['shop_name'].$get_cl_id_arr['dues']."e ---d  ";
			$ctotal_due+=$get_cl_id_arr['dues'];
		}

	}
}

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
<title>Daily Report</title>
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
<td class="c25"><p class="c19 subtitle"><a name="h.f9dtygnsfopk"></a><span>DAILY SALES REPORT</span></p></td>
</tr>
</tbody>
</table>
<p class="c3"><span></span></p><a href="#" name="6b0f16fa3e6144c49f76bfa9fc181c8d6b525522"></a><a href="#" name="1"></a>

<table cellpadding="0" cellspacing="0" class="c15">
	<tbody>
	<tr class="c4">
	<td class="c0 c21"><h1 class="c19"><a name="h.iscnhzafokvq"></a><span class="c1">TOTAL SALES : RS '.number_format($total_sales_sum,2).'</span></h1></td>
	</tr>
	<tr class="c13">
	<td class="c0"><p class="c3"><span></span></p><a href="#" name="325ff26a9b4da85d1af551f9ee0020d8f93a6f8f"></a><a href="#" name="4"></a><table cellpadding="0" cellspacing="0" class="c15">
	<tbody>
	<tr class="c4">
	<td class="c26"><p class="c19 c36"><span class="c11"><b>SL#</b></span></p></td>
	<td class="c5"><p class="c19"><span class="c11"><b>INVOICE#</b></span></p></td>
	<td class="c18"><p class="c19"><span class="c11"><b>SHOP NAME</b></span></p></td>
	<td class="c7" align="right"><p class="c2"><span class="c11"><b>AMOUNT</b></span></p></td>
	</tr>';
	
	$total_sales_query=mysql_query("select i.invoice_no,c.shop_name,i.amount from client c, invoice i where i.in_c_id=c.c_id and date_format(in_date,'%m-%d-%Y')='$date' order by amount desc");
	$tslno=0;
	while($total_sales_arr=mysql_fetch_array($total_sales_query)){
	++$tslno;
	
	$daily_txt.='<tr class="c4">
	<td class="c26"><p class="c19"><span class="c11">'.$tslno.'</span></p></td>
	<td class="c5"><p class="c19"><span class="c11">'.number_format($total_sales_arr['invoice_no'],2).'</span></p>
	</td><td class="c18"><p class="c19"><span class="c11">'.$total_sales_arr['shop_name'].'</span></p></td>
	<td class="c7" align="right"><p class="c2"><span class="c11">'.number_format($total_sales_arr['amount'],2).'</span></p></td>
	</tr>'; }
	
	$total_pur_sum_query=mysql_query("select sum(p_price) as totalpurchase from purchase_order where date_format(p_date,'%m-%d-%Y')='$date'");
	$tota_pur_sum_arr=mysql_fetch_array($total_pur_sum_query);
	$total_pur_sum=$tota_pur_sum_arr['totalpurchase'];
	
	
	$daily_txt.='</tbody>
	</table><p class="c3"><span></span></p></td>
	</tr>
	</tbody>
	</table>
	<p class="c3"><span></span></p></td></tr></tbody></table><p class="c3"><span></span></p><a href="#" name="37f5b8cb45d851e9f4358440a02d0cd6b1accfa7"></a><a href="#" name="3"></a>


<table cellpadding="0" cellspacing="0" class="c15">
	<tbody>
	<tr class="c4">
	<td class="c0 c21"><h1 class="c19"><a name="h.iscnhzafokvq"></a><span class="c1">TOTAL PURCHASE : RS '.number_format($total_pur_sum,2).'</span></h1></td>
	</tr>
	<tr class="c13">
	<td class="c0"><p class="c3"><span></span></p><a href="#" name="325ff26a9b4da85d1af551f9ee0020d8f93a6f8f"></a><a href="#" name="4"></a><table cellpadding="0" cellspacing="0" class="c15">
	<tbody>
	<tr class="c4">
	<td class="c26"><p class="c19 c36"><span class="c11"><b>SL#</b></span></p></td>
	<td class="c5"><p class="c19"><span class="c11"><b>DUES</b></span></p></td>
	<td class="c18"><p class="c19"><span class="c11"><b>MARKET NAME</b></span></p></td>
	<td class="c7" align="right"><p class="c2"><span class="c11"><b>AMOUNT</b></span></p></td>
	</tr>';
	
	$purchase_query=mysql_query("select po.p_b_id,b.market_name,sum(p_price) as totalpurchase from purchase_order po , biller b where date_format(p_date,'%m-%d-%Y')='$date' and po.p_b_id=b.b_id group by p_b_id");
	$pslno=0;
	while($purchase_arr=mysql_fetch_array($purchase_query)){
		++$pslno;
		$purchase_due_query=mysql_query("select dues from bill_payment_master where date_format(date,'%m-%d-%Y')='$date' and bill_b_id='$purchase_arr[p_b_id]' order by bl_id desc limit 1");
		$purchase_due_arr=mysql_fetch_assoc($purchase_due_query);
		$purchase_due=$purchase_due_arr['dues'];
		if(!isset($purchase_due)){
	
			$d_p_d_q=mysql_query("select dues from biller where b_id='$purchase_arr[p_b_id]'");
			$d_p_d_arr=mysql_fetch_assoc($d_p_d_q);
			$purchase_due=$d_p_d_arr['dues'];
	
		}
	
	$daily_txt.='<tr class="c4">
	<td class="c26"><p class="c19"><span class="c11">'.$pslno.'</span></p></td>
	<td class="c5"><p class="c19"><span class="c11">'.number_format($purchase_due,2).'</span></p>
	</td><td class="c18"><p class="c19"><span class="c11">'.$purchase_arr['market_name'].'</span></p></td>
	<td class="c7" align="right"><p class="c2"><span class="c11">'.number_format($purchase_arr['totalpurchase'],2).'</span></p></td>
	</tr>';}
	

	$coll_sum_query=mysql_query("select sum(paid) as paid from payment_master  where date_format(date,'%m-%d-%Y')='$date' and  paid!=0");
	$coll_sum_arr=mysql_fetch_assoc($coll_sum_query);
	$coll_sum=$coll_sum_arr['paid'];
	 
	$coll_query=mysql_query("select c.c_id,c.shop_name,pm.paid from payment_master pm, client c where date_format(date,'%m-%d-%Y')='$date' and pm.pay_c_id=c.c_id and paid!=0");
	 
	
	$daily_txt.='</tbody></table><p class="c3"><span></span></p></td>
	</tr>
	</tbody>
	</table>
	
	
	
	
	
	
		<p class="c3"><span></span></p></td></tr></tbody></table><p class="c3"><span></span></p><a href="#" name="37f5b8cb45d851e9f4358440a02d0cd6b1accfa7"></a><a href="#" name="3"></a>


<table cellpadding="0" cellspacing="0" class="c15">
	<tbody>
	<tr class="c4">
	<td class="c0 c21"><h1 class="c19"><a name="h.iscnhzafokvq"></a><span class="c1">TOTAL COLLECTIONS : RS '.number_format($coll_sum,2).'</span></h1></td>
	</tr>
	<tr class="c13">
	<td class="c0"><p class="c3"><span></span></p><a href="#" name="325ff26a9b4da85d1af551f9ee0020d8f93a6f8f"></a><a href="#" name="4"></a><table cellpadding="0" cellspacing="0" class="c15">
	<tbody>
	<tr class="c4">
	<td class="c26"><p class="c19 c36"><span class="c11"><b>SL#</b></span></p></td>
	<td class="c5"><p class="c19"><span class="c11"><b>DUES</b></span></p></td>
	<td class="c18"><p class="c19"><span class="c11"><b>SHOP NAME</b></span></p></td>
	<td class="c7" align="right"><p class="c2"><span class="c11"><b>AMOUNT</b></span></p></td>
	</tr>';
	
	$cslno=0;
            	while($col_arr=mysql_fetch_array($coll_query)){
            	$coll_due_query=mysql_query("select dues from payment_master where pay_c_id='$col_arr[c_id]' and date_format(date,'%m-%d-%Y')='$date' order by pay_id desc limit 1");
            	$coll_due_arr=mysql_fetch_assoc($coll_due_query);
            	$coll_due=$coll_due_arr['dues'];
	
	$daily_txt.='<tr class="c4">
	<td class="c26"><p class="c19"><span class="c11">'.++$cslno.'</span></p></td>
	<td class="c5"><p class="c19"><span class="c11">'.number_format($coll_due,2).'</span></p>
	</td><td class="c18"><p class="c19"><span class="c11">'.$col_arr['shop_name'].'</span></p></td>
	<td class="c7" align="right"><p class="c2"><span class="c11">'.number_format($col_arr['paid'],2).'</span></p></td>
	</tr>';}
	
	
	$eslno=0;
	$exp_sum_query=mysql_query("select sum(ex_amount) as totalexpense from expense where date_format(exp_date,'%m-%d-%Y')='$date'");
	$exp_sum_arr=mysql_fetch_assoc($exp_sum_query);
	$exp_sum=$exp_sum_arr['totalexpense'];
	$exp_query=mysql_query("select e.emp_name,et.ex_type,ex.ex_amount from employee e, expense_type et, expense ex where date_format(ex.exp_date,'%m-%d-%Y')='$date' and ex.exp_ex_id=et.ex_id and ex.exp_emp_id=e.emp_id");
	 
	
	
	$daily_txt.='</tbody></table><p class="c3"><span></span></p></td>
	</tr>
	</tbody>
	</table>
	
	<p class="c3"><span></span></p></td></tr></tbody></table><p class="c3"><span></span></p><a href="#" name="37f5b8cb45d851e9f4358440a02d0cd6b1accfa7"></a><a href="#" name="3"></a>


<table cellpadding="0" cellspacing="0" class="c15">
	<tbody>
	<tr class="c4">
	<td class="c0 c21"><h1 class="c19"><a name="h.iscnhzafokvq"></a><span class="c1">TOTAL EXPENSES : RS '.number_format($exp_sum,2).'</span></h1></td>
	</tr>
	<tr class="c13">
	<td class="c0"><p class="c3"><span></span></p><a href="#" name="325ff26a9b4da85d1af551f9ee0020d8f93a6f8f"></a><a href="#" name="4"></a><table cellpadding="0" cellspacing="0" class="c15">
	<tbody>
	<tr class="c4">
	<td class="c26"><p class="c19 c36"><span class="c11"><b>SL#</b></span></p></td>
	<td class="c5"><p class="c19"><span class="c11"><b>EXPENSE TYPE</b></span></p></td>
	<td class="c18"><p class="c19"><span class="c11"><b>PERSON NAME</b></span></p></td>
	<td class="c7" align="right"><p class="c2"><span class="c11"><b>AMOUNT</b></span></p></td>
	</tr>';

	while($exp_arr=mysql_fetch_array($exp_query)){
		++$eslno;
	$daily_txt.='<tr class="c4">
	<td class="c26"><p class="c19"><span class="c11">'.$eslno.'</span></p></td>
	<td class="c5"><p class="c19"><span class="c11">'.$exp_arr['ex_type'].'</span></p>
	</td><td class="c18"><p class="c19"><span class="c11">'.$exp_arr['emp_name'].'</span></p></td>
	<td class="c7" align="right"><p class="c2"><span class="c11">'.number_format($exp_arr['ex_amount'],2).'</span></p></td>
	</tr>';}

	$daily_txt.='</tbody></table><p class="c3"><span></span></p></td>
	</tr>
	</tbody>
	</table>
	
	
	
	
	
	
	<p class="c3"><span></span></p><p class="c3"><span></span></p><a href="#" name="3cc46e1d6075833d07f4eb670ad9fbf67bb58229"></a><a href="#" name="9"></a>
	
	<table cellpadding="0" cellspacing="0" class="c15"><tbody><tr class="c4">
	<td class="c0 c21"><h1 class="c19"><a name="h.vbfc24hyqdle"></a><span class="c1">DAY&rsquo;s SUMMARY</span></h1></td>
	</tr><tr class="c13"><td class="c0"><p class="c3"><span></span></p><a href="#" name="a75141bc368a5b165ccce81b24f9aabaf2d58865"></a><a href="#" name="10"></a><table cellpadding="0" cellspacing="0" class="c15"><tbody><tr>
	<td class="c6" align="right"><p class="c16 c19"><span class="c1">TOTAL SALES</span></p></td>
	<td class="c6" align="right"><p class="c16 c19"><span class="c1">'.number_format($total_sales_sum,2).'</span></p></td>
	</tr><tr class="c4">
	<td class="c6" align="right"><p class="c16 c9"><span class="c1">TOTAL PURCHASE</span></p></td>
	<td class="c6" align="right"><p class="c10 c9"><span class="c1">'.number_format($total_pur_sum,2).'</span></p></td></tr>
	<tr class="c4">
	<td class="c6" align="right"><p class="c16 c9"><span class="c1">TOTAL DUES TO BE PAID</span></p></td>
	<td class="c6" align="right"><p class="c10 c9"><span class="c1">'.number_format($p_due_total,2).'</span></p></td></tr>
	<tr class="c4">
	<td class="c6" align="right"><p class="c16 c9"><span class="c1">TOTAL DUES TO BE RECEIVED</span></p></td>
	<td class="c6" align="right"><p class="c9 c10"><span class="c1">'.number_format($ctotal_due,2).'</span></p></td></tr>
	<tr class="c4">
	<td class="c6" align="right"><p class="c19"><span class="c1">TOTAL COLLECTION</span></p></td>
	<td class="c6" align="right"><p class="c10 c9"><span class="c1">'.number_format($coll_sum,2).'</span></p></td></tr><tr class="c4">
	<td class="c6" align="right"><p class="c19"><span class="c1">TOTAL EXPENSE</span></p></td>
	<td class="c6" align="right"><p class="c10 c9"><span class="c1">'.number_format($exp_sum,2).'</span></p></td></tr>
	<tr class="c4">
	<td class="c6" align="right"><p class="c19"><span class="c1">CLOSING STOCK VALUE </span></p></td>
	<td class="c6" align="right"><p class="c10 c9"><span class="c1">'.number_format($total_inventory,2).'</span></p></td></tr>
	<tr class="c4">
	<td class="c6" align="right"><p class="c19"><span class="c1">TOTAL WASTAGE</span></p></td>
	<td class="c6" align="right"><p class="c10 c9"><span class="c1">'.number_format($total_wastage,2).'</span></p></td></tr>
	</tbody></table><p class="c3"><span></span></p></td></tr></tbody></table><p class="c3"><span></span></p><div><p class="c3 c14"><span class="c32"></span></p><a href="#" name="fb9fb93011ad78ca1e36c4c1e56fdf04d009bd67"></a><a href="#" name="11"></a><table cellpadding="0" cellspacing="0" class="c15"><tbody></tbody></table><p class="c9 c14 c24"><span></span></p></div></body></html>


';

$mpdf->WriteHTML($daily_txt);

$mpdf->Output();
exit;

?>