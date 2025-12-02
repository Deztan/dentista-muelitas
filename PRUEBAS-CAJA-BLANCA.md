# 🧪 PRUEBAS DE CAJA BLANCA - SISTEMA DENTISTA MUELITAS

## Análisis de Complejidad Ciclomática

---

## 🎯 **MÉTODOS CANDIDATOS (V(G) > 4)**

### 🔢 **FÓRMULA: V(G) = 1 + número de nodos de decisión**

**Nodos de decisión:** if, while, for, case, catch, &&, ||

---

### 🎯 **MÉTODO 1: `facturas()` - ReportesController** ⭐ RECOMENDADO

**Archivo:** `app/Http/Controllers/ReportesController.php` (líneas 47-118)

#### **Análisis de Complejidad Ciclomática**

```php
public function facturas(Request $request)
{
    $desde = $request->input('desde');         // Base = 1
    $hasta = $request->input('hasta');
    $estado = $request->input('estado');
    $metodo = $request->input('metodo_pago');

    $query = Factura::with(['paciente', 'tratamiento'])
        ->orderByDesc('created_at');

    if ($desde) {                              // Nodo 1: +1 = 2
        try {
            $desde = Carbon::parse($desde)->startOfDay();
        } catch (\Exception $e) {              // Nodo 2: +1 = 3
            $desde = null;
        }
    }

    if ($hasta) {                              // Nodo 3: +1 = 4
        try {
            $hasta = Carbon::parse($hasta)->endOfDay();
        } catch (\Exception $e) {              // Nodo 4: +1 = 5
            $hasta = null;
        }
    }

    if ($desde) {                              // Nodo 5: +1 = 6
        $query->where('created_at', '>=', $desde);
    }
    if ($hasta) {                              // Nodo 6: +1 = 7
        $query->where('created_at', '<=', $hasta);
    }
    if ($estado) {                             // Nodo 7: +1 = 8
        $query->where('estado', $estado);
    }
    if ($metodo) {                             // Nodo 8: +1 = 9
        $query->where('metodo_pago', $metodo);
    }

    // Segunda sección para totales
    if ($desde) {                              // Nodo 9: +1 = 10
        $totalesQuery->where('created_at', '>=', $desde);
    }
    if ($hasta) {                              // Nodo 10: +1 = 11
        $totalesQuery->where('created_at', '<=', $hasta);
    }
    if ($estado) {                             // Nodo 11: +1 = 12
        $totalesQuery->where('estado', $estado);
    }
    if ($metodo) {                             // Nodo 12: +1 = 13
        $totalesQuery->where('metodo_pago', $metodo);
    }
}
```

**V(G) = 13** ✅ (12 nodos IF + 1 base = 13 caminos independientes)

---

### 🎯 **MÉTODO 2: `tratamientos()` - ReportesController**

**Archivo:** `app/Http/Controllers/ReportesController.php` (líneas 125-184)

#### **Análisis de Complejidad Ciclomática**

```php
public function tratamientos(Request $request)
{
    $desde = $request->input('desde');         // Base = 1
    $hasta = $request->input('hasta');

    if ($desde) {                              // Nodo 1: +1 = 2
        try {
            $desde = Carbon::parse($desde)->startOfDay();
        } catch (\Exception $e) {              // Nodo 2: +1 = 3
            $desde = null;
        }
    }

    if ($hasta) {                              // Nodo 3: +1 = 4
        try {
            $hasta = Carbon::parse($hasta)->endOfDay();
        } catch (\Exception $e) {              // Nodo 4: +1 = 5
            $hasta = null;
        }
    }

    $query = Expediente::with(['tratamiento', 'paciente', 'odontologo'])
        ->orderByDesc('fecha');

    if ($desde) {                              // Nodo 5: +1 = 6
        $query->where('fecha', '>=', $desde);
    }
    if ($hasta) {                              // Nodo 6: +1 = 7
        $query->where('fecha', '<=', $hasta);
    }

    $statsQuery = Expediente::query();
    if ($desde) {                              // Nodo 7: +1 = 8
        $statsQuery->where('fecha', '>=', $desde);
    }
    if ($hasta) {                              // Nodo 8: +1 = 9
        $statsQuery->where('fecha', '<=', $hasta);
    }
}
```

**V(G) = 9** ✅ (8 nodos IF/CATCH + 1 base = 9 caminos independientes)

---

### 🎯 **MÉTODO 3: `ingresos()` - ReportesController**

**Archivo:** `app/Http/Controllers/ReportesController.php` (líneas 191-269)

#### **Análisis de Complejidad Ciclomática**

