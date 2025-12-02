<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura {{ $factura->numero_factura }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        
        @page {
            size: A4;
            margin: 15mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Roboto', Arial, sans-serif;
            font-size: 10px;
            color: #2c3e50;
            line-height: 1.4;
            background-color: white;
        }
        .print-page {
            background: white;
            max-width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 15mm;
            position: relative;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            padding-bottom: 12px;
            border-bottom: 3px solid #3498db;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .logo-container {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-icon {
            font-size: 28px;
            color: white;
        }
        .company-info h1 {
            color: #2c3e50;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .company-info p {
            color: #7f8c8d;
            font-size: 8px;
            margin: 0;
            line-height: 1.3;
        }
        .header-right {
            text-align: right;
        }
        .factura-title {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 8px 18px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
            display: inline-block;
        }
        .invoice-meta {
            display: flex;
            gap: 4px;
            flex-direction: column;
        }
        .meta-row {
            display: flex;
            justify-content: space-between;
            font-size: 8px;
        }
        .meta-row strong {
            color: #7f8c8d;
            font-weight: 500;
        }
        .meta-row span {
            color: #2c3e50;
            font-weight: 600;
        }
        .info-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 15px;
        }
        .info-card {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
        }
        .info-card h3 {
            font-size: 9px;
            color: #3498db;
            margin-bottom: 6px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #3498db;
            padding-bottom: 3px;
        }
        .info-card p {
            margin: 4px 0;
            font-size: 9px;
            color: #2c3e50;
        }
        .info-card strong {
            color: #2c3e50;
            font-weight: 600;
            display: inline-block;
            min-width: 70px;
        }
        .services-section {
            margin: 12px 0;
        }
        .services-section h3 {
            font-size: 10px;
            color: #2c3e50;
            margin-bottom: 8px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .detalles-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border: 2px solid #3498db;
        }
        .detalles-table thead {
            background: #3498db;
            color: white;
        }
        .detalles-table th {
            padding: 6px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .detalles-table td {
            padding: 8px;
            border-bottom: 1px solid #ecf0f1;
            font-size: 9px;
        }
        .detalles-table tbody tr:last-child td {
            border-bottom: none;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totales-section {
            margin-top: 15px;
            display: flex;
            justify-content: flex-end;
        }
        .totales-box {
            width: 250px;
            background: #f8f9fa;
            border: 2px solid #3498db;
        }
        .totales-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 12px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 9px;
        }
        .totales-row:last-child {
            border-bottom: none;
        }
        .totales-row strong {
            color: #2c3e50;
            font-weight: 500;
        }
        .totales-row span {
            color: #2c3e50;
            font-weight: 600;
        }
        .total-final {
            background: #3498db;
            color: white;
            font-size: 11px;
            font-weight: 700;
        }
        .total-final strong,
        .total-final span {
            color: white;
        }
        .estado-badge {
            display: inline-block;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .estado-pagada {
            color: #27ae60;
        }
        .estado-pendiente {
            color: #f39c12;
        }
        .estado-cancelada {
            color: #e74c3c;
        }
        .observaciones {
            margin-top: 12px;
            padding: 8px 10px;
            background-color: #fff9e6;
            border-left: 3px solid #f39c12;
            clear: both;
        }
        .observaciones h4 {
            color: #d68910;
            margin-bottom: 4px;
            font-size: 8px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .observaciones p {
            color: #6c5d3f;
            font-size: 8px;
            line-height: 1.4;
        }
        .payment-method {
            margin-top: 12px;
            padding: 8px 10px;
            background-color: #ecf0f1;
            border-left: 3px solid #3498db;
            clear: both;
        }
        .payment-method h4 {
            color: #2c3e50;
            margin-bottom: 4px;
            font-size: 8px;
            font-weight: 600;
        }
        .payment-method .iban {
            font-family: 'Courier New', monospace;
            font-size: 9px;
            font-weight: 600;
            color: #3498db;
            margin-top: 4px;
            letter-spacing: 0.5px;
        }
        .footer {
            position: absolute;
            bottom: 15mm;
            left: 15mm;
            right: 15mm;
            padding-top: 10px;
            border-top: 1px solid #bdc3c7;
            text-align: center;
        }
        .footer p {
            font-size: 7px;
            color: #95a5a6;
            margin: 2px 0;
        }
        .footer .brand {
            font-weight: 600;
            color: #3498db;
            margin-top: 4px;
            font-size: 8px;
        }
        
        /* Estilos de impresión */
        @media print {
            body {
                background: white;
            }
            .print-page {
                margin: 0;
                padding: 10mm;
                box-shadow: none;
                page-break-after: avoid;
            }
            .footer {
                position: fixed;
                bottom: 10mm;
            }
        }
        
        /* Evitar saltos de página */
        .info-section, .services-section, .totales-section {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="print-page">
        <!-- Encabezado con Logo -->
        <div class="header">
            <div class="header-left">
                <div class="logo-container">
                    <i class="logo-icon">🦷</i>
                </div>
                <div class="company-info">
                    <h1>CLÍNICA DENTAL MUELITAS</h1>
                    <p><strong>Dr. Juan García</strong> • NIF: 12345678A</p>
                    <p>Av. de la Salud, 123 • 28000 Madrid • Tel: 910.000.000</p>
                    <p>Email: correo@clinicadental.es</p>
                </div>
            </div>
            <div class="header-right">
                <div class="factura-title">FACTURA</div>
                <div class="invoice-meta">
                    <div class="meta-row">
                        <strong>N°:</strong>
                        <span>{{ $factura->numero_factura }}</span>
                    </div>
                    <div class="meta-row">
                        <strong>Fecha:</strong>
                        <span>{{ \Carbon\Carbon::parse($factura->created_at)->format('d/m/Y') }}</span>
                    </div>
                    <div class="meta-row">
                        <strong>Estado:</strong>
                        @if($factura->estado === 'pagada')
                            <span class="estado-badge estado-pagada">PAGADA</span>
                        @elseif($factura->estado === 'pendiente')
                            <span class="estado-badge estado-pendiente">PENDIENTE</span>
                        @else
                            <span class="estado-badge estado-cancelada">CANCELADA</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Cliente -->
        <div class="info-section">
            <div class="info-card">
                <h3>Datos del Paciente</h3>
                <p><strong>Nombre:</strong> {{ $factura->paciente->nombre_completo }}</p>
                <p><strong>DNI/CI:</strong> {{ $factura->paciente->ci ?? 'No especificado' }}</p>
                <p><strong>Teléfono:</strong> {{ $factura->paciente->telefono }}</p>
                <p><strong>Email:</strong> {{ $factura->paciente->email }}</p>
            </div>
            <div class="info-card">
                <h3>Detalles de Pago</h3>
                <p><strong>Método:</strong> {{ ucfirst($factura->metodo_pago) }}</p>
                <p><strong>Monto Total:</strong> Bs {{ number_format($factura->monto_total, 2) }}</p>
                <p><strong>Pagado:</strong> Bs {{ number_format($factura->monto_pagado, 2) }}</p>
                <p><strong>Saldo:</strong> Bs {{ number_format($factura->saldo_pendiente, 2) }}</p>
            </div>
        </div>

        <!-- Tabla de Servicios -->
        <div class="services-section">
            <h3>Detalle de Servicios Prestados</h3>
            <table class="detalles-table">
                <thead>
                    <tr>
                        <th style="width: 12%;">Código</th>
                        <th style="width: 48%;">Descripción del Tratamiento</th>
                        <th style="width: 10%;" class="text-center">Cant.</th>
                        <th style="width: 15%;" class="text-right">P. Unit. (Bs)</th>
                        <th style="width: 15%;" class="text-right">Total (Bs)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ $factura->tratamiento->codigo ?? 'TRT-001' }}</strong></td>
                        <td>
                            <strong>{{ $factura->tratamiento->nombre }}</strong>
                            @if($factura->tratamiento->descripcion)
                                <br><span style="color: #7f8c8d; font-size: 8px;">{{ Str::limit($factura->tratamiento->descripcion, 80) }}</span>
                            @endif
                        </td>
                        <td class="text-center">1</td>
                        <td class="text-right">{{ number_format($factura->monto_total, 2) }}</td>
                        <td class="text-right"><strong>{{ number_format($factura->monto_total, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Totales -->
        <div class="totales-section">
            <div class="totales-box">
                <div class="totales-row">
                    <strong>Subtotal:</strong>
                    <span>Bs {{ number_format($factura->monto_total, 2) }}</span>
                </div>
                <div class="totales-row">
                    <strong>Descuento:</strong>
                    <span>Bs 0.00</span>
                </div>
                <div class="totales-row total-final">
                    <strong>TOTAL A PAGAR:</strong>
                    <span>Bs {{ number_format($factura->monto_total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Forma de Pago -->
        <div class="payment-method">
            <h4>Forma de pago: {{ strtoupper($factura->metodo_pago) }}</h4>
            @if($factura->metodo_pago === 'transferencia')
                <p style="font-size: 8px; margin-top: 3px;">Cuenta bancaria: <strong class="iban">BOL 0000 0000 0000 0000 0000</strong></p>
            @endif
        </div>

        <!-- Observaciones -->
        @if($factura->observaciones)
        <div class="observaciones">
            <h4>Observaciones</h4>
            <p>{{ $factura->observaciones }}</p>
        </div>
        @else
        <div class="observaciones">
            <h4>Condiciones</h4>
            <p>Pago en efectivo o transferencia. Validez: 30 días. Gracias por su confianza.</p>
        </div>
        @endif

        <!-- Pie de página -->
        <div class="footer">
            <p>Este documento es un comprobante válido de la factura emitida • Clínica Dental Muelitas</p>
            <p>Gracias por confiar en nuestros servicios • www.dentistamuelitas.com</p>
            <p class="brand">Generado: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <script>
        // Auto-imprimir al cargar (opcional - descomentar si se desea)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
