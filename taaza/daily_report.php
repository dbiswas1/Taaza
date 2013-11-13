<!-- To Avoid resubmitting -->
<?php

    include 'db_config.php' ;
  		
	$conn=new createConnection();
	$conn->connect();
	$conn->selectdb();

	session_start();	
	

	if (  isset($_POST["in_btn"]) )
	{
		
	if ($_POST["formid"] == $_SESSION["formid"])
	{
		$_SESSION["formid"] = '';
		
	}
	else
		exit ;
	}
	else
	{
		$_SESSION["formid"] = md5(rand(0,10000000));
	}
	
	
?>


<!DOCTYPE html>
<html class="sidebar_default no-js" lang="en">
<head>
<meta charset="utf-8">
<title>Taaza Tarkari- Daily Report</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="css/images/favicon.png">
<!-- Le styles -->
<link href="js/plugins/chosen/chosen/chosen.css" rel="stylesheet">
<link href="css/twitter/bootstrap.css" rel="stylesheet">
<link href="css/base.css" rel="stylesheet">
<link href="css/twitter/responsive.css" rel="stylesheet">
<link href="css/jquery-ui-1.8.23.custom.css" rel="stylesheet">
<script src="js/plugins/modernizr.custom.32549.js"></script>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
</head>

<body>
<div id="loading"><img src="img/ajax-loader.gif"></div>
<div id="responsive_part">
  <div class="logo"> <a href="index.html"><span>Start</span><span class="icon"></span></a> </div>
  <ul class="nav responsive">
    <li>
      <button class="btn responsive_menu icon_item" data-toggle="collapse" data-target=".overview"> <i class="icon-reorder"></i> </button>
    </li>
  </ul>
</div>
<?php include 'Menu.php' ; ?>
<!-- End sidebar_box --> 
      
    </div>
  </div>
