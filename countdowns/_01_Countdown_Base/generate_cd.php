<?php

// turn on errors for dev
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

ini_set('memory_limit', '512M');
ini_set('max_execution_time', 1);


$results_string = '';

// timezone
date_default_timezone_set('America/Los_Angeles');

// times
$now  = new DateTime('now');

// require directory check
require_once('../../libraries/dir_check/index.php');


// at this point, the required files exist in the directory, so let's perform a check on the configuration file 
$config_json = file_get_contents("config.json");
$config_data = json_decode($config_json);

$ends = strlen($config_data->ends) > 0 ? new DateTime($config_data->ends) : '';
$font_size_dt = $config_data->font_size_dt;
$font_size_mb = $config_data->font_size_mb;
$text_color_hex = $config_data->text_color;
$transparent_color_dt = $config_data->transparent_color_dt;
$transparent_color_mb = $config_data->transparent_color_mb;
$num_colors = $config_data->num_colors;
$dither = $config_data->dither;
$num_frames = $config_data->num_frames;

$coordinates = $config_data->digit_coordinates;

// check to see if any values are empty
if (empty($ends) || 
    empty($font_size_dt) || 
    empty($font_size_mb) || 
    empty($text_color_hex) || 
    empty($transparent_color_mb) || 
    empty($transparent_color_dt) || 
    empty($num_colors) ||
    !is_bool($dither) ||
    empty($num_frames)
) {
    echo "<div class=\"alert alert-danger\" role=\"alert\">One or more problems found with the <code style=\"font-weight: bold; color: #000000;\">config.json</code> file.</div>";
    exit;
}


// libraries to include
require "../../libraries/AnimGif.php";

// setup Anim object
$dt_anim = new GifCreator\AnimGif();
$mb_anim = new GifCreator\AnimGif();

// the base background image - this should be a PNG file
$dt_bg_image = 'dt_bg.png';
$mb_bg_image = 'mb_bg.png';


// count background images to see how many frames we have
$dt_bg_frames = 1;
$mb_bg_frames = 1;

$dt_list = glob("*.png");
foreach ($dt_list as $file) {
  if (preg_match("~^dt_bg([0-9]|[0-9][1-9]).png$~",$file)) {
    $dt_bg_frames++;
  }
}
$mb_list = glob("*.png");
foreach ($mb_list as $file) {
  if (preg_match("~^mb_bg([0-9]|[0-9][1-9]).png$~",$file)) {
    $mb_bg_frames++;
  }
}

// set up cycle counts to keep track of which bg image we're using
$dt_bg_cycle = 1;
$mb_bg_cycle = 1;


// setup text colors
list($text_r, $text_g, $text_b) = sscanf($text_color_hex, "#%02x%02x%02x");
$im = imagecreatetruecolor(500, 150);
$text_color = imagecolorallocate($im, $text_r, $text_g, $text_b);

// fonts
$space_mono = "../../assets/fonts/SpaceMono-Bold.ttf";

// create arrays for frames for both images because we want both generated at the same time
$dt_frames = array();
$mb_frames = array();

// calculate time
$left = $now->diff($ends);
$secs = $ends->getTimestamp() - $now->getTimestamp();
$secs_text = number_format($secs, 0, ".", ",");


// DESKTOP - create XX frames for days/hours
for ($i=0; $i <= $num_frames; $i++) { 

	// if we have multiple backgrounds, handle which one we need for this frame
  if ($dt_bg_frames > 1) {
  
  // see if cycle count is larger than frame count and reset to 1 if so
  if ($dt_bg_cycle > $dt_bg_frames) {
    $dt_bg_cycle = 1;
  }

  if ($dt_bg_cycle === 1) {
    // this is the first cycle, use regular image
    $tempImg = imagecreatefrompng($dt_bg_image);
  } else {
    // use cycle count image if it exists, or default to frame 1 bg if it doesn't
    $tempImg = file_exists('dt_bg'.$dt_bg_cycle.'.png') ? imagecreatefrompng('dt_bg'.$dt_bg_cycle.'.png') : imagecreatefrompng($dt_bg_image);
  }

  // increment cycle count 
  $dt_bg_cycle++;

  } else {

    // we only have one bg image
    $tempImg = imagecreatefrompng($dt_bg_image);

  }

	// calculate time
	date_modify($now, '+1 second');
	$left = $now->diff($ends);

	$days = $left->format("%a");
	$hours = $left->format("%H");
	$mins = $left->format("%I");
	$secs = $left->format("%S");

	// place each of our text items where they need to be depending on if it's days/hours or mins/secs
	// days should be a single digit, so need to calcluate X position
	// imagettftext(image, size, angle, x, y, color, fontfile, text)
	if (strlen($days) <= 1) {
		imagettftext($tempImg, $font_size_dt, 0, $coordinates->desktop->days_1digit[0], $coordinates->desktop->days_1digit[1], $text_color, $space_mono, $days);
	} else {
		imagettftext($tempImg, $font_size_dt, 0, $coordinates->desktop->days_2digit[0], $coordinates->desktop->days_2digit[1], $text_color, $space_mono, $days);
	}
	imagettftext($tempImg, $font_size_dt, 0, $coordinates->desktop->hours[0], $coordinates->desktop->hours[1], $text_color, $space_mono, $hours);
	imagettftext($tempImg, $font_size_dt, 0, $coordinates->desktop->minutes[0], $coordinates->desktop->minutes[1], $text_color, $space_mono, $mins);
	imagettftext($tempImg, $font_size_dt, 0, $coordinates->desktop->seconds[0], $coordinates->desktop->seconds[1], $text_color, $space_mono, $secs);

	$dt_frames[] = $tempImg;
}


