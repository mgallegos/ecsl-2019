@extends('ecsl-2019::base')

@section('container')
<?php $prefix = 'pon-'; $appInfo = array('id' => 'presentation-management');?>
<!-- Page Content -->
<div class="container">

  <!-- Page Heading/Breadcrumbs -->
  <h1 class="mt-4 mb-3">Agenda</h1>

  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="{{URL::to('cms/inicio')}}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a>
    </li>
    <li class="breadcrumb-item">Evento</li>
    <li class="breadcrumb-item active">Agenda</li>
  </ol>


<ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="julio-03-tab" data-toggle="tab" href="#julio-03" role="tab" aria-controls="julio-03" aria-selected="true">03 de Julio</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="julio-04-tab" data-toggle="tab" href="#julio-04" role="tab" aria-controls="julio-04" aria-selected="false">04 de Julio</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="julio-05-tab" data-toggle="tab" href="#julio-05" role="tab" aria-controls="julio-05" aria-selected="false">05 de Julio</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="julio-06-tab" data-toggle="tab" href="#julio-06" role="tab" aria-controls="julio-06" aria-selected="false">06 de Julio</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="julio-07-tab" data-toggle="tab" href="#julio-07" role="tab" aria-controls="julio-07" aria-selected="false">07 de Julio</a>
  </li>
</ul>

