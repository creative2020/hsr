<?php
class Screenshot
{

    private static $google_api_key;
    private static $openSSL_okay = false;
    private static $screenshot;
    private static $shot_okay = false;
    private static $cache_time = 0;
    private static $webpage_url;
    private static $device = "desktop";

    function __construct()
    {
        $arguments = func_get_args();
        self::$google_api_key = @$arguments[0];
        self::$openSSL_okay = extension_loaded('openssl');
    }

    public static function cache($cache_time)
    {
        $output = false;
        $cache_time = (int)strtotime($cache_time);
        if ($cache_time >= 1) {
            $live__time = time();
            $sec___time = $cache_time - $live__time;
            if ($sec___time > 1) {
                self::$cache_time = $sec___time;
                $output = true;
            }
        }
        return $output;
    }
	
	public static function format($url){	
		if(strpos($url,"http") === false){
			return "http://".$url;
		}
		return $url;		
	}

    public static function generate($webpage_url, $device = "desktop")
    {
        $output = false;
        if (self::$openSSL_okay) {
            $approved_devices = array("desktop", "mobile");
            if (!in_array($device, $approved_devices)) {
                $device = "desktop";
            }
            self::$device = $device;
            if (!!filter_var($webpage_url, FILTER_VALIDATE_URL) && @preg_match("/^https?\:\/\//i", $webpage_url)) {
                self::$webpage_url = $webpage_url;

                $cache_req = false;
                $cache_dat = null;
                $webp_hash = md5($webpage_url . $device);

                if (is_numeric(self::$cache_time) && self::$cache_time > 0) {
                    $cache_req = true;
                }

                $min_rack = date("ymd", time() - self::$cache_time);
				
				// ADD IN WORDPRESS DIRECTORY PATHS
				$uploads = wp_upload_dir();
				
				// CREATE CACHE DIR
				if(!is_dir($uploads['path']. "/wlt_screenshot_cache/")){  
					@mkdir($uploads['path']. "/wlt_screenshot_cache/" . $today_rack . "/" . $sub_rack);
				}
				
                $racks = array_filter(array_slice(scandir($uploads['path']. "/wlt_screenshot_cache"), 2), function ($r) use ($min_rack) {
                    return $r >= $min_rack;
                });

                foreach ($racks as $rack) {
                    $shot_root = $uploads['path']. "/wlt_screenshot_cache/" . $rack . "/" . substr($webp_hash, 0, 2) . "/" . $webp_hash . ".jpg";
                    if (file_exists($shot_root)) {
					 	$thumbnail_link =  $uploads['url']. "/wlt_screenshot_cache/" . $rack . "/" . substr($webp_hash, 0, 2) . "/" . $webp_hash . ".jpg";                        
                        break;
                    }
                }

				// IF THE THUMBNAILW AS FOUND, JUST RETURN IT
                if ($thumbnail_link != null) {
                    
                       return $thumbnail_link;
					
                } else {
                    $google_root = "https://www.googleapis.com/pagespeedonline/v1/runPagespeed?url=" . urlencode($webpage_url) . "&strategy=" . $device . "&screenshot=true&fields=responseCode%2Cscreenshot&key=" . self::$google_api_key;
                    $google_data = @json_decode(file_get_contents($google_root));
                    if (is_object($google_data)) {
                        if (@$google_data->responseCode == 200) {
                            $_shotdat = @$google_data->screenshot->data;
                            $image_data = @base64_decode(str_replace(array("-", "_"), array("+", "/"), $_shotdat));
                            $image_okay = @imagecreatefromstring($image_data);
							
                            if ($image_okay !== false) {
                               
                                self::$shot_okay = true;
                                $output = true;
                                if ($cache_req) {
                                    $today_rack = date("ymd");
                                    if (!is_dir($uploads['path']. "/wlt_screenshot_cache/" . $today_rack)) {
                                        @mkdir($uploads['path']. "/wlt_screenshot_cache/" . $today_rack);
                                    }
                                    $sub_rack = substr($webp_hash, 0, 2);
                                    if (!is_dir($uploads['path']. "/wlt_screenshot_cache/" . $today_rack . "/" . $sub_rack)) {
                                        @mkdir($uploads['path']. "/wlt_screenshot_cache/" . $today_rack . "/" . $sub_rack);
                                    }
									
									// SAVE THUMBNAIL
									$thumbnail_path = $uploads['path']. "/wlt_screenshot_cache/" . $today_rack . "/" . $sub_rack . "/" . $webp_hash . ".jpg";
									$thumbnail_link = $uploads['url'] . "/wlt_screenshot_cache/" . $today_rack . "/" . $sub_rack . "/" . $webp_hash . ".jpg";									
									file_put_contents($thumbnail_path, $image_data);									
									return $thumbnail_link;
                                }
                            } else {
								return array('error' => 'Screenshot image data corrupted'); //Screenshot image data corrupted                              
                            }
                            unset($image_okay);
                        } else {
							return array('error' => 'Webpage not found'); //Webpage not found
                             
                        }
                    } else {
                        return array('error' => 'Invalid Google API key'); //Invalid Google API key
                    }
                }

            } else {
                return array('error' => 'Invalid Webpage URL'); //Invalid Webpage URL
            }
        } else {
			return array('error' => 'OpenSSL extension not installed'); //OpenSSL extension not installed
            
        }
        return $output;
    }
}
?>