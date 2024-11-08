<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header img {
            height: 70px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #d83b67;
            color: #fff;
        }
        .event-details th {
            background-color: #f29c1f;
        }
        .total-section th {
            background-color: #0074bf;
            color: #fff;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h1>REHILETE</h1>
            <p>Espacio Lúdico</p>
        </div>
        <img src="logo.png" alt="Logo">
    </div>

    <table>
        <tr>
            <th>Recibí de:</th>
            <td>{{$abono->evento->dueño->nombre}} {{$abono->evento->dueño->apellido}}</td>
            <th>Teléfono:</th>
            <td>{{$abono->evento->dueño->telefono}}</td>
        </tr>
        <tr>
            <th>La suma de:</th>
            <td colspan="3">${{ number_format($abono->cantidad, 2, '.', ',') }}</td>
        </tr>
        <tr>
            <th>Por concepto de:</th>
            <td colspan="3">Realización del evento "{{$abono->evento->nombre}}" que es basado en un paquete "{{$abono->evento->paquete->nombre}}" </td>
        </tr>
    </table>

    <table class="event-details">
        <tr>
            <th>Fecha evento:</th>
            <td>{{$abono->evento->fecha}}</td>
            <th>Hora inicio:</th>
            <td>{{$abono->evento->hora_inicio}}</td>
            <th>Hora término:</th>
            <td>{{$abono->evento->hora_fin}}</td>
        </tr>
    </table>

    <table class="total-section">
        <tr>
            <th>Total:</th>
            <td>${{ number_format($abono->evento->precio, 2, '.', ',') }}</td>
        </tr>
        <tr>
            <th>Total de Abonos:</th>
            <td>${{ number_format($abono->evento->totalAbonos(), 2, '.', ',') }}</td>
        </tr>
        <tr>
            <th>Resta:</th>
            <td>${{ number_format( $abono->evento->precio -  $abono->evento->totalAbonos() , 2, '.', ',') }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Lic. Citlalli Clemente Parra</p>
        <p>Camino Real a San Gabriel núm. 950, Nandambua 2a Secc, Chiapa de Corzo</p>
        <p>Tel: 961 278 9769 | rehiletespacioludico</p>
    </div>
</body>
</html>