```php
public function ingresos(Request $request)
{
    $desde = $request->input('desde');         // Base = 1
    $hasta = $request->input('hasta');

    if ($desde) {                              // Nodo 1: +1 = 2
        try {
            $desde = Carbon::parse($desde)->startOfDay();
        } catch (\Exception $e) {              // Nodo 2: +1 = 3
            $desde = null;
        }
    }

    if ($hasta) {                              // Nodo 3: +1 = 4
        try {
            $hasta = Carbon::parse($hasta)->endOfDay();
        } catch (\Exception $e) {              // Nodo 4: +1 = 5
            $hasta = null;
        }
    }

    $query = Factura::with(['paciente', 'tratamiento']);

    if ($desde) {                              // Nodo 5: +1 = 6
        $query->where('created_at', '>=', $desde);
    }
    if ($hasta) {                              // Nodo 6: +1 = 7
        $query->where('created_at', '<=', $hasta);
    }

    // Ingresos por mes
    if (!$desde && !$hasta) {                  // Nodo 7: +1 = 8 (condición compuesta && cuenta como 1 nodo)
        $hace6Meses = Carbon::now()->subMonths(6)->startOfMonth();
        $ingresosPorMes = Factura::select(...)->get();
    } else {
        $ingresosPorMes = collect();
    }
}
```

**V(G) = 8** ✅ (7 nodos de decisión + 1 base = 8 caminos independientes)

---

### 🎯 **MÉTODO 4: `pacientes()` - ReportesController**

**Archivo:** `app/Http/Controllers/ReportesController.php` (líneas 276-349)

#### **Análisis de Complejidad Ciclomática**

```php
public function pacientes(Request $request)
{
    $desde = $request->input('desde');         // Base = 1
    $hasta = $request->input('hasta');

    if ($desde) {                              // Nodo 1: +1 = 2
        try {
            $desde = Carbon::parse($desde)->startOfDay();
        } catch (\Exception $e) {              // Nodo 2: +1 = 3
            $desde = null;
        }
    }

    if ($hasta) {                              // Nodo 3: +1 = 4
        try {
            $hasta = Carbon::parse($hasta)->endOfDay();
        } catch (\Exception $e) {              // Nodo 4: +1 = 5
            $hasta = null;
        }
    }

    $queryPacientes = Cita::with('paciente')
        ->where('estado', '!=', 'cancelada');

    if ($desde) {                              // Nodo 5: +1 = 6
        $queryPacientes->where('fecha', '>=', $desde);
    }
    if ($hasta) {                              // Nodo 6: +1 = 7
        $queryPacientes->where('fecha', '<=', $hasta);
    }

    $pacientesNuevos = Paciente::query();
    if ($desde) {                              // Nodo 7: +1 = 8
        $pacientesNuevos->where('created_at', '>=', $desde);
    }
    if ($hasta) {                              // Nodo 8: +1 = 9
        $pacientesNuevos->where('created_at', '<=', $hasta);
    }

    $citasCompletadas = Cita::where('estado', 'completada');
    if ($desde) {                              // Nodo 9: +1 = 10
        $citasCompletadas->where('fecha', '>=', $desde);
    }
    if ($hasta) {                              // Nodo 10: +1 = 11
        $citasCompletadas->where('fecha', '<=', $hasta);
    }

    $citasCanceladas = Cita::whereIn('estado', ['cancelada', 'no_asistio']);
    if ($desde) {                              // Nodo 11: +1 = 12
        $citasCanceladas->where('fecha', '>=', $desde);
    }
    if ($hasta) {                              // Nodo 12: +1 = 13
        $citasCanceladas->where('fecha', '<=', $hasta);
    }
}
```

**V(G) = 13** ✅ (12 nodos IF/CATCH + 1 base = 13 caminos independientes)

---

## 📋 RESUMEN DE CAMINOS INDEPENDIENTES

### **MÉTODO RECOMENDADO: `facturas()` con V(G) = 13**

#### **Caminos Independientes Básicos (13 caminos mínimos):**

