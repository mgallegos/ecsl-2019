@extends('ecsl-2019::base')

@section('container')
<!-- Page Content -->
<div class="container">

  <div class="d-block d-lg-none">
    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">Logística</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{URL::to('cms/inicio')}}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a>
      </li>
      <li class="breadcrumb-item">Evento</li>
      <li class="breadcrumb-item active">Logística</li>
    </ol>
  </div>

  <!-- Content Row -->
  <div id="rowContainer" class="row">

    <!-- Sidebar Column -->

    <!-- <div class="col-lg-3 m-2 p-0 border rounded"> -->
      <div id="prueba" class="col-lg-3" style="display: block"></div>
      <div id="colSide" class="col-lg-3 m-2 p-0 rounded side-bar"> <!--m-2 p-0-->
      <div id="sideLogistica">
        <!-- Participacion -->
        <div class="card border-0">
          <div class="card-header bg-white p-0 m-0">
            <div class="btn w-100" id="headingParticipation" data-toggle="collapse" data-target="#collapseParticipation" aria-expanded="true">
              <div class="row">
                <div class="col-8 text-left">
                  <p class="font-weight-bold text-primary m-0">Participación</p>
                </div>
                <div class="col-4 text-right">
                  <i class="fa fa-chevron-down text-secondary "></i>
                </div>
              </div>
            </div>

          </div>

          <div id="collapseParticipation" class="collapse {{ !Agent::isMobile()?'show':'' }}" aria-labelledby="headingParticipation" data-parent="#sideLogistica">
            <div class="card-body p-0">
              <div class="list-group list-group-flush m-0">
                <a href="#participacion" class="list-group-item list-group-item-action py-2">Reseña</a>
                <a href="#dinamica-del-evento" class="list-group-item list-group-item-action py-2">Dinámica del evento</a>
                <a href="#cuota-de-participacion" class="list-group-item list-group-item-action py-2">Cuota de participación</a>
                <a href="#paquete-en-swag" class="list-group-item list-group-item-action py-2">Paquete promocional</a>
                <a href="#forma-de-pago" class="list-group-item list-group-item-action py-2">Forma de pago</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Hospedaje -->
        <div class="card border-0">
          <div class="card-header bg-white p-0 m-0 border-top">
            <div class="btn w-100" id="headingHospedaje" data-toggle="collapse" data-target="#collapseHospedaje" aria-expanded="false">
              <div class="row ">
                <div class="col-9 text-center">
                  <p class="font-weight-bold text-primary my-0 text-left">Hospedaje</p>
                </div>
                <div class="col-3 text-right">
                  <i class="fa fa-chevron-down text-secondary "></i>
                </div>
              </div>
            </div>

          </div>

          <div id="collapseHospedaje" class="collapse" aria-labelledby="headingHospedaje" data-parent="#sideLogistica">
            <div class="card-body p-0">
              <div class="list-group list-group-flush m-0">
                <a href="#hospedaje-oficial" class="list-group-item list-group-item-action py-2">Hospedaje Oficial</a>
                <a href="#hospedaje-alternativo" class="list-group-item list-group-item-action py-2">Hospedajes Alternativos</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Sede Oficial -->
        <div class="card border-0">
          <div class="card-header bg-white p-0 m-0 border-top">
            <a href="#sede-oficial" class="btn w-100 rounded-0">
              <div class="font-weight-bold text-primary text-left" aria-expanded="false">
                Sede Oficial</div>
            </a>
          </div>

        </div>

        <!-- Movilizacion -->
        {{-- <div class="card border-0">
          <div class="card-header bg-white p-0 m-0 border-top">
            <div class="btn w-100" id="headingMovilizacion" data-toggle="collapse" data-target="#collapseMovilizacion" aria-expanded="false">
              <div class="row ">
                <div class="col-8 text-left">
                  <p class="font-weight-bold text-primary my-0">Movilización</p>
                </div>
                <div class="col-4 text-right">
                  <i class="fa fa-chevron-down text-secondary "></i>
                </div>
              </div>
            </div>
          </div>
          <div id="collapseMovilizacion" class="collapse" aria-labelledby="headingMovilizacion" data-parent="#sideLogistica">
            <div class="card-body p-0">
              <div class="list-group list-group-flush m-0">
                <a href="#a-pie" class="list-group-item list-group-item-action py-2">A pie</a>
                <a href="#servicio-de-autobuses" class="list-group-item list-group-item-action py-2">Servicio de Autobuses</a>
                <a href="#servicio-de-taxis" class="list-group-item list-group-item-action py-2">Servicio de taxis</a>
                <a href="#servicio-de-UBER" class="list-group-item list-group-item-action py-2">Servicio UBER</a>
              </div>
            </div>
          </div>
        </div> --}}

        <div class="card border-0">
          <div class="card-header bg-white p-0 m-0 border-top">
            <a href="#movilizacion" class="btn w-100 rounded-0">
              <div class="font-weight-bold text-primary text-left" aria-expanded="false">
                Movilización</div>
            </a>
          </div>

        </div>

        <div class="card border-0">
          <div class="card-header bg-white p-0 m-0 border-top">
            <a href="#aereo" class="btn w-100 rounded-0">
              <div class="font-weight-bold text-primary text-left" aria-expanded="false">
                Información de viaje</div>
            </a>
          </div>

        </div>

          {{-- <!-- Opcion de Viaje -->
          <div class="card border-0">
            <div class="card-header bg-white p-0 m-0">
              <div class="btn w-100" id="headingTravelInfo" data-toggle="collapse" data-target="#collapseTravelInfo" aria-expanded="false">
                <div class="row ">
                  <div class="col-9 text-center">
                    <p class="font-weight-bold text-primary my-0 text-left">Información de Viaje</p>
                  </div>
                  <div class="col-3 text-right">
                    <i class="fa fa-chevron-down text-secondary "></i>
                  </div>
                </div>
              </div>

            </div>

            <div id="collapseTravelInfo" class="collapse" aria-labelledby="headingTravelInfo" data-parent="#sideLogistica">
              <div class="card-body p-0">
                <div class="list-group list-group-flush m-0">
                  <a href="#aereo" class="list-group-item list-group-item-action py-2">Aéreo</a>
                  <a href="#terrestre" class="list-group-item list-group-item-action py-2">Terrestre</a>
                </div>
              </div>
            </div>
          </div> --}}

        <!-- Informacion de El Salvador-->
        <div class="card border-0">
          <div class="card-header bg-white p-0 m-0 border-top">
            <div class="btn w-100" id="headingInfoESA" data-toggle="collapse" data-target="#collapseInfoESA" aria-expanded="false">
              <div class="row ">
                <div class="col-8 text-left">
                  <p class="font-weight-bold text-primary my-0">Acerca de Guatemala</p>
                </div>
                <div class="col-4 text-right">
                  <i class="fa fa-chevron-down text-secondary"></i>
                </div>
              </div>
            </div>
          </div>


          <div id="collapseInfoESA" class="collapse" aria-labelledby="headingInfoESA" data-parent="#sideLogistica">
            <div class="card-body p-0">
              <div class="list-group list-group-flush m-0">
                <a href="#moneda-local" class="list-group-item list-group-item-action py-1">Moneda Local</a>
                <a href="#telefonia" class="list-group-item list-group-item-action py-1">Telefonía</a>
                <a href="#gastronomia" class="list-group-item list-group-item-action py-1">Gastronomía</a>
                <a href="#condiciones-del-clima" class="list-group-item list-group-item-action py-1">Condiciones del Clima</a>
                <a href="#fumado" class="list-group-item list-group-item-action py-1">Fumado y Tabaco</a>
                <a href="#alcohol" class="list-group-item list-group-item-action py-1">Alcohol</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Opciones de Tiempo Libre-->
        <div class="card border-0">
          <div class="card-header bg-white p-0 m-0 border-top ">
            <a href="#free-time" class="btn w-100 rounded-0">
              <div class="font-weight-bold text-primary text-left"  aria-expanded="false">
                Atracciones cerca del hotel</div>
            </a>
          </div>

        </div>

        <!-- Recomendaciones de Seguridad -->
        <div class="card border-0">
          <div class="card-header bg-white p-0 m-0 border-top ">
            <a href="#recomendaciones" class="btn w-100 rounded-0">
              <div class="font-weight-bold text-primary text-left" aria-expanded="False">
                Recomendaciones</div>
            </a>
          </div>

        </div>

      </div>
      </div>
    <!-- </div>   -->

    <!-- Content Column -->
    <div id="colContent" class="col-lg-9 mb-4 offset-lg-3"> <!--offset-lg-3 mb-4-->
      <div data-spy="scroll" data-target="#sideLogistica" data-offset="0">

        <div class="d-none d-lg-block">
          <!-- Page Heading/Breadcrumbs -->
          <h1 class="mt-4 mb-3">Logística</h1>

          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{URL::to('cms/inicio')}}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a>
            </li>
            <li class="breadcrumb-item active">Logística</li>
          </ol>
        </div>

        <div id="participacion" class="right-block">
          <h3 class="font-weight-bold">Participación</h3>
          <h4 class="display-6 font-italic font-weight-bold">Reseña</h4>
          <p class="text-justify">
            El Encuentro Centroamericano de Software Libre (ECSL) es un evento anual organizado por la Comunidad Software Libre Centroamérica (SLCA).
            Reúne a representantes de comunidades de los siete países de la región, donde se intercambian experiencias, se comparte conocimiento, se
            promueven proyectos gestionados por las comunidades locales, se establecen objetivos comunes y se plantean estrategias para promover la
            filosofía, la cultura, el desarrollo y el uso del Software Libre y de Código Abierto. que se realiza desde el año 2009.
            <br><br>
            A la fecha, se ha realizado en Nicaragua (2009), Costa Rica (2010), El Salvador (2011), Guatemala (2012), Belize (2013), Panamá (2014),
            Honduras (2015), Nicaragua (2016), Costa Rica (2017) y El Salvador (2018). En su undecima edición, se realizará en la ciudad de
            Quetzaltenango, Guatemala los días 4, 5 y 6 de julio del 2019.
            <br><br>
            Es un evento abierto para todo el público interesado en el aprender y compartir sobre diversas temáticas acerca de tecnologías libres
            pero principalmente sobre Software Libre, está es una celebración donde te encontraras con entusiastas, estudiantes y profesionales;
            un espacio para relacionarte y hacer nuevas amistades y contactos que compartirán contigo la pasión por liberar el conocimiento para
            el beneficio de las personas.
          </p>
        </div>

        <div id="dinamica-del-evento" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Dinámica del Evento</h4>

          <p class="font-weight-bold">Para participar es requerido completar el proceso de registro.</p>

          <p class="text-justify">
            El ECSL es un evento sin fines de lucro, pero se financian los equipos, herramientas, materiales, alimentación entre otras necesidades que
            requiere el evento por medio de las cuotas de participación. Asi mismo se cuenta con el apoyo que realizan diversos patrocinadores.
          </p>
        </div>

        <div id="cuota-de-participacion" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Cuota de Participación</h4>
          <!-- Content Row -->
          @include('ecsl-2019::paquetes-participacion')
          <br>
          <p class="text-justify">
            La organización brindará información sobre hoteles cercanos a la sede para quienes la requieran, como una cortesía.
            Sin embargo, no se hará responsable de traslados ni depósitos de garantía que deban realizar quienes elijan la cuota parcial.
          </p>
        </div>

        <div id="paquete-en-swag" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Paquete promocional</h4>
          <br>
          @if (!Agent::isMobile())
            <div class="row ">
              <div class="col-4 py-2 border-right ">&nbsp;</div>
              <div class="col-4 border border-bottom-0  text-center text-dark bg-gray font-weight-bold h4 py-3 mb-0 border-left-0">Básico</div>
              <div class="col-4 border border-bottom-0  text-center text-dark bg-gray font-weight-bold h4 py-3 mb-0 border-left-0">Completo</div>
            </div>
            <div class="row border border-bottom-0">
              <div class="col-4 border-right  d-flex align-items-center justify-content-start  py-2">Playera</div>
              <div class="col-4 border-right  d-flex align-items-center justify-content-center py-2"><i class="fa fa-check icon-check"></i></div>
              <div class="col-4 border-left   d-flex align-items-center justify-content-center py-2"><i class="fa fa-check icon-check"></i></div>
            </div>
            <div class="row border border-bottom-0   bg-light">
              <div class="col-4 border-right  d-flex align-items-center justify-content-start py-2">Gafete</div>
              <div class="col-4 border-right  d-flex align-items-center justify-content-center py-2"><i class="fa fa-check icon-check"></i></div>
              <div class="col-4 border-left  d-flex align-items-center justify-content-center py-2"><i class="fa fa-check icon-check"></i></div>
            </div>
            <div class="row border border-bottom-0">
              <div class="col-4 border-right  d-flex align-items-center justify-content-start py-2">Sticker</div>
              <div class="col-4 border-right  d-flex align-items-center justify-content-center py-2"><i class="fa fa-times icon-null"></i></div>
              <div class="col-4 border-left  d-flex align-items-center justify-content-center py-2"><i class="fa fa-check icon-check"></i></div>
            </div>
            <div class="row border   bg-light">
              <div class="col-4 border-right  d-flex align-items-center justify-content-start py-2">Artesanía nacional</div>
              <div class="col-4 border-right  d-flex align-items-center justify-content-center py-2"><i class="fa fa-times icon-null"></i></div>
              <div class="col-4 border-left  d-flex align-items-center justify-content-center py-2 "><i class="fa fa-check icon-check"></i></div>
            </div>
          @else
            <div class="row">
              <div class="col-md-6 mb-4">
                <div class="card card1">
                  <h3 class="card-header text-center">Básico</h3>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">Playera</li>
                    <li class="list-group-item">Gafete</li>
                  </ul>
                </div>
              </div>

              <div class="col-md-6 mb-4">
                <div class="card">
                  <h3 class="card-header text-center">Completo</h3>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item ">Playera</li>
                    <li class="list-group-item ">Gafete</li>
                    <li class="list-group-item ">Sticker</li>
                    <li class="list-group-item ">Artesanía nacional</li>
                  </ul>
                </div>
              </div>
            </div>
          @endif
          <br>
        </div>

        <div id="forma-de-pago" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Forma de Pago</h4>
          <p>Proximamente se estará informando sobre los medios oficiales de pago de la cuota de inscripción al evento.</p>
        </div>

        <hr>

        <div id="hospedaje-oficial" class="right-block">
          <h3 class="font-weight-bold">Hospedaje</h3>
          <h4 class="display-6 font-italic font-weight-bold">Hospedaje Oficial (Hotel Villa Real Plaza)</h4>
          <p class="text-justify">
            El Hotel Villa Real Plaza es el lugar donde se hospedaran los participantes que adquirieron su paquete completo de participación
            al ECSL está ubicado en 4a Calle 12-22 Zona 1, Quetzaltenango 09001, Guatemala. Esta a 3 km (30 minutos caminando) de la Universidad
            Mesoamericana sede del ECSL 2019.

            <br><br> Estas son algunas de las características del alojamiento:

            <ul>
              <li>Restaurante.</li>
              <li>Servicio de limpieza diario.</li>
              <li>Caja fuerte en la recepción.</li>
              <li>Lavandería.</li>
              <li>Autoservicio.</li>
              <li>Resguardo de equipaje.</li>
              <li>Asistencia turística.</li>
              <li>Wifi gratis.</li>
              <li>Estacionamiento gratis.</li>
            </ul>
          </p>

          <div class="embed-responsive embed-responsive-16by9">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1593.8033011907823!2d-91.5197648!3d14.8350115!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x846814725fb72a20!2sHotel+Villa+Real+Plaza!5e1!3m2!1ses-419!2ssv!4v1554412390584!5m2!1ses-419!2ssv" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
          </div>
{{--
          @if (!Agent::isMobile())
            <div class="row">
              <div class="col-md-12">
                <div class="row mb-4 justify-content-center pl-3">
                  <a href="https://storage.googleapis.com/decimaerp/organizations/15/comedor.jpg" data-toggle="lightbox" data-gallery="gallery-hotel" class="col-sm-3 px-1">
                      <img src="https://storage.googleapis.com/decimaerp/organizations/15/comedor.jpg" class="img-fluid">
                  </a>
                  <a href="https://storage.googleapis.com/decimaerp/organizations/15/habitaciones2.jpg" data-toggle="lightbox" data-gallery="gallery-hotel" class="col-sm-3 px-1">
                      <img src="https://storage.googleapis.com/decimaerp/organizations/15/habitaciones2.jpg" class="img-fluid">
                  </a>
                  <!-- <a href="https://storage.googleapis.com/decimaerp/organizations/15/honduras_thumbnail.jpg" data-toggle="lightbox" data-gallery="gallery-hotel" class="col-sm-3 px-1">
                      <img src="https://storage.googleapis.com/decimaerp/organizations/15/honduras_thumbnail.jpg" class="img-fluid">
                  </a>
                  <a href="https://storage.googleapis.com/decimaerp/organizations/15/costarica_thumbnail.jpg" data-toggle="lightbox" data-gallery="gallery-hotel" class="col-sm-3 px-1">
                      <img src="https://storage.googleapis.com/decimaerp/organizations/15/costarica_thumbnail.jpg" class="img-fluid">
                  </a> -->
                </div>
              </div>
            </div>
          @else
          <div class="row">
            <div class="col-md-12">
              <div class="row mb-4 justify-content-center">
                <a href="https://storage.googleapis.com/decimaerp/organizations/15/comedor.jpg" data-toggle="lightbox" data-gallery="gallery-hotel-mobile" class="col-6 px-1 pb-2">
                    <img src="https://storage.googleapis.com/decimaerp/organizations/15/comedor.jpg" class="img-fluid">
                </a>
                <br>
                <a href="https://storage.googleapis.com/decimaerp/organizations/15/habitaciones.jpg" data-toggle="lightbox" data-gallery="gallery-hotel-mobile" class="col-6 px-1 pb-2">
                    <img src="https://storage.googleapis.com/decimaerp/organizations/15/habitaciones.jpg" class="img-fluid">
                </a>
                <a href="https://storage.googleapis.com/decimaerp/organizations/15/areas_merienda_opt.jpg" data-toggle="lightbox" data-gallery="gallery-hotel" class="col-6 px-1">
                    <img src="https://storage.googleapis.com/decimaerp/organizations/15/areas_merienda_opt.jpg" class="img-fluid">
                </a>
                <a href="https://storage.googleapis.com/decimaerp/organizations/15/fachadaLoyola.jpg" data-toggle="lightbox" data-gallery="gallery-hotel" class="col-6 px-1">
                    <img src="https://storage.googleapis.com/decimaerp/organizations/15/fachadaLoyola.jpg" class="img-fluid">
                </a>
              </div>
            </div>
          </div>
          @endif --}}
        </div>
        <br>
        <div id="hospedaje-alternativo" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Hospedajes Alternativos</h4>
          <!-- <p class="text-justify">Si desea reservar un lugar de alojamiento por su cuenta, se le recomienda las siguientes alternativas:</p> -->
          <p>Proximamente se estará informando sobre hoteles alternativos.</p>
        </div>

        <hr>

        <div id="sede-oficial" class="right-block">
          <h3 class="font-weight-bold">Sede Oficial <small>(Universidad Mesoamericana Sede Quetzaltenango)</small></h3>
          <p class="text-justify">El evento se llevará a cabo en la Universidad Mesoamericana Sede Quetzaltenango los días 4, 5 y 6 de Julio del 2019, su ubicación es en 3ª. calle 14-36 y 14-03 zona 3, Quezaltenango, Quetzaltenango, Guatemala.</p>
          <p>
            Si desea más detalles, puede utilizar esta información de contacto:<br>Teléfono: (+502) 7932-9000 <br> Sitio web: <a target="_blank" href="https://www.umes.edu.gt/sedes/sede-quetzaltenango/">Universidad Mesoamericana Sede Quetzaltenango”</a> <br>
          </p>
{{--
          @if (!Agent::isMobile())
            <div class="row">
              <div class="col-md-12">
                <div class="row mb-4 justify-content-center pl-3">
                  <a href="https://storage.googleapis.com/decimaerp/organizations/15/Exterior_del_edificio_ICAS.jpg" data-toggle="lightbox" data-gallery="gallery-uca" class="col-sm-3 px-1">
                      <img src="https://storage.googleapis.com/decimaerp/organizations/15/Exterior_del_edificio_ICAS.jpg" class="img-fluid">
                  </a>
                  <a href="https://storage.googleapis.com/decimaerp/organizations/15/Hall_y_escalera_de_acceso_a_segundo_nivel.jpg" data-toggle="lightbox" data-gallery="gallery-uca" class="col-sm-3 px-1">
                      <img src="https://storage.googleapis.com/decimaerp/organizations/15/Hall_y_escalera_de_acceso_a_segundo_nivel.jpg" class="img-fluid">
                  </a>
                  <a href="https://storage.googleapis.com/decimaerp/organizations/15/Cafeteria_anexa_al_ICAS.jpg" data-toggle="lightbox" data-gallery="gallery-uca" class="col-sm-3 px-1">
                      <img src="https://storage.googleapis.com/decimaerp/organizations/15/Cafeteria_anexa_al_ICAS.jpg" class="img-fluid">
                  </a>
                  <a href="https://storage.googleapis.com/decimaerp/organizations/15/Auditorio.jpg" data-toggle="lightbox" data-gallery="gallery-uca" class="col-sm-3 px-1">
                      <img src="https://storage.googleapis.com/decimaerp/organizations/15/Auditorio.jpg" class="img-fluid">
                  </a>
                </div>
              </div>
            </div>
          @else
            <div class="row">
              <div class="col-md-12">
                <div class="row mb-4 justify-content-center">
                  <a href="https://storage.googleapis.com/decimaerp/organizations/15/Exterior_del_edificio_ICAS.jpg" data-toggle="lightbox" data-gallery="gallery-uca-mobile" class="col-6 px-1 pb-2">
                      <img src="https://storage.googleapis.com/decimaerp/organizations/15/Exterior_del_edificio_ICAS.jpg" class="img-fluid">
                  </a>
                  <a href="https://storage.googleapis.com/decimaerp/organizations/15/Hall_y_escalera_de_acceso_a_segundo_nivel.jpg" data-toggle="lightbox" data-gallery="gallery-uca-mobile" class="col-6 px-1 pb-2">
                      <img src="https://storage.googleapis.com/decimaerp/organizations/15/Hall_y_escalera_de_acceso_a_segundo_nivel.jpg" class="img-fluid">
                  </a>
                  <a href="https://storage.googleapis.com/decimaerp/organizations/15/Cafeteria_anexa_al_ICAS.jpg" data-toggle="lightbox" data-gallery="gallery-uca-mobile" class="col-6 px-1">
                      <img src="https://storage.googleapis.com/decimaerp/organizations/15/Cafeteria_anexa_al_ICAS.jpg" class="img-fluid">
                  </a>
                  <a href="https://storage.googleapis.com/decimaerp/organizations/15/Auditorio.jpg" data-toggle="lightbox" data-gallery="gallery-uca-mobile" class="col-6 px-1">
                      <img src="https://storage.googleapis.com/decimaerp/organizations/15/Auditorio.jpg" class="img-fluid">
                  </a>
                </div>
              </div>
            </div>
          @endif --}}
        </div>

        <hr>

        <div id="movilizacion" class="right-block">
          <h3 class="font-weight-bold">Movilización</h3>
          <div class="embed-responsive embed-responsive-16by9">
          <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d7713.510774269914!2d-91.52319297551706!3d14.838980508604031!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e6!4m5!1s0x858e980352666293%3A0x846814725fb72a20!2sHotel+Villa+Real+Plaza%2C+4a+Calle%2C+Quezaltenango!3m2!1d14.8350624!2d-91.51839149999999!4m5!1s0x858ea2ab00334b2f%3A0xb70aba74577dd282!2sUniversidad+Mesoamericana%2C+3a+Calle%2C+Quezaltenango!3m2!1d14.842735099999999!2d-91.5181092!5e0!3m2!1ses-419!2ssv!4v1554522153833!5m2!1ses-419!2ssv" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
          </div>
          <p class="text-justify">Para movilizarse del lugar de hospedaje hacia la sede del ECSL-2019 existen varias opciones que se describen a continuación:</p>
        </div>

        {{-- <div id="a-pie" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">A pie</h4>
          <p class="text-justify">
            Desde el hospedaje oficial a la sede del evento no hay más de 15 minutos caminando.
            Antiguo Cuscatlán es un municipio muy seguro para llevar su equipo, no obstante, como en
            cualquier gran ciudad, siempre es mejor ir en grupo que solo/a. En cuanto al tipo de
            camino, solo hay que atravesar un par de calles de doble sentido sin mucho tráfico.
          </p>
        </div>

        <div id="servicio-de-autobuses" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Servicio de Autobuses</h4>
          <p class="text-justify">En El Salvador es posible llegar prácticamente a cualquier lugar utilizando el servicio de autobuses.
            <br><br> La rutas que llegan a la Universidad Centroamericana “José Simeón Cañas” (UCA):
            <ul>
              <li>Ruta 42 (Bus y Coaster)</li>
              <li>Ruta 44 (Bus y Coaster)</li>
              <!-- <li>Ruta 101</li> -->
            </ul>
          </p>
        </div>

        <div id="servicio-de-taxis" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Servicio de taxis</h4>
          <p class="text-justify">Los taxis no cuentan con taxímetro, la tarifa se negocia con el taxista antes de abordar el vehículo. El costo promedio para desplazarse desde la Universidad Centroamericana “José Simeón Cañas” (UCA) sede del evento y el Centro Loyola es de
            $ 5.00 dólares.
            <br><br> Cabe destacar que a la salida hacia la calle “La Sultana” de la Universidad Centroamericana “José Simeón Cañas” (UCA) se ubica un punto de taxis de los cuales puede hacer uso en el horario que usted desee.
          </p>
        </div>

        <div id="servicio-de-UBER" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Servicio UBER</h4>
          <p class="text-justify">También puede optar por el servicio <a target="_blank" href="https://www.uber.com/es-ES/cities/san-salvador/">Uber</a>, para lo cual previamente debe instalar la respectiva app y configurar una cuenta. En El Salvador se ofrece la opción de UberX (4 personas).
            Puede pagar el servicio con tarjeta de débito/crédito o con dinero en efectivo en dólares.</p>
          <p>
            Para consultar estimación de tarifas, puede dirigirse a <a target="_blank" href="https://www.uber.com/es-ES/fare-estimate/">este enlace.</a>
          </p>
        </div> --}}

        <hr>

        <div id="aereo" class="right-block">
          <h3 class="font-weight-bold">Información de viaje</h3>
          {{-- <h4 class="display-6 font-italic font-weight-bold">Aérea</h4> --}}
          <p class="text-justify">Existen diversas empresas de buses, los cuales cuentan con traslado desde la Ciudad de Guatemala y la ciudad de Quetzaltenango. El costo aproximado es de Q70.00 ($10).</p>

          <div class="embed-responsive embed-responsive-16by9">
            <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d987423.9913337226!2d-91.58127000713635!3d14.818242926549749!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x8589a15f18a23e65%3A0xa8d9f9b1ae2d4eca!2sAeropuerto+Internacional+La+Aurora%2C+Guatemala!3m2!1d14.5840977!2d-90.5276868!4m5!1s0x858e97fe3fc89d3f%3A0x3ba7ff011f0f000f!2sQuezaltenango!3m2!1d14.8446068!2d-91.5231866!5e0!3m2!1ses-419!2ssv!4v1554522255980!5m2!1ses-419!2ssv" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
          </div>
        </div>

        <br>
        {{-- <div id="terrestre" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Terrestre</h4>
          <p class="text-justify">Llegar a San Salvador por tierra es la opción más viable para las personas que vienen de los países centroamericanos, aconsejamos verificar precios y asegúrese de consultar las promociones y descuentos especiales directamente con cada empresa
            de transporte.</p>

          <ul>
            <li class="text-justify">
              <p class="font-weight-bold mb-0">Platinum:</p>
              <p class="">Tiene un servicio de transporte con atención de primera clase hacia San Salvador, El Salvador y tiene sus puertos de salida en Guatemala, Honduras y Nicaragua posee rutas clase Platinum, King y Quality los precios van desde $69.00 USD.
                Más información en el <a target="_blank" href="http://www.platinumcentroamerica.com/">sitio web de Platinum.</a></p>
            </li>

            <li class="text-justify">
              <p class="font-weight-bold mb-0">TicaBus:</p>
              <p class="">Tiene servicio de transporte de mediano costo hacia San Salvador, El Salvador y tiene puertos de salida en Guatemala, Honduras, NIcaragua y Costa Rica posee rutas turistica y ejecutiva los precio van desde $72.00 USD. hasta $131.00 USD.
                Más información en el <a target="_blank" href="http://ticabus.com/ ">sitio web de Ticabus.</a></p>
            </li>

            <li class="text-justify">
              <p class="font-weight-bold mb-0">Transportes del Sol:</p>
              <p class="">Tes una de las opciones más económicas para viajar a San Salvador, El Salvador poseen cuota diferencial entre adultos y menores de edad sus puertos de salida están ubicados unicamente en Guatemala, Nicaragua y Costa Rica; los precio van
                desde $50.00 USD. hasta $120.00 USD. <a target="_blank" href="http://www.transportedelsol.com/">sitio web de Transportes del Sol.</a></p>
            </li>
          </ul>

        </div> --}}
        <hr>

        <h3 class="font-weight-bold">Acerca de Guatemala</h3>

        <div id="moneda-local" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Moneda local</h4>
          <p class="text-justify">
            En Guatemala circula como moneda local el quetzal, y se manejan las siguientes denominaciones:
            <br><br>
            Monedas: Q0.01, Q0.05, Q0.10, Q0.25, Q0.50 y Q1.00.
            <br>
            Billetes: Q1, Q5, Q10, Q20, Q50, Q100, Q200.
            <br><br>
            Nota: En algunos comercios pequeños del país no aceptan billetes de Q100 y Q200. Sin embargo puede cambiarlos en cualquier
            banco o institución financiera.
            <br><br>
            La mayoría de los cajeros automáticos o ATMs aceptan Visa y MasterCard.
            Al cruzar el parque central de Quetzaltenango un kiosco con cajero automático disponible las 24 horas.
            <br><br>
            Los impuestos de venta (12%) no siempre están incluidos en los precios que están a la vista.
            En muchos bares y restaurantes se acostumbra a incluir el 10% de propina, que según ley es voluntaria.
          </p>

        </div>

        <div id="telefonia" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Telefonía</h4>
          <p class="text-justify">
            El codigo postal que le corresponde a Guatemala es +502.
            <br>
            Las compañías de telefonía e internet móvil que operan en Guatemala son:
          </p>

          <ul>
            <li class="text-justify">
              <p class="font-weight-bold mb-0">Claro Guatemala:</p>
              <p class="">
                Más información en el <a target="_blank" href="https://www.claro.com.gt/personas/">sitio web de Claro.</a>
              </p>
            </li>

            <li class="text-justify">
              <p class="font-weight-bold mb-0">Tigo Guatemala</p>
              <p class="">
                Más información en el <a target="_blank" href="https://www.tigo.com.gt/">sitio web de Tigo.</a>
              </p>
            </li>
          </ul>
        </div>

        <div id="gastronomia" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Gastronomía</h4>
          <p class="text-justify">
            La gastronomía de Guatemala se basa en productos como el arroz, frijoles, maíz, carnes,
            ricas frutas y verduras, productos lacteos, además de pescados y mariscos.
          </p>
          <p class="text-justify">
            Entre sus platos típicos hay que destacar el kakik, pepian, jocon, chuchitos, tamales, fiambre, shucos
            y en las bebidas los atoles de elote, arroz en leche, platano y de masa.
          </p>
        </div>

        <div id="condiciones-del-clima" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Condiciones del Clima</h4>
          <p class="text-justify">
            A lo largo del año las temperaturas se mantienen entre los 18° y 35°.
          </p>
        </div>

        <div id="fumado" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Fumado y Tabaco</h4>
          <p class="text-justify">
            La Universidad Mesoamericana es una zona libre de tabaco, por ende los salones de
            conferencia de la sede son áreas de no fumado. Usted puede fumar fuera de la sede.
          </p>
          <p class="text-justify">
            Según la legislación vigente no se permite fumar en las áreas interiores de  restaurantes y bares. Por cualquier duda,
            es mejor preguntar antes de encender un cigarrillo, aunque debería haber siempre letreros que lo indiquen.
          </p>
        </div>

        <div id="alcohol" class="right-block">
          <h4 class="display-6 font-italic font-weight-bold">Alcohol</h4>
          <p class="text-justify">
            La edad mínima que la ley establece para la compra de alcohol es 18 años. Es probable que se pida
            identificación al momento de realizar la compra en restaurantes, bares, supermercados u otros
            establecimientos.
          </p>
        </div>

        <div id="free-time" class="right-block">
          <h3 class="font-weight-bold">Atracciones cerca del hotel</h3>
          <p class="text-justify">
            <ul>
              <li>
                <p class="mb-0">Parque central de Quetzaltenango: 1 minutos a pie.</p>
              </li>

              <li>
                <p class="mb-0">Museo de Historia Natural: 2 minutos a pie.</p>
              </li>

              <li>
                <p class="mb-0">Catedral de Quetzaltenango: 2 minutos a pie.</p>
              </li>

              <li>
                <p class="mb-0">Fábrica de productos textiles Trama Textiles: 3 minutos a pie.</p>
              </li>

              <li>
                <p class="mb-0">Teatro Municipal: 5 minutos a pie.</p>
              </li>

              <li>
                <p class="mb-0">Museo del ferrocarril de Los Altos: 24 minutos a pie.</p>
              </li>

              <li>
                <p class="mb-0">Parque Nacional Cerro El Baúl: 36 minutos a pie.</p>
              </li>

              <li>
                <p class="mb-0">Volcán Santa María: 7 km.</p>
              </li>
            </ul>
          </p>
        </div>

        <div id="recomendaciones" class="right-block">
          <h3 class="font-weight-bold">Recomendaciones de Seguridad</h3>
          <p class="text-justify">
            La zona del evento y de hospedaje es relativamente segura, es normal observar personas caminando
            solas, portando su teléfono móvil en la mano o paseando a sus mascotas; sin embargo se recomienda
            seguir las normas básicas de seguridad:
            <ul>
              <li>Camine siempre en grupo, nunca en solitario.</li>
              <li>Evite zonas oscuras o solitarias.</li>
              <li>No porte objetos de valor, o evite mostrarlos.</li>
              <li>Guarde una copia de su pasaporte y de demás documentos de importancia, en un lugar aparte, o en digital.</li>
              <li>En caso de emergencia llame a:
                  <ul>
                    <li>122 y 123: Sistema de emergencias de Guatemala (no requiere línea telefónica activa)..</li>
                  </ul>
              </li>
            </ul>
          </p>
        </div>

      </div>
    </div>

  </div>
  <!-- /.row -->

