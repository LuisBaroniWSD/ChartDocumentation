package com.wsd.priip.script.quercus.modules;

import java.util.Arrays;
import java.util.Date;
import java.util.Iterator;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import java.awt.BasicStroke;
import java.awt.Color;
import java.awt.Font;
import java.awt.Shape;
import java.awt.Stroke;
import java.awt.geom.Ellipse2D;
import java.awt.geom.Rectangle2D;
import java.awt.geom.RoundRectangle2D;
import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.math.BigDecimal;
import java.text.DecimalFormat;
import java.text.NumberFormat;

import org.jfree.chart.ChartFactory;
import org.jfree.chart.ChartUtilities;
import org.jfree.chart.JFreeChart;
import org.jfree.chart.annotations.CategoryTextAnnotation;
import org.jfree.chart.annotations.XYPointerAnnotation;
import org.jfree.chart.annotations.XYPolygonAnnotation;
import org.jfree.chart.annotations.XYShapeAnnotation;
import org.jfree.chart.annotations.XYTextAnnotation;
import org.jfree.chart.axis.NumberAxis;
import org.jfree.chart.axis.NumberTickUnit;
import org.jfree.chart.plot.PlotOrientation;
import org.jfree.chart.plot.ValueMarker;
import org.jfree.chart.plot.XYPlot;
import org.jfree.data.category.DefaultCategoryDataset;
import org.jfree.data.xy.XYSeries;
import org.jfree.data.xy.XYSeriesCollection;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import com.caucho.quercus.QuercusModuleException;
import com.caucho.quercus.env.ArrayValue;
import com.caucho.quercus.env.Env;
import com.caucho.quercus.module.AbstractQuercusModule;

import org.jfree.chart.plot.CategoryPlot; 
import org.jfree.chart.renderer.category.BarRenderer;
import java.awt.GradientPaint;

import org.jfree.chart.renderer.category.CategoryItemRenderer;
import org.jfree.chart.renderer.category.GradientBarPainter;
import org.jfree.chart.renderer.category.StandardBarPainter;
import org.jfree.chart.plot.CategoryMarker;
import org.jfree.ui.Layer;   
import org.jfree.ui.RectangleAnchor;
import org.jfree.ui.TextAnchor;

import org.jfree.chart.axis.CategoryAxis;
import org.jfree.chart.axis.CategoryLabelPositions;

import org.jfree.chart.axis.ValueAxis;
import org.jfree.chart.renderer.xy.StandardXYItemRenderer;
import org.jfree.data.xy.XYDataset;
import org.jfree.chart.renderer.xy.XYLineAndShapeRenderer;
import org.jfree.ui.RectangleInsets;

import org.jfree.chart.axis.DateAxis;
import org.jfree.data.time.TimeSeries;
import org.jfree.data.time.TimeSeriesCollection;
import org.jfree.data.time.Day;
import org.jfree.date.MonthConstants;
import org.jfree.chart.renderer.xy.XYSplineRenderer;

import org.jfree.chart.axis.DateTickUnit;
import java.text.SimpleDateFormat;
import org.jfree.chart.title.TextTitle;
import org.jfree.chart.title.LegendTitle;

import org.jfree.chart.labels.PieSectionLabelGenerator;
import org.jfree.chart.plot.PiePlot;
import org.jfree.data.general.DefaultPieDataset;
import org.jfree.data.general.PieDataset;
import org.jfree.chart.labels.StandardPieSectionLabelGenerator;

import org.apache.commons.codec.binary.Base64;

import org.jfree.chart.labels.StandardCategoryItemLabelGenerator;
import org.jfree.chart.plot.IntervalMarker;

public class DocAutoChartModule extends AbstractQuercusModule {
	
    private static final Logger logger = LoggerFactory.getLogger(DocAutoChartModule.class);

    public static WsdChart2 wsd2_chart_bar_vertical(Env env, String title, String xAxis, String yAxis, boolean legend) {
    	return new WsdBarChart2(title, xAxis, yAxis, PlotOrientation.VERTICAL, legend);
    }
    
    public static WsdChart2 wsd2_chart_xy_line(Env env, String title, String xAxis, String yAxis, boolean legend) {
        return new WsdXYLineChart2(title, xAxis, yAxis, legend, false, null);
    }

    public static WsdChart2 wsd2_chart_xy_line_date(Env env, String title, String xAxis, String yAxis, boolean legend) {
        return new WsdXYLineChart2(title, xAxis, yAxis, legend, true, "yyyy-MM-dd");
    }

    public static WsdChart2 wsd2_chart_xy_line_date(Env env, String title, String xAxis, String yAxis, boolean legend, String dateFormat) {
        return new WsdXYLineChart2(title, xAxis, yAxis, legend, true, dateFormat);
    }

    public static WsdChart2 wsd2_chart_pie(Env env, String title, boolean legend) {
        return new WsdPieChart2(title, legend);
    }

    public static WsdChart2 wsd2_chart_pie_3d(Env env, String title, boolean legend) {
        return new WsdPieChart3D2(title, legend);
    }

    public static WsdChart2 wsd2_chart_xy_area_date(Env env, String title, String xAxis, String yAxis, boolean legend, String dateFormat) {
        return new WsdXYAreaChart2(title, xAxis, yAxis, legend, true, dateFormat);
    }

