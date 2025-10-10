<?php

function addTextAnnotation($chart, $text, $font, $style, $size, $x, $y, $r, $g, $b) {
    // Calculate y positions for each line
    $textHeight = ((getTextHeight($text, $size)-8) * 200) / 500; // Normalized for graph dimensions
    $lines = countLines($text);
    $topY = ($y*100 + ($textHeight / 2)) / 100; // Percentage format

    $sizeNormalized = ((($size + 2) * 200) / 500); // Normalized font size for graph dimensions with 2 pixels for line spacing
    $sizeNormalized /= 100; // Percentage format

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

function countLines($text) {
    $temp = $text;
    $counter = 1;

    for ($i=0; strstr($temp, '\n'); $i+=strlen($temp) - strlen(strstr($temp, '\n'))) {
        $temp = substr($temp, strpos($temp, '\n') + 1);
        $counter++;
    }

    //trigger_error(print_r($counter, true), E_USER_ERROR); //-teh

    return $counter;
}

function getTextHeight($text, $size) {
    return countLines($text)*($size+2); // Adding 2 pixels for line spacing
}

function maxWordLength($text) {
    $str = str_replace('\n', " ", $text);
    //trigger_error(print_r($str, true), E_USER_ERROR); //-teh
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
        //trigger_error(print_r(1, true), E_USER_ERROR); //-teh
        return maxWordLength($text) * $charWidth;
    }
}

function addBoxedTextAnnotation($chart, $text, $font, $style, $size, $x, $y, $r, $g, $b, $bgR, $bgG, $bgB, $bgA, $padding=4) {
    // Get text height and width
    $textHeight = getTextHeight($text, $size);
    
    $charWidth = 0.75 * $size; // Ajust multiplier to fit your font
    $textWidth = getTextWidth($text, $charWidth);
    
    //trigger_error(print_r($textWidth . "---" . $charWidth*strlen($text), true), E_USER_ERROR); //-teh
    
    // Add padding
    $boxWidth = $textWidth + 4 * $padding; // padding in pixels
    $boxHeight = $textHeight + 4 * $padding;

    // Normalize coordinates
    $boxHeightNormalized = ($boxHeight * 200) / 500;
    $boxWidthNormalized = ($boxWidth * 200) / 800;

    // Calculate box position
    $boxX = $x*100 - ($boxWidthNormalized / 2);
    $boxY = $y*100 - ($boxHeightNormalized / 2);

    // Draw rectangle (box)
    $chart->addXYPolygonAnnotation(
        [$boxX/100, $boxY/100, $boxX/100, $boxY/100 + $boxHeightNormalized/100, 
        $boxX/100, $boxY/100 + $boxHeightNormalized/100, $boxX/100 + $boxWidthNormalized/100, $boxY/100 + $boxHeightNormalized/100,
        $boxX/100 + $boxWidthNormalized/100, $boxY/100 + $boxHeightNormalized/100, $boxX/100 + $boxWidthNormalized/100, $boxY/100,
        $boxX/100 + $boxWidthNormalized/100, $boxY/100, $boxX/100, $boxY/100],
        1, 1, 1, 255,
        255, 255, 255, 255,
        1, "solid", true
    );

    // Add text on top of the box
    addTextAnnotation(
        $chart,
        $text,
        $font,
        $style,
        $size,
        $x,
        $y,
        $r, $g, $b
    );
}

// X axis
$xAxisStart = 0;
$xAxisEnd = 200 / 100; // Divided by 100 for percentage format
$xAxisInterval = 50 / 100; // Divided by 100 for percentage format
$xAxisFormat = "#.00%";

// Y axis
$yAxisStart = 0;
$yAxisEnd = 200 / 100; // Divided by 100 for percentage format
$yAxisInterval = 50 / 100; // Divided by 100 for percentage format
$yAxisFormat = "#%";

$chart = wsd_chart_xy_line("", "Hypothetical Final Index Level as % of Initial Index Level", "Hypothetical Cash Settlement Amount as % of Face Amount", true);

$chart->setBackgroundRGB(255, 255, 255);

