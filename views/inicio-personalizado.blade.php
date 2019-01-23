@extends('ecsl-2019::base')

@section('container')

<style>

body {
  padding-top: 0px;
}


</style>

<script type="text/javascript">
  $(document).ready(function(){
    am4core.options.commercialLicense = true

    var city
    var tm = 1
    var country
    var mapChart
    var lineChart
    var lineSeries

    var valueAxis

    var pieChart
    var pieSeries
    var mapPreview

    var colorSet
    var cityCircle

    // Set themes
    am4core.useTheme(am4themes_animated)
    am4core.useTheme(am4themes_amchartsdark)

    colorSet = new am4core.ColorSet()


    setTimeout (init, 500)


    function init () {
      mainContainer = am4core.create("map-preview", am4core.Container)
      mainContainer.width = am4core.percent(100)
      mainContainer.height = am4core.percent(100)
      mainContainer.preloader.disabled = true

      // area chart on initial screen (the one which bends around pie chart)
      lineChart = mainContainer.createChild(am4charts.XYChart)
      lineChart.padding(0,0,0,0)

      var data = []
      var date = new Date(2000, 0, 1, 0, 0, 0, 0)

      for (var i = 0; i < 6; i ++) {
        var newDate = new Date(date.getTime())
        newDate.setDate(i + 1)

        data.push({ date: newDate, value: 32 })
      }

      lineChart.data = data

      var dateAxis = lineChart.xAxes.push(new am4charts.DateAxis())
      dateAxis.renderer.grid.template.location = 0
      dateAxis.renderer.ticks.template.disabled = true
      dateAxis.renderer.axisFills.template.disabled = true

      dateAxis.renderer.labels.template.disabled = true
      dateAxis.renderer.inside = true
      dateAxis.renderer.grid.template.disabled = true
      dateAxis.startLocation = 0.5
      dateAxis.endLocation = 0.5
      dateAxis.renderer.baseGrid.disabled = true
      dateAxis.tooltip.disabled = true
      dateAxis.renderer.line.disabled = true

      valueAxis = lineChart.yAxes.push(new am4charts.ValueAxis())
      valueAxis.tooltip.disabled = true
      valueAxis.renderer.ticks.template.disabled = true
      valueAxis.renderer.axisFills.template.disabled = true
      valueAxis.renderer.labels.template.disabled = true
      valueAxis.renderer.inside = true
      valueAxis.renderer.grid.template.disabled = true
      valueAxis.min = 0
      valueAxis.max = 100
      valueAxis.strictMinMax = true
      valueAxis.tooltip.disabled = true
      valueAxis.renderer.line.disabled = true
      valueAxis.renderer.baseGrid.disabled = true

      lineSeries = lineChart.series.push(new am4charts.LineSeries())
      lineSeries.dataFields.dateX = "date"
      lineSeries.dataFields.valueY = "value"
      lineSeries.sequencedInterpolation = true
      lineSeries.fillOpacity = 0.3
      lineSeries.strokeOpacity = 0
      lineSeries.tensionX = 0.75
      lineSeries.fill = am4core.color("#222a3f")
      lineSeries.fillOpacity = 1
      lineSeries.hidden = true
      // when line series is inited, start everything
      lineSeries.events.on("inited", startEverything);
    }

    function startEverything() {
      lineChart.visible = true;
      lineSeries.defaultState.transitionDuration = 1000 * tm;
      var animation = lineSeries.show();

      animation.events.on("animationended", function() {
        setTimeout(stage0, 500 * tm)
      })
    }


    function stage0 () {
    	if (!pieChart) {
    		pieChart = mainContainer.createChild(am4charts.PieChart)

    		pieChart.zindex = 15
    		pieChart.hiddenState.properties.opacity = 0
    		pieChart.width = 400
    		pieChart.x = am4core.percent(300 / 5)
    		pieChart.horizontalCenter = "middle"

    		pieChart.hiddenState.properties.opacity = 0
    		pieChart.defaultState.transitionDuration = 3500 * tm
    		pieChart.defaultState.transitionEasing = am4core.ease.elasticOut

        pieChart.data = [{
          "answer": "[bold]No[/b]",
          "value": 400,
          "fontColor": am4core.color("#222a3f")
        }, {
          "answer": "Derecho a la vida",
          "value": 200,
          "radius": 10
        }, {
          "answer": "Derecho a la educación",
          "value": 40,
          "disabled": true
        }, {
          "answer": "Derecho a la salud",
          "value": 30,
          "disabled": true
        }]

    		pieSeries = pieChart.series.push(new am4charts.PieSeries())
        pieSeries.dataFields.value = "value"
        pieSeries.dataFields.category = "answer"
        pieChart.innerRadius = 75
        pieChart.radius = 150

        // this makes initial animation
        pieSeries.hiddenState.properties.opacity = 0
        pieSeries.slices.template.cornerRadius = 7
        pieSeries.defaultState.transitionDuration = 2000 * tm
        pieSeries.hiddenState.transitionEasing = am4core.ease.sinOut

        pieSeries.labels.template.fillOpacity = 0.8
        pieSeries.labels.template.text = "{category}"
        pieSeries.alignLabels = false
        pieSeries.labels.template.radius = -53
        pieSeries.labels.template.propertyFields.disabled = "disabled"
        pieSeries.labels.template.propertyFields.fill = "fontColor"
        pieSeries.labels.template.propertyFields.radius = "radius"
        pieSeries.ticks.template.disabled = true

        //this makes initial animation from bottom
        pieSeries.hiddenState.properties.dy = 400
        pieSeries.defaultState.transitionEasing = am4core.ease.elasticOut
        pieSeries.defaultState.transitionDuration = 3500 * tm
      }

      pieChart.hide(0)
      pieChart.show()

      pieSeries.hide(0)
      var animation = pieSeries.show()
      animation.events.on("animationended", createMap)
       // change duration and easing
      lineSeries.interpolationDuration = 3000 * tm;
      lineSeries.interpolationEasing = am4core.ease.elasticOut;

      lineSeries.dataItems.getIndex(3).setValue("valueY", 80, 3500 * tm);
    }

    function stage1 () {
    	var series = pieChart.series.getIndex(0)
      var firstDataItem = series.dataItems.getIndex(0)

      setTimeout(function() {
        var animation
        series.dataItems.each(function(dataItem) {
          if (dataItem.index != 1) {
            animation = dataItem.hide()
          }
          dataItem.label.hide()
        })

        animation.events.on("animationended", function() {
          var animation = series.dataItems.getIndex(1).slice.animate({ property: "innerRadius", to: 0 }, 300 * tm)
          animation.events.on("animationended", function() {
            setTimeout(showMap, 50)
          })
        })
      }, 1000 * tm)
    }

    function stage2 () {
    	polygonSeries.show(0)

      var polygonPoint = { x: initialPolygon.polygon.bbox.x + initialPolygon.polygon.bbox.width / 2, y: initialPolygon.polygon.bbox.y + initialPolygon.polygon.bbox.height / 2 }
      var seriesPoint = am4core.utils.spritePointToSprite(polygonPoint, initialPolygon.polygon, polygonSeries)

      var geoPoint = mapChart.seriesPointToGeo(seriesPoint)
      mapChart.zoomToGeoPoint(geoPoint, mapChart.zoomLevel, true, 0)

      initialPolygon.polygon.morpher.morphToCircle(slice.radius / mapChart.zoomLevel / mapChart.scaleRatio, 0)
      initialPolygon.visible = true
      initialPolygon.fillOpacity = 1
      initialPolygon.opacity = 1
      initialPolygon.strokeOpacity = 0
      initialPolygon.toFront()
      initialPolygon.tooltipText = "{title}"
      polygonSeries.opacity = 1

      setTimeout(function() {
      	pieChart.visible = false

      	var animation = initialPolygon.polygon.morpher.morphBack(1500 * tm)
     	 	animation.events.on("animationended", function() {
    	   	pieSeries.dataItems.each(function(dataItem) {
    	      dataItem.show(0)
    	   	})

          lineSeries.interpolationEasing = am4core.ease.cubicOut;
          lineSeries.hiddenState.transitionDuration = 700 * tm;

          var hideAnimation = lineSeries.hide();

          hideAnimation.events.on("animationended", function() {
            lineSeries.dataItems.getIndex(3).setValue("valueY", 31, 0);
            lineSeries.dataItems.getIndex(3).setWorkingValue("valueY", 0, 0);
            lineChart.visible = false;

            continentSeries.show();
            setTimeout(stage3, 1000 * tm);
          })
    	  }, 100)
    	})
    }

    function stage3 () {
    	cityCircle.hide(0)
      var animation = cityCircle.show(1500 * tm)

      cityLabel.hide(0)
      cityLabel.show(1000)

      animation.events.on("animationended", function() {
        var zoomAnim = mapChart.zoomToMapObject(city, 4, true, 500 * tm)
      })
    }

    var polygonSeries
    var continentSeries
    var cityLabel
    var sfLabel

    function createMap () {
    	country = { id: "SV", city: "El Salvador", latitude: 13.7, longitude: -89.2 }

    	mapChart = mainContainer.createChild(am4maps.MapChart)
    	mapChart.seriesContainer.draggable = false
      mapChart.seriesContainer.resizable = false
      mapChart.resizable = false

      mapChart.geodataSource.url = "//www.amcharts.com/lib/4/geodata/json/continentsHigh.json"
      mapChart.projection = new am4maps.projections.Mercator()
      mapChart.x = am4core.percent(300 / 5)
      mapChart.y = mainContainer.pixelHeight / 2
      mapChart.horizontalCenter = "middle"
      mapChart.verticalCenter = "middle"
      mapChart.showOnInit = false
      mapChart.hiddenState.properties.opacity = 1
      mapChart.deltaLongitude = -11
      mapChart.zIndex = 10
      mapChart.mouseWheelBehavior = "none"

       // make it pacific centered
      if (country.longitude > 90) {
        mapChart.deltaLongitude = -160
      }

      continentSeries = mapChart.series.push(new am4maps.MapPolygonSeries())
      continentSeries.useGeodata = true
      continentSeries.exclude = ["antarctica"]

      continentSeries.mapPolygons.template.fill = am4core.color("#2c3e50")
      continentSeries.mapPolygons.template.stroke = am4core.color("#313950")
      continentSeries.mapPolygons.template.hiddenState.properties.visible = true
      continentSeries.mapPolygons.template.hiddenState.properties.opacity = 1
      continentSeries.hidden = true

      polygonSeries = mapChart.series.push(new am4maps.MapPolygonSeries())
      polygonSeries.useGeodata = true

      polygonSeries.geodataSource.url = "https://www.amcharts.com/wp-content/uploads/assets/maps/worldCustomHigh.json"
      polygonSeries.include = ["US", country.id]

      polygonSeries.mapPolygons.template.fill = am4core.color("#2c3e50")
      polygonSeries.mapPolygons.template.stroke = am4core.color("#313950")
      polygonSeries.mapPolygons.template.hiddenState.properties.visible = true
      polygonSeries.mapPolygons.template.hiddenState.properties.opacity = 1
      polygonSeries.showOnInit = true
      polygonSeries.hiddenState.properties.opacity = 1
      polygonSeries.hidden = true

      var mapImageSeries = mapChart.series.push(new am4maps.MapImageSeries())

      city = mapImageSeries.mapImages.create()
      city.latitude = country.latitude
      city.longitude = country.longitude
      city.nonScaling = true

      cityLabel = city.createChild(am4core.Label)
      cityLabel.text = country.city
      cityLabel.verticalCenter = "middle"

      cityLabel.dx = 15
      cityLabel.dy = -1
      cityLabel.fontSize = 16
      cityLabel.hiddenState.properties.dy = 100
      cityLabel.hide(0)

      cityCircle = city.createChild(am4core.Circle)
      cityCircle.fill = colorSet.getIndex(0)
      cityCircle.stroke = cityCircle.fill
      cityCircle.radius = 7

      cityCircle.hiddenState.properties.radius = 0
      cityCircle.defaultState.transitionEasing = am4core.ease.elasticOut
      cityCircle.defaultState.transitionDuration = 2000 * tm
      cityCircle.hide(0)

      mapChart.events.on("inited",
        function() {
          setTimeout(stage1, 100)
        }
      )
    }

    function showMap () {
    	var polygon = polygonSeries.getPolygonById(country.id)
      if (!polygon) {
        polygonSeries.geodataSource.events.on("ended", function() {
          setTimeout(function() {
            preStage2(country)
          }, 100)
        })
      }
      else {
        preStage2(country)
      }
    }

    function preStage2 (country) {
      initialPolygon = polygonSeries.getPolygonById(country.id)

      slice = pieChart.series.getIndex(0).dataItems.getIndex(1).slice

      var w = initialPolygon.polygon.bbox.width * mapChart.scaleRatio
      var h = initialPolygon.polygon.bbox.height * mapChart.scaleRatio

      initialPolygon.fill = slice.fill

      mapChart.zoomToGeoPoint({ latitude: initialPolygon.latitude, longitude: initialPolygon.longitude }, (slice.radius * 2) / Math.max(w, h), true, 0)

      continentSeries.visible = false
      continentSeries.opacity = 0

      polygonSeries.dataItems.each(function(dataItem) {
        dataItem.mapPolygon.visible = false
        dataItem.mapPolygon.fillOpacity = 0
      })

      setTimeout(stage2, 100 * tm)
    }

  });
