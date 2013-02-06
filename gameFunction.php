<?php
require_once('gameCallURL.php');
require_once('SequenceVO.php');
require_once('StyleVO.php');
require_once('SequenceChildVO.php');
require_once('Parser.php');
require_once('InstructionSection.php');
require_once('ItemSection.php');
require_once('HeaderSection.php');


/**
 * This functions forms the HTML content with the XML content that needs to be displayed
 *
 * @param unknown $dataContent
 * @param unknown $styleContent
 * @return string containing HTML content
 */

function formHTMLContent($headerContent,$dataContent,$styleContent){

	/*
	 * Creates a HTML content with the data xml and style xml embedded in it.
	 * Returns the HTML content as a string to the caller.
	 */
	$result =<<<FILECONTENT
	<html>
	<head>

$headerContent
  </head>

  <body>
$dataContent 
$styleContent
  </body>
</html>

FILECONTENT;

	return $result;
}

/**
 * This function receives the dataUri, styleUri. Fetches the XML content using the URI.
 * Creates an HTML page with the contents of the XML and displays it.
 *
 * @param unknown $dataUri
 * @param unknown $styleUri
 * @param string $formatOverride
 * @return string containing HTML content
 */

function game ($dataUri, $styleUri, $formatOverride = FALSE){

	/*
	 * Checks if the data URL and style is null is not null.
	* If null, an appropriate exception is thrown.
	*
	*/
	if(is_null($dataUri)){
		throw new Exception("Data URI is NULL");
	}

	if(is_null($styleUri)){
		throw new Exception("Style URI is NULL");
	}

	/*
	 * Calls the gameCallURL function to fetch the contents of data and style xml.
	*
	*/

	try{
		$dataURLContent = gameCallURL($dataUri);
		$styleURLContent = gameCallURL($styleUri);
		
		/*
		 * Parse the data and style xmls and form a html string using the data and style VO objects
		*
		*/
		
		$sequenceObject  = parseDataFile($dataURLContent);
		$styleObject = parseStyleFile($styleURLContent);
		
		
	}catch(Exception $e){
		throw $e;
	}

	
	$headerContent = formHeaderSection($sequenceObject, $styleObject);
	$dataHTMLConent = formSequenceHTML($sequenceObject);
	$styleHTMLConent = formInstructionsHTML($styleObject,$sequenceObject);
	
	/*
	 * Calls the function formHTMLContent to create a string that contains the HTML content with the data and style xml's.
	*/

	$htmlContent = formHTMLContent($headerContent,$dataHTMLConent,$styleHTMLConent);

	/*
	 * returns the html string to the caller.
	 */
	
	return $htmlContent;

}

?>