</div>
<div id="main">
  <div class="container">
		<?php include 'top.php' ; ?>
		<!-- End Top Right -->
   
   
    <?php 
   
   		
		$date = date('m-d-Y'); 
		$ddate=date('M-d-Y');
		
		if(isset($_POST['idate']))
		{
			 $date=$_POST['idate'];
			 $ddate=str_replace("-", "/", $_POST['idate']);
		
			 
		}
		
    ?>
   
    <div id="main_container">
      <div class="row-fluid">
        <div class="span12">
        <form name="date_form" action="daily_report.php?report=active&d_report=active"  method="post">
          <div class="box paint color_19">
            <div class="title">
              <h4> <i class="icon-book"></i><span>Daily Report (<?php echo date('M-d-Y', strtotime($ddate));?>)  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Change Date: <input align="right" class="span2" name="idate" type="text" id="datepicker1" value="<?php echo $date ;?>" class="row-fluid"></span> </h4>
            
			              
               
             </div>
             
        
        
       <div class="content">
       <?php 
       $total_sales_sum_query=mysql_query("select sum(amount) as totalsales from invoice where date_format(in_date,'%m-%d-%Y')='$date'");
       $total_sales_sum_arr=mysql_fetch_assoc($total_sales_sum_query);
       $total_sales_sum=$total_sales_sum_arr['totalsales'];
       
       ?>
       <i class=" icon-bar-chart"></i><span><b>&nbsp;&nbsp;&nbsp;Total Sales : Rs <?php echo $total_sales_sum ;?></b></span>
          <table class="table table-condensed table-striped">
            <thead>
              <tr>
                <th> SL# </th>
                <th> Invoice #</th>
                <th> Shop Name </th>
                <th> Amount </th>
              </tr>
            </thead>
            <tbody>
            <?php 
            	$total_sales_query=mysql_query("select i.invoice_no,c.shop_name,i.amount from client c, invoice i where i.in_c_id=c.c_id and date_format(in_date,'%m-%d-%Y')='$date' order by amount desc");
            	$tslno=0;
            	while($total_sales_arr=mysql_fetch_array($total_sales_query)){
				++$tslno;            
            ?>
              
              <tr>
                <td> <?php echo $tslno ;?> </td>
                <td> <?php echo $total_sales_arr['invoice_no'] ;?> </td>
                <td> <?php echo $total_sales_arr['shop_name'] ;?> </td>
                <td> <?php echo $total_sales_arr['amount'] ;?> </td>
              </tr>
              <?php }?>
            
            </tbody>
          </table>

          <!-- End .box -->
       
       </div>
       
       <div class="content">
       <?php 
      			$date1=$date;
      			$date1 = date("m-d-Y",strtotime("-1 day",strtotime($ddate)));
      			//echo $date."-".$date1;
       			$total_pur_sum_query=mysql_query("select sum(p_price) as totalpurchase from purchase_order where date_format(p_date,'%m-%d-%Y')='$date'");
       			$tota_pur_sum_arr=mysql_fetch_array($total_pur_sum_query);
       			$total_pur_sum=$tota_pur_sum_arr['totalpurchase'];
       
       ?>
       <i class=" icon-bar-chart"></i><span><b>&nbsp;&nbsp;&nbsp;Total Purchase : Rs <?php echo $total_pur_sum ;?></b></span>
          <table class="table table-condensed table-striped">
            <thead>
              <tr>
                <th> SL# </th>
                <th> Market</th>
                <th> Current Due  </th>
                
                <th> Amount </th>
              </tr>
            </thead>
            <tbody>
            <?php 
            	$p_due_total=0;
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
            ?>
              <tr>
                <td> <?php echo $pslno; ?> </td>
                <td> <?php echo $purchase_arr['market_name']; ?> </td>
                <td> <?php echo $purchase_due ; ?> </td>
               
                <td> <?php echo $purchase_arr['totalpurchase']; ?> </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>

          <!-- End .box -->
       
       </div>
       
        <div class="content">
        <?php 
        	$ctotal_due=0;
        	$coll_sum_query=mysql_query("select sum(paid) as paid from payment_master  where date_format(date,'%m-%d-%Y')='$date' and  paid!=0");
        	$coll_sum_arr=mysql_fetch_assoc($coll_sum_query);
        	$coll_sum=$coll_sum_arr['paid'];
        	
        	$coll_query=mysql_query("select c.c_id,c.shop_name,pm.paid from payment_master pm, client c where date_format(date,'%m-%d-%Y')='$date' and pm.pay_c_id=c.c_id and paid!=0");
        	
        		
        ?>
       <i class=" icon-bar-chart"></i><span><b>&nbsp;&nbsp;&nbsp;Total Collection : Rs <?php echo $coll_sum ;?></b></span>
          <table class="table table-condensed table-striped">
            <thead>
              <tr>
                <th> SL# </th>
                <th> Shop &nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th> Current Due</th>
                <th> Amount </th>
              </tr>
            </thead>
            <tbody>
            <?php    
            
            	$cslno=0;
            	while($col_arr=mysql_fetch_array($coll_query)){
            	$coll_due_query=mysql_query("select dues from payment_master where pay_c_id='$col_arr[c_id]' and date_format(date,'%m-%d-%Y')='$date' order by pay_id desc limit 1");
            	$coll_due_arr=mysql_fetch_assoc($coll_due_query);
            	$coll_due=$coll_due_arr['dues'];
            
            ?>
              <tr>
                <td> <?php echo ++$cslno;?> </td>
                <td> <?php echo $col_arr['shop_name'];?> </td>
                <td> <?php echo $coll_due ;?> </td>
                <td> <?php echo $col_arr['paid'];?>  </td>
              </tr>
              
              <?php }?>
            
            </tbody>
          </table>

          <!-- End .box -->
       
       </div>
       
       
       <div class="content">
       <?php 
       		$eslno=0;
       		$exp_sum_query=mysql_query("select sum(ex_amount) as totalexpense from expense where date_format(exp_date,'%m-%d-%Y')='$date'");
       		$exp_sum_arr=mysql_fetch_assoc($exp_sum_query);
       		$exp_sum=$exp_sum_arr['totalexpense'];
       		$exp_query=mysql_query("select e.emp_name,et.ex_type,ex.ex_amount from employee e, expense_type et, expense ex where date_format(ex.exp_date,'%m-%d-%Y')='$date' and ex.exp_ex_id=et.ex_id and ex.exp_emp_id=e.emp_id");
       
       
       ?>
       <i class=" icon-bar-chart"></i><span><b>&nbsp;&nbsp;&nbsp;Total Expense : Rs <?php echo $exp_sum ;?></b></span>
          <table class="table table-condensed table-striped">
            <thead>
              <tr>
                <th> SL# </th>
                <th> Person</th>
                <th> Expense Type </th>
                <th> Amount </th>
              </tr>
            </thead>
            <tbody>
            <?php 
            	while($exp_arr=mysql_fetch_array($exp_query)){
            	++$eslno;
            ?>
              <tr>
                <td> <?php echo $eslno ;?> </td>
                <td> <?php echo $exp_arr['emp_name'];?> </td>
                <td> <?php echo $exp_arr['ex_type'];?> </td>
                <td> <?php echo $exp_arr['ex_amount'];?> </td>
              </tr>
              <?php }?>
            
            </tbody>
          </table>

          <!-- End .box -->
       
       </div>
      <div class="content">
       <i class=" icon-bar-chart"></i><span><b>&nbsp;&nbsp;&nbsp;Summary</b></span>
          <table class="table table-condensed table-striped">
            <thead>
              <tr>
                <th> Type </th>
                <th> Amount</th>
                
              </tr>
            </thead>
            <tbody>
              <tr>
                <td> Total Sales </td>
                <td> <?php echo  number_format($total_sales_sum,2); ?> </td>
                
              </tr>
              <tr>
                <td> Total Purchase </td>
                <td> <?php echo number_format($total_pur_sum,2) ;?> </td>
                
              </tr>
              <tr>
                <td> Total Dues to be Paid </td>
                <td> <?php 
                
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
                		echo number_format($p_due_total,2) ;?> </td>
                
              </tr>
              <tr>
                <td> Total Collection </td>
                <td> <?php echo  number_format($coll_sum,2); ?> </td>
                
              </tr>
               <tr>
                <td> Total Dues to be Recieved </td>
                <td> <?php 
                	
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
                
                
                echo  number_format($ctotal_due,2); ?> </td>
                
              </tr>
            
               <tr>
                <td> Total Expense </td>
                <td> <?php echo  number_format($exp_sum,2); ?> </td>
                
              </tr>
              <tr>
                <td> Total Wastage </td>
                <td><?php 
                	$total_wastage_query=mysql_query("select sum(price*qty) as totalwasatge  from wastage_history where date_format(date,'%m-%d-%Y')='$date'");
                	$total_wastage_arr=mysql_fetch_assoc($total_wastage_query);
                	$total_wastage=$total_wastage_arr['totalwasatge'];

                	echo  number_format($total_wastage,2);
                
                ?>  </td>
                
              </tr>
              <tr>
                <td> Total Inventory Stock Amount   </td>
                <td>  </td>
                
              </tr>
            
            </tbody>
          </table>

          <!-- End .box -->
       
       </div>
       
          <div class="accordion" id="accordion3">
                <div class="accordion-group">
                  <div id="collapseOne1" class="accordion-body collapse" style="height: 0px; ">
                    <div class="accordion-inner"><textarea id="text" name="notes" rows="3" class="row-fluid"></textarea></div>
                  </div>
                </div>
          
        </div>
        <!-- End Content -->
       
		         
                  
       <p align="center"> <button  type="submit" name="in_btn" value="inden" class="btn btn-primary">Print</button> </p>
        </div>
        <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
        </form>
        <!-- End Box --> 
        	 
      </div>
      <!-- End span12 -->
    </div>
    
     
    <?php $conn->close(); ?>
				
				
		  
            
   
  </div> <!-- End #container -->
   		<?php include 'foot.php' ; ?>
		 <!-- End Footer -->
		
