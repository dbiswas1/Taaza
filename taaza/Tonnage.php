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
<title>Taaza Tarkari- Indent Report</title>
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
        <form name="date_form" action="Tonnage.php?indent=active&in_indent=in&to_indent=active"  method="post">
          <div class="box paint color_25">
            <div class="title">
              <h4> <i class="icon-book"></i><span>Total Tonnage Report (<?php echo date('M-d-Y', strtotime($ddate));?>)  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Change Date: <input align="right" class="span2" name="idate" type="text" id="datepicker1" value="<?php echo $date ;?>" class="row-fluid"></span> </h4>
            	
			    <?php $totalton=0; ?>          
               
             </div>
             <div class="content top ">
              <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
                <thead>
                
                  <tr>
                    <th class="no_sort"> Item</th>
                    <th class="no_sort"> Qty </th>
                    <th class="no_sort"> Item</th>
                    <th class="no_sort"> Qty </th>
                    <th class="no_sort"> Item</th>
                    <th class="no_sort"> Qty </th>
				   </tr>
                </thead>
                         
            	<tbody>
            	<?php  for ($i=0 ; $i<$row_count ; $i++){ 
                	 $result = mysql_query("select im.item_code,im.item,sum(io.qty) as qty from item_master im,indent_order io  where im.item_code=io.i_item_code   and  date_format(io.date,'%m-%d-%Y')='$date' and qty > 0 group by io.i_item_code limit $limit,3") or die(mysql_error());
                	//$result = mysql_query("select item,item_code as qty from item_master limit $limit,3");
                ?>
                  <tr>
                  <?php 
                  	while($item_arr = mysql_fetch_array( $result ))
                  		{
                  			
                  			switch ($item_arr['item_code']) {
                  			
                  			case 4:
                  				?>
                  				<td><?php echo $item_arr['item'] ; $totalton=$totalton+($item_arr['qty']/2); ?></td>
                    			<td><?php echo round ($item_arr['qty']/2 ,2) ;?></td>
                    		
                    		<?php  break 1; case 52: ?>
                  				<td><?php echo $item_arr['item'] ; $totalton=$totalton+($item_arr['qty']/25) ;?></td>
                    			<td><?php echo round ($item_arr['qty']/25 ,2) ;?></td> 
          			
                    			
                    		<?php break 1; case 56: ?>
                    				<td><?php echo $item_arr['item'] ; $totalton=$totalton+($item_arr['qty']/25); ?></td>
                    				<td><?php echo round ($item_arr['qty']/25 ,2) ;?></td>
                    		
                    		<?php break 1; case 69: ?>
                    				<td><?php echo $item_arr['item'] ; $totalton=$totalton+($item_arr['qty']/3); ?></td>
                    				<td><?php echo round ($item_arr['qty']/3 ,2) ;?></td>
                    		
                    		<?php break 1; case 77: ?>
                    				<td><?php echo $item_arr['item'] ; $totalton=$totalton+($item_arr['qty']/3); ?></td>
                    				<td><?php echo round ($item_arr['qty']/3 ,2) ;?></td> 
                    		
                    		<?php break 1; case 78: ?>
                    				<td><?php echo $item_arr['item'] ; $totalton=$totalton+($item_arr['qty']/4); ?></td>
                    				<td><?php echo round ($item_arr['qty']/4 ,2) ;?></td>  
                  	
                  			<?php break 1; case 79: ?>
                    				<td><?php echo $item_arr['item']  ; $totalton=$totalton+($item_arr['qty']/20); ?></td>
                    				<td><?php echo round ($item_arr['qty']/20 ,2) ;?></td>  
                  	
                  			<?php break 1; case 80: ?>
                    				<td><?php echo $item_arr['item'] ; $totalton=$totalton+($item_arr['qty']/5); ?></td>
                    				<td><?php echo round ($item_arr['qty']/5 ,2) ;?></td>  
                  	
                  			<?php break 1; case 81: ?>
                    				<td><?php echo $item_arr['item'] ;  $totalton=$totalton+($item_arr['qty']/10); ?></td>
                    				<td><?php echo round ($item_arr['qty']/10 ,2) ;?></td>  
                  	 
                  			<?php break 1; case 82: ?>
                    				<td><?php echo $item_arr['item'] ; $totalton=$totalton+($item_arr['qty']/6); ?></td>
                    				<td><?php echo round ($item_arr['qty']/6 ,2) ;?></td>
                    				
                    		<?php break 1; case 83: ?>
                    				<td><?php echo $item_arr['item'] ; $totalton=$totalton+($item_arr['qty']/15); ?></td>
                    				<td><?php echo round ($item_arr['qty']/15 ,2) ;?></td>
                    				
                    		<?php break 1; case 84: ?>
                    				<td><?php echo $item_arr['item'] ; $totalton=$totalton+($item_arr['qty']/8); ?></td>
                    				<td><?php echo round ($item_arr['qty']/8 ,2) ;?></td>
                    			
                    		<?php break 1; case 85: ?>
                    				<td><?php echo $item_arr['item'] ; $totalton=$totalton+($item_arr['qty']/20); ?></td>
                    				<td><?php echo round ($item_arr['qty']/20 ,2) ;?></td>
                    		
                    		<?php break 1; case 87: ?>
                    				<td><?php echo $item_arr['item'] ; $totalton=$totalton+($item_arr['qty']/2); ?></td>
                    				<td><?php echo round ($item_arr['qty']/2 ,2) ;?></td>
                    				
                    				
                    		<?php break 1; case 88: ?>
                    				<td><?php echo $item_arr['item'] ;?></td>
                    				<td><?php echo round ($item_arr['qty']/8 ,2) ; $totalton=$totalton+($item_arr['qty']/8); ?></td>
                    				
                    		<?php break 1; case 89: ?>
                    				<td><?php echo $item_arr['item'] ; $totalton=$totalton+($item_arr['qty']/8); ?></td>
                    				<td><?php echo round ($item_arr['qty']/8 ,2) ;?></td>
                    								
                  			<?php break 1; default :?>
                    			<td><?php echo $item_arr['item'] ; $totalton=$totalton+$item_arr['qty'] ;?></td>
                    			<td><?php echo $item_arr['qty'] ;?></td> 		
                    
                   <?php } }
                   $limit=$limit+3; ?>
                    
                  </tr>
                  <?php }$conn->close(); ?>
                  <tr><b>Total Tonnage: <?php echo round($totalton,2);  ?> KG</b></tr>
                  
                  </tbody>
              </table>
            
            
         

          
          
          
         
           
        </div>
        
        
                <div class="accordion" id="accordion3">
                <div class="accordion-group">
                  <div id="collapseOne1" class="accordion-body collapse" style="height: 0px; ">
                    <div class="accordion-inner"><textarea id="text" name="notes" rows="3" class="row-fluid"></textarea></div>
                  </div>
                </div>
          
        </div>
        <!-- End Content -->
       
		         
                  
       <p align="center"> <button  type="button" onclick="location.href='print_tonnage_report.php?date1=<?php echo date('M-d-Y', strtotime($ddate));?>&date=<?php echo $date ;?>';" name="in_btn" value="inden" class="btn btn-primary">Print</button> </p>
        </div>
        <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
        </form>
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