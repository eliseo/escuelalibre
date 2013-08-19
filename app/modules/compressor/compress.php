<?php

/*
 *
 *  Author: Pavel Markovnin (based on Vivvo CMS)      
 *  Site:   http://vremenno.net
 *  E-mail: pavel@markovnin.com
 *
 *
 *  Usage Example: <script type="text/javascript" src="compress.php?js,js/file1,js/file3,js/file3"></script> 
 */
 
 
define("DIRNAME", dirname(__FILE__));

/*
 * Load Compress Libs
 */
 
require_once('cssmin.php');
require_once('jsmin.php');


/*
 * Path to Compressed File
 */

function compressFilePath($filesMd5, $totalTime, $type) {
	return DIRNAME . '/compressed/' . $filesMd5 . '-' . $totalTime . '.' . $type;
}


/*
 * Compress and Save Files
 */

function compressFiles($files, $type, $filesMd5, $totalTime) {
	$mTimeSum = 0;
	$output   = '';
	
	foreach ($files as $file){
		$file = preg_replace('/[^a-zA-Z0-9\_\-\/\.]/', '', $file);
		if (file_exists(DIRNAME . '/' . $file . '.' . $type)){
			$output   .= file_get_contents(DIRNAME . '/' . $file .'.' . $type) . "\n";
			$mTimeSum += filemtime(DIRNAME . '/' . $file . '.' . $type);
		}
	}
	
	if($type == 'css')
		$output = cssmin::minify($output);
	else
		$output = JSMin::minify($output);
	
	foreach(glob(DIRNAME . '/compressed/' . $filesMd5 . '-*.' . $type) as $v)
	    unlink($v);
		
	file_put_contents(compressFilePath($filesMd5, $totalTime, $type), $output);

	return true;
}



####################################################################################

if (ini_get('zlib.output_compression'))
	ob_start();
elseif (function_exists('ob_gzhandler'))
	ob_start('ob_gzhandler');
else
	ob_start();

$files    = explode(',', parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY));
$filesMd5 = md5($_SERVER['REQUEST_URI']);
$sendbody = true;

if (!empty($files)){
	$type = $files[0];
	array_shift($files);
		if (!empty($files)) {
			$mTimeSum = 0;

			switch($type) {
				case 'js':  header("Content-Type: application/x-javascript"); break;				
				case 'css': header("Content-Type: text/css"); break;
				default:    exit;
			}
		
			foreach ($files as $file) {
				if(file_exists(DIRNAME . '/' . $file . '.' . $type)) {
					$mt        = filemtime(DIRNAME . '/' . $file . '.' . $type);
					$mTime[]   = $mt;
					$mTimeSum += $mt;
				} else {
					echo '/* File not found: ' . $file . '.' . $type . ' */
';
				}
			}
			
			if(!file_exists(compressFilePath($filesMd5, $mTimeSum, $type)))
				compressFiles($files, $type, $filesMd5, $mTimeSum);
			
			$output = file_get_contents(compressFilePath($filesMd5, $mTimeSum, $type));
			
				
			
			/* -----------------------------------------
			
			   Output Compressed Data with Cache Headers
			   
			   ----------------------------------------- */
			
			$lastmod = max($mTime);
			$expires = 60 * 60 * 24 * 3;
			$exp_gmt = gmdate("D, d M Y H:i:s", time() + $expires)." GMT";
			$mod_gmt = gmdate("D, d M Y H:i:s", time() + (3600 * -5 * 24 * 365) )." GMT";
			$expires = 60 * 60 * 24 * 10;
			$exp_gmt = gmdate("D, d M Y H:i:s", time() + $expires )." GMT";
			$mod_gmt = gmdate("D, d M Y H:i:s", $lastmod) . " GMT";
			
			$etag = '"'.md5($output).'"';
			
			
			/* Check 'If-Modified-Since' header
			   -------------------------------- */
			   
			if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && gmdate('D, d M Y H:i:s', $lastmod)." GMT" == trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
				header("HTTP/1.0 304 Not Modified");
				header("Content-Length: 0");
				$sendbody = false;
			}
			
			
			/* Check 'If-None-Match' header (ETag)
			   ----------------------------------- */
			   
			if ($sendbody && isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
				$inm = explode(",",$_SERVER['HTTP_IF_NONE_MATCH']);
				foreach ($inm as $i) {
					if (trim($i) != $etag) continue;
					header("HTTP/1.0 304 Not Modified");
					header("Content-Length: 0");
					$sendbody = false; break;
				}
			}
			
			
			/* Caching headers (enable cache for one day)
			   ------------------------------------------ */
			   
			$expires = 60 * 60 * 24 * 10;
			$exp_gmt = gmdate("D, d M Y H:i:s", time() + $expires) . " GMT";
			$mod_gmt = gmdate("D, d M Y H:i:s", $lastmod) . " GMT";
			header("Expires: {$exp_gmt}");
			header("Last-Modified: {$mod_gmt}");
			header("Cache-Control: public, max-age={$expires}");
			header("Pragma: !invalid");
			header("ETag: {$etag}");
			
			echo '/* Compressed (MD5 '. $filesMd5 .'), Last Modified on ' . gmdate('D, d M Y H:i:s', $lastmod) . ' GMT */ ' . $output;
		}
}

ob_end_flush();
?>
