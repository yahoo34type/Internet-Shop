<?php 
	function getvalchange($url, $getparam, $newval)
				{
				    $k = preg_split("/[\"&?]+/", $url);
				    $s = false;
				    for ($i=0; $i<count($k); $i++) 
				    {
				    	$key = $k[$i];
				    	$pos = strpos($key, $getparam);
				    	if ($pos !== false)
				    	{
				    			$k[$i] = $getparam . "=" . $newval;
				    			$s = true;
							}
						}
						if (!$s)
						{
							if (count($k)==1)
								return $url . "?" . $getparam . "=" . $newval;
							else
								return $url . "&" . $getparam . "=" . $newval;
						}
						else
						{
							$a = $k[0];
							for ($j=1; $j<count($k); $j++)
							{
								if ($j == 1)
									$a = $a . "?" . $k[$j];
								else
									$a = $a . "&" . $k[$j];
							}
							return $a;
						}
					}
	print_r(getvalchange("http://itandcs/viewgoods.php?page=2","id","4"));
 ?>