<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="julio-03" role="tabpanel" aria-labelledby="julio-03-tab">
    <table class="table table-striped table-bordered">
      <tbody>
        <tr>
          <td class="text-center font-weight-bold">03:00 P.M. - 09:00 P.M. </td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2" style="text-transform: uppercase;">Aeropuerto Internacional La Aurora / Estaciones de autobús</p>
            <h5 class="font-weight-bold mb-2" style="text-transform: uppercase;">Recibimiento y traslado hacia hotel de participantes que lo solicitaron.</h5>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="tab-pane fade" id="julio-04" role="tabpanel" aria-labelledby="julio-04-tab">
    <table class="table table-striped table-bordered">
      <tbody>
        <tr>
          <td class="text-center font-weight-bold">6:00 A.M. - 11:00 A.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2" style="text-transform: uppercase;">GASOLINERA PUMA DEL BLVD. LOS PRóCERES</p>
            <h5 class="font-weight-bold mb-2">TRASLADO GUATEMALA - QUETZALTENANGO</h5>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">1:00 P.M. - 3:00 P.M. </td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">LUGAR POR CONFIRMAR</p>
            <h5 class="font-weight-bold mb-2">REGISTRO Y ACREDITACIÓN</h5>
          </td>
        </tr>
        <!-- <tr>
          <td class="text-center font-weight-bold">9:00 A.M. - 9:15 A.M. </td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">LUGAR POR CONFIRMAR</p>
            <h5 class="font-weight-bold mb-2">APERTURA DEL XI ENCUENTRO CENTROAMERICANO DE SOFTWARE LIBRE</h5>
          </td>
        </tr> -->
        <tr>
          <td class="text-center font-weight-bold">3:00 P.M. - 4:00 P.M.</td>
        </tr>
        <tr>
          <td class="text-center table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-04 15:00:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">4:00 P.M. - 5:00 P.M.</td>
        </tr>
        <tr>
          <td class="text-center table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-04 16:00:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">6:00 P.M. - 7:00 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">LUGAR POR CONFIRMAR</p>
            <h5 class="font-weight-bold mb-2">CENA</h5>
          </td>
        </tr>
        <!-- <tr>
          <td class="text-center font-weight-bold">7:30 P.M. - 10:00 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">EVENTO SOCIAL</p>
            <h5 class="font-weight-bold mb-2" style="text-transform: uppercase;">Tour Centro Histórico</h5>
            <h6 class="mb-2">
              Caminata nocturna para conocer el Centro de San Salvador, tour guiado por <a href="https://www.facebook.com/espiral.elsalvador/" target="_blank">Espiral de El Salvador</a>, al finalizar brindaremos, cantaremos y bailaremos en la residencia.<br>
              Puedes preguntar más detalles en el grupo <a href="https://t.me/joinchat/AAAAAEc7J24xaZp0Ub_mfg" target="_blank"><i class="fa fa-telegram" aria-hidden="true"> Social ECSL 2019</i></a>
            </h6>
          </td>
        </tr> -->
      </tbody>
    </table>
  </div>
  <div class="tab-pane fade" id="julio-05" role="tabpanel" aria-labelledby="julio-05-tab">
    <table class="table table-striped">
      <tbody>
        <tr>
          <td class="text-center font-weight-bold">7:00 A.M. - 8:00 A.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">LUGAR POR CONFIRMAR</p>
            <h5 class="font-weight-bold mb-2">DESAYUNO</h5>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">9:00 A.M. - 10:00 A.M. </td>
        </tr>
        <tr>
          <td class="text-center py-4 table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-05 09:00:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">10:00 A.M. - 11:00 A.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-05 10:00:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">11:00 A.M. - 12:00 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-05 11:00:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">12:00 P.M. - 1:00 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-05 12:00:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">1:00 P.M. - 2:30 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">LUGAR POR CONFIRMAR</p>
            <h5 class="font-weight-bold mb-2">ALMUERZO</h5>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">2:30 P.M. - 3:30 P.M.</td>
        </tr>
        <tr>
          <td class="text-center table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-05 14:30:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">3:30 P.M. - 4:30 P.M.</td>
        </tr>
        <tr>
          <td class="text-center table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-05 15:30:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">4:30 P.M. - 5:30 P.M.</td>
        </tr>
        <tr>
          <td class="text-center table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-05 16:30:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <!-- <tr>
          <td class="text-center font-weight-bold">5:00 P.M. - 5:15 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">LUGAR POR CONFIRMAR</p>
            <h5 class="font-weight-bold mb-2">FOTO GRUPAL</h5>
          </td>
        </tr> -->
        <!-- <tr>
          <td class="text-center font-weight-bold">5:20 P.M. - 6:30 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">LUGAR POR CONFIRMAR</p>
            <h5 class="font-weight-bold mb-2">CIERRE DEL XI ENCUENTRO CENTROAMERICANO DE SOFTWARE LIBRE</h5>
          </td>
        </tr> -->
        <tr>
          <td class="text-center font-weight-bold">7:00 P.M. - 8:00 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">LUGAR POR CONFIRMAR</p>
            <h5 class="font-weight-bold mb-2">CENA</h5>
          </td>
        </tr>
        <!-- <tr>
          <td class="text-center font-weight-bold">9:00 P.M. - 12:00 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">EVENTO SOCIAL</p>
            <h5 class="font-weight-bold mb-2">CIERRE FIESTERO EN LA RESIDENCIA</h5>
            <h6 class="mb-2">
              Brindaremos y nos enfiestamos en la residencia, donde también habrá muestra del talento artístico de integrantes de la comunidad.
              Puedes preguntar más detalles en el grupo <a href="https://t.me/joinchat/AAAAAEc7J24xaZp0Ub_mfg" target="_blank"><i class="fa fa-telegram" aria-hidden="true"> Social ECSL 2019</i></a>
            </h6>
          </td>
        </tr> -->
      </tbody>
    </table>
  </div>
  <div class="tab-pane fade" id="julio-06" role="tabpanel" aria-labelledby="julio-06-tab">
    <table class="table table-striped">
      <tbody>
        <tr>
          <td class="text-center font-weight-bold">7:00 A.M. - 8:00 A.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">LUGAR POR CONFIRMAR</p>
            <h5 class="font-weight-bold mb-2">DESAYUNO</h5>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">9:00 A.M. - 10:00 A.M. </td>
        </tr>
        <tr>
          <td class="text-center py-4 table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-06 09:00:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">10:00 A.M. - 11:00 A.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-06 10:00:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">11:00 A.M. - 12:00 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-06 11:00:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">12:00 P.M. - 1:00 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-06 12:00:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">1:00 P.M. - 2:30 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">LUGAR POR CONFIRMAR</p>
            <h5 class="font-weight-bold mb-2">ALMUERZO</h5>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">2:30 P.M. - 3:30 P.M.</td>
        </tr>
        <tr>
          <td class="text-center table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-06 14:30:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">3:30 P.M. - 4:30 P.M.</td>
        </tr>
        <tr>
          <td class="text-center table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-06 15:30:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <td class="text-center font-weight-bold">4:30 P.M. - 5:30 P.M.</td>
        </tr>
        <tr>
          <td class="text-center table-info">
            <div class="row">
              @foreach ($presentationsBySchedule as $index => $presentation)
                @if($presentation['schedule'] == '2019-07-06 16:30:00')
                  @include('ecsl-2019::agenda-item')
                @endif
              @endforeach
            </div>
          </td>
        </tr>
        <!-- <tr>
          <td class="text-center font-weight-bold">5:00 P.M. - 5:15 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">LUGAR POR CONFIRMAR</p>
            <h5 class="font-weight-bold mb-2">FOTO GRUPAL</h5>
          </td>
        </tr> -->
        <!-- <tr>
          <td class="text-center font-weight-bold">5:20 P.M. - 6:30 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">LUGAR POR CONFIRMAR</p>
            <h5 class="font-weight-bold mb-2">CIERRE DEL XI ENCUENTRO CENTROAMERICANO DE SOFTWARE LIBRE</h5>
          </td>
        </tr> -->
        <tr>
          <td class="text-center font-weight-bold">7:00 P.M. - 8:00 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">LUGAR POR CONFIRMAR</p>
            <h5 class="font-weight-bold mb-2">CENA</h5>
          </td>
        </tr>
        <!-- <tr>
          <td class="text-center font-weight-bold">9:00 P.M. - 12:00 P.M.</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">EVENTO SOCIAL</p>
            <h5 class="font-weight-bold mb-2">CIERRE FIESTERO EN LA RESIDENCIA</h5>
            <h6 class="mb-2">
              Brindaremos y nos enfiestamos en la residencia, donde también habrá muestra del talento artístico de integrantes de la comunidad.
              Puedes preguntar más detalles en el grupo <a href="https://t.me/joinchat/AAAAAEc7J24xaZp0Ub_mfg" target="_blank"><i class="fa fa-telegram" aria-hidden="true"> Social ECSL 2019</i></a>
            </h6>
          </td>
        </tr> -->
      </tbody>
    </table>
  </div>
  <div class="tab-pane fade" id="julio-07" role="tabpanel" aria-labelledby="julio-07-tab">
    <table class="table table-striped table-bordered">
      <tbody>
        <tr>
          <td class="text-center font-weight-bold">HORA POR CONFIRMAR</td>
        </tr>
        <tr>
          <td class="text-center py-4 table-success">
            <p class="badge badge-success my-2">LUGAR POR CONFIRMAR</p>
            <h5 class="font-weight-bold mb-2">TRASLADO QUETZALTENANGO - GUATEMALA</h5>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
