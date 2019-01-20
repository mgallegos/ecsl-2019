@extends('ecsl-2019::base')

@section('container')

<style>

#chartdiv {
  width: 100%;
  height: 500px;
}

.ecsl-banner {
	width: 100%;
	background-color: #fff;
}

.ecsl-banner .banner-wrapper {
	width: 100%;
	height: 100%;
	overflow-x: hidden;
}

.ecsl-banner .banner-wrapper .ecsl-banner-description {
	z-index: 100;
  background-color:transparent;
  float : left;
  margin-top: -220px;
  padding: 10px;
}

</style>

<script type="text/javascript">
  $(document).ready(function(){
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create map instance
    var chart = am4core.create("chartdiv", am4maps.MapChart);
    chart.geodata = am4geodata_worldLow;
    chart.projection = new am4maps.projections.Miller();
    chart.homeZoomLevel = 10;
    chart.homeGeoPoint = {
      latitude: 14,
      longitude: -89
    };

    // Create map polygon series
    var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
    polygonSeries.useGeodata = true;
    polygonSeries.mapPolygons.template.fill = chart.colors.getIndex(0).lighten(0.5);
    polygonSeries.exclude = ["AQ"];

    // Add line bullets
    var cities = chart.series.push(new am4maps.MapImageSeries());
    cities.mapImages.template.nonScaling = true;

    var city = cities.mapImages.template.createChild(am4core.Circle);
    city.radius = 6;
    city.fill = chart.colors.getIndex(0).brighten(-0.2);
    city.strokeWidth = 2;
    city.stroke = am4core.color("#fff");

    function addCity(coords, title) {
      var city = cities.mapImages.create();
      city.latitude = coords.latitude;
      city.longitude = coords.longitude;
      city.tooltipText = title;
      return city;
    }

    var elSalvador = addCity({ "latitude": 13.8333000, "longitude": -88.9167000 }, "El Salvador");
    var guatemala = addCity({ "latitude": 15.5000000, "longitude": -90.2500000 }, "Guatemala");

    // Add lines
    var lineSeries = chart.series.push(new am4maps.MapArcSeries());
    lineSeries.mapLines.template.line.strokeWidth = 2;
    lineSeries.mapLines.template.line.strokeOpacity = 0.5;
    lineSeries.mapLines.template.line.stroke = city.fill;
    lineSeries.mapLines.template.line.nonScalingStroke = true;
    lineSeries.mapLines.template.line.strokeDasharray = "1,1";
    lineSeries.zIndex = 10;

    var shadowLineSeries = chart.series.push(new am4maps.MapLineSeries());
    shadowLineSeries.mapLines.template.line.strokeOpacity = 0;
    shadowLineSeries.mapLines.template.line.nonScalingStroke = true;
    shadowLineSeries.mapLines.template.shortestDistance = false;
    shadowLineSeries.zIndex = 5;

    function addLine(from, to) {
      var line = lineSeries.mapLines.create();
      line.imagesToConnect = [from, to];
      line.line.controlPointDistance = -0.3;

      var shadowLine = shadowLineSeries.mapLines.create();
      shadowLine.imagesToConnect = [from, to];

      return line;
    }

    addLine(elSalvador, guatemala);


    // Add plane
    var plane = lineSeries.mapLines.getIndex(0).lineObjects.create();
    plane.position = 0;
    plane.width = 10;
    plane.height = 10;

    plane.adapter.add("scale", (scale, target) => {
      return 0.5 * (1 - (Math.abs(0.5 - target.position)));
    })

    var planeImage = plane.createChild(am4core.Sprite);
    planeImage.scale = 0.04;
    planeImage.horizontalCenter = "middle";
    planeImage.verticalCenter = "middle";
    planeImage.path = "m2,106h28l24,30h72l-44,-133h35l80,132h98c21,0 21,34 0,34l-98,0 -80,134h-35l43,-133h-71l-24,30h-28l15,-47";
    planeImage.fill = chart.colors.getIndex(2).brighten(-0.2);
    planeImage.strokeOpacity = 0;

    var shadowPlane = shadowLineSeries.mapLines.getIndex(0).lineObjects.create();
    shadowPlane.position = 0;
    shadowPlane.width = 10;
    shadowPlane.height = 10;

    var shadowPlaneImage = shadowPlane.createChild(am4core.Sprite);
    shadowPlaneImage.scale = 0.01;
    shadowPlaneImage.horizontalCenter = "middle";
    shadowPlaneImage.verticalCenter = "middle";
    shadowPlaneImage.path = "m2,106h28l24,30h72l-44,-133h35l80,132h98c21,0 21,34 0,34l-98,0 -80,134h-35l43,-133h-71l-24,30h-28l15,-47";
    shadowPlaneImage.fill = am4core.color("#000");
    shadowPlaneImage.strokeOpacity = 0;

    shadowPlane.adapter.add("scale", (scale, target) => {
      target.opacity = (0.6 - (Math.abs(0.5 - target.position)));
      return 0.5 - 0.3 * (1 - (Math.abs(0.5 - target.position)));
    })

    // Plane animation
    var currentLine = 0;
    var direction = 1;

    function flyPlane() {

      // Get current line to attach plane to
      plane.mapLine = lineSeries.mapLines.getIndex(currentLine);
      plane.parent = lineSeries;
      shadowPlane.mapLine = shadowLineSeries.mapLines.getIndex(currentLine);
      shadowPlane.parent = shadowLineSeries;
      shadowPlaneImage.rotation = planeImage.rotation;

      // Set up animation
      var from, to;
      var numLines = lineSeries.mapLines.length;
      if (direction == 1) {
          from = 0
          to = 1;
          if (planeImage.rotation != 0) {
              planeImage.animate({ to: 0, property: "rotation" }, 1000).events.on("animationended", flyPlane);
              return;
          }
      }
      else {
          from = 1;
          to = 0;
          if (planeImage.rotation != 180) {
              planeImage.animate({ to: 180, property: "rotation" }, 1000).events.on("animationended", flyPlane);
              return;
          }
      }

      // Start the animation
      var animation = plane.animate({
          from: from,
          to: to,
          property: "position"
      }, 5000, am4core.ease.sinInOut);
      animation.events.on("animationended", flyPlane)
      /*animation.events.on("animationprogress", function(ev) {
        var progress = Math.abs(ev.progress - 0.5);
        //console.log(progress);
        //planeImage.scale += 0.2;
      });*/

      shadowPlane.animate({
          from: from,
          to: to,
          property: "position"
      }, 5000, am4core.ease.sinInOut);

      // Increment line, or reverse the direction
      currentLine += direction;
      if (currentLine < 0) {
          currentLine = 0;
          direction = 1;
      }
      else if ((currentLine + 1) > numLines) {
          currentLine = numLines - 1;
          direction = -1;
      }

    }

    // Go!
    flyPlane();
  });