    protected static TextAnchor getTextAnchor(String name) {
	if ("BASELINE_CENTER".equals(name)) {
	    return TextAnchor.BASELINE_CENTER;
	}
	else if ("BASELINE_LEFT".equals(name)) {
	    return TextAnchor.BASELINE_LEFT;
	}
	else if ("BASELINE_RIGHT".equals(name)) {
	    return TextAnchor.BASELINE_RIGHT;
	}
	else if ("BOTTOM_CENTER".equals(name)) {
	    return TextAnchor.BOTTOM_CENTER;
	}
	else if ("BOTTOM_LEFT".equals(name)) {
	    return TextAnchor.BOTTOM_LEFT;
	}
	else if ("BOTTOM_RIGHT".equals(name)) {
	    return TextAnchor.BOTTOM_RIGHT;
	}
	else if ("CENTER".equals(name)) {
	    return TextAnchor.CENTER;
	}
	else if ("CENTER_LEFT".equals(name)) {
	    return TextAnchor.CENTER_LEFT;
	}
	else if ("CENTER_RIGHT".equals(name)) {
	    return TextAnchor.CENTER_RIGHT;
	}
	else if ("HALF_ASCENT_CENTER".equals(name)) {
	    return TextAnchor.HALF_ASCENT_CENTER;
	}
	else if ("HALF_ASCENT_LEFT".equals(name)) {
	    return TextAnchor.HALF_ASCENT_LEFT;
	}
	else if ("HALF_ASCENT_RIGHT".equals(name)) {
	    return TextAnchor.HALF_ASCENT_RIGHT;
	}
	else if ("TOP_CENTER".equals(name)) {
	    return TextAnchor.TOP_CENTER;
	}
	else if ("TOP_LEFT".equals(name)) {
	    return TextAnchor.TOP_LEFT;
	}
	else if ("TOP_RIGHT".equals(name)) {
	    return TextAnchor.TOP_RIGHT;
	}
	else {
	    return null;
	}
    }

    @SuppressWarnings("unchecked")
    public static Object wsd2_chart_draw(Env env, WsdChart2 chart, int width, int height) {
	  return wsd2_chart_draw(env, chart, null, null, width, height);
    }

    @SuppressWarnings("unchecked")
    public static Object wsd2_chart_draw(Env env, WsdChart2 chart, Float width, Float height, int scale_width, int scale_height) {
        ByteArrayOutputStream output = new ByteArrayOutputStream();
        try {
            ChartUtilities.writeChartAsPNG(output, chart.chart, scale_width, scale_height);     	
        } catch (IOException e) {
            throw new QuercusModuleException("Could not create chart", e);
        }
		
	return env.createString(Base64.encodeBase64String(output.toByteArray()));
    }

    public static void tediousFuckingBullshit(String base64) {
        try {
            org.apache.commons.io.FileUtils.writeStringToFile(new java.io.File("base64.txt"), base64);
        } catch (Exception e) {
            throw new QuercusModuleException("Could not create chart", e);
        }
    }

    @SuppressWarnings("unchecked")
    public static Object wsd2_chart_draw_jpg(Env env, WsdChart2 chart, int width, int height) {
	  return wsd2_chart_draw(env, chart, null, null, width, height);
    }

    @SuppressWarnings("unchecked")
    public static Object wsd2_chart_draw_jpg(Env env, WsdChart2 chart, Float width, Float height, int scale_width, int scale_height) {
        ByteArrayOutputStream output = new ByteArrayOutputStream();
        try {
            ChartUtilities.writeChartAsJPEG(output, 1f, chart.chart, scale_width, scale_height);
        	
        } catch (IOException e) {
            throw new QuercusModuleException("Could not create chart", e);
        }
	
		return env.createString(Base64.encodeBase64String(output.toByteArray()));
    }
    
    protected abstract static class WsdChart2 {
        private JFreeChart chart;
        
        public WsdChart2 setBackgroundRGB(int r, int g, int b) {
            chart.getPlot().setBackgroundPaint(new Color(r, g, b));

            return this;
        }

        public WsdChart2 setChartBackgroundRGB(int r, int g, int b) {
            chart.setBackgroundPaint(new Color(r, g, b));

            return this;
        }

        public void setOutlineVisible(final boolean visible) {
            chart.getPlot().setOutlineVisible(visible);
        }

        public void setLegendFont(String fontName, int style, int size) {
            LegendTitle legend = chart.getLegend();
            if (legend == null) {
                return;
            }

            Font labelFont = new java.awt.Font(fontName, style, size);
            legend.setItemFont(labelFont);
        }

        public void setLegendBorderOff() {
            LegendTitle legend = chart.getLegend();
            legend.setFrame(org.jfree.chart.block.BlockBorder.NONE);
        }


        public WsdChart2 setBackgroundGradient(float x1, float y1, 
                                              int r1, int g1, int b1,
                                              float x2, float y2,
                                              int r2, int g2, int b2,
                                              boolean cyclic) {

            chart.getPlot().setBackgroundPaint(new GradientPaint(x1, y1, new Color(r1, g1, b1), x2, y2, new Color(r2, g2, b2), cyclic));

            return this;
        }
        
        protected void setChart(JFreeChart chart) {
            this.chart = chart;
        }

        protected Stroke stroke(float weight, String style) {
            if ("dotted".equals(style)) {
                return new BasicStroke(weight,
                        BasicStroke.CAP_BUTT, BasicStroke.JOIN_BEVEL, 0.0f,
                        new float[] {2.0f, 2.0f}, 0.0f);
	    }
	    else if ("dashed".equals(style)) {
                return new BasicStroke(weight,
				       BasicStroke.CAP_BUTT, BasicStroke.JOIN_MITER, 10.0f, new float[] {10.0f}, 0.0f);
            }
	    else {
                return new BasicStroke(weight);
            }
        }
        
        protected Color color(int r, int g, int b) {
            return new Color(r, g, b);
        }
        
	protected JFreeChart getChart() {
	    return chart;
	}

    }

    protected static class WsdBarChart2 extends WsdChart2 {

	private Map<String, Color> barColors = new HashMap<String, Color>();

	private class MyBarRenderer extends BarRenderer {

	    @Override
	    public java.awt.Paint getItemPaint(int row, int col) {

		if (barColors.get("" + row + ":" + col) != null) {
		    return barColors.get("" + row + ":" + col);
		}

		return super.getItemPaint(row, col);
	    }
	}


