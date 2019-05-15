<div class="card mb-3">
  <h4 class="card-header">{{ $registroLabel }}</h4>
  <div class="card-body">
    {!! Form::open(array('id'=>'reg-form', 'role' => 'form', 'onsubmit'=>'return false;', 'url'=>URL::to('cms/dashboard'))) !!}
      {!! Honeypot::generate('fc-kwaai-name', 'fc-kwaai-time') !!}
      <!-- <div class="alert alert-dark" role="alert">
        <h6 class="card-title mb-0">Complete el formulario para poder realizar el pago y proponer una o más ponencias.</h6>
      </div> ff7a28-->
      <div class="row">
        <div class="col-md-12">

          <div id="alert-ecsl2018" class="form-group mg-hm alert alert-success">
            <label><strong>¿Participó en el ECSL 2018?</strong></label>
            <hr style="margin-top:0;margin-bottom: .5rem;"/>
            <div class="row">
              <div class="col-12">
                <p>Haz clic <a href="#" data-toggle="modal" data-target="#reg-imp-modal">aquí</a> para importar tus datos</p>
              </div>
            </div>
          </div>

          <div class="row">
            <!--Firstname -->
            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-firstname">Nombres</label>
                <div class="input-group">
                  <span class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-user"></i></div>
                  </span>
                  {!! Form::text('reg-firstname', null, array('id'=>'reg-firstname', 'class'=>'form-control', 'data-mg-required'=>'')) !!}
                  {!! Form::hidden('reg-user-id', null, array('id' => 'reg-user-id')) !!}
                  {!! Form::hidden('reg-registration-form-id', null, array('id' => 'reg-registration-form-id')) !!}
                </div>
              </div>
            </div>

            <!--Lastname -->
            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-lastname">Apellidos</label>
                <div class="input-group">
                  <span class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-user"></i></div>
                  </span>
                  {!! Form::text('reg-lastname', null, array('id'=>'reg-lastname', 'class'=>'form-control', 'data-mg-required'=>'')) !!}
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Password -->
            <div class="col-lg-6 col-md-12">
              <div id="reg-password-col" class="form-group mg-hm">
                <label for="reg-password">Contraseña</label>
                <div class="input-group">
                  <span class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-key"></i></div>
                  </span>
                  {!! Form::password('reg-password', array('id'=>'reg-password', 'class'=>'form-control', 'data-mg-required'=>'')) !!}
                </div>
              </div>
            </div>

            <!-- Password Confirmation -->
            <div class="col-lg-6 col-md-12">
              <div id="reg-password-confirmation-col" class="form-group mg-hm">
                <label for="reg-password-confirmation">Confirmar contraseña</label>
                <div class="input-group">
                  <span class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-key"></i></div>
                  </span>
                  {!! Form::password('reg-password-confirmation', array('id'=>'reg-password-confirmation', 'class'=>'form-control', 'data-mg-required'=>'')) !!}
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- E-mail -->
            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-email">Correo electrónico</label>
                <div class="input-group">
                  <span class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-envelope-o"></i></div>
                  </span>
                  {!! Form::text('reg-email', null, array('id'=>'reg-email', 'class'=>'form-control', 'data-mg-required'=>'')) !!}
                </div>
              </div>
            </div>

            <!-- Contact -->
            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-contact">Teléfono de contacto</label>
                <div class="input-group">
                  <span class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-phone"></i></div>
                  </span>
                  {!! Form::text('reg-contact-phone', null, array('id'=>'reg-contact-phone', 'class'=>'form-control', 'data-mg-required'=>'')) !!}
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Emergency Contact -->
            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-emergency-contact">En caso de emergencia contactar a</label>
                <div class="input-group">
                  <span class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-user"></i></div>
                  </span>
                  {!! Form::text('reg-emergency-contact-name', null, array('id'=>'reg-emergency-contact-name', 'class'=>'form-control', 'data-mg-required'=>'')) !!}
                </div>
              </div>
            </div>

            <!-- Phone Number Emergency Contact -->
            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-number-emergency">Teléfono de contacto de emergencia</label>
                <div class="input-group">
                  <span class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-phone"></i></div>
                  </span>
                  {!! Form::text('reg-emergency-contact-phone', null, array('id' => 'reg-emergency-contact-phone', 'class'=>'form-control', 'data-mg-required'=>'')) !!}
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Country -->
            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-country">País</label>
                @if (!Agent::isMobile())
                  {!! Form::autocomplete('reg-country-label', $countries, array('class' => 'form-control', 'data-mg-required' => '', 'data-default-id'=> ''), 'reg-country-label', 'reg-country-id', null, null, null, 10, 'btn-outline-secondary', '4') !!}
                  {!! Form::hidden('reg-country-id', null, array('id'  => 'reg-country-id')) !!}
            		@else
                  {!! Form::select('reg-country-id', array(
                    '11' => 'Argentina',
                    '35'  => 'Belize',
                    '28' => 'Bolivia',
                    '29' => 'Brazil',
                    '44' => 'Chile',
                    '49' => 'Cuba',
                    '48' => 'Costa Rica',
                    '47' => 'Colombia',
                    '60' => 'Ecuador',
                    '224' => 'Estados Unidos de América',
                    '65' => 'España',
                    '202' => 'El Salvador',
                    '77' => 'French Guiana',
                    '90' => 'Guyana',
                    '87' => 'Guatemala',
                    '93' => 'Honduras',
                    '150' => 'Mexico',
                    '158' => 'Nicaragua',
                    '166' => 'Panamá',
                    '179' => 'Paraguay',
                    '167' => 'Perú',
                    '200' => 'Suriname',
                    '225' => 'Uruguay',
                    '229' => 'Venezuela')
                    , null,
                    array('id'=>'reg-country-id', 'class'=>'form-control', 'data-mg-required'=>''))
                  !!}
            		@endif
              </div>
            </div>

            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-state">Departamento/Provincia</label>
                <div class="input-group">
                  <span class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-map"></i></div>
                  </span>
                  {!! Form::text('reg-state', null, array('id'=>'reg-state', 'class'=>'form-control', 'data-mg-required'=>'')) !!}
                </div>
              </div>
            </div>

          </div>

          <div class="row">

            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-district">Municipio</label>
                <div class="input-group">
                  <span class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-map-marker"></i></div>
                  </span>
                  {!! Form::text('reg-district', null, array('id'=>'reg-district', 'class'=>'form-control', 'data-mg-required'=>'')) !!}
                </div>
              </div>
            </div>

            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label id="reg-passport-number-label" for="reg-passport-number">Pasaporte</label>
                <div class="input-group">
                  <span class="input-group-prepend">
                    <div class="input-group-text"><i class="fa fa-id-card"></i></div>
                  </span>
                  {!! Form::text('reg-passport', null, array('id'=>'reg-passport', 'class'=>'form-control', 'data-mg-required'=>'')) !!}
                </div>
              </div>
            </div>

          </div>

          <!-- Address -->
