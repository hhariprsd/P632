<?php

/**
 * This function calls the URL, receives the data from server and senda back the data to the caller
 *
 * @param unknown $url
 * @return string
 */
function gameCallURL($url){

	$data = "";

	/*
	 * Decodes the URL and trims spaces that are leading or to the suffix of the URL.
	* Checks if the URL is valid by creating a file handle. If the URL is not valid, an Exception is thrown.
	* If the URL is valid, the contents are read into a string and return to the caller.
	*/

	$url = urldecode($url);

	$url = trim($url);

	if(!($fileHandle = fopen($url,"r"))){
		throw new Exception("Not able to access URL " . $url);
	}

	while(!feof($fileHandle)){
		$data = $data . fgets($fileHandle);
	}

	fclose($fileHandle);

	return $data;
}

?>