$chart->setXAxisGridline(1, "dotted", 205, 205, 205);
$chart->setXAxisRange($xAxisStart, $xAxisEnd);
$chart->setXAxisInterval($xAxisInterval);
$chart->setXAxisFormat($xAxisFormat);

$chart->setYAxisGridline(1, "dotted", 205, 205, 205);
$chart->setYAxisRange($yAxisStart, $yAxisEnd);
$chart->setYAxisInterval($yAxisInterval);
$chart->setYAxisFormat($yAxisFormat);

$chart->setAxisOffsets(0, 0, 0, 20); // Right offset to accommodate x axis format

// Underlying Performance line
$chart->plot("Underlying Performance", $xAxisStart, $yAxisStart, 1, 1, 1, 1, "dashed");
$chart->plot("Underlying Performance", $xAxisEnd, $yAxisEnd, 1, 1, 1, 1, "dashed");

// PLUS line
$chart->plot("PLUS", $xAxisStart, $yAxisStart, 255, 1, 1, 3, "solid");
$chart->plot("PLUS", (100 / 100), (100 / 100), 255, 1, 1, 3, "solid"); // Line go to x=100% and y=100%
$chart->plot("PLUS", (106.834 / 100), (120.500 / 100), 255, 1, 1, 3, "solid"); // Line go to x=106.834% and y=120.500%
$chart->plot("PLUS", $xAxisEnd, (120.500 / 100), 255, 1, 1, 3, "solid"); // Line go to x=200.000% and y=120.500%

// Barriers lines
$chart->addXYPolygonAnnotation(
  [(1 / 100), (100 / 100), (100 / 100), (100 / 100)],  // x1, y1, x2, y2 (1 in x1 instead of $xAxisStart cuz of a bug)
  100, 100, 200, 255,  // RGBA
  0, 0, 0, 0,  // Fillings RGBA
  1, "dashed", true  // Width, style and background or not
);

$chart->addXYPolygonAnnotation(
  [(100 / 100), (100 / 100), (100 / 100), $yAxisStart],
  100, 100, 200, 255,
  0, 0, 0, 0,
  1, "dashed", true
);

$chart->addXYPolygonAnnotation(
  [$xAxisStart, (120.500 / 100), (106.834 / 100), (120.500 / 100)],
  100, 100, 200, 255,
  0, 0, 0, 0,
  1, "dashed", true
);

$chart->addXYPolygonAnnotation(
  [(106.834 / 100), (120.500 / 100), (106.834 / 100), $yAxisStart],
  100, 100, 200, 255,
  0, 0, 0, 0,
  1, "dashed", true
);

// Triangle shape
$chart->addXYPolygonAnnotation(
    [(100 / 100), (100 / 100), (106.834 / 100), (120.500 / 100), (120.500 / 100), (120.500 / 100)], // xa, ya, xb, yb, xc, yc
    // Similar color to the one used in the document
    95, 140, 220, 255,
    95, 140, 220, 255,
    2, "solid", true
);

// Text Annotations
addBoxedTextAnnotation($chart, "100.000%", "Arial", 1, 12, (50 / 100) / 2, (100 / 100), 0, 0, 0, 255, 255, 255, 255, 4);
addBoxedTextAnnotation($chart, "120.500%", "Arial", 1, 12, (50 / 100 + 100 / 100) / 2, (120.500 / 100), 0, 0, 0, 255, 255, 255, 255, 4);
addBoxedTextAnnotation($chart, "106.834%", "Arial", 1, 12, (106.834 / 100), (70 / 100), 0, 0, 0, 255, 255, 255, 255, 4);
addBoxedTextAnnotation($chart, "100.000%", "Arial", 1, 12, (100 / 100), (30 / 100), 0, 0, 0, 255, 255, 255, 255, 4);
addBoxedTextAnnotation($chart, '$1,000\nStated\nPrincipal\nAmount', "Arial", 1, 12, (100 / 100), (160 / 100), 0, 0, 0, 255, 255, 255, 255, 4);

echo wsd_chart_draw($chart, 800, 500); // Apparently the width and height are correctly set here

?>
