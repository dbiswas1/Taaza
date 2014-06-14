<!-- To Avoid resubmitting -->
<?php

    include 'db_config.php' ;
  		
	$conn=new createConnection();
	$conn->connect();
	$conn->selectdb();

	session_start();	
	

	if (isset($_POST["item_txt"]) && (strlen($_POST["item_txt"]) > 0) )
	{
	if ($_POST["formid"] == $_SESSION["formid"])
	{
		$_SESSION["formid"] = '';
		mysql_query("insert into item_master(item ) values ('$_POST[item_txt]')") ;
		
		$item_code_1=mysql_query("select item_code from item_master where item='$_POST[item_txt]'");
		
		//var_dump($item_code_1);
		
		
		$insert_code=mysql_fetch_assoc($item_code_1);
		$item_pscode=$insert_code['item_code'];
		
			mysql_query("insert into inventory(s_item_code) values ($item_pscode)");
			mysql_query("insert into price_list(p_item_code) values ($item_pscode)");
			
		
		
		
		
		
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
<title>Taaza Tarkari- List Item</title>
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
        <form action="view_indent.html">
          <div class="box paint color_25">
            <div class="title">
              <h4> <i class="icon-book"></i><span>List Items </span> </h4>
            </div>
            
            
           
            
            <div class="content top ">
              <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
                <thead>
                
                  <tr>
                    <th class="no_sort"> Sl#</th>
                    <th class="no_sort"> Item </th>
                    <th class="no_sort"> Sl#</th>
                    <th class="no_sort"> Item </th>
                    <th class="no_sort"> Sl#</th>
                    <th class="no_sort"> Item </th>
				   </tr>
                </thead>
                
                
                
            	<tbody>
            	<?php  for ($i=0 ; $i<$row_count ; $i++){ 
                	$result = mysql_query("SELECT * from item_master limit $limit,3") or die(mysql_error());
                	
                ?>
                  <tr>
                  <?php 
                  	while($item_arr = mysql_fetch_array( $result ))
                  		{
                  ?>
                    <td><?php echo $item_arr['item_code'] ;?></td>
                    <td><?php echo $item_arr['item'] ;?></td>
                    
                   <?php }
                   $limit=$limit+3; ?>
                    
                  </tr>
                  <?php } $conn->close();?>
                  
                  </tbody>
              </table>
            
            
         

          
          
          
         
           
        </div>
        
        <!-- End Content -->
      
       
		       
                  
       <p align="center"> <a  data-toggle="modal" href="#myModal" ><button type="submit"  class="btn btn-primary">Add Item</button></a> </p>
        </div>
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

	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                	  <form action="List_Item.php?indent=active&in_indent=in&l_indent=active" method="post">
                	  <div class="modal-header">
                	  
                  	  	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                  	  	<h1 id="myModalLabel">Add New Item  </h1>
                	  </div>
                	  <div class="modal-body">
                  			
                  			<table class="table table-condensed table-striped">
                  			
           					<tr>
            					<td class="to_hide_phone"> <input class="row-fluid span4" id="Textinput" autofocus="autofocus" name="item_txt" type="text" >  </td>
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