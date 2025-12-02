<x-mail::message>
# Recordatorio de Cita

Hola **{{ $paciente->nombre_completo }}**,

Te recordamos que tienes una cita programada en nuestra clínica:

<x-mail::panel>
📅 **Fecha:** {{ $fechaFormateada }}  
🕒 **Hora:** {{ $horaFormateada }}  
👨‍⚕️ **Doctor(a):** {{ $odontologo->nombre_completo ?? 'Por asignar' }}  
💉 **Tratamiento:** {{ $tratamiento->nombre ?? 'Consulta general' }}
</x-mail::panel>

## Recomendaciones:

- Por favor, llega **10 minutos antes** de tu hora programada
- Si necesitas **reprogramar** tu cita, contáctanos lo antes posible
- Trae contigo tu carnet de identidad

<x-mail::button url="{{ config('app.url') }}" color="success">
Ver Mis Citas
</x-mail::button>

¡Te esperamos!

Saludos cordiales,<br>
**Clínica Dental Muelitas**<br>
📞 Teléfono: (591) 123-4567<br>
📍 Dirección: La Paz, Bolivia
</x-mail::message>
