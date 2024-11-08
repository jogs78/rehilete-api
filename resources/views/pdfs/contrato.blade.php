<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Arrendamiento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            margin: 20px;
        }
        h1, h2 {
            text-align: center;
        }
        .clause {
            margin-bottom: 20px;
        }
        .signature {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <img src="logo.png" alt="Logo" height="70px">

    <h1>Contrato de Arrendamiento del Salón de Eventos "REHILETE"</h1>
    <p>Que celebran por una parte en su calidad de GERENTE el (la) Sr(a). {{$evento->gerente->nombre}} {{$evento->gerente->apellido}}, 
     y por la otra parte en su calidad de ARRENDATARIO el (la) sr.(a) {{$evento->dueño->nombre}} {{$evento->dueño->apellido}}, 
     ambos con capacidad legal para celebrar el presente contrato, para los efectos acuerdan las partes que se les designe como 
     ARRENDADOR y ARRENDATARIO, respectivamente, en el tenor de las siguientes declaraciones y cláusulas:</p>

    <h2>CLÁUSULAS</h2>

    <div class="clause">
        <strong>PRIMERA</strong>.- El objeto del presente contrato es el arrendamiento del salón de eventos denominado "REHILETE" 
        con capacidad máxima de 100 personas, ubicado en Camino Real a San Gabriel núm. 950 esquina con calle innominada, 
        Nandambua 2ª. Sec., Chiapa de Corzo, Chiapas. Por lo que "EL ARRENDADOR" se obliga a mantener en buen estado y limpio el 
        salón en la fecha acordada y "EL ARRENDATARIO" se obliga a pagar la cantidad estipulada en la Cláusula Tercera de este 
        Contrato.
    </div>

    <div class="clause">
        <strong>SEGUNDA</strong>.- El salón se usará para realizar el evento de: <em>"{{$evento->nombre}}"</em> que es 
        basado en un paquete <em>"{{$evento->paquete->nombre}}"</em>, iniciando a las <em>{{$evento->hora_inicio}}</em> 
        horas y concluyendo a las <em>{{$evento->hora_fin}}</em> horas, del día <em>{{$evento->fecha}}</em>. La duración del 
        evento incluye la recepción y desalojo del lugar. Cabe precisar que si esta cláusula no se cumple en sus términos, 
        "EL ARRENDATARIO" se obliga a pagar el costo de una hora extra por ocupación de tiempo adicional del salón, siempre y 
        cuando haya disponibilidad.
    </div>

    <div class="clause">
        <strong>TERCERA</strong>.- El precio total que "EL ARRENDATARIO" se obliga a pagar por concepto de renta y servicios del 
        salón es de $ <em>{{$evento->precio}}</em> (Tres mil pesos 00/100 M.N.). En caso de que "EL ARRENDATARIO" requiera hacer 
        uso del salón por más tiempo del estipulado en la Cláusula Segunda del presente contrato, "EL ARRENDADOR" cobrará la 
        cantidad de $ <em>400.00</em> por hora adicional.
        <!--
        "EL ARRENDATARIO" se obliga a depositar la cantidad de $ <em>600.00</em> (Seiscientos pesos 00/100 M.N.) para garantizar 
        el pago de los servicios accesorios al uso del inmueble. Dicho depósito será devuelto el día del evento al finalizar el 
        evento o al retiro del mobiliario si fuese contratado, siempre y cuando no se hayan generado daños a los bienes muebles 
        o a los objetos antes mencionados.
        -->
    </div>a

    <div class="clause">
        <strong>CUARTA</strong>.- "EL ARRENDATARIO" excluye de cualquier responsabilidad al "ARRENDADOR" por accidentes ocurridos 
        dentro de las instalaciones arrendadas durante el evento.
    </div>

    <div class="clause">
        <strong>QUINTA</strong>.- La renta incluye exclusivamente las siguientes instalaciones: Área jardinada, Cocina, 
        Baños para hombres, mujeres y discapacitados, Salón de eventos techado, y la disponibilidad de la zona de sombrillas.
    </div>

    <div class="clause">
        <strong>SEXTA</strong>.- "EL ARRENDADOR" se obliga a prestar el salón de eventos en perfectas condiciones para la 
        realización del evento, cuidando la higiene de los baños, cocinas, y demás instalaciones señaladas en la cláusula 
        anterior.
    </div>

    <div class="clause">
<!--
     <strong>SÉPTIMA</strong>.- Si los bienes destinados a la prestación del servicio sufrieran un menoscabo por culpa o 
     negligencia de "EL ARRENDATARIO", "EL ARRENDADOR" tendrá derecho a usar el depósito de garantía para la reparación 
     de los mismos.
-->    
     <strong>SÉPTIMA</strong>.- Si los bienes destinados a la prestación del servicio sufrieran un menoscabo por culpa o 
     negligencia de "EL ARRENDATARIO", "EL ARRENDADOR" se compromete a cubrir los costos de reparación o reposición 
     de los mismos.
    </div>

    <p>No habiendo más que conste sobre el presente documento y enteradas las partes de su alcance y contenido, lo firman 
     en la ciudad de Chiapa de Corzo.</p>

    <div class="signature">
        <p>_________________________</p>
        <p>ARRENDADOR: {{$evento->gerente->nombre}} {{$evento->gerente->apellido}}</p>

        <p>_________________________</p>
        <p>ARRENDATARIO: {{$evento->dueño->nombre}} {{$evento->dueño->apellido}}</p>
    </div>
</body>
</html>