<div class="background_changer dropdown">
  <div class="dropdown" id="colors_pallete"> <a data-toggle="dropdown" data-target="drop4" class="change_color"></a>
    <ul  class="dropdown-menu pull-left" role="menu" aria-labelledby="drop4">
      <li><a data-color="color_0" class="color_0" tabindex="-1">1</a></li>
      <li><a data-color="color_1" class="color_1" tabindex="-1">1</a></li>
      <li><a data-color="color_2" class="color_2" tabindex="-1">2</a></li>
      <li><a data-color="color_3" class="color_3" tabindex="-1">3</a></li>
      <li><a data-color="color_4" class="color_4" tabindex="-1">4</a></li>
      <li><a data-color="color_5" class="color_5" tabindex="-1">5</a></li>
      <li><a data-color="color_6" class="color_6" tabindex="-1">6</a></li>
      <li><a data-color="color_7" class="color_7" tabindex="-1">7</a></li>
      <li><a data-color="color_8" class="color_8" tabindex="-1">8</a></li>
      <li><a data-color="color_9" class="color_9" tabindex="-1">9</a></li>
      <li><a data-color="color_10" class="color_10" tabindex="-1">10</a></li>
      <li><a data-color="color_11" class="color_11" tabindex="-1">10</a></li>
      <li><a data-color="color_12" class="color_12" tabindex="-1">12</a></li>
      <li><a data-color="color_13" class="color_13" tabindex="-1">13</a></li>
      <li><a data-color="color_14" class="color_14" tabindex="-1">14</a></li>
      <li><a data-color="color_15" class="color_15" tabindex="-1">15</a></li>
      <li><a data-color="color_16" class="color_16" tabindex="-1">16</a></li>
      <li><a data-color="color_17" class="color_17" tabindex="-1">17</a></li>
      <li><a data-color="color_18" class="color_18" tabindex="-1">18</a></li>
      <li><a data-color="color_19" class="color_19" tabindex="-1">19</a></li>
      <li><a data-color="color_20" class="color_20" tabindex="-1">20</a></li>
      <li><a data-color="color_21" class="color_21" tabindex="-1">21</a></li>
      <li><a data-color="color_22" class="color_22" tabindex="-1">22</a></li>
      <li><a data-color="color_23" class="color_23" tabindex="-1">23</a></li>
      <li><a data-color="color_24" class="color_24" tabindex="-1">24</a></li>
      <li><a data-color="color_25" class="color_25" tabindex="-1">25</a></li>
    </ul>
  </div>
