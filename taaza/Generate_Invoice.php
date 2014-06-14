<!-- To Avoid resubmitting -->
<?php

    include 'db_config.php' ;
  		
	$conn=new createConnection();
	$conn->connect();
	$conn->selectdb();

	session_start();	
	

	if (isset($_POST["inden_no"]) )
	{
		if ($_POST["formid"] == $_SESSION["formid"])
		{
			$_SESSION["formid"] = '';
			//echo "<pre>"; print_r($_POST) ;  echo "</pre>";
			
			mysql_query("update indent set invoiced=1 where indent_no='$_POST[inden_no]'");
			$indent_date_query=mysql_query("select date_format(i_date,'%d-%m-%Y') as i_date from indent where indent_no='$_POST[inden_no]'");
			$indent_date_arr=mysql_fetch_assoc($indent_date_query);
			$indent_date=$indent_date_arr['i_date'];
			
			//mysql_query("insert into invoice (in_indent_no,in_c_id,price,in_date) values ('$_POST[inden_no]','$_POST[cli_id]','$_POST[price]',now())");
			$insert_invoice_string="insert into invoice (in_indent_no,in_c_id,in_date) values (".$_POST['inden_no'].",".$_POST['cli_id'].",STR_TO_DATE('".$indent_date."','%d-%m-%Y'))";
			//echo $insert_invoice_string;
			mysql_query($insert_invoice_string);
			$build_indent1=mysql_query("select i_item_code from indent_order where i_indent_no='$_POST[inden_no]' ");
			
			$q_invoice_no1=mysql_query("select invoice_no from invoice where in_indent_no='$_POST[inden_no]'");

			$q_invoice_arr=mysql_fetch_assoc($q_invoice_no1);

			$q_invoice_no=$q_invoice_arr['invoice_no'];
			
			

			
			
			while ($build_arr=mysql_fetch_array($build_indent1)){
				
				
				$price_query_string="select ".$_POST["price"]. " as p from price_list where p_item_code=".$build_arr['i_item_code'];
				//echo $price_query_string."<br>";
				$q_price_detail1=mysql_query("$price_query_string");
				
				
				
				
				$q_price_arr=mysql_fetch_assoc($q_price_detail1);
				
				//echo "<pre>"; print_r($q_price_arr) ;  echo "</pre>";
				
				$q_price_detail=$q_price_arr['p'];
				
				//echo $q_price_detail .$q_invoice_no."this is price and invoice" ."<br>";
			
				$query_string="insert into invoice_history (in_h_invoice_no,in_h_indent_no,in_h_item_code,in_h_price,in_date) values ($q_invoice_no,$_POST[inden_no],'$build_arr[i_item_code]',$q_price_detail,STR_TO_DATE('$indent_date','%d-%m-%Y'))";
				
				//echo $query_string . "<br>";
				mysql_query($query_string);
				
				
				
			}
			$amt_query="select sum(ino.qty*ih.in_h_price) as amt  from invoice_history ih, indent_order ino where ih.in_h_item_code=ino.i_item_code and ih.in_h_indent_no=ino.i_indent_no and ino.i_indent_no=".$_POST["inden_no"];
			$amt1=mysql_query($amt_query);
			$amt_arr=mysql_fetch_assoc($amt1);
			$amt=$amt_arr['amt'];
			
			mysql_query("update invoice set amount=$amt where invoice_no=$q_invoice_no");
			$client_due_id=mysql_query("select in_c_id from invoice where invoice_no=$q_invoice_no");
			$client_due_arr=mysql_fetch_assoc($client_due_id);
			
			$cur_due_query=mysql_query("select dues from client where c_id='$client_due_arr[in_c_id]'");

			$cur_due_arr=mysql_fetch_assoc($cur_due_query);

			$cur_due=$cur_due_arr['dues'];

				

				

			mysql_query("insert into payment_master (invoice_no,new_dues,pay_c_id,paid,dues,date) values ($q_invoice_no,$cur_due+$amt,'$client_due_arr[in_c_id]',0,$cur_due,STR_TO_DATE('$indent_date','%d-%m-%Y'))");
			
			
			mysql_query("update client set dues=($amt+dues) where c_id='$client_due_arr[in_c_id]'");
			

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
<title>Taaza Tarkari - Generate Invoices</title>
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
		
		<?php include 'top.php' ; ?>
		 <!-- End Top Right -->
    
	<div id="main_container">
      <div class="row-fluid">
        <div class="box color_3">
          <div class="title">
            <h4> <span>Generate Invoices table <small>(Sorted in descending order)</small> </span> </h4>
          </div>
          <!-- End .title -->
          
         <!--  <form action="Generate_Invoice.php?invoice=active&in_invoice=in&g_invoice=active" method="post"> --> 
         
          <div class="content top">
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
              <thead>
                <tr>
                  <th class="">Indent #</th>
                  <th class="">Date</th>
                  <th class="">Shop Name</th>
                  <th class="no_sort">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select Price</th>
                  
                  
                  <th class="ms no_sort ">Actions</th>
                </tr>
              </thead>
              <tbody>
               <?php 
          		$invoice_result1=mysql_query("select price,indent_no, i_client_id,date_format(i_date,'%b-%d-%Y') as d from indent where invoiced=0");
          		while($invoice_arr=mysql_fetch_array($invoice_result1)){  	
          		?>
          		
                <tr>
                
                  <td><a data-toggle="modal" href=<?php echo "#myModal".$invoice_arr['indent_no'] ; ?>  rel="tooltip"  data-original-title="View Indent"><b><?php echo $invoice_arr['indent_no'] ;?></b> </a></td>
                  <td><?php echo  $invoice_arr['d'] ; ?></td>
                  <?php $shop_result=mysql_query("select shop_name from client where c_id='$invoice_arr[i_client_id]'") ;
                  		$shop_arr=mysql_fetch_assoc($shop_result);
                  		
                  ?>
                  <td class="to_hide_phone" name="shop_name" value="<?php echo $shop_arr['shop_name'] ; ?>"><?php echo $shop_arr['shop_name'] ; ?></td>
                  <input type="hidden" name="shop_name" value="<?php echo $shop_arr['shop_name']; ?>" />
                  <!--  <input type="hidden" name="inden_no" value="<?php echo $invoice_arr['indent_no']; ?>" /> -->
          		<input type="hidden" name="cli_id" value="<?php echo $invoice_arr['i_client_id']; ?>" />
                  <td class="to_hide_phone">
				  
				   <div class="span6">
              		<select id="price<?php echo $invoice_arr['indent_no']; ?>" data-placeholder="Choose Price..." class="chzn-select" onchange="update_price<?php echo $invoice_arr['indent_no'] ; ?>(this.value) ;">
                      
                      <?php 
                      	if ($invoice_arr['price'] == 0)
                      	{
                      ?>
                      
                      <option value="price1" selected>Price 1</option>
                      <option value="price2">Price 2</option>
                      <option value="price3">Price 3</option>
                      <option value="price4">Price 4</option>
                      <option value="secondary">Secondary</option>
                     
                      <?php } elseif ($invoice_arr['price'] == 1){  ?>
					 
					  	
					  <option value="price1" >Price 1</option>
                      <option value="price2" selected>Price 2</option>
                      <option value="price3">Price 3</option>
                      <option value="price4">Price 4</option>
                      <option value="secondary">Secondary</option>
                      
                      
                      
                      
                      
                     <?php } elseif ($invoice_arr['price'] == 2){  ?>
					 
					  	
					  <option value="price1" >Price 1</option>
                      <option value="price2" >Price 2</option>
                      <option value="price3" selected>Price 3</option>
                      <option value="price4">Price 4</option>
                      <option value="secondary">Secondary</option>
                      
                     <?php }  elseif ($invoice_arr['price'] == 3){  ?>
                     
                      <option value="price1" >Price 1</option>
                      <option value="price2" >Price 2</option>
                      <option value="price3" >Price 3</option>
                      <option value="price4" selected>Price 4</option>
                      <option value="secondary">Secondary</option>
                     
                     
                     <?php } else { ?>
                     
                     <option value="price1" >Price 1</option>
                      <option value="price2">Price 2</option>
                      <option value="price3">Price 3</option>
                      <option value="price4">Price 4</option>
                      <option value="secondary" selected>Secondary</option>
					  
					  <?php } ?>
                      
               		</select>
               </div>
				  
				  </td>
                 
                  
                  <td class="ms">
                  	<div class="btn-group">
                  	
                  	 <script>
                	  	var price_details<?php echo $invoice_arr['indent_no'] ; ?>=document.getElementById("price<?php echo $invoice_arr['indent_no']; ?>");
                	  	var price_det<?php echo $invoice_arr['indent_no'] ; ?>=price_details<?php echo $invoice_arr['indent_no'] ; ?>.options[price_details<?php echo $invoice_arr['indent_no'] ; ?>.selectedIndex].value;
                	  	function update_price<?php echo $invoice_arr['indent_no'] ; ?>(pdata) { 
                	  		price_det<?php echo $invoice_arr['indent_no'] ; ?> = pdata;
                	       // alert(value);
                	    }

                	  </script>
                  	
                  			<button  name="gn_btn_in" class="btn btn-info" rel="tooltip" data-placement="top" data-original-title="Generate Invoice"  onclick="javascript:formSubmit1(<?php echo $invoice_arr['indent_no']; ?>,<?php echo $invoice_arr['i_client_id']; ?>,price_det<?php echo $invoice_arr['indent_no'] ; ?>);">Generate Invoice</button>
              
                  		 
                  	</div>
                  </td>
                </tr>
                <?php } ?>
                  </tbody>
            </table>
          </div>
          <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
          <!--  </form> -->
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
         		
         		
         		<?php 
		 	
		 	$pop_ind_result=mysql_query("select indent_no,i_client_id,date_format(i_date,'%D-%b-%Y') as i_date1, notes from indent where invoiced=0");
		 	while($pop_ind_arr= mysql_fetch_array($pop_ind_result)){
		 	
		 	
		 		$client_id=$pop_ind_arr['i_client_id'];
		 	
		 		 
		 		$shop_name1=mysql_query("select shop_name from client where c_id='$client_id'");
		 		$shop_name_arr=mysql_fetch_assoc($shop_name1);
		 		$shop_name=$shop_name_arr['shop_name']; 
		 		
		 		$indent_no=$pop_ind_arr['indent_no'];
		 		$count1=mysql_query("select count(*) as c from indent_order ind,item_master i where ind.i_item_code=i.item_code and i_indent_no=$indent_no");
		 		$count2=mysql_fetch_assoc($count1);
		 		$count=$count2['c'];
		 		 
		 
		 ?>
         		
         		<div id="myModal<?php echo $pop_ind_arr['indent_no']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                	  <div class="modal-header">
                  	  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  	  	<h1 id="myModalLabel">
                  	  	<table>
                  	  	<tr>
                  	  		<td><?php echo $shop_name ; ?></td> 
                  	  		<td>Total Items=<?php echo $count;?> </td> 
                  	  		<td><?php echo $pop_ind_arr['i_date1'];?></td>   
                  	  	</tr>
                  	  	</table>
                  	  	</h1>
                	  </div>
                	  <div class="modal-body">
                  		
                  			<table class="table table-condensed table-striped">
           					 <thead>
             				 	<tr>
                				<th> SL# </th>
                				<th> Item </th>
                				<th> Qty</th>
                				<th> SL# </th>
                				<th> Item </th>
                				<th> Qty</th>
              					</tr>
           					 </thead>
            				 <tbody>
            				 <?php 
            				 	
            				 	
            				 	
            				 	
            				 	$limit=0;
            				 	$rowcount=ceil($count/2);
            				 	$sl_count=0;
            				 	for($i=0; $i<$rowcount; $i++){
            				 	$i_ord1=mysql_query("select i.item,ind.qty from indent_order ind,item_master i where ind.i_item_code=i.item_code and i_indent_no=$indent_no limit $limit,2");
            				 	
            				 		
            				 	
            				 	
            				 ?>
              				  <tr>
              				  <?php while($i_ord_arr=mysql_fetch_array($i_ord1)){ ?>
                				<td> <?php echo $sl_count=$sl_count+1; ?> </td>
                				<td> <?php echo $i_ord_arr['item']; ?> </td>
                				<td> <?php echo $i_ord_arr['qty']; ?></td>
                				
                				<?php } $limit=$limit+2; ?>
              				</tr>
              				<?php } ?>
              			
        
            			</tbody>
          				</table>
                	  </div>
                	  <div class="modal-footer">
                	 
                	  
                	  <button class="btn btn-info" onclick="location.href='Edit_Indent.php?indent=active&in_indent=in&v_indent=active&gn_in_i_no=<?php echo $pop_ind_arr['indent_no']; ?>&gen_c_name=<?php echo $shop_name ; ?>&gen_c_id=<?php echo $pop_ind_arr['i_client_id'] ; ?>';">Edit</button>
                  	  <button class="btn" data-dismiss="modal">Close</button>
                  			
                	  </div>
              		</div>
              		
              		<?php }$conn->close(); ?>
  
</div>
<!-- End .background_changer -->
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
<script>


function formSubmit1($indentno,$clid,$price)
{

		//var $teststr1="indent_no=" + $indentno + " client="+ $clid+" price= "+$price ;
		//alert ($teststr1);

	  	


		
	var form = document.createElement("form");
    form.setAttribute("method", "POST");
    form.setAttribute("action", "Generate_Invoice.php?invoice=active&in_invoice=in&g_invoice=active");
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "inden_no");
    hiddenField.setAttribute("value", $indentno);
    form.appendChild(hiddenField);


    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "cli_id");
    hiddenField.setAttribute("value", $clid);
    form.appendChild(hiddenField);

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "price");
    hiddenField.setAttribute("value", $price);
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
<script src="js/scripts.js" type="text/javascript">
function openDialog() {
    Avgrund.show( "#default-popup" );
  }
  function closeDialog() {
    Avgrund.hide();
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