<?php
include_once("simple_html_dom.php");

mysql_connect("localhost","root","");
mysql_select_db("websearchdb");

/*for($cnt=1;$cnt<=29;$cnt++)
{
}
*/
	scraping_IMDB("http://gasturbinecontrols.com/component/search/?searchword=is2&ordering=newest&searchphrase=all");




function scraping_IMDB($url) {

	// extraction start
	
	$html = file_get_html($url);
	$i=0;
	$base_url="http://gasturbinecontrols.com";
	$part_number="";
	$part_href="";
	$part_desc="";
	$part_img="";

		$query="INSERT INTO `tbl_parts_gas_turbine` (`parts_number`,`parts_href`, `scrapped_url`,`parts_desc`,`parts_image`) VALUES ";
			foreach($html->find('div[class="results  clearfix"]') as $a_data)
			{

				foreach($a_data->find('tr') as $row_data)
				{
					$cnt=0;
					foreach($row_data->find('a') as $td_data)
					{
						if($cnt==0)
						{
							$part_number=$td_data->plaintext;
							$part_href=$base_url.$td_data->href;
							echo "<h5>".$td_data->plaintext."</h5>";
							echo "<br>link:".$base_url.$td_data->href;
							//echo $td_data->href;
						}
						else if($cnt==1)
						{
							echo "<br>desc:".$td_data->href;
							$part_desc=$td_data->href;
							//echo $td_data->href;
						}
						else if($cnt==2)
						{
							foreach($td_data->find('img') as $im_data)
							{
								$part_img=$im_data->src;
								echo"<br>Image :". $im_data->src;
							}
						}
						$cnt++;	
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

		//		echo "<br>".$i;
				/*
				$part_href=$a_data->href;
				$part_number=$a_data->plaintext;
				*/

				
			}
		//	echo $part_href;
		//	echo $part_number;
		/*
		INSERT INTO `tbl_parts` (`parts_id`, `parts_number`, `parts_desc`, `parts_image`, `parts_href`, `parts_status`, `scrapped_url`) VALUES
(1, 'IC300ADC020', '', '', 'https://www.axcontrol.com/automation/ge-fanuc-plc/ic300-ocs/IC300ADC020', 0, 'https://www.axcontrol.com/search.php?search_term=ic3'),
(2, 'IC300ADC110', '', '', 'https://www.axcontrol.com/automation/ge-fanuc-plc/ic300-ocs/IC300ADC110', 0, 'https://www.axcontrol.com/search.php?search_term=ic3')
		*/
		/*
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
		*/
		
		echo $query;
		mysql_query($query);
		
		$html->clear();
	    unset($html);
	    echo "<h1>Done</h1>";
	    
	    
}

?>