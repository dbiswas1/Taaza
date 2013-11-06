<div id="sidebar" class=" collapse1 in">
  <div class="scrollbar">
    <div class="track">
      <div class="thumb">
        <div class="end"></div>
      </div>
    </div>
  </div>
  <div class="viewport ">
     <div class="overview collapse">
      <div class="search row-fluid container">
        <h2>Search</h2>
        <form class="form-search">
          <div class="input-append">
            <input type="text" class=" search-query" placeholder="">
            <button class="btn_search color_4">Search</button>
          </div>
        </form>
      </div>

	
      <ul id="sidebar_menu" class="navbar nav nav-list container full">
        <li class="accordion-group color_4 "> <a class="dashboard " href="Add_Indent.php?indent=active&in_indent=in&a_indent=active"><img src="img/menu_icons/dashboard.png"><span>Dashboard</span></a> </li>
		
		
		<!-- Indent Column Start-->
		<?php if(isset($_GET['indent']) ) { ?>
			<li class="accordion-group color_25 active"> <a class="accordion-toggle widgets collapsed " data-toggle="collapse" data-parent="#sidebar_menu" 
			href="#collapse1"> <img src="img/menu_icons/forms.png"><span>Indent</span></a>
			<ul id="collapse1" class="accordion-body collapse in">
		<?php } else { ?>
			<li class="accordion-group color_25 "> <a class="accordion-toggle widgets collapsed " data-toggle="collapse" data-parent="#sidebar_menu" 
			href="#collapse1"> <img src="img/menu_icons/forms.png"><span>Indent</span></a>
			<ul id="collapse1" class="accordion-body collapse">

		 <?php } if (isset($_GET['a_indent']) ) { ?>
			<li class="active"><a href="Add_Indent.php?indent=active&in_indent=in&a_indent=active">Add Indent</a></li>
		 <?php } else { ?>
			<li><a href="Add_Indent.php?indent=active&in_indent=in&a_indent=active">Add Indent</a></li>
         
		 <?php } if (isset($_GET['v_indent']) ) { ?>
			<li class="active"><a href="view_indent.php?indent=active&in_indent=in&v_indent=active">View Indent</a></li>
		 <?php } else { ?>
			<li><a href="view_indent.php?indent=active&in_indent=in&v_indent=active">View Indent</a></li>
		  <?php } if (isset($_GET['l_indent']) ) { ?>
            <li class="active"><a href="List_Item.php?indent=active&in_indent=in&l_indent=active">List Items</a></li>
		  <?php } else { ?>
			<li><a href="List_Item.php?indent=active&in_indent=in&l_indent=active">List Items</a></li>
		  <?php } ?>
            <li><a href="#">Old Indents</a></li>
          </ul>
        </li>
		
		<!-- Indent Column END-->

		
		<!-- Invoice Column Start-->

		<?php if(isset($_GET['invoice']) ) { ?>
			<li class="accordion-group color_3 active"> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse2"> <img src="img/menu_icons/invoice.gif"><span>Invoivcing</span></a>
			<ul id="collapse2" class="accordion-body collapse in">
		<?php } else { ?>
			<li class="accordion-group color_3 "> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse2"> <img src="img/menu_icons/invoice.gif"><span>Invoivcing</span></a>
			<ul id="collapse2" class="accordion-body collapse">
		<?php } if (isset($_GET['g_invoice']) ) { ?>
            <li class="active"><a href="Generate_Invoice.php?invoice=active&in_invoice=in&g_invoice=active">Generate Invoice</a></li>
		<?php } else { ?>
			<li class><a href="Generate_Invoice.php?invoice=active&in_invoice=in&g_invoice=active">Generate Invoice</a></li>
		<?php } if (isset($_GET['v_invoice']) ) { ?>
            <li class="active"><a href="view_invoice.php?invoice=active&in_invoice=in&v_invoice=active">View Invoice</a></li>
		<?php } else { ?>
			<li><a href="view_invoice.php?invoice=active&in_invoice=in&v_invoice=active">View Invoice</a></li>
		<?php } if (isset($_GET['p_invoice']) ) { ?>
            <li class="active"><a href="#?invoice=active&in_invoice=in&p_invoice=active">Old Invoices</a></li>
		<?php } else { ?>
			<li><a href="#?invoice=active&in_invoice=in&p_invoice=active">Old Invoices</a></li>
		<?php } if (isset($_GET['s_invoice']) ) { ?>
			<li class="active"><a href="selling_price.php?invoice=active&in_invoice=in&s_invoice=active&tab1=pr1">Selling Price List</a></li>
		<?php } else { ?>
			<li><a href="selling_price.php?invoice=active&in_invoice=in&s_invoice=active&tab1=pr1">Selling Price List</a></li>
		<?php } ?>
            <li><a href="#">Place Holder</a></li>
          </ul>
        </li>
		<!-- Invoice Column End-->
		
		
		
      <!-- Purchase Menu Start -->
      
        <?php if(isset($_GET['purchase']) ) { ?>
        	<li class="accordion-group color_13 active"> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse3"> <img src="img/menu_icons/cart.png"><span>Purchase</span></a>
          <ul id="collapse3" class="accordion-body collapse in">
       <?php } else { ?> 
          <li class="accordion-group color_13 "> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse3"> <img src="img/menu_icons/cart.png"><span>Purchase</span></a>
          <ul id="collapse3" class="accordion-body collapse">
        <?php } if (isset($_GET['ad_biller']) ) { ?>
            <li class="active"><a href="Add_Biller.php?purchase=active&ad_biller=active">Add Biller</a></li>
         <?php } else {?>   
            <li><a href="Add_Biller.php?purchase=active&ad_biller=active"">Add Biller</a></li>
          <?php } if (isset($_GET['ac_biller']) ) {?>
            <li class="active"><a href="Active_biller.php?purchase=active&ac_biller=active">Active Biller</a></li>
            <?php } else {?>
            <li><a href="Active_biller.php?purchase=active&ac_biller=active">Active Biller</a></li>
            <?php } if (isset($_GET['dp_biller']) ) { ?>
            	<li class="active"><a href="Active_biller.php?purchase=active&dp_biller=active">Depricated Biller</a></li>
            <?php } else {?>
            	<li><a href="Active_biller.php?purchase=active&dp_biller=active">Depricated Biller</a></li>
            <?php } if (isset($_GET['ad_purchase']) ) { ?>
            <li class="active"><a href="Add_Purchase.php?purchase=active&ad_purchase=active">Add Purchase Items</a></li>
            <?php } else {?>
            <li><a href="Add_Purchase.php?purchase=active&ad_purchase=active">Add Purchase Items</a></li>
            <?php } if (isset($_GET['v_purchase']) ) {?>
            <li class="active"><a href="view_purchase.php?purchase=active&in_purchase=in&v_purchase=active">View Purchases</a></li>
            <?php } else {?>
            <li><a href="view_purchase.php?purchase=active&in_purchase=in&v_purchase=active">View Purchases</a></li>
            <?php } if (isset($_GET['b_purchase']) ) {?>
            <li class="active"><a href="bill_payment.php?purchase=active&in_purchase=in&b_purchase=active">Make Payment</a></li>
            <?php } else {?>
            <li><a href="bill_payment.php?purchase=active&in_purchase=in&b_purchase=active">Make Payment</a></li>
            <?php } if (isset($_GET['vp_purchase']) ) {?>
            <li class="active"><a href="view_bill_payment.php?purchase=active&in_purchase=in&vp_purchase=active">View Payment</a></li>
            <?php } else {?>
            <li><a href="view_bill_payment.php?purchase=active&in_purchase=in&vp_purchase=active">View Payment</a></li>
            <?php } ?>
          </ul>
         </li>
         
            <!-- Purchase Menu End -->
      
       <!-- Inventory Menu -->
      <?php if(isset($_GET['stock']) ) { ?>
         <li class="accordion-group color_8 active" > <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse4"> <img src="img/menu_icons/inventory.png"><span>Inventory</span></a>
          <ul id="collapse4" class="accordion-body collapse in">
       <?php } else { ?>
       	    <li class="accordion-group color_8"> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse4"> <img src="img/menu_icons/inventory.png"><span>Inventory</span></a>
          	<ul id="collapse4" class="accordion-body collapse">
        <?php } if (isset($_GET['p_stock']) ) { ?>
            <li class="active"><a href="Stock_List.php?stock=active&p_stock=active">Primary Stock</a></li>
        <?php } else { ?>
        	<li><a href="Stock_List.php?stock=active&p_stock=active">Primary Stock</a></li>
        <?php } if (isset($_GET['s_stock']) ) { ?>
            <li class="active"><a href="Stock_List.php?stock=active&s_stock=active">Secondary Stock</a></li>
        <?php } else { ?>
        	<li><a href="Stock_List.php?stock=active&s_stock=active">Secondary Stock</a></li>
         <?php } if (isset($_GET['w_stock']) ) { ?>
            <li class="active"><a href="Stock_List.php?stock=active&w_stock=active">Wastage List</a></li>
         <?php } else { ?>
         	 <li><a href="Stock_List.php?stock=active&w_stock=active">Wastage List</a></li>
         <?php }if (isset($_GET['ps_stock']) ) { ?>
         
            <li><a href="Stock_Purchase_List.php?stock=active&ps_stock=active">Stock to Purchase</a></li>
         <?php } else { ?> 
            <li><a href="Stock_Purchase_List.php?stock=active&ps_stock=active">Stock to Purchase</a></li>
           <?php } ?>
   		  </ul>
         </li>
         
         <!-- Client Menu -->
        
        <?php if(isset($_GET['client']) ) { ?>
        <li class="accordion-group color_24 active"> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse5"> <img src="img/menu_icons/users.png"><span>Clients</span></a>
          <ul id="collapse5" class="accordion-body collapse in">
        <?php } else { ?>
           <li class="accordion-group color_24"> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse5"> <img src="img/menu_icons/users.png"><span>Clients</span></a>
          <ul id="collapse5" class="accordion-body collapse">
         <?php } if (isset($_GET['ad_client']) ) { ?>
            <li class="active"><a href="Add_Client.php?client=active&ad_client=active">Add Clients</a></li>
          <?php } else { ?>
            <li><a href="Add_Client.php?client=active&ad_client=active">Add Clients</a></li>
          <?php } if (isset($_GET['ac_client']) ) { ?>
            <li class="active"><a href="Active_Client.php?client=active&ac_client=active">Active Clients</a></li>
           <?php } else { ?>
           	<li><a href="Active_Client.php?client=active&ac_client=active">Active Clients</a></li>
           	<?php } if (isset($_GET['dp_client']) ) { ?>
            <li class="active"><a href="Active_Client.php?client=active&dp_client=active">Depricated Clients</a></li>
            <?php } else { ?>
            <li><a href="Active_Client.php?client=active&dp_client=active">Depricated Clients</a></li>
            <?php } if (isset($_GET['pay_client']) ) {?>
            <li class="active"><a href="Payment.php?client=active&pay_client=active">Make Payments</a></li>
            <?php }else{ ?>
            <li><a href="Payment.php?client=active&pay_client=active">Make Payments</a></li>
            <?php } if (isset($_GET['v_pay_client']) ) {?>
            <li class="active"><a href="View_Payment.php?client=active&v_pay_client=active">View Payments</a></li>
            <?php }else{ ?>
            <li><a href="View_Payment.php?client=active&v_pay_client=active">View Payments</a></li>
            <?php }?>
            
            
          </ul>
        </li>
        
          <?php if(isset($_GET['expense']) ) { ?>
            <li class="accordion-group color_5 active" > <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse7"> <img src="img/menu_icons/rupee.png"><span>Expense</span></a>
          	<ul id="collapse7" class="accordion-body collapse in">
          <?php }else {?>
          	<li class="accordion-group color_5" > <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse7"> <img src="img/menu_icons/rupee.png"><span>Expense</span></a>
          	<ul id="collapse7" class="accordion-body collapse ">
          <?php } if (isset($_GET['a_expense'])) {?>
            <li class="active"><a href="Expense.php?expense=active&a_expense=active">Add Expense</a></li>
            <?php }else {?>
            <li><a href="Expense.php?expense=active&a_expense=active">Add Expense</a></li>
            <?php }if (isset($_GET['v_expense'])) {?>
            <li class="active"><a href="View_Expense.php?expense=active&v_expense=active">View Expense</a></li>
            <?php } else { ?>
            <li><a href="View_Expense.php?expense=active&v_expense=active">View Expense</a></li>
            <?php } ?>
            <li><a href="#">Detailed View</a></li>
            <li><a href="#">Register Employee</a></li>
            <li><a href="#">View Employee</a></li>
            
            
          </ul>
        </li>
        
        <li class="accordion-group color_19"> <a class="accordion-toggle widgets collapsed" data-toggle="collapse" data-parent="#sidebar_menu" href="#collapse6"> <img src="img/menu_icons/statistics.png"><span>Reports</span></a>
          <ul id="collapse6" class="accordion-body collapse">
            <li><a href="#">Place Holder</a></li>
            <li><a href="#">Place Holder</a></li>
          </ul>
        </li>
      
        
        <li class="color_13"> <a class="widgets" href="#"> <img src="img/menu_icons/calendar.png"><span>Calendar</span></a> </li>
        

      </ul>
      <div class="menu_states row-fluid container ">
        <h2 class="pull-left">Menu Settings</h2>
        <div class="options pull-right">
          <button id="menu_state_1" class="color_4" rel="tooltip" data-state ="sidebar_icons" data-placement="top" data-original-title="Icon Menu">1</button>
          <button id="menu_state_2" class="color_4 active" rel="tooltip" data-state ="sidebar_default" data-placement="top" data-original-title="Fixed Menu">2</button>
          <button id="menu_state_3" class="color_4" rel="tooltip" data-placement="top" data-state ="sidebar_hover" data-original-title="Floating on Hover Menu">3</button>
        </div>
      </div>
      
     