</script>


<div class="ecsl-banner">
  <div class="banner-wrapper">
    <div id="chartdiv"></div>
    <div class="container">
      <div class="ecsl-banner-description">
        <h2 class="font-weight-bold">XI Encuentro Centroamericano de <br> Sofware Libre.</h2>
        <p class="font-weight-bold">12, 13 y 14 de julio del 2019</p>
      </div>
    </div>
  </div>
</div>

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
  <div class="jumbotron jumbotron-fluid bg-dark">
    <div class="container">
      <h2 class="text-center text-white"><strong>X Encuentro Centroamericano de Software Libre</strong></h2>
      <h4 class="text-center text-white font-weight-bold">12, 13 y 14 de julio del 2019</h4>
      <p class="lead text-center text-white">El Encuentro Centroamericano de Software Libre (ECSL) es un evento anual organizado desde el año 2009 por y para la comunidad  de Software Libre Centroamérica (SLCA). El ECSL es una reunión de activistas e integrantes de comunidades y grupos de
        usuarios/as que sirve como punto de encuentro y espacio de articulación, educación, coordinación e intercambio de ideas para fortalecer acuerdos y formas de trabajo conjuntas que faciliten la promoción del uso y desarrollo del Software Libre en
        la región.</p>
      <!-- <div id="btn-registration" class="text-center" style="margin:0 auto;">
        <a class="btn btn-lg btn-secondary" href="{{ URL::to('/registro') }}">Registrarse</a>
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
        <a href="http://ecsl2017.softwarelibre.ca/" target="_blank">
          <img src="https://storage.googleapis.com/decimaerp/organizations/15/costarica_thumbnail.jpg" class="card-img-top img-fluid">
        </a>
        <div class="card-body">
          <h5 id="ecsl-2017-card-title" class="card-title text-center">IX ECSL 2017 <br> San José, Costa Rica</h5>
          <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
          <a href="http://ecsl2017.softwarelibre.ca/" target="_blank" class="btn btn-secondary">Ver sitio web</a>
          <!-- <a href="https://www.youtube.com/watch?v=gY9b9RMMqCU" class="btn btn-secondary" data-toggle="lightbox">Ver video</a> -->
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
          <a href="http://encuentro.softwarelibre.ca/2016/" target="_blank" class="btn btn-secondary">Ver sitio web</a>
          <a href="https://www.youtube.com/watch?v=gY9b9RMMqCU" class="btn btn-secondary" data-toggle="lightbox">Ver video</a>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card">
        <!-- <a href="https://www.youtube.com/watch?v=gY9b9RMMqCU" data-toggle="lightbox" data-gallery="youtubevideos">
          <img src="http://i3.ytimg.com/vi/gY9b9RMMqCU/mqdefault.jpg" class="card-img-top img-fluid">
        </a> -->
        <a href="http://ecsl2015.softwarelibre.ca/" target="_blank">
          <img src="https://storage.googleapis.com/decimaerp/organizations/15/honduras_thumbnail.jpg" class="card-img-top img-fluid">
        </a>
        <div class="card-body">
          <h5 class="card-title text-center">VII ECSL 2015 <br> San Pedro Sula, Honduras</h5>
          <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
          <a href="http://ecsl2015.softwarelibre.ca/" target="_blank" class="btn btn-secondary">Ver sitio web</a>
          <!-- <a href="https://www.youtube.com/watch?v=gY9b9RMMqCU" class="btn btn-secondary" data-toggle="lightbox">Ver video</a> -->
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
      <a class="btn btn-lg btn-secondary btn-block" href="{{URL::to('cms/eventos-anteriores')}}">Ver todos los eventos anteriores</a>
    </div>
  </div>

  <!-- <hr> -->
