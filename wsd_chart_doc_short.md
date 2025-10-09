Cria ou printa objetos:

1. wsd_chart_draw($chart, 500, 500);

2. wsd_chart_bar_vertical(“Title of chart”, “Description of horizontal axis”, “Description of vertical axis”, true);
Metodos do objeto de retorno do wsd_chart_bar_vertical:
    2.1 setBackgroundRGB(255, 255, 255);
    2.2 setShadow(false);
    2.3 setBarOutline(false);
    2.4 setGradient(false);
    2.5 setXAxisGridline(1, "solid", 0, 0, 0);
    2.6 setXAxisGridlineOff();
    2.7 setYAxisGridline(1, "solid", 0, 0, 0);
    2.8 setYAxisGridlineOff();
    2.9 plot($series1, $category1, 1.0);
    2.10 setColor(0, 255, 0, 0);
    2.11 rotateXLabelsUp(true);
    2.12 rotateXLabelsDown(true);
    2.13 rotateXLabelsUp(false);
    2.14 rotateXLabelsDown(false);
    2.15 addMarker(9, 1, 'solid', 0, 0, 0);

3. wsd_chart_xy_line(“Title of chart”, “Description of horizontal axis”, “Description of vertical axis”, true);
Metodos do objeto de retorno do wsd_chart_xy_line:
    setBackgroundRGB(255, 255, 255);
    setXAxisGridlineOff();
    setYAxisGridline(0.5, “solid”, 0, 0, 0);
    plot(“Upward sloping line”, 0, 0);
    setXAxisRange(0, 100);
    setXAxisInterval(10);
    setYAxisRange(0, 100);
    setYAxisInterval(20);
    setXAxisFormat(“#”);
    setYAxisFormat(“#”);
    overrideTicks(true);
    setOverrideTicks($tickMarks);
    overrideTicksYAxis(true, $tickMarks);
    
    addXYPolygonAnnotation($this->__createPolygonArray($polygon), $this->polygonOutlineColor[0], $this->polygonOutlineColor[1], $this->polygonOutlineColor[2], $this->polygonOutlineAlpha, $this->polygonFillColor[0], $this->polygonFillColor[1], $this->polygonFillColor[2], $this->polygonFillAlpha,$this->polygonOutlineLineWeight, $this->polygonOutlineLineStyle, true);
    
    createCircle(
        $this->__adjustXCoordinateForIssuerSchema($downsideLevel) - ($this->__adjustXCoordinateForIssuerSchema(200)/$this->imageHeightPX) * $this->circleDiameter/2,
        $this->__adjustYCoordinateForIssuerSchema(100 + 100 - $downsideLevel) - ($this->__adjustYCoordinateForIssuerSchema($this->yAxisRange)/$this->imageWidthPX) * $this->circleDiameter/2 - $this->__adjustYCoordinateForIssuerSchema(2),
        ($this->__adjustXCoordinateForIssuerSchema(200)/$this->imageHeightPX) * $this->circleDiameter,
        ($this->__adjustYCoordinateForIssuerSchema($this->yAxisRange)/$this->imageWidthPX) * 2 * $this->circleDiameter
        );
    
    addXYShapeAnnotation($shape, $this->polygonOutlineColor[0], $this->polygonOutlineColor[1], $this->polygonOutlineColor[2], 255, $this->polygonOutlineColor[0], $this->polygonOutlineColor[1], $this->polygonOutlineColor[2], 255, $this->circleOutlineWith, $this->circleOutlineStyle, true);
    
    addNonPointerAnnotation($annotation['terminology'], 'Arial', 0, 24,
    $this->__adjustXCoordinateForIssuerSchema($annotation['x']), $this->__adjustYCoordinateForIssuerSchema($annotation['y']), 0, 0, 0, 255, 255, 255, 0, $annotation['pointerLength']+5, $annotation['pointerAngle'], $annotation['pointerOrientation'], 5);

    addPointerAnnotation($annotation['terminology'], 'Arial', 50, 22,
    $this->__adjustXCoordinateForIssuerSchema($annotation['x']), $this->__adjustYCoordinateForIssuerSchema($annotation['y']), 0, 0, 0, 255, 255, 255, 0, $annotation['pointerLength']+5, $annotation['pointerAngle'], $annotation['pointerOrientation'], 5);

    setTitleAndFont("", "Arial", 0, 30);
    setXAxisLabelFont("Arial", 0, 20);
    setXAxisLegendFont("Arial", 0, 28);
    setYAxisLabelFont("Arial", 0, 20);
    setYAxisLegendFont("Arial", 0, 28);
    setAxisOffsets(0.0, 0.0, 0.0, 0.0);
    rotateXLabelsUp();


4. wsd_chart_xy_line_date($yAxisTitle, $xAxisTitle, $chartTitle, false, "MMM-yy");
Metodos do objeto de retorno do wsd_chart_xy_line_date:
    setTitleAndFont("", "Arial", 0, 15);
    overrideTicksDates(true, NULL, "CENTER_RIGHT", "CENTER_RIGHT", -0.7853981633974483);
    setOverrideTicksDates($dates);
    plotDate("Closing price", $x, $y, 91, 135, 43, 2.5, 'solid');
    
    addYMarker($manager->getElementRawValue($underlying['Ticker'] . ': Coupon barrier level') * $underlying['Close'][$manager->getElementRawValue('Last historical prices date')], 3, 'solid', 255, 0, 0);
    
    setBackgroundRGB(255, 255, 255);
    setXAxisGridlineOff();
    setYAxisGridline(1, "solid", 150, 150, 150);
    setDateAxisRange(date("Y-m-d", $firstPlotDate), date("Y-m-d", $lastClosingPriceDate));
    setMonthlyTickUnit(150);
    setYAxisRange(0, $y_max + $y_max_adjust);
    setYAxisInterval($y_interval);
    setYAxisFormat($yAxisFormat);
    setXAxisLabelFont("Arial", 1, 20);
    setYAxisLabelFont("Arial", 1, 22);
    setYAxisLegendFont("Arial", 1, 20);
    setXAxisLegendFont("Arial", 1, 20);
    setAxisOffsets(0.0, 0.0, 0.0, 20);
    rotateXLabelsUp();

5. wsd_mktime(0, 0, 0, 1, date('j',$underlying['Last historical close prices date']), date('Y', $underlying['Last historical close prices date']) - 10);

6. wsd_decimal_format($this->__adjustYCoordinateForIssuerSchema(100)*$this->denomination, ',##0.00') . "\n" . 'Stated Principal Amount';

