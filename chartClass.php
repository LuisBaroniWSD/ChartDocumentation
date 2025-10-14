<?php
// Codelib: <Class: chartClass>

// General Use ChartsClass
class chartClass {
	function countLines($text) {
		$temp = $text;
		$counter = 1;
		
		for ($i=0; strstr($temp, '\n'); $i+=strlen($temp) - strlen(strstr($temp, '\n'))) {
			$temp = substr($temp, strpos($temp, '\n') + 1);
			$counter++;
		}
		
		return $counter;
	}
	
	function getTextHeight($text, $size) {
		return $this->countLines($text)*($size+2); // Adding 2 pixels for line spacing
	}
	
	function maxWordLength($text) {
		$str = str_replace('\n', " ", $text);
		$words = preg_split('/\s+/', $str, -1, PREG_SPLIT_NO_EMPTY);
		
		$maxLen = 0;
		foreach ($words as $word) {
			$len = strlen($word);
			if ($len > $maxLen) {
				$maxLen = $len;
			}
		}
		return $maxLen;
	}
	
	function getTextWidth($text, $charWidth) {
		if(strpos($text, '\n') === false) {
			return strlen($text) * $charWidth;
		} else {
			return $this->maxWordLength($text) * $charWidth;
		}
	}

	// both addTextAnnotation and addBoxedTextAnnotation treat $style as an integer, 0=normal, 1=bold, 2=italic, 3=bold-italic
	function addTextAnnotation($chart, $text, $font, $style, $size, $graphYAxisSize, $graphVerticalSize, $x, $y, $r, $g, $b) {
		// Calculate y positions for each line
		$textHeight = (($this->getTextHeight($text, $size)-8) * $graphYAxisSize) / $graphVerticalSize; // $textHeight is in graph axis dimensions
		$lines = $this->countLines($text);
		$topY = ($y + ($textHeight / 2)); // position of first line on top side of the box
		
		$sizeNormalized = ((($size + 2) * $graphYAxisSize) / $graphVerticalSize); // Normalized font size for graph axis dimensions with 2 pixels for line spacing
		
		for ($i = 0; $i < $lines; $i++) {
			$yPositions[$i] = $topY - ($i * $sizeNormalized); // Adjust y position for each line
		}

		// Split words
		$str = str_replace('\n', " ", $text);
		$words = preg_split('/\s+/', $str, -1, PREG_SPLIT_NO_EMPTY);

		$counter = 0;
		foreach ($words as $word) {
			$chart->addNonPointerAnnotation(
				$word,
				$font,
				$style,
				$size,
				$x,
				$yPositions[$counter], // Adjust y position for each line
				$r, $g, $b
			);
			$counter++;
		}
	}
	
	function addBoxedTextAnnotation($chart, $text, $font, $style, $size, $charSizeMult=0.75, $x, $y, $graphXAxisSize, $graphYAxisSize, $graphHorizontalSize, $graphVerticalSize, $r, $g, $b, $bgR, $bgG, $bgB, $bgA, $borderR, $borderG, $borderB, $padding=4) {
		// Get text height and width
		// $x and $y are in graph axis format
		// $size is in pixel format
		$textHeight = $this->getTextHeight($text, $size); // return in pixels, so $textHeight is in pixel format
		
		$charWidth = $charSizeMult * $size; // Ajust multiplier to fit your font, since it is an approximation
		$textWidth = $this->getTextWidth($text, $charWidth); // $textWidth is in pixel format
		
		// Add padding
		$boxWidth = $textWidth + 4 * $padding; // $textWidth and $padding are in pixel format
		$boxHeight = $textHeight + 4 * $padding; // so $boxWidth and $boxHeight are in pixel format

		// Normalize coordinates to graph axis dimensions
		$boxHeightNormalized = ($boxHeight * $graphYAxisSize) / $graphVerticalSize;
		$boxWidthNormalized = ($boxWidth * $graphXAxisSize) / $graphHorizontalSize;

		// Calculate box position
		$boxX = $x - ($boxWidthNormalized / 2);
		$boxY = $y - ($boxHeightNormalized / 2);
		// $boxX and $boxY are the lower left corner of the box in graph axis format

		// Draw rectangle (box)
		$chart->addXYPolygonAnnotation(
			[$boxX, $boxY, $boxX, $boxY + $boxHeightNormalized, // from lower left to upper left 
			$boxX, $boxY + $boxHeightNormalized, $boxX + $boxWidthNormalized, $boxY + $boxHeightNormalized, // from upper left to upper right
			$boxX + $boxWidthNormalized, $boxY + $boxHeightNormalized, $boxX + $boxWidthNormalized, $boxY, // from upper right to lower right
			$boxX + $boxWidthNormalized, $boxY, $boxX, $boxY], // from lower right to lower left
			$borderR, $borderG, $borderB, 255,
			$bgR, $bgG, $bgB, $bgA,
			$style, "solid", true
		);


		// Add text on top of the box
		$this->addTextAnnotation(
			$chart,
			$text,
			$font,
			$style,
			$size,
			$graphYAxisSize,
			$graphVerticalSize,
			$x,
			$y,
			$r, $g, $b
		);
	}
}

