-- Update the Invoice History table with Purcahse details
-- Change active client delete logic
-- Update table with purchase price(ADD column) detail in price_master

use taaza_tarkari;
select * from indent;
select * from indent_order ;
select * from price_list;
select * from inventory;

select it.item,ino.qty,pr.price1 from  indent_order ino, item_master it,price_list pr where it.item_code=i_item_code and it.item_code=pr.p_item_code and ino.i_indent_no=4;

select amount from invoice where in_c_id=4 order by in_date desc limit 1;
select * from invoice_history;
select * from invoice;
select * from client;
select * from price_list;

select inv.invoice_no,date_format(inv.in_date,'%b-%d-%Y') as in_date,c.shop_name,inv.amount,inv.dues from invoice inv, client c where inv.in_c_id=c.c_id;

select ih.in_h_invoice_no,ino.i_indent_no,ih.in_h_item_code,it.item,ino.qty,in_h_price from invoice_history ih, indent_order ino, item_master it where it.item_code=in_h_item_code and ih.in_h_item_code=ino.i_item_code and ih.in_h_indent_no=ino.i_indent_no and ih.in_h_invoice_no=1 ;

select * from client;


select ih.in_h_invoice_no,ino.i_indent_no,ih.in_h_item_code,it.item,ino.qty,in_h_price from invoice_history ih, indent_order ino, item_master it where it.item_code=in_h_item_code and ih.in_h_item_code=ino.i_item_code and ih.in_h_indent_no=ino.i_indent_no and ih.in_h_invoice_no=2;


select  it.item,ind.qty,ih.in_h_price from item_master it,invoice_history ih,indent_order ind where  ih.in_h_invoice_no=6 and ind.i_item_code=ih.in_h_item_code and ih.in_h_item_code=it.item_code and ind.i_indent_no=14 ;

select  count(*) as c from item_master it,invoice_history ih,indent_order ind where  ih.in_h_invoice_no=6 and ind.i_item_code=ih.in_h_item_code and ih.in_h_item_code=it.item_code and ind.i_indent_no=14 ;

select cl.shop_name from client cl, invoice iv where iv.in_c_id = cl.c_id and iv.invoice_no=5;


select sum(ino.qty*ih.in_h_price) as amt  from invoice_history ih, indent_order ino where ih.in_h_item_code=ino.i_item_code and ih.in_h_indent_no=ino.i_indent_no and ih.in_h_invoice_no=5;


select count(*) from invoice_history where in_h_invoice_no=6;



alter table price_list add purchase decimal(9,2) default 0 ;
alter table client drop column dues ;

alter table invoice  drop column dues ;

select * from payment_master;

select p.pay_id,c.shop_name,p.paid,date_format(p.date,'%m-%d-%Y') as pay_date,p.pay_v_no,p.dues from client c , payment_master p where c.c_id=p.pay_c_id ;
select * from biller;

select * from purchase_order;

delete from purchase_order where p_id=2;

select p_id, + 1 AS slno, b.market_name, sum(p.p_price) as amt, p.p_date from biller b , purchase_order p where p.p_b_id=b.b_id group by p.p_date, p.p_id ;

insert into purchase_order (p_b_id,pu_item_code, p_qty,p_price,p_date) values (1,1,4,40, STR_TO_DATE("10-21-2013", '%m-%d-%Y')) ;

select TRUNCATE(avg(p_price/p_qty),2) as avg_price from purchase_order where p_date = STR_TO_DATE('10-21-2013', '%m-%d-%Y') group by pu_item_code,p_date ;

select date_format(p_date,'%m-%d-%Y')as date from purchase_order where p_id=1;


select b.b_id, b.market_name, sum(p.p_price) as amt, date_format(p.p_date,'%m-%d-%Y') as pu_date,date_format(p.p_date,'%D-%b-%Y') as date from biller b , purchase_order p where p.p_b_id=b.b_id group by p.p_date, p.p_b_id ;

select p_qty from purchase_order where p_date=STR_TO_DATE('10-21-2013','%m-%d-%Y') and p_b_id=1 and pu_item_code=1 ;


insert into client(dues,shop_name,client_name,ph_num, address ) values (56,'w','w','rtr','s') ;

insert into client(dues,shop_name,client_name,ph_num, address ) values (0,'ff','rr','','') ;

select i.item,w.primary_stock from item_master i , inventory w where i.item_code=w.s_item_code;

select date_format(now(),'%b-%D-%Y'),count(*) as c from item_master;

select i.item,w.primary_stock from item_master i , inventory w where i.item_code=w.s_item_code limit 3,3;

select sum(p_price) as amt from purchase_order where p_b_id=2 and p_date=STR_TO_DATE('10-22-2013','%m-%d-%Y') group by p_date, p_b_id;


select sum(p_price) as amt from purchase_order where p_b_id=2 and p_date=STR_TO_DATE('10-22-2013','%m-%d-%Y') group by p_date, p_b_id;


select * from bill_payment_master;
select * from payment_master;

select b.b_id,p.bl_id,b.market_name,p.paid,date_format(p.date,'%m-%d-%Y') as pay_date,p.pay_b_no,p.dues from biller b , bill_payment_master p where b.b_id=p.bill_b_id

select p.bl_id,b.market_name,p.paid,date_format(p.date,'%m-%d-%Y') as pay_date,p.pay_b_no,p.dues from biller b , bill_payment_master p where p.bl_id=1 and p.bill_b_id=b.b_id;

insert into bill_payment_master (bill_b_id,paid,dues,date) values (1,0,(select dues from biller where b_id=1),now());


mysqlbackup --port=13000 --protocol=tcp --user=root --password=root --backup-dir=/home/admin/backups backup-and-apply-log ;

select pay_id,date, dues from payment_master where pay_c_id=3 and date <= DATE_SUB(STR_TO_DATE('oct-23-2013','%b-%d-%Y'),INTERVAL 1 DAY) order by pay_id desc limit 1;
select pay_id,date,paid from payment_master where pay_c_id=3 and date <= DATE_SUB(STR_TO_DATE('10-23-2013','%m-%d-%Y'),INTERVAL 1 DAY) and paid != 0 order by pay_id desc limit 1;

select pay_id,date_format('%b-%d-%Y',date) as date, dues from payment_master where pay_c_id=3 and date <= DATE_SUB(STR_TO_DATE('Oct-20-2013','%b-%d-%Y'),INTERVAL 1 DAY) order by pay_id desc limit 1;

select
pay_id,date_format('%b-%d-%Y',date) as date, paid from
payment_master where pay_c_id=3 and date <=
DATE_SUB(STR_TO_DATE('Oct-20-2013','%b-%d-%Y'),INTERVAL
1 DAY) and paid != 0 order by pay_id desc limit 1;


select pay_id,date_format('%b-%d-%Y',date) as
date, dues from payment_master where pay_c_id=3 and date
<= DATE_SUB(STR_TO_DATE('Oct-23-2013','%b-
%d-%Y'),INTERVAL 1 DAY) order by pay_id desc limit 1select
pay_id,date_format('%b-%d-%Y',date) as date, paid from
payment_master where pay_c_id=3 and date <=
DATE_SUB(STR_TO_DATE('Oct-23-2013','%b-%d-%Y'),INTERVAL
1 DAY) and paid != 0 order by pay_id desc limit 1