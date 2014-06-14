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


   $mondate=date('m-01-Y', strtotime($ddate));
       $total_sales_sum_query=mysql_query("select sum(amount) as totalsales from invoice where date_format(in_date,'%m-%d-%Y')='$date'");
       $total_sales_sum_arr=mysql_fetch_assoc($total_sales_sum_query);
       $total_sales_sum=$total_sales_sum_arr['totalsales'];
       $mon_sales_sum_query=mysql_query("select sum(amount) as totalsales from invoice where in_date between str_to_date('$mondate','%m-%d-%Y') and  str_to_date('$date','%m-%d-%Y')");
       $mon_sales_sum_arr=mysql_fetch_assoc($mon_sales_sum_query);
       $mon_sales_sum=$mon_sales_sum_arr['totalsales'];




  	
            	
            	$opening_stock1=mysql_query("select sum(price*qty) as opening  from wastage_history where date_format(date,'%Y-%m-%d')= date_sub(str_to_date('$date','%m-%d-%Y'),INTERVAL 1 DAY)");
				//echo "select sum(price*qty) as opening  from wastage_history where date_format(date,'%Y-%m-%d')= date_sub(str_to_date('$date','%m-%d-%Y'),INTERVAL 1 DAY)";
				$opening_stock_arr=mysql_fetch_assoc($opening_stock1);
				$opening_stock_v=$opening_stock_arr['opening'];
				
				
				/*$openin_stockm_1=mysql_query("select sum(price*qty) as omnopn  from wastage_history where date_format(date,'%m-%Y')='$mondate'");
				$opening_stockm_arr=mysql_fetch_assoc($openin_stockm_1);
				$opening_stock_m=$opening_stockm_arr['omnopn'];*/
            	
            	
            	
            	$total_pur_sum_query=mysql_query("select sum(p_price) as totalpurchase from purchase_order where date_format(p_date,'%m-%d-%Y')='$date'");
       			$tota_pur_sum_arr=mysql_fetch_array($total_pur_sum_query);
       			$total_pur_sum=$tota_pur_sum_arr['totalpurchase'];
       			$mon_pur_sum_query=mysql_query("select sum(p_price) as monthlypurchase from purchase_order where p_date between str_to_date('$mondate','%m-%d-%Y') and  str_to_date('$date','%m-%d-%Y')");
       			$mon_pur_sum_arr=mysql_fetch_assoc($mon_pur_sum_query);
       			$mon_purr_sum=$mon_pur_sum_arr['monthlypurchase'];
       			
       			$exp_sum_query=mysql_query("select sum(ex_amount) as totalexpense from expense where date_format(exp_date,'%m-%d-%Y')='$date'");
       			$exp_sum_arr=mysql_fetch_assoc($exp_sum_query);
       			$exp_sum=$exp_sum_arr['totalexpense'];
       			
       			
       			$total_wastage_query=mysql_query("select sum(price*qty) as totalwasatge  from wastage_history where date_format(date,'%m-%d-%Y')='$date'");
                $total_wastage_arr=mysql_fetch_assoc($total_wastage_query);
                $total_wastage=$total_wastage_arr['totalwasatge'];
                $mon_wastage_query=mysql_query("select sum(price*qty) as totalwasatge  from wastage_history where date between str_to_date('$mondate','%m-%d-%Y') and  str_to_date('$date','%m-%d-%Y')");
                $mon_wastage_arr=mysql_fetch_assoc($mon_wastage_query);
                $mon_wastage=$mon_wastage_arr['totalwasatge'];
                
                $total_inventory_query=mysql_query("select sum(i.primary_stock*p.purchase) as totalstock from sc_price_list_history p, sc_inventory_history i where date_format(i.date,'%m-%d-%Y')=date_format(p.date,'%m-%d-%Y') and p.p_item_code=i.s_item_code and date_format(i.date,'%m-%d-%Y')='$date' and primary_stock > 0 ");
                $total_inventory_arr=mysql_fetch_assoc($total_inventory_query);
                $total_inventory=$total_inventory_arr['totalstock'];

       			
       			$total_COF=$total_pur_sum + $exp_sum + $total_wastage;

				$tsl_no=0;

