wsd_chart_draw($chart, $width, $height)

Parâmetros:

$chart: objeto gráfico criado por funções como wsd_chart_xy_line, wsd_chart_xy_line_date ou wsd_chart_bar_vertical

$width: largura da imagem gerada (em pixels)

$height: altura da imagem gerada (em pixels)

O que faz:
Renderiza o gráfico configurado no objeto $chart, gerando uma imagem pronta para ser inserida em documentos, exibida em tela ou salva em arquivo. Aplica todas as configurações e dados previamente definidos no objeto gráfico.

Retorno:
Retorna uma imagem do gráfico (objeto, recurso binário ou estrutura compatível com a biblioteca de documentos ou saída HTML/PDF utilizada). Não é uma função void; o retorno é utilizado em chamadas como echo ou como argumento de métodos de inserção em documentos.

-----------------------------------------------------------------------------------------------------------------

wsd_mktime($hour, $minute, $second, $month, $day, $year)

Parâmetros:

$hour: hora (0-23)

$minute: minuto (0-59)

$second: segundo (0-59)

$month: mês (1-12)

$day: dia do mês (1-31)

$year: ano (quatro dígitos)

O que faz:
Gera um timestamp Unix para a data e hora especificadas, equivalente à função nativa mktime() do PHP. Permite criar datas passadas ou futuras, facilitando cálculos e manipulação de datas em históricos financeiros.

Retorno:
Retorna um inteiro representando o timestamp Unix correspondente à data/hora informada. Esse valor pode ser usado em comparações, formatação de datas ou como chave para arrays de histórico.

-----------------------------------------------------------------------------------------------------------------

wsd_decimal_format($value, $format)

Parâmetros:

$value: valor numérico a ser formatado (float ou int)

$format: string de formato (ex: ',##0.00')

O que faz:
Formata o valor numérico de acordo com o padrão especificado, inserindo separadores de milhar, casas decimais, etc. É útil para exibir valores financeiros de forma padronizada em relatórios ou documentos.

Retorno:
Retorna uma string com o valor formatado conforme o padrão solicitado. Pode ser concatenada com outros textos para compor legendas, títulos ou descrições em documentos.

-----------------------------------------------------------------------------------------------------------------

wsd_chart_xy_line($title, $xAxisDescription, $yAxisDescription, $includeLegend)

Parâmetros:

$title: título do gráfico

$xAxisDescription: descrição do eixo X

$yAxisDescription: descrição do eixo Y

$includeLegend: booleano que define se o gráfico deve incluir uma legenda (true para incluir, false para não incluir)

O que faz:
Cria e retorna um objeto gráfico do tipo linha XY (sem eixo de datas), pronto para receber dados, configurações visuais e anotações. O parâmetro booleano permite controlar a presença da legenda no gráfico já na criação, facilitando a customização visual conforme a necessidade do relatório ou documento.

Retorno:
Retorna um objeto gráfico (instância Java, ex: WsdXYLineChart), sobre o qual podem ser chamados métodos para configurar aparência, plotar dados, adicionar anotações e renderizar o gráfico.wsd_chart_xy_line($title, $xAxisDescription, $yAxisDescription, $includeLegend)

Parâmetros:

$title: título do gráfico

$xAxisDescription: descrição do eixo X

$yAxisDescription: descrição do eixo Y

$includeLegend: booleano que define se o gráfico deve incluir uma legenda (true para incluir, false para não incluir)

O que faz:
Cria e retorna um objeto gráfico do tipo linha XY (sem eixo de datas), pronto para receber dados, configurações visuais e anotações. O parâmetro booleano permite controlar a presença da legenda no gráfico já na criação, facilitando a customização visual conforme a necessidade do relatório ou documento.

Retorno:
Retorna um objeto gráfico (instância Java, ex: WsdXYLineChart), sobre o qual podem ser chamados métodos para configurar aparência, plotar dados, adicionar anotações, etc.

Métodos:



setBackgroundRGB($r, $g, $b)

Parâmetros:

$r: valor do componente vermelho (0-255)

$g: valor do componente verde (0-255)

$b: valor do componente azul (0-255)

O que faz:
Define a cor de fundo do gráfico, ajustando o background para a cor RGB especificada. Isso afeta toda a área do gráfico, melhorando a visualização ou adequando o gráfico ao padrão visual do documento ou relatório.

Retorno:
Não retorna valor (função void). O efeito é aplicado diretamente ao objeto gráfico (WsdXYLineChart).



setXAxisGridlineOff()

Parâmetros:
(nenhum)

O que faz:
Desativa (remove) as linhas de grade do eixo X no gráfico, deixando o fundo do gráfico mais limpo ou menos poluído visualmente.

Retorno:
Não retorna valor (função void). O efeito é aplicado diretamente ao objeto gráfico.



setYAxisGridline($interval, $style, $r, $g, $b)

Parâmetros:

$interval: espaçamento entre as linhas de grade do eixo Y (ex: 0.5)

$style: estilo da linha (ex: "solid")

$r, $g, $b: cor RGB da linha de grade

O que faz:
Ativa e configura as linhas de grade do eixo Y, definindo o espaçamento, o estilo e a cor das linhas.

Retorno:
Não retorna valor (função void). O efeito é aplicado diretamente ao objeto gráfico.



plot($seriesName, $x, $y)

Parâmetros:

$seriesName: nome da série de dados (ex: "Upward sloping line")

$x: valor no eixo X

$y: valor no eixo Y

O que faz:
Plota um ponto ou segmento de linha no gráfico, associando-o a uma série de dados específica.

Retorno:
Não retorna valor (função void). O ponto/linha é adicionado ao objeto gráfico.



setXAxisRange($min, $max)

Parâmetros:

$min: valor mínimo do eixo X

$max: valor máximo do eixo X

O que faz:
Define o intervalo de valores exibidos no eixo X do gráfico.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setXAxisInterval($interval)

Parâmetros:

$interval: espaçamento entre os ticks (marcadores) do eixo X

O que faz:
Define o espaçamento entre os marcadores (ticks) do eixo X.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setYAxisRange($min, $max)

Parâmetros:

$min: valor mínimo do eixo Y

$max: valor máximo do eixo Y

O que faz:
Define o intervalo de valores exibidos no eixo Y do gráfico.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setYAxisInterval($interval)

Parâmetros:

$interval: espaçamento entre os ticks (marcadores) do eixo Y

O que faz:
Define o espaçamento entre os marcadores (ticks) do eixo Y.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setXAxisFormat($format)

Parâmetros:

$format: string de formato para exibição dos valores do eixo X (ex: "#")

O que faz:
Define como os valores do eixo X serão exibidos (quantas casas decimais, separadores, etc).

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setYAxisFormat($format)

Parâmetros:

$format: string de formato para exibição dos valores do eixo Y (ex: "#")

O que faz:
Define como os valores do eixo Y serão exibidos (quantas casas decimais, separadores, etc).

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



overrideTicks($bool)

Parâmetros:

$bool: booleano que define se os ticks do eixo X serão definidos manualmente (true) ou automaticamente (false)

O que faz:
Ativa ou desativa a definição manual dos ticks (marcadores) do eixo X.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setOverrideTicks($tickMarks)

Parâmetros:

$tickMarks: array/lista de valores para os ticks do eixo X

O que faz:
Define manualmente os valores dos ticks (marcadores) do eixo X, substituindo a geração automática.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



overrideTicksYAxis($bool, $tickMarks)

Parâmetros:

$bool: booleano que define se os ticks do eixo Y serão definidos manualmente (true) ou automaticamente (false)

$tickMarks: array/lista de valores para os ticks do eixo Y

O que faz:
Ativa a definição manual dos ticks do eixo Y e define os valores dos marcadores.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



addXYPolygonAnnotation($polygonArray, $r1, $g1, $b1, $alpha1, $r2, $g2, $b2, $alpha2, $weight, $style, $filled)

Parâmetros:

$polygonArray: array de coordenadas (pares X/Y) que definem os vértices do polígono

$r1, $g1, $b1, $alpha1: cor e transparência do contorno do polígono

$r2, $g2, $b2, $alpha2: cor e transparência do preenchimento do polígono

$weight: espessura da linha do contorno

$style: estilo da linha do contorno (ex: 'solid', 'dashed')

$filled: booleano indicando se o polígono deve ser preenchido

O que faz:
Adiciona um polígono ao gráfico, usando as coordenadas fornecidas para desenhar a forma, com as cores, transparências e estilos especificados para contorno e preenchimento.

Retorno:
Não retorna valor (função void). O polígono é adicionado ao objeto gráfico.



createCircle($x, $y, $width, $height)

Parâmetros:

$x: coordenada X do canto superior esquerdo do círculo

$y: coordenada Y do canto superior esquerdo do círculo

$width: largura do círculo

$height: altura do círculo

O que faz:
Cria uma forma de círculo (ou elipse) com as dimensões e posição especificadas, retornando um objeto de forma que pode ser usado em anotações no gráfico.

Retorno:
Retorna um objeto de forma (shape) representando o círculo, que pode ser passado para métodos como addXYShapeAnnotation.



addXYShapeAnnotation($shape, $r1, $g1, $b1, $alpha1, $r2, $g2, $b2, $alpha2, $weight, $style, $filled)

Parâmetros:

$shape: objeto de forma (ex: círculo criado por createCircle)

$r1, $g1, $b1, $alpha1: cor e transparência do contorno

$r2, $g2, $b2, $alpha2: cor e transparência do preenchimento

$weight: espessura da linha do contorno

$style: estilo da linha do contorno

$filled: booleano indicando se a forma deve ser preenchida

O que faz:
Adiciona uma forma geométrica (ex: círculo, elipse) ao gráfico, com as cores, transparências e estilos especificados.

Retorno:
Não retorna valor (função void). A forma é adicionada ao objeto gráfico.



addNonPointerAnnotation($text, $font, $weight, $size, $x, $y, $r1, $g1, $b1, $r2, $g2, $b2, $angle, $pointerLength, $pointerAngle, $pointerOrientation, $padding)

Parâmetros:

$text: texto da anotação

$font: nome da fonte

$weight: peso da fonte

$size: tamanho da fonte

$x, $y: coordenadas da anotação

$r1, $g1, $b1: cor do texto

$r2, $g2, $b2: cor do fundo

$angle: ângulo de rotação do texto

$pointerLength, $pointerAngle, $pointerOrientation, $padding: parâmetros de layout (usados para ponteiros, mas ignorados aqui)

O que faz:
Adiciona uma anotação de texto ao gráfico, sem ponteiro, na posição e com o estilo especificados.

Retorno:
Não retorna valor (função void). A anotação é adicionada ao objeto gráfico.



addPointerAnnotation($text, $font, $weight, $size, $x, $y, $r1, $g1, $b1, $r2, $g2, $b2, $angle, $pointerLength, $pointerAngle, $pointerOrientation, $padding)

Parâmetros:

$text: texto da anotação

$font: nome da fonte

$weight: peso da fonte

$size: tamanho da fonte

$x, $y: coordenadas da anotação

$r1, $g1, $b1: cor do texto

$r2, $g2, $b2: cor do fundo

$angle: ângulo de rotação do texto

$pointerLength: comprimento do ponteiro

$pointerAngle: ângulo do ponteiro

$pointerOrientation: orientação do ponteiro

$padding: espaçamento interno

O que faz:
Adiciona uma anotação de texto ao gráfico, com ponteiro, na posição e com o estilo especificados.

Retorno:
Não retorna valor (função void). A anotação é adicionada ao objeto gráfico.



setTitleAndFont($title, $font, $weight, $size)

Parâmetros:

$title: texto do título do gráfico

$font: nome da fonte (ex: "Arial")

$weight: peso da fonte (ex: 0 para normal, 1 para negrito)

$size: tamanho da fonte (em pontos)

O que faz:
Define o título do gráfico e a formatação da fonte utilizada nesse título.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setXAxisLabelFont($font, $weight, $size)

Parâmetros:

$font: nome da fonte

$weight: peso da fonte

$size: tamanho da fonte

O que faz:
Define a fonte utilizada nos rótulos (labels) do eixo X.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setXAxisLegendFont($font, $weight, $size)

Parâmetros:

$font: nome da fonte

$weight: peso da fonte

$size: tamanho da fonte

O que faz:
Define a fonte utilizada na legenda (descrição) do eixo X.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setYAxisLabelFont($font, $weight, $size)

Parâmetros:

$font: nome da fonte

$weight: peso da fonte

$size: tamanho da fonte

O que faz:
Define a fonte utilizada nos rótulos (labels) do eixo Y.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setYAxisLegendFont($font, $weight, $size)

Parâmetros:

$font: nome da fonte

$weight: peso da fonte

$size: tamanho da fonte

O que faz:
Define a fonte utilizada na legenda (descrição) do eixo Y.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setAxisOffsets($top, $bottom, $left, $right)

Parâmetros:

$top: margem superior

$bottom: margem inferior

$left: margem esquerda

$right: margem direita

O que faz:
Ajusta as margens internas do gráfico, controlando o espaçamento entre o conteúdo do gráfico e suas bordas.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



rotateXLabelsUp()

Parâmetros:
(nenhum)

O que faz:
Rotaciona os rótulos do eixo X para cima (em ângulo), melhorando a legibilidade quando há muitos valores ou os rótulos são longos.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.

-----------------------------------------------------------------------------------------------------------------

wsd_chart_bar_vertical($title, $xAxisDescription, $yAxisDescription, $includeLegend)

Parâmetros:

$title: título do gráfico

$xAxisDescription: descrição do eixo X

$yAxisDescription: descrição do eixo Y

$includeLegend: booleano que define se o gráfico deve incluir uma legenda (true para incluir, false para não incluir)

O que faz:
Cria e retorna um objeto gráfico do tipo barras verticais, configurado para receber dados de séries/categorias, além de permitir ajustes visuais, legendas e anotações. O parâmetro booleano permite controlar se a legenda será exibida já ao criar o gráfico.

Retorno:
Retorna um objeto gráfico (instância Java, ex: WsdBarChart), sobre o qual podem ser chamados métodos para configurar aparência, plotar valores, personalizar rótulos, adicionar marcadores e renderizar o gráfico.

Métodos:



setBackgroundRGB($r, $g, $b)

Parâmetros:

$r: valor do componente vermelho (0-255)

$g: valor do componente verde (0-255)

$b: valor do componente azul (0-255)

O que faz:
Define a cor de fundo do gráfico de barras verticais.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setShadow($bool)

Parâmetros:

$bool: booleano que define se as barras terão sombra (true para ativar, false para desativar)

O que faz:
Ativa ou desativa o efeito de sombra nas barras do gráfico.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setBarOutline($bool)

Parâmetros:

$bool: booleano que define se as barras terão contorno (true para ativar, false para desativar)

O que faz:
Ativa ou desativa o contorno nas barras do gráfico.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setGradient($bool)

Parâmetros:

$bool: booleano que define se as barras terão preenchimento em gradiente (true para ativar, false para desativar)

O que faz:
Ativa ou desativa o preenchimento em gradiente nas barras do gráfico.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setXAxisGridline($interval, $style, $r, $g, $b)

Parâmetros:

$interval: espaçamento entre as linhas de grade do eixo X

$style: estilo da linha (ex: "solid")

$r, $g, $b: cor RGB da linha de grade

O que faz:
Ativa e configura as linhas de grade do eixo X, definindo o espaçamento, o estilo e a cor das linhas.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setXAxisGridlineOff()

Parâmetros:
(nenhum)

O que faz:
Desativa (remove) as linhas de grade do eixo X no gráfico.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setYAxisGridline($interval, $style, $r, $g, $b)

Parâmetros:

$interval: espaçamento entre as linhas de grade do eixo Y

$style: estilo da linha (ex: "solid")

$r, $g, $b: cor RGB da linha de grade

O que faz:
Ativa e configura as linhas de grade do eixo Y, definindo o espaçamento, o estilo e a cor das linhas.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setYAxisGridlineOff()

Parâmetros:
(nenhum)

O que faz:
Desativa (remove) as linhas de grade do eixo Y no gráfico.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



plot($series, $category, $value)

Parâmetros:

$series: nome da série de dados

$category: categoria/barras no eixo X onde o valor será plotado

$value: valor numérico a ser exibido para essa categoria nessa série

O que faz:
Plota o valor especificado em uma barra do gráfico, associando-o à série e à categoria indicadas.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setColor($seriesIndex, $r, $g, $b)

Parâmetros:

$seriesIndex: índice da série de dados

$r, $g, $b: valores RGB da cor para a série

O que faz:
Define a cor utilizada para plotar/desenhar a série indicada no gráfico.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



rotateXLabelsUp($bool)

Parâmetros:

$bool: se true, rotaciona os rótulos do eixo X para cima; se false, remove rotação para cima

O que faz:
Rotaciona os rótulos do eixo X para cima caso haja muitos valores ou nomes longos.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



rotateXLabelsDown($bool)

Parâmetros:

$bool: se true, rotaciona os rótulos do eixo X para baixo; se false, remove rotação para baixo

O que faz:
Rotaciona os rótulos do eixo X para baixo (angulação oposta).

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



addMarker($x, $y, $style, $r, $g, $b)

Parâmetros:

$x: posição X no gráfico

$y: posição Y no gráfico

$style: estilo do marcador (ex: 'solid')

$r, $g, $b: cor RGB do marcador

O que faz:
Adiciona um marcador customizado (como ponto ou anotação) na posição especificada do gráfico de barras verticais.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.

----------------------------------------------------------------------------------------------------------------

wsd_chart_xy_line_date($yAxisTitle, $xAxisTitle, $chartTitle, $includeLegend, $dateFormat)

Parâmetros:

$yAxisTitle: título do eixo Y

$xAxisTitle: título do eixo X

$chartTitle: título do gráfico

$includeLegend: booleano que define se o gráfico deve incluir uma legenda (true para incluir, false para não incluir)

$dateFormat: formato da data para exibição no eixo X (ex: "MMM-yy")

O que faz:
Cria e retorna um objeto gráfico do tipo linha XY, especialmente projetado para exibir séries temporais com eixo X de datas. Permite personalizar títulos, formato das datas e presença de legenda, sendo ideal para gráficos históricos de preços ou métricas ao longo do tempo.

Retorno:
Retorna um objeto gráfico (instância Java, ex: WsdXYLineChart), sobre o qual podem ser chamados métodos para configurar aparência, plotar dados por datas, adicionar marcadores e renderizar o gráfico.

Métodos:



setTitleAndFont($title, $font, $weight, $size)

Parâmetros:

$title: texto do título do gráfico

$font: nome da fonte (ex: "Arial")

$weight: peso da fonte (ex: 0 para normal, 1 para negrito)

$size: tamanho da fonte (em pontos)

O que faz:
Define o título do gráfico e a formatação da fonte utilizada nesse título.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



overrideTicksDates($bool, $datesArray, $anchorStart, $anchorEnd, $rotationAngle)

Parâmetros:

$bool: booleano que define se os ticks do eixo X (datas) serão definidos manualmente

$datesArray: array/lista de datas para os ticks (pode ser NULL se não customizar)

$anchorStart, $anchorEnd: posição dos rótulos (ex: "CENTER_RIGHT")

$rotationAngle: ângulo de rotação dos rótulos (em radianos)

O que faz:
Ativa ou desativa a customização manual dos ticks de datas no eixo X, além de definir âncoras e rotação dos rótulos.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setOverrideTicksDates($dates)

Parâmetros:

$dates: array/lista de datas a serem exibidas como ticks no eixo X

O que faz:
Define manualmente os valores das datas que serão exibidas como ticks no eixo X, substituindo a geração automática.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



plotDate($seriesName, $date, $value, $r, $g, $b, $size, $style)

Parâmetros:

$seriesName: nome da série de dados (ex: "Closing price")

$date: data no formato string (ex: "2025-10-09")

$value: valor numérico para a data

$r, $g, $b: cor RGB do ponto ou linha

$size: tamanho do marcador

$style: estilo da linha (ex: 'solid')

O que faz:
Plota um ponto ou linha referente a uma data específica no gráfico.

Retorno:
Não retorna valor (função void). O ponto/linha é adicionado ao objeto gráfico.



addYMarker($value, $size, $style, $r, $g, $b)

Parâmetros:

$value: valor do marcador no eixo Y

$size: espessura da linha

$style: estilo da linha (ex: "solid")

$r, $g, $b: cor RGB da linha do marcador

O que faz:
Adiciona uma linha horizontal (marcador) no eixo Y, destacando níveis de barreira ou referência.

Retorno:
Não retorna valor (função void). O marcador é adicionado ao objeto gráfico.setTitleAndFont($title, $font, $weight, $size)

Parâmetros:

$title: texto do título do gráfico

$font: nome da fonte (ex: "Arial")

$weight: peso da fonte (ex: 0 para normal, 1 para negrito)

$size: tamanho da fonte em pontos

O que faz:
Define o título do gráfico e a fonte utilizada no título.

Retorno:
Não retorna valor (função void). O efeito é aplicado ao objeto gráfico.



overrideTicksDates($bool, $datesArray, $anchorStart, $anchorEnd, $rotationAngle)

Parâmetros:

$bool: booleano que ativa/desativa a definição manual de ticks do eixo X (datas)

$datesArray: array de datas para os ticks (pode ser NULL para padrão automático)

$anchorStart, $anchorEnd: posições de âncoras dos rótulos (ex: "CENTER_RIGHT")

$rotationAngle: ângulo de rotação dos rótulos das datas (em radianos)

O que faz:
Ativa a definição manual dos ticks do eixo X (datas) e permite configurar a posição e rotação dos rótulos de datas.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setOverrideTicksDates($dates)

Parâmetros:

$dates: array/lista de datas para os ticks do eixo X

O que faz:
Define manualmente as datas que serão usadas como ticks no eixo X.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



plotDate($seriesName, $date, $value, $r, $g, $b, $size, $style)

Parâmetros:

$seriesName: nome da série (ex: "Closing price")

$date: data (formato string, ex: "2025-10-09")

$value: valor numérico para a data

$r, $g, $b: cor RGB

$size: espessura/tamanho do marcador

$style: estilo da linha (ex: "solid")

O que faz:
Plota um valor de série referente a uma data específica no gráfico.

Retorno:
Não retorna valor (função void). O valor é adicionado ao objeto gráfico.



addYMarker($value, $size, $style, $r, $g, $b)

Parâmetros:

$value: valor de posicionamento no eixo Y

$size: espessura da linha

$style: estilo da linha (ex: "solid")

$r, $g, $b: cor RGB

O que faz:
Adiciona uma linha horizontal no eixo Y como marcador de nível (exemplo: barreiras de cupom).

Retorno:
Não retorna valor (função void). O marcador é adicionado ao objeto gráfico.