// Citi Live ChartsClass
class payoffChartClass extends chartClass{

	var $issuerSchema = NULL;

	var $denomination;

	var $productType;
	
	var $underlying_x;
	var $underlying_y;
	var $derivative_x;
	var $derivative_y;
	
	var $derivativeLineColor;
	var $derivativeLineWeight;
	var $derivativeLineStyle;
	var $underlyingLineColor;
	var $underlyingLineWeight;
	var $underlyingLineStyle;
	var $polygonOutlineColor;
	var $polygonFillColor;
	
	var $highlightAreasWhereUnderlyingOutperformsDerivative = true;

	var $showAnnotations = true;
	
	var $statedPrincipalAmountTerminology = '';
	var $bufferZoneTerminology = '';	
	var $barrierZoneTerminology = '';
	var $participationZoneTerminology = '';
	var $digitalZoneTerminology = '';
	var $fixedReturnAmountTerminology = '';
	var $minimumReturnAtMaturityTerminology = "";
	var $maximumReturnAmountTerminology = '';
	var $absoluteReturnZoneTerminology = '';
	var $additionalUpperParticipationTerminology = '';
	
	var $polygons = array();
	
	var $fixedReturnAmountPercentage = NULL;
	var $upsideStrikeLevel = NULL;
	var $additionalUpsideStrikeLevel = NULL;
	var $maximumReturnAmountPercentage = NULL;
	var $bufferPercentage = NULL;
	var $barrierPercentage = NULL;
	var $leverageFactor = NULL;
	var $upperLeverageFactor = NULL;
	var $x_limit = 201;
	var $x_leveragePosition = NULL;
	var $x_upperLeveragePosition = NULL;
	
	var $xAxisTitle;
	var $yAxisTitle;

	function __construct() {

		$this->denomination = 1000;
	
		$this->derivativeLineColor = [100, 100, 100];
		$this->derivativeLineWeight = 5;
		$this->derivativeLineStyle = 'solid';
		$this->underlyingLineColor = [150, 150, 150];
		$this->underlyingLineWeight = 5;
		$this->underlyingLineStyle = 'dashed';
		$this->polygonOutlineColor = [100, 100, 100];
		$this->polygonOutlineAlpha = 255;
		$this->polygonOutlineWeight = 1;
		$this->polygonOutlineStyle = 'solid';
		$this->polygonFillColor = [200, 200, 200];
		$this->polygonFillAlpha = 255;
		
		$this->xAxisTitle = 'Final Underlier Level as % of Initial Underlier Level';
		$this->yAxisTitle = 'Hypothetical Cash Settlement Amount as % of Principal Amount';
		
		// required for KI/KO-downside-circles. Setter-Methods to come. 
		$this->imageWidthPX = 1200;
		$this->imageHeightPX = 850;
		$this->yAxisRange = 219;
		
		$this->circleOutlineStyle = 'solid';
		$this->circleOutlineWith = 3.5;
		$this->circleDiameter = 18;
		
	}

	function getLeveragePosition($limit = 100, $leverageFactor = 100){
		return ((($limit - 100) * (($leverageFactor / 100) - 1)) + $limit);
	}

	function setProductTypeProperty($property, $value) {
	
		switch($property) {
		
			case 'Fixed return amount percentage':
				$this->fixedReturnAmountPercentage = $value;
			break;
		
			case 'Upside srtike level':
				$this->upsideStrikeLevel = $value;
			break;
			
			case 'Upper leverage factor':
				$this->upperLeverageFactor = $value;
			break;
			
			case 'Additional upper participation terminology':
				$this->additionalUpperParticipationTerminology = $value;
			break;
			
			case 'Leverage annotation position':
				$this->x_leveragePosition = $value;
			break;
			
			case 'Upper leverage annotation position':
				$this->x_upperLeveragePosition = $value;
			break;

			case 'Additional upside strike level':
				$this->additionalUpsideStrikeLevel = $value;
			break;
		
			case 'Fixed return amount terminology':
				$this->fixedReturnAmountTerminology = $value;
			break;
		
			case 'Absolute Return terminology':
				$this->absoluteReturnTerminology = $value;
			break;
		
			case 'KO occurred':
				$this->KnockOutOccurredTerminology = $value;
			break;
		
			case 'KO not occurred':
				$this->KnockOutNotOccurredTerminology = $value;
			break;

			case 'Maximum return amount percentage':
				$this->maximumReturnAmountPercentage = $value;
			break;

			case 'Maximum return amount terminology':
				$this->maximumReturnAmountTerminology = $value;
			break;

			case 'Participation terminology':
				$this->participationZoneTerminology = $value;
			break;
			
			case 'Maximum return amount percentage upper':
				$this->maximumReturnAmountPercentageUpper = $value;
			break;

			case 'Buffer terminology':
				$this->bufferZoneTerminology = $value;
			break;

			case 'Barrier terminology':
				$this->barrierZoneTerminology = $value;
			break;

			case 'Absolute return terminology':
				$this->absoluteReturnZoneTerminology = $value;
			break;
			
			case 'Leverage factor':
				$this->leverageFactor = $value;
				break;
			
			case 'Buffer percentage':
				$this->bufferPercentage = $value;
				break;
			
			case 'Minimum payment terminology':
				$this->minimumPaymentAtMaturityTerminology = $value;
				break;

			case 'Barrier percentage':
				$this->barrierPercentage = $value;
				break;
				
				

		}
	
	}
	
