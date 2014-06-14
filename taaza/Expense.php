<!-- To Avoid resubmitting -->
<?php

    include 'db_config.php' ;
  		
	$conn=new createConnection();
	$conn->connect();
	$conn->selectdb();

	session_start();	
	
	//echo '<pre>'; print_r($_POST); echo '</pre>';
	if (  isset($_POST['pay_btn']) || isset($_POST['ex_txt']) || isset($_POST['emp_txt']))
	{
		
	if ($_POST["formid"] == $_SESSION["formid"])
	{
		$_SESSION["formid"] = '';
		//echo '<pre>'; print_r($_POST); echo '</pre>';
	
		if (  isset($_POST['pay_btn']))
		{
			$insert_query = "insert into expense (exp_ex_id,exp_emp_id,exp_date,rec_no,ex_amount) values  (". $_POST['ex_id'].",".$_POST['em_id'] .",STR_TO_DATE('".$_POST['date']."', '%m-%d-%Y'),".$_POST['vouch'].",". $_POST['pay'].")";
			//echo $insert_query;
			

		
			mysql_query($insert_query);
			
		}
		
		if (isset($_POST['ex_txt']))
		{
			//echo "This is test".$_POST['ex_txt'];
			//echo "insert into expense_type (ex_type) values ('$_POST[ex_txt]')";
			
			mysql_query("insert into expense_type (ex_type) values ('$_POST[ex_txt]')");
		}
		if (isset($_POST['emp_txt']))
		{
		
				
			mysql_query("insert into employee (emp_name) values ('$_POST[emp_txt]')");
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
<title>Taaza Tarkari - Expense Entry</title>
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
	<!-- Responsive part -->

		<?php include 'Menu.php' ; ?>
      <!-- End sidebar_box --> 
      
    </div>
  </div>
</div>
<div id="main" style="min-height:1000px">
  <div class="container">
		<?php include 'top.php' ; ?>
		<!-- End Top Right -->
    

    
    <div id="main_container">
      <div class="row-fluid">
        <div class="box color_5">
          <div class="title">
            <h4> <span>Make Expense Payment </span> </h4>
          </div>
          <!-- End .title -->
          
          <div class="content top">
          <form  name="pay_form" action="Expense.php?expense=active&a_expense=active"  onsubmit="return validate();" method="post">
          
          		<fieldset>
                        <div class="form-row control-group row-fluid">
                          <label class="control-label span2">Expense Type</label>
                          <div class="controls span9">
                            <select name="ex_id" data-placeholder="Please select.." class="chzn-select" onchange="addoption(this.options[this.selectedIndex].value);">
                              <option value=""></option>
                             <?php 
                             	$expense_array=mysql_query("select ex_id, ex_type from expense_type order by ex_type ");
                             	while ($ex_arr = mysql_fetch_array($expense_array)) {?>
                              
                              <option value="<?php echo $ex_arr['ex_id']; ?>"><?php echo $ex_arr['ex_type']; ?></option>
                              <?php }  ?>
                             
                              <option value="add">Add Type</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-row control-group row-fluid">
                          <label class="control-label span2">Person Name</label>
                          <div class="controls span9">
                            <select name="em_id" data-placeholder="Please select.." class="chzn-select" onchange="addoption1(this.options[this.selectedIndex].value);">
                              <option value=""></option>
                             <?php 
                             	$employee_array=mysql_query("select emp_id, emp_name from employee order by emp_name ");
                             	while ($emp_arr = mysql_fetch_array($employee_array)) {?>
                              
                              <option value="<?php echo $emp_arr['emp_id']; ?>"><?php echo $emp_arr['emp_name']; ?></option>
                              <?php } $conn->close(); ?>
                             
                              <option value="addp">Add Person</option>
                            </select>
                          </div>
                        </div>
                        
                        <div class="form-row control-group row-fluid">
                          <label class="control-label span2">Select Date</label>
                          <div class="controls span9">
                          	<?php $date = date('m-d-Y'); ?>
                            <input type="text" id="datepicker1"  name="date" value="<?php echo $date ;?>" 	class="row-fluid">
                          </div>
                        </div>
                        
                        <div class="control-group row-fluid"> 
                          <!-- Password -->
                          <label class="control-label span2"  for="name">Reciept no</label>
                          <div class="controls span9">
                            <input type="text"  name="vouch" placeholder="0" class="row-fluid" value="0" onfocus="this.select();"  onblur="extractNumber(this,0,false);" onkeyup="extractNumber(this,0,false);" onkeypress="return blockNonNumbers(this, event, true, false);">
                          </div>
                        </div>
                        
                       <div class="control-group row-fluid"> 
                          <!-- Password -->
                          <label class="control-label span2"  for="name">Amount</label>
                          <div class="controls span9">
                            <input type="text"  name="pay" placeholder="0"  value="0.00" class="row-fluid" onfocus="this.select();"  onblur="extractNumber(this,2,false);" onkeyup="extractNumber(this,2,false);" onkeypress="return blockNonNumbers(this, event, true, false);">
                          </div>
                        </div>
                  
                       
                     
                      </fieldset>
                      
                   <div class="description content">
                    <ul class="pager wizard mb5">
                      <li class="previous ">
                        <button class="btn btn-primary pull-left btn-large"><i class="icon-caret-left"></i> Cancel</button>
                      </li>
                      <li class="next">
                        <button class="btn btn-primary btn-large pull-right" name="pay_btn" type="submit" value="pressed">Make Payment <i class="icon-caret-right"></i></button>
                      </li>
                      
                    </ul>
                  </div>
          		
  
            <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
            </form>
          </div>
          <!-- End .content --> 
        </div>
        <!-- End box --> 
      </div>
      <!-- End .row-fluid --> 
      
    </div>
  
    	
    
    
    <!-- End #container --> 
  </div>
  

  
  
  
  
  
  
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
<!-- /container --> 
<div class="avgrund-popup  stack modal" id="default-popup" >
  <div class="modal-header">
    <h3 id="myModalLabel">Add Expense Type</h3>
  </div>
 <form name="addtype" action="Expense.php?expense=active&a_expense=active" method="POST">
  <div class="modal-body">
  
  	<table class="table table-condensed table-striped">
                  			
    <tr>  
    <td class="to_hide_phone"><p> <input class="row-fluid span4"  id="exinput" autofocus="autofocus"  name="ex_txt" type="text"  >  </p></td>
    </tr>
    </table>
    <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
  </div>
  <div class="modal-footer">
    <button name="ex_add" type="button" value="click" class="btn" onclick="javascript:add_ex_type();">Add</button>
    <script type="text/javascript">
	function add_ex_type()
	{
		if(document.forms.addtype.ex_txt.value == null || document.forms.addtype.ex_txt.value == '' )
		{
			
			alert("Enter a Proper value");
			return false;
		}
		else
		{
			document.forms.addtype.submit();
		}
	}

    </script>
    
    <button class="btn" type="button" onclick="javascript:closeDialog();">Close</button>
    
    
  </div>
  </form>
</div>
<div class="avgrund-cover"></div>
<div class="avgrund-popup  stack modal" id="default-popup1" >
  <div class="modal-header">
    <h3 id="myModalLabel">Add Person</h3>
  </div>
 <form name="addemp" action="Expense.php?expense=active&a_expense=active" method="POST">
  <div class="modal-body">
  
  	<table class="table table-condensed table-striped">
                  			
    <tr>  
    <td class="to_hide_phone"><p> <input class="row-fluid span4"  id="empinput" autofocus="autofocus"  name="emp_txt" type="text"  >  </p></td>
    </tr>
    </table>
    <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
  </div>
  <div class="modal-footer">
    <button name="ex_add" type="button" value="click" class="btn" onclick="javascript:add_emp_type();">Add</button>
    <script type="text/javascript">
	function add_emp_type()
	{
		if(document.forms.addemp.emp_txt.value == null || document.forms.addemp.emp_txt.value == '' )
		{
			
			alert("Enter a Proper value");
			return false;
		}
		else
		{
			document.forms.addemp.submit();
		}
	}

    </script>
    
    <button class="btn" type="button" onclick="javascript:closeDialog();">Close</button>
    
    
  </div>
  </form>
</div>
<div class="avgrund-cover"></div>

<!-- Le javascript
    ================================================== --> 
    
    
 <!-- Modal Concept --> 
<script language="javascript" type="text/javascript" src="js/plugins/avgrund.js"></script> 
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
<script language="javascript" type="text/javascript" src="js/plugins/chosen/chosen/chosen.jquery.min.js"></script>    
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

<!-- Forms Wizard --> 
<script language="javascript" type="text/javascript" src="js/plugins/wizard-master/jquery.bootstrap.wizard.js"></script> 

<!-- Custom made scripts for this template --> 
<script src="js/scripts.js" type="text/javascript"></script> 
<script type="text/javascript">
  /**** Specific JS for this page ****/
  
function addoption(x)
  {
		if (x == "add")
		{
			//alert("in add section")
			openDialog();
		}
		else
		{
			return true;
		}

	}

function addoption1(y)
{
		if (y == "addp")
		{
			//alert("in add section")
			openDialog1();
		}
		else
		{
			return true;
		}

	}


function openDialog() {
	
	//global_invoice=value;
	//alert("openDialog");
	Avgrund.show( "#default-popup" );
  
}
function closeDialog() {
  Avgrund.hide();
}

function openDialog1() {
	
	//global_invoice=value;
	//alert("openDialog");
	Avgrund.show( "#default-popup1" );
  
}
function closeDialog1() {
  Avgrund.hide();
}


function validate()
{
	w=document.forms["pay_form"]["em_id"].value;
	y=document.forms["pay_form"]["pay"].value;
	x=document.forms["pay_form"]["ex_id"].value;
	z=document.forms["pay_form"]["vouch"].value;
	
	if (x == "" || y == "" || x == null || y == null || y =="0.00" || y == 0 || z == null || z == 0 || z == "" || w == "" || w == null ) {
	
		alert ('Expense Type,Person Name, Reciept Number and Amount are mandatory');
		return false;
	}
	
	else{
		document.indentform.submit();
		return true;
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
        // $("#text").limiter(100, elem);
        // Mask plugin http://digitalbush.com/projects/masked-input-plugin/
        $("#mask-phone").mask("999-999-9999");
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
        });;
      
        $('#datepicker2').datepicker();
        $('.colorpicker').colorpicker()
        $('#colorpicker3').colorpicker();
    });

    $(document).ready(function() {
      $('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
      var $total = navigation.find('li').length;
      var $current = index+1;
      var $percent = ($current/$total) * 100;
      $('#rootwizard').find('.bar').css({width:$percent+'%'});
      
      // If it's the last tab then hide the last button and show the finish instead
      if($current >= $total) {
        $('#rootwizard').find('.pager .next').hide();
        $('#rootwizard').find('.pager .finish').show();
        $('#rootwizard').find('.pager .finish').removeClass('disabled');
      } else {
        $('#rootwizard').find('.pager .next').show();
        $('#rootwizard').find('.pager .finish').hide();
      }
      
    }});
    // $('#rootwizard .finish').click(function() {
    //   alert('Finished! Starting over!');
    //   $('#rootwizard').find("a[href*='tab1']").trigger('click');
    // }); 
   
  }); 

</script>




</body>
</html>