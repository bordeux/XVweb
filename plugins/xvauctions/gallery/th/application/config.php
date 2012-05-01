<?php

$xvConfig = array(
	"PATH_INFO" => (isset($_SERVER["ORIG_PATH_INFO"]) ? $_SERVER["ORIG_PATH_INFO"] :  $_SERVER["PATH_INFO"]),
	"allowed" => "jpeg|png|gif|jpg|bmp|tiff",
);