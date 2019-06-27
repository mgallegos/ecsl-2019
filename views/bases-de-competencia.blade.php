@extends('ecsl-2019::base')

@section('container')
<!-- Page Content -->
<div class="container">

  <!-- Page Heading/Breadcrumbs -->
  <h1 class="mt-4 mb-3">Bases de Competencia</h1>

  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="{{URL::to('cms/inicio')}}"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a>
    </li>
    <li class="breadcrumb-item">Evento</li>
    <li class="breadcrumb-item active">Bases de competencia</li>
  </ol>

  <div class="row">
    <div class="col-md-10 mx-auto">
      <h5 class="mb-0 text-center">Bases de Competencia</h5>
      <h3 class="text-center">“ROBOT SEGUIDOR DE LÍNEA VELOCISTA”</h3>

      <p class="h6 font-weight-bold mb-0">1. Descripción General:</p>
      <p class="text-justify">El objetivo de ésta competencia es completar las pistas de
      competición (habrán varias pistas, que se utilizarán según el momento de la competencia)
      en el menor período de tiempo posible, el tiempo se medirá basado en cronómetro de inicio
      a fin.</p>

      <p class="h6 font-weight-bold mb-0">2. Participantes:</p>
      <ol type="a" class="text-justify">
        <li>Cada participante podrá ser un equipo de hasta 3 personas o de forma individual.</li>
        <li>Cada participante (equipo o individual), deberá presentar por lo menos un robot en condiciones de funcionamiento. No se permite que un participante (grupo o individual) compita con dos robots distintos.</li>
        <li>Todos los participantes (equipo o individual) deberán estar oficialmente inscritos en la competencia.</li>
        <li>Cada participante que haya sido formado por equipo, deberá nombrar a una persona que funge como capitán o representante.</li>
        <li>Una persona, podrá competir bajo dos participantes (grupos o individual).
            Ejemplo de competencia de una participación en grupo y una participación
            individual: Juan Reyes es miembro del equipo participante A con el robot 1,
            pero también podrá participar como Juan Reyes, participante C con el robot
            2. Ejemplo de competencia con dos participaciones en dos grupos: Carlos
            Rivera es miembro del equipo participante B con el robot 6 y miembro del
            equipo participante G con el robot 3. Como individual podrá participar con
            solo un robot.
        </li>
      </ol>

      <p class="h6 font-weight-bold mb-0">3. Inscripción:</p>
      <ol type="a" class="text-justify">
        <li>Todo participante (equipo o individual), deberá inscribirse con la persona encargada (Iver Adolfo Vargas), por correo electrónico (ing.ivargas21314@gmail.com indicando en el asunto inscripción
            competencia robot seguidor de linea velocista) o en la ubicación física destinada para el efecto.</li>
        <li>Deberán consignar los siguientes datos: nombre del participante (grupo o individual), nombre del robot, fotografía del robot, nombre de los miembros que compongan el grupo, nacionalidad.</li>
        <li>La inscripción se cerrará el día viernes 05 de julio a las 11:00 horas.</li>
        <li>Se llevará a cabo el sorteo e identificación de cruces/duelos el día viernes 05 de julio a las 14:00 horas.</li>
      </ol>

      <p class="h6 font-weight-bold mb-0">4. Costo de la inscripción:</p>
      <p class="text-justify">Deberá ser miembros registrado oficialmente dentro del ECSL 2019 para participar en la competencia de robots.</p>

      <p class="h6 font-weight-bold mb-0">5. Pruebas:</p>
      <ol type="a" class="text-justify">
        <li>Las pruebas en las pistas disponibles se podrán hacer el día viernes 05 de julio de 14:00 horas a 15:00 horas.</li>
        <li>Las pruebas se podrán realizar con el objetivo de ajustar sus robots previo a la competencia oficial.</li>
      </ol>

      <p class="h6 font-weight-bold mb-0">6. Caracteristicas del Robot:</p>
      <p class="text-justify mb-0">Velando por una igualdad en la competencia, es necesario cumplir con las siguientes características</p>
      <ol type="a" class="text-justify">
        <li>Los robots solamente podrán estar construidos con componentes de tipo diferencial, no podrán competir robots del tipo triciclo o tracción Ackerman.</li>
        <li>Las dimensiones del robot no podrán exceder de 20 cms de ancho x 25 cms de largo, la altura y el peso del robot no está limitada.</li>
        <li>El accionamiento del robot podrá realizarse de forma manual o inalámbrica cuando se indique la salida. Los robots no pueden tener partes en movimiento (como las ruedas) antes de la señal de salida.</li>
        <li>En caso que el robot cuente con turbinas en el funcionamiento de la misma podrá activarse antes o después que el juez de la señal de salida.</li>
      </ol>

      <p class="h6 font-weight-bold mb-0">7. Limitaciones</p>
      <ol type="a" class="text-justify">
        <li>Cada robot debe ser completamente autónomo a nivel de locomoción, muestreo y procesamiento. Motores, sensores, energía y procesado deben estar incorporados en el robot, debiendo éste tomar sus propias decisiones</li>
        <li>No se podrá dar ninguna instrucción directa o indirectamente al robot después de encenderlo, es decir, no se admite ningún sistema de comunicación con el robot después de accionar su inicio en la competencia.</li>
        <li>No se permite el cambio de baterías. Las baterías deberán estar cargadas para el funcionamiento del robot desde el momento que el robot hace su
            primera competencia hasta terminar todos los turnos. Caso contrario será descalificado. Dichos cambios deberán hacerse antes de iniciar su primera participación.</li>
      </ol>

      <p class="h6 font-weight-bold mb-0">8. Características de las pistas</p>
      <ol type="a" class="text-justify">
        <li>Las pistas la compondrá un circuito abierto, con inicio y final, impreso en banner o pintado sobre madera, con líneas negras sobre superficie blancas de 2.00 cms de grosor.</li>
        <li>Cada pista tendrá las curvas que la organización considere oportunas, pero en ningún caso existirán bifurcaciones.</li>
        <li>Se indicarán los puntos de salida mediante alguna marca que no afecte el desempeño de los robots.</li>
        <li>El radio mínimo de cualquier curva del circuito será de 10cms.</li>
        <li>Alrededor de la pista habrá al menos 0.5m disponibles para los jueces y los representantes de cada equipo para evitar interferencias, en éste espacio
            solamente podrán entrar los jueces y un integrante de cada participante (equipo o individual) en competencia.</li>
        <li>No se garantiza una iluminación especial por lo que los competidores deberán estar preparados para recalibrar sus sensores en caso de que lo requieran.</li>
      </ol>

      <p class="h6 font-weight-bold mb-0">9. Desarrollo de la Competencia</p>
      <ol type="a" class="text-justify">
        <li>La competencia oficial dará inicio el día viernes 05 de julio, a las 15:30 horas con los cruces que se hayan sorteado y el orden establecido.</li>
        <li>Se tendrán 3 intentos de forma alternada por cada competidor, el mejor tiempo entre los tres intentos se tendrá en cuenta para tomar el veredicto final.</li>
        <li>Al iniciar la competencia todos los robots serán colocados en la mesa principal de competencia. Podrán ser movidos cuando les toque su participación.</li>
        <li>El robot se colocará centímetros antes de la línea de control (marca específica en la pista) especificada por el juez</li>
        <li>El robot se encenderá al escuchar la señalización del juez y proseguirá en su movimiento hasta llegar a la meta final.</li>
        <li>No existe petición de parada de carrera.</li>
        <li>Si el robot no funciona desde el principio o deja de funcionar por cualquier motivo, en dos de sus tres intentos, pierde automáticamente el duelo y quedaría eliminado de la competencia.</li>
        <li>Una vez que el robot termine su recorrido deberá ser llevado a la mesa principal de jueces, junto con los demás robots.</li>
        <li>Si un robot requiere mantenimiento tales como limpieza de llantas se podrá realizar previo aviso, mientras que el robot que le precede está en competencia. No se podrá hacer mantenimientos de tipo técnico como ajustes de sensores, recalibración de componentes electrónicos o motores.</li>
        <li>Los robots que pasen de fase de competencia, tendrán 5 minutos previo a la llamada, para ajustes y calibración de sensores, piezas electrónicas o motores.</li>
        <li>Se considerarán faltas graves y acreedoras de descalificación las siguientes:
          <ol type="i">
            <li>La entrada de un miembro del participante (equipo o individual) en la zona reservada sin permiso del juez. Sólo el responsable del equipo puede estar en la pista para colocar el robot durante el desarrollo de la prueba.</li>
            <li>Si la caída de piezas de un robot de forma no intencionada obstaculiza el buen desarrollo de la prueba por parte de su rival.</li>
            <li>Causar desperfectos en la pista o en el robot rival de forma deliberada.</li>
            <li>Cambio de baterías del robot, iniciada la competencia.</li>
          </ol>
        </li>
        <li>El ganador de la competencia será el robot que haya culminado en recorrer las pistas de forma satisfactoria en el menor tiempo posible, y derrotado a sus rivales en cada fase de competencia.</li>
      </ol>

      <p class="h6 font-weight-bold mb-0">10. Tiempos.</p>
      <ol type="a" class="text-justify">
        <li>El tiempo de competencia se mide desde que se da la señal de salida hasta que el robot cruce la línea de meta. Un robot se considera que ha cruzado la línea cuando la parte más adelantada del robot haga contacto con la línea de control.</li>
        <li>Se permitirá un máximo de 2 minutos para que un robot complete la pista establecida. Si no puede completar la pista en el tiempo asignado en dos de los tres intentos, el robot perderá su duelo y quedará descalificado.</li>
        <li>El tiempo podrá ser medido de forma manual o de forma electrónica.</li>
      </ol>

      <p class="h6 font-weight-bold mb-0">11. Control Autónomo:</p>
      <p class="text-justify">Una vez que un robot ha cruzado la línea de salida debe seguir
      siendo totalmente autónomo o será descalificado. Al cruzar la línea final, deberá ser
      autónomo para parar su funcionamiento.</p>

      <p class="h6 font-weight-bold mb-0">12. Pérdida de la línea:</p>
      <p class="text-justify">Se considera válido que un robot regrese a la pista si éste lo logra
      sin ayuda externa, es decir, sin que el operario interfiera; por otro lado, el robot deberá
      regresar a la pista en el mismo punto o antes del punto en que abandonó a la misma, con el
      fin de evitar atajos. Caso contrario será descalificado.</p>

      <p class="h6 font-weight-bold mb-0">13. Jueces</p>
      <ol type="a" class="text-justify">
        <li>La figura del juez es la máxima autoridad dentro de la competencia, él será el encargado de que las reglas y normas establecidas por el comité organizador en ésta categoría sean cumplidas.</li>
        <li>Los jueces para ésta competencia serán designados por el comitéorganizador.</li>
        <li>Los participantes pueden presentar sus objeciones al juez encargado de las categorías antes de que acabe la competencia.</li>
        <li>En caso de duda en la aplicación de las normas en la competencia, la última palabra la tiene siempre el juez principal, ésta decisión es inapelable.</li>
      </ol>

      <h5 class="mb-5 text-center">Comité Organizador</h5>


    </div>

  </div>
  <!-- <p></p> -->
</div>
<!-- /.container -->
@parent
@stop