| #       | Camino                                                                                                        | Descripción                                         |
| ------- | ------------------------------------------------------------------------------------------------------------- | --------------------------------------------------- |
| **C1**  | 1→if($desde=true)→catch→if($hasta=true)→catch→8 IFs=true→FIN                                                  | Excepciones capturadas, todos los filtros aplicados |
| **C2**  | 1→if($desde=false)→if($hasta=false)→sin filtros→FIN                                                           | Sin ningún filtro (camino base)                     |
| **C3**  | 1→if($desde=true)→no-catch→if($hasta=false)→4 IFs primeros=true→FIN                                           | Desde válido, sin hasta, primeros 4 filtros         |
| **C4**  | 1→if($desde=false)→if($hasta=true)→no-catch→últimos 4 IFs=true→FIN                                            | Sin desde, hasta válido, últimos 4 filtros          |
| **C5**  | 1→if($desde=true)→catch→if($hasta=false)→if($estado=true)→FIN                                                 | Excepción en desde, solo estado aplicado            |
| **C6**  | 1→if($desde=false)→if($hasta=true)→catch→if($metodo=true)→FIN                                                 | Excepción en hasta, solo método aplicado            |
| **C7**  | 1→if($desde=true)→no-catch→if($hasta=true)→no-catch→if($estado=false)→if($metodo=false)→FIN                   | Ambas fechas válidas, sin estado ni método          |
| **C8**  | 1→if($desde=true)→catch→if($hasta=true)→catch→FIN                                                             | Ambas excepciones, sin filtros aplicados            |
| **C9**  | 1→if($desde=true)→no-catch→primeros 4 IFs=false→últimos 4 IFs=true→FIN                                        | Desde válido, solo filtros de totales               |
| **C10** | 1→if($hasta=true)→no-catch→if($estado=true)→if($metodo=false)→FIN                                             | Hasta válido con estado, sin método                 |
| **C11** | 1→if($desde=false)→if($hasta=false)→if($estado=true)→if($metodo=true)→FIN                                     | Sin fechas, con estado y método                     |
| **C12** | 1→if($desde=true)→no-catch→if($hasta=true)→no-catch→if($estado=true)→if($metodo=true)→8 filtros aplicados→FIN | Todos los filtros válidos y aplicados               |
| **C13** | 1→if($desde=true)→catch→if($hasta=false)→if($estado=false)→if($metodo=true)→solo método aplicado→FIN          | Excepción en desde, solo método                     |

---

## 🧪 CASOS DE PRUEBA DETALLADOS

### **PRUEBAS PARA `facturas()` - V(G) = 15**

#### **Entrada:**

```php
Request $request con parámetros:
- desde: string|null
- hasta: string|null
- estado: string|null ('pagada'|'pendiente'|'cancelada')
- metodo_pago: string|null ('efectivo'|'tarjeta'|'transferencia'|'qr')
```

#### **Tabla de Casos de Prueba:**

| #        | Entrada (Request)                                                           | Camino | Salida Esperada                                            | Estado      |
| -------- | --------------------------------------------------------------------------- | ------ | ---------------------------------------------------------- | ----------- |
| **CP1**  | desde='2024-01-01', hasta='2024-12-31', estado='pagada', metodo='efectivo'  | C1     | Facturas filtradas correctamente                           | ✅ Correcto |
| **CP2**  | desde='fecha_invalida', hasta='2024-12-31', estado=null, metodo=null        | C3     | Excepción capturada, desde=null, facturas sin filtro desde | ✅ Correcto |
| **CP3**  | desde='2024-01-01', hasta='fecha_invalida', estado=null, metodo=null        | C4     | Excepción capturada, hasta=null, filturas sin filtro hasta | ✅ Correcto |
| **CP4**  | desde=null, hasta=null, estado=null, metodo=null                            | C15    | Todas las facturas sin filtro                              | ✅ Correcto |
| **CP5**  | desde='2024-01-01', hasta=null, estado='pendiente', metodo=null             | C6     | Facturas >= 2024-01-01 con estado pendiente                | ✅ Correcto |
| **CP6**  | desde=null, hasta='2024-12-31', estado=null, metodo='tarjeta'               | C7     | Facturas <= 2024-12-31 con método tarjeta                  | ✅ Correcto |
| **CP7**  | desde='2024-01-01', hasta='2024-12-31', estado='cancelada', metodo=null     | C9     | Facturas en rango con estado cancelada                     | ✅ Correcto |
| **CP8**  | desde=null, hasta=null, estado='pagada', metodo='efectivo'                  | C10    | Facturas pagadas en efectivo (sin filtro fecha)            | ✅ Correcto |
| **CP9**  | desde='2024-06-01', hasta='2024-06-30', estado=null, metodo='transferencia' | C8     | Facturas de junio 2024 por transferencia                   | ✅ Correcto |
| **CP10** | desde='fecha_invalida', hasta='fecha_invalida', estado=null, metodo=null    | C14    | Ambas excepciones, desde=null, hasta=null                  | ⚠️ Error    |

---

## 📐 GRAFO DE FLUJO - Método `facturas()`