// reset $now
date_modify($now, '-'.($num_frames + 1).' seconds');

// MOBILE - create 59 frames for mins/secs
for ($i=0; $i <= $num_frames; $i++) { 

	// if we have multiple backgrounds, handle which one we need for this frame
  if ($mb_bg_frames > 1) {
  
    // see if cycle count is larger than frame count and reset to 1 if so
    if ($mb_bg_cycle > $mb_bg_frames) {
      $mb_bg_cycle = 1;
    }

    if ($mb_bg_cycle === 1) {
      // this is the first cycle, use regular image
      $tempImg = imagecreatefrompng($mb_bg_image);
    } else {
      // use cycle count image if it exists, or default to frame 1 bg if it doesn't
      $tempImg = file_exists('mb_bg'.$mb_bg_cycle.'.png') ? imagecreatefrompng('mb_bg'.$mb_bg_cycle.'.png') : imagecreatefrompng($mb_bg_image);
    }

    // increment cycle count 
    $mb_bg_cycle++;

  } else {

    // we only have one bg image
    $tempImg = imagecreatefrompng($mb_bg_image);

  }

	// change font_size if necessary
	$font_size = 49;

	// calculate time
	date_modify($now, '+1 second');
	$left = $now->diff($ends);

	$days = $left->format("%a");
	$hours = $left->format("%H");
	$mins = $left->format("%I");
	$secs = $left->format("%S");

	// place each of our text items where they need to be depending on if it's days/hours or mins/secs
	if (strlen($days) <= 1) {
        imagettftext($tempImg, $font_size_mb, 0, $coordinates->mobile->days_1digit[0], $coordinates->mobile->days_1digit[1], $text_color, $space_mono, $days);
    } else {
        imagettftext($tempImg, $font_size_mb, 0, $coordinates->mobile->days_2digit[0], $coordinates->mobile->days_2digit[1], $text_color, $space_mono, $days);
    }
    imagettftext($tempImg, $font_size_mb, 0, $coordinates->mobile->hours[0], $coordinates->mobile->hours[1], $text_color, $space_mono, $hours);
    imagettftext($tempImg, $font_size_mb, 0, $coordinates->mobile->minutes[0], $coordinates->mobile->minutes[1], $text_color, $space_mono, $mins);
    imagettftext($tempImg, $font_size_mb, 0, $coordinates->mobile->seconds[0], $coordinates->mobile->seconds[1], $text_color, $space_mono, $secs);

    $mb_frames[] = $tempImg;
}


// set variables for the AnimGif library
$durations = array(100); // delay between frames - 100 = 1 second
$loop = 0;


// remove leading # from transparent colors if they exist
$transparent_color_dt = ltrim($transparent_color_dt, '#');
$transparent_color_mb = ltrim($transparent_color_mb, '#');

// create desktop version of gif and save to current folder
try {
    $dt_anim->create($dt_frames, $durations, $loop, $num_colors, $dither, $transparent_color_dt);
    $dt_gif = $dt_anim->get();
    $dt_anim->save('./cd_dt.gif');
} catch (Exception $e) {
    $results_string .= 'error creating desktop version; ';
}



// create mobile version of gif and save to current folder
try {
    $mb_anim->create($mb_frames, $durations, $loop, $num_colors, $dither, $transparent_color_mb);
    $mb_gif = $mb_anim->get();
    $mb_anim->save('./cd_mb.gif');
} catch (Exception $e) {
    $results_string .= 'error creating mobile version';
}



// memory usage diagnostic - uncomment to test
//displayPeakMemUsage();

// all done! echo out the result for the cronjob file and exit the script
$results_string = $results_string == '' ? "success" : $results_string;
echo $results_string;
exit;

function displayPeakMemUsage() {
  /* Peak memory usage */
  $mem_peak = memory_get_peak_usage();
  echo 'Peak usage: <strong>' . round($mem_peak / 1024) . 'KB</strong> of memory.<br><br>';
  exit;
}