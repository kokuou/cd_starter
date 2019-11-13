<?php

$check_string = '';
$errors_found = 0;

// First get directory perms
clearstatcache();
$directory_perms = substr(sprintf('%o', fileperms('./')), -3);
$index_perms = substr(sprintf('%o', fileperms('./index.php')), -3);
$generate_perms = substr(sprintf('%o', fileperms('./generate_cd.php')), -3);

// check perms for the folder and the file 
$directory_perms_checkmark = $directory_perms == '777' ? '<span style="color: seagreen;">✔</span>' : '<span style="color: tomato;">✖</span>';
$index_perms_checkmark = $index_perms == '777' ? '<span style="color: seagreen;">✔</span>' : '<span style="color: tomato;">✖</span>';
$generate_perms_checkmark = $generate_perms == '777' ? '<span style="color: seagreen;">✔</span>' : '<span style="color: tomato;">✖</span>';

// add to results string 
$check_string .= "[".$directory_perms_checkmark."] directory permissions set to '777'.<br>[".$index_perms_checkmark."] <strong>index.php</strong> file permissions set to '777' (current:".$index_perms.").<br>[".$generate_perms_checkmark."] <strong>generate_cd.php</strong> file permissions set to '777' (current:".$generate_perms.").<br>";

// increment $errors_found if necessary
if ($directory_perms !== '777') {
	$errors_found++;
}
if ($index_perms !== '777' && !isLocalhost()) {
	$errors_found++;
}
if ($generate_perms !== '777' && !isLocalhost()) {
	$errors_found++;
}

// make sure there's a config file
$has_config = file_exists("config.json");

$has_config_checkmark = $has_config ? '<span style="color: seagreen;">✔</span>' : '<span style="color: tomato;">✖</span>';

// add to results string
$check_string .= '['.$has_config_checkmark.'] <strong>config.json</strong> file found.<br>';

// increment errors_found if necessary
if (!$has_config) {
	$errors_found++;
}


// Next, look for required files 

$desktop_bg_exists = file_exists('dt_bg.png');
$mobile_bg_exists = file_exists('mb_bg.png');

$desktop_fallback_exists = file_exists('cd_dt_fallback.png');
$mobile_fallback_exists = file_exists('cd_mb_fallback.png');

$desktop_zero_exists = file_exists('cd_dt_zero.png');
$mobile_zero_exists = file_exists('cd_mb_zero.png');



$dt_bg_checkmark = $desktop_bg_exists ? '<span style="color: seagreen;">✔</span>' : '<span style="color: tomato;">✖</span>';
$mb_bg_checkmark = $mobile_bg_exists ? '<span style="color: seagreen;">✔</span>' : '<span style="color: tomato;">✖</span>';

$dt_fallback_checkmark = $desktop_fallback_exists ? '<span style="color: seagreen;">✔</span>' : '<span style="color: tomato;">✖</span>';
$mb_fallback_checkmark = $mobile_fallback_exists ? '<span style="color: seagreen;">✔</span>' : '<span style="color: tomato;">✖</span>';

$dt_zero_checkmark = $desktop_zero_exists ? '<span style="color: seagreen;">✔</span>' : '<span style="color: tomato;">✖</span>';
$mb_zero_checkmark = $mobile_zero_exists ? '<span style="color: seagreen;">✔</span>' : '<span style="color: tomato;">✖</span>';

// add to results string 
$check_string .= "[".$dt_bg_checkmark."] <strong>dt_bg.png</strong> file found.<br>[".$mb_bg_checkmark."] <strong>mb_bg.png</strong> file found.<br>[".$dt_zero_checkmark."] <strong>cd_dt_zero.png</strong> file found.<br>[".$mb_zero_checkmark."] <strong>cd_mb_zero.png</strong> file found.<br>[".$dt_fallback_checkmark."] <strong>cd_dt_fallback.png</strong> file found.<br>[".$mb_fallback_checkmark."] <strong>cd_mb_fallback.png</strong> file found.<br>";

// increment $errors_found if necessary
if (!$desktop_bg_exists) {
	$errors_found++;
}
if (!$mobile_bg_exists) {
	$errors_found++;
}
if (!$desktop_fallback_exists) {
	$errors_found++;
}
if (!$mobile_fallback_exists) {
	$errors_found++;
}
if (!$desktop_zero_exists) {
	$errors_found++;
}
if (!$mobile_zero_exists) {
	$errors_found++;
}


if ($errors_found > 0) {
	echo "<pre>";
	$check_string = "This image failed the directory check with <strong>".$errors_found."</strong> errors:<br><br>".$check_string;

	if (isLocalhost()) {
		$check_string .= '<br><br>(Currently working on <strong>localhost</strong>, so file permissions for <strong>index.php</strong> and <strong>generate_cd.php</strong> are ignored.)';
	}

	echo $check_string;
	echo '</pre>';
	exit;
}

// localhost check function 
function isLocalhost($whitelist = ['127.0.0.1', '::1']) {
    return in_array($_SERVER['REMOTE_ADDR'], $whitelist);
}