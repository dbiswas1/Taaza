
<?php 
include('./mpdf/mpdf.php');
$mpdf=new mPDF();
$mpdf->SetFooter('Taaza Tarkari Agro India PVT LTD ||Page {PAGENO} of {nb}');
$invoice_txt = <<<invoice
<html><head><title>INVOICE_master</title>
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<style type="text/css">ol{margin:0;padding:0}.c28{vertical-align:top;width:285pt;border-style:solid;background-color:#e4e4e6;border-color:#f1f1f2;border-width:0.5pt;padding:5pt 5pt 5pt 5pt}.c2{vertical-align:top;width:90pt;border-style:solid;background-color:#e4e4e6;border-color:#ffffff;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c38{vertical-align:top;width:103.5pt;border-style:solid;background-color:#e4e4e6;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c36{vertical-align:top;width:105.8pt;border-style:solid;background-color:#e4e4e6;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c9{vertical-align:top;width:103.5pt;border-style:solid;background-color:#f1f1f2;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c40{vertical-align:top;width:58.5pt;border-style:solid;border-color:#000000;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c19{vertical-align:top;width:112.5pt;border-style:solid;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c25{vertical-align:top;width:285.8pt;border-style:solid;border-color:#f1f1f2;border-width:0.5pt;padding:5pt 5pt 5pt 5pt}.c11{vertical-align:baseline;font-size:10pt;font-style:normal;font-family:"Arial";text-decoration:none;font-weight:normal}.c37{vertical-align:top;width:136.5pt;border-style:solid;border-color:#000000;border-width:0pt;padding:5pt 5pt 5pt 5pt}.c42{vertical-align:top;width:18pt;border-style:solid;border-color:#000000;border-width:0pt;padding:5pt 5pt 5pt 5pt}.c34{vertical-align:top;width:482.2pt;border-style:solid;border-color:#ffffff;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c32{vertical-align:top;width:194.2pt;border-style:solid;border-color:#000000;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c39{vertical-align:top;width:105.8pt;border-style:solid;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c0{vertical-align:top;width:250.5pt;border-style:solid;border-color:#efefef;border-width:1pt;padding:5pt 5pt 5pt 5pt}.c21{line-height:1.15;padding-top:0pt;text-align:left;padding-bottom:0pt}.c15{vertical-align:baseline;font-style:normal;font-family:"Arial";text-decoration:none}.c3{margin-right:auto;border-collapse:collapse}.c8{line-height:1.0;padding-top:0pt;padding-bottom:0pt}.c4{max-width:552.1pt;background-color:#ffffff;padding:50.4pt 21.6pt 50.4pt 21.6pt}.c17{line-height:1.0;text-align:left}.c1{text-align:right;direction:ltr}.c41{font-size:12pt;font-family:"Verdana"}.c14{line-height:1.5;direction:ltr}.c18{font-size:8pt;font-style:normal}.c22{color:#ffffff;font-size:8pt}.c6{height:10pt;direction:ltr}.c13{text-align:left;margin-left:0.8pt}.c26{line-height:1.15}.c29{color:#c2c2c4}.c20{height:0pt}.c33{background-color:#9aa9a1}.c43{margin-left:0.8pt}.c10{background-color:#f1f1f2}.c12{height:61pt}.c35{font-size:8pt}.c16{font-weight:normal}.c31{color:#e4e4e6}.c5{color:#7e8076}.c23{direction:ltr}.c24{height:10pt}.c30{text-align:left}.c45{font-size:12pt}.c7{font-weight:bold}.c27{font-size:30pt}.c44{line-height:1.0}.title{padding-top:0pt;line-height:1.15;text-align:left;color:#c2c2c4;font-size:48pt;font-family:"Arial";padding-bottom:0pt}.subtitle{padding-top:0pt;line-height:1.0;text-align:right;color:#ffffff;font-size:24pt;background-color:#9aa9a1;font-family:"Arial";font-weight:bold;padding-bottom:0pt}li{color:#7e8076;font-size:10pt;font-family:"Arial"}p{color:#7e8076;font-size:10pt;margin:0;font-family:"Arial"}h1{padding-top:0pt;line-height:1.0;text-align:left;color:#7e8076;font-size:8pt;font-family:"Arial";font-weight:bold;padding-bottom:0pt}h2{padding-top:0pt;line-height:1.0;text-align:right;color:#7e8076;font-size:8pt;font-family:"Arial";padding-bottom:0pt}h3{padding-top:0pt;line-height:1.5;text-align:left;color:#7e8076;font-size:9pt;font-family:"Arial";padding-bottom:0pt}h4{padding-top:0pt;line-height:1.5;text-align:left;color:#434343;font-size:8pt;font-family:"Arial";padding-bottom:0pt}h5{padding-top:0pt;line-height:1.0;text-align:right;color:#ffffff;font-size:10pt;background-color:#9aa9a1;font-family:"Arial";padding-bottom:0pt}h6{padding-top:0pt;line-height:1.0;text-align:left;color:#666666;font-size:8pt;background-color:#e4e4e6;font-family:"Arial";padding-bottom:0pt}</style>
</head><body class="c4">
<div><p class="c23"><img height="52" src="images/image00.jpg" width="53"><span class="c27 c29">&nbsp;</span><span class="c29 c7 c41">TAAZA TARKARI AGRO INDIA PVT LTD </span></p></div>
<p class="c26 c23 c30 title"><a name="h.9ryq27p4pmwc"></a><span class="c27">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span></p>
<a href="#" name="9f7713ad245e8a357a6ce4d5f2ac972b27d7afab"></a><a href="#" name="0"></a>
	<table cellpadding="0" cellspacing="0" class="c3" >
	<tbody>
	<tr class="c12">
		<td class="c2"><p class="c1 c24"><span class="c22"></span></p><h6 class="c1"><a name="h.4ms4pjdvvcn5"></a><span>Aug 15, 2012<br></span></h6><h6 class="c1"><a name="h.4ms4pjdvvcn5"></a><span>Invoice No. XXXX</span></h6></td>
		<td class="c33 c34" align="right"><p class="c23 subtitle"><a name="h.f9dtygnsfopk"></a><span>INVOICE</span></p><h5 class="c23"><a name="h.rm9y3hcs0pf"></a><span class="c16">Prepared for </span><span>Shopper City Shop</span></h5><h5 class="c23"><a name="h.pjxe0e68da60"></a><span class="c16">John Cooper &bull; 000.000.000</span></h5><p class="c8 c1 c24"><span></span></p></td>
		
	</tr>
	</tbody>
	</table>
	<p class="c6"><span class="c5"></span></p><a href="#" name="dba8ca4f4bf2cf451b6c3f15600cc260b2a622fa"></a><a href="#" name="1"></a>
	<table cellpadding="0" cellspacing="0" class="c3">
	<tbody>
		<tr class="c20">
			
			<td class="c0 c10" align="left"><h1 class="c23"><a name="h.8qi986j2qqlt"></a><span>ITEMS</span></h1></td>
			<td class="c19 c10" align="right"><h2 class="c1"><a name="h.rmx9glyl9qk1"></a><span class="c18 c5 c7">QTY</span></h2></td>
			<td class="c10 c39" align="right"><h2 class="c1"><a name="h.rmx9glyl9qk1"></a><span class="c5 c7 c18">UNIT PRICE</span></h2></td>
			<td class="c9" align="right"><h2 class="c1"><a name="h.rmx9glyl9qk1"></a><span class="c18 c5 c7">SUB TOTAL</span></h2></td>
			
			</tr>
			
			<tr class="c20">
				<td class="c0" ><p class="c23"><span class="c5">Onion</span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span class="c5"></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span></span></p><p class="c6"><span class="c5"></span></p><p class="c6"><span class="c5"></span></p></td>
				<td class="c19" align="right"><p class="c1" ><span>6</span><span class="c5">&nbsp;hrs</span></p></td>
				<td class="c39" align="right"><p class="c1" ><span class="c5">$25/hr</span></p></td>
				<td class="c9" align="right"><p class="c1" ><span class="c5">$125</span></p></td>
				</tr>
				<tr class="c20">
					<td class="c0" align="center"><p class="c8 c6 c30"><span class="c11 c5">Total Items = 1</span></p></td>
					<td class="c19"><p class="c8 c6 c13"><span class="c11 c5"></span></p></td>
					<td class="c36" align="right"><h1 class="c8 c1 c43"><a name="h.yg9sa2ezkvpj"></a><span>SUB TOTAL</span></h1></td>
					<td class="c38"><p class="c8 c6 c13"><span class="c5 c11"></span></p></td>
					
				</tr>
				</tbody>
			</table>
			
			
			<p class="c6"><span class="c5"></span></p><p class="c6"><span class="c5"></span></p><a href="#" name="418fbd276a6087ce5dbcca7eaff3cfd3cbefbc89"></a><a href="#" name="2"></a>
			
			
			<table cellpadding="0" cellspacing="0" class="c3">
			<tbody>
			<tr class="c20">
				<td class="c25"><h3 class="c14"><a name="h.ifr7ajoyoea7"></a><span class="c5 c7">PAYMENT TERMS </span></h3><p class="c8 c23"><br><br><span>To be paid in full. </span></p><p class="c6 c8"><span></span></p><p class="c8 c23"><span>Thanks for doing business with us</span></p><p class="c8 c6"><span></span></p><p class="c8 c6"><span></span></p><p class="c8 c6"><span></span></p></td><td class="c28"><p class="c1 c24 c44"><span class="c7"></span></p><a href="#" name="a493544ab5b91c6f55868936d0ba55a99f78f3fc"></a><a href="#" name="3"></a><table cellpadding="0" cellspacing="0" class="c3"><tbody>
				
				<tr>
					<td class="c32" align="right"><p class="c8 c1"><span class="c7">LAST BILL :</span></p><p class="c8 c1"><span class="c7">LAST PAYMENT : </span></p><p class="c8 c1"><span class="c7">CREDIT :</span></p></td>
					
					
					<td class="c40" align="right"><p class="c8 c1"><span class="c7">1000</span></p><p class="c8 c1"><span class="c7">700</span></p><p class="c8 c1"><span class="c7">300</span></p></td>
					
				</tr>
				
				<tr class="c20"><td class="c32" align="right"><p class="c8 c1"><span class="c7">GRAND TOTAL :</span></p></td><td class="c40" align="right"><p class="c8 c1"><span class="c7">4000</span></p></td></tr>
				
				
</tbody></table><p class="c17 c6"><span class="c7"></span></p><a href="#" name="de88862835c008cbf721407b29643cf0ef46e543"></a><a href="#" name="4"></a><table cellpadding="0" cellspacing="0" class="c3"><tbody><tr><td class="c42"><p class="c8 c6 c30"><span class="c7"></span></p></td><td class="c37"><p class="c8 c6 c30"><span class="c7"></span></p></td></tr></tbody></table><p class="c6 c17"><span class="c7"></span></p></td></tr></tbody></table><p class="c6"><span></span></p><div><p class="c6 c26"><span class="c31 c33"></span></p><a href="#" name="fb9fb93011ad78ca1e36c4c1e56fdf04d009bd67"></a><a href="#" name="5"></a><table cellpadding="0" cellspacing="0" class="c3"><tbody></tbody></table><p class="c6 c21"><span></span></p></div>

</body></html>
invoice;

$mpdf->WriteHTML($invoice_txt);

$mpdf->Output();
exit;

?>