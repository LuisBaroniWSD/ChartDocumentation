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

// For your desired use, extend your class from the chartClass, to make use of the functions implemented there
class payoffChartClass extends chartClass {
	// Like this
}

?>