	function setProductType($productType) {
	
		$this->productType = $productType;
	
	}
	
	function setIssuerSchema($issuerSchema) {
	
		$this->issuerSchema = $issuerSchema;
		
		$this->__setPlotPropertiesForIssuerSchema();
	
	}
		
	function __setPlotPropertiesForIssuerSchema() {

		if($this->issuerSchema == NULL)
			trigger_error('payoffChartClass: no issuer schema specified', E_USER_ERROR);
	
		switch($this->issuerSchema) {

			
			case 'Citi blue':
			case 'MS blue':
			case 'Marketing sheet':
				$this->underlyingLineColor = array(0, 0, 0);
				$this->underlyingLineWeight = 5;
				$this->underlyingLineStyle = 'solid';
				$this->derivativeLineWeight = 5;
				$this->derivativeLineStyle = 'solid';
				$this->polygonOutlineAlpha = 255;
				$this->polygonOutlineWeight = 1;
				$this->polygonOutlineStyle = 'solid';
				$this->polygonFillAlpha = 255;
				$this->highlightAreasWhereUnderlyingOutperformsDerivative = false;
			break;
			
			
			default:
				trigger_error('payoffChartClass: issuer invalid schema', E_USER_ERROR);
		
		}
		
		switch($this->issuerSchema) {
			

			case 'Citi blue':
			case 'MS blue':
			case 'Marketing sheet':
				$this->derivativeLineColor = array(34, 146, 208);
				$this->polygonOutlineColor = array(34, 146, 208);
				//$this->polygonFillColor = array(220, 235, 244);
				$this->polygonFillColor = array(255, 255, 0);
			break;
			
		}
	
		$this->initializeTerminology();
	}

