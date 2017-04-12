<?php
include_once("simple_html_dom.php");

mysql_connect("localhost","root","");
mysql_select_db("websearchdb");

//for($cnt=0;$cnt<=190;$cnt++)
for($cnt=0;$cnt<=54;$cnt++)
{
	scraping_IMDB("http://360turbine.com/parts?field_turbine_system_target_id=All&field_part_manufacturer_tid=All&title=is2&page=".$cnt);
}
//	scraping_IMDB("http://gasturbinecontrols.com/component/search/?searchword=is2&ordering=newest&searchphrase=all");




function scraping_IMDB($url) {

	// extraction start
	
	$html = file_get_html($url);
	$i=0;
	$base_url="http://360turbine.com";
	$part_number="";
	$part_href="";
	$part_desc="";
	$part_img="";

		$query="INSERT INTO `tbl_parts_360` (`parts_number`,`parts_href`, `scrapped_url`,`parts_desc`,`parts_image`) VALUES ";
			foreach($html->find('div[class="view-content"]') as $a_data)
			{

				foreach($a_data->find('td') as $row_data)
				{
					foreach ($row_data->find('img') as $img_data) 
					{
						$part_img=$img_data->src."</h5>";;
					}

					foreach ($row_data->find('div[class="views-field views-field-title"]') as $text_data) 
					{
						$part_number = str_replace(" ", "", $text_data->plaintext);
						
						foreach($text_data->find('a') as $link_data)
						{
							$part_href =$base_url.$link_data->href;
						}

					}
					
					
					if($i==0)
					{
						$query=$query." ('".$part_number."','".$part_href."','".$url."','".$part_desc."','".$part_img."')";
					}
					else
					{
						$query=$query." ,('".$part_number."','".$part_href."','".$url."','".$part_desc."','".$part_img."')";
					}
					$i++;
					//echo $query;

				}

			}
		
		echo $query;
		mysql_query($query);
		
		$html->clear();
	    unset($html);
	    echo "<h1>Done</h1>";
	    
	    
	    
}

?>