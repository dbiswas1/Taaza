<?php
// Create connection
/*$dbhost = 'localhost';
$dbuser = 'root';
$dbpasswd = 'root';
$con=mysql_connect("localhost","root","root");
mysql_select_db('taaza_tarkari') or die(mysql_error()); 

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


 
$count1 = mysql_query('select count(*) as c from item_master');
$count2 = mysql_fetch_assoc($count1);
$count=$count2['c'];

echo $count;
$row_count=ceil($count/3);


$limit=0;
 Print "<table border cellpadding=3>"; 
 for ($i=0 ; $i<$row_count ; $i++){
 $result = mysql_query("SELECT * from item_master limit $limit,3") or die(mysql_error());
 
 while($info = mysql_fetch_array( $result )) 
 { 
 
 Print " <td>".$info['item_code'] . "</td> "; 
 Print " <td>".$info['item'] . "</td> "; 
 }
 $limit=$limit+3;
 Print "<tr>"; 
 }
 Print "</table>"; 

	mysql_close($con); */


include ('db_config.php');
$connection = new createConnection();
$connection->connect();
$connection->selectdb();
//$connection->close();

$invoice_report=mysql_query("select ih.in_h_invoice_no,ino.i_indent_no,ih.in_h_item_code,it.item,ino.qty,in_h_price from invoice_history ih, indent_order ino, item_master it where it.item_code=in_h_item_code and ih.in_h_item_code=ino.i_item_code and ih.in_h_indent_no=ino.i_indent_no and ih.in_h_invoice_no='$_GET[invoice_no]'");
var_dump($invoice_report);



?> 