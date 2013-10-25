<!-- To Avoid resubmitting -->
<?php

    include 'db_config.php' ;
  		
	$conn=new createConnection();
	$conn->connect();
	$conn->selectdb();

	session_start();	
	

	if (  isset($_POST["sec_btn"])  || isset($_POST["p1_btn"]) ||  isset($_POST["p2_btn"]) || isset($_POST["pur_btn"]))
	{
		
	if ($_POST["formid"] == $_SESSION["formid"])
	{
		$_SESSION["formid"] = '';
		if (  isset($_POST["sec_btn"])){
			//echo "Secondary";
			$i=0;
			$p3_result=mysql_query("select p_item_code from price_list");
			while ($p3_indx=mysql_fetch_array($p3_result)){
					
				$i=$p3_indx['p_item_code'];
				//echo $i;
				$value2=$_POST[$i];
				//echo $_POST[$i];
				mysql_query("update price_list set secondary=$value2 where p_item_code=$i" );
					
			}
			
			}
		
		
		
			
		if (  isset($_POST["p1_btn"])){
			//echo"Primary";
			$p_result=mysql_query("select p_item_code from price_list");
			while ($p_indx=mysql_fetch_array($p_result)){
					
				$i=$p_indx['p_item_code'];
				//echo $i;	
				$value=$_POST[$i];
				//echo $_POST[$i];
				mysql_query("update price_list set price1=$value where p_item_code=$i" );
					
			}
			
			
		}
			
		if (  isset($_POST["p2_btn"])){
			$i=0;
			$p2_result=mysql_query("select p_item_code from price_list");
			while ($p2_indx=mysql_fetch_array($p2_result)){
					
				$i=$p2_indx['p_item_code'];
				//echo $i;
				$value1=$_POST[$i];
				//echo $_POST[$i];
				mysql_query("update price_list set price2=$value1 where p_item_code=$i" );
					
			}
			//echo "Primary2";
		}
		
		if (  isset($_POST["pur_btn"])){
			$i=0;
			$pur_result=mysql_query("select p_item_code from price_list");
			while ($pur_indx=mysql_fetch_array($pur_result)){
					
				$i=$pur_indx['p_item_code'];
				//echo $i;
				$value3=$_POST[$i];
				//echo $_POST[$i];
				mysql_query("update price_list set purchase=$value3 where p_item_code=$i" );
					
			}
			//echo "Purchase";
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
<title>Taaza Tarkari -  Selling Price</title>
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
        <div class="span12">
          <div class="box paint color_3">
            <div class="title">
              <div class="row-fluid">
                <h4> Price List Tabs </h4>
              </div>
            </div>
            <!-- End .title -->
            <div class="content">
              <ul id="tabExample1" class="nav nav-tabs">
              
              <?php if(isset($_GET['tab1'])) {?>
                <li class="active"><a href="selling_price.php?invoice=active&in_invoice=in&s_invoice=active&tab1=pr1" >Price 1</a></li>
               <?php } else { ?>
               	<li ><a href="selling_price.php?invoice=active&in_invoice=in&s_invoice=active&tab1=pr1">Price 1</a></li>
               <?php } if(isset($_GET['tab2'])) {?>
                <li class="active"><a href="selling_price.php?invoice=active&in_invoice=in&s_invoice=active&tab2=pr2" >Price 2</a></li>
                <?php } else { ?>
                	<li><a href="selling_price.php?invoice=active&in_invoice=in&s_invoice=active&tab2=pr2" >Price 2</a></li>
                <?php } if(isset($_GET['tab3'])) { ?>
                	<li class="active"><a href="selling_price.php?invoice=active&in_invoice=in&s_invoice=active&tab3=pr3" >Secondary</a></li>
                <?php } else { ?>
                	<li><a href="selling_price.php?invoice=active&in_invoice=in&s_invoice=active&tab3=pr3" >Secondary</a></li>
                <?php } if(isset($_GET['tab4'])) { ?>
                	<li class="active"><a href="selling_price.php?invoice=active&in_invoice=in&s_invoice=active&tab4=pr4" >Purchase</a></li>
                <?php } else { ?>
                	<li><a href="selling_price.php?invoice=active&in_invoice=in&s_invoice=active&tab4=pr4" >Purchase</a></li>
                <?php } ?>
                
              </ul>
              <div class="tab-content ">
              
              <?php if(isset($_GET['tab1'])) {?>
              <form name="p1" action="selling_price.php?invoice=active&in_invoice=in&s_invoice=active&tab1=pr1" method="post">
                
                
                <div class="tab-pane fade in active" id="home1">
               <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
                <thead>
                  <tr>
                    <th class="no_sort"> Item Name </th>
                    <th class="no_sort"> Purchase </th>
                    <th class="no_sort"> Price </th>
                    <th class="no_sort"> Item Name </th>
                    <th class="no_sort"> Purchase </th>
                    <th class="no_sort"> Price </th>
   					<th class="no_sort"> Item Name </th>
                    <th class="no_sort"> Purchase </th>
                    <th class="no_sort"> Price </th>
                   
                  </tr>
                </thead>
            	<tbody>
                  <?php 
                  		$price1_count=mysql_query("select count(*) as c from price_list p, item_master i where i.item_code=p.p_item_code");
                  		$price1_count2=mysql_fetch_assoc($price1_count);
                  		$price1_count=$price1_count2['c'];
                  		$p1row_count=ceil($price1_count/3);
                  		$limit=0;
                  		for ($i=0 ; $i<$p1row_count ; $i++){
                  			$price1_result=mysql_query("select p.p_item_code, p.p_id,i.item,p.price1,p.purchase from item_master i, price_list p where i.item_code=p.p_item_code limit $limit,3");
                   ?>
                  <tr>
                        <?php while($price1_arr=mysql_fetch_array($price1_result)) { ?>
                    <td><?php echo $price1_arr['item'] ; ?></td>
                    <td>&nbsp;&nbsp;<?php echo $price1_arr['purchase'] ; ?></td>
                    <td class="to_hide_phone"> <input class="row-fluid span6" name="<?php echo $price1_arr['p_item_code'] ;?>" value="<?php echo $price1_arr['price1'] ;?>"  type="text"  onclick="this.select();" onfocus="this.select();" onblur="extractNumber(this,2,false);" onkeyup="extractNumber(this,2,false);" onkeypress="return blockNonNumbers(this, event, true, false);"> </td>
              
            
                  <?php 
                   }
                   $limit=$limit+3;
                   
                   }  ?>
  
                  </tbody>
              </table>
            	 
            	 <p align="center"> <button  type="submit" name="p1_btn" value="p1_v" class="btn btn-primary">Save changes</button> </p>
				<input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
				</div>
              </form> 
              <?php } ?>
                
                 
                 <?php if(isset($_GET['tab2'])) {?>
                 <form name="p2" action="selling_price.php?invoice=active&in_invoice=in&s_invoice=active&tab2=pr2" method="post">
                <div class="tab-pane fade in active" id="profile1">
                   <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
                <thead>
                  <tr>
                   <th class="no_sort"> Item Name </th>
                    <th class="no_sort"> Purchase </th>
                    <th class="no_sort"> Price </th>
                    <th class="no_sort"> Item Name </th>
                    <th class="no_sort"> Purchase </th>
                    <th class="no_sort"> Price </th>
   					<th class="no_sort"> Item Name </th>
                    <th class="no_sort"> Purchase </th>
                    <th class="no_sort"> Price </th>
                   
                  </tr>
                </thead>
            	<tbody>
                  <?php 
                  		$price2_count=mysql_query("select count(*) as c from price_list p, item_master i where i.item_code=p.p_item_code");
                  		$price2_count2=mysql_fetch_assoc($price2_count);
                  		$price2_count=$price2_count2['c'];
                  		$p2row_count=ceil($price2_count/3);
                  		$limit=0;
                  		for ($i=0 ; $i<$p2row_count ; $i++){
                  			$price2_result=mysql_query("select p.p_item_code,p.p_id,i.item,p.price2, p.purchase from item_master i, price_list p where i.item_code=p.p_item_code limit $limit,3");
                   ?>
                  <tr>
                        <?php while($price2_arr=mysql_fetch_array($price2_result)) { ?>
                    <td><?php echo $price2_arr['item'] ; ?></td>
                    <td>&nbsp;&nbsp;<?php echo $price2_arr['purchase'] ; ?></td>
                     <td class="to_hide_phone"> <input class="row-fluid span6" name="<?php echo $price2_arr['p_item_code'] ;?>" value="<?php echo $price2_arr['price2'] ;?>"  type="text"  onclick="this.select();" onfocus="this.select();"  onblur="extractNumber(this,2,false);" onkeyup="extractNumber(this,2,false);" onkeypress="return blockNonNumbers(this, event, true, false);"> </td>
              
            
                  <?php 
                   }
                   $limit=$limit+3;
                   
                   }  ?>
  
                  </tbody>
                </table>
              <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
              <p align="center"> <button name="p2_btn" value="p2_v" type="submit"  class="btn btn-primary">Save changes</button> </p>

                </div>
                </form>
                <?php } ?>
                
                <?php if(isset($_GET['tab3'])) {?>
                
             <form name="secondary" action="selling_price.php?invoice=active&in_invoice=in&s_invoice=active&tab3=pr3" method="post"> 
             <div class="tab-pane fade in active" id="profile2">
                   <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
                <thead>
                  <tr>
                   <th class="no_sort"> Item Name </th>
                    <th class="no_sort"> Purchase </th>
                    <th class="no_sort"> Price </th>
                    <th class="no_sort"> Item Name </th>
                    <th class="no_sort"> Purchase </th>
                    <th class="no_sort"> Price </th>
   					<th class="no_sort"> Item Name </th>
                    <th class="no_sort"> Purchase </th>
                    <th class="no_sort"> Price </th>
                   
                  </tr>
                </thead>
            	<tbody>
                  <?php 
                  		$price3_count=mysql_query("select count(*) as c from price_list p, item_master i where i.item_code=p.p_item_code");
                  		$price3_count2=mysql_fetch_assoc($price3_count);
                  		$price3_count=$price3_count2['c'];
                  		$p3row_count=ceil($price3_count/3);
                  		$limit=0;
                  		for ($i=0 ; $i<$p3row_count ; $i++){
                  			$price3_result=mysql_query("select p.p_item_code,p.p_id,i.item,p.secondary, p.purchase from item_master i, price_list p where i.item_code=p.p_item_code limit $limit,3");
                   ?>
                  <tr>
                        <?php while($price3_arr=mysql_fetch_array($price3_result)) { ?>
                    <td><?php echo $price3_arr['item'] ; ?></td>
                    <td><?php echo $price3_arr['purchase'] ; ?></td>
                     <td class="to_hide_phone"> <input class="row-fluid span6" name="<?php echo $price3_arr['p_item_code'] ;?>" value="<?php echo $price3_arr['secondary'] ;?>"  type="text" onclick="this.select();" onfocus="this.select();" onblur="extractNumber(this,2,false);" onkeyup="extractNumber(this,2,false);" onkeypress="return blockNonNumbers(this, event, true, false);"> </td>
              
            
                  <?php 
                   }
                   $limit=$limit+3;
                   
                   } ?>
  
                  </tbody>
                          </table>
                          <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
				    <p align="center"> <button name=sec_btn value="se_v" type="submit"  class="btn btn-primary">Save changes</button> </p>
                </div>
             </form>
             <?php } ?>
             
             <?php if(isset($_GET['tab4'])) {?>
              <form name="purchase" action="selling_price.php?invoice=active&in_invoice=in&s_invoice=active&tab4=pr4" method="post"> 
             <div class="tab-pane fade in active" id="profile3">
                   <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
                <thead>
                  <tr>
                    <th class="no_sort"> Sl#</th>
                    <th class="no_sort"> Item </th>
                    <th class="no_sort"> Price </th>
                    <th class="no_sort"> Sl#</th>
                    <th class="no_sort"> Item </th>
                    <th class="no_sort"> Price </th>
                    <th class="no_sort"> Sl#</th>
                    <th class="no_sort"> Item </th>
                    <th class="no_sort"> Price</th>
                   
                  </tr>
                </thead>
            	<tbody>
                  <?php 
                  		$price4_count=mysql_query("select count(*) as c from price_list p, item_master i where i.item_code=p.p_item_code");
                  		$price4_count2=mysql_fetch_assoc($price4_count);
                  		$price4_count=$price4_count2['c'];
                  		$p4row_count=ceil($price4_count/3);
                  		$limit=0;
                  		for ($i=0 ; $i<$p4row_count ; $i++){
                  			$price4_result=mysql_query("select p.p_item_code,p.p_id,i.item,p.purchase from item_master i, price_list p where i.item_code=p.p_item_code limit $limit,3");
                   ?>
                  <tr>
                        <?php while($price4_arr=mysql_fetch_array($price4_result)) { ?>
                    <td><?php echo $price4_arr['p_id'] ; ?></td>
                    <td><?php echo $price4_arr['item'] ; ?></td>
                     <td class="to_hide_phone"> <input class="row-fluid span6" name="<?php echo $price4_arr['p_item_code'] ;?>" value="<?php echo $price4_arr['purchase'] ;?>"  type="text" placeholder="<?php echo $price1_arr['purchase'] ;?>" onclick="this.select();" onfocus="this.select();" onblur="extractNumber(this,2,false);" onkeyup="extractNumber(this,2,false);" onkeypress="return blockNonNumbers(this, event, true, false);"> </td>
              
            
                  <?php 
                   }
                   $limit=$limit+3;
                   
                   } $conn->close(); ?>
  
                  </tbody>
                          </table>
                          <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
				    <p align="center"> <button name=pur_btn value="se_v" type="submit"  class="btn btn-primary">Save changes</button> </p>
                </div>
             </form>
             <?php } ?>
    
             
             
             
             
             
                
              </div>
            </div>
            <!-- End .content --> 
          </div>
          <!-- End  .box --> 
        </div>
        <!-- End .span12 -->
        
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
  
  function SecondSubmit()
    {
    	document.getElementById("secondary").submit();
    }

  function p1Submit()
  {
  	document.getElementById("p1").submit();
  }

  function p2Submit()
  {
  	document.getElementById("p2").submit();
  }


</script>
</body>
</html>