$daily_txt = '
<html>
<head>
<title>P & L Report</title>
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
<td class="c25"><p class="c19 subtitle"><a name="h.f9dtygnsfopk"></a><span>DAILY P & L STATEMENT</span></p></td>
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
	<td class="c18"><p class="c19"><span class="c11"><b>PARTICULARS</b></span></p></td>
	<td class="c18" align="right"><p class="c19"><span class="c11"><b>FOR THE DAY</b></span></p></td>

	<td class="c7" align="right"><p class="c2"><span class="c11"><b>MONTH TILL DATE</b></span></p></td>
	</tr>
	
	<tr class="c4">
	<td class="c26"><p class="c19"><span class="c11">'.++$tslno.'</span></p></td>
	</td><td class="c18"><p class="c19"><span class="c11">OPENING STOCK</span></p></td>
		</td><td class="c18" align="right"><p class="c19"><span class="c11">'.number_format($opening_stock_v,2).'</span></p></td>

	<td class="c7" align="right"><p class="c2"><span class="c11">N/A</span></p></td>
	</tr>
	
	<tr class="c4">
		<td class="c26"><p class="c19"><span class="c11">'.++$tslno.'</span></p></td>
		</td><td class="c18"><p class="c19"><span class="c11">Total Purchases</span></p></td>
		</td><td class="c18" align="right"><p class="c19"><span class="c11">'.number_format($total_pur_sum,2).'</span></p></td>
		<td class="c7" align="right"><p class="c2"><span class="c11">'.number_format($mon_purr_sum,2).'</span></p></td>
	</tr>
	
	';
	
	$cash_outflow_1=mysql_query("select et.ex_id,et.ex_type,sum(ex.ex_amount) as sum_exp from expense_type et, expense ex where date_format(ex.exp_date,'%m-%d-%Y')='$date' and ex.exp_ex_id=et.ex_id group by et.ex_id");
	while($cash_outflow_rr=mysql_fetch_array($cash_outflow_1)){

	
	
	$daily_txt.='
	<tr class="c4">
		<td class="c26"><p class="c19"><span class="c11">'.++$tsl_no.'</span></p></td>
		</td><td class="c18"><p class="c19"><span class="c11">'.$cash_outflow_rr['ex_type'].'</span></p></td>
		</td><td class="c18" align="right"><p class="c19"><span class="c11">'.$cash_outflow_rr['sum_exp'].'</span></p></td> ';
		
		$mon_expense_1=mysql_query("select sum(ex_amount) as sum_exp from expense  where exp_date between str_to_date('$mondate','%m-%d-%Y') and  str_to_date('$date','%m-%d-%Y') and exp_ex_id='$cash_outflow_rr[ex_id]'");
        //echo "select sum(ex_amount) as sum_exp from expense  where exp_date between str_to_date('$mondate','%m-%d-%Y') and  str_to_date('$date','%m-%d-%Y') and exp_ex_id='$cash_outflow_rr[ex_id]'";
        $mon_expense_arr=mysql_fetch_assoc($mon_expense_1);
        $mon_expense=$mon_expense_arr['sum_exp'];
		
		$daily_txt.='<td class="c7" align="right"><p class="c2"><span class="c11">'.number_format($mon_expense,2).'</span></p></td>
	</tr>';
	}
	$daily_txt.='
		<tr class="c4">
			<td class="c26"><p class="c19"><span class="c11">'.++$tslno.'</span></p></td>
			</td><td class="c18"><p class="c19"><span class="c11">Total Wastages</span></p></td>
			</td><td class="c18" align="right"><p class="c19"><span class="c11">'.number_format($total_wastage,2).'</span></p></td>
			<td class="c7" align="right"><p class="c2"><span class="c11">'.number_format($mon_wastage,2).'</span></p></td>
		</tr>
		<tr class="c4">
			<td class="c26"><p class="c19"><span class="c11">'.++$tslno.'</span></p></td>
			</td><td class="c18"><p class="c19"><span class="c11">Total Sales</span></p></td>
			</td><td class="c18" align="right"><p class="c19"><span class="c11">'.number_format($total_sales_sum,2).'</span></p></td>
			<td class="c7" align="right"><p class="c2"><span class="c11">'.number_format($mon_sales_sum,2).'</span></p></td>
		</tr>
		<tr class="c4">
			<td class="c26"><p class="c19"><span class="c11">'.++$tslno.'</span></p></td>
			</td><td class="c18"><p class="c19"><span class="c11">Closing Stock</span></p></td>
			</td><td class="c18" align="right"><p class="c19"><span class="c11">'.number_format($total_inventory,2).'</span></p></td>
			<td class="c7" align="right"><p class="c2"><span class="c11">N/A</span></p></td>
		</tr>
		
		<tr class="c4">
			<td class="c26"><p class="c19"><span class="c11"></span></p></td>
			</td><td class="c18" align="center"><p class="c19"><span class="c11"><b>Profit</b></span></p></td>
			</td><td class="c18" align="right"><p class="c19"><span class="c11"><b>'.number_format(00000,2).'</b></span></p></td>
			<td class="c7" align="right"><p class="c2"><span class="c11"><b>'.number_format(00000,2).'</b></span></p></td>
		</tr>
	
	'; 
	
	
	
	
			
	
	
	$daily_txt.='</tbody>
	</table><p class="c3"><span></span></p></td>
	</tr>
	</tbody>
	</table>
	<p class="c3"><span></span></p></td></tr></tbody></table><p class="c3"><span></span></p><a href="#" name="37f5b8cb45d851e9f4358440a02d0cd6b1accfa7"></a><a href="#" name="3"></a>


';



$mpdf->WriteHTML($daily_txt);



$mpdf->Output();

exit;



?>