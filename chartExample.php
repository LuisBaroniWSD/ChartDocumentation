<?php
// Taglib: <Display: charts testings>

// X axis
$xAxisStart = 0;
$xAxisEnd = 2; // Divided by 100 for percentage format
$xAxisInterval = 0.5; // Divided by 100 for percentage format
$xAxisFormat = "0.00%";

// Y axis
$yAxisStart = 0;
$yAxisEnd = 2; // Divided by 100 for percentage format
$yAxisInterval = 0.5; // Divided by 100 for percentage format
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

// PLUS line
$chart->plot("PLUS", $xAxisStart, $yAxisStart, 255, 1, 1, 3, "solid");
$chart->plot("PLUS", 1, 1, 255, 1, 1, 3, "solid"); // Line go to x=100% and y=100%
$chart->plot("PLUS", 1.06834, 1.20500, 255, 1, 1, 3, "solid"); // Line go to x=106.834% and y=120.500%
$chart->plot("PLUS", $xAxisEnd, 1.20500, 255, 1, 1, 3, "solid"); // Line go to x=200.000% and y=120.500%

// Underlying Performance line
$chart->plot("Underlying Performance", $xAxisStart, $yAxisStart, 1, 1, 1, 1, "dashed");
$chart->plot("Underlying Performance", $xAxisEnd, $yAxisEnd, 1, 1, 1, 1, "dashed");

// Barriers lines
$chart->addXYPolygonAnnotation(
  [0.01, 1, 1, 1],  // x1, y1, x2, y2 (0.01 in x1 instead of $xAxisStart cuz of a bug)
  100, 100, 200, 255,  // RGBA
  0, 0, 0, 0,  // Fillings RGBA
  1, "dashed", true  // Width, style and background or not
);

$chart->addXYPolygonAnnotation(
  [1, 1, 1, $yAxisStart],
  100, 100, 200, 255,
  0, 0, 0, 0,
  1, "dashed", true
);

$chart->addXYPolygonAnnotation(
  [$xAxisStart, 1.20500, 1.06834, 1.20500],
  100, 100, 200, 255,
  0, 0, 0, 0,
  1, "dashed", true
);

$chart->addXYPolygonAnnotation(
  [1.06834, 1.20500, 1.06834, $yAxisStart],
  100, 100, 200, 255,
  0, 0, 0, 0,
  1, "dashed", true
);

// Triangle shape
$chart->addXYPolygonAnnotation(
    [1, 1, 1.06834, 1.20500, 1.20500, 1.20500], // xa, ya, xb, yb, xc, yc
    // Similar color to the one used in the document
    95, 140, 220, 255,
    95, 140, 220, 255,
    2, "solid", true
);

$chartManager = new chartClass(); // For use of custom functions, not present in the java side of the library

// Text Annotations
$chartManager->addBoxedTextAnnotation($chart, "100.000%", "Arial", 0, 12, 0.75, 0.5 / 2, 1, $xAxisEnd, $yAxisEnd, 800, 500, 0, 0, 0, 255, 255, 255, 255, 1, 1, 1, 4);
$chartManager->addBoxedTextAnnotation($chart, "120.500%", "Arial", 0, 12, 0.75, (0.5 + 1) / 2, 1.20500, $xAxisEnd, $yAxisEnd, 800, 500, 0, 0, 0, 255, 255, 255, 255, 1, 1, 1, 4);
$chartManager->addBoxedTextAnnotation($chart, "106.834%", "Arial", 0, 12, 0.75, 1.06834, 0.7, $xAxisEnd, $yAxisEnd, 800, 500, 0, 0, 0, 255, 255, 255, 255, 1, 1, 1, 4);
$chartManager->addBoxedTextAnnotation($chart, "100.000%", "Arial", 0, 12, 0.75, 1, 0.3, $xAxisEnd, $yAxisEnd, 800, 500, 0, 0, 0, 255, 255, 255, 255, 1, 1, 1, 4);
$chartManager->addBoxedTextAnnotation($chart, '$1,000\nStated\nPrincipal\nAmount', "Arial", 0, 12, 0.75, 1, 1.6, $xAxisEnd, $yAxisEnd, 800, 500, 0, 0, 0, 255, 255, 255, 255, 1, 1, 1, 4);

echo wsd_chart_draw($chart, 800, 500); // Apparently the width and height are correctly set here

?>