</div>
<!-- /.container -->
<div id='blog-post-modal' class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="padding: 0.5rem;">
        <!-- <img id='blog-post-header-image' src="{{isset($ogImage)?$ogImage:'http://placehold.it/900x300'}}" class="img-responsive img-fluid" style="display:inline;"> -->
        <h3 id='blog-post-title' class="modal-title"></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute;right: 11px;top: 5px;">
          <span aria-hidden="true">
            &times;
          </span>
        </button>
      </div>
		 	<div class="modal-body">
        <div>
          <div class="row">
            <div class="col-md-7">
              <h5 style="color:grey;font-size: 20px;">
                <img id='blog-post-author-image' class="img-circle" src="" onerror="this.src='http://www.decimaerp.com/assets/kwaai/images/anonymous.png'" style="width: 40px;"></img>
                <span>·</span>
                <span id='blog-post-author'></span>
                <!-- <span>·</span> -->
                <!-- <span id='blog-post-date'></span> -->
              </h5>
            </div>
            <div class="col-md-5 share-buttons">
              <div style="display:  inline-block;">
                <div id='fb-share' class="fb-share-button" data-href="" data-layout="button_count"></div>
              </div>
              <div style="display:inline-block;">
                <div id="twitter-container" class="twitter-share-button"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="mb-2">
          <strong>Eje temático:</strong>&nbsp;<span id='blog-topic'></span><br>
          <strong>Aula:</strong>&nbsp;<span id='blog-space'></span>&nbsp;&nbsp;
          <strong>Fecha y hora:</strong>&nbsp;<span id='blog-date'></span>
        </div>
        <div id='blog-post-content'  class="text-justify mb-2">
          Este es un texto de ejemplo!!!
        </div>
        @include('decima-file::file-cms-viewer')
        <!-- Comments -->
        <div id='fb-comments' class="fb-comments mt-2" data-href="" data-numposts="10" width="100%"></div>
      </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fa fa-undo"></i> Regresar</button>
			</div>
    </div>
  </div>
</div>
@parent
@stop