```
     [INICIO]
        │
        ▼
    ┌───────┐
    │   1   │ Obtener parámetros request
    └───┬───┘
        │
        ▼
    ┌───────┐
    │   2   │ if ($desde)? ────No────┐
    └───┬───┘                        │
       Sí                            │
        │                            │
        ▼                            │
    ┌───────┐                        │
    │   3   │ try parse desde        │
    └───┬───┘                        │
        │                            │
        ▼                            │
    ┌───────┐                        │
    │   4   │ catch Exception? ──Sí──┤
    └───┬───┘                        │
       No                            │
        │                            │
        ▼◄───────────────────────────┘
    ┌───────┐
    │   5   │ if ($hasta)? ────No────┐
    └───┬───┘                        │
       Sí                            │
        │                            │
        ▼                            │
    ┌───────┐                        │
    │   6   │ try parse hasta        │
    └───┬───┘                        │
        │                            │
        ▼                            │
    ┌───────┐                        │
    │   7   │ catch Exception? ──Sí──┤
    └───┬───┘                        │
       No                            │
        │                            │
        ▼◄───────────────────────────┘
    ┌───────┐
    │   8   │ if ($desde)? ────No────┐
    └───┬───┘                        │
       Sí                            │
        │                            │
        ▼                            │
  [Aplicar filtro]                  │
        │                            │
        ▼◄───────────────────────────┘
    ┌───────┐
    │   9   │ if ($hasta)? ────No────┐
    └───┬───┘                        │
       Sí                            │
        │                            │
        ▼                            │
  [Aplicar filtro]                  │
        │                            │
        ▼◄───────────────────────────┘
    ┌───────┐
    │  10   │ if ($estado)? ───No────┐
    └───┬───┘                        │
       Sí                            │
        │                            │
        ▼                            │
  [Aplicar filtro]                  │
        │                            │
        ▼◄───────────────────────────┘
    ┌───────┐
    │  11   │ if ($metodo)? ───No────┐
    └───┬───┘                        │
       Sí                            │
        │                            │
        ▼                            │
  [Aplicar filtro]                  │
        │                            │
        ▼◄───────────────────────────┘
    ┌───────┐
    │ 12-15 │ [Repetir lógica para totales]
    └───┬───┘
        │
        ▼
     [RETURN]
```

---

