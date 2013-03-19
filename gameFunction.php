<?php
require_once('gameCallURL.php');
require_once('SequenceVO.php');
require_once('StyleVO.php');
require_once('SequenceChildVO.php');
require_once('Parser.php');
require_once('SequenceHTMLFormatter.php');
require_once('HTMLContentFormatter.php');
require_once('CategorizeHTMLFormatter.php');

/**
 * This functions forms the HTML content with the XML content that needs to be displayed
 *
 * @param unknown $dataContent
 * @param unknown $styleContent
 * @return string containing HTML content
*/

function formHTMLContent($dataVO,$styleVO){



	if ($dataVO->getGameType() == 'SEQUENCE'){

		try{
			$sequenceHTMLFormatter = new SequenceHTMLFormatter();
			$htmlFormatter = new HTMLContentFormatter();
			$htmlFormatter->setHTMLFormatterObject($sequenceHTMLFormatter);

			// Forms the various sections of the HTML document.
			
			$headerContent = $htmlFormatter->formHeaderSection($dataVO, $styleVO);
			$instructionContent = $htmlFormatter->formInstructionSection($dataVO, $styleVO);
			$gameContent = $htmlFormatter->formGameSection($dataVO, $styleVO);
				
		}catch(Exception $e){
			throw $e;
		}
	}else if($dataVO->getGameType() == 'CATEGORIZE'){
		try{
			$categorizeHTMLFormatter = new CategorizeHTMLFormatter();
			$htmlFormatter = new HTMLContentFormatter();
			$htmlFormatter->setHTMLFormatterObject($categorizeHTMLFormatter);
		
			// Forms the various sections of the HTML document.
				
			$headerContent = $htmlFormatter->formHeaderSection($dataVO, $styleVO);
			$instructionContent = $htmlFormatter->formInstructionSection($dataVO, $styleVO);
			$gameContent = $htmlFormatter->formGameSection($dataVO, $styleVO);
		
		}catch(Exception $e){
			throw $e;
		}
	}

	/*
	 * Creates a HTML content with the data xml and style xml embedded in it.
	* Returns the HTML content as a string to the caller.
	*/
	$htmlContent =<<<FILECONTENT
<html>
  <head>
$headerContent
  </head>
  <body>
$instructionContent
$gameContent
  </body>
</html>

FILECONTENT;

	return $htmlContent;
}

function formDefaultHTMLContent($dataContent,$styleContent){

	/*
	 * Creates a HTML content with the data xml and style xml embedded in it.
	* Returns the HTML content as a string to the caller.
	*/

	$result =<<<FILECONTENT
<html>
  <head>
    <title>WGS game</title>
  </head>

  <body>
    <h1>This is a WGS game</h1>

    <h2>Data file:</h2>
<pre>
$dataContent
</pre>

<h2>Style file:</h2>
<pre>
$styleContent
</pre>
  <body>
<html>

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
		exit("Data URI is NULL");
	}

	if(is_null($styleUri)){
		exit("Style URI is NULL");
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

		$dataVO  = parseDataFile($dataURLContent);
		$styleVO = parseStyleFile($styleURLContent);
		
		/*
		 * Forms the HTML Section for the game.
		*
		*/
		$htmlContent = formHTMLContent($dataVO,$styleVO);

	}catch(Exception $e){
		$htmlContent = formDefaultHTMLContent(htmlspecialchars($dataURLContent),htmlspecialchars($styleURLContent));
	}
	/*
	 * returns the html string to the caller.
	*/

	return $htmlContent;

}

?>
