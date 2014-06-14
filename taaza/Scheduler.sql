show processlist;
show events;
show tables;

select * from sc_price_list_history;
select * from  sc_inventory_history;


select sum(i.primary_stock*p.purchase) from sc_price_list_history p, sc_inventory_history i where date_format(i.date,'%m-%d-%Y')=date_format(p.date,'%m-%d-%Y') and p.p_item_code=i.s_item_code and date_format(i.date,'%m-%d-%Y')='11-13-2013' and primary_stock > 0 ;



select * from purchase_order where date_format(p_date,'%m-%d-%Y')='11-15-2013';

select * from bill_payment_master;

select * from biller;
select bill_b_id,paid,dues,date from bill_payment_master where bill_b_id=3 and date_format(date,'%m-%d-%Y')='11-17-2013' order by bl_id desc ;
select bl_id,bill_b_id,paid,dues,date from bill_payment_master where bill_b_id=3 and date_format(date,'%m-%d-%Y')<='11-17-2013' order by date desc ;

insert into bill_payment_master (bill_b_id,paid,dues,date) values ('3',0,(select dues from biller where b_id='3' ),now());