## 🔬 CÓDIGO DE PRUEBA UNITARIA (PHPUnit)

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\ReportesController;
use Illuminate\Http\Request;
use App\Models\Factura;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportesFacturasTest extends TestCase
{
    use RefreshDatabase;

    /**
     * CP1: Camino completo con todos los filtros válidos
     * V(G) Camino: 1→2→3→5→6→8→9→10→11→12→13→14→15→FIN
     */
    public function test_facturas_con_todos_los_filtros_validos()
    {
        // Arrange
        $request = Request::create('/reportes/facturas', 'GET', [
            'desde' => '2024-01-01',
            'hasta' => '2024-12-31',
            'estado' => 'pagada',
            'metodo_pago' => 'efectivo'
        ]);

        // Act
        $controller = new ReportesController();
        $response = $controller->facturas($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotNull($response);
    }

    /**
     * CP2: Fecha desde inválida (excepción capturada)
     * V(G) Camino: 1→2→3(exception)→4→5→8→9→10→11→FIN
     */
    public function test_facturas_con_fecha_desde_invalida()
    {
        // Arrange
        $request = Request::create('/reportes/facturas', 'GET', [
            'desde' => 'fecha_invalida',
            'hasta' => '2024-12-31',
            'estado' => null,
            'metodo_pago' => null
        ]);

        // Act
        $controller = new ReportesController();
        $response = $controller->facturas($request);

        // Assert (debe manejar la excepción)
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * CP3: Fecha hasta inválida (excepción capturada)
     * V(G) Camino: 1→2→5→6(exception)→7→8→9→FIN
     */
    public function test_facturas_con_fecha_hasta_invalida()
    {
        // Arrange
        $request = Request::create('/reportes/facturas', 'GET', [
            'desde' => '2024-01-01',
            'hasta' => 'fecha_invalida',
            'estado' => null,
            'metodo_pago' => null
        ]);

        // Act
        $controller = new ReportesController();
        $response = $controller->facturas($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * CP4: Sin ningún filtro (camino base)
     * V(G) Camino: 1→FIN
     */
    public function test_facturas_sin_filtros()
    {
        // Arrange
        $request = Request::create('/reportes/facturas', 'GET');

        // Act
        $controller = new ReportesController();
        $response = $controller->facturas($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * CP5: Solo fecha desde y estado
     * V(G) Camino: 1→2→5→8→10→FIN
     */
    public function test_facturas_solo_desde_y_estado()
    {
        // Arrange
        $request = Request::create('/reportes/facturas', 'GET', [
            'desde' => '2024-01-01',
            'estado' => 'pendiente'
        ]);

        // Act
        $controller = new ReportesController();
        $response = $controller->facturas($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * CP6: Solo fecha hasta y método
     * V(G) Camino: 1→5→9→11→FIN
     */
    public function test_facturas_solo_hasta_y_metodo()
    {
        // Arrange
        $request = Request::create('/reportes/facturas', 'GET', [
            'hasta' => '2024-12-31',
            'metodo_pago' => 'tarjeta'
        ]);

        // Act
        $controller = new ReportesController();
        $response = $controller->facturas($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * CP7: Rango de fechas con estado cancelada
     * V(G) Camino: 1→2→5→8→9→10→FIN
     */
    public function test_facturas_rango_fechas_estado_cancelada()
    {
        // Arrange
        $request = Request::create('/reportes/facturas', 'GET', [
            'desde' => '2024-01-01',
            'hasta' => '2024-12-31',
            'estado' => 'cancelada'
        ]);

        // Act
        $controller = new ReportesController();
        $response = $controller->facturas($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * CP8: Solo estado y método (sin fechas)
     * V(G) Camino: 1→10→11→FIN
     */
    public function test_facturas_solo_estado_y_metodo()
    {
        // Arrange
        $request = Request::create('/reportes/facturas', 'GET', [
            'estado' => 'pagada',
            'metodo_pago' => 'efectivo'
        ]);

        // Act
        $controller = new ReportesController();
        $response = $controller->facturas($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * CP9: Rango específico con método transferencia
     * V(G) Camino: 1→2→5→8→9→11→FIN
     */
    public function test_facturas_rango_con_transferencia()
    {
        // Arrange
        $request = Request::create('/reportes/facturas', 'GET', [
            'desde' => '2024-06-01',
            'hasta' => '2024-06-30',
            'metodo_pago' => 'transferencia'
        ]);

        // Act
        $controller = new ReportesController();
        $response = $controller->facturas($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * CP10: Ambas fechas inválidas (doble excepción)
     * V(G) Camino: 1→2→3(catch)→4→5→6(catch)→7→FIN
     */
    public function test_facturas_ambas_fechas_invalidas()
    {
        // Arrange
        $request = Request::create('/reportes/facturas', 'GET', [
            'desde' => 'fecha_invalida_1',
            'hasta' => 'fecha_invalida_2'
        ]);

        // Act
        $controller = new ReportesController();
        $response = $controller->facturas($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
    }
}
```

---

## 📊 FÓRMULA DE COMPLEJIDAD CICLOMÁTICA

### **Método de McCabe:**

```
V(G) = E - N + 2P
```

Donde:

-   **E** = Número de aristas (conexiones)
-   **N** = Número de nodos (bloques de código)
-   **P** = Número de componentes conectados (generalmente 1)

### **Método simplificado (conteo de nodos de decisión):**

```
V(G) = 1 + número de nodos (if, while, for, case, &&, ||, catch)
```

Para `facturas()`:

-   **Base:** 1
-   **Nodos de decisión:**
    -   if ($desde) → +1
    -   catch en try $desde → +1
    -   if ($hasta) → +1
    -   catch en try $hasta → +1
    -   if ($desde) query → +1
    -   if ($hasta) query → +1
    -   if ($estado) query → +1
    -   if ($metodo) query → +1
    -   if ($desde) totales → +1
    -   if ($hasta) totales → +1
    -   if ($estado) totales → +1
    -   if ($metodo) totales → +1

**Total:** 1 + 12 = **V(G) = 13**

---

## ✅ RECOMENDACIÓN FINAL

### **MÉTODO MÁS ADECUADO:** `facturas()` en ReportesController

**Razones:**

1. ✅ **V(G) = 13** (12 nodos + 1 base) - Complejidad alta > 4
2. ✅ **13 caminos independientes** (suficientes para análisis completo)
3. ✅ **12 nodos de decisión** (if + catch)
4. ✅ **Lógica de negocio crítica** (filtrado de reportes financieros)
5. ✅ **Fácil de probar** (Request mock simple)
6. ✅ **Manejo de excepciones** (validación de fechas)
7. ✅ **Múltiples filtros combinables** (desde, hasta, estado, método)

### **Alternativas:**

-   `pacientes()` con **V(G) = 13** (12 nodos IF/CATCH + 1)
-   `tratamientos()` con **V(G) = 9** (8 nodos + 1)
-   `ingresos()` con **V(G) = 8** (7 nodos + 1)

---

**Fecha:** Diciembre 2025  
**Estado:** ✅ Análisis completo para pruebas de caja blanca
