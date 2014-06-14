<?php

    include 'db_config.php' ;
  		
	$conn=new createConnection();
	$conn->connect();
	$conn->selectdb();

	session_start();	
	

	if (  isset($_POST["in_btn"]) || isset($_POST['in_ed_btn']) || isset($_POST['indentkey']))
	{
		
	if ($_POST["formid"] == $_SESSION["formid"])
	{
		$_SESSION["formid"] = '';
		//echo '<pre>'; print_r($_POST); echo '</pre>';
		
		if(isset($_POST["in_btn"])){
		
		//Do Not the Indent if the already a indent have been added
		$client_exist1=mysql_query("select count(*) as cl_count from indent where i_client_id='$_POST[cl_id]' and i_date=STR_TO_DATE('$_POST[idate]', '%m-%d-%Y')");
		$client_exist_arr=mysql_fetch_assoc($client_exist1);
		$client_exist=$client_exist_arr['cl_count'];
	
		if($client_exist == 0)	
		{
		
		mysql_query("insert into indent (i_client_id,price,i_date,notes) values('$_POST[cl_id]','$_POST[price]', STR_TO_DATE('$_POST[idate]', '%m-%d-%Y'),'$_POST[notes]' )" );
		$indent_no1=mysql_query("select indent_no from 	indent order by indent_no desc limit 1");
		$indent_arr=mysql_fetch_assoc($indent_no1);
		$indent_no=$indent_arr['indent_no'];
		
		$i_idx1=mysql_query("select item_code from item_master");
		
		while($i_idx_arr=mysql_fetch_array($i_idx1))
		{	
			$i_idx = $i_idx_arr['item_code'];
			if (isset($_POST[$i_idx]) && $_POST[$i_idx] != 0)
			{	
				mysql_query("insert into indent_order (i_indent_no,i_item_code, qty,date) values ('$indent_no','$i_idx', '$_POST[$i_idx]' ,STR_TO_DATE('$_POST[idate]', '%m-%d-%Y'))");
				mysql_query("update inventory set primary_stock=primary_stock-'$_POST[$i_idx]' where s_item_code=$i_idx");
			}
		}
		
		}
		else
		   {  ?>
		   	  
		   	  <script type="text/javascript">
		   	  alert( "Indent already exist for the client");
		   	  </script>
<?php		   }
		}
		
		if(isset($_POST['in_ed_btn']))
		{
			$i_idx1=mysql_query("select item_code from item_master");
			//echo "<pre>"; print_r($_POST) ;  echo "</pre>";
			while($i_idx_arr=mysql_fetch_array($i_idx1))

			{

				$i_idx = $i_idx_arr['item_code'];
				$in_up1=mysql_query("select count(*) as c from indent_order where i_indent_no='$_POST[indent_no_gen]' and i_item_code='$i_idx'");
				$in_up_arr=mysql_fetch_assoc($in_up1);
				$in_up=$in_up_arr['c'];

				if (isset($_POST[$i_idx])  && $in_up != 0)

				{
			
					$current_qty1=mysql_query("select qty from indent_order where i_indent_no='$_POST[indent_no_gen]' and i_item_code='$i_idx'");
					$current_qty_arr=mysql_fetch_assoc($current_qty1);
					$current_qty=$current_qty_arr['qty'];
					$updated_qty=$_POST[$i_idx]-$current_qty;
			
					mysql_query("update inventory set primary_stock=primary_stock-$updated_qty where s_item_code=$i_idx");

					mysql_query("update indent_order set qty='$_POST[$i_idx]',date=STR_TO_DATE('$_POST[idate]', '%m-%d-%Y') where i_indent_no='$_POST[indent_no_gen]' and i_item_code='$i_idx'" );
					
				}
				if (isset($_POST[$i_idx]) && $_POST[$i_idx] != 0 && $in_up == 0)
				{
					mysql_query("insert into indent_order (i_indent_no,i_item_code, qty,date) values ('$_POST[indent_no_gen]','$i_idx', '$_POST[$i_idx]',STR_TO_DATE('$_POST[idate]', '%m-%d-%Y') )");
					
					mysql_query("update inventory set primary_stock=primary_stock-'$_POST[$i_idx]' where s_item_code=$i_idx");
				}
		
		
			}
			mysql_query("update indent set price='$_POST[price]' ,notes='$_POST[notes]', i_date=STR_TO_DATE('$_POST[idate]','%m-%d-%Y') where indent_no= '$_POST[indent_no_gen]'");
			
			//echo $_POST["price"];
			
		}
		
		if(isset($_POST['indentkey']))
		{
			$del_qty_query=mysql_query("select qty,i_item_code from indent_order where i_indent_no='$_POST[indentkey]'" );
			while($del_qty_arr=mysql_fetch_array($del_qty_query)){
				mysql_query("update inventory set primary_stock=primary_stock +'$del_qty_arr[qty]' where s_item_code='$del_qty_arr[i_item_code]'");
				
			}
			mysql_query("delete from indent_order where i_indent_no='$_POST[indentkey]'") ;
			mysql_query("delete from indent where indent_no='$_POST[indentkey]'") ;
			

				
			
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
<title>Taaza Tarkari - View Indents</title>
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
        <div class="box color_25">
          <div class="title">
            <h4> <span>Indents table <small>(Sorted in descending order)</small> </span> </h4>
          </div>
          <!-- End .title -->
          
          <div class="content top">
           
           
            
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
              <thead>
                <tr>
                  <th class="">Indent #</th>
                  <th class="no_sort">Date</th>
                  <th class="">Shop Name</th>
                  <th class="">Invoiced</th>
                  <th class="no_sort">Notes</th>
                  <th class="ms no_sort">Actions</th>
                </tr>
              </thead>
              <tbody>
           <?php 
              	$view_in_result1=mysql_query("select price,indent_no,invoiced, i_client_id,date_format(i_date,'%D-%b-%Y') as i_date1, notes from indent where i_date>=DATE_SUB(CURDATE(),INTERVAL 7 DAY)");
              	while($view_in_arr=mysql_fetch_array($view_in_result1)){
              		
              		
                $client_id=$view_in_arr['i_client_id'];
                
              	
              	$shop_name1=mysql_query("select shop_name from client where c_id='$client_id'");
              	$shop_name_arr=mysql_fetch_assoc($shop_name1);
              	$shop_name=$shop_name_arr['shop_name'];	
              	
              	
              ?> 
                <tr>
                  <td class="to_hide_phone"><?php echo $view_in_arr['indent_no']; ?></td>
                  <td class=""><?php echo $view_in_arr['i_date1']; ?></td>
                  <td class=""><?php echo $shop_name ; ?></td>
                  <?php if ($view_in_arr['invoiced'] == 0){ ?>
                  		<td class="to_hide_phone"><strong> NO </strong></td>
                  <?php } else { ?>
                  		<td class="to_hide_phone"><strong> YES </strong></td>
                  <?php } ?>
                  <td class="to_hide_phone"><?php echo $view_in_arr['notes']; ?></td>
                  
              <?php if ($view_in_arr['invoiced'] == 0){ ?>
                  <td class="ms">
                  	<div class="btn-group"> 
                  		<a class="btn btn-small"  href="edit_indent.php?indent=active&in_indent=in&v_indent=active&gn_in_i_no=<?php echo $view_in_arr['indent_no'];?>&gen_c_name=<?php echo $shop_name ; ?>&gen_c_id=<?php echo $client_id ;?>" rel="tooltip" data-placement="top" data-original-title=" Edit Indent "><i class="gicon-edit"></i></a> 
                  		<!--  <a class="btn btn-small" rel="tooltip" data-placement="top" data-original-title="View"><i class="gicon-eye-open"></i></a> -->
                   		<a class="btn btn-small"  href="print_indent.php?cid=<?php echo $client_id ; ?>&price=<?php echo $view_in_arr['price']; ?>&indent_no=<?php echo $view_in_arr['indent_no']; ?>&date=<?php echo $view_in_arr['i_date1']; ?>" rel="tooltip" data-placement="top" data-original-title=" Print Indent"><i class="gicon-print"></i></a>
                   		<a data-toggle="modal" href="<?php echo "#myModal".$view_in_arr['indent_no']; ?>" class="btn  btn-small" rel="tooltip" data-placement="top" data-original-title="View Indent"><i class="gicon-eye-open"></i></a>
						<a class="btn  btn-small"  id="remrow" rel="tooltip" data-placement="top" data-original-title="Remove Indent" onclick="javascript:openDialog(<?php echo $view_in_arr['indent_no']; ?>);"><i class="gicon-remove "></i></a>
						 
                  	</div>
                  		
                  </td>
                  <?php } else { ?>
                       <td class="ms">
                  	<div class="btn-group"> 
                  		<a class="btn btn-small"  href="#" rel="tooltip" data-placement="top" data-original-title=" Cannot Edit Already Invoiced"><i class="gicon-edit"></i></a> 
                  		
                   		<a data-toggle="modal" href="<?php echo "#myModal".$view_in_arr['indent_no']; ?>" class="btn  btn-small" rel="tooltip" data-placement="top" data-original-title="View Indent"><i class="gicon-eye-open"></i></a>
						<a class="btn  btn-small"  id="remrow" rel="tooltip" data-placement="top" data-original-title="Cannot Remove Indent Altready Invoiced"><i class="gicon-remove "></i></a> 
                  	</div>
                  </td>
                  <?php } ?>
                  
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
		 	
		 	$pop_ind_result=mysql_query("select indent_no,i_client_id,date_format(i_date,'%D-%b-%Y') as i_date1, notes from indent where i_date>=DATE_SUB(CURDATE(),INTERVAL 7 DAY)");

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
                  	  		<td>Shop Name: <?php echo" ".$shop_name ; ?></td> 
                  	  		<td>Total Items=<?php echo $count;?> </td> 
                  	  		<td>Date:<?php echo " ".$pop_ind_arr['i_date1'];?></td>   
                  	  	</tr>
                  	  	</table>
                  	  	</h1>
                	  </div>
                	  <div class="modal-body">
                  		
                  			<table class="table table-condensed table-striped">
           					 <thead>
             				 	<tr>
                				<th> # </th>
                				<th> Item </th>
                				<th> Qty</th>
                				<th> # </th>
                				<th> Item </th>
                				<th> Qty</th>
              					</tr>
           					 </thead>
            				 <tbody>
            				 <?php 
            				 	
            				 	
            				 	
            				 	
            				 	$limit=0;
            				 	$rowcount=ceil($count/2);
            				 	for($i=0; $i<$rowcount; $i++){
            				 	$i_ord1=mysql_query("select ind.i_id,i.item,ind.qty from indent_order ind,item_master i where ind.i_item_code=i.item_code and i_indent_no=$indent_no limit $limit,2");
            				 	
            				 		
            				 	
            				 	
            				 ?>
              				  <tr>
              				  <?php while($i_ord_arr=mysql_fetch_array($i_ord1)){ ?>
                				<td> <?php echo $i_ord_arr['i_id']; ?> </td>
                				<td> <?php echo $i_ord_arr['item']; ?> </td>
                				<td> <?php echo $i_ord_arr['qty']; ?></td>
                				
                				<?php } $limit=$limit+2; ?>
              				</tr>
              				<?php } ?>
              			
        
            			</tbody>
          				</table>
                	  </div>
                	  <div class="modal-footer">
                  			<button class="btn" data-dismiss="modal">Close</button>
                  			
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
        "bStateSave": true,
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