</script>

<div class="oadh-banner">
  <div class="banner-wrapper">
    <div id="map-preview"></div>
    <div class="container">
      <div class="oadh-banner-description">
        <h2 class="website-description">XI Encuentro Centroamérica de Sofware Libre.</h2>
        <p class="website-date">?, ? y ? de julio del 2019.</p>
        <button class="btn-lg btn-welcome">Explorar</button>
      </div>
    </div>
  </div>
</div>


<!-- <div class="ecsl-banner">
  <div class="banner-wrapper">
    <div id="chartdiv"></div>
    <div class="container">
      <div class="ecsl-banner-description">
        <h2 class="font-weight-bold">XI Encuentro Centroamericano de <br> Sofware Libre.</h2>
        <p class="font-weight-bold">?, ? y ? de julio del 2019</p>
      </div>
    </div>
  </div>
</div> -->

<!-- CARRUSEL-->
<!-- <header>
  <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselIndicators" data-slide-to="1"></li>
    </ol>

    <div class="carousel-inner" role="listbox">
      <div class="carousel-item active" style="background-image: url('https://storage.googleapis.com/decimaerp/organizations/15/carousel2.jpg')"></div>

      <div class="carousel-item" style="background-image: url('https://storage.googleapis.com/decimaerp/organizations/15/carousel3.jpg')"></div>

    </div>



    <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
    <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
  </div>
