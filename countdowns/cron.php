<?php

ini_set('memory_limit', '-1');
date_default_timezone_set('America/Los_Angeles');

// This script will be run by a cronjob every two minutes, regenerating countdown files whose end dates are in the future.


//------------------------------
//  COUNTDOWN IMAGE REFRESHING
//------------------------------


// Get all directories
$dirs = array_filter(glob('*'), 'is_dir');

// Set $base_dir to the the base directory you keep your countdowns.
// For example, if you have a countdown at the following URL: https://www.mycoolsite.com/emails/cd/my_cool_countdown/, your $base_dir is 'https://www.mycoolsite.com/emails/cd/'
$base_dir = '[YOUR_BASE_URL]/cd/';

// set the timezone
date_default_timezone_set('America/Los_Angeles');

// get the current time
$now  = new DateTime('now');

$affected_dirs = "Last updated directories\r\n------------------------\r\n\r\n";

$countdowns_updated = false;

// Go through each directory
foreach ($dirs as $k => $dir_name) {

	// make sure the dirname doesn't start with an underscore, that it has a config file
	$is_proper_dir = substr($dir_name, 0, 1) !== "_";
	$has_config = file_exists($dir_name."/config.json");
	$ends_in_future = false;

	if ($is_proper_dir && $has_config) {

		// if both are true, check that end date is in the future
		$config_json = file_get_contents($dir_name."/config.json");
		$config_data = json_decode($config_json);
		$config_ends = new DateTime($config_data->ends);
		
		if ($now < $config_ends) {
			$ends_in_future = true;
		}
	}


	// only take action if it is a proper directory, it has a config file, and an end date that is in the future
	if ($is_proper_dir && $has_config && $ends_in_future) {

		if (!$countdowns_updated) {
        	$affected_dirs .="Countdowns:\r\n";
        	$countdowns_updated = true;
        }


		$affected_dirs .= $dir_name." ".$now->format('Y-m-d H:i:s')." - ";
		
		$ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, $base_dir.$dir_name."/generate_cd.php"); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $results contains the output string 
        $results = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);

        $affected_dirs .= $results."\r\n";


	} 
	
}


// if no directories have been updated, note that in the log
if ($affected_dirs == "Last updated directories\r\n------------------------\r\n\r\n") {
	$affected_dirs .= "No directories affected - ".$now->format('Y-m-d H:i:s');
}

// Finally, output log file 
$fp = fopen("./cron_log.txt","wb");
fwrite($fp,$affected_dirs);
fclose($fp);