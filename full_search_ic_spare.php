<h1>
<a href='full_search_ic_spare.php'>Next</a>
</h1>
<?php
include_once("simple_html_dom.php");

mysql_connect("localhost","root","");
mysql_select_db("websearchdb");


$parts_query="select * from tbl_parts_ic_spare where parts_status=0 order by parts_id asc limit 200";
//echo $parts_query;
$parts_res=mysql_query($parts_query);
while($parts_row=mysql_fetch_assoc($parts_res))
{
	extract($parts_row);
//	echo "<br>".$parts_href;
	scraping_IMDB($parts_href,$parts_id);
}

//scraping_IMDB("https://www.axcontrol.com/automation/ge-fanuc-plc/ic300-ocs/IC300ADC020",11);
function scraping_IMDB($url,$pid) {

	// extraction start
	
	$html = file_get_html($url);
	//echo $html;
	$desc="";
	$img_url="";
	$j=0;
	
	foreach($html->find('div[class="flex_column av_one_third  flex_column_div av-zero-column-padding first  avia-builder-el-1  el_before_av_one_third  avia-builder-el-first"]') as $img_data_full_div)
	{
		foreach($img_data_full_div->find('div[class="avia_textblock"]') as $img_data_div)
		{
			foreach($img_data_div->find('img') as $img_data)
			{
				$img_url=$img_data->src;
			}
		}
	}

	foreach($html->find('p[class="single-page-mk"]') as $desc_data)
	{
		$desc=$desc_data->plaintext;
	}
	
	$query="update tbl_parts_ic_spare set parts_desc='".$desc."',parts_image='".$img_url."',parts_status='1' 
	where parts_id='".$pid."'";
	echo "<h5>".$pid."</h5>";
	//echo $query;
	
	mysql_query($query);
	$html->clear();
    unset($html);
    
    
}
?>