</header> -->

<!--Acerca de-->
<section class="">
  <div class="jumbotron jumbotron-fluid bg-darkblue">
    <div class="container">
      <h2 class="text-center text-white"><strong>XI Encuentro Centroamericano de Software Libre</strong></h2>
      <h4 class="text-center text-white font-weight-bold">?, ? y ? de julio del 2019</h4>
      <p class="lead text-center text-white">El Encuentro Centroamericano de Software Libre (ECSL) es un evento anual organizado desde el año 2009 por y para la comunidad  de Software Libre Centroamérica (SLCA). El ECSL es una reunión de activistas e integrantes de comunidades y grupos de
        usuarios/as que sirve como punto de encuentro y espacio de articulación, educación, coordinación e intercambio de ideas para fortalecer acuerdos y formas de trabajo conjuntas que faciliten la promoción del uso y desarrollo del Software Libre en
        la región.</p>
      <!-- <div id="btn-registration" class="text-center" style="margin:0 auto;">
        <a class="btn btn-lg btn-outline-primary" href="{{ URL::to('/registro') }}">Registrarse</a>
      </div> -->
    </div>
  </div>
</section>

<!-- Page Content -->
<div class="container">

  <!-- Marketing Icons Section -->
  <div class="row">
    <div class="col-lg-4 mb-4">
      <div class="card">
        <!-- <a href="https://www.youtube.com/watch?v=gY9b9RMMqCU" data-toggle="lightbox" data-gallery="youtubevideos">
          <img src="http://i3.ytimg.com/vi/gY9b9RMMqCU/mqdefault.jpg" class="card-img-top img-fluid">
        </a> -->
        <a href="http://ecsl2018.softwarelibre.ca/" target="_blank">
          <img src="https://storage.googleapis.com/decimaerp/organizations/15/ECSL_2018_036.jpg" class="card-img-top img-fluid">
        </a>
        <div class="card-body">
          <h5 id="ecsl-2017-card-title" class="card-title text-center">X ECSL 2018 <br> San Salvador, El Salvador</h5>
          <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
          <a href="http://ecsl2018.softwarelibre.ca/" target="_blank" class="btn btn-outline-primary">Ver sitio web</a>
          <!-- <a href="https://www.youtube.com/watch?v=gY9b9RMMqCU" class="btn btn-outline-primary" data-toggle="lightbox">Ver video</a> -->
        </div>
      </div>
    </div>
    <div class="col-lg-4 mb-4">
      <div class="card">
        <!-- <a href="https://www.youtube.com/watch?v=gY9b9RMMqCU" data-toggle="lightbox" data-gallery="youtubevideos">
          <img src="http://i3.ytimg.com/vi/gY9b9RMMqCU/mqdefault.jpg" class="card-img-top img-fluid">
        </a> -->
        <a href="http://ecsl2017.softwarelibre.ca/" target="_blank">
          <img src="https://storage.googleapis.com/decimaerp/organizations/15/costarica_thumbnail.jpg" class="card-img-top img-fluid">
        </a>
        <div class="card-body">
          <h5 id="ecsl-2017-card-title" class="card-title text-center">IX ECSL 2017 <br> San José, Costa Rica</h5>
          <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
          <a href="http://ecsl2017.softwarelibre.ca/" target="_blank" class="btn btn-outline-primary">Ver sitio web</a>
          <!-- <a href="https://www.youtube.com/watch?v=gY9b9RMMqCU" class="btn btn-outline-primary" data-toggle="lightbox">Ver video</a> -->
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card">
        <a href="https://www.youtube.com/watch?v=gY9b9RMMqCU" data-toggle="lightbox" data-gallery="youtubevideos">
          <img src="https://storage.googleapis.com/decimaerp/organizations/15/nicaragua_thumbnail.jpg" class="card-img-top img-fluid">
        </a>
        <div class="card-body">
          <h5 class="card-title text-center">VIII ECSL 2016 <br> Managua, Nicaragua</h5>
          <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
          <a href="http://encuentro.softwarelibre.ca/2016/" target="_blank" class="btn btn-outline-primary">Ver sitio web</a>
          <a href="https://www.youtube.com/watch?v=gY9b9RMMqCU" class="btn btn-outline-primary" data-toggle="lightbox">Ver video</a>
        </div>
      </div>
    </div>
    <!-- <div class="col-lg-4 mb-4">
      <div class="card h-100">
        <h4 class="card-header">Card Title</h4>
        <div class="card-body">
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
        </div>
        <div class="card-footer">
          <a href="#" class="btn btn-primary">Learn More</a>
        </div>
      </div>
    </div> -->

  </div>
  <!-- /.row -->
  <div class="row mb-4">
    <div class="col-md-8">
      <p class="text-center">¡Conoce los países y lugares en los que el Encuentro Centroamericano de Software Libre se ha venido realizando desde al año 2009 y no pierdas la oportunidad de participar en la décima edición del evento El Salvador 2019!</p>
    </div>
    <div class="col-md-4">
      <a class="btn btn-lg btn-outline-primary btn-block" href="{{URL::to('cms/eventos-anteriores')}}">Ver todos los eventos anteriores</a>
    </div>
  </div>

  <!-- <hr> -->
