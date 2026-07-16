<?php
class ObjectCache
{

	private static $cachePath;
	private static $ttl = 259200;

	public static function isCached($cache_file_name, $use_cache = true, $define_ttl = 0)
	{
		global $_OBJECT_CACHE_PATH;

		$file = self::getCacheFilePath($cache_file_name);
		if ($define_ttl > 0) {
			$use_ttl = $define_ttl;
		} else {
			$use_ttl = self::$ttl;
		}
		return file_exists($file) && (time() - filemtime($file)) < $use_ttl;
	}

	public static function getCacheFilePath($cache_file_name)
	{
		global $_OBJECT_CACHE_PATH;

		$cache_file_name = $cache_file_name;

		return dirname(__DIR__) . "/$_OBJECT_CACHE_PATH" . $cache_file_name;
	}

	public static function getCache($cache_file)
	{
		$response = file_get_contents(dirname(__DIR__) . "/cache_object/" . "$cache_file");
		if ($response) {
			$response = json_decode(gzuncompress($response), true);
		} else {
			$response = [];
		}
		return $response;
	}

	public static function getCacheFileUnixTime($cache_file)
	{
		// Check if the file exists
		$cache_file = dirname(__DIR__) . "/cache_object/" . "$cache_file";
		if (file_exists($cache_file)) {
			// Get the file's last modification time
			$file_mod_time = filemtime($cache_file);
			return $file_mod_time;
		} else {
			// Handle the case where the file does not exist
			return false; // or you can throw an exception or return a specific value
		}
	}


	public static function cache($cache_file_name, $cache_content, $convertUtf8 = true)
	{

		if ($cache_content) {
			//set the filename
			if ($convertUtf8) {
				$cache_content = Helper::convertUTF8($cache_content);
			}

			$cache_content = json_encode($cache_content);
			$cache_content = gzcompress($cache_content, 9);
		} else {
			$cache_content = '';
		}
		 $host = $_SERVER['HTTP_HOST'];
        $faq_path = '';
        if ($host === 'ryantest.newpages.com.my') {
            $faq_path = "/faq";
        }
		$filename = $_SERVER['DOCUMENT_ROOT'] . "$faq_path/cache_object/$cache_file_name";
		$handle = fopen($filename, 'w+');
		//write the data into the file
		fwrite($handle, $cache_content);
		//close the file
		fclose($handle);
	}


}

?>