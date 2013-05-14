<?
function parse_mif($file_name)
{
	$x=1;
	$line_num = 1;
	$fh = @fopen($file_name,"r");
	$ret = '';
	while(!feof($fh))
	{
		$line = fgets($fh);
		$line_arr = explode(" ",$line);
		if (trim($line_arr[0])<>'')
		{
			if (trim($line_arr[0])=='Region') {
				$num_regions = trim($line_arr[2]);
				$i=1;
				// Export regions (number of shapes)
				while ($i<=$num_regions){
					$p=1;
					$num_points = trim(fgets($fh));
					if (strlen($num_points)>5)
					{
					} else {
						// Read points from file
						while ($p<=$num_points){
							$line = fgets($fh);
							$line = explode(" ",$line);
							$ret.='{point_no: '.$line_num.',pol_id: '.$x.', lat:'.trim($line[1]).', lng:'.trim($line[0]).'},';
							$line_num++;
							$p++;
						}
					}

					$i++;
					$x++;
				}

			}
			 
		}
	}
	$rez[0]=$x; // Return number of polygons
	$rez[1]=substr($ret, 0, -1); // Actual polygons
	return $rez;
}


?>