	function initializeTerminology() {
		
		global $manager;
		
		if($this->issuerSchema == NULL)
			trigger_error('payoffChartClass: no issuer schema specified', E_USER_ERROR);
	
		
		switch($this->issuerSchema) {

			case 'Citi blue':
				$this->showAnnotations = true;
				$this->statedPrincipalAmountTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema(100)*$this->denomination, ',##0.00') . "\n" . 'Stated Principal Amount';
				$this->bufferZoneTerminology = 'Buffer Zone';	
				$this->barrierZoneTerminology = 'Barrier Zone';
				$this->digitalZoneTerminology = 'Digital Zone';
				$this->participationZoneTerminology = 'Participation' . "\n" . 'Zone';
				if(stristr($this->productType, 'Participation')) { // What Citi calls the maximum return return at maturity in a participation structure, we call the fixed return amount
					if($manager->getElement('Distribution channel') == 'GS')
						$this->fixedReturnAmountTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema($this->fixedReturnAmountPercentage)*$this->denomination, ',##0.00');
					else
						$this->fixedReturnAmountTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema($this->fixedReturnAmountPercentage)*$this->denomination, ',##0.00') . "\n" . '($' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema(100)*$this->denomination, ',##0.00') . ' plus' . "\n" . 'Maximum Payment at Maturity)';
					} else
						$this->fixedReturnAmountTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema($this->fixedReturnAmountPercentage)*$this->denomination, ',##0.00');
						//$this->fixedReturnAmountTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema($this->fixedReturnAmountPercentage)*$this->denomination, ',##0.00')."\n" . '($' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema(100)*$this->denomination, ',##0.00') . ' plus' . "\n" . 'Fixed Return Amount)';
				$this->maximumReturnAmountTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema($this->maximumReturnAmountPercentage)*$this->denomination, ',##0.00') . ' Maximum' ."\n" . 'Payment at Maturity';
				$this->minimumReturnAtMaturityTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema(100 - $this->bufferPercentage)*$this->denomination, ',##0.00') . "\n" . 'Minimum Payment' . "\n" . 'at Maturity';
			break;
		
			case 'MS blue':
				
				$this->showAnnotations = true;
				$this->statedPrincipalAmountTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema(100), ',##0.00') . "\n" . 'Stated Principal Amount';
				$this->bufferZoneTerminology = 'Buffer Zone';	
				if(stristr($this->productType, 'Twin win participation'))
					$this->barrierZoneTerminology = ' Unleveraged Trigger Zone';
				else
					$this->barrierZoneTerminology = 'Barrier Zone';
				
				
				$this->digitalZoneTerminology = 'Jump Zone';	
			
				$this->digitalZoneTerminology = 'Digital Zone';	
						
				
				$this->participationZoneTerminology = 'PLUS' . "\n" . 'Zone';
				if(stristr($this->productType, 'Participation')){
					// What Citi calls the maximum return return at maturity in a participation structure, we call the fixed return amount
					$this->fixedReturnAmountTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema($this->fixedReturnAmountPercentage), ',##0.00#') . "\n" . '(Maximum Payment at Maturity)';
				}else if($manager->getElement('Upside style') == 'Digital'){
					$this->fixedReturnAmountTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema($this->fixedReturnAmountPercentage), ',##0.00') . "\n" . '($' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema(100), ',##0.00#') . ' plus' . "\n" . 'Upside Payment)';
				}else{
					$this->fixedReturnAmountTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema($this->fixedReturnAmountPercentage), ',##0.00') . "\n" . '($' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema(100), ',##0.00#') . ' plus' . "\n" . 'Fixed Return Amount)';
				}
				$this->maximumReturnAmountTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema($this->maximumReturnAmountPercentage), ',##0.00#') . ' Maximum' ."\n" . 'Payment at Maturity';
				$this->minimumReturnAtMaturityTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema(100 - $this->bufferPercentage), ',##0.00#') . "\n" . 'Minimum Payment' . "\n" . 'at Maturity';
			break;
			
			case 'Marketing sheet':

				$this->principalProtectionTerminology =  $this->principalProtection.'% Principal Protection';
				$this->statedPrincipalAmountTerminology = '';
				$this->digitalZoneTerminology = 'Digital Level';
				$this->bufferPercentageTerminology = 'Buffer Percentage';
				if(stristr($this->productType, 'Participation')) { // What Citi calls the maximum return return at maturity in a participation structure, we call the fixed return amount
					if($manager->getElementRawValue('Principal protection level')){
						if($manager->doesElementExist('Cap')){
							if($manager->isElementRange('Cap')){
								//$this->fixedReturnAmountTerminology = 'Maximum Redemption Amount' . "\n" . '[' . $this->minCap . '%-' . $this->maxCap . '%]';
								$this->fixedReturnAmountTerminology = 'Maximum Redemption Amount' . "\n" . '[' . ($this->minCap + $this->maxCap) / 2.0 . '%]';
							}else{
								$this->fixedReturnAmountTerminology = 'Maximum Redemption'. "\n" . 'Amount (' . $manager->displayNumber($this->fixedReturnAmountPercentage, ['formatString' => '##0.00#']) . '%)';
							}
						}
					}else{
						$this->fixedReturnAmountTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema($this->fixedReturnAmountPercentage)*$this->denomination, ',##0.00') . "\n" . '($' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema(100)*$this->denomination, ',##0.00') . ' plus' . "\n" . 'Maximum Payment at Maturity)';
					}
				}else{
					$this->fixedReturnAmountTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema($this->fixedReturnAmountPercentage)*$this->denomination, ',##0.00');
				}
				
				$this->minimumReturnAtMaturityTerminology = '$' . wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema(100 - $this->bufferPercentage)*$this->denomination, ',##0.00') . "\n" . 'Minimum Payment' . "\n" . 'at Maturity';

			break;
			
			default:
				trigger_error('payoffChartClass: issuer invalid schema', E_USER_ERROR);
		
		}
	}

	function __adjustXCoordinateForIssuerSchema($xCoordinate) {

		if($this->issuerSchema == NULL)
			trigger_error('payoffChartClass: no issuer schema specified', E_USER_ERROR);
	
		switch($this->issuerSchema) {

			case 'Citi blue':
			case 'Marketing sheet':
				return ($xCoordinate) / 100.0;
			break;

			case 'MS blue':
				return ($xCoordinate - 100) / 100.0;
			break;
			
			default:
				trigger_error('payoffChartClass: issuer invalid schema', E_USER_ERROR);

		}
	}

	function __adjustXEdgesForIssuerSchema($edges) {

		$adjustedEdges = array();		
		foreach($edges as $edge)
			array_push($adjustedEdges, $this->__adjustXCoordinateForIssuerSchema($edge));
		return $adjustedEdges;
	
	}
	
	function __adjustYCoordinateForIssuerSchema($yCoordinate) {

		if($this->issuerSchema == NULL)
			trigger_error('payoffChartClass: no issuer schema specified', E_USER_ERROR);
	
		switch($this->issuerSchema) {

			case 'Citi blue':
			case 'Marketing sheet':
				return $yCoordinate / 100.0; //* $this->denomination;
			break;
			
			case 'MS blue':
				
				switch($this->productType) {
					
					case 'Delta 1':
						return ($yCoordinate - 100) / 100.0;
					break;
					default:
						return $yCoordinate / 100.0 * $this->denomination;
					break;					
					
				}
			break;
			
			default:
				trigger_error('payoffChartClass: issuer invalid schema', E_USER_ERROR);

		}
	}

	function __adjustYEdgesForIssuerSchema($edges) {

		$adjustedEdges = array();		
		foreach($edges as $edge)
			array_push($adjustedEdges, $this->__adjustYCoordinateForIssuerSchema($edge));
		return $adjustedEdges;
	
	}
	
	function __adjustYAxisRange() {
	
		// this should make sure that the "maximum return amount" annotations will be completely within the image
	
		if (stristr($this->productType, 'Twin win') and $this->fixedReturnAmountPercentage / $this->denomination > 0.6) {
		
			$this->yAxisRange = 259;
			
		} elseif ($this->maximumReturnAmountPercentage / $this->denomination > 0.6 or stristr($this->productType, 'Twin win') and $this->fixedReturnAmountPercentage / $this->denomination > 0.5) {
		
			$this->yAxisRange = 249;
			
		} elseif ($this->maximumReturnAmountPercentage / $this->denomination > 0.5 or stristr($this->productType, 'Twin win') and $this->fixedReturnAmountPercentage / $this->denomination > 0.4) {
		
			$this->yAxisRange = 239;
			
		} elseif ($this->maximumReturnAmountPercentage / $this->denomination > 0.4 or stristr($this->productType, 'Twin win') and $this->fixedReturnAmountPercentage / $this->denomination > 0.3) {
		
			$this->yAxisRange = 229;
			
		} else {
		
			$this->yAxisRange = 219;		
			
		}
		
	}

	function setDenomination($denomination) {

		$this->denomination = $denomination;
		
	}
	
	function setXAxisTitle($xAxisTitle) {
	
		$this->xAxisTitle = $xAxisTitle;
	
	}
	
	function setYAxisTitle($yAxisTitle) {
	
		$this->yAxisTitle = $yAxisTitle;
	
	}
	
	function __addPolygon($xEdges, $yEdges) {
	
		$polygon = array();
		
		$polygon['xEdges'] = $xEdges;
		$polygon['yEdges'] = $yEdges;

		array_push($this->polygons, $polygon);

	}
	
	function __createPolygonArray($polygon) {

		$adjustedXEdges = $this->__adjustXEdgesForIssuerSchema($polygon['xEdges']);
		$adjustedYEdges = $this->__adjustYEdgesForIssuerSchema($polygon['yEdges']);
		
		$polygonArray = array();

		foreach($adjustedXEdges as $key => $value) {
			array_push($polygonArray, $adjustedXEdges[$key]);
			array_push($polygonArray, $adjustedYEdges[$key]);
		}
		
		return $polygonArray;
	
	}

	function addDerivative($valueX = [], $valueY = []){

		if(is_numeric($valueX) && is_numeric($valueY)){
			$this->derivative_x = $valueX;
			$this->derivative_y = $valueY;
		}elseif(!is_array($valueX) || !is_array($valueY)){
			trigger_error(print_r('chartClass: Invalid derivative : X = [' . $valueX . '], Y = [' . $valueY . ']', true), E_USER_ERROR); //-teh
		}

		if(count($valueX) != count($valueY)){
			trigger_error(print_r('chartClass: Derivative arrays X and Y doesn\'t have the same lenght : X = [' . count($valueX) . '], Y = [' . count($valueY) . ']', true), E_USER_ERROR); //-teh
		}

		for($i = 0; $i < count($valueX); $i++){
			$this->derivative_x[] = $valueX[$i];
			$this->derivative_y[] = $valueY[$i];
		}

	}

	function addAnnotation($annotation = []){

		$this->annotations[] = $annotation;

	}

	function addVerticalReferenceLine($verticalReferenceLines = []){

		$this->verticalReferenceLines[] = $verticalReferenceLines;

	}

	function addHorizontalReferenceLine($horizontalReferenceLines = []){

		$this->horizontalReferenceLines[] = $horizontalReferenceLines;

	}

	function addAdditionalLine($additionalLines = []){

		$this->additionalLines[] = $additionalLines;

	}

	function addAdditionalLineProperties($array = []){
		$this->additionalLineColor[0] = $array[0];
		$this->additionalLineColor[1] = $array[1];
		$this->additionalLineColor[2] = $array[2];
		$this->additionalLineWeight = $array[3];
		$this->additionalLineStyle = $array[4];

	}
	

	function drawPayoffChart() {
		
		global $manager;

		// $this->__adjustYAxisRange();

		$this->underlying_x = [0, $this->x_limit];
		$this->underlying_y = [0, $this->x_limit];

		$this->chart = wsd_chart_xy_line("", $this->xAxisTitle, $this->yAxisTitle, false);
		$this->chart->overrideTicks(true);
		
		if($this->bufferPercentage != NULL) {
			$tickMarks[] = $this->bufferPercentage / 100.0;
		} else if($this->barrierPercentage != NULL) {
			$tickMarks[] = $this->barrierPercentage / 100.0;
		}
		
		if($this->fixedReturnAmountPercentage != NULL)
			$tickMarks[] = $this->fixedReturnAmountPercentage / 100.0;
		if($this->maximumReturnAmountPercentage != NULL)
			$tickMarks[] = $this->maximumReturnAmountPercentage / 100.0 -1;
		
		sort($tickMarks);

		// $this->chart->setOverrideTicks($tickMarks);

		// $this->chart->overrideTicksYAxis(true, $tickMarks);

		//*********** Payoff performance ***********//
		$previousXCoordinate = -1; // This is necessary because no vertical lines should be drawn in the case of jumps
		$counter = 0;

		foreach($this->derivative_x as $key => $value) {
			if($manager->getElement('MS graph applies')){
				$value -= 100;
			}
			if($previousXCoordinate == $this->derivative_x[$key])
				$counter++;
			$this->chart->plot('Derivative ' . $counter, $this->__adjustXCoordinateForIssuerSchema($this->derivative_x[$key]), $this->__adjustYCoordinateForIssuerSchema($this->derivative_y[$key]), $this->derivativeLineColor[0], $this->derivativeLineColor[1], $this->derivativeLineColor[2], $this->derivativeLineWeight, $this->derivativeLineStyle);
			$previousXCoordinate = $this->derivative_x[$key];
		}

		//*********** Underlying performance ***********//
		foreach($this->underlying_x as $key => $value){
			if($manager->getElement('MS graph applies')){
				$value -= 100;
			}
			$this->chart->plot('Underlying', $this->__adjustXCoordinateForIssuerSchema($this->underlying_x[$key]), $this->__adjustYCoordinateForIssuerSchema($this->underlying_y[$key]), $this->underlyingLineColor[0], $this->underlyingLineColor[1], $this->underlyingLineColor[2], $this->underlyingLineWeight, $this->underlyingLineStyle);
		}

		//*********** Polygons ***********//
		foreach($this->polygons as $polygon){
			$this->chart->addXYPolygonAnnotation($this->__createPolygonArray($polygon), $this->polygonOutlineColor[0], $this->polygonOutlineColor[1], $this->polygonOutlineColor[2], $this->polygonOutlineAlpha, $this->polygonFillColor[0], $this->polygonFillColor[1], $this->polygonFillColor[2], $this->polygonFillAlpha,$this->polygonOutlineLineWeight, $this->polygonOutlineLineStyle, true);
		}

		if ($manager->getElement('Twinwin applies') && $manager->getElement('MS graph applies')) {

			if($manager->getElement('Downside style') == 'OTM put'){
				$downsideLevel = $this->bufferPercentage;
				$lowerCircleLevel = 100;
			}else{
				$downsideLevel = $this->barrierPercentage;
				$lowerCircleLevel = $this->barrierPercentage;
			}

			$shape = $this->chart->createCircle(
			
				$this->__adjustXCoordinateForIssuerSchema($downsideLevel) - ($this->__adjustXCoordinateForIssuerSchema(200)/$this->imageHeightPX) * $this->circleDiameter/2,
				$this->__adjustYCoordinateForIssuerSchema(100 + 100 - $downsideLevel) - ($this->__adjustYCoordinateForIssuerSchema($this->yAxisRange)/$this->imageWidthPX) * $this->circleDiameter/2 - $this->__adjustYCoordinateForIssuerSchema(2),
				($this->__adjustXCoordinateForIssuerSchema(200)/$this->imageHeightPX) * $this->circleDiameter,
				($this->__adjustYCoordinateForIssuerSchema($this->yAxisRange)/$this->imageWidthPX) * 2 * $this->circleDiameter
				
			);
				
			$this->chart->addXYShapeAnnotation($shape, $this->polygonOutlineColor[0], $this->polygonOutlineColor[1], $this->polygonOutlineColor[2], 255, $this->polygonOutlineColor[0], $this->polygonOutlineColor[1], $this->polygonOutlineColor[2], 255, $this->circleOutlineWith, $this->circleOutlineStyle, true);
			
			$shape = $this->chart->createCircle(
			
				$this->__adjustXCoordinateForIssuerSchema($downsideLevel) - ($this->__adjustXCoordinateForIssuerSchema(200)/$this->imageHeightPX) * $this->circleDiameter/2,
				$this->__adjustYCoordinateForIssuerSchema($lowerCircleLevel) - ($this->__adjustYCoordinateForIssuerSchema($this->yAxisRange)/$this->imageWidthPX) * $this->circleDiameter/2 - $this->__adjustYCoordinateForIssuerSchema(2),
				($this->__adjustXCoordinateForIssuerSchema(200)/$this->imageHeightPX) * $this->circleDiameter,
				($this->__adjustYCoordinateForIssuerSchema($this->yAxisRange)/$this->imageWidthPX) * $this->circleDiameter*2
				
			);
				
			$this->chart->addXYShapeAnnotation($shape, $this->polygonOutlineColor[0], $this->polygonOutlineColor[1], $this->polygonOutlineColor[2], 255, 255, 255, 255, 255, $this->circleOutlineWith, $this->circleOutlineStyle, true);

		}

		if($this->showAnnotations) {
			
			foreach($this->annotations as $annotation) {

				switch($annotation['type']){
					
					case 'AnnotationWithoutPointer':
						if($this->$annotation['terminology'] == $this->$statedPrincipalAmountTerminology){
							$this->chart->addNonPointerAnnotation(
								$annotation['terminology'], 'Arial', 0, 24,
								$this->__adjustXCoordinateForIssuerSchema($annotation['x']), $this->__adjustYCoordinateForIssuerSchema($annotation['y']),
								0, 0, 0, 255, 255, 255, 
								0, $annotation['pointerLength']+5, $annotation['pointerAngle'], $annotation['pointerOrientation'], 5);
						}else{
							$this->chart->addNonPointerAnnotation(
								$annotation['terminology'], 'Arial', 0, 24,
								$this->__adjustXCoordinateForIssuerSchema($annotation['x']), $this->__adjustYCoordinateForIssuerSchema($annotation['y']),
								0, 0, 0, 255, 255, 255,
								0, $annotation['pointerLength']+5, $annotation['pointerAngle'], $annotation['pointerOrientation'], 5);
						}
					break;

					case 'M-Note':
						$this->chart->addPointerAnnotation(
							$annotation['terminology'], 'Arial', 50, 22,
							$this->__adjustXCoordinateForIssuerSchema($annotation['x']), $this->__adjustYCoordinateForIssuerSchema($annotation['y']),
							0, 0, 0, 255, 255, 255, 
							0, $annotation['pointerLength']+5, $annotation['pointerAngle'], $annotation['pointerOrientation'], 5);
							
					break;
					
					default:

						if($annotation['terminology'] == $this->statedPrincipalAmountTerminology){
							$this->chart->addPointerAnnotation(
								$annotation['terminology'], 'Arial', 50, 24,
								$this->__adjustXCoordinateForIssuerSchema($annotation['x']), $this->__adjustYCoordinateForIssuerSchema($annotation['y']),
								0, 0, 0, 0, 0, 0, 
								0, $annotation['pointerLength']+5, $annotation['pointerAngle'], $annotation['pointerOrientation'], 5);
						}else{
							$this->chart->addPointerAnnotation(
								$annotation['terminology'], 'Arial', 0, 22,
								$this->__adjustXCoordinateForIssuerSchema($annotation['x']), $this->__adjustYCoordinateForIssuerSchema($annotation['y']),
								0, 0, 0, 0, 0, 0, 
								0, $annotation['pointerLength']+5, $annotation['pointerAngle'], $annotation['pointerOrientation'], 5);
						}
					break;
				}

			}
		}

		foreach($this->horizontalReferenceLines as $key => $value) {
			$this->chart->plot('Horizontal reference lines ' . $key, $this->__adjustXCoordinateForIssuerSchema(0), $this->__adjustYCoordinateForIssuerSchema($value[1]), 0, 0, 0, 1, 'dashed');
			$this->chart->plot('Horizontal reference lines ' . $key, $this->__adjustXCoordinateForIssuerSchema($value[0]), $this->__adjustYCoordinateForIssuerSchema($value[1]), 0, 0, 0, 1, 'dashed');
		}

		foreach($this->verticalReferenceLines as $key => $value) {	
			$this->chart->plot('Vertical reference lines ' . $key, $this->__adjustXCoordinateForIssuerSchema($value[0]), $this->__adjustYCoordinateForIssuerSchema($value[1]), 0, 0, 0, 1, 'dashed');
			$this->chart->plot('Vertical reference lines ' . $key, $this->__adjustXCoordinateForIssuerSchema($value[0]), $this->__adjustYCoordinateForIssuerSchema(0), 0, 0, 0, 1, 'dashed');
		}

		foreach($this->additionalLines as $key => $value) {
			$this->chart->plot('Additional line ' . $key, $this->__adjustXCoordinateForIssuerSchema(0), $this->__adjustYCoordinateForIssuerSchema($value[1]), $this->additionalLineColor[0], $this->additionalLineColor[1], $this->additionalLineColor[2], $this->additionalLineWeight, $this->additionalLineStyle);
			$this->chart->plot('Additional line ' . $key, $this->__adjustXCoordinateForIssuerSchema($value[0]), $this->__adjustYCoordinateForIssuerSchema($value[1]), $this->additionalLineColor[0], $this->additionalLineColor[1], $this->additionalLineColor[2], $this->additionalLineWeight, $this->additionalLineStyle);
		}

		$this->chart->setTitleAndFont("", "Arial", 0, 30);
		$this->chart->setXAxisLabelFont("Arial", 0, 20);
		$this->chart->setXAxisLegendFont("Arial", 0, 28);
		$this->chart->setYAxisLabelFont("Arial", 0, 20);
		$this->chart->setYAxisLegendFont("Arial", 0, 28);
	
		$this->chart->setBackgroundRGB(255, 255, 255);
		
		$this->chart->setAxisOffsets(0.0, 0.0, 0.0, 0.0);

		$this->chart->setYAxisFormat("#0.##%");
		$this->chart->setXAxisFormat("#0.##%");

		$this->chart->setYAxisInterval(0.5);
		$this->chart->setXAxisInterval(0.1);

		$this->chart->rotateXLabelsUp();
		
		if($manager->getElement('MS graph applies')){

			$this->chart->overrideTicksYAxis(true);

			$tickMarks = [-1, -0.75, -0.50, -0.25, 0, 0.25, 0.50, 0.75, 1.00];
			$y_tickMarks = [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 1600, 1700, 1800, 1900, 2000];

			// $features = [
			// 	/* $this->barrierPercentage / 100,
			// 	$this->bufferPercentage / 100, */
			// 	$this->maximumReturnAmountPercentage / 100,
			// 	$this->fixedReturnAmountPercentage / 100,
			// ];

			
			if($manager->getElement('Upside style') == 'Digital'){
				$addedXFeatures[] = $this->fixedReturnAmountPercentage ? $this->fixedReturnAmountPercentage / 100 : NULL;
			}
			
			$addedXFeatures[] = $this->maximumReturnAmountPercentage ? $this->maximumReturnAmountPercentage / 100 : NULL;
			$addedXFeatures[] = $this->barrierPercentage ? $this->barrierPercentage / 100 : NULL;
			$addedXFeatures[] = $this->bufferPercentage ? $this->bufferPercentage / 100 : NULL;

			foreach($addedXFeatures as $feature){
				$tickMarks[] = $feature - 1;

				foreach ($tickMarks as $key => $value) {

					if (abs(($feature - 1) - $value) <= 0.05) {
						unset($tickMarks[$key]);
						$tickMarks[] = $feature - 1;
					}
				}
			}

			// foreach($addedYFeatures as $feature){
			// 	$y_tickMarks[] = $feature * 1000;

			// 	foreach ($y_tickMarks as $key => $value) {

			// 		if (abs(($feature * 1000) - $value) <= 45) {
			// 			unset($y_tickMarks[$key]);
			// 			$y_tickMarks[] = $feature * 1000;
			// 		}
			// 	}
			// }

			$tickMarks = array_unique($tickMarks);
			sort($tickMarks);

			$y_tickMarks = array_unique($y_tickMarks);
			sort($y_tickMarks);
			

			$this->chart->setOverrideTicks($tickMarks);
			$this->chart->overrideTicksYAxis(true, $y_tickMarks);

			// // overrideTicksYAxis resets a lot of stuff, so the below methods has to be placed here
			$this->chart->setYAxisFormat("$###0");
			$this->chart->setXAxisFormat("#0.##%");

			$this->chart->setXAxisInterval(1000);
			$this->chart->setYAxisInterval(5000);

			$this->chart->setYAxisLabelFont("Arial", 0, 20);
			$this->chart->setYAxisLegendFont("Arial", 0, 23);

		}

		if($manager->getElement('Goldman graph applies')){

			$this->chart->overrideTicksYAxis(true);

			$tickMarks = $y_tickMarks = [0.00, 0.25, 0.50, 0.75, 1.00, 1.25, 1.50, 1.75, 2.00];

			$y_tickMarks[] = $this->fixedReturnAmountPercentage / 100;

			$features = [
				$this->barrierPercentage / 100,
				$this->bufferPercentage / 100,
				$this->maximumReturnAmountPercentage / 100
			];

			if($manager->getElement('Upside style') == 'Digital'){
				$features[] = $this->fixedReturnAmountPercentage / 100;
			}

			$addedFeatures = array_filter($features, function($value) {
				return is_numeric($value) && $value != 0 && $value != 1;
			});

			foreach($addedFeatures as $feature){
				$tickMarks[] = $feature;

				foreach ($tickMarks as $key => $value) {
					
					if (abs($feature - $value) <= 0.05) {
						unset($tickMarks[$key]);
						$tickMarks[] = $feature;
					}
				}
			}

			foreach ($y_tickMarks as $key => $value) {
					
				if (abs(($this->fixedReturnAmountPercentage / 100) - $value) < 0.05) {
					unset($y_tickMarks[$key]);
					$y_tickMarks[] = $this->fixedReturnAmountPercentage / 100;
				}
			}

			$tickMarks = array_unique($tickMarks);
			sort($tickMarks);

			$y_tickMarks = array_unique($y_tickMarks);
			sort($y_tickMarks);
			

			$this->chart->setOverrideTicks($tickMarks);
			$this->chart->overrideTicksYAxis(true, $y_tickMarks);

			// // overrideTicksYAxis resets a lot of stuff, so the below methods has to be placed here
			$this->chart->setYAxisFormat("#0.00##%");
			$this->chart->setXAxisFormat("#0.00%");

			$this->chart->setXAxisInterval(1000);
			$this->chart->setYAxisInterval(1000);

			$this->chart->setYAxisLabelFont("Arial", 0, 20);
			$this->chart->setYAxisLegendFont("Arial", 0, 23);

		}

		$this->chart->setYAxisRange($this->__adjustYCoordinateForIssuerSchema(0), $this->__adjustYCoordinateForIssuerSchema($this->x_limit));
		$this->chart->setXAxisRange($this->__adjustXCoordinateForIssuerSchema(0), $this->__adjustXCoordinateForIssuerSchema($this->x_limit));

		if($manager->getElement('Goldman graph applies') || $manager->getElement('MS graph applies')){
			echo wsd_chart_draw($this->chart, 590, 380, 1200, 850);
		}else{
			echo wsd_chart_draw($this->chart, 550, 450, 1100, 900);
		}
	}

}

?>
