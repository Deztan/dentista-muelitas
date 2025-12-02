@extends('reportes.pdf.layout')

@section('title', 'Reporte de Pacientes')

@section('content')
<div class="info-section">
    <h3>Reporte de Pacientes</h3>
    <p>
        @if($desde || $hasta)
            Período: 
            {{ $desde ? $desde->format('d/m/Y') : 'Inicio' }} - 
            {{ $hasta ? $hasta->format('d/m/Y') : 'Actualidad' }}
        @else
            Todos los pacientes
        @endif
    </p>
</div>

<!-- Estadísticas -->
<div class="stats-grid">
    <div class="stat-box">
        <div class="stat-label">Total Pacientes</div>
        <div class="stat-value">{{ $totalPacientes }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Pacientes Nuevos</div>
        <div class="stat-value" style="color: #28a745;">{{ $totalPacientesNuevos }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Citas Completadas</div>
        <div class="stat-value" style="color: #17a2b8;">{{ $totalCitasCompletadas }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Citas Canceladas</div>
        <div class="stat-value" style="color: #dc3545;">{{ $totalCitasCanceladas }}</div>
    </div>
</div>

<!-- Listado de pacientes -->
<div class="info-section">
    <h3>Listado de Pacientes</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 25%;">Paciente</th>
                <th style="width: 15%;">CI</th>
                <th style="width: 20%;">Teléfono</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 15%;" class="text-center">Total Citas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($queryPacientes as $paciente)
                <tr>
                    <td>{{ $paciente->nombre }} {{ $paciente->apellido }}</td>
                    <td>{{ $paciente->ci ?? 'N/A' }}</td>
                    <td>{{ $paciente->telefono ?? 'N/A' }}</td>
                    <td>{{ $paciente->email }}</td>
                    <td class="text-center">
                        <strong>{{ $paciente->citas->count() }}</strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No se encontraron pacientes</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
