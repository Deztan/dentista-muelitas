<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Insertar expedientes médicos con datos coherentes
$expedientes = [
    // 1. Limpieza dental - Roberto Mendoza
    [
        'paciente_id' => 3, // Roberto Mendoza
        'cita_id' => 1, // Cita existente
        'tratamiento_id' => 1, // Limpieza dental
        'odontologo_id' => 1, // Dr. Carlos Limachi
        'asistente_id' => 2, // María Elena Condori
        'fecha' => Carbon::today()->subDays(5),
        'diagnostico' => 'Paciente presenta acumulación de sarro y placa bacteriana en piezas dentales superiores e inferiores. Encías inflamadas en zona anterior con sangrado al sondaje. No se observan caries activas. Índice de placa bacteriana elevado (75%). Gingivitis moderada generalizada.',
        'descripcion_tratamiento' => 'Se realizó limpieza dental profunda (profilaxis) utilizando ultrasonido para eliminación de cálculos supragingival es y curetas manuales Gracey para limpieza subgingival. Pulido dental con pasta profiláctica abrasiva. Aplicación de flúor tópico en gel al 2% durante 4 minutos. Duración del procedimiento: 45 minutos.',
        'pieza_dental' => null,
        'observaciones' => 'Se instruyó al paciente sobre técnica de cepillado Bass modificado. Se recomendó uso de hilo dental diariamente y enjuague bucal con clorhexidina 0.12% por 15 días. Control y mantenimiento periodontal en 6 meses.',
        'created_at' => now(),
        'updated_at' => now(),
    ],

    // 2. Extracción quirúrgica - Juan Carlos Pérez
    [
        'paciente_id' => 1, // Juan Carlos Pérez
        'cita_id' => 2, // Cita existente
        'tratamiento_id' => 2, // Extracción dental
        'odontologo_id' => 1, // Dr. Carlos Limachi
        'asistente_id' => 3, // Pedro Gutiérrez
        'fecha' => Carbon::today()->subDays(30),
        'diagnostico' => 'Tercer molar inferior derecho (pieza 48) en posición horizontal impactada confirmada por radiografía panorámica. Caries profunda con compromiso pulpar y necrosis. Dolor intenso referido. Pericoronaritis recurrente. Indicación absoluta de extracción quirúrgica.',
        'descripcion_tratamiento' => 'Extracción quirúrgica de tercer molar impactado. Anestesia troncular (bloqueo del nervio dentario inferior) con lidocaína 2% con epinefrina 1:100,000 (3 cartuchos). Incisión de colgajo mucoperióstico triangular. Osteotomía con fresa quirúrgica redonda bajo irrigación constante. Odontosección en 2 fragmentos (corona y raíz). Luxación y extracción con elevadores. Limpieza del alvéolo. Sutura con 3 puntos simples (seda 3-0). Tiempo quirúrgico: 35 minutos.',
        'pieza_dental' => '48',
        'observaciones' => 'Paciente tolera bien el procedimiento. Se prescribió: amoxicilina 500mg cada 8 horas por 7 días, ibuprofeno 400mg cada 8 horas por 5 días, paracetamol 500mg SOS. Dieta blanda y fría primeras 48 horas. Control en 7 días para retiro de puntos. Indicaciones postoperatorias verbales y escritas entregadas. Pronóstico favorable.',
        'created_at' => now(),
        'updated_at' => now(),
    ],

    // 3. Resina dental - Patricia Rojas
    [
        'paciente_id' => 4, // Patricia Rojas
        'cita_id' => 4, // Cita existente
        'tratamiento_id' => 3, // Resina dental
        'odontologo_id' => 1, // Dr. Carlos Limachi
        'asistente_id' => 2, // María Elena Condori
        'fecha' => Carbon::today(),
        'diagnostico' => 'Caries oclusal de tamaño moderado en primer molar superior derecho (pieza 16). Profundidad media sin compromiso pulpar confirmado por pruebas de vitalidad pulpar positivas. Sensibilidad leve a estímulos fríos y dulces. Cavidad Clase I según clasificación Black.',
        'descripcion_tratamiento' => 'Anestesia tópica benzocaína 20% y anestesia infiltrativa vestibular con lidocaína 2%. Aislamiento relativo con rollos de algodón y eyector. Eliminación de tejido cariado con fresa redonda diamantada #2. Preparación cavitaria con paredes divergentes y piso plano. Grabado ácido fosfórico 37% durante 15 segundos. Lavado y secado. Aplicación de adhesivo dentinario fotopolimerizable Single Bond. Resina compuesta nanohíbrida Filtek Z350 XT color A2 en técnica incremental (3 capas de 2mm). Fotopolimerización 20 segundos por capa con lámpara LED. Ajuste oclusal con papel articular. Pulido final con discos Sof-Lex.',
        'pieza_dental' => '16',
        'observaciones' => 'Restauración con anatomía oclusal adecuada y contacto oclusal balanceado. Paciente no refiere molestias post-tratamiento. Se indicó evitar alimentos muy duros por 24 horas. Pulido final satisfactorio con brillo superficial óptimo. Control opcional en 1 mes. Pronóstico excelente.',
        'created_at' => now(),
        'updated_at' => now(),
    ],

    // 4. Blanqueamiento dental - Sofía Vargas
    [
        'paciente_id' => 8, // Sofía Vargas
        'cita_id' => 5, // Cita existente
        'tratamiento_id' => 4, // Blanqueamiento
        'odontologo_id' => 1, // Dr. Carlos Limachi
        'asistente_id' => 5, // Laura Mamani
        'fecha' => Carbon::today()->subDays(9),
        'diagnostico' => 'Paciente solicita blanqueamiento dental por motivos estéticos. Dientes vitales con coloración amarillenta generalizada nivel A3 en escala Vita. No presenta sensibilidad dental previa. Encías en buen estado sin inflamación. Sin caries activas. Buena higiene oral. Expectativas realistas del tratamiento.',
        'descripcion_tratamiento' => 'Blanqueamiento dental profesional en consultorio con sistema de activación LED. Profilaxis previa con pasta sin flúor. Registro fotográfico inicial. Protección gingival con barrera fotopolimerizable (Opaldam). Aplicación de peróxido de hidrógeno al 35% (Zoom WhiteSpeed) en superficie vestibular de piezas anteriores superiores (11-23) e inferiores (31-43). Tres ciclos de 15 minutos cada uno con activación lámpara LED de alta intensidad. Enjuague abundante entre ciclos. Aplicación final de gel desensibilizante con nitrato de potasio 5% y flúor por 10 minutos. Tiempo total: 90 minutos.',
        'pieza_dental' => '11-43',
        'observaciones' => 'Aclaramiento exitoso de 4 tonos en escala Vita (de A3 a A1/B1). Paciente muy satisfecha con el resultado estético. Se indicó dieta blanca por 48 horas (evitar café, té, vino tinto, gaseosas oscuras, salsa de tomate, etc.). Posible sensibilidad dental transitoria en primeras 24-48 horas (respuesta normal). Se entregó kit de mantenimiento casero con gel blanqueador al 10% para uso nocturno durante 5 noches. Control en 2 semanas.',
        'created_at' => now(),
        'updated_at' => now(),
    ],

    // 5. Endodoncia - María García
    [
        'paciente_id' => 2, // María García
        'cita_id' => 3, // Cita existente
        'tratamiento_id' => 5, // Endodoncia
        'odontologo_id' => 1, // Dr. Carlos Limachi
        'asistente_id' => 3, // Pedro Gutiérrez
        'fecha' => Carbon::today()->subDays(14),
        'diagnostico' => 'Pulpitis irreversible sintomática en primer premolar superior izquierdo (pieza 24). Dolor espontáneo severo pulsátil que aumenta en decúbito. Respuesta exagerada y prolongada a estímulos térmicos (especialmente frío). Radiografía periapical muestra caries profunda con proximidad cameral y ensanchamiento leve del ligamento periodontal apical. Prueba de percusión levemente positiva. Indicación de tratamiento de conducto radicular.',
        'descripcion_tratamiento' => 'Endodoncia en pieza 24. Anestesia infiltrativa vestibular y palatina con lidocaína 2% con epinefrina. Aislamiento absoluto con dique de goma (grapa #9). Apertura cameral con fresa redonda diamantada #2. Localización de conducto único (no se encontraron conductos accesorios). Conductometría con localizador apical electrónico: 22mm de longitud de trabajo. Instrumentación con sistema rotatorio ProTaper Universal (SX, S1, S2, F1, F2, F3) a 300 rpm y 2 N/cm de torque. Irrigación copiosa con hipoclorito de sodio 5.25% (20ml) alternado con EDTA 17% para remover smear layer. Secado con puntas de papel estériles. Obturación con conos de gutapercha estandarizados y cemento sellador endodóntico AH Plus mediante técnica de condensación lateral. Radiografía de control final satisfactoria mostrando obturación hermética hasta ápice radiográfico. Restauración temporal con IRM (óxido de zinc eugenol reforzado). Tiempo de tratamiento: 75 minutos.',
        'pieza_dental' => '24',
        'observaciones' => 'Tratamiento de conducto exitoso. Conducto obturado herméticamente sin espacios vacíos o sobrefilling. Paciente sin dolor post-tratamiento inmediato. Se prescribió ibuprofeno 400mg cada 8 horas SOS por 3 días. Se programó cita en 7 días para evaluación y restauración definitiva. Opciones: resina compuesta o corona de porcelana (recomendada por mayor destrucción coronaria). Pronóstico favorable a largo plazo.',
        'created_at' => now(),
        'updated_at' => now(),
    ],

    // 6. Control ortodoncia - Ana Martínez
    [
        'paciente_id' => 6, // Ana Martínez
        'cita_id' => 6, // Cita existente
        'tratamiento_id' => 6, // Ortodoncia
        'odontologo_id' => 1, // Dr. Carlos Limachi
        'asistente_id' => 2, // María Elena Condori
        'fecha' => Carbon::today()->subDays(2),
        'diagnostico' => 'Control mensual de ortodoncia. Paciente en mes 8 de tratamiento (duración estimada 18-20 meses). Brackets metálicos sistema MBT Roth en ambas arcadas. Progreso favorable en alineación y nivelación. Apiñamiento anterior superior reducido en 60%. Buena cooperación del paciente con uso de elásticos intermaxilares. Higiene oral mejorable (presencia de placa alrededor de brackets).',
        'descripcion_tratamiento' => 'Control rutinario de ortodoncia fija. Revisión completa de aparatología: todos los brackets en posición correcta, no se detectaron desprendimientos. Cambio de ligaduras elásticas (color azul solicitado por paciente) por desgaste y decoloración. Activación de arco de acero rectangular 19x25 superior con dobleces de primer y segundo orden. Cambio de arco inferior a acero 18x25 para mayor control tridimensional. Colocación de cadena elástica corta en sector anterosuperior (13 a 23) para cierre de diastemas residuales. Verificación de oclusión y guía anterior. Instrucción reforzada sobre técnica de cepillado en ortodoncia (cepillo en 45° con movimientos circulares).',
        'pieza_dental' => null,
        'observaciones' => 'Evolución del tratamiento según planificación inicial. Cierre de espacios en progreso satisfactorio (3mm de cierre logrado). Se enfatizó importancia de higiene rigurosa para prevenir descalcificaciones del esmalte y gingivitis. Recordatorio: evitar alimentos duros (hielo, caramelos, nueces) y pegajosos (chicles, caramelos masticables) que puedan desprender brackets. Continuar uso de elásticos intermaxilares Clase II (6 oz) 20 horas diarias. Próximo control programado en 4 semanas. Paciente motivado y colaborador.',
        'created_at' => now(),
        'updated_at' => now(),
    ],

    // 7. Preparación corona - Luis Ramírez
    [
        'paciente_id' => 5, // Luis Ramírez
        'cita_id' => null, // Sin cita previa (paciente nuevo para este tratamiento)
        'tratamiento_id' => 7, // Corona
        'odontologo_id' => 1, // Dr. Carlos Limachi
        'asistente_id' => 3, // Pedro Gutiérrez
        'fecha' => Carbon::today()->subDays(6),
        'diagnostico' => 'Primer molar inferior izquierdo (pieza 36) con gran destrucción coronaria por caries extensa de larga data. Tratamiento de conducto endodóntico realizado hace 2 años por otro profesional (confirmado radiográficamente). Obturación endodóntica satisfactoria. Indicación de corona metal-porcelana para restauración completa, protección de estructura remanente y recuperación funcional.',
        'descripcion_tratamiento' => 'Primera sesión para corona definitiva. Anestesia troncular (bloqueo nervio dentario inferior) con lidocaína 2% con epinefrina. Tallado dental con fresas diamantadas cilíndricas de grano grueso y fino (851 y 856). Reducción oclusal de 2mm respetando anatomía. Reducción axial de 1.5mm (360 grados). Línea de terminación en chamfer supragingival de 1mm de ancho. Biselado cuspídeo. Ángulos redondeados. Toma de impresión con silicona de adición (técnica de doble mezcla: masilla pesada + liviana simultánea). Arco facial para montaje en articulador semiajustable. Registro de mordida en relación céntrica con silicona de registro oclusal. Selección de color con guía Vita bajo luz natural: A3 para cuerpo de corona. Confección de corona provisional en acrílico (PMMA) mediante técnica directa, ajuste oclusal con papel articular, cementación temporal con cemento Temp-Bond ZnOE. Tiempo de preparación: 60 minutos.',
        'pieza_dental' => '36',
        'observaciones' => 'Tallado con geometría adecuada y líneas de terminación bien definidas. Impresiones de excelente calidad enviadas a laboratorio dental "DentalTech". Orden de trabajo: corona metal-porcelana sobre muñón, aleación cobalto-cromo, porcelana feldespática color A3. Fabricación estimada: 7-10 días hábiles. Paciente con corona provisional estable y estética aceptable. Se indicó evitar masticación intensa en ese sector y alimentos muy pegajosos. Cita programada para cementación definitiva. Pronóstico excelente.',
        'created_at' => now(),
        'updated_at' => now(),
    ],

    // 8. Implante dental - Carmen Flores
    [
        'paciente_id' => 7, // Carmen Flores
        'cita_id' => 7, // Cita existente
        'tratamiento_id' => 8, // Implante
        'odontologo_id' => 1, // Dr. Carlos Limachi
        'asistente_id' => 5, // Laura Mamani
        'fecha' => Carbon::today()->subDays(19),
        'diagnostico' => 'Edentulismo unitario en zona estética anterior superior (incisivo central derecho, pieza 11) causado por traumatismo dentoalveolar hace 6 meses. Tomografía computarizada 3D (CBCT) muestra hueso alveolar residual con altura de 14mm y ancho de 7mm (adecuado). Tabla ósea vestibular de 2mm de espesor. Espacio mesiodistal de 8mm y vertical de 11mm (suficiente). Mucosa queratinizada de 4mm. Paciente ASA I (sin compromiso sistémico). Indicación de implante osteointegrado unitario.',
        'descripcion_tratamiento' => 'Cirugía de colocación de implante dental en una etapa. Premedicación antibiótica: amoxicilina 2g vía oral 1 hora previa. Enjuague con clorhexidina 0.12% por 1 minuto. Anestesia infiltrativa vestibular y palatina con articaína 4% con epinefrina 1:100,000. Incisión crestal lineal con bisturí #15. Elevación de colgajo mucoperióstico de espesor total. Fresado secuencial bajo irrigación salina estéril profusa (temperatura <47°C): broca piloto 2.0mm, 2.5mm, 3.0mm, 3.2mm, 3.5mm a 800 rpm. Colocación de implante de titanio grado 4 superficie SLA (moderadamente rugosa), conexión interna hexagonal, plataforma 3.75mm x 13mm de longitud con torque de inserción de 35 N/cm (estabilidad primaria excelente, clasificación IT >32). Colocación de tapa de cicatrización (healing abutment) de 4mm de altura y 5mm de diámetro. Sutura con 4 puntos simples (seda negra 4-0). Radiografía periapical digital de control post-colocación. Tiempo quirúrgico: 45 minutos.',
        'pieza_dental' => '11',
        'observaciones' => 'Implante bien posicionado tridimensionalmente (eje axial correcto, emergencia ideal, profundidad 3mm subcrest al). Estabilidad primaria óptima. Paciente tolera procedimiento satisfactoriamente sin complicaciones intraoperatorias. Prescripción: amoxicilina 500mg cada 8 horas por 7 días, ibuprofeno 400mg cada 8 horas por 5 días, omeprazol 20mg cada 24h por 5 días. Enjuagues con clorhexidina 0.12% cada 12h por 14 días (iniciar 24h post-cirugía). Indicaciones: dieta blanda y fría primeros 7 días, no fumar, no succionar, no escupir con fuerza. Control post-operatorio en 7 días para retiro de puntos y evaluación de cicatrización. Período de osteointegración: 3-4 meses. Posterior segunda fase quirúrgica menor (descubrimiento si es necesario) y carga protésica con corona de porcelana libre de metal. Pronóstico muy favorable (tasa éxito 95-98% en este sector).',
        'created_at' => now(),
        'updated_at' => now(),
    ],
];

// Insertar registros
DB::table('expedientes')->insert($expedientes);

echo "\n✅ Se insertaron " . count($expedientes) . " expedientes médicos exitosamente\n\n";
echo "📋 EXPEDIENTES CREADOS:\n";
echo str_repeat("=", 80) . "\n";

foreach ($expedientes as $index => $exp) {
    $paciente = DB::table('pacientes')->where('id', $exp['paciente_id'])->first();
    $tratamiento = DB::table('tratamientos')->where('id', $exp['tratamiento_id'])->first();

    echo ($index + 1) . ". " . $paciente->nombre_completo . "\n";
    echo "   Tratamiento: " . $tratamiento->nombre . "\n";
    echo "   Pieza dental: " . ($exp['pieza_dental'] ?? 'N/A') . "\n";
    echo "   Diagnóstico: " . substr($exp['diagnostico'], 0, 80) . "...\n";
    echo str_repeat("-", 80) . "\n";
}

echo "\n✨ Todos los expedientes médicos fueron insertados con éxito\n";
