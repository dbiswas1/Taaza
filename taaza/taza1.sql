create database taaza_tarkari ;

-- This is for List Items Page and Master Item
use taaza_tarkari ;

drop table item_master;

create table item_master (item_code int not null auto_increment , item varchar(100) , primary key(item_code));

insert into item_master(item ) values ('Aaure Kai'),('Ash Gourd'),('Baby corn'),('Banana Flower'),('Banana Stem'),
('Banana-Raw'),('Beans -  COUNTRY'),('Beans - Cluster'),('Beans - Field (Gorikai)'),('Beans - French'),
('Beans -Haricut'),('Beans Anupam'),('Beans-Snake') , ('Beans Ripen'),('Beetroot'),('Bhendi Small'),('Bhendi Big'),('Bitter gourd'),('Bitter gourd White');



Bottle gourd small
Bottle gourd Big
Brinjal - Bell
Brinjal - Gr Round
Brinjal long
Brinjal Long Purp
Brinjal Purp

Select * from item_master ;

select item_code from item_master where item="Beetroot";


-- This is for Add Client Page and Master Item
drop table client;

create table client (c_id int Not Null auto_increment , shop_name varchar(100), client_name varchar(100), 
ph_num varchar(100), address varchar(100), status tinyint(1) not null default 1, join_date DATETIME NOT NULL DEFAULT now(),
 PRIMARY KEY (c_id));

ALTER TABLE client 
  ADD COLUMN join_date DATETIME NOT NULL DEFAULT now() AFTER status ;

select c_id,shop_name,client_name,ph_num,address,date_format(join_date, '%D-%b-%Y')as jdate from client where status=1;

select * from client ;

-- To create a inventory table
drop table inventory ;

create table inventory	(
s_id int not null auto_increment, s_item_code int ,primary_stock decimal(9,2) default 0, secondary_stock decimal(9,2) default 0,  waste_stock decimal(9,2) default 0, primary key(s_id), 
foreign key(s_item_code) references item_master(item_code) ON DELETE CASCADE) ;

insert into inventory(s_item_code)  select item_code from item_master;

select * from inventory ;
select s_item_code from inventory;

update inventory set primary_stock=primary_stock-(-6) where s_item_code=2;



select s.s_id ,i.item, s.primary_stock  from inventory s, item_master i where s.s_item_code=i.item_code ;  

select s.s_id ,i.item, s.secondary_stock  from inventory s, item_master i where s.s_item_code=i.item_code ;  

select s.s_id ,i.item, s.waste_stock  from inventory s, item_master i where s.s_item_code=i.item_code ;  


-- To create a price table

drop table price_list;

create table price_list	(
p_id int not null auto_increment, p_item_code int , price1 decimal(9,2) default 0, price2 decimal(9,2) default 0, purchase decimal(9,2) default 0 ,secondary decimal(9,2) default 0, primary key(p_id), 
foreign key(p_item_code) references item_master(item_code) ON DELETE CASCADE) ;

drop table price_list;

insert into price_list(p_item_code)  select item_code from item_master;

select p.p_id,i.item,p.price1 from item_master i, price_list p where i.item_code=p.p_item_code limit 0,3 ;
select count(*) as c from price_list p, item_master i where i.item_code=p.p_item_code


select p_item_code from price_list ;

-- Indent table
drop table indent;
create table indent (indent_no int unsigned not null auto_increment, i_client_id int not null, 
price tinyint(1) not null default 0, invoiced tinyint(1) not null default 0, i_date DATETIME NOT NULL,notes varchar(100),
primary key (indent_no), foreign key(i_client_id) references client(c_id) on delete cascade); 

drop table indent_order;
create table indent_order (i_id int unsigned not null auto_increment, i_indent_no int unsigned  
	not null, i_item_code int, 
	qty double(6,2), primary key(i_id), foreign key(i_indent_no) references indent(indent_no) 
    on delete cascade , foreign key(i_item_code) 
	references item_master(item_code) ON DELETE CASCADE  );

select * from indent ;
select qty from indent_order where i_indent_no=4 ;



update indent set invoiced=0 where indent_no=4;

update indent_order set qty='4' where i_indent_no='4' and i_item_code='25';

select count(*)as c from indent_order where i_indent_no=4 and i_item_code=50;

select * from indent_order;

select * from indent_order where i_item_code=55;

select ind.i_id,i.item,ind.qty from indent_order ind,item_master i where ind.i_item_code=i.item_code and i_indent_no=4 limit 0,2;


select qty from indent_order where i_indent_no=4 and i_item_code=55;


-- Invoice table

drop table invoice;

create table invoice ( invoice_no int unsigned not null auto_increment, in_c_id int Not Null,in_indent_no int unsigned not null, amount double(11,2) not null default 0, 
price tinyint(1) default 0, paid double(11,2) not null default 0, dues double(11,2) not null default 0, status tinyint(1) default 0 ,in_date DATETIME NOT NULL, pay_date DATETIME NOT NULL default now(),
primary key(invoice_no), foreign key(in_indent_no) references indent(indent_no), foreign key(in_c_id) references client(c_id) ON DELETE CASCADE);


select * from invoice;

select * from indent;

select in_indent_no from invoice where invoice_no='4';

update indent set invoiced=0 where indent_no=4;
delete from invoice_history where in_h_indent_no=4;
delete from invoice where invoice_no=5;

select invoice_no from invoice where in_indent_no=4;

drop table invoice_history;


