<?php

$data = !empty($_POST['configData']) ? json_decode($_POST['configData']) : '';

if ($data === '') {
	echo "empty";
} else {
	$fp = fopen('../config.json', 'w');
	fwrite($fp, json_encode($data));
	fclose($fp);
	echo "saved";
}