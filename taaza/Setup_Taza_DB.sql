
-- Set up DB
drop database taaza_tarkari;
create database taaza_tarkari ;
use taaza_tarkari ;

-- Drop all Tables
drop table expense;
drop table expense_type;
drop table employee;
drop table wastage_history;
drop table purchase_order;
drop table biller;
drop table payment_master;
drop table invoice_history;
drop table invoice;
drop table indent_order;
drop table indent;
drop table price_list;
drop table inventory ;
drop table client;
drop table item_master;
drop table sc_inventory_history;
drop event  stock_history_event;
drop table sc_price_list_history;
drop event price_history_event;


-- Create Item Table
create table item_master (item_code int not null auto_increment , item varchar(100) , primary key(item_code));


-- Create Client Table
create table client (c_id int Not Null auto_increment , shop_name varchar(100), client_name varchar(100), 
ph_num varchar(100), address varchar(100), status tinyint(1) not null default 1, join_date DATETIME NOT NULL DEFAULT now(),dues double(11,2) default 0 not null,
 PRIMARY KEY (c_id));


-- Create Inventory Table
create table inventory	(
s_id int not null auto_increment, s_item_code int ,primary_stock decimal(9,2) default 0, secondary_stock decimal(9,2) default 0,  waste_stock decimal(9,2) default 0, primary key(s_id), 
foreign key(s_item_code) references item_master(item_code) ON DELETE CASCADE) ;


-- Create Price List Table
create table price_list	(
p_id int not null auto_increment, p_item_code int , price1 decimal(9,2) default 0, price2 decimal(9,2) default 0,  secondary decimal(9,2) default 0, purchase decimal(9,2) default 0,
primary key(p_id), foreign key(p_item_code) references item_master(item_code) ON DELETE CASCADE) ;


-- Create Indent Table summary
create table indent (indent_no int unsigned not null auto_increment, i_client_id int not null, 
price tinyint(1) not null default 0, invoiced tinyint(1) not null default 0, i_date DATETIME NOT NULL,notes varchar(100),
primary key (indent_no), foreign key(i_client_id) references client(c_id) on delete cascade); 



-- Create Indent_order Table to track indent Deatils
create table indent_order (i_id int unsigned not null auto_increment, i_indent_no int unsigned  
	not null, i_item_code int, 
	qty double(6,2), date datetime, primary key(i_id), foreign key(i_indent_no) references indent(indent_no) 
    on delete cascade , foreign key(i_item_code) 
	references item_master(item_code) ON DELETE CASCADE  );


-- Create Invoice Summary table
create table invoice ( invoice_no int unsigned not null auto_increment, in_c_id int Not Null,in_indent_no int unsigned not null, amount double(11,2) not null default 0, 
in_date DATETIME NOT NULL, pay_date DATETIME NOT NULL default now(),
primary key(invoice_no), foreign key(in_indent_no) references indent(indent_no), foreign key(in_c_id) references client(c_id) ON DELETE CASCADE);


-- Create Invoice History For Invoice details
create table invoice_history(in_h_invoice_no int unsigned not null, in_h_item_code int not null , in_h_indent_no int unsigned not null,in_h_price decimal(9,2), in_date DATETIME NOT NULL,
foreign key(in_h_item_code) references item_master(item_code), foreign key(in_h_invoice_no) references invoice(invoice_no),
foreign key(in_h_indent_no) references indent(indent_no) on delete cascade);


-- Create a Payment Table
create table payment_master (pay_id int unsigned not null auto_increment, pay_c_id int not null, paid double(11,2) default 0, dues double(11,2) default 0,date datetime not null,
pay_v_no int unsigned default 0 , new_dues double(11,2) default 0,invoice_no  int(255) unsigned not null default 0, primary key(pay_id), foreign key(pay_c_id) references client(c_id) on delete cascade);



-- Create Purchase tables

create table biller (b_id int Not Null auto_increment , market_name varchar(100), biller_name varchar(100), dues double(11,2) default 0,
ph_num varchar(100), address varchar(100), status tinyint(1) not null default 1, join_date DATETIME NOT NULL DEFAULT now(),
 PRIMARY KEY (b_id));



Create table purchase_order (p_id int unsigned not null auto_increment, p_qty double(11,2) default 0, p_price double(11,2) default 0,
pu_item_code int not null, p_b_id int  not null, p_date datetime not null, primary key(p_id) , foreign key (pu_item_code) references item_master(item_code) ,
 foreign key(p_b_id) references biller(b_id) on delete cascade
);

create table bill_payment_master (bl_id int unsigned not null auto_increment, bill_b_id int not null, paid double(11,2) default 0, dues double(11,2) default 0,date datetime not null,
pay_b_no int unsigned default 0, primary key(bl_id), foreign key(bill_b_id) references biller(b_id) on delete cascade);

-- Wastage History
create table wastage_history (w_id int unsigned not null auto_increment,w_item_code int not null, qty double (9,2), price double(10,2),date datetime default now(), primary key(w_id),  
foreign key(w_item_code) references item_master(item_code) on delete cascade );

-- Expense table

create table expense_type (ex_id int(11) unsigned not null auto_increment, ex_type varchar(200), primary key(ex_id));

create table employee (emp_id int(10) unsigned not null auto_increment, emp_name varchar(50), emp_due double(10,2) default 0, emp_salary double(10,2) default 0,
primary key(emp_id) );

create table expense (exp_id int(15) unsigned not null auto_increment, exp_ex_id int(11) unsigned not null, exp_emp_id int(10) unsigned not null ,
rec_no int(15) unsigned, exp_date datetime, ex_amount double(10,2), primary key(exp_id), foreign key(exp_ex_id) references expense_type(ex_id),
foreign key(exp_emp_id) references employee(emp_id) on delete cascade);


-- Create a Scheduler Table for Stock

create table sc_inventory_history	(
 s_item_code int ,primary_stock decimal(9,2) default 0, secondary_stock decimal(9,2) default 0,  waste_stock decimal(9,2) default 0, 
date datetime) ;



CREATE 
	EVENT stock_history_event ON SCHEDULE EVERY 1 DAY STARTS '2013-11-14 17:00:00'

DO
	insert into sc_inventory_history (select s_item_code,primary_stock,secondary_stock,waste_stock,now() from inventory);


-- Create a scheduler Table for Price

create table sc_price_list_history	(
 p_item_code int , price1 decimal(9,2) default 0, price2 decimal(9,2) default 0,  secondary decimal(9,2) default 0, purchase decimal(9,2) default 0,
date datetime ) ;

CREATE 
	EVENT price_history_event ON SCHEDULE EVERY 1 DAY STARTS '2013-11-14 17:00:00'

DO
	insert into sc_price_list_history (select p_item_code,price1,price2,secondary,purchase,now() from price_list);
