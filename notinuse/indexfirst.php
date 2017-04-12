<?php
include_once("simple_html_dom.php");

mysql_connect("localhost","root","");
mysql_select_db("websearchdb");

scraping_IMDB("https://www.axcontrol.com/search.php?search_term=is2");



function scraping_IMDB($url) {

	// extraction start
	
	$html = file_get_html($url);
	//echo $html;
	$base_url="https://www.axcontrol.com";
	foreach($html->find('div[id="content"]') as $content_data)
	{
		//echo $content_data;
		
		$i=0;
		/*
		INSERT INTO `tbl_parts` (`parts_id`, `parts_number`, `parts_desc`, `parts_image`, `parts_href`, `parts_status`, `scrapped_url`) VALUES
(1, 'IC300ADC020', '', '', 'https://www.axcontrol.com/automation/ge-fanuc-plc/ic300-ocs/IC300ADC020', 0, 'https://www.axcontrol.com/search.php?search_term=ic3'),
(2, 'IC300ADC110', '', '', 'https://www.axcontrol.com/automation/ge-fanuc-plc/ic300-ocs/IC300ADC110', 0, 'https://www.axcontrol.com/search.php?search_term=ic3')
		*/
		$query="INSERT INTO `tbl_parts` (`parts_number`,`parts_href`, `scrapped_url`) VALUES ";
		foreach($content_data->find('a') as $part_data)
		{

			$part_number = $part_data->plaintext;
			$part_href=$base_url.$part_data->href;
			if($i==0)
			{
				$query=$query." ('".$part_number."','".$part_href."','".$url."')";
			}
			else
			{
				$query=$query." ,('".$part_number."','".$part_href."','".$url."')";
			}
			$i++;
			//$query="insert into tbl_parts(parts_number,parts_href,scrapped_url) values('".$part_number."','".$part_href."','".$url."')";
		}
		echo $query;
		mysql_query($query);
	}
	 $html->clear();
     unset($html);
     echo "<h1>Done</h1>";
}

?>