</div>
<!-- End .background_changer -->
</div>
<!-- /container --> 

<!-- Le javascript
    ================================================== --> 
<!-- General scripts --> 
<script src="js/jquery.js" type="text/javascript"> </script> 
<!--[if !IE]> -->
<script src="js/plugins/enquire.min.js" type="text/javascript"></script> 
<!-- <![endif]-->
<script language="javascript" type="text/javascript" src="js/plugins/jquery.sparkline.min.js"></script> 
<script src="js/plugins/excanvas.compiled.js" type="text/javascript"></script> 
<script src="js/bootstrap-transition.js" type="text/javascript"></script> 
<script src="js/bootstrap-alert.js" type="text/javascript"></script> 
<script src="js/bootstrap-modal.js" type="text/javascript"></script> 
<script src="js/bootstrap-dropdown.js" type="text/javascript"></script> 
<script src="js/bootstrap-scrollspy.js" type="text/javascript"></script> 
<script src="js/bootstrap-tab.js" type="text/javascript"></script> 
<script src="js/bootstrap-tooltip.js" type="text/javascript"></script> 
<script src="js/bootstrap-popover.js" type="text/javascript"></script> 
<script src="js/bootstrap-button.js" type="text/javascript"></script> 
<script src="js/bootstrap-collapse.js" type="text/javascript"></script> 
<script src="js/bootstrap-carousel.js" type="text/javascript"></script> 
<script src="js/bootstrap-typeahead.js" type="text/javascript"></script> 
<script src="js/bootstrap-affix.js" type="text/javascript"></script> 
<script src="js/fileinput.jquery.js" type="text/javascript"></script> 
<script src="js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script> 
<script src="js/jquery.touchdown.js" type="text/javascript"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/jquery.uniform.min.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/jquery.tinyscrollbar.min.js"></script> 
<script language="javascript" type="text/javascript" src="js/jnavigate.jquery.min.js"></script> 
<script language="javascript" type="text/javascript" src="js/jquery.touchSwipe.min.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/jquery.peity.min.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/wysihtml5-0.3.0.min.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/bootstrap-wysihtml5.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/jquery.peity.min.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/textarea-autogrow.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/character-limit.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/jquery.maskedinput-1.3.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/chosen/chosen/chosen.jquery.min.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/bootstrap-datepicker.js"></script> 
<script language="javascript" type="text/javascript" src="js/plugins/bootstrap-colorpicker.js"></script> 

<!-- Custom made scripts for this template --> 
<script src="js/scripts.js" type="text/javascript"></script> 
<script type="text/javascript">
  /**** Specific JS for this page ****/
  
  