create table invoice_history(in_h_invoice_no int unsigned not null, in_h_item_code int not null , in_h_indent_no int unsigned not null,in_h_price decimal(9,2), in_date DATETIME NOT NULL,
foreign key(in_h_item_code) references item_master(item_code), foreign key(in_h_invoice_no) references invoice(invoice_no),
foreign key(in_h_indent_no) references indent(indent_no) on delete cascade);

select * from invoice_history;

select i.indent_no, c.shop_name,date_format(i.i_date,'%b-%h-%Y') as d,i.price from indent i , client c where i.i_client_id=ino.ic.c_id and i.invoiced=0;

select * from indent_order;

-- This is the query to update the amount
select ino.i_indent_no,ih.in_h_item_code,ino.qty,in_h_price from invoice_history ih, indent_order ino where ih.in_h_item_code=ino.i_item_code and ih.in_h_indent_no=ino.i_indent_no and ino.i_indent_no=4;

select sum(ino.qty*ih.in_h_price) as amt  from invoice_history ih, indent_order ino where ih.in_h_item_code=ino.i_item_code and ih.in_h_indent_no=ino.i_indent_no and ino.i_indent_no=4;

-- Create payment History

create table payments_history (pay_id int unsigned not null auto_increment, pay_cl_id int Not Null, paid double (12,2) default 0, date datetime not null);

-- Create Purcahse Master

create table purchase_master (purchase_id  int unsigned not null auto_increment, name varchar(50), address varchar(100), ph int unsigned not null, join_date datetime, primary key(purchase_id));

create table purchase_summary (p_pid int unsigned not null, amount double(10,2) default 0, paid double(10,2),
paid_date datetime not null, p_date datetime not null, foreign key(p_pid) references purchase_master(purchase_id) on delete cascade); 

create table purchase_history(p_h_pid int unsigned not null,p_h_qty double(8,2) not null,p_h_item_code int not null,p_h_price double (10,2),
p_date datetime not null, foreign key(p_h_pid) references purchase_master(purchase_id),foreign key(p_h_item_code) 
references item_master(item_code) on delete cascade);


-- Create Purchase table

create table biller (b_id int Not Null auto_increment , market_name varchar(100), biller_name varchar(100), dues double(11,2) default 0,
ph_num varchar(100), address varchar(100), status tinyint(1) not null default 1, join_date DATETIME NOT NULL DEFAULT now(),
 PRIMARY KEY (b_id));

Create table purchase_order (p_id int unsigned not null auto_increment, p_qty double(11,2) default 0, p_price double(11,2) default 0,
pu_item_code int not null, p_b_id int  not null, p_date datetime not null, primary key(p_id) , foreign key (pu_item_code) references item_master(item_code) ,
 foreign key(p_b_id) references biller(b_id) on delete cascade
);


-- Create a Payment Master


create table payment_master (pay_id int unsigned not null auto_increment, pay_c_id int not null, paid double(11,2) default 0, date datetime not null,
pay_v_no int unsigned , primary key(pay_id), foreign key(pay_c_id) references client(c_id) on delete cascade);


create table bill_payment_master (bl_id int unsigned not null auto_increment, bill_b_id int not null, paid double(11,2) default 0, dues double(11,2) default 0,date datetime not null,
pay_b_no int unsigned , primary key(bl_id), foreign key(bill_b_id) references biller(b_id) on delete cascade);

select p_date,p_b_id,pu_item_code,TRUNCATE(avg(p_price/p_qty),2) as avg_price from purchase_order where p_date = STR_TO_DATE('10-21-2013','%m-%d-%Y') and pu_item_code=8 group by pu_item_code,p_date;
select * from purchase_order where p_date = STR_TO_DATE('10-21-2013','%m-%d-%Y') and p_b_id=1;

select i.item,p.p_qty,p.p_price from item_master i , purchase_order p where p.pu_item_code=i.item_code and p.p_date = STR_TO_DATE('10-21-2013','%m-%d-%Y') and p.p_b_id=1; 


-- Wastage History
create table wastage_history (w_id int unsigned not null auto_increment,w_item_code int not null, qty double (9,2), date datetime default now(), primary key(w_id),  
foreign key(w_item_code) references item_master(item_code) on delete cascade );



select * from wastage_history;


-- Expense Related

create table employee (eid int unsigned not null auto_increment, e_name varchar(100), joining_date  datetime not null , primary key(eid) );

create table expense_list(ex_id int unsigned not null auto_increment, ex_type varchar(100), primary key(ex_id));

create table expense (ep_id int unsigned not null auto_increment, notes varchar(200),ep_eid int unsigned not null,ep_ex_id int unsigned not null, amt double(11,2) default 0, 
ep_date datetime not null default now(),primary key(ep_id), foreign key(ep_eid) references employee(eid), foreign key(ep_ex_id) references expense_list(ex_id) 
on delete cascade);

desc payment_master;

alter table payment_master add column (new_dues double(11,2) default 0,invoice_no  int(255) unsigned not null default 0);

select * from payment_master order by pay_id desc;

select * from indent_order;

select * from item_master ;

select * from invoice_history where date_format(in_date,'%d-%m-%Y')='25-11-2013';

select im.item,sum(io.qty)as qty from item_master im,indent_order io , invoice_history ih where im.item_code=io.i_item_code and ih.in_h_item_code=io.i_item_code and io.i_indent_no=ih.in_h_indent_no and  date_format(ih.in_date,'%d-%m-%Y')='10-11-2013'  group by io.i_item_code;


alter table indent_order add column date datetime;





