<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
    <h1>Correlativo de pago: #{{ $number }}</h1>
    <p>Confirmación de recepción del siguiente pago:</p>
		<ul>
			<li><strong>Fecha y hora:</strong> {{ $datetime }}</li>
			<li><strong>Opción de pago:</strong> {{ $type }}</li>
			<li><strong>Monto:</strong> ${{ $amount }}</li>
			<li><strong>Número de aprobación:</strong> {{ $reference }}</li>
			<li><strong>Realizado por:</strong> {{ $name }}</li>
		</ul>
		<p>Favor de tomar nota:</p>
		<ul>
			<li>Guarde su <strong>correlativo de pago</strong>, le servirá para identificar su inscripción con los miembros del comíte organizador.</li>
			<li>Puede descargar el comprobante de su pago en la sección <strong>"Realizar pago"</strong>, del sitio web oficial del evento.</li>
		</ul>
		<p>Un saludo,<br>Comité Organizador del ECSL 2019.</p>
	</body>
</html>