</div>
<!-- /.container -->
<script>

  var bool = false;
  var documentHeight = $(document).height();
  var partialHeight  =  documentHeight -(documentHeight * 0.10);
  var partialHeight2 = documentHeight -(documentHeight * 0.06);

  @if (!Agent::isMobile())

  $(window).scroll(function()
  {
    if( $(".show").find(".active").length == 0){
       //$(".collapse").removeClass("show");
       $(".collapse").collapse('hide');
    }

    if( $("a.active").length != 0 && !($("a.active").parents(".show").eq(2).length) && !bool){
      //$("a.active").parents().eq(2).addClass("show");

      $("a.active").parents().eq(2).collapse('show');
    }


    var windowScroll = $(window).scrollTop();
    console.log($("#prueba").css("width"));
    if( windowScroll >=  partialHeight2 ){
      $("#colSide").removeClass("side-bar m-2 p-0").addClass("side-bar-sticky");
      $("#colContent").removeClass("offset-lg-3 mb-4");

      $("#colSide").css({
        "margin-top": partialHeight2,
        "width": "auto"
      });

      $("#prueba").css({
        "display": "none"
      });

    }else{
      $("#colSide").removeClass("side-bar-sticky").addClass("side-bar m-2 p-0");
      $("#colContent").addClass("offset-lg-3 mb-4");
      $("#prueba").css({
        "display": "block"
      });

      $("#colSide").css({
        "width": $("#prueba").width()
      });
    }

    // var windowLevel = $(window).scrollTop();
    // var marginLevel = parseInt($(".col-lg-3").height())*0.92;
    // var sideContainer = $("#colSide");
    // var colContent = $("#colContent");
    // var top = $("#rowContainer").height()*0.92;
    // if( (windowLevel >= marginLevel))
    // {
    //   colContent.removeClass("offset-lg-3");
    //   sideContainer.removeClass("m-2 p-0");
    //   sideContainer.css({
    //     "position": "relative",
    //     "top": top
    //   });
    // }else
    // {
    //  colContent.addClass("offset-lg-3");
    //  sideContainer.addClass("m-2 p-0");
    //  sideContainer.css({
    //     "position": "fixed",
    //     "top": ""
    //   });

    // }
    bool = false;
  });


  $(window).resize(function()
  {
     var widthCol = $("#prueba").width();
    $("#colSide").css({
      "width": widthCol
    });
  });

  @endif



  $("a.btn").click(function()
  {
    bool = true;
    $("a.active").removeClass("active");
    if( $("div.show").length != 0 )
    {
      //$(this).addClass("active");
      $("div.collapse").collapse("hide");
    }

    $("a.active").removeClass("active");
  });



</script>
@parent
@stop
