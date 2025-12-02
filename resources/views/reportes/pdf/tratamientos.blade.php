@extends('reportes.pdf.layout')

@section('title', 'Reporte de Tratamientos')

@section('content')
<div class="info-section">
    <h3>Reporte de Tratamientos Realizados</h3>
    <p>
        @if($desde || $hasta)
            Período: 
            {{ $desde ? $desde->format('d/m/Y') : 'Inicio' }} - 
            {{ $hasta ? $hasta->format('d/m/Y') : 'Actualidad' }}
        @else
            Todos los tratamientos
        @endif
    </p>
    <p><strong>Total de tratamientos realizados:</strong> {{ $totalTratamientos }}</p>
</div>

<!-- Top 10 Tratamientos -->
<div class="info-section">
    <h3>Top 10 Tratamientos Más Realizados</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;" class="text-center">Posición</th>
                <th style="width: 60%;">Tratamiento</th>
                <th style="width: 30%;" class="text-center">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tratamientosMasRealizados as $index => $item)
                <tr>
                    <td class="text-center">
                        @if($index === 0) 🥇
                        @elseif($index === 1) 🥈
                        @elseif($index === 2) 🥉
                        @else {{ $index + 1 }}
                        @endif
                    </td>
                    <td>{{ $item->tratamiento->nombre ?? 'Sin especificar' }}</td>
                    <td class="text-center"><strong>{{ $item->total }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Historial de tratamientos -->
<div class="info-section">
    <h3>Historial de Tratamientos</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 15%;">Fecha</th>
                <th style="width: 25%;">Paciente</th>
                <th style="width: 30%;">Tratamiento</th>
                <th style="width: 30%;">Odontólogo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expedientes as $expediente)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($expediente->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $expediente->paciente->nombre ?? 'N/A' }} {{ $expediente->paciente->apellido ?? '' }}</td>
                    <td>{{ $expediente->tratamiento->nombre ?? 'N/A' }}</td>
                    <td>{{ $expediente->odontologo->nombre ?? 'N/A' }} {{ $expediente->odontologo->apellido ?? '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No se encontraron tratamientos</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