function validate(x)
{
	if (!x == '') {
		document.indentform.submit();
		return true;
	}
	else{
		alert ('Select a Client');
		return false;
	}
		
   
} 



function extractNumber(obj, decimalPlaces, allowNegative)
{
	var temp = obj.value;
	
	// avoid changing things if already formatted correctly
	var reg0Str = '[0-9]*';
	if (decimalPlaces > 0) {
		reg0Str += '\\.?[0-9]{0,' + decimalPlaces + '}';
	} else if (decimalPlaces < 0) {
		reg0Str += '\\.?[0-9]*';
	}
	reg0Str = allowNegative ? '^-?' + reg0Str : '^' + reg0Str;
	reg0Str = reg0Str + '$';
	var reg0 = new RegExp(reg0Str);
	if (reg0.test(temp)) return true;

	// first replace all non numbers
	var reg1Str = '[^0-9' + (decimalPlaces != 0 ? '.' : '') + (allowNegative ? '-' : '') + ']';
	var reg1 = new RegExp(reg1Str, 'g');
	temp = temp.replace(reg1, '');

	if (allowNegative) {
		// replace extra negative
		var hasNegative = temp.length > 0 && temp.charAt(0) == '-';
		var reg2 = /-/g;
		temp = temp.replace(reg2, '');
		if (hasNegative) temp = '-' + temp;
	}
	
	if (decimalPlaces != 0) {
		var reg3 = /\./g;
		var reg3Array = reg3.exec(temp);
		if (reg3Array != null) {
			// keep only first occurrence of .
			//  and the number of places specified by decimalPlaces or the entire string if decimalPlaces < 0
			var reg3Right = temp.substring(reg3Array.index + reg3Array[0].length);
			reg3Right = reg3Right.replace(reg3, '');
			reg3Right = decimalPlaces > 0 ? reg3Right.substring(0, decimalPlaces) : reg3Right;
			temp = temp.substring(0,reg3Array.index) + '.' + reg3Right;
		}
	}
	
	obj.value = temp;
}
function blockNonNumbers(obj, e, allowDecimal, allowNegative)
{
	var key;
	var isCtrl = false;
	var keychar;
	var reg;
		
	if(window.event) {
		key = e.keyCode;
		isCtrl = window.event.ctrlKey
	}
	else if(e.which) {
		key = e.which;
		isCtrl = e.ctrlKey;
	}
	
	if (isNaN(key)) return true;
	
	keychar = String.fromCharCode(key);
	
	// check for backspace or delete, or if Ctrl was pressed
	if (key == 8 || isCtrl)
	{
		return true;
	}

	reg = /\d/;
	var isFirstN = allowNegative ? keychar == '-' && obj.value.indexOf('-') == -1 : false;
	var isFirstD = allowDecimal ? keychar == '.' && obj.value.indexOf('.') == -1 : false;
	
	return isFirstN || isFirstD || reg.test(keychar);
}
  
  
  
  
  
  
  
 $(document).ready(function () {
       
        $('textarea.autogrow').autogrow();
        var elem = $("#chars");
        $("#text").limiter(100, elem);
        // Mask plugin http://digitalbush.com/projects/masked-input-plugin/
        $("#mask-phone").mask("(999) 999-9999");
        $("#mask-date").mask("99-99-9999");
        $("#mask-int-phone").mask("+33 999 999 999");
        $("#mask-tax-id").mask("99-9999999");
        $("#mask-percent").mask("99%");
        // Editor plugin https://github.com/jhollingworth/bootstrap-wysihtml5/
        $('#editor1').wysihtml5({
          "image": false,
          "link": false
          });
        // Chosen select plugin
        $(".chzn-select").chosen({
          disable_search_threshold: 10
        });
        // Datepicker
        $('#datepicker1').datepicker({
          format: 'mm-dd-yyyy'
        }).on('changeDate', function (ev) {
        	
            $(this).datepicker('hide');
            document.date_form.submit();
            
        });;
        $('#datepicker7').datepicker({
            format: 'mm-dd-yyyy'
          }).on('changeDate', function (ev) {
              $(this).datepicker('hide');
          });;
        $('#datepicker2').datepicker();
        $('.colorpicker').colorpicker()
        $('#colorpicker3').colorpicker();
    });



</script>
</body>
</html>