        private final DefaultCategoryDataset dataset;       

	public void setBarColor(int row, int col, int r, int g, int b) {
	    barColors.put("" + row + ":" + col, new Color(r, g, b));
	}

        private WsdBarChart2(String title, String xAxis, String yAxis, PlotOrientation orientation, boolean legend) {
            this.dataset = new DefaultCategoryDataset();

            setChart(ChartFactory.createBarChart(title, xAxis, yAxis, dataset, orientation, legend, false, false));
	    ((CategoryPlot)getChart().getPlot()).setRenderer(new MyBarRenderer());

	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();

            plot.setBackgroundImageAlpha(1f);

	    plot.setForegroundAlpha(1f);

        }
        
        public WsdBarChart2 plot(String series, String name, BigDecimal number) {
	    this.dataset.setValue(number, series, name);       	
            
            return this;
        }

	
        
        public void setXAxisLegendFont(String fontName, int style, int size) {
	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();
    	    plot.getDomainAxis().setLabelFont(new java.awt.Font(fontName, style, size));
    	}
        
        public void setXAxisLabelFont(String fontName, int style, int size) {
	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();
    	    plot.getDomainAxis().setTickLabelFont(new java.awt.Font(fontName, style, size));
    	}
        
        public void setYAxisLegendFont(String fontName, int style, int size) {
        	CategoryPlot plot = (CategoryPlot) getChart().getPlot();
    	    plot.getRangeAxis().setLabelFont(new java.awt.Font(fontName, style, size));
    	}
        
        public void setYAxisLabelFont(String fontName, int style, int size) {
        	CategoryPlot plot = (CategoryPlot) getChart().getPlot();
    	    plot.getRangeAxis().setTickLabelFont(new java.awt.Font(fontName, style, size));
    	}
        
        // setting the margins of the catagory axis
        public void setCategoryMargis(Float number) {
    	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();
    	    final CategoryAxis domainAxis = plot.getDomainAxis();
    	    domainAxis.setCategoryMargin(number); // e.g. 0.05 = 5%
    	}
        
        // setting the max width of the bars of the bar chart
        public void setMaxBarWidth(Float number) {
    	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();
    	    BarRenderer br = (BarRenderer) plot.getRenderer(); 
    	    br.setMaximumBarWidth(number); // e.g. 0.35 = 35% of chart 
    	}
        
        private CategoryAxis xAxis() {
  		  CategoryPlot plot = (CategoryPlot) getChart().getPlot();
            return (CategoryAxis) plot.getDomainAxis();
        }
  	
        private NumberAxis yAxis() {
            CategoryPlot plot = (CategoryPlot) getChart().getPlot();
            return (NumberAxis) plot.getRangeAxis();
        }
	
        public WsdBarChart2 setYAxisFormat(String format) {
            yAxis().setNumberFormatOverride(new DecimalFormat(format));
            
            return this;
        }
	
        
        public WsdBarChart2 setYAxisRange(float min, float max) {
            yAxis().setRange(min, max);
            return this;
        }

        public WsdBarChart2 setYAxisInterval(float interval) {
            yAxis().setTickUnit(new NumberTickUnit(interval));
            return this;
        }
        
        
        public void displayItemLabels() {
            CategoryPlot plot = (CategoryPlot) getChart().getPlot();
            CategoryItemRenderer renderer = plot.getRenderer();    
            renderer.setSeriesItemLabelsVisible(0, Boolean.TRUE);
        }
        

	protected BarRenderer getRenderer() {
	    return (BarRenderer) ((CategoryPlot)getChart().getPlot()).getRenderer();
	}

        public void setGradient(boolean gradient) {
	    if (gradient) {
		getRenderer().setBarPainter(new GradientBarPainter());
	    } else {
		getRenderer().setBarPainter(new StandardBarPainter());
	    }
	}

        public void setShadow(boolean shadow) {
	    getRenderer().setShadowVisible(shadow); 
	}


        public void setBarOutline(boolean barOutline) {
	    getRenderer().setDrawBarOutline(barOutline);
	}

        public void setColor(int seriesIndex, int r, int g, int b) {
	    getRenderer().setSeriesPaint(seriesIndex, new Color(r, g, b));
	}

	public void addMarker(BigDecimal value, float weight, String style, int r, int g, int b) {
	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();
	    plot.addRangeMarker(createMarker(value, weight, style, "", r, g, b), Layer.BACKGROUND);
	}
	
	public void addMarker(BigDecimal value, float weight, String style, String label, int r, int g, int b) {
	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();
	    plot.addRangeMarker(createMarker(value, weight, style, label, r, g, b), Layer.BACKGROUND);
	}
	
	public void addMarker(BigDecimal value, float weight, String style, String label, String labelFont, int labelStyle, int labelFontSize, int r, int g, int b) {
	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();
	    plot.addRangeMarker(createMarkerWithLabel(value, weight, style, label, labelFont, labelStyle, labelFontSize, r, g, b), Layer.BACKGROUND);
	}


	public void addMarker(BigDecimal value, float weight, String style, String label, String labelFont, int labelStyle, int labelFontSize, int r, int g, int b, String rectangleAnchor, String textAnchor, String layer) {
	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();
            ValueMarker marker = createMarkerWithLabel(value, weight, style, label, labelFont, labelStyle, labelFontSize, r, g, b, rectangleAnchor, textAnchor);

            if ("FOREGROUND".equals(layer)) {
                plot.addRangeMarker(marker, Layer.FOREGROUND);
            } else if ("BACKGROUND".equals(layer)) {
                plot.addRangeMarker(marker, Layer.BACKGROUND);
            }

	}