</div>
<!-- /.container -->

<!--Informacion General-->
<section class="about-us section-padding">
  <div class="jumbotron jumbotron-fluid bg-dark">
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
          <a href="http://www.uca.edu.sv" target="_blank">
            <img class="card-img-top img-fluid" src="https://storage.googleapis.com/decimaerp/organizations/15/logo_uca.png">
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="http://www.uca.edu.sv" target="_blank" class="card-logo-title">
              Universidad Centroamericana José Simeón Cañas
            </a>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo card-header-logo-padding">
          <a href="http://www.slsv.org/" target="_blank">
            <img class="card-img-top img-fluid" src="https://storage.googleapis.com/decimaerp/organizations/15/logo_slsv.png">
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="http://www.slsv.org/" target="_blank" class="card-logo-title">
              Comunidad Salvadoreña de Software Libre
            </a>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo mt-2">
          <a href="http://www.salud.gob.sv/" target="_blank">
            <img class="card-img-top img-fluid" src="https://storage.googleapis.com/decimaerp/organizations/15/logo_minsal.png">
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="http://www.salud.gob.sv/" target="_blank" class="card-logo-title">
              Ministerio de Salud
            </a>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo">
          <a href="http://www.decimaerp.com/" target="_blank">
            <img class="card-img-top img-fluid" src="https://storage.googleapis.com/decimaerp/organizations/15/logo_decimaerp_.png">
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="http://www.decimaerp.com/" target="_blank" class="card-logo-title">
              DecimaERP
            </a>
          </h6>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo">
          <a href="https://uls.edu.sv/sitioweb/" target="_blank">
            <img class="card-img-top img-fluid" src="https://storage.googleapis.com/decimaerp/organizations/15/logo_luterana.jpg">
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="https://uls.edu.sv/sitioweb/" target="_blank" class="card-logo-title">
              Universidad Luterana Salvadoreña
            </a>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo">
          <a href="http://delfos-cloud.com/" target="_blank">
            <img class="card-img-top img-fluid" src="https://storage.googleapis.com/decimaerp/organizations/15/logo_delfos_cloud.jpg">
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="http://delfos-cloud.com/" target="_blank" class="card-logo-title">
              Delfos Cloud
            </a>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo card-header-logo-padding">
          <a href="http://www.ieproes.edu.sv/" target="_blank">
            <img class="card-img-top img-fluid" src="https://storage.googleapis.com/decimaerp/organizations/15/logo_ieproes.jpg">
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="http://www.ieproes.edu.sv/" target="_blank" class="card-logo-title">
              IEPROES
            </a>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo">
          <a href="https://www.pagadito.com/" target="_blank">
            <img class="card-img-top img-fluid" src="https://storage.googleapis.com/decimaerp/organizations/15/logo_pagadito.png">
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="https://www.pagadito.com/" target="_blank" class="card-logo-title">
              Pagadito
            </a>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo">
          <a href="https://es-la.facebook.com/LabCTsv/" target="_blank">
            <img class="card-img-top img-fluid" src="https://storage.googleapis.com/decimaerp/organizations/15/logo_labCT.png">
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="https://es-la.facebook.com/LabCTsv/" target="_blank" class="card-logo-title">
              LabCT
            </a>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo">
          <a href="http://hackerspace.teubi.co/" target="_blank">
            <img class="card-img-top img-fluid" src="https://storage.googleapis.com/decimaerp/organizations/15/logo_hackerspace.png">
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="http://hackerspace.teubi.co/" target="_blank" class="card-logo-title">
              Hacker space
            </a>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo">
          <a href="http://www.sv" target="_blank">
            <img class="card-img-top img-fluid" src="https://storage.googleapis.com/decimaerp/organizations/15/logo_svnet.jpg">
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="http://www.sv" target="_blank" class="card-logo-title">
              SVNet
            </a>
          </h6>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo">
          <a href="https://www.gridshield.com" target="_blank">
            <img class="card-img-top img-fluid" src="https://storage.googleapis.com/decimaerp/organizations/15/logo_gridshield.jpg">
          </a>
        </div>
        <div class="card-body">
          <h6 class="card-title text-center">
            <a href="https://www.gridshield.com" target="_blank" class="card-logo-title">
              Gridshield
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