<!--
          <div class="form-group mg-hm">
            <label for="reg-address">Dirección en su país</label>
            <div class="input-group">
              <span class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-home"></i></div>
              </span>
              {!! Form::text('reg-address', null, array('id'=>'reg-address', 'class'=>'form-control')) !!}
            </div>
          </div> -->


          <div class="row">
            <!-- Tshirt Size -->
            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-tshirt-size">Talla de camiseta</label>
                @if (!Agent::isMobile())
                  {!! Form::autocomplete('reg-shirt-size', array('S', 'M', 'L', 'XL', 'XXL'), array('class' => 'form-control', 'data-mg-required'=>''), null, null, null, null, null, null, 'btn-outline-secondary', '4') !!}
            		@else
                  {!! Form::select('reg-shirt-size', array('S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL', 'XXL' => 'XXL'), null, array('id'=>'reg-shirt-size', 'class'=>'form-control', 'data-mg-required'=>'')) !!}
            		@endif
              </div>
            </div>

            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-birthdate">Fecha de nacimiento</label>
                {!! Form::date('reg-birth-date', array('class' => 'form-control', 'data-mg-required'=>''), null, 'btn-outline-secondary', '4', 'c-55:c') !!}
              </div>
            </div>
          </div>


          <div class="row">
            <!-- Gender -->
            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-gender">Género</label>
                @if (!Agent::isMobile())
                  {!! Form::autocomplete('reg-gender', array('Mujer','Hombre', 'Deseo especificarlo', 'Prefiero no decirlo'), array('class' => 'form-control', 'data-mg-required'=>''), null, null, null, null, null, null, 'btn-outline-secondary', '4') !!}
            		@else
                  {!! Form::select('reg-gender', array('Mujer' => 'Mujer', 'Hombre' => 'Hombre', 'Deseo especificarlo' => 'Deseo especificarlo', 'Prefiero no decirlo' => 'Prefiero no decirlo'), null, array('id'=>'reg-gender', 'class'=>'form-control')) !!}
            		@endif
            </div>
            </div>

            <!-- Gender -->
            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-birthdate">Mi género está mejor representado como</label>
                {!! Form::text('reg-custom-gender', null, array('id'=>'reg-custom-gender', 'class'=>'form-control', 'disabled'=>'disabled')) !!}
              </div>
            </div>
          </div>

          <!-- <hr> -->

          <div class="form-group mg-hm">
            <label for="institution">Institución que representa</label>
            <div class="input-group">
              <span class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-university"></i></div>
              </span>
              {!! Form::text('reg-institution', null, array('id'=>'reg-institution', 'class'=>'form-control')) !!}
            </div>
          </div>

          <!-- <hr> -->

          <div class="row">
            <!-- Health Condition -->
            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-health-condition">Enfermedades / Alergias</label>
                  {!! Form::textareacustom('reg-health-condition', 4, 500, array('class' => 'form-control')) !!}
                </div>
            </div>

            <!-- Special Needs -->
            <div class="col-lg-6 col-md-12">
              <div class="form-group mg-hm">
                <label for="reg-special-needs">Necesidades específicas</label>
                  {!! Form::textareacustom('reg-specific-needs', 4, 500, array('class' => 'form-control')) !!}
              </div>
            </div>
          </div>

          <!-- Previous ECSL -->
          <div class="form-group mg-hm">
            <label>Encuentros anteriores en los que ha participado</label>
            <div class="row">
              <div class="col-lg-6 col-md-12">
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-participated-in-ecsl2009' class="form-check-input" type="checkbox" value=""> Nicaragua 2009
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-participated-in-ecsl2010' class="form-check-input" type="checkbox" value=""> Costa Rica 2010
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-participated-in-ecsl2011' class="form-check-input" type="checkbox" value=""> El Salvador 2011
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-participated-in-ecsl2012' class="form-check-input" type="checkbox" value=""> Guatemala 2012
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-participated-in-ecsl2013' class="form-check-input" type="checkbox" value=""> Belize 2013
                  </label>
                </div>
              </div>
              <div class="col-lg-6 col-md-12">
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-participated-in-ecsl2014' class="form-check-input" type="checkbox" value=""> Panamá 2014
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-participated-in-ecsl2015' class="form-check-input" type="checkbox" value=""> Honduras 2015
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-participated-in-ecsl2016' class="form-check-input" type="checkbox" value=""> Nicaragua 2016
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-participated-in-ecsl2017' class="form-check-input" type="checkbox" value=""> Costa Rica 2017
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-participated-in-ecsl2018' class="form-check-input" type="checkbox" value=""> El Salvador 2018
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- Linux Distros -->
          <div class="form-group mg-hm">
            <label for="email">Distibuciones Linux que utiliza:</label>
            <div class="row">
              <div class="col-lg-6 col-md-12">
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-debian-linux-user' class="form-check-input" type="checkbox" value=""> Debian
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-ubuntu-linux-user' class="form-check-input" type="checkbox" value=""> Ubuntu
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-mint-linux-user' class="form-check-input" type="checkbox" value=""> Linux Mint
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-arch-linux-user' class="form-check-input" type="checkbox" value=""> Arch Linux
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-slackware-linux-user' class="form-check-input" type="checkbox" value=""> Slackware
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-opensuse-linux-user' class="form-check-input" type="checkbox" value=""> OpenSUSE
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-knoppix-linux-user' class="form-check-input" type="checkbox" value=""> Knoppix
                  </label>
                </div>
              </div>
              <div class="col-lg-6 col-md-12">
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-centos-linux-user' class="form-check-input" type="checkbox" value=""> CentOS
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-damn-linux-user' class="form-check-input" type="checkbox" value=""> Damn Small Linux
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-dream-linux-user' class="form-check-input" type="checkbox" value=""> Dream Linux
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-elementary-linux-user' class="form-check-input" type="checkbox" value=""> Elementary OS
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-fedora-linux-user' class="form-check-input" type="checkbox" value=""> Fedora
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-gentoo-linux-user' class="form-check-input" type="checkbox" value=""> Gentoo
                  </label>
                </div>
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-antergos-linux-user' class="form-check-input" type="checkbox" value=""> Antergos
                  </label>
                </div>
              </div>
            </div>
          </div>
          <!-- Other Distribution -->
          <div class="form-group row">
            <label for="reg-other-distribution" class="col-sm-3 col-form-label">Especificar distribución</label>
            <div class="col-sm-9">
              {!! Form::text('reg-custom-distribution', null, array('id'=>'reg-custom-distribution', 'class'=>'form-control')) !!}
            </div>
          </div>

          <div class="form-group mg-hm alert alert-success">
            <label><strong>Opción alimenticia alternativa</strong></label>
            <hr style="margin-top:0;margin-bottom: .5rem;"/>
            <div class="row">
              <div class="col-12">
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-vegetarian' class="form-check-input" type="checkbox" value=""> Deseo optar por la opción vegetariana en todas las comidas del evento (disponible para los paquetes parcial y completo).
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- <div class="form-group mg-hm alert alert-success">
            <label><strong>Competencia de seguidores en línea</strong></label>
            <hr style="margin-top:0;margin-bottom: .5rem;"/>
            <div class="row">
              <div class="col-12">
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-interested-in-competition' class="form-check-input" type="checkbox" value=""> Estoy interesado en participar en la competencia de seguidores en línea y me gustaría recibir información adicional.
                  </label>
                </div>
              </div>
            </div>
          </div> -->

          <!-- <div class="form-group mg-hm alert alert-success">
            <label><strong>Día social</strong></label>
            <hr style="margin-top:0;margin-bottom: .5rem;"/>
            <div class="row">
              <div class="col-12">
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-interested-in-social-day' class="form-check-input" type="checkbox" value=""> Estoy interesado en participar en el día social que se llevará a cabo en la playa El Amatal, el sábado 14 de julio del 2019 (el costo es adicional a la cuota del evento) y me gustaría recibir información adicional.
                  </label>
                </div>
              </div>
            </div>
          </div> -->

          <div class="form-group mg-hm alert alert-warning">
            <label><strong>Privacidad</strong></label>
            <hr style="margin-top:0;margin-bottom: .5rem;"/>
            <div class="row">
              <div class="col-12">
                <div class="form-check">
                  <label class="form-check-label">
                    <input id='reg-is-gender-visible' class="form-check-input" type="checkbox" value="" checked> Autorizo que el género que especifiqué forme parte de las estadísticas del evento.
                  </label>
                  <label class="form-check-label">
                    <input id='reg-is-general-information-visible' class="form-check-input" type="checkbox" value="" checked> Autorizo que mi país, edad, institución que represento, eventos anteriores que he participado y distribuciones Linux de mi preferencia, formen parte de las estadísticas del evento.
                  </label>
                  <label class="form-check-label">
                    <input id='reg-is-photo-visible' class="form-check-input" type="checkbox" value="" checked> Autorizo que mi <a href="https://gravatar.com" target="_blank">gravatar</a> se muestre en la sección de participantes y ponentes (si aplica) del sitio web.
                  </label>
                </div>
              </div>
            </div>
          </div>

          {!! Form::button($registroLabel, array('id'=>'reg-btn-register', 'class'=>'btn btn-dark', 'style' => 'display:block;')) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
</div>
<div class="modal fade" id="reg-imp-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Importar datos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! Form::open(array('id'=>'reg-imp-form', 'role' => 'form', 'onsubmit'=>'return false;', 'url'=>URL::to('cms/dashboard/import'))) !!}
          {!! Honeypot::generate('reg-imp-kwaai-name', 'reg-imp-kwaai-time') !!}
          <div class="alert alert-dark" role="alert">
            Utilice sus credenciales del sitio web del ECSL 2018
          </div>
          <div class="form-group mg-hm">
            <div class="input-group">
              <span class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-envelope-o"></i></div>
              </span>
              {!! Form::text('reg-imp-email', null, array('id'=>'reg-imp-email', 'class'=>'form-control', 'data-mg-required'=>'', 'placeholder' => Lang::get('security/user-management.email'))) !!}
              </div>
          </div>
          <div class="form-group mg-hm">
            <div class="input-group">
              <span class="input-group-prepend">
                <div class="input-group-text"><i class="fa fa-key"></i></div>
              </span>
              {!! Form::password('reg-imp-password', array('id'=>'reg-imp-password', 'class'=>'form-control', 'data-mg-required'=>'', 'placeholder' => Lang::get('security/user-management.password'))) !!}
              </div>
          </div>
        {!! Form::close() !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Regresar</button>
        <button id = "reg-imp-btn-import" type="button" class="btn btn-dark">Importar</button>
      </div>
    </div>
  </div>
</div>