	private ValueMarker createMarkerWithLabel(BigDecimal value, float weight, String style, String label, String labelFont, int labelStyle, int labelFontSize, int r, int g, int b) {
            return createMarkerWithLabel(value, weight, style, label, labelFont, labelStyle, labelFontSize, r, g, b, "TOP_LEFT", "BOTTOM_LEFT");
        }


	private ValueMarker createMarkerWithLabel(BigDecimal value, float weight, String style, String label, String labelFont, int labelStyle, int labelFontSize, int r, int g, int b, String rectangleAnchor, String textAnchor) {
	    ValueMarker marker = new ValueMarker(value.doubleValue());
	    marker.setPaint(color(r, g, b));
	    marker.setLabel(label);
	    marker.setStroke(stroke(weight, style));

            marker.setLabelAnchor(getRectangleAnchor(rectangleAnchor));

            marker.setLabelTextAnchor(getTextAnchor(textAnchor));

	    marker.setLabelFont(new java.awt.Font(labelFont, labelStyle, labelFontSize));
	    return marker;
	}

	
	private ValueMarker createMarkerWithLabelXXX(BigDecimal value, float weight, String style, String label, String labelFont, int labelStyle, int labelFontSize, int r, int g, int b) {
	    ValueMarker marker = new ValueMarker(value.doubleValue());
	    marker.setPaint(color(r, g, b));
	    marker.setLabel(label);
	    marker.setStroke(stroke(weight, style));
	    marker.setLabelAnchor(RectangleAnchor.TOP_LEFT);
	    marker.setLabelTextAnchor(TextAnchor.BOTTOM_LEFT);
	    marker.setLabelFont(new java.awt.Font(labelFont, labelStyle, labelFontSize));
	    return marker;
	}

        private ValueMarker createMarker(BigDecimal value, float weight, String style, String label, int r, int g, int b) {
            ValueMarker marker = new ValueMarker(value.doubleValue());
            marker.setPaint(color(r, g, b));
            marker.setLabel(label);
            marker.setLabelAnchor(RectangleAnchor.TOP_LEFT);
            marker.setLabelTextAnchor(TextAnchor.BOTTOM_LEFT);
            marker.setStroke(stroke(weight, style));
            return marker;
        }

        public WsdBarChart2 setXAxisGridlineOff() {
	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();
            plot.setDomainGridlinesVisible(false);
            return this;
        }

        public WsdBarChart2 setXAxisGridline(float weight, String style, int r, int g, int b) {
	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();
            plot.setDomainGridlinesVisible(true);
	    plot.setDomainGridlinePaint(color(r, g, b));
            plot.setDomainGridlineStroke(stroke(weight, style));
            return this;
        }

        public WsdBarChart2 setYAxisGridlineOff() {
	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();
            plot.setRangeGridlinesVisible(false);
            return this;
        }

        public WsdBarChart2 setYAxisGridline(float weight, String style, int r, int g, int b) {
	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();
            plot.setRangeGridlinesVisible(true);
	    plot.setRangeGridlinePaint(color(r, g, b));
            plot.setRangeGridlineStroke(stroke(weight, style));
            return this;
        }


	public void rotateXLabelsUp(boolean vertical) {
	    if (vertical) {
		rotateXLabelsUp(CategoryLabelPositions.UP_90);
	    } else {
		rotateXLabelsUp(CategoryLabelPositions.UP_45);
	    }
	}

	public void rotateXLabelsDown(boolean vertical) {
	    if (vertical) {
		rotateXLabelsDown(CategoryLabelPositions.DOWN_90);
	    } else {
		rotateXLabelsDown(CategoryLabelPositions.DOWN_45);
	    }
	}

	private void rotateXLabelsUp(CategoryLabelPositions position) {
	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();
	    final CategoryAxis domainAxis = plot.getDomainAxis();
	    domainAxis.setCategoryLabelPositions(position);
	}

	private void rotateXLabelsDown(CategoryLabelPositions position) {
	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();
	    final CategoryAxis domainAxis = plot.getDomainAxis();
	    domainAxis.setCategoryLabelPositions(position);

	}


	public void setNumbersOnTopOfBars(boolean on, String labelFormat, String formatter, String percentFormatter) {
	    BarRenderer renderer = getRenderer();
	    renderer.setBaseItemLabelsVisible(on);

	    if (on) {
		renderer.setBaseItemLabelGenerator(new StandardCategoryItemLabelGenerator(
						       labelFormat,
						       new DecimalFormat(formatter), 
						       new DecimalFormat(percentFormatter)));

	    }

	}
	
	public void setBarRendererPaint(int r, int g, int b, String font, int style, int size) {

	    BarRenderer renderer = getRenderer();

	    renderer.setBaseItemLabelFont(new java.awt.Font(font, style, size));
	    renderer.setBaseItemLabelPaint(color(r, g, b));
	}

        
        public void addIntervalMarker(final double start, final double end,
                                      final String labelText,
                                      final String labelFontName, final int labelFontStyle, final int labelFontSize,
                                      final String labelAnchor, final String labelTextAnchor,
                                      final int labelR, final int labelG, final int labelB, final int labelA,
                                      final int r, final int g, final int b, final int a,
                                      final String intervalLayer) {


            IntervalMarker intervalmarker = new IntervalMarker(start, end);
            intervalmarker.setLabel(labelText);
            intervalmarker.setLabelFont(new Font(labelFontName, labelFontStyle, labelFontSize));
            intervalmarker.setLabelAnchor(getRectangleAnchor(labelAnchor));
            intervalmarker.setLabelTextAnchor(getTextAnchor(labelTextAnchor));
            intervalmarker.setLabelPaint(new Color(labelR, labelR, labelB, labelA));
            intervalmarker.setPaint(new Color(r, g, b, a));

	    CategoryPlot plot = (CategoryPlot) getChart().getPlot();

            if ("FOREGROUND".equals(intervalLayer)) {
                plot.addRangeMarker(intervalmarker, Layer.FOREGROUND);
            } else if ("BACKGROUND".equals(intervalLayer)) {
                plot.addRangeMarker(intervalmarker, Layer.BACKGROUND);
            }

        }



        protected static TextAnchor getTextAnchor(String name) {

            if ("BASELINE_CENTER".equals(name)) {
                return TextAnchor.BASELINE_CENTER;
            }
            else if ("BASELINE_LEFT".equals(name)) {
                return TextAnchor.BASELINE_LEFT;
            }
            else if ("BASELINE_RIGHT".equals(name)) {
                return TextAnchor.BASELINE_RIGHT;
            }
            else if ("BOTTOM_CENTER".equals(name)) {
                return TextAnchor.BOTTOM_CENTER;
            }
            else if ("BOTTOM_LEFT".equals(name)) {
                return TextAnchor.BOTTOM_LEFT;
            }
            else if ("BOTTOM_RIGHT".equals(name)) {
                return TextAnchor.BOTTOM_RIGHT;
            }
            else if ("CENTER".equals(name)) {
                return TextAnchor.CENTER;
            }
            else if ("CENTER_LEFT".equals(name)) {
                return TextAnchor.CENTER_LEFT;
            }
            else if ("CENTER_RIGHT".equals(name)) {
                return TextAnchor.CENTER_RIGHT;
            }
            else if ("HALF_ASCENT_CENTER".equals(name)) {
                return TextAnchor.HALF_ASCENT_CENTER;
            }
            else if ("HALF_ASCENT_LEFT".equals(name)) {
                return TextAnchor.HALF_ASCENT_LEFT;
            }
            else if ("HALF_ASCENT_RIGHT".equals(name)) {
                return TextAnchor.HALF_ASCENT_RIGHT;
            }
            else if ("TOP_CENTER".equals(name)) {
                return TextAnchor.TOP_CENTER;
            }
            else if ("TOP_LEFT".equals(name)) {
                return TextAnchor.TOP_LEFT;
            }
            else if ("TOP_RIGHT".equals(name)) {
                return TextAnchor.TOP_RIGHT;
            }
            else {
                return null;
            }
        }


        protected static RectangleAnchor getRectangleAnchor(String name) {

            if ("BOTTOM".equals(name)) {
                return RectangleAnchor.BOTTOM;
            }
            else if ("BOTTOM_LEFT".equals(name)) {
                return RectangleAnchor.BOTTOM_LEFT;
            }
            else if ("BOTTOM_RIGHT".equals(name)) {
                return RectangleAnchor.BOTTOM_RIGHT;
            }
            else if ("CENTER".equals(name)) {
                return RectangleAnchor.CENTER;
            }
            else if ("LEFT".equals(name)) {
                return RectangleAnchor.LEFT;
            }
            else if ("RIGHT".equals(name)) {
                return RectangleAnchor.RIGHT;
            }
            else if ("TOP".equals(name)) {
                return RectangleAnchor.TOP;
            }            
            else if ("TOP_LEFT".equals(name)) {
                return RectangleAnchor.TOP_LEFT;
            }
            else if ("TOP_RIGHT".equals(name)) {
                return RectangleAnchor.TOP_RIGHT;
            }
            else {
                return null;
            }
        }
	    
    }

    
    protected abstract static class WsdXYChart2 extends WsdChart2 {
        protected XYPlot plot;
        
        @Override
        protected void setChart(JFreeChart chart) {
            this.plot = chart.getXYPlot();
            super.setChart(chart);
        }
        
        private NumberAxis xAxis() {
            return (NumberAxis) plot.getDomainAxis();
        }
        
        private NumberAxis yAxis() {
            return (NumberAxis) plot.getRangeAxis();
        }
        

        public void overrideTicks(final boolean b, Number[] numbers) {
            if (b) {
                ArbitraryTicksNumberAxis axis = new ArbitraryTicksNumberAxis();
                if (numbers != null) {
                    axis.setNumbers(Arrays.asList(numbers));
                }

                axis.setLabel(plot.getDomainAxis().getLabel());

                plot.setDomainAxis(axis);
            }
        }

        public void setOverrideTicks(Number[] numbers) {
            if (plot.getDomainAxis() instanceof ArbitraryTicksNumberAxis) {
                ((ArbitraryTicksNumberAxis) plot.getDomainAxis()).setNumbers(Arrays.asList(numbers));
            }
        }

        public void hack() {
            ((ArbitraryTicksDateAxis) plot.getDomainAxis()).hack();
        }


        public void overrideTicksDates(final boolean b, Number[] numbers, String textAnchor, String rotationAnchor, Double angle) {
            if (b) {
                ArbitraryTicksDateAxis axis = new ArbitraryTicksDateAxis();
                if (numbers != null) {
                    axis.setNumbers(Arrays.asList(numbers));
                }

                axis.setDateFormatOverride(((DateAxis) plot.getDomainAxis()).getDateFormatOverride());
                axis.setLabel(plot.getDomainAxis().getLabel());


                axis.setCustomTickProperties(getTextAnchor(textAnchor), getTextAnchor(rotationAnchor), angle);

                plot.setDomainAxis(axis);
            }
        }

        public void setOverrideTicksDates(Number[] numbers) {
            if (plot.getDomainAxis() instanceof ArbitraryTicksDateAxis) {
                ((ArbitraryTicksDateAxis) plot.getDomainAxis()).setNumbers(Arrays.asList(numbers));
            }
        }


        public WsdXYChart2 setXAxisRange(float min, float max) {
            xAxis().setRange(min, max);
            return this;
        }
        
        public WsdXYChart2 setYAxisRange(float min, float max) {
            yAxis().setRange(min, max);
            return this;
        }

        public WsdXYChart2 setXAxisInterval(float interval) {
            xAxis().setTickUnit(new NumberTickUnit(interval));
            return this;
        }
        
        public WsdXYChart2 setYAxisInterval(float interval) {
            yAxis().setTickUnit(new NumberTickUnit(interval));
            return this;
        }
        
        public WsdXYChart2 setXAxisFormat(String format) {
            xAxis().setNumberFormatOverride(new DecimalFormat(format));
            return this;
        }
        
        public WsdXYChart2 setYAxisFormat(String format) {
            yAxis().setNumberFormatOverride(new DecimalFormat(format));
            return this;
        }
        
        public WsdXYChart2 setXAxisGridlineOff() {
            plot.setDomainGridlinesVisible(false);
            return this;
        }
        
        public WsdXYChart2 setYAxisGridlineOff() {
            plot.setRangeGridlinesVisible(false);
            return this;
        }
        
        public WsdXYChart2 setXAxisGridline(float weight, String style, int r, int g, int b) {
            plot.setDomainGridlinesVisible(true);
            plot.setDomainGridlinePaint(color(r, g, b));
            plot.setDomainGridlineStroke(stroke(weight, style));
            return this;
        }
        
        public WsdXYChart2 setYAxisGridline(float weight, String style, int r, int g, int b) {
            plot.setRangeGridlinesVisible(true);
            plot.setRangeGridlinePaint(color(r, g, b));
            plot.setRangeGridlineStroke(stroke(weight, style));
            return this;
        }
        
        public WsdXYChart2 addXMarker(BigDecimal x, float weight, String style, int r, int g, int b) {
            plot.addDomainMarker(createMarker(x, weight, style, r, g, b));
            return this;
        }

        public WsdXYChart2 addYMarker(BigDecimal y, float weight, String style, int r, int g, int b) {
            plot.addRangeMarker(createMarker(y, weight, style, r, g, b));
            return this;
        }

        private ValueMarker createMarker(BigDecimal value, float weight, String style, int r, int g, int b) {
            ValueMarker marker = new ValueMarker(value.doubleValue());
            marker.setPaint(color(r, g, b));
            marker.setStroke(stroke(weight, style));
            return marker;
        }

	public void addNonPointerAnnotation(String label, String labelFont, int labelFontStyle, int labelFontSize,
					 double x, double y,
					 int r, int g, int b) {

	    XYTextAnnotation annotation = new XYTextAnnotation(label,
							       x, y);
	    
	    annotation.setFont(new Font(labelFont,
					labelFontStyle,
					labelFontSize));

	    annotation.setPaint(new Color(r, g, b));

	    plot.getRenderer().addAnnotation(annotation);

	}

	private double[] getDoubleArray(ArrayValue av) {
	    double[] d = new double[av.getSize()];
	    int i = 1;
	    Object o = null;
	    d[0] = new Double("" + av.current());
	    do {
		o = av.next();
		d[i] = new Double("" + o);
		i++;
	    } while (i < av.getSize());

	    return d;
	}

	public void addXYPolygonAnnotationOutline(Env env, ArrayValue av,
						  int or, int og, int ob, int oa,
						  Float weight, String style, boolean background) {


	    double[] d = getDoubleArray(av);
	    XYPolygonAnnotation polygon = new XYPolygonAnnotation(d, stroke(weight, style),
								  new Color(or, og, ob, oa));
	    
	    plot.getRenderer().addAnnotation(polygon, background ? Layer.BACKGROUND : Layer.FOREGROUND);
	}


	public void addXYPolygonAnnotation(Env env, com.caucho.quercus.env.ArrayValue av,
					   int or, int og, int ob, int oa,
					   int fr, int fg, int fb, int fa,
					   Float weight, String style, boolean background) {

	    double[] d = getDoubleArray(av);
	    XYPolygonAnnotation polygon = new XYPolygonAnnotation(d, stroke(weight, style), 
								  new Color(or, og, ob, oa),
								  new Color(fr, fg, fb, fa));

	    plot.getRenderer().addAnnotation(polygon, background ? Layer.BACKGROUND : Layer.FOREGROUND);
	}


	public Shape createCircle(double x,  double y, double w, double h) {
	    return new Ellipse2D.Double(x, y, w, h);
	}

	public Shape createRectangle(double x,  double y, double w, double h) {
	    return new Rectangle2D.Double(x, y, w, h);
	}

	public Shape createRoundRectangle(double x,  double y, double w, double h, double arcw, double arch) {
	    return new RoundRectangle2D.Double(x, y, w, h, arcw, arch);
	}


	public void addXYShapeAnnotationOutline(Env env, Shape shape,
						int or, int og, int ob, int oa,
						Float weight, String style, boolean background) {


	    XYShapeAnnotation polygon = new XYShapeAnnotation(shape, stroke(weight, style),
							      new Color(or, og, ob, oa));

	    plot.getRenderer().addAnnotation(polygon, background ? Layer.BACKGROUND : Layer.FOREGROUND);
	}

	public void shapes() {

            XYShapeAnnotation a1 = new XYShapeAnnotation(
                new Ellipse2D.Double(20.0, 20.0, 50.0, 50.0), new BasicStroke(1.0f), Color.blue
            );

            plot.addAnnotation(a1);

	}


	public void addXYShapeAnnotation(Env env, Shape shape,
					 int or, int og, int ob, int oa,
					 int fr, int fg, int fb, int fa,
					 Float weight, String style, boolean background) {

	    logger.debug("shape is [" + shape + "]");
	    
	    
	    XYShapeAnnotation polygon = new XYShapeAnnotation(shape, stroke(weight, style), 
								  new Color(or, og, ob, oa),
								  new Color(fr, fg, fb, fa));

	    plot.getRenderer().addAnnotation(polygon, background ? Layer.BACKGROUND : Layer.FOREGROUND);


	}
        

	// NOTE: to draw along a DateAxis specify a millisecond value
	public void addPointerAnnotation(String label, String labelFont, int labelFontStyle, int labelFontSize,
					 double x, double y,
					 int r, int g, int b,
					 int arrowR, int arrowG, int arrowB,
					 int tipRadius, int baseRadius,
					 double angle, String textAnchor,
					 double labelOffset,
                                         Float weight, String style, Double arrowWidth) {
	    

	    XYPointerAnnotation annotation = new XYPointerAnnotation(
		label,
		x, y, 
		angle);
	    
	    annotation.setTipRadius(tipRadius);
	    annotation.setBaseRadius(baseRadius);

	    annotation.setLabelOffset(labelOffset);

	    annotation.setTextAnchor(getTextAnchor(textAnchor));
	    annotation.setPaint(new Color(r, g, b));
	    annotation.setArrowPaint(new Color(arrowR, arrowG, arrowB));

	    annotation.setFont(new Font(labelFont,
					labelFontStyle,
					labelFontSize));
	    
            if (weight != null && style != null) {
                annotation.setArrowStroke(stroke(weight, style));
            }

            if (arrowWidth != null) {
                annotation.setArrowWidth(arrowWidth);
            }


	    plot.getRenderer().addAnnotation(annotation);
	    
	}

    }

    protected static class WsdXYAreaChart2 extends WsdXYLineChart2 {
	
	private WsdXYAreaChart2() { }
	
        private WsdXYAreaChart2(String title, String xAxis, String yAxis, boolean legend, boolean dates, String dateFormat) {

            this.dataset = new XYSeriesCollection();
 	    this.timeDataset = new TimeSeriesCollection();

	    JFreeChart chart = ChartFactory.createXYAreaChart(
		title,
		xAxis, yAxis,
		timeDataset,
		PlotOrientation.VERTICAL,
		legend,  // legend
		true,  // tool tips
		false  // URLs
		);


	    XYPlot plot = chart.getXYPlot();

	    ValueAxis domainAxis = new DateAxis(xAxis);
	    domainAxis.setLowerMargin(0.0);
	    domainAxis.setUpperMargin(0.0);
	    plot.setDomainAxis(domainAxis);

	    plot.setForegroundAlpha(1f);
	    ((DateAxis) domainAxis).setDateFormatOverride(new java.text.SimpleDateFormat(dateFormat));
	    setChart(chart);
        }

    }

    protected static class WsdXYLineChart2 extends WsdXYChart2 {
        protected XYSeriesCollection dataset;
        protected TimeSeriesCollection timeDataset;

	private WsdXYLineChart2() { }
        
        private WsdXYLineChart2(String title, String xAxis, String yAxis, boolean legend, boolean dates, String dateFormat) {
            this.dataset = new XYSeriesCollection();
	    this.timeDataset = new TimeSeriesCollection();

	    if (dates) {

		setChart(ChartFactory.createXYLineChart(title, xAxis, yAxis, timeDataset, PlotOrientation.VERTICAL, legend, false, false));
		plot.setDomainAxis(new DateAxis(xAxis));

		((DateAxis) plot.getDomainAxis()).setDateFormatOverride(new java.text.SimpleDateFormat(dateFormat));


	    } else {
		setChart(ChartFactory.createXYLineChart(title, xAxis, yAxis, dataset, PlotOrientation.VERTICAL, legend, false, false));
	    }


        }
	
	public void setUpperMargin(double margin) {
	    XYPlot plot = (XYPlot) getChart().getPlot();
	    final ValueAxis valueAxis = plot.getDomainAxis();

	    valueAxis.setUpperMargin(margin);
	}

	public void setPadding(double top, double left, double bottom, double right) {


	    getChart().setPadding(new RectangleInsets(top, left, bottom, right));
	}

	public void setSplineRenderer(boolean visible_shapes) {
	    getChart().getXYPlot().setRenderer(new XYSplineRenderer());
	    ((XYSplineRenderer) getChart().getXYPlot().getRenderer()).setBaseShapesVisible(visible_shapes);
	}

	public void setSplineShapesFilled(boolean filled_shapes) {
	    ((XYSplineRenderer) getChart().getXYPlot().getRenderer()).setBaseShapesFilled(filled_shapes);
	}

	public void setMonthlyTickUnit(int value) {
	    DateTickUnit tickUnit = new DateTickUnit(org.jfree.chart.axis.DateTickUnitType.MONTH, value);
	    ((DateAxis) plot.getDomainAxis()).setTickUnit(tickUnit);
	}

	public void rotateXLabelsUp() {
	    XYPlot plot = (XYPlot) getChart().getPlot();
	    final ValueAxis valueAxis = plot.getDomainAxis();
	    valueAxis.setVerticalTickLabels(true);
	}

	public void rotateXLabelsDown() {
	    XYPlot plot = (XYPlot) getChart().getPlot();
	    final ValueAxis valueAxis = plot.getDomainAxis();
	    valueAxis.setVerticalTickLabelsDown(true);
	}


	public void setAxisOffsets(double top, double left, double bottom, double right) {
	    XYPlot plot = (XYPlot) getChart().getPlot();
	    plot.setAxisOffset(new RectangleInsets (top, left, bottom, right));
	}

        public WsdXYChart2 setDateAxisRange(String lower, String upper) {
	    SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
	    try {
		((DateAxis) plot.getDomainAxis()).setRange(sdf.parse(lower), sdf.parse(upper));
	    } catch (Exception e) {
		throw new QuercusModuleException("Could not parse ", e);
	    }
            return this;
        }

	public void setXAxisLegendFont(String fontName, int style, int size) {
	    plot.getDomainAxis().setLabelFont(new java.awt.Font(fontName, style, size));
	}

	public void setYAxisLegendFont(String fontName, int style, int size) {
	    plot.getRangeAxis().setLabelFont(new java.awt.Font(fontName, style, size));
	}

	public void setXAxisLabelFont(String fontName, int style, int size) {
	    plot.getDomainAxis().setTickLabelFont(new java.awt.Font(fontName, style, size));
	}

	public void setYAxisLabelFont(String fontName, int style, int size) {
	    plot.getRangeAxis().setTickLabelFont(new java.awt.Font(fontName, style, size));
	}

	public void setTitleAndFont(String title, String fontName, int style, int size) {
	    getChart().setTitle(new TextTitle(title, new java.awt.Font(fontName, style, size)));
	}

	public WsdXYLineChart2 plotDate(String name, String dateString, BigDecimal y, int r, int g, int b, float weight, String style) {
	    
	    Date day = null;
	    try {
		day = new java.text.SimpleDateFormat("yyyy-MM-dd").parse(dateString);
	    } catch (java.text.ParseException e) {
		throw new QuercusModuleException("Failed to parse dateString [" + dateString + "] in plotDate", e);
	    }

	    return plotDate(name, day, y, new Color(r, g, b), weight, style);
	}


        private WsdXYLineChart2 plotDate(String name, Date date, BigDecimal y, Color color, Float weight, String style) {
            TimeSeries series = null;
	    int seriesIndex = 0;
            for(Object o : timeDataset.getSeries()) {
                TimeSeries item = (TimeSeries) o;
                if (name.equals(item.getKey())) {
                    series = item;
                    break;
                }
		seriesIndex++;
            }

            if (series == null) {
                series = new TimeSeries(name);
		if (color != null) {
		    plot.getRenderer().setSeriesPaint(seriesIndex, color);
		}
		if (weight != null && style != null) {
		    plot.getRenderer().setSeriesStroke(seriesIndex, stroke(weight, style));
		}
		timeDataset.addSeries(series);
            }
            
            series.add(new Day(date), y);
            return this;
        }


        public WsdXYLineChart2 plot(String name, BigDecimal x, BigDecimal y) {
	    return plot(name, x, y, null, null, null);
	}

        public WsdXYLineChart2 plot(String name, BigDecimal x, BigDecimal y, float weight, String style) {
	    return plot(name, x, y, null, weight, style);
	}

        public WsdXYLineChart2 plot(String name, BigDecimal x, BigDecimal y, int r, int g, int b) {
	    return plot(name, x, y, new Color(r, g, b), null, null);
	}

        public WsdXYLineChart2 plot(String name, BigDecimal x, BigDecimal y, int r, int g, int b, float weight, String style) {
	    return plot(name, x, y, new Color(r, g, b), weight, style);
	}

        private WsdXYLineChart2 plot(String name, BigDecimal x, BigDecimal y, Color color, Float weight, String style) {
            XYSeries series = null;
	    int seriesIndex = 0;
            for(Object o : dataset.getSeries()) {
                XYSeries item = (XYSeries) o;
                if (name.equals(item.getKey())) {
                    series = item;
                    break;
                }
		seriesIndex++;
            }

            if (series == null) {
                series = new XYSeries(name);
		if (color != null) {
		    plot.getRenderer().setSeriesPaint(seriesIndex, color);
		}
		if (weight != null && style != null) {
		    plot.getRenderer().setSeriesStroke(seriesIndex, stroke(weight, style));
		}
		dataset.addSeries(series);
            }
            
            series.add(x, y);
            
            
            return this;
        }
        
    }


    protected static class WsdPieChart3D2 extends WsdPieChart2 {

        protected WsdPieChart3D2(String title, boolean legend) {
            this.dataset = new DefaultPieDataset();
            
            setChart(ChartFactory.createPieChart3D(title, dataset, legend, false, false));

        }

    }


    protected static class WsdPieChart2 extends WsdChart2 {
        protected PieDataset dataset;

	private WsdPieChart2() { }
        
        protected WsdPieChart2(String title, boolean legend) {
            this.dataset = new DefaultPieDataset();
            
            setChart(ChartFactory.createPieChart(title, dataset, legend, false, false));

        }

        public void addValue(final String key, final Number n) {
            ((DefaultPieDataset) dataset).setValue(key, n); // new Double(43.200000000000003D));
        }

        public void setColor(final String key, int r, int g, int b) {
            PiePlot plot = (PiePlot) getChart().getPlot();
            plot.setSectionPaint(key, new Color(r, g, b));
        }

        public void setSimpleLabels(final boolean b) {
            ((PiePlot) getChart().getPlot()).setSimpleLabels(b);
        }

        public void setLabelBackgroundColor(int r, int g, int b, int alpha) {
            ((PiePlot) getChart().getPlot()).setLabelBackgroundPaint(new Color(r, g, b, alpha));
        }

        public void setLabelOutlinePaint(int r, int g, int b, int alpha) {
            ((PiePlot) getChart().getPlot()).setLabelOutlinePaint(new Color(r, g, b, alpha));
        }

        public void setLabelPaint(int r, int g, int b, int alpha) {
            ((PiePlot) getChart().getPlot()).setLabelPaint(new Color(r, g, b, alpha));
        }

        public void setLabelOutlineStroke(Float weight, String style) {
            ((PiePlot) getChart().getPlot()).setLabelOutlineStroke(stroke(weight, style));
        }

	public void setLabelFont(String fontName, int style, int size) {
            ((PiePlot) getChart().getPlot()).setLabelFont(new java.awt.Font(fontName, style, size));
	}

        public void setLabelShadowPaintOff(final boolean b) {
            ((PiePlot) getChart().getPlot()).setLabelShadowPaint(null);
        }

        public void setLabelShadowPaint(int r, int g, int b) {
            ((PiePlot) getChart().getPlot()).setLabelShadowPaint(new Color(r, g, b));
        }

	public void setTitleAndFont(String title, String fontName, int style, int size) {
	    getChart().setTitle(new TextTitle(title, new java.awt.Font(fontName, style, size)));
	}

    }
}
