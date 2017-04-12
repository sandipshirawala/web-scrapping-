<?php 
/*
mysql_connect("localhost","root","");
mysql_select_db("websearchdb");

$query="select * from tbl_parts_world";
$resultset=mysql_query($query);
while($row=mysql_fetch_assoc($resultset))
{
	extract($row);
	echo "<br>".$parts_number;
	$new_parts_data=explode("&#8211;", $parts_number);
	if(count($new_parts_data)>=2)
	{

		$new_part_number=$new_parts_data[0];
		$power_supply=$new_parts_data[1];
		$upquery="update tbl_parts_world set parts_number='".$new_part_number."',power_supply='".$power_supply."' where parts_id='".$parts_id."'";
		mysql_query($upquery);
	}
}
*/
?>