<?php 
include('./mpdf/mpdf.php');
$mpdf=new mPDF();


$html2 = <<<ter
<html>
<head>
	<title>
		INVOICE_master
	</title><meta content="text/html; charset=UTF-8" http-equiv="content-type">
	<style type="text/css">ol{margin:0;padding:0}.c26{vertical-align:top;width:285pt;border-style:solid;background-color:#e4e4e6;border-color:#f1f1f2;border-width:0.5pt;padding:5pt 5pt 5pt 5pt}.c23{vertical-align:top;width:482.2pt;border-style:solid;background-color:#9aa9a1;border-color:#ffffff;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c20{vertical-align:top;width:103.5pt;border-style:solid;background-color:#e4e4e6;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c3{vertical-align:top;width:105.8pt;border-style:solid;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c27{vertical-align:top;width:58.5pt;border-style:solid;border-color:#000000;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c24{vertical-align:top;width:194.2pt;border-style:solid;border-color:#000000;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c19{vertical-align:top;width:285.8pt;border-style:solid;border-color:#f1f1f2;border-width:0.5pt;padding:5pt 5pt 5pt 5pt}.c40{vertical-align:top;width:90pt;border-style:solid;border-color:#ffffff;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c39{vertical-align:top;width:250.5pt;border-style:solid;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c37{vertical-align:top;width:103.5pt;border-style:solid;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c28{vertical-align:top;width:112.5pt;border-style:solid;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c1{vertical-align:baseline;color:#7e8076;font-style:normal;font-family:"Arial";text-decoration:none;font-weight:bold}.c11{line-height:1.0;padding-top:0pt;text-align:left;margin-left:0.8pt;padding-bottom:0pt}.c33{vertical-align:baseline;font-size:10pt;font-family:"Arial";text-decoration:none;font-weight:normal}.c6{line-height:1.0;padding-top:0pt;text-align:right;direction:ltr;padding-bottom:0pt}.c17{line-height:1.0;padding-top:0pt;text-align:left;padding-bottom:0pt}.c0{color:#1155cc;background-color:#9aa9a1;text-decoration:underline}.c5{color:#ffffff;background-color:#9aa9a1;font-weight:bold}.c34{max-width:552.1pt;background-color:#ffffff;padding:50.4pt 21.6pt 50.4pt 21.6pt}.c13{margin-right:auto;border-collapse:collapse}.c25{line-height:1.0;padding-top:0pt;padding-bottom:0pt}.c12{line-height:1.5;direction:ltr}.c2{height:10pt;direction:ltr}.c43{color:inherit;text-decoration:inherit}.c35{line-height:1.15;text-align:left}.c8{text-align:right;direction:ltr}.c30{line-height:1.15;text-indent:36pt}.c4{color:#e4e4e6;background-color:#9aa9a1}.c44{font-size:24pt;font-family:"Verdana"}.c42{padding-top:0pt;padding-bottom:0pt}.c14{line-height:1.0;text-align:right}.c32{color:#e4e4e6}.c38{font-weight:normal}.c31{background-color:#e4e4e6}.c41{margin-left:0.8pt}.c7{color:#7e8076}.c9{font-weight:bold}.c18{color:#ffffff}.c29{height:0pt}.c16{font-style:normal}.c22{direction:ltr}.c10{font-size:8pt}.c15{background-color:#f1f1f2}.c21{font-size:30pt}.c36{height:61pt}.title{padding-top:0pt;line-height:1.15;text-align:left;color:#c2c2c4;font-size:48pt;font-family:"Arial";padding-bottom:0pt}.subtitle{padding-top:0pt;line-height:1.0;text-align:right;color:#ffffff;font-size:24pt;background-color:#9aa9a1;font-family:"Arial";font-weight:bold;padding-bottom:0pt}li{color:#7e8076;font-size:10pt;font-family:"Arial"}p{color:#7e8076;font-size:10pt;margin:0;font-family:"Arial"}h1{padding-top:0pt;line-height:1.0;text-align:left;color:#7e8076;font-size:8pt;font-family:"Arial";font-weight:bold;padding-bottom:0pt}h2{padding-top:0pt;line-height:1.0;text-align:right;color:#7e8076;font-size:8pt;font-family:"Arial";padding-bottom:0pt}h3{padding-top:0pt;line-height:1.5;text-align:left;color:#7e8076;font-size:9pt;font-family:"Arial";padding-bottom:0pt}h4{padding-top:0pt;line-height:1.5;text-align:left;color:#434343;font-size:8pt;font-family:"Arial";padding-bottom:0pt}h5{padding-top:0pt;line-height:1.0;text-align:right;color:#ffffff;font-size:10pt;background-color:#9aa9a1;font-family:"Arial";padding-bottom:0pt}h6{padding-top:0pt;line-height:1.0;text-align:left;color:#666666;font-size:8pt;background-color:#e4e4e6;font-family:"Arial";padding-bottom:0pt}</style></head><body class="c34"><p class="c22 c35 title"><a name="h.9ryq27p4pmwc"></a><span class="c44">TAAZA TARKARI </span><span class="c21">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><img height="52" src="images/image00.jpg" width="53"></p><a href="#" name="3e1982bb5404f03c220cbf95fcdfcf8e7179c3a3"></a><a href="#" name="0"></a>
	
	<table cellpadding="0" cellspacing="0" class="c13">
	<tbody>
		<tr class="c36">
			<td class="c31 c40"><p class="c2"><span class="c10 c18"></span></p><h6 class="c22"><a name="h.4ms4pjdvvcn5"></a><span>Aug 15, 2012<br></span></h6><h6 class="c22"><a name="h.4ms4pjdvvcn5"></a><span>Invoice No. XXXX</span></h6></td>
			<td class="c23"><p class="c8 subtitle"><a name="h.f9dtygnsfopk"></a><span>INVOICE</span></p><h5 class="c8"><a name="h.rm9y3hcs0pf"></a><span class="c38">Prepared for </span><span>Shopper City Shop</span></h5><h5 class="c8"><a name="h.6bllre6rkd7y"></a><span class="c38">John Cooper &bull; 000.000.000</span></h5></td>
		</tr>
	</tbody>
	</table>
	
	<p class="c2"><span class="c7"></span></p><a href="#" name="dba8ca4f4bf2cf451b6c3f15600cc260b2a622fa"></a><a href="#" name="1"></a>
	
	
	<table cellpadding="0" cellspacing="0" class="c13">
	<tbody>
		<tr class="c29">
			<td class="c39 c15"><h1 class="c22"><a name="h.8qi986j2qqlt"></a><span>ITEMS</span></h1></td>
			<td class="c15 c28"><h2 class="c8"><a name="h.rmx9glyl9qk1"></a><span class="c7 c9 c16 c10">QTY</span></h2></td>
			<td class="c3 c15"><h2 class="c8"><a name="h.rmx9glyl9qk1"></a><span class="c7 c9 c10 c16">UNIT PRICE</span></h2></td>
			<td class="c37 c15"><h2 class="c8"><a name="h.rmx9glyl9qk1"></a><span class="c7 c9 c16 c10">SUB TOTAL</span></h2></td>
		</tr>
		
		<tr class="c29">
			<td class="c39"><p class="c22"><span class="c7">Item number one: description of the work that was completed</span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span class="c7"></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span></span></p><p class="c2"><span class="c7"></span></p><p class="c2"><span class="c7"></span></p></td>
			<td class="c28"><p class="c8"><span>6</span><span class="c7">&nbsp;hrs</span></p></td>
			<td class="c3"><p class="c8"><span class="c7">$25/hr</span></p></td>
			<td class="c15 c37"><p class="c8"><span class="c7">$125</span></p></td>
		</tr>
		
		<tr class="c29">
			<td class="c39"><p class="c2 c17"><span class="c7 c16 c33"></span></p></td>
			<td class="c28"><p class="c2 c11"><span class="c33 c7 c16"></span></p></td>
			<td class="c3 c31"><h1 class="c6 c41"><a name="h.yg9sa2ezkvpj"></a><span>SUB TOTAL</span></h1></td>
			<td class="c20"><p class="c11 c2"><span class="c33 c7 c16"></span></p></td>
		</tr>
	</tbody>
	</table>
	<p class="c2"><span class="c7"></span></p><p class="c2"><span class="c7"></span></p><a href="#" name="1f01dc49e4b879cbce4f74b963a9592e1032c917"></a><a href="#" name="2"></a>
	
	
	<table cellpadding="0" cellspacing="0" class="c13">
	<tbody>
		<tr class="c29">
			<td class="c19"><h3 class="c12"><a name="h.ifr7ajoyoea7"></a><span class="c7 c9">PAYMENT TERMS </span></h3><p class="c25 c22"><span>To be paid in full. </span></p><p class="c25 c2"><span></span></p><p class="c25 c22"><span>Thanks for doing business with us</span></p><p class="c25 c2"><span></span></p><p class="c25 c2"><span></span></p><p class="c2 c25"><span></span></p></td>
			<td class="c26"><p class="c2 c14"><span class="c9"></span></p><a href="#" name="a493544ab5b91c6f55868936d0ba55a99f78f3fc"></a><a href="#" name="3"></a>
				<table cellpadding="0" cellspacing="0" class="c13">
					<tbody>
					<tr>
						<td class="c24"><p class="c6"><span class="c9">LAST BILL :</span></p><p class="c6"><span class="c9">LAST PAYMENT : </span></p><p class="c6"><span class="c9">CREDIT :</span></p></td>
						<td class="c27"><p class="c6"><span class="c9">1000</span></p><p class="c6"><span class="c9">700</span></p><p class="c6"><span class="c9">300</span></p></td>
					</tr>
					<tr class="c29">
						<td class="c24"><p class="c6"><span class="c9">GRAND TOTAL :</span></p></td>
						<td class="c27"><p class="c6"><span class="c9">4000</span></p></td>
					</tr></tbody></table><p class="c2 c14"><span class="c9"></span></p>
			</td>
		</tr>
	</tbody>
	</table>
	
	
	<p class="c2"><span></span></p><div><p align="middle" class="c22 c30"><span class="c5">Taaza Tarkari Agro India PVT LTD : &nbsp;&nbsp;  Thanks for doing business with us </span></p><p class="c2 c30"><span class="c4"></span></p><a href="#" name="fb9fb93011ad78ca1e36c4c1e56fdf04d009bd67"></a><a href="#" name="4"></a><table cellpadding="0" cellspacing="0" class="c13"><tbody></tbody></table><p class="c2 c35 c42"><span></span></p></div>
	
	
	
	</body></html>
ter;

$mpdf->WriteHTML($html2);

$mpdf->Output();
exit;
	
	
	?>
	
	
	
	
	
	
	
	