<!-- To Avoid resubmitting -->
<?php

    include 'db_config.php' ;
  		
	$conn=new createConnection();
	$conn->connect();
	$conn->selectdb();

	session_start();	
	

	if (  isset($_POST["Editbiller"])  || isset($_POST["billerkey"]) ||  isset($_POST["act"]) )
	{
		
	if ($_POST["formid"] == $_SESSION["formid"])
	{
		$_SESSION["formid"] = '';
		if (  isset($_POST["Editbiller"]))
			mysql_query("update biller set market_name='$_POST[E_market_name]',biller_name='$_POST[E_biller_name]', ph_num='$_POST[E_ph_no]', address='$_POST[E_ad_txt]',dues='$_POST[E_dues]'  where b_id='$_POST[b_id]' ") ;
			
		if (  isset($_POST["billerkey"]))
			
			mysql_query("update biller set status=0 where b_id='$_POST[billerkey]'");
		if (  isset($_POST["act"]))
			mysql_query("update biller set status=1 where b_id='$_POST[act]'");
		
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
<title>Taaza Tarkari - View Active Billers</title>
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
    
 <?php if (isset($_GET["ac_biller"])){ ?>
    
    <div id="main_container">
      <div class="row-fluid">
        <div class="box color_13">
          <div class="title">
            <h4> <span>Active Biller table <small>(Sorted in descending order)</small> </span> </h4>
          </div>
          <!-- End .title -->
          
          <div class="content top">
          <form id="del_form" action="Active_biller.php?purchase=active&ac_biller=active" method="post">
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
              <thead>
                <tr>
                  <th class="">Biller ID #</th>
                  <!--  <th class="">Biller Name</th> -->
                  <th class="">Market Name</th>
                <!--    <th class="">Phone Number</th> -->
                  <th class="">Join Date</th>
                  <th class="">Dues</th>
                  <th class="ms no_sort ">Actions</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              	$result=mysql_query("select dues,b_id,market_name,biller_name,ph_num,address,date_format(join_date, '%D-%b-%Y') as jdate from biller where status=1");
              	while ($biller_arr=mysql_fetch_array($result)){
              ?>
              
                <tr>
                  <td><?php echo $biller_arr['b_id'] ; ?></td>
                 <!--   <td><?php echo $biller_arr['biller_name'] ; ?></td> -->
                  <td class="to_hide_phone"><?php echo $biller_arr['market_name'] ; ?></td>
                 <!--   <td class="to_hide_phone"> <?php echo $biller_arr['ph_num'] ; ?> </td> -->
                  <td class="to_hide_phone"><?php echo $biller_arr['jdate'] ; ?></td>
                  <td class="to_hide_phone"><?php echo $biller_arr['dues'] ; ?></td>
                  <td class="ms">
                  	<div class="btn-group" id="<?php echo $biller_arr['b_id'] ;?>"> 
                  		<a class="btn btn-small" href="Edit_Biller.php?purchase=active&ac_biller=active&bid=<?php echo $biller_arr['b_id'] ;?>" rel="tooltip" data-placement="top" data-original-title=" Edit " ><i class="gicon-edit"></i></a> 		
						<a class="btn  btn-small" rel="tooltip" data-placement="top" data-original-title="Remove" onclick="javascript:openDialog(<?php echo $biller_arr['b_id'] ;?>);"><i class="gicon-remove"></i></a> 
						<input type="hidden" name="cremove" value="<?php echo $biller_arr['b_id'] ;?>" />
						
                  	</div>
                  </td>
                </tr>
                
                
                
                
                
                <?php } $conn->close();?>
           
               </tbody>
            </table>
            <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
            </form>
          </div>
          <!-- End .content --> 
        </div>
        <!-- End box --> 
      </div>
      <!-- End .row-fluid --> 
      
    </div>
    <?php } if(isset($_GET["dp_biller"])){ ?>
    	
    	
    	    <div id="main_container">
      <div class="row-fluid">
        <div class="box color_13">
          <div class="title">
            <h4> <span>In-Active Biller table <small>(Sorted in descending order)</small> </span> </h4>
          </div>
          <!-- End .title -->
          
          <div class="content top">
          <form id="del_form" action="Active_biller.php?purchase=active&dp_biller=active" method="post">
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
              <thead>
                <tr>
                  <th class="">Biller ID #</th>
                  <th class="">Market Name</th>
                  <th class="">Join Date</th>
                  <th class="">Dues</th>
                  <th class="ms no_sort ">Actions</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              	$result=mysql_query("select dues,b_id,market_name,biller_name,ph_num,address,date_format(join_date, '%D-%b-%Y') as jdate from biller where status=0");
              	while ($biller_arr=mysql_fetch_array($result)){
              ?>
              
                <tr>
                  <td><?php echo $biller_arr['b_id'] ; ?></td>
                  <td class="to_hide_phone"><?php echo $biller_arr['market_name'] ; ?></td>
                  <td class="to_hide_phone"><?php echo $biller_arr['jdate'] ; ?></td>
                  <td class="to_hide_phone"><?php echo $biller_arr['dues'] ; ?></td>
                  <td class="ms">
                  	<div class="btn-group" id="<?php echo $biller_arr['b_id'] ;?>"> 
                  		<a class="btn btn-small" href="Edit_Biller.php?purchase=active&dp_biller=active&bid=<?php echo $biller_arr['b_id'] ;?>" rel="tooltip" data-placement="top" data-original-title=" Edit " ><i class="gicon-edit"></i></a> 		
						 
						<button class="btn btn-success" rel="tooltip" type="submit" data-placement="top" data-original-title="Activate Client" >Activate</button>
						<input type="hidden" name="act" value="<?php echo $biller_arr['b_id'] ;?>" />
						
                  	</div>
                  </td>
                </tr>
                
                
                
                
                
                <?php } $conn->close();?>
           
               </tbody>
            </table>
            <input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
            </form>
          </div>
          <!-- End .content --> 
        </div>
        <!-- End box --> 
      </div>
      <!-- End .row-fluid --> 
      
    </div>
    	
    	
    <?php } ?>
    
    <!-- End #container --> 
  </div>
  
  
  <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                	  <form action="Active_Client.php?client=active&ac_client=active" method="post">
                	  <div class="modal-header">
                	  
                  	  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                  	  	<h1 id="myModalLabel">Edit Client  </h1>
                	  </div>
                	  <div class="modal-body">
                  			
                  			<table class="table table-condensed table-striped">
                  			
           					<tr>
            					<td class="to_hide_phone"> <input class="row-fluid span4" id="Textinput" autofocus="autofocus" name="item_txt" type="text" value="test">  </td>
            				</tr>
            				<tr>
            					<td> <p align="center"> <a href="List_Item.php?indent=active&in_indent=in&l_indent=active" ><button type="submit"  id="add" name="submit" class="btn btn-primary">Add</button></a> </p> </td>
            				</tr>
            				
          				</table>
          				<input type="hidden" name="formid" value="<?php echo $_SESSION["formid"]; ?>" />
                	  </div>
                	  <div class="modal-footer">
                  			<button class="btn" data-dismiss="modal">Close</button>
                  			
                	  </div>
                	  </form>
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
    <h3 id="myModalLabel">Confirm</h3>
  </div>
  <div class="modal-body">
    <p> Do you want to Delte the Client </p>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" onclick="javascript:formSubmit();">Delete</button>
    <button class="btn btn-primary" onclick="javascript:closeDialog();">Close</button>
  </div>
</div>
<div class="avgrund-cover"></div>

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
        global_client=value;
        Avgrund.show( "#default-popup" );
      }
      function closeDialog() {
        Avgrund.hide();
      }


      function formSubmit()
      {

      	//alert(global_client);


      		
      	var form = document.createElement("form");
          form.setAttribute("method", "POST");
          form.setAttribute("action", "Active_biller.php?purchase=active&ac_biller=active");
          var hiddenField = document.createElement("input");
          hiddenField.setAttribute("type", "hidden");
          hiddenField.setAttribute("name", "billerkey");
          hiddenField.setAttribute("value", global_client);
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
         "aaSorting": [[ 1, "asc" ]],
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