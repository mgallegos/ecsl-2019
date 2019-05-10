<!DOCTYPE html>
<html>
  <head>
    <link rel="shortcut icon" href="https://storage.googleapis.com/decimaerp/organizations/15/favico.png" type="image/vnd.microsoft.icon" />
    <meta charset="utf-8">

    <title>ECSL-2019</title>
    <style>

      body {
        background-image: url('https://storage.googleapis.com/decimaerp-cloud-bucket/organizations/15/fondo_ecsl2019.png');
        background-position: center;
        background-repeat: no-repeat;
      }

      .root{
        font-size: 1rem;
        display: inline-block;
        text-align: justify;
        line-height: 15pt;
        /* background-image: url('https://storage.googleapis.com/decimaerp/organizations/15/fondo.png'); */
      }

      .contenedor{
        padding-left: 25px;
        padding-right: 25px;
        font-size: 2rem;
        position: relative;
        display: inline-block;
        text-align: justify;
        margin-bottom: 400px;
      }

      .footer{
        padding-left: 25px;
        padding-right: 25px;
        font-size: 2rem;
        position: absolute;

      }

      .pt{
        /* padding-top: 125px; */
        margin-top: 35px;
      }

      .mb{
        /* margin-bottom: 50px; */
      }

      .bold{
        font-weight:bold;
      }

      footer { position: fixed; bottom: 50px; left: 0px; right: 0px;}

    </style>
  </head>

  <body class="pt-3">

    <div class="" width="100%" >
      <img src="https://storage.googleapis.com/decimaerp-cloud-bucket/organizations/15/header_ecsl2019.png" class ="" width="100%" >
    </div>

    <div class="root pt" width="100%">
      <!-- <img  src="https://storage.googleapis.com/decimaerp/organizations/15/fondo.png" width="90%" height="90%" style="padding-left:50px;" class="contenedor"> -->

      <div style="text-align:right;">
        <p>{{ $date }}</p>
      </div>

      <div style="text-align:left;margin-top:40px;">
        <p>A quien corresponda,</p>
      </div>

      <div style="margin-top:30px;">
        <p class="mb">
          Por este medio, el comité organizador del décimo primer <strong>Encuentro Centroamericano de Software Libre (ECSL)</strong>
          remite una atenta invitación a <strong>{{ $name }}</strong> con el propósito de contar con su
          presencia como participante y ponente en el marco de la celebración de dicha actividad,
          la cual tendrá lugar en la Universidad Mesoamericana, el municipio de Quetzaltenango (Xela), Guatemala C.A.
           Dicho evento dará inicio el día miércoles 3 de julio de 2019 y concluyendo el día domingo 7 del mismo mes y año.
        </p>
        <p class="mb">
          El <strong>ECSL</strong> es un evento que se realiza anualmente con el fin de reunir a personas expertas, comunidades y grupos de
          usuarios/as afines a la temática del Software y Hardware Libres, proveyendo espacios de articulación, educación,
          coordinación e intercambio para facilitar el desarrollo y la divulgación de conocimientos sobre tecnologías libres,
          fortalecer acuerdos y formas de trabajo conjuntas, adjuntamos más información sobre el evento en los documentos anexos
          a esta carta de invitación.
        </p>
        <p class="mb">
          En base a lo anteriormente expuesto, se convoca a  <strong>{{ $name }}</strong> para formar parte de la presente
          edición del ECSL.
        </p>

        <table width="100%" style="text-align: center; margin-top: 60px;">
          <tr>
            <td>
              <div class="col text-center">
                <img height="75px"src="https://storage.googleapis.com/decimaerp-cloud-bucket/organizations/15/Firma_ARS_v2.png">
                <p style="line-height: 2pt;margin-bottom: 0;">Axel Ruiz Serrano</p>
                <p style="font-size: 0.8rem;line-height: 10pt;">Representante General del<br>Comité Organizador del ECSL</p>
              </div>
            </td>
            <td>
              <div class="col text-center">
                <img height="100px" src="https://storage.googleapis.com/decimaerp-cloud-bucket/organizations/15/firma_MCCM.png">
                <p style="line-height: 2pt;margin-bottom: 0;">Maria del Carmen Castillo Martini</p>
                <p style="font-size: 0.8rem;line-height: 10pt;">Administración y Marketing del<br>Comité Organizador del ECSL</p>
              </div>
            </td>
          </tr>
        </table>

        <!-- <strong><p class="mb" style="text-align: center;">Sello digital</p></strong> -->


        <p class="mb" style="text-align: center;">Quetzaltenango, Guatemala, Centroamérica.</p>

      </div>
    </div>

    <!-- <div width="100%" style="margin-top:10px;">
      <img  src="https://storage.googleapis.com/decimaerp/organizations/15/PieDePagina.png" class ="" width="100%" >
    </div> -->
    <footer>
      <img  src="https://storage.googleapis.com/decimaerp-cloud-bucket/organizations/15/footer_ecsl2019.png" width="100%" >
    </footer>

  </body>
</html>
