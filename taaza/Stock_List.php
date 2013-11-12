<!-- To Avoid resubmitting -->
<?php

    include 'db_config.php' ;
  		
	$conn=new createConnection();
	$conn->connect();
	$conn->selectdb();

	session_start();	
	

	if (isset($_POST["pri_btn"]) || isset($_POST["sec_btn"]) ||isset($_POST["wst_btn"])  )
	{
	if ($_POST["formid"] == $_SESSION["formid"])
	{
		$_SESSION["formid"] = '';
		//mysql_query("insert into item_master(item ) values ('$_POST[item_txt]')") ;
		if (isset($_POST["pri_btn"])){
			//echo "Pressed Primary";
			//echo $_POST['2'];
			
			$p_result=mysql_query("select s_item_code from inventory");
			while ($s_indx=mysql_fetch_array($p_result)){
				
				$i=$s_indx['s_item_code'];
			
				$value=$_POST[$i];
				mysql_query("update inventory set primary_stock=$value where s_item_code=$i" );
				
				
			}
			
		}
		
		if (isset($_POST["wst_btn"])){
			//echo "Pressed Primary";
			//echo $_POST['2'];
				
			$p_result=mysql_query("select s_item_code from inventory");
			while ($s_indx=mysql_fetch_array($p_result)){
		
				$i=$s_indx['s_item_code'];
					
				$value=$_POST[$i];
				
				$w_date_exist_query=mysql_query("select date_format(date,'%Y-%m-%d') as date from wastage_history where w_item_code=$i order by w_id desc limit 1");
				$w_date_exist_arr=mysql_fetch_assoc($w_date_exist_query);
				$w_date_exist=$w_date_exist_arr['date'];
				$today_date= date('Y-m-d');
				
				$value_flag_query=mysql_query("select qty from wastage_history where date_format(date,'%Y-%m-%d')='$today_date' and w_item_code=$i"); 
				$value_flag_arr=mysql_fetch_assoc($value_flag_query);
				if (isset ($value_flag_arr['qty']) and $value == 0)
				{
					$value=$value_flag_arr['qty'];
					
				}	
							
						
						
				if($value !=0 )
				{
					$value=$_POST[$i];
					if($today_date != $w_date_exist){
							mysql_query("update inventory set waste_stock=$value,primary_stock=primary_stock-$value where s_item_code=$i" );
							mysql_query("insert into wastage_history (w_item_code,qty,price) values ($i,$value,(select purchase from price_list where p_item_code=$i))");
							//echo "new $today_date  and $w_date_exist";
					}
					else{
							
							$curr_wast_qty_query=mysql_query("select qty from wastage_history where date_format(date,'%Y-%m-%d') = '$today_date' and w_item_code=$i");
							$curr_wast_qty_arr=mysql_fetch_assoc($curr_wast_qty_query);
							$curr_wast_qty=$curr_wast_qty_arr['qty'];
							$updated_qty=$value-$curr_wast_qty;
							
							//echo "update quantity $updated_qty";
							mysql_query("update inventory set waste_stock=$value,primary_stock=primary_stock-$updated_qty where s_item_code=$i" );
							mysql_query("update  wastage_history set w_item_code = $i ,qty = qty+$updated_qty,price= (select purchase from price_list where p_item_code=$i) where date_format(date,'%Y-%m-%d')='$today_date' and w_item_code=$i");
							mysql_query("delete from wastage_history where qty =0 and w_id >0");
					}
				}	
		
			}
				
		}
				
		if (isset($_POST["sec_btn"])){
			//echo "Pressed secondary";
			//echo $_POST['2'];
			$p_result=mysql_query("select s_item_code from inventory");
			while ($s_indx=mysql_fetch_array($p_result)){
			
				$i=$s_indx['s_item_code'];
					
				$value=$_POST[$i];
				mysql_query("update inventory set secondary_stock=$value where s_item_code=$i" );
			
			}
			
		}
			
		
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
<title>Taaza Tarkari- Stock List</title>
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
   
   
		$item_count1 = mysql_query('select count(*) as c from item_master');
		$item_count2 = mysql_fetch_assoc($item_count1);
		$item_count=0;
		$item_count=$item_count2['c'];
		
		$row_count=ceil($item_count/3);
		$limit=0;
		
?>
   
    <div id="main_container">
      <div class="row-fluid">
        <div class="span12">
        
   <?php if (isset($_GET['p_stock'])) {?> 
      <form id=pristock action="Stock_List.php?stock=active&p_stock=active" method="post">
         
          <div class="box paint color_8">
            <div class="title">
            
              	<h4> <i class="icon-book"></i><span>Primary Stock </span> </h4>
            	
            </div>

            
            <div class="content top ">
              <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
                <thead>
                
                  <tr>
                    <th class="no_sort"> Sl#</th>
                    <th class="no_sort"> Item </th>
                    <th class="no_sort"> Qty</th>
                    <th class="no_sort"> Sl# </th>
                    <th class="no_sort"> Item</th>
                    <th class="no_sort"> Qty </th>
                     <th class="no_sort"> Sl# </th>
                    <th class="no_sort"> Item</th>
                    <th class="no_sort"> Qty </th>
				   </tr>
                </thead>
                
                
                
            	<tbody>
            	<?php  for ($i=0 ; $i<$row_count ; $i++){ 
            		
                	$result = mysql_query("select s.s_item_code, s.s_id ,i.item, s.primary_stock  from inventory s, item_master i where s.s_item_code=i.item_code limit $limit,3") or die(mysql_error());
                	
                ?>
                  <tr>
                  <?php 
                  	while($stock_arr = mysql_fetch_array( $result ))
                  		{
                  ?>
                    <td><?php echo $stock_arr['s_id'] ;?></td>
                    <td><?php echo $stock_arr['item'] ;?></td>
                    <td class="to_hide_phone"> <input class="row-fluid span6" name="<?php echo $stock_arr['s_item_code'] ;?>" value="<?php echo $stock_arr['primary_stock'] ;?>" placeholder="<?php echo $stock_arr['primary_stock'] ;?>"  type="text"  onclick="this.select();" onfocus="this.select();" onblur="extractNumber(this,2,true);" onkeyup="extractNumber(this,2,true);" onkeypress="return blockNonNumbers(this, event, true, true);"> </td>
                    
                    
                   <?php }
                   $limit=$limit+3; ?>
                    
                  </tr>
                  <?php } $conn->close();?>
                  
                  </tbody>
              </table>
            
            <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
         

        </div>
        
        
        <!-- End Content -->
                  
       <p align="center"> <a><button name="pri_btn" type="submit"  class="btn btn-primary">Save Changes</button></a> </p>
       <p align="center"> <a><button name="prnt_btn" type="button" onclick="location.href='print_stock_list.php?stockval=0';"  class="btn ">Print</button></a> </p>
        </div>
        </form>
        
        <?php } if (isset($_GET['s_stock'])) {  ?>        
        
        	 <form id=pristock action="Stock_List.php?stock=active&s_stock=active" method="post">
         
          <div class="box paint color_8">
            <div class="title">
            
              	<h4> <i class="icon-book"></i><span>Secondary Stock </span> </h4>
            	
            </div>

            
            <div class="content top ">
              <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
                <thead>
                
                  <tr>
                    <th class="no_sort"> Sl#</th>
                    <th class="no_sort"> Item </th>
                    <th class="no_sort"> Qty</th>
                    <th class="no_sort"> Sl# </th>
                    <th class="no_sort"> Item</th>
                    <th class="no_sort"> Qty </th>
                     <th class="no_sort"> Sl# </th>
                    <th class="no_sort"> Item</th>
                    <th class="no_sort"> Qty </th>
				   </tr>
                </thead>
                
                
                
            	<tbody>
            	<?php  for ($i=0 ; $i<$row_count ; $i++){ 
                	$result = mysql_query("select s.s_item_code, s.s_id ,i.item, s.secondary_stock  from inventory s, item_master i where s.s_item_code=i.item_code limit $limit,3") or die(mysql_error());
                	
                ?>
                  <tr>
                  <?php 
                  	while($stock_arr = mysql_fetch_array( $result ))
                  		{
                  ?>
                    <td><?php echo $stock_arr['s_id'] ;?></td>
                    <td><?php echo $stock_arr['item'] ;?></td>
                    <td class="to_hide_phone"> <input class="row-fluid span6" name="<?php echo $stock_arr['s_item_code'] ;?>" type="text" value="<?php echo $stock_arr['secondary_stock'] ;?>" placeholder="<?php echo $stock_arr['secondary_stock'] ;?>" onclick="this.select();" onfocus="this.select();" onblur="extractNumber(this,2,true);" onkeyup="extractNumber(this,2,true);" onkeypress="return blockNonNumbers(this, event, true, true);"> </td>
                    
                   <?php }
                   $limit=$limit+3; ?>
                    
                  </tr>
                  <?php } $conn->close();?>
                  
                  </tbody>
              </table>
            
            <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
         

        </div>
        
        
        <!-- End Content -->
                  
       <p align="center"> <a><button name="sec_btn" type="submit"  class="btn btn-primary">Save Changes</button></a> </p>
       <p align="center"> <a><button name="prnt_btn" type="button" onclick="location.href='print_stock_list.php?stockval=1';"  class="btn ">Print</button></a> </p>
        </div>
        </form>
        
         <?php } if (isset($_GET['w_stock'])) {?> 
      <form id=pristock action="Stock_List.php?stock=active&w_stock=active" method="post">
         
          <div class="box paint color_8">
            <div class="title">
            
              	<h4> <i class="icon-book"></i><span>Waste Stock </span> </h4>
            	
            </div>

            
            <div class="content top ">
              <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
                <thead>
                
                  <tr>
                    <th class="no_sort"> Sl#</th>
                    <th class="no_sort"> Item </th>
                    <th class="no_sort"> Qty</th>
                    <th class="no_sort"> Sl# </th>
                    <th class="no_sort"> Item</th>
                    <th class="no_sort"> Qty </th>
                     <th class="no_sort"> Sl# </th>
                    <th class="no_sort"> Item</th>
                    <th class="no_sort"> Qty </th>
				   </tr>
                </thead>
                
                
                
            	<tbody>
            	<?php $today_date_waste= date('m-d-Y'); 
            		//echo "$today_date_waste";
            		$waste_reset_query=mysql_query("select count(*) as count from wastage_history where date_format(date,'%m-%d-%Y')='$today_date_waste'");
            		$waste_reset_arr= mysql_fetch_assoc($waste_reset_query);
            		if($waste_reset_arr['count'] ==0 ){
            			mysql_query("update inventory set waste_stock=0 where s_id > 0");
            		
            		}
            				
            		for ($i=0 ; $i<$row_count ; $i++){ 
                	$result = mysql_query("select s.s_item_code, s.s_id ,i.item, s.waste_stock  from inventory s, item_master i where  s.s_item_code=i.item_code limit $limit,3") or die(mysql_error());
                	
                ?>
                  <tr>
                  <?php 
                  	while($stock_arr = mysql_fetch_array( $result ))
                  		{
                  ?>
                    <td><?php echo $stock_arr['s_id'] ;?></td>
                    <td><?php echo $stock_arr['item'] ;?></td>
                    <td class="to_hide_phone"> <input class="row-fluid span6" name="<?php echo $stock_arr['s_item_code'] ;?>" value="<?php echo $stock_arr['waste_stock'] ;?>" placeholder="<?php echo $stock_arr['waste_stock'] ;?>"  type="text"  onclick="this.select();" onfocus="this.select();" onblur="extractNumber(this,2,true);" onkeyup="extractNumber(this,2,true);" onkeypress="return blockNonNumbers(this, event, true, true);"> </td>
                    
                    
                   <?php }
                   $limit=$limit+3; ?>
                    
                  </tr>
                  <?php } $conn->close();?>
                  
                  </tbody>
              </table>
            
            <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
         

        </div>
        
        
        <!-- End Content -->
                
       <p align="center"> <a><button name="wst_btn" type="submit"  class="btn btn-primary">Save Changes</button></a> </p>
       <p align="center"> <a><button name="prnt_btn" type="button" onclick="location.href='print_stock_list.php?stockval=2';"  class="btn ">Print</button></a> </p>
        </div>
        </form>
        
        	
        
        
        
        
        <?php }?>
        
        
        
        <!-- End Box --> 
        
        
        	 
      </div>
      <!-- End span12 -->
    </div>
    
     
      
            
   
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

<script>

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
                   


</script>



<script type="text/javascript">
  /**** Specific JS for this page ****/
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
        });
        $('#datepicker7').datepicker({
            format: 'mm-dd-yyyy'
          });
        $('#datepicker2').datepicker();
        $('.colorpicker').colorpicker()
        $('#colorpicker3').colorpicker();

        $(document).ready(function() {
            $("#myInput").keyup(validateInput);
        });
        
    });


 function hasWhiteSpaceOrEmpty(s) 
 {
   return s == "" || s.indexOf(' ') >= 0;
 }

 function validateInput()
 {
     var inputVal = $("#Textinput").val();
     if(hasWhiteSpaceOrEmpty(inputVal))
     {
         //This has whitespace or is empty, disable the button
         $("#add").attr("disabled", "disabled");
     }
     else
     {
         //not empty or whitespace
         $("#add").removeAttr("disabled");
     }
 }




</script>
</body>
</html>