</div>
<!-- /.container -->

<!--Informacion General-->
<section class="about-us section-padding">
  <div class="jumbotron jumbotron-fluid bg-darkblue">
    <div class="container">
      <h2 class="display-5 text-center text-white">Información General</h2><br>
      <div class="row">
        <div class="col-12 col-sm-6 text-center col-md-3">
          <a href="{{URL::to('cms/logistica')}}" class="text-white">
                  <i class="fa fa-user-circle-o main-icons" aria-hidden="true"></i> <h3>Participación</h3>
                </a>
        </div>


        <div class="col-12 col-sm-6 text-center col-md-3">
          <a href="{{URL::to('cms/logistica')}}" class="text-white">
                <i class="fa fa-bed main-icons" aria-hidden="true"></i><h3>Hospedaje</h3>
              </a>
        </div>


        <div class="col-12 col-sm-6 text-center col-md-3">
          <a href="{{URL::to('cms/logistica')}}" class="text-white">
                <i class="fa fa-university main-icons" aria-hidden="true"></i><h3>Sede</h3>
                </a>
        </div>

        <div class="col-12 col-sm-6 text-center col-md-3">
          <a href="{{URL::to('cms/faq')}}" class="text-white">
              <i class="fa fa-question-circle-o main-icons" aria-hidden="true"></i><h3>FAQ</h3>
            </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Page Content -->
