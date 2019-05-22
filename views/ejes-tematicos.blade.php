@extends('ecsl-2019::base')

@section('container')
<!-- Page Content -->
<div class="container">

  <!-- Page Heading/Breadcrumbs -->
  <h1 class="mt-4 mb-3">Ejes Temáticos</h1>

  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="{{URL::to('cms/inicio')}}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a>
    </li>
    <li class="breadcrumb-item">Evento</li>
    <li class="breadcrumb-item active">Ejes Temáticos</li>
  </ol>

    <div class="card-deck">
      <div class="card">
        <h5 class="card-header">Software Libre</h5>
        <div class="card-body">
          <p class="card-text text-justify">Compartir los distintos proyectos de desarrollo y/o utilización de software libre, promoviendo los entornos y tecnologias para fortalecer el avance de la region. Fomentar el intercambio de informacion y conocimiento para crear entornos colaborativos para el desarrollo de estrategias para la promocion del software libre.</p>
        </div>
      </div>
      <div class="card">
        <h5 class="card-header">Hardware Libre</h5>
        <div class="card-body">
          <p class="card-text text-justify">Conocer e identificar las diversas definiciones y clasificaciones existentes sobre hardware libre, generando  procesos de intercambio y liberación de diseño y código que permiten el desarrollo hardware que pueden promover el avance tecnologico.</p>
        </div>
      </div>
      <div class="card">
        <h5 class="card-header">Cultura Libre</h5>
        <div class="card-body">
          <p class="card-text text-justify">Generar un modelo para impulsar la cultura libre potenciando el uso de tecnología y modelos de propiedad intelectual no privativos, permitiendo un entorno adecuado para compartir y distribuir los conocimientos generados en una sociedad.</p>
        </div>
      </div>
    </div>
</div>
<!-- /.container -->
@parent
@stop
