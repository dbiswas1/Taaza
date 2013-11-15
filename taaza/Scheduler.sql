show processlist;
show events;
show tables;

select * from sc_price_list_history;
select * from  sc_inventory_history;


select sum(i.primary_stock*p.purchase) from sc_price_list_history p, sc_inventory_history i where date_format(i.date,'%m-%d-%Y')=date_format(p.date,'%m-%d-%Y') and p.p_item_code=i.s_item_code and date_format(i.date,'%m-%d-%Y')='11-13-2013' and primary_stock > 0 ;