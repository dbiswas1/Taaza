<!-- To Avoid resubmitting -->
<?php

    include 'db_config.php' ;
  		
	$conn=new createConnection();
	$conn->connect();
	$conn->selectdb();

	session_start();	
	

	if (isset($_POST["gn_btn_in"]) || isset($_POST["del_invoice"]) || isset($_POST["in_ed_btn"]))
	{
		if ($_POST["formid"] == $_SESSION["formid"])
		{
			$_SESSION["formid"] = '';
			
			
			if(isset($_POST["del_invoice"]))
			{
				//echo "Invoice No" . $_POST["del_invoice"];
				$indent_no_1=mysql_query("select in_c_id,amount,in_indent_no from invoice where invoice_no='$_POST[del_invoice]'");
				$indent_arr1=mysql_fetch_assoc($indent_no_1);
				mysql_query("update indent set invoiced=0 where indent_no='$indent_arr1[in_indent_no]'");
				
				$indent_date_query=mysql_query("select date_format(i_date,'%d-%m-%Y') as i_date from indent where indent_no='$indent_arr1[in_indent_no]'");
				$indent_date_arr=mysql_fetch_assoc($indent_date_query);
				$indent_date=$indent_date_arr['i_date'];
				
				mysql_query("delete from invoice_history where in_h_indent_no='$indent_arr1[in_indent_no]'");
				mysql_query("delete from invoice where invoice_no='$_POST[del_invoice]'");
				mysql_query("update client set dues=dues-'$indent_arr1[amount]' where c_id='$indent_arr1[in_c_id]'");
				
				$cur_due_query=mysql_query("select dues from client where c_id='$indent_arr1[in_c_id]'");
				$cur_due_arr=mysql_fetch_assoc($cur_due_query);
				$cur_due=$cur_due_arr['dues'];
				
				mysql_query("insert into payment_master (pay_c_id,paid,dues,date) values ('$indent_arr1[in_c_id]',0,$cur_due,STR_TO_DATE('$indent_date','%d-%m-%Y'))");
			}
			
			if(isset($_POST["in_ed_btn"]))
			{
				//echo '<pre>'; print_r($_POST); echo '</pre>';
				
				$item_in_index=mysql_query("select in_h_item_code from invoice_history where in_h_invoice_no='$_POST[invoice_ch_no]'");
				while($item_ed_arr = mysql_fetch_array($item_in_index))
				{
					$edidx=$item_ed_arr['in_h_item_code'];
					//echo $edidx ."<br>";
					//echo "Post value oe of $edidx".$_POST[$edidx] . "<br>";
					
					mysql_query("update invoice_history set in_h_price='$_POST[$edidx]' where in_h_invoice_no='$_POST[invoice_ch_no]' and in_h_item_code=$edidx");
					
						
				}
				
				$amt_query="select sum(ino.qty*ih.in_h_price) as amt  from invoice_history ih, indent_order ino where ih.in_h_item_code=ino.i_item_code and ih.in_h_indent_no=ino.i_indent_no and ih.in_h_invoice_no=".$_POST["invoice_ch_no"];
				$amt1=mysql_query($amt_query);
				$amt_arr=mysql_fetch_assoc($amt1);
				$amt=$amt_arr['amt'];
				
				$old_amt_query=mysql_query("select in_c_id,amount from invoice where invoice_no='$_POST[invoice_ch_no]'");
				$old_amt_arr=mysql_fetch_array($old_amt_query);
				$old_amt=$old_amt_arr['amount'];
					
				$due_amt_diff=$amt-$old_amt;
				$due_client_id=$old_amt_arr['in_c_id'];
				
				
					
				//echo "Due Iff is $due_amt_diff";
				
				mysql_query("update invoice set amount=$amt where invoice_no='$_POST[invoice_ch_no]'");
				mysql_query("update client set dues=dues+$due_amt_diff where c_id=$due_client_id" );
				
				
				$invoice_date_query=mysql_query("select date_format(in_date,'%d-%m-%Y') as in_date from invoice where invoice_no='$_POST[invoice_ch_no]'");
				$invoice_date_arr=mysql_fetch_assoc($invoice_date_query);
				$invoice_date=$invoice_date_arr['in_date'];
				
				mysql_query("insert into payment_master (pay_c_id,paid,dues,date) values ($due_client_id,0,(select dues from client where c_id=$due_client_id),STR_TO_DATE('$invoice_date','%d-%m-%Y'))");
				
			}
			
			
			//echo "<pre>"; print_r($_POST) ;  echo "</pre>";
			
			
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
<title>Taaza Tarkari - View Invoices</title>
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

<form name=view_in action="view_invoice.php?invoice=active&in_invoice=in&v_invoice=active">
	<div id="main" style="min-height:1000px">
		<?php include 'top.php' ; ?>
		<!-- End Top Right -->
    <div id="main_container">
      <div class="row-fluid">
        <div class="box color_3">
          <div class="title">
            <h4> <span>Invoices table <small>(Sorted in descending order)</small> </span> </h4>
          </div>
          <!-- End .title -->
          
          <div class="content top">
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
              <thead>
                <tr>
                  <th class="">Invoice #</th>
                  <th class="">Date</th>
                  <th class="">Shop Name</th>
                  <th class="">Amount</th>
                  <!--  <th class="">Status</th> -->
                 <!--   <th class="">Dues</th>  -->
                  
                  <th class="ms no_sort ">Actions</th>
                </tr>
              </thead>
              <tbody>
              
              <?php 
              	$view_invoice_query=mysql_query("select inv.in_indent_no,c.c_id,inv.invoice_no,date_format(inv.in_date,'%b-%d-%Y') as in_date,c.shop_name,inv.amount from invoice inv, client c where inv.in_c_id=c.c_id");
              	while( $v_i_arr=mysql_fetch_array($view_invoice_query)){
              	
              	?>
                <tr>
                  <td><?php echo $v_i_arr['invoice_no'] ;?></td>
                  <td><?php echo $v_i_arr['in_date']; ?></td>
                  <td class="to_hide_phone"><?php echo $v_i_arr['shop_name'] ;?></td>
                  <td class="to_hide_phone"><strong> <?php echo $v_i_arr['amount'] ;?> </strong></td>
                 <!--  <td><?php echo ($v_i_arr['status'] == 0 ? "Pending" : "Processed") ; ?></td> --> 
                <!--   <td class="to_hide_phone"><?php echo $v_i_arr['dues'] ; ?></td> --> 
                  <td class="ms">
                  	<div class="btn-group"> 
                  		<a class="btn btn-small" href="Edit_Invoice.php?invoice=active&in_invoice=in&v_invoice=active&invoiceval=<?php echo $v_i_arr['invoice_no'] ;?>&indentval=<?php echo $v_i_arr['in_indent_no'] ;?>" rel="tooltip" data-placement="top" data-original-title=" Edit Invoice "><i class="gicon-edit"></i></a> 
                  		<a class="btn btn-small"  href="print_invoice.php?cid=<?php echo $v_i_arr['c_id'] ; ?>&invoice_no=<?php echo $v_i_arr['invoice_no'] ; ?>&date=<?php echo $v_i_arr['in_date']; ?>" rel="tooltip" data-placement="top" data-original-title=" Print Invoice"><i class="gicon-print"></i></a>
                  		<!--  <a class="btn btn-small" rel="tooltip" data-placement="top" data-original-title="View Indent"><i class="gicon-eye-open"></i></a> -->
                   		<a data-toggle="modal" href="#myModal<?php echo $v_i_arr['invoice_no'];?>" class="btn  btn-small" rel="tooltip" data-placement="top" data-original-title="View Invoice"><i class="gicon-eye-open"></i></a>
						
						<a class="btn  btn-small"  id="remrow" rel="tooltip" data-placement="top" data-original-title="Remove Invoice" onclick="javascript:openDialog(<?php echo $v_i_arr['invoice_no'] ; ?>);"><i class="gicon-remove "></i></a>
						 
						
						
						
                  	</div>
                  </td>
                </tr>
               <?php } ?>
               </tbody>
            </table>
          </div>
                    <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
          
          <!-- End .content --> 
        </div>
        <!-- End box --> 
      </div>
      <!-- End .row-fluid --> 
      
    </div>
    <!-- End #container --> 
  </div>
  
  </form>
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
           	<?php	
				$invoice_row=mysql_query("select invoice_no from invoice");
				while ($invoice_row_arr=mysql_fetch_array($invoice_row)){
				$total=0;
				$sl_no=1;
				
           	
           	?>
           	
           	<div id="myModal<?php echo $invoice_row_arr['invoice_no']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                	  <div class="modal-header">
                  	  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  	  	<h3 id="myModalLabel">Invoice Summary for Invoice:- <?php echo $invoice_row_arr['invoice_no']; ?></h3>
                	  </div>
                	  <div class="modal-body">
                	  	<table class="table table-condensed table-striped">
           					 <thead>
             				 	<tr>
                					<th> Sl# </th>
                					<th> Item </th>
                					<th> Qty</th>
                					<th> Price </th>
                					<th> <b>Total</b> </th>
                				
              					</tr>
           					 </thead>
            				 <tbody>
                  		<?php 
 							
 							
                  			$invoice_report=mysql_query("select ih.in_h_invoice_no,ino.i_indent_no,ih.in_h_item_code,it.item,ino.qty,in_h_price from invoice_history ih, indent_order ino, item_master it where it.item_code=in_h_item_code and ih.in_h_item_code=ino.i_item_code and ih.in_h_indent_no=ino.i_indent_no and ih.in_h_invoice_no='$invoice_row_arr[invoice_no]'");
							while($invoice_report_arr=mysql_fetch_array($invoice_report)){
						?>
							<tr>
								<td> <?php echo $sl_no ; $sl_no=$sl_no+1; ?>  </td>
								<td> <?php echo $invoice_report_arr['item'] ;?>  </td>
								<td> <?php echo $invoice_report_arr['qty'] ;?>  </td>
								<td> <?php echo $invoice_report_arr['in_h_price'] ;?>  </td>
								<td align="right"> <?php echo ($invoice_report_arr['in_h_price']*$invoice_report_arr['qty']); $total=($total)+($invoice_report_arr['in_h_price']*$invoice_report_arr['qty']) ;?>  </td>
							</tr>
						<?php }?>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td><b>Sub Total</b></td>
								<td align="right"><b><?php echo $total ; ?></b></td>
								<?php $total=0; $sl_no=1; ?>
							</tr>
							</tbody>
						</table>	
						
                	  </div>
                	  <div class="modal-footer">
                  			<button class="btn" data-dismiss="modal">Close</button>
                  			
                	  </div>
              		</div>
              		<?php } $conn->close(); ?>
  
</div>
<!-- End .background_changer -->

 <div class="avgrund-popup  stack modal" id="default-popup" >
  <div class="modal-header">
    <h3 id="myModalLabel">Confirm</h3>
  </div>
  <div class="modal-body">
    <p> Do you want to Delte the Invoice </p>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" onclick="javascript:formSubmit();">Delete</button>
    <button class="btn btn-primary" onclick="javascript:closeDialog();">Close</button>
  </div>
</div>
<div class="avgrund-cover"></div>

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
<script language="javascript" type="text/javascript" src="js/plugins/chosen/chosen/chosen.jquery.min.js"></script> 

<!-- Data tables plugin --> 
<script type="text/javascript" language="javascript" src="js/plugins/datatables/js/jquery.dataTables.js"></script> 

<!-- Custom made scripts for this template --> 
<script src="js/scripts.js" type="text/javascript"></script> 
<script>
function openDialog(value) {
	
	global_invoice=value;
	//alert(global_invoice);
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
    form.setAttribute("action", "view_invoice.php?invoice=active&in_invoice=in&v_invoice=active");
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "del_invoice");
    hiddenField.setAttribute("value", global_invoice);
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
  
  
  

</script>




</body>
</html>