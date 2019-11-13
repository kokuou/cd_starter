<?php

// turn on errors for dev
error_reporting(E_ALL);
ini_set('display_errors', 1);

ini_set('memory_limit', '512M');
ini_set('max_execution_time', 3);

// timezone
date_default_timezone_set('America/Los_Angeles');


// require directory check to make sure all the files exist and that permissions are correct
require_once('../../libraries/dir_check/index.php');


// grab the end date from the config file 
$config_json = file_get_contents("config.json");
$config_data = json_decode($config_json);

$now  = new DateTime('now');
$ends = strlen($config_data->ends) > 0 ? new DateTime($config_data->ends) : '';


// are we fetching the mobile version?
$which_image = (isset($_GET['mb']) && $_GET['mb'] == 'y') ? '_mb' : '_dt';
$is_mb = (isset($_GET['mb']) && $_GET['mb'] == 'y') ? true : false;


// checks to see if each of the countdown GIFs exist
$cd_dt_image = 'cd_dt.gif';
$cd_mb_image = 'cd_mb.gif';
$dt_image_exists = file_exists($cd_dt_image) ? true : false;
$mb_image_exists = file_exists($cd_mb_image) ? true : false;


// set up our fallback images
$cd_dt_fallback = 'cd_dt_fallback.png';
$cd_mb_fallback = 'cd_mb_fallback.png';


// first check to see that ends isn't empty 
if ($ends == '') {
	
	// if it is, show the fallback 
	if ($is_mb) {

		header("Expires: Mon, 1 Jan 2001 05:00:00 GMT");
		header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($cd_mb_fallback)).' GMT', true, 200);
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: image/png");
		$size = filesize($cd_mb_fallback);
		header("Content-Length: $size bytes");
		readfile($cd_mb_fallback);
		exit;
		
	} else {
		header("Expires: Mon, 1 Jan 2001 05:00:00 GMT");
		header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($cd_dt_fallback)).' GMT', true, 200);
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: image/png");
		$size = filesize($cd_dt_fallback);
		header("Content-Length: $size bytes");
		readfile($cd_dt_fallback);
		exit;
	}
}

// next, we'll check to see if the current time is before the end time for the countdown

if ($now < $ends) {

	// if the image exists, figure out which to show

	if ($is_mb) {
		
		// mobile image is being requested

		// check that the most recent mobile image exists and is no more than five minutes old

		$image_age = 300;

		if ($mb_image_exists) {
			$image_time = filemtime($cd_mb_image);
			$image_age = $now->getTimestamp() - $image_time;
		}

		if ($image_age >= 300 || !$mb_image_exists) {

			// if it's older than five minutes, there's a cron job issue
			// if it doesn't exist, something else is wrong
			// in either case, show a fallback

			header("Expires: Mon, 1 Jan 2001 05:00:00 GMT");
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($cd_mb_fallback)).' GMT', true, 200);
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Pragma: no-cache");
			header("Content-type: image/png");
			$size = filesize($cd_mb_fallback);
			header("Content-Length: $size bytes");
			readfile($cd_mb_fallback);
			exit;

		} else {

			// the image is fine, show the mobile countdown

			header("Expires: Mon, 1 Jan 2001 05:00:00 GMT");
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($cd_mb_image)).' GMT', true, 200);
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Pragma: no-cache");
			header("Content-type: image/gif");
			$size = filesize($cd_mb_image);
			header("Content-Length: $size bytes");
			readfile($cd_mb_image);
			exit;
		}

	} else {

		// desktop image is being requested 

		// again check that the most recent desktop image exists and is no more than five minutes old

		$image_age = 300;

		if ($mb_image_exists) {
			$image_time = filemtime($cd_dt_image);
			$image_age = $now->getTimestamp() - $image_time;
		}

		if ($image_age >= 300 || !$dt_image_exists) {

			// if it's older than five minutes, there's a cron job issue
			// if it doesn't exist, something else is wrong
			// in either case, show a fallback

			header("Expires: Mon, 1 Jan 2001 05:00:00 GMT");
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($cd_dt_fallback)).' GMT', true, 200);
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Pragma: no-cache");
			header("Content-type: image/png");
			$size = filesize($cd_dt_fallback);
			header("Content-Length: $size bytes");
			readfile($cd_dt_fallback);
			exit;

		} else {

			// the image is fine, show the countdown

			header("Expires: Mon, 1 Jan 2001 05:00:00 GMT");
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($cd_dt_image)).' GMT', true, 200);
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Pragma: no-cache");
			header("Content-type: image/gif");
			$size = filesize($cd_dt_image);
			header("Content-Length: $size bytes");
			readfile($cd_dt_image);
			exit;
		}

	}
	
}


if ($now >= $ends) {

	// countdown timer is over, just display zeroes

	if ($is_mb) {
		$cd_done = 'cd_mb_zero.png';
	} else {
		$cd_done = 'cd_dt_zero.png';
	}

	// memory usage diagnostic - uncomment to test
	//displayPeakMemUsage();

	header("Expires: Mon, 1 Jan 2001 05:00:00 GMT");
	header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($cd_done)).' GMT', true, 200);
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Pragma: no-cache");
	header("Content-type: image/gif");
	$size = filesize($cd_done);
	header("Content-Length: $size bytes");
	readfile($cd_done);
	exit;

	
} 

function displayPeakMemUsage() {
	 /* Peak memory usage */
   $mem_peak = memory_get_peak_usage();
   echo 'Peak usage: <strong>' . round($mem_peak / 1024) . 'KB</strong> of memory.<br><br>';
   exit;
}