setBackgroundRGB($r, $g, $b)

Parâmetros:

$r: valor do componente vermelho (0-255)

$g: valor do componente verde (0-255)

$b: valor do componente azul (0-255)

O que faz:
Define a cor de fundo do gráfico.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setXAxisGridlineOff()

Parâmetros:
(nenhum)

O que faz:
Desativa (remove) as linhas de grade do eixo X no gráfico.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setYAxisGridline($interval, $style, $r, $g, $b)

Parâmetros:

$interval: espaçamento entre as linhas de grade do eixo Y

$style: estilo da linha (ex: "solid")

$r, $g, $b: cor RGB da linha de grade

O que faz:
Ativa e configura as linhas de grade do eixo Y, definindo o espaçamento, o estilo e a cor das linhas.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setDateAxisRange($startDate, $endDate)

Parâmetros:

$startDate: data inicial do eixo X (formato string, ex: "2025-01-01")

$endDate: data final do eixo X (formato string, ex: "2025-12-31")

O que faz:
Define o intervalo de datas exibido no eixo X do gráfico.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setMonthlyTickUnit($unit)

Parâmetros:

$unit: espaçamento entre os ticks do eixo X, em meses (ex: 150)

O que faz:
Define o espaçamento entre os marcadores (ticks) do eixo X, agrupando-os por unidade mensal.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setYAxisRange($min, $max)

Parâmetros:

$min: valor mínimo do eixo Y

$max: valor máximo do eixo Y

O que faz:
Define o intervalo de valores exibidos no eixo Y do gráfico.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setYAxisInterval($interval)

Parâmetros:

$interval: espaçamento entre os ticks (marcadores) do eixo Y

O que faz:
Define o espaçamento entre os marcadores (ticks) do eixo Y.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setYAxisFormat($format)

Parâmetros:

$format: string de formato para exibição dos valores do eixo Y (ex: ",##0.00")

O que faz:
Define como os valores do eixo Y serão exibidos (quantas casas decimais, separadores, etc).

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setXAxisLabelFont($font, $weight, $size)

Parâmetros:

$font: nome da fonte

$weight: peso da fonte

$size: tamanho da fonte

O que faz:
Define a fonte utilizada nos rótulos (labels) do eixo X.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setYAxisLabelFont($font, $weight, $size)

Parâmetros:

$font: nome da fonte

$weight: peso da fonte

$size: tamanho da fonte

O que faz:
Define a fonte utilizada nos rótulos (labels) do eixo Y.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setYAxisLegendFont($font, $weight, $size)

Parâmetros:

$font: nome da fonte

$weight: peso da fonte

$size: tamanho da fonte

O que faz:
Define a fonte utilizada na legenda (descrição) do eixo Y.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setXAxisLegendFont($font, $weight, $size)

Parâmetros:

$font: nome da fonte

$weight: peso da fonte

$size: tamanho da fonte

O que faz:
Define a fonte utilizada na legenda (descrição) do eixo X.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



setAxisOffsets($top, $bottom, $left, $right)

Parâmetros:

$top: margem superior

$bottom: margem inferior

$left: margem esquerda

$right: margem direita

O que faz:
Ajusta as margens internas do gráfico, controlando o espaçamento entre o conteúdo do gráfico e suas bordas.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.



rotateXLabelsUp()

Parâmetros:
(nenhum)

O que faz:
Rotaciona os rótulos do eixo X para cima (em ângulo), melhorando a legibilidade quando há muitos valores ou os rótulos são longos.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.setBackgroundRGB($r, $g, $b)

Parâmetros:

$r: valor do componente vermelho (0-255)

$g: valor do componente verde (0-255)

$b: valor do componente azul (0-255)

O que faz:
Define a cor de fundo do gráfico.

Retorno:
Não retorna valor (função void). O ajuste é aplicado ao objeto gráfico.

----------------------------------------------------------------------------------------------------------------