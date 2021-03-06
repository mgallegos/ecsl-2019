@extends('ecsl-2019::base')

@section('container')
<style>

body {
  padding-top: 0px;
}


</style>

<script type="text/javascript">

  // $.ajaxSetup({
  //   headers: {
  //       'X-CSRF-TOKEN': $('#app-token').val(),
  //   }
  // });

  jQuery.support.cors = true;


  var userCountryId = "US";
  // am4core.options.commercialLicense = true;

  // jQuery.getJSON( "https://services.amcharts.com/ip/?v=xz6Z", function( geo ) {
  //   console.log('hola mundo');
  //   console.log(geo);
  // });


  var ds = new am4core.DataSource();
  ds.url = "https://services.amcharts.com/ip/?v=xz6Z";
  ds.events.on("ended", function(ev)
  {
    if(ev.target.data != undefined)
    {
      userCountryId = ev.target.data.country_code;
    }
  });
  ds.load();

  console.log(userCountryId);

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

  var lineSeries;

  var lineSeries20;
  var lineSeries21;

  var sfCircle;
  var mapChart;
  var connectingLine;
  var plane;

  var city;
  var tm = 1;
  var planePath = "M71,515.3l-33,72.5c-0.9,2.1,0.6,4.4,2.9,4.4l19.7,0c2.8,0,5.4-1,7.5-2.9l54.1-39.9c2.4-2.2,5.4-3.4,8.6-3.4 l103.9,0c1.8,0,3,1.8,2.3,3.5l-64.5,153.7c-0.7,1.6,0.5,3.3,2.2,3.3l40.5,0c2.9,0,5.7-1.3,7.5-3.6L338.4,554c3.9-5,9.9-8,16.2-8c24.2,0,85.5-0.1,109.1-0.2c21.4-0.1,41-6.3,59-17.8c4.2-2.6,7.9-6.1,11.2-9.8c2.6-2.9,3.8-5.7,3.7-8.5c0.1-2.8-1.1-5.5-3.7-8.5c-3.3-3.7-7-7.2-11.2-9.8c-18-11.5-37.6-17.7-59-17.8c-23.6-0.1-84.9-0.2-109.1-0.2c-6.4,0-12.3-2.9-16.2-8L222.6,316.6c-1.8-2.3-4.5-3.6-7.5-3.6l-40.5,0c-1.7,0-2.9,1.7-2.2,3.3L237,470c0.7,1.7-0.5,3.5-2.3,3.5l-103.9,0c-3.2,0-6.2-1.2-8.6-3.4l-54.1-39.9c-2.1-1.9-4.7-2.9-7.5-2.9l-19.7,0c-2.3,0-3.8,2.4-2.9,4.4l33,72.5C72.6,507.7,72.6,511.8,71,515.3z";
  //var hPlanePath = "M176.4,56.7C195,67.2,305.9,130,363.9,162.6c3.5,2,7.4,3,11.5,3.1c29.7,0.3,59.5,0.1,89.2,0.2c21.4,0.1,41,6.3,59,17.8  c4.2,2.6,7.9,6.1,11.2,9.8c4.9,5.6,4.9,10.5,0.2,16.2c-2.9,3.5-6.4,6.8-10.3,9.4c-17.5,11.4-36.7,18.2-57.7,18.3  c-71.5,0.2-143,0.3-214.5-0.1c-27.6-0.1-54.7-5.3-81.5-11.3c-31.2-7-62.1-15.1-93.1-22.6c-3.9-0.9-6.1-2.8-7.6-6.7l-33.5-87.2h24.6  c2.8,0,5.4,1,7.5,2.9l54.1,49.9c2.4,2.2,5.4,3.4,8.6,3.4h97.7c0,0-70.9-70.8-108.3-108.3c-0.8-0.8-0.2-2.2,0.9-2.2h48.7  C172.7,55.2,174.6,55.7,176.4,56.7z"
  var lineChart;
  var valueAxis;
  var pieSeries;
  var mainContainer;
  var headerLabel;
  var footerLabel;
  var nextButton;

  var destinationCity;
  var destinationCityLabel;
  var destinationCityCircle;

  var tempInitialPolygon;
  var tempSliceFill;


  // Set themes
  am4core.useTheme(am4themes_animated)
  am4core.useTheme(am4themes_amchartsdark)

  colorSet = new am4core.ColorSet()

  function init () {
    mainContainer = am4core.create("map-preview", am4core.Container)
    mainContainer.width = am4core.percent(100)
    mainContainer.height = am4core.percent(100)
    mainContainer.preloader.disabled = true

    // header label
    headerLabel = mainContainer.createChild(am4core.TextLink)
    headerLabel.fill = am4core.color("#ffffff");
    headerLabel.background.fill = am4core.color("#2b3e50");//nuevo
    headerLabel.background.fillOpacity = 1;

    headerLabel.fontSize = 20;
    //headerLabel.isMeasured = false;
    headerLabel.horizontalCenter = "middle";
    headerLabel.verticalCenter = "middle";
    headerLabel.x = am4core.percent(300 / 5);
    headerLabel.y = 70;
    headerLabel.showOnInit = true;
    headerLabel.zIndex = 1300;

    headerLabel.hiddenState.properties.dy = - 150;
    headerLabel.hiddenState.transitionDuration = 700;
    headerLabel.defaultState.transitionDuration = 800;

    var triangle2 = new am4core.Triangle();
    triangle2.width = 8;
    triangle2.height = 10;
    triangle2.fill = am4core.color("#fff62e");
    triangle2.direction = "right";
    triangle2.valign = "middle";
    triangle2.align = "center";
    triangle2.dx = 1;

    // nextButton = mainContainer.createChild(am4core.Button);
    // nextButton.horizontalCenter = "middle";
    // nextButton.verticalCenter = "middle";
    // nextButton.padding(0, 0, 0, 0);
    // nextButton.background.cornerRadius(25, 25, 25, 25);
    // //nextButton.x = am4core.percent(300/5);
    // nextButton.y = headerLabel.y;
    // nextButton.dy = 1;
    // nextButton.height = 40;
    // nextButton.width = 40;
    // nextButton.horizontalCenter = "middle";
    // nextButton.verticalCenter = "middle";
    // nextButton.zIndex = 5000;
    // nextButton.icon = triangle2;
    // nextButton.hide(0);
    // nextButton.events.on("hit", repeat);

    footerLabel = mainContainer.createChild(am4core.Label);
    footerLabel.x = am4core.percent(300 / 5);
    footerLabel.y = am4core.percent(90);
    // footerLabel.fontSize = 60;
    // footerLabel.fill = am4core.color("#ffffff");
    // footerLabel.fill = am4core.color("#0a75da");
    footerLabel.fill = am4core.color("#ffffff");
    footerLabel.verticalCenter = "middle";
    footerLabel.horizontalCenter = "middle";
    // footerLabel.fillOpacity = 0.5;
    footerLabel.fontSize = 30;
    footerLabel.hide(0);

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
    // lineSeries.fill = am4core.color("#222a3f")
    lineSeries.fill = am4core.color("#2b3e50")
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
        "answer": "Ubuntu",
        "value": 106
        // "fontColor": am4core.color("#222a3f")
      }, {
        "answer": "Debian",
        "value": 97,
        "radius": 10
      }, {
        "answer": "Linux Mint",
        "value": 42
      }, {
        "answer": "CentOS",
        "value": 36
      }, {
        "answer": "Fedora",
        "value": 20
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
      pieSeries.defaultState.transitionDuration = 7500 * tm
    }

    pieChart.hide(0)
    pieChart.show()

    footerLabel.text = "Las 5 distribuciones Linux más utilizadas por la comunidad";
    footerLabel.background.fill = am4core.color("#2b3e50");//nuevo
    footerLabel.background.fillOpacity = 1;
    footerLabel.zIndex = 10000;
    footerLabel.fontSize = 20;
    footerLabel.show();

    pieSeries.hide(0)
    var animation = pieSeries.show()
    animation.events.on("animationended", createMap)
     // change duration and easing
    lineSeries.interpolationDuration = 3000 * tm;
    lineSeries.interpolationEasing = am4core.ease.elasticOut;

    lineSeries.dataItems.getIndex(3).setValue("valueY", 80, 3500 * tm);
  }

  function stage1 () {
    footerLabel.hide();
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

      zoomAnim.events.on("animationended", function() {
        stage5();
      })

    })
  }

  function stage5() {

    initialPolygon.fill = tempInitialPolygon;

    sfCircle.show();

    connectingLine.show();
    connectingLine.arrow.show();

    footerLabel.text = "¡Este año el ECSL será en Guatemala!";
    footerLabel.background.fill = am4core.color("#2b3e50");//nuevo
    footerLabel.background.fillOpacity = 1;
    footerLabel.zIndex = 10000;
    footerLabel.fontSize = 30;
    footerLabel.show();

    var showed = false;

    var animation = connectingLine.arrow.animate({ property: "position", from: 0, to: 1 }, 5000 * tm, am4core.ease.polyInOut3);
    animation.events.on("animationprogress", function(event) {
      var point = connectingLine.positionToPoint(event.progress);
      var geoPoint = mapChart.seriesPointToGeo(point);

      mapChart.zoomToGeoPoint(geoPoint, mapChart.zoomLevel, true, 0);
      mapChart.seriesContainer.validatePosition();

      if (event.progress > 0.90 && !showed) {
        cityLabel.hide(0);
        showed = true;
        sfLabel.hide(0);
        sfLabel.show(1000);
      }
    })

    animation.events.on("animationended", function(event) {
      setTimeout(stage6, 500);
    })
  }

  function stage6() {
    footerLabel.hide();
    connectingLine.hide();
    plane.parent = mapChart.seriesContainer;
    var currentScale = plane.scale;
    plane.adapter.remove("scale");
    plane.mapLine = undefined; // detaches from line to allow animations

    headerLabel.y = 70;

    sfLabel.hide();
    cityCircle.hide(0)
    // plane.hide(0);
    plane.animate([{ property: "rotation", to: 360 }, { property: "scale", from: currentScale, to: 0.22 }], 1000 * tm, am4core.ease.quadOut);
    var animation = sfCircle.animate([{ property: "radius", to: 1000 }, { property: "opacity", to: 0 }], 1000 * tm);
    animation.events.on("animationended", stage7);
    // animation.events.on("animationended", plane.hide(0));

    // stage7();
    // preStage7()
  }

  function preStage7()
  {
    console.log('entre 0');

    var polygon = polygonSeries.getPolygonById("GT")

    if (!polygon) {
      console.log('entre 1');
      polygonSeries.geodataSource.events.on("ended", function() {
        setTimeout(function() {
          stage7()
        }, 100)
      })
    }
    else {
      console.log('entre 2');
      stage7()
    }
  }

  function stage7() {
    plane.hide(0);

    destinationCityCircle.hide(0)

    endPolygon = polygonSeries.getPolygonById("GT")

    console.log(endPolygon);

    // slice = pieChart.series.getIndex(0).dataItems.getIndex(1).slice

    // var w = initialPolygon.polygon.bbox.width * mapChart.scaleRatio
    // var h = initialPolygon.polygon.bbox.height * mapChart.scaleRatio

    // tempInitialPolygon = initialPolygon.fill
    endPolygon.fill = tempSliceFill

    // endPolygon.polygon.morpher.morphToCircle(slice.radius / mapChart.zoomLevel / mapChart.scaleRatio, 0)
    endPolygon.visible = true
    endPolygon.fillOpacity = 1
    endPolygon.opacity = 1
    endPolygon.strokeOpacity = 0
    endPolygon.toFront()
    // initialPolygon.tooltipText = "{title}"
    // polygonSeries.opacity = 1

    var animation = destinationCityCircle.show(1500 * tm)

    destinationCityLabel.hide(0)
    destinationCityLabel.show(1000)

    animation.events.on("animationended", function() {
      var zoomAnim = mapChart.zoomToMapObject(destinationCity, 6, true, 500 * tm)

      zoomAnim.events.on("animationended", function() {

      })

    })
  }


  var polygonSeries
  var continentSeries
  var cityLabel
  var sfLabel

  function createMap () {

    var count = countries.length;
    var cindex = Math.floor(Math.random() * count);

    country = getCountryById(userCountryId);

    // country = { id: "SV", city: "El Salvador", latitude: 13.7, longitude: -89.2 }
    // country = { id: "PA", city: "Panama City", latitude: 8.9667, longitude: -79.5333 }

    // pick random if no such country in list
    if (!country || userCountryId == "GT") {
      var randomId = randomCountries[Math.floor(Math.random() * randomCountries.length)];
      country = getCountryById(randomId);
    }

    var destinations = [{ id: "GT", city: "Guatemala", latitude: 14.6167, longitude: -90.5167 }];

    // var destination = destinations[Math.floor(Math.random() * destinations.length)]
    var destination = destinations[0]

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
    // polygonSeries.geodataSource.url = "//www.amcharts.com/wp-content/uploads/assets/maps/worldCustomHigh.json"
    // polygonSeries.include = ["US", country.id]
    polygonSeries.include = ["MX", "SV", "CR", "PA", "NI", "HN", "GT"];


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
    cityLabel.fill = am4core.color("#ffffff");
    cityLabel.background.fill = am4core.color("#2b3e50");//nuevo
    cityLabel.background.fillOpacity = 1;
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

    destinationCity = mapImageSeries.mapImages.create()
    destinationCity.latitude = destination.latitude
    destinationCity.longitude = destination.longitude
    destinationCity.nonScaling = true

    destinationCityLabel = destinationCity.createChild(am4core.Label)
    destinationCityLabel.text = destination.city
    destinationCityLabel.verticalCenter = "middle"

    destinationCityLabel.dx = 15
    destinationCityLabel.dy = -1
    destinationCityLabel.fontSize = 16
    destinationCityLabel.fill = am4core.color("#ffffff");
    destinationCityLabel.background.fill = am4core.color("#2b3e50");//nuevo
    destinationCityLabel.background.fillOpacity = 1;
    destinationCityLabel.hiddenState.properties.dy = 100
    destinationCityLabel.hide(0)

    destinationCityCircle = destinationCity.createChild(am4core.Circle)
    destinationCityCircle.fill = colorSet.getIndex(0)
    destinationCityCircle.stroke = destinationCityCircle.fill
    destinationCityCircle.radius = 7

    destinationCityCircle.hiddenState.properties.radius = 0
    destinationCityCircle.defaultState.transitionEasing = am4core.ease.elasticOut
    destinationCityCircle.defaultState.transitionDuration = 2000 * tm
    destinationCityCircle.hide(0)

    //plane
    var sfCity = mapImageSeries.mapImages.create();
    sfCity.latitude = destination.latitude;
    sfCity.longitude = destination.longitude;
    sfCity.nonScaling = true;

    sfLabel = sfCity.createChild(am4core.Label);
    sfLabel.text = destination.city;

    sfLabel.verticalCenter = "middle";
    // sfLabel.fillOpacity = 0.5;
    sfLabel.dx = 22;
    sfLabel.dy = -1;
    sfLabel.hiddenState.properties.dy = 100;
    sfLabel.hide(0);
    sfLabel.fontSize = 18;
    sfLabel.fill = am4core.color("#ffffff");
    sfLabel.background.fill = am4core.color("#2b3e50");//nuevo
    sfLabel.background.fillOpacity = 1;

    sfCircle = sfCity.createChild(am4core.Circle);
    sfCircle.fill = colorSet.getIndex(2);
    sfCircle.stroke = sfCircle.fill;
    sfCircle.radius = 12;
    sfCircle.hiddenState.properties.radius = 0;
    sfCircle.defaultState.transitionEasing = am4core.ease.elasticOut;
    sfCircle.defaultState.transitionDuration = 2000 * tm;
    sfCircle.hide(0);

    var mapLineSeries = mapChart.series.push(new am4maps.MapLineSeries());
    connectingLine = mapLineSeries.mapLines.create();
    connectingLine.imagesToConnect = [city, sfCity];
    connectingLine.line.strokeDasharray = "0.5,0.5"
    connectingLine.line.strokeOpacity = 0.4;
    connectingLine.hide(0);

    plane = connectingLine.arrow;
    var planeImage = plane.createChild(am4core.Sprite);
    planeImage.path = planePath;
    planeImage.horizontalCenter = "middle";
    planeImage.verticalCenter = "middle";
    plane.fill = colorSet.getIndex(0);
    plane.position = 0;
    //arrow.nonScaling = true;
    plane.hide(0);

    plane.adapter.add("scale", function(scale, target) {
      return (0.08 - 0.10 * (Math.abs(0.5 - target.position))) / mapChart.zoomLevel;
    })

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

    tempInitialPolygon = initialPolygon.fill
    tempSliceFill = initialPolygon.fill = slice.fill

    mapChart.zoomToGeoPoint({ latitude: initialPolygon.latitude, longitude: initialPolygon.longitude }, (slice.radius * 2) / Math.max(w, h), true, 0)

    continentSeries.visible = false
    continentSeries.opacity = 0

    polygonSeries.dataItems.each(function(dataItem) {
      dataItem.mapPolygon.visible = false
      dataItem.mapPolygon.fillOpacity = 0
    })

    setTimeout(stage2, 100 * tm)
  }


var countries =
  [
    { id: "SS", city: "Juba", latitude: 4.85, longitude: 31.6167 },
    { id: "NZ", city: "Auckland", latitude: -36.8485, longitude: 174.7633 },
    { id: "LT", city: "Vilnius", latitude: 54.6833, longitude: 25.3167 },
    { id: "LU", city: "Luxembourg", latitude: 49.6, longitude: 6.1167 },
    { id: "MK", city: "Skopje", latitude: 42, longitude: 21.4333 },
    { id: "MG", city: "Antananarivo", latitude: -18.9167, longitude: 47.5167 },
    { id: "MW", city: "Lilongwe", latitude: -13.9667, longitude: 33.7833 },
    { id: "MY", city: "Kuala Lumpur", latitude: 3.1667, longitude: 101.7 },
    { id: "ML", city: "Bamako", latitude: 12.65, longitude: -8 },
    { id: "MR", city: "Nouakchott", latitude: 18.0667, longitude: -15.9667 },
    { id: "MX", city: "Mexico City", latitude: 19.4333, longitude: -99.1333 },
    { id: "MD", city: "Chisinau", latitude: 47, longitude: 28.85 },
    { id: "MN", city: "Ulaanbaatar", latitude: 47.9167, longitude: 106.9167 },
    { id: "ME", city: "Podgorica", latitude: 42.4333, longitude: 19.2667 },
    { id: "MA", city: "Rabat", latitude: 34.0167, longitude: -6.8167 },
    { id: "MZ", city: "Maputo", latitude: -25.95, longitude: 32.5833 },
    { id: "NA", city: "Windhoek", latitude: -22.5667, longitude: 17.0833 },
    { id: "NP", city: "Kathmandu", latitude: 27.7167, longitude: 85.3167 },
    { id: "NL", city: "Amsterdam", latitude: 52.35, longitude: 4.9167 },
    { id: "KW", city: "Kuwait City", latitude: 29.3667, longitude: 47.9667 },
    { id: "KG", city: "Bishkek", latitude: 42.8667, longitude: 74.6 },
    { id: "LA", city: "Vientiane", latitude: 17.9667, longitude: 102.6 },
    { id: "LV", city: "Riga", latitude: 56.95, longitude: 24.1 },
    { id: "LB", city: "Beirut", latitude: 33.8667, longitude: 35.5 },
    { id: "LS", city: "Maseru", latitude: -29.3167, longitude: 27.4833 },
    { id: "LR", city: "Monrovia", latitude: 6.3, longitude: -10.8 },
    { id: "LY", city: "Tripoli", latitude: 32.8833, longitude: 13.1667 },
    { id: "KR", city: "Seoul", latitude: 37.55, longitude: 126.9833 },
    { id: "JO", city: "Amman", latitude: 31.95, longitude: 35.9333 },
    { id: "KZ", city: "Astana", latitude: 51.1667, longitude: 71.4167 },
    { id: "KE", city: "Nairobi", latitude: -1.2833, longitude: 36.8167 },
    { id: "KP", city: "Pyongyang", latitude: 39.0167, longitude: 125.75 },
    { id: "JP", city: "Tokyo", latitude: 35.6833, longitude: 139.75 },
    { id: "IT", city: "Rome", latitude: 41.9, longitude: 12.4833 },
    { id: "JM", city: "Kingston", latitude: 18, longitude: -76.8 },
    { id: "IL", city: "Tel Aviv", latitude: 32.0853, longitude: 34.7818 },
    { id: "IR", city: "Tehran", latitude: 35.7, longitude: 51.4167 },
    { id: "IQ", city: "Baghdad", latitude: 33.3333, longitude: 44.4 },
    { id: "IE", city: "Dublin", latitude: 53.3167, longitude: -6.2333 },
    { id: "ID", city: "Jakarta", latitude: -6.1667, longitude: 106.8167 },
    { id: "IN", city: "Bangalore", latitude: 12.9716, longitude: 77.5946 },
    { id: "HN", city: "Tegucigalpa", latitude: 14.1, longitude: -87.2167 },
    { id: "HU", city: "Budapest", latitude: 47.5, longitude: 19.0833 },
    { id: "IS", city: "Reykjavik", latitude: 64.15, longitude: -21.95 },
    { id: "HT", city: "Port-au-Prince", latitude: 18.5333, longitude: -72.3333 },
    { id: "ER", city: "Asmara", latitude: 15.3333, longitude: 38.9333 },
    { id: "EE", city: "Tallinn", latitude: 59.4333, longitude: 24.7167 },
    { id: "ET", city: "Addis Ababa", latitude: 9.0333, longitude: 38.7 },
    { id: "FI", city: "Helsinki", latitude: 60.1667, longitude: 24.9333 },
    { id: "FR", city: "Paris", latitude: 48.8667, longitude: 2.3333 },
    { id: "GA", city: "Libreville", latitude: 0.3833, longitude: 9.45 },
    { id: "GM", city: "Banjul", latitude: 13.45, longitude: -16.5667 },
    { id: "GE", city: "Tbilisi", latitude: 41.6833, longitude: 44.8333 },
    { id: "DE", city: "Berlin", latitude: 52.5167, longitude: 13.4 },
    { id: "GH", city: "Accra", latitude: 5.55, longitude: -0.2167 },
    { id: "GR", city: "Athens", latitude: 37.9833, longitude: 23.7333 },
    { id: "GL", city: "Nuuk", latitude: 64.1833, longitude: -51.75 },
    { id: "GQ", city: "Malabo", latitude: 3.75, longitude: 8.7833 },
    { id: "EC", city: "Quito", latitude: -0.2167, longitude: -78.5 },
    { id: "EG", city: "Cairo", latitude: 30.05, longitude: 31.25 },
    { id: "SV", city: "San Salvador", latitude: 13.7, longitude: -89.2 },
    { id: "DJ", city: "Djibouti", latitude: 11.5833, longitude: 43.15 },
    { id: "DK", city: "Copenhagen", latitude: 55.6667, longitude: 12.5833 },
    { id: "CZ", city: "Prague", latitude: 50.0833, longitude: 14.4667 },
    { id: "CY", city: "Nicosia", latitude: 35.1667, longitude: 33.3667 },
    { id: "CU", city: "Havana", latitude: 23.1167, longitude: -82.35 },
    { id: "HR", city: "Zagreb", latitude: 45.8, longitude: 16 },
    { id: "CI", city: "Yamoussoukro", latitude: 6.8167, longitude: -5.2667 },
    { id: "CR", city: "San José", latitude: 9.9333, longitude: -84.0833 },
    { id: "CG", city: "Brazzaville", latitude: -4.25, longitude: 15.2833 },
    { id: "CD", city: "Kinshasa", latitude: -4.3167, longitude: 15.3 },
    { id: "CO", city: "Bogota", latitude: 4.6, longitude: -74.0833 },
    { id: "CN", city: "Shanghai", latitude: 31.2304, longitude: 121.4737 },
    { id: "CL", city: "Santiago", latitude: -33.45, longitude: -70.6667 },
    { id: "TD", city: "N'Djamena", latitude: 12.1, longitude: 15.0333 },
    { id: "CF", city: "Bangui", latitude: 4.3667, longitude: 18.5833 },
    { id: "CA", city: "Toronto", latitude: 43.6532, longitude: -79.3832 },
    { id: "KH", city: "Phnom Penh", latitude: 11.55, longitude: 104.9167 },
    { id: "CM", city: "Yaounde", latitude: 3.8667, longitude: 11.5167 },
    { id: "BI", city: "Bujumbura", latitude: -3.3667, longitude: 29.35 },
    { id: "MM", city: "Rangoon", latitude: 16.8, longitude: 96.15 },
    { id: "BF", city: "Ouagadougou", latitude: 12.3667, longitude: -1.5167 },
    { id: "BG", city: "Sofia", latitude: 42.6833, longitude: 23.3167 },
    { id: "BR", city: "Sao Paulo", latitude: -23.5505, longitude: -46.6333 },
    { id: "BW", city: "Gaborone", latitude: -24.6333, longitude: 25.9 },
    { id: "BA", city: "Sarajevo", latitude: 43.8667, longitude: 18.4167 },
    { id: "BO", city: "La Paz", latitude: -16.5, longitude: -68.15 },
    { id: "BT", city: "Thimphu", latitude: 27.4667, longitude: 89.6333 },
    { id: "BJ", city: "Porto-Novo", latitude: 6.4833, longitude: 2.6167 },
    { id: "BZ", city: "Belmopan", latitude: 17.25, longitude: -88.7667 },
    { id: "BE", city: "Brussels", latitude: 50.8333, longitude: 4.3333 },
    { id: "BY", city: "Minsk", latitude: 53.9, longitude: 27.5667 },
    { id: "AM", city: "Yerevan", latitude: 40.1667, longitude: 44.5 },
    { id: "AZ", city: "Baku", latitude: 40.3833, longitude: 49.8667 },
    { id: "BD", city: "Dhaka", latitude: 23.7167, longitude: 90.4 },
    { id: "AT", city: "Vienna", latitude: 48.2, longitude: 16.3667 },
    { id: "AU", city: "Sydney", latitude: -33.8688, longitude: 151.2093 },
    { id: "AR", city: "Buenos Aires", latitude: -34.5833, longitude: -58.6667 },
    { id: "AO", city: "Luanda", latitude: -8.8333, longitude: 13.2167 },
    { id: "DZ", city: "Algiers", latitude: 36.75, longitude: 3.05 },
    { id: "AL", city: "Tirana", latitude: 41.3167, longitude: 19.8167 },
    { id: "GT", city: "Guatemala", latitude: 14.6167, longitude: -90.5167 },
    { id: "GN", city: "Conakry", latitude: 9.5, longitude: -13.7 },
    { id: "GW", city: "Bissau", latitude: 11.85, longitude: -15.5833 },
    { id: "GY", city: "Georgetown", latitude: 6.8, longitude: -58.15 },
    { id: "NI", city: "Managua", latitude: 12.1333, longitude: -86.25 },
    { id: "NE", city: "Niamey", latitude: 13.5167, longitude: 2.1167 },
    { id: "NG", city: "Abuja", latitude: 9.0833, longitude: 7.5333 },
    { id: "NO", city: "Oslo", latitude: 59.9167, longitude: 10.75 },
    { id: "OM", city: "Muscat", latitude: 23.6167, longitude: 58.5833 },
    { id: "PK", city: "Islamabad", latitude: 33.6833, longitude: 73.05 },
    { id: "PA", city: "Panama City", latitude: 8.9667, longitude: -79.5333 },
    { id: "PG", city: "Port Moresby", latitude: -9.45, longitude: 147.1833 },
    { id: "PY", city: "Asuncion", latitude: -25.2667, longitude: -57.6667 },
    { id: "PE", city: "Lima", latitude: -12.05, longitude: -77.05 },
    { id: "PH", city: "Manila", latitude: 14.6, longitude: 120.9667 },
    { id: "PL", city: "Warsaw", latitude: 52.25, longitude: 21 },
    { id: "PT", city: "Lisbon", latitude: 38.7167, longitude: -9.1333 },
    { id: "PR", city: "San Juan", latitude: 18.4667, longitude: -66.1167 },
    { id: "RO", city: "Bucharest", latitude: 44.4333, longitude: 26.1 },
    { id: "RU", city: "Moscow", latitude: 55.75, longitude: 37.6 },
    { id: "RW", city: "Kigali", latitude: -1.95, longitude: 30.05 },
    { id: "SA", city: "Riyadh", latitude: 24.65, longitude: 46.7 },
    { id: "SN", city: "Dakar", latitude: 14.7333, longitude: -17.6333 },
    { id: "RS", city: "Belgrade", latitude: 44.8333, longitude: 20.5 },
    { id: "SL", city: "Freetown", latitude: 8.4833, longitude: -13.2333 },
    { id: "SK", city: "Bratislava", latitude: 48.15, longitude: 17.1167 },
    { id: "SI", city: "Ljubljana", latitude: 46.05, longitude: 14.5167 },
    { id: "SO", city: "Mogadishu", latitude: 2.0667, longitude: 45.3333 },
    { id: "ZA", city: "Pretoria", latitude: -25.7, longitude: 28.2167 },
    { id: "ES", city: "Madrid", latitude: 40.4, longitude: -3.6833 },
    { id: "LK", city: "Colombo", latitude: 6.9167, longitude: 79.8333 },
    { id: "SD", city: "Khartoum", latitude: 15.6, longitude: 32.5333 },
    { id: "SR", city: "Paramaribo", latitude: 5.8333, longitude: -55.1667 },
    { id: "SZ", city: "Mbabane", latitude: -26.3167, longitude: 31.1333 },
    { id: "SE", city: "Stockholm", latitude: 59.3333, longitude: 18.05 },
    { id: "CH", city: "Bern", latitude: 46.9167, longitude: 7.4667 },
    { id: "SY", city: "Damascus", latitude: 33.5, longitude: 36.3 },
    { id: "TW", city: "Taipei", latitude: 25.0333, longitude: 121.5167 },
    { id: "TJ", city: "Dushanbe", latitude: 38.55, longitude: 68.7667 },
    { id: "TZ", city: "Dar es Salaam", latitude: -6.8, longitude: 39.2833 },
    { id: "TH", city: "Bangkok", latitude: 13.75, longitude: 100.5167 },
    { id: "TN", city: "Tunis", latitude: 36.8, longitude: 10.1833 },
    { id: "TR", city: "Ankara", latitude: 39.9333, longitude: 32.8667 },
    { id: "TM", city: "Ashgabat", latitude: 37.95, longitude: 58.3833 },
    { id: "UG", city: "Kampala", latitude: 0.3167, longitude: 32.55 },
    { id: "UA", city: "Kyiv", latitude: 50.4333, longitude: 30.5167 },
    { id: "AE", city: "Abu Dhabi", latitude: 24.4667, longitude: 54.3667 },
    { id: "GB", city: "London", latitude: 51.5, longitude: -0.0833 },
    { id: "UY", city: "Montevideo", latitude: -34.85, longitude: -56.1667 },
    { id: "UZ", city: "Tashkent", latitude: 41.3167, longitude: 69.25 },
    { id: "VE", city: "Caracas", latitude: 10.4833, longitude: -66.8667 },
    { id: "VN", city: "Hanoi", latitude: 21.0333, longitude: 105.85 },
    { id: "YE", city: "Sanaa", latitude: 15.35, longitude: 44.2 },
    { id: "ZM", city: "Lusaka", latitude: -15.4167, longitude: 28.2833 },
    { id: "ZW", city: "Harare", latitude: -17.8167, longitude: 31.0333 }
  ]

var randomCountries = ["MX", "SV", "CR", "PA", "NI", "HN"];

function getCountryById(id) {
  for (var i = 0; i < countries.length; i++) {
    if (countries[i].id == id) {
      return countries[i];
    }
  }
}


  $(document).ready(function()
  {
    setTimeout (init, 500)
  });
</script>

<div class="oadh-banner">
  <div class="banner-wrapper">
    <div id="map-preview"></div>
    <div class="container">
      <div class="oadh-banner-description">
        <!-- <h2 class="website-description">XI Encuentro Centroamérica de Sofware Libre.</h2> -->
        <h2 class="website-description">
          <img src="https://storage.googleapis.com/decimaerp-cloud-bucket/organizations/15/logo_ecsl_2019_medium.png" class="img-fluid">
        </h2>
        <p class="website-date" style="color: #ff690d;">4, 5 y 6 de julio del 2019.</p>
        <!-- <a class="btn btn-lg btn-welcome" href="{{ URL::to('/registro') }}">Registrarse</a> -->
        <button class="btn btn-lg btn-welcome" disabled>Registro cerrado</button>
      </div>
    </div>
  </div>
</div>

<!--Acerca de-->
<section class="">
  <div class="ecsl-about bg-darkblue py-5">
    <div class="container">
      <h2 class="text-center text-white"><strong>XI Encuentro Centroamericano de Software Libre</strong></h2>
      <h4 class="text-center text-white font-weight-bold">4, 5 y 6 de julio del 2019</h4>
      <p class="lead text-center text-white">
        El Encuentro Centroamericano de Software Libre (ECSL) es un evento anual
        organizado desde el año 2009 por y para la comunidad  de Software Libre Centroamérica (SLCA). El ECSL es una
        reunión de activistas e integrantes de comunidades y grupos de usuarios/as que sirve como punto de encuentro
        y espacio de articulación, educación, coordinación e intercambio de ideas para fortalecer acuerdos y formas
        de trabajo conjuntas que faciliten la promoción del uso y desarrollo del Software Libre en la región.
      </p>
    </div>
  </div>
</section>

<!-- <div class="ecsl-canvas-wrap">
  <canvas id="ecsl-canvas"></canvas>
</div> -->

<!-- Page Content -->
<div class="container">

  <!-- Marketing Icons Section -->
  <div class="row mt-5">
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
  </div>
  <!-- /.row -->
  <div class="row mb-4">
    <div class="col-md-8">
      <p class="text-center">¡Conoce los países y lugares en los que el Encuentro Centroamericano de Software Libre se ha venido realizando
        desde al año 2009 y no pierdas la oportunidad de participar en la décima primera edición del evento en Guatemala!</p>
    </div>
    <div class="col-md-4">
      <a class="btn btn-lg btn-outline-primary btn-block" href="{{URL::to('cms/eventos-anteriores')}}">Ver todos los eventos anteriores</a>
    </div>
  </div>
</div>

<!--Informacion General-->
<section class="about-us section-padding">
  <div class="bg-darkblue py-5">
    <div class="container">
      <h2 class="display-5 text-center text-white">Información General</h2><br>
      <div class="row">
        <div class="col-12 col-sm-6 text-center col-md-3">
          <a href="{{URL::to('cms/logistica')}}" class="text-white">
                  <i class="fa fa-info main-icons" aria-hidden="true"></i> <h3>Logística</h3>
                </a>
        </div>


        <div class="col-12 col-sm-6 text-center col-md-3">
          <a href="{{URL::to('cms/ejes-tematicos')}}" class="text-white">
                <i class="fa fa-list-ul main-icons" aria-hidden="true"></i><h3>Ejes temáticos</h3>
              </a>
        </div>


        <div class="col-12 col-sm-6 text-center col-md-3">
          <a href="{{URL::to('cms/eventos-anteriores')}}" class="text-white">
                <i class="fa fa-calendar main-icons" aria-hidden="true"></i><h3>Eventos anteriores</h3>
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
<div class="container py-5">


  <!-- Portfolio Section -->
  <h2 class="text-center display-5">Patrocinadores</h2><br>

  <div class="row">
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo">
          <a href="#" target="_blank">
            <img class="card-img-top img-fluid" src='https://storage.googleapis.com/decimaerp-cloud-bucket/organizations/15/vr.jpg'>
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
        <div class="card-header-logo">
          <a href="#" target="_blank">
            <img class="card-img-top img-fluid" src='https://storage.googleapis.com/decimaerp-cloud-bucket/organizations/15/ccc.png'>
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
    <div class="col-lg-6 col-md-8 col-sm-6 mb-4">
      <div class="card card-logo">
        <div class="card-header-logo">
          <a href="#" target="_blank">
            <img class="card-img-top img-fluid" src='https://storage.googleapis.com/decimaerp-cloud-bucket/organizations/15/logomeso.jpeg'>
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
        <div class="card-header-logo">
          <a href="#" target="_blank">
            <img class="card-img-top img-fluid" src='https://storage.googleapis.com/decimaerp-cloud-bucket/organizations/15/logo__pixela_.jpg'>
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