<div class="container">


  <!-- Portfolio Section -->
  <h2 class="text-center display-5">Patrocinadores</h2><br>

  <div class="row">
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo card-header-logo-padding">
          <a href="#" target="_blank">
            <img class="card-img-top img-fluid" src='data:image/svg+xml;charset=UTF-8,<svg%20width%3D"200"%20height%3D"200"%20xmlns%3D"http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg"%20viewBox%3D"0%200%20200%20200"%20preserveAspectRatio%3D"none"><defs><style%20type%3D"text%2Fcss">%23holder_1687c9c531f%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20<%2Fstyle><%2Fdefs><g%20id%3D"holder_1687c9c531f"><rect%20width%3D"200"%20height%3D"200"%20fill%3D"%23777"><%2Frect><g><text%20x%3D"73.640625"%20y%3D"104.5">200x200<%2Ftext><%2Fg><%2Fg><%2Fsvg>'>
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="#" target="_blank" class="card-logo-title">
              Patrocinador
            </a>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo card-header-logo-padding">
          <a href="#" target="_blank">
            <img class="card-img-top img-fluid" src='data:image/svg+xml;charset=UTF-8,<svg%20width%3D"200"%20height%3D"200"%20xmlns%3D"http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg"%20viewBox%3D"0%200%20200%20200"%20preserveAspectRatio%3D"none"><defs><style%20type%3D"text%2Fcss">%23holder_1687c9c531f%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20<%2Fstyle><%2Fdefs><g%20id%3D"holder_1687c9c531f"><rect%20width%3D"200"%20height%3D"200"%20fill%3D"%23777"><%2Frect><g><text%20x%3D"73.640625"%20y%3D"104.5">200x200<%2Ftext><%2Fg><%2Fg><%2Fsvg>'>
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="#" target="_blank" class="card-logo-title">
              Patrocinador
            </a>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo card-header-logo-padding">
          <a href="#" target="_blank">
            <img class="card-img-top img-fluid" src='data:image/svg+xml;charset=UTF-8,<svg%20width%3D"200"%20height%3D"200"%20xmlns%3D"http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg"%20viewBox%3D"0%200%20200%20200"%20preserveAspectRatio%3D"none"><defs><style%20type%3D"text%2Fcss">%23holder_1687c9c531f%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20<%2Fstyle><%2Fdefs><g%20id%3D"holder_1687c9c531f"><rect%20width%3D"200"%20height%3D"200"%20fill%3D"%23777"><%2Frect><g><text%20x%3D"73.640625"%20y%3D"104.5">200x200<%2Ftext><%2Fg><%2Fg><%2Fsvg>'>
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="#" target="_blank" class="card-logo-title">
              Patrocinador
            </a>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo card-header-logo-padding">
          <a href="#" target="_blank">
            <img class="card-img-top img-fluid" src='data:image/svg+xml;charset=UTF-8,<svg%20width%3D"200"%20height%3D"200"%20xmlns%3D"http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg"%20viewBox%3D"0%200%20200%20200"%20preserveAspectRatio%3D"none"><defs><style%20type%3D"text%2Fcss">%23holder_1687c9c531f%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20<%2Fstyle><%2Fdefs><g%20id%3D"holder_1687c9c531f"><rect%20width%3D"200"%20height%3D"200"%20fill%3D"%23777"><%2Frect><g><text%20x%3D"73.640625"%20y%3D"104.5">200x200<%2Ftext><%2Fg><%2Fg><%2Fsvg>'>
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="#" target="_blank" class="card-logo-title">
              Patrocinador
            </a>
          </h6>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->
</div>
<!-- /.container -->
@parent
@stop
