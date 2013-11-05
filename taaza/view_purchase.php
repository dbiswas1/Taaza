<?php

    include 'db_config.php' ;
  		
	$conn=new createConnection();
	$conn->connect();
	$conn->selectdb();

	session_start();	
	//$date = date('m-d-Y');

	if (  isset($_POST["pu_btn"]) || isset($_POST['pu_ed_btn']) || isset($_POST['indentkey']))
	{
		
	if ($_POST["formid"] == $_SESSION["formid"])
	{
		$_SESSION["formid"] = '';
		//echo '<pre>'; print_r($_POST); echo '</pre>';
		
		if(isset($_POST["pu_btn"])){
		
		
		$i_idx1=mysql_query("select item_code from item_master");
		$total_amt=0;
		while($i_idx_arr=mysql_fetch_array($i_idx1))
		{	
			$i_idx = $i_idx_arr['item_code'];
			$price_value="pr".$i_idx_arr['item_code'];
			if (isset($_POST[$i_idx]) && $_POST[$i_idx] != 0)
			{	
				$str="insert into purchase_order (p_b_id,pu_item_code, p_qty,p_price,p_date) values (".$_POST['b_id'].",".$i_idx .",". $_POST[$i_idx].",".$_POST[$price_value] .","." STR_TO_DATE('".$_POST['idate'] ."', '%m-%d-%Y'))";
				//echo $str;
				
				mysql_query($str);
				mysql_query("update inventory set primary_stock=primary_stock+'$_POST[$i_idx]' where s_item_code=$i_idx");
				
				$avg_string="select TRUNCATE(sum(p_price)/sum(p_qty),2) as avg_price from purchase_order where p_date = STR_TO_DATE('".$_POST['idate']."','%m-%d-%Y') and pu_item_code=$i_idx group by pu_item_code,p_date" ;
				
				//echo $avg_string;
				
				$avg_price_query=mysql_query($avg_string);
				$avg_price_arr=mysql_fetch_assoc($avg_price_query);
				$avg_price=$avg_price_arr['avg_price'];
				
				mysql_query("update price_list set purchase=$avg_price where p_item_code=$i_idx");
				$total_amt=$total_amt+$_POST[$price_value];
				
			}
		}
		 
		
		
			$biil_cur_due_query=mysql_query("select dues from biller where b_id='$_POST[b_id]'");
			$bill_cur_due_arr=mysql_fetch_assoc($bill_cur_due_query);
			$bill_cur_due=$cur_due_arr['dues'];
		
		
			mysql_query("insert into bill_payment_master (bill_b_id,paid,dues,date) values ('$_POST[b_id]',0,$bill_cur_due,now())");
			mysql_query("update biller set dues = dues + $total_amt where b_id = '$_POST[b_id]'"); 
		}
		
		if(isset($_POST['pu_ed_btn']))
		{
			
			$due_str="select sum(p_price) as amt from  purchase_order  where  p_b_id=".$_POST['biller_id']." and p_date=STR_TO_DATE('".$_POST['pur_date']."','%m-%d-%Y') group by p_date, p_b_id";
			$old_due_query=mysql_query("$due_str");
			$old_due_arr=mysql_fetch_assoc($old_due_query);
			$old_due=$old_due_arr['amt'];
			$i_idx1=mysql_query("select item_code from item_master");
			//echo "i am in edit";
			//echo "<pre>"; print_r($_POST) ;  echo "</pre>";
			$total_amt=0;
			while($i_idx_arr=mysql_fetch_array($i_idx1))
			{
				$i_idx = $i_idx_arr['item_code'];
				$count_str="select count(*) as c from purchase_order where p_date=STR_TO_DATE('".$_POST['pur_date']."','%m-%d-%Y') and p_b_id=".$_POST['biller_id']." and pu_item_code=".$i_idx ; 
				$in_up1=mysql_query($count_str);
				$in_up_arr=mysql_fetch_assoc($in_up1);
				$in_up=$in_up_arr['c'];
				if (isset($_POST[$i_idx]) && $in_up != 0)
				{
					//echo "I am in in 1";
					$qty_str="select p_qty from purchase_order where p_date=STR_TO_DATE('".$_POST['pur_date']."','%m-%d-%Y') and p_b_id=".$_POST['biller_id']." and pu_item_code=$i_idx";
					//echo $qty_str;
					$current_qty1=mysql_query($qty_str);
					$current_qty_arr=mysql_fetch_assoc($current_qty1);
					$current_qty=$current_qty_arr['p_qty'];
					//echo "Curr_value".$current_qty."<br>"."Updated Qty".$_POST[$i_idx];
					$updated_qty=$current_qty-$_POST[$i_idx];
					$pr_idx="pr".$i_idx;
					mysql_query("update inventory set primary_stock=primary_stock-$updated_qty where s_item_code=$i_idx");
					
					$update_purchase_string="update purchase_order set p_qty=".$_POST[$i_idx]." , p_price=".$_POST[$pr_idx]. " where p_date=STR_TO_DATE('".$_POST['pur_date']."','%m-%d-%Y') and p_b_id=".$_POST['biller_id']." and pu_item_code=$i_idx" ;
					//echo $update_purchase_string."<br>";
					mysql_query($update_purchase_string);
					
					$avg_string="select TRUNCATE(sum(p_price)/sum(p_qty),2) as avg_price from purchase_order where p_date = STR_TO_DATE('".$_POST['pur_date']."','%m-%d-%Y') and pu_item_code=$i_idx group by pu_item_code,p_date" ;
					
					//echo $avg_string;
					
					$avg_price_query=mysql_query($avg_string);
					$avg_price_arr=mysql_fetch_assoc($avg_price_query);
					$avg_price=$avg_price_arr['avg_price'];
					
					mysql_query("update price_list set purchase=$avg_price where p_item_code=$i_idx");
					//$total_amt=$total_amt+$_POST[$pr_idx];
					
					
				}
				if (isset($_POST[$i_idx])  && $in_up == 0)
				{
					$pr_idx="pr".$i_idx;
					$str="insert into purchase_order (p_b_id,pu_item_code, p_qty,p_price,p_date) values (".$_POST['biller_id'].",".$i_idx .",". $_POST[$i_idx].",".$_POST[$pr_idx] .","." STR_TO_DATE('".$_POST['pur_date'] ."', '%m-%d-%Y'))";
				//echo "i am in second";
				
					mysql_query($str);
					
					$update_inventory_string="update inventory set primary_stock=primary_stock+".$_POST[$i_idx]." where s_item_code=$i_idx";
					//echo $update_inventory_string;
					mysql_query("update inventory set primary_stock=primary_stock+ $_POST[$i_idx] where s_item_code=$i_idx");
					
					$avg_string="select TRUNCATE(sum(p_price)/sum(p_qty),2) as avg_price from purchase_order where p_date = STR_TO_DATE('".$_POST['pur_date']."','%m-%d-%Y') and pu_item_code=$i_idx group by pu_item_code,p_date" ;
					
					//echo $avg_string;
				
					$avg_price_query=mysql_query($avg_string);
					$avg_price_arr=mysql_fetch_assoc($avg_price_query);
					$avg_price=$avg_price_arr['avg_price'];
					
					$update_price_string="update price_list set purchase=$avg_price where p_item_code=$i_idx";
					//echo $update_price_string;
				
					mysql_query("update price_list set purchase=$avg_price where p_item_code=$i_idx");
					//$total_amt=$total_amt+$_POST[$pr_idx];
				}
		
		
			}
			
			
			
			//echo $due_str;
			$cur_due_query=mysql_query("$due_str");
			$cur_due_arr=mysql_fetch_assoc($cur_due_query);
			$cur_due=$cur_due_arr['amt'];
			$cur_due= $cur_due-$old_due;
			//echo "old AMt".$old_due ."Diff".$cur_due;
			mysql_query("update biller set dues = dues + $cur_due where b_id = '$_POST[biller_id]'");
			mysql_query("insert into bill_payment_master (bill_b_id,paid,dues,date) values ('$_POST[biller_id]',0,(select dues from biller where b_id='$_POST[biller_id]'),now())");
			
		}
		
		if(isset($_POST['indentkey']))
		{
			//mysql_query("delete from indent_order where i_indent_no='$_POST[indentkey]'") ;
			//mysql_query("delete from indent where indent_no='$_POST[indentkey]'") ;
				
			
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
<title>Taaza Tarkari - View Purchase</title>
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
        <div class="box color_13">
          <div class="title">
            <h4> <span>Purchase table <small>(Sorted in descending order)</small> </span> </h4>
          </div>
          <!-- End .title -->
          
          <div class="content top">
           
           
            
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
              <thead>
                <tr>
                  <th class="">SL #</th>
                  <th class="">Market Name</th>
                  <th class="">Amount</th>
                  <th class="">Date</th>
                 
                  <th class="ms no_sort">Actions</th>
                </tr>
              </thead>
              <tbody>
           <?php 
           
                $sl=0;
              	$view_in_result1=mysql_query("select b.b_id,p.p_id, b.market_name, sum(p.p_price) as amt, date_format(p.p_date,'%m-%d-%Y') as pu_date,date_format(p.p_date,'%D-%b-%Y') as date from biller b , purchase_order p where p.p_b_id=b.b_id group by p.p_date, p.p_b_id ");
              	while($view_in_arr=mysql_fetch_array($view_in_result1)){
              		
             
              	
              	
              ?> 
                <tr>
                  <td class="to_hide_phone"><?php echo $sl++ ; ?>
                  <td class="to_hide_phone"><?php echo $view_in_arr['market_name']; ?></td>
                  <td class=""><?php echo $view_in_arr['amt']; ?></td>
                  <td class=""><?php echo $view_in_arr['date']; ?></td>
                                  
             
                  <td class="ms">
                  	<div class="btn-group"> 
                  		<a class="btn btn-small"  href="edit_purchase.php?purchase=active&v_purchase=active&pu_date=<?php echo $view_in_arr['pu_date'];?>&gen_b_name=<?php echo $view_in_arr['market_name']; ?> &gen_b_id=<?php echo $view_in_arr['b_id']; ?>" rel="tooltip" data-placement="top" data-original-title=" Edit Purchase "><i class="gicon-edit"></i></a> 
                  		<!--  <a class="btn btn-small" rel="tooltip" data-placement="top" data-original-title="View"><i class="gicon-eye-open"></i></a> -->
                   		<a class="btn btn-small"  href="#?cid=<?php echo $client_id ; ?>&price=<?php echo $view_in_arr['price']; ?>&indent_no=<?php echo $view_in_arr['indent_no']; ?>&date=<?php echo $view_in_arr['i_date1']; ?>" rel="tooltip" data-placement="top" data-original-title=" Print Purchase"><i class="gicon-print"></i></a>
                   		<a data-toggle="modal" href="<?php echo "#myModal".$view_in_arr['b_id'] . $view_in_arr['pu_date']; ?>" class="btn  btn-small" rel="tooltip" data-placement="top" data-original-title="View Purchase"><i class="gicon-eye-open"></i></a>
						<!-- <a class="btn  btn-small"  id="remrow" rel="tooltip" data-placement="top" data-original-title="Remove Indent" onclick="javascript:openDialog(<?php echo $view_in_arr['p_id']; ?>);"><i class="gicon-remove "></i></a> -->
						 
                  	</div>
                  		
                  </td>
                 
                  
                </tr>
                
										
                
                
                <?php }  ?>
                
                           
           
               </tbody>
            </table>
            
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
		 
		 <?php 
		 	
		 	$pop_pur_result=mysql_query("select b.b_id,p.p_id, b.market_name, sum(p.p_price) as amt, date_format(p.p_date,'%m-%d-%Y') as pu_date,date_format(p.p_date,'%D-%b-%Y') as date from biller b , purchase_order p where p.p_b_id=b.b_id group by p.p_date, p.p_b_id");
		 	while($pop_pur_arr= mysql_fetch_array($pop_pur_result)){
		 	
		 	
		 		$biller_name=$pop_pur_arr['market_name'];
		 	
		 		 
		 	
		 		
		 		
		 		$count_str="select count(*) as c from purchase_order where p_b_id=".$pop_pur_arr['b_id']." and p_date=STR_TO_DATE('".$pop_pur_arr['pu_date']." ','%m-%d-%Y')";
		 		$count1=mysql_query($count_str);
		 		$count2=mysql_fetch_assoc($count1);
		 		$count=$count2['c'];
		 		 
		 
		 ?>
		 
		<div id="myModal<?php echo $pop_pur_arr['b_id'] . $pop_pur_arr['pu_date']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                	  <div class="modal-header">
                  	  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  	  	<h1 id="myModalLabel">
                  	  	<table>
                  	  	<tr>
                  	  		<td>Shop Name: <?php echo" ".$biller_name ; ?></td> 
                  	  		<td>Total Items=<?php echo $count;?> </td> 
                  	  		<td>Date:<?php echo " ".$pop_pur_arr['pu_date'];?></td>   
                  	  	</tr>
                  	  	</table>
                  	  	</h1>
                	  </div>
                	  <div class="modal-body">
                  		
                  			<table class="table table-condensed table-striped">
           					 <thead>
             				 	<tr>
                				<th> Item</th>
                				<th> Qty </th>
                				<th> Price</th>
                				<th> Item</th>
                				<th> Qty </th>
                				<th> Price</th>
              					</tr>
           					 </thead>
            				 <tbody>
            				 <?php 
            				 	
            				 	
            				 	
            				 	
            				 	$limit=0;
            				 	$rowcount=ceil($count/2);
            				 	for($i=0; $i<$rowcount; $i++){
            				 	
            				 		$modal_string="select i.item,p.p_qty,p.p_price from item_master i , purchase_order p where p.pu_item_code=i.item_code and p.p_date = STR_TO_DATE('".$pop_pur_arr['pu_date']."','%m-%d-%Y') and p.p_b_id=".$pop_pur_arr['b_id']." limit $limit,2"; 
            				 		$i_ord1=mysql_query($modal_string);
            				 	
            				 		
            				 	
            				 	
            				 ?>
              				  <tr>
              				  <?php while($i_ord_arr=mysql_fetch_array($i_ord1)){ ?>
                				<td> <?php echo $i_ord_arr['item']; ?> </td>
                				<td> <?php echo $i_ord_arr['p_qty']; ?> </td>
                				<td> <?php echo $i_ord_arr['p_price']; ?></td>
                				
                				<?php } $limit=$limit+2; ?>
              				</tr>
              				<?php } ?>
              			
        
            			</tbody>
          				</table>
                	  </div>
                	  <div class="modal-footer">
                	  		
                  			Total=<?php echo $pop_pur_arr['amt'] ?>&nbsp;&nbsp;&nbsp;<button class="btn" data-dismiss="modal">Close</button>
                  			
                	  </div>
              		</div>
              		
              		<?php }$conn->close(); ?>
        		 
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

 <div class="avgrund-popup  stack modal" id="default-popup" >
  <div class="modal-header">
    <h3 id="myModalLabel">Confirm</h3>
  </div>
  <div class="modal-body">
    <p> Do you want to Delte the Indent </p>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" onclick="javascript:formSubmit();">Delete</button>
    <button class="btn btn-primary" onclick="javascript:closeDialog();">Close</button>
  </div>
</div>
<div class="avgrund-cover"></div>



<!-- End .background_changer -->
<!-- /container --> 





<!-- Le javascript
    ================================================== --> 
<!-- General scripts --> 
<script src="js/jquery.js" type="text/javascript"> 
var global_indent;
</script> 
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
<script language="javascript" type="text/javascript" src="js/plugins/chosen/chosen/chosen.jquery.min.js"></script> 

<!-- Data tables plugin --> 
<script type="text/javascript" language="javascript" src="js/plugins/datatables/js/jquery.dataTables.js"></script> 

<!-- Custom made scripts for this template --> 
<script src="js/scripts.js" type="text/javascript"></script> 

<script>
function openDialog(value) {
	global_indent=value;
	  Avgrund.show( "#default-popup" );
  
}
function closeDialog() {
  Avgrund.hide();
}

function formSubmit()
{

	//alert(global_indent);


		
	var form = document.createElement("form");
    form.setAttribute("method", "POST");
    form.setAttribute("action", "view_indent.php?indent=active&in_indent=in&v_indent=active");
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "indentkey");
    hiddenField.setAttribute("value", global_indent);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "formid");
    hiddenField.setAttribute("value", "<?php echo $_SESSION["formid"]; ?>");
    form.appendChild(hiddenField);

   
 
    
    document.body.appendChild(form);
	form.submit();
}
</script> 


<script type="text/javascript">
  /**** Specific JS for this page ****/
  // Datatables
    $(document).ready(function() {
    
      var dontSort = [];
                $('#datatable_example thead th').each( function () {
                    if ( $(this).hasClass( 'no_sort' )) {
                        dontSort.push( { "bSortable": false } );
                    } else {
                        dontSort.push( null );
                    }
      } );
      $('#datatable_example').dataTable( {
        "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
         "aaSorting": [[ 0, "desc" ]],
        "bPaginate": true,

        "sPaginationType": "full_numbers",
        "bJQueryUI": false,
        "aoColumns": dontSort,
        
      } );
      $.extend( $.fn.dataTableExt.oStdClasses, {
        "s`": "dataTables_wrapper form-inline"
      } );

       $(".chzn-select, .dataTables_length select").chosen({
                   disable_search_threshold: 10

        });
    });
  
  
    $('#remrow').click(function() {
        $('table.table-editor tr:eq(-1)').remove();

        
    });

</script>

</body>
</html>
