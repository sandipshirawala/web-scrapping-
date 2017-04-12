<h1>
<a href='full_search.php'>Next</a>
</h1>

<?php
include_once("simple_html_dom.php");

mysql_connect("localhost","root","");
mysql_select_db("websearchdb");


$parts_query="select * from tbl_parts_world where parts_status=0 order by parts_id asc limit 200";
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
	foreach($html->find('div[class="items_group"]') as $content_data)
	{
		//echo $content_data;

		foreach($content_data->find('img[class="scale-with-grid"]') as $img_data)
		{
			//echo $img_data;
			$img_url=$img_data->src;
		}

		foreach($content_data->find('div[class="column_attr"]') as $desc_data)
		{
			$desc=$desc_data->plaintext;
		}
		
		/*foreach($content_data->find('span[itemprop="description"]') as $full_data)
		{
			$desc = $full_data->plaintext;
		}	

		foreach($content_data->find('img[class="main_img"]') as $img_data)
		{
			if($j==0)
			{
				$img_url=$base_url.$img_data->src;
			}
			else
			{
				$img_url=$img_url.",".$base_url.$img_data->src;
			}
			$j++;
		}

		*/
		
	}
	
	$query="update tbl_parts_world set parts_desc='".$desc."',parts_image='".$img_url."',parts_status='1' 
	where parts_id='".$pid."'";
	//echo $query;
	//echo $query;
	echo "<h5>".$pid."</h5>";
	
	mysql_query($query);
	$html->clear();
    unset($html);
    //echo "<h5>".$pid."</h5>";
    //echo $query;
    //echo "<h1>Done</h1>";
}
?>

