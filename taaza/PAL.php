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


<SCRIPT language="JavaScript">
<!--hide

var password;

var pass1="dingdong";

password=prompt('Please enter your password to view this page!');

if (password==pass1)
  alert('Password Correct! Click OK to enter!');
else
   {
    alert('Password INCorrect! Going to Home page!');
    window.location="Add_Indent.php?indent=active&in_indent=in&a_indent=active";
    }

//-->
</SCRIPT>


<meta charset="utf-8">
<title>Taaza Tarkari- P & L Report</title>
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
        <form name="date_form" action="PAL.php?report=active&p_report=active"  method="post">
          <div class="box paint color_19">
            <div class="title">
              <h4> <i class="icon-book"></i><span>Profit & Loss Report (<?php echo date('M-d-Y', strtotime($ddate));?>)  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Change Date: <input align="right" class="span2" name="idate" type="text" id="datepicker1" value="<?php echo $date ;?>" class="row-fluid"></span> </h4>
            
			              
               
             </div>
             
        
        
       <div class="content">
       <?php 
       $mondate=date('m-01-Y', strtotime($ddate));
       $total_sales_sum_query=mysql_query("select sum(amount) as totalsales from invoice where date_format(in_date,'%m-%d-%Y')='$date'");
       $total_sales_sum_arr=mysql_fetch_assoc($total_sales_sum_query);
       $total_sales_sum=$total_sales_sum_arr['totalsales'];
       $mon_sales_sum_query=mysql_query("select sum(amount) as totalsales from invoice where in_date between str_to_date('$mondate','%m-%d-%Y') and  str_to_date('$date','%m-%d-%Y')");
       $mon_sales_sum_arr=mysql_fetch_assoc($mon_sales_sum_query);
       $mon_sales_sum=$mon_sales_sum_arr['totalsales'];
       
       
       
       ?>
       <i class=" icon-bar-chart"></i><span><b>&nbsp;&nbsp;&nbsp;Profit & Loss Statement</b></span>
          <table class="table table-condensed table-striped">
            <thead>
              <tr>
               
                <th>Sl#</th>
                <th> Particulars </th>
                <th> For the day </th>
                <th> Month to date </th>
              </tr>
            </thead>
            <tbody>
            <?php 
            	$plno=0;
            	
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
       
            	
            	           
            ?>
              
              <tr>
               	<td><?php echo ++$plno ;?></td>
                <td> Opening Stock </td>
                <td> <?php echo $opening_stock_v ;?> </td>
                <td> <?php echo "N/A" ;?> </td>
              </tr>
              <tr>
               	<td><?php echo ++$plno ;?></td>
                <td> Total Purchases </td>
                <td> <?php echo $total_pur_sum ;?> </td>
                <td> <?php echo $mon_purr_sum ;?> </td>
              </tr>
              
              
              
             <?php $cash_outflow_1=mysql_query("select et.ex_id,et.ex_type,sum(ex.ex_amount) as sum_exp from expense_type et, expense ex where date_format(ex.exp_date,'%m-%d-%Y')='$date' and ex.exp_ex_id=et.ex_id group by et.ex_id");
             //echo "select et.ex_id,et.ex_type,sum(ex.ex_amount) as sum_exp from expense_type et, expense ex where date_format(ex.exp_date,'%m-%d-%Y')='$date' and ex.exp_ex_id=et.ex_id group by et.ex_id";
				while($cash_outflow_rr=mysql_fetch_array($cash_outflow_1)){ 
			?>
                 <tr>
               	<td><?php echo ++$plno ;?></td>
                <td> <?php echo $cash_outflow_rr['ex_type']; ?> </td>
                <td> <?php echo $cash_outflow_rr['sum_exp']; ?>  </td>
                <?php
                	$mon_expense_1=mysql_query("select sum(ex_amount) as sum_exp from expense  where exp_date between str_to_date('$mondate','%m-%d-%Y') and  str_to_date('$date','%m-%d-%Y') and exp_ex_id='$cash_outflow_rr[ex_id]'");
                	//echo "select sum(ex_amount) as sum_exp from expense  where exp_date between str_to_date('$mondate','%m-%d-%Y') and  str_to_date('$date','%m-%d-%Y') and exp_ex_id='$cash_outflow_rr[ex_id]'";
                	$mon_expense_arr=mysql_fetch_assoc($mon_expense_1);
                	$mon_expense=$mon_expense_arr['sum_exp'];
                ?>
                
                <td> <?php echo $mon_expense ;?> </td>
              </tr>
              
              <?php } ?>
              <tr>
               	<td><?php echo ++$plno ;?></td>
                <td> Total Wastage </td>
                <td> <?php echo $total_wastage ;?> </td>
                <td> <?php echo $mon_wastage ;?> </td>
              </tr>
              
                <tr>
               	<td><?php echo ++$plno ;?></td>
                <td> Total Sales </td>
                <td> <?php echo $total_sales_sum ;?> </td>
                <td> <?php echo $mon_sales_sum ;?> </td>
              </tr>
              
            <tr>
               	<td><?php echo ++$plno ;?></td>
                <td> Closing Stock </td>
                <td> <?php echo $total_inventory ;?> </td>
                <td> <?php echo "N/A" ;?> </td>
              </tr>
              
               <tr>
               	<td><?php echo ++$plno ;?></td>
                <td> <b>Profit</b> </td>
                <td> <b>00000</b> </td>
                <td> <b>00000</b> </td>
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
       
		         
                  
       <p align="center"> <button  type="button" onclick="location.href='print_pal_report.php?date=<?php echo $date ;?>';" name="in_btn" value="inden" class="btn btn-primary">Print</button> </p>
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