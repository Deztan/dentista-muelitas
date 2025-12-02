# 🧾 SISTEMA DE IMPRESIÓN DE FACTURAS

## Clínica Dental Muelitas

---

## 📋 CARACTERÍSTICAS IMPLEMENTADAS

### ✅ Diseño Profesional

-   **Logo del diente** en esquina superior izquierda con gradiente azul
-   **Diseño moderno** inspirado en facturas profesionales
-   **Tipografía Google Fonts** (Inter) para mejor legibilidad
-   **Paleta de colores** corporativa con gradientes

### ✅ Información Completa

1. **Encabezado:**

    - Logo de la clínica (emoji 🦷 personalizable)
    - Nombre de la clínica
    - Datos del doctor/administrador
    - NIF/NIT
    - Dirección completa
    - Teléfono y email de contacto

2. **Datos de la Factura:**

    - Número de factura destacado
    - Fecha de emisión
    - Estado (Pagada/Pendiente/Cancelada) con badges de color
    - Método de pago

3. **Información del Cliente:**

    - Nombre completo del paciente
    - DNI/CI
    - Dirección
    - Teléfono y email

4. **Detalles del Servicio:**

    - Tabla con código de tratamiento
    - Descripción completa
    - Cantidad
    - Precio unitario
    - Total

5. **Cálculo de Totales:**

    - Subtotal
    - IVA (21%)
    - Total a pagar destacado en azul

6. **Forma de Pago:**

    - Método seleccionado
    - Número de cuenta bancaria (IBAN) para transferencias

7. **Observaciones:**
    - Nota con términos de pago
    - Observaciones personalizadas

---

## 🎨 ELEMENTOS DE DISEÑO

### Logo y Marca

```html
<div class="logo-container">
    <i class="logo-icon">🦷</i>
</div>
```

**Características:**

-   Tamaño: 70x70px
-   Gradiente azul (#4fc3f7 → #0288d1)
-   Border-radius: 12px
-   Box-shadow con efecto de profundidad
-   Emoji personalizable (puedes cambiarlo por imagen)

### Paleta de Colores

```css
Primary: #0288d1 (Azul corporativo)
Light: #4fc3f7 (Azul claro)
Success: #4caf50 (Verde)
Warning: #ff9800 (Naranja)
Danger: #f44336 (Rojo)
Text: #1a1a1a (Negro texto)
Gray: #666 (Gris medio)
```

### Tipografía

-   **Fuente principal:** Inter (Google Fonts)
-   **Títulos:** 700 (Bold)
-   **Subtítulos:** 600 (Semi-bold)
-   **Texto normal:** 400 (Regular)
-   **Tamaños:**
    -   Título FACTURA: 20px
    -   Nombre clínica: 24px
    -   Texto tabla: 11.5px
    -   Total final: 16px

---

## 📱 RESPONSIVE & IMPRESIÓN

### Media Query para Impresión

```css
@media print {
    body {
        background: white;
    }
    .print-page {
        margin: 0;
        padding: 20px;
        box-shadow: none;
    }
}
```

### Tamaño de Página

-   **Formato:** A4 (210mm x 297mm)
-   **Orientación:** Portrait (vertical)
-   **Márgenes:** 40px 50px

---

## 🔧 CÓMO USAR

### 1. Desde el Listado de Facturas

En `facturas/index.blade.php`:

```html
<a
    href="{{ route('facturas.print', $factura->id) }}"
    class="btn btn-primary"
    target="_blank"
>
    <i class="bi bi-printer"></i>
</a>
```

### 2. Desde el Detalle de Factura

En `facturas/show.blade.php`:

```html
<a
    href="{{ route('facturas.print', $factura->id) }}"
    class="btn btn-primary"
    target="_blank"
>
    <i class="bi bi-printer me-1"></i> Imprimir Factura
</a>
```

### 3. Ruta del Controlador

```php
Route::get('/facturas/{factura}/print', [FacturaController::class, 'print'])
    ->name('facturas.print');
```

---

## 🎯 PERSONALIZACIÓN

### Cambiar el Logo

Reemplaza el emoji 🦷 por una imagen:

**Opción 1: Emoji personalizado**

```html
<i class="logo-icon">🦷</i>
<!-- Cambia por 😁 🏥 ⚕️ -->
```

**Opción 2: Imagen real**

```html
<img
    src="{{ asset('images/logo-diente.png') }}"
    alt="Logo Dentista Muelitas"
    style="width: 50px; height: 50px;"
/>
```

### Cambiar Datos de la Clínica

En `print.blade.php` línea ~250:

```html
<h1>DENTISTA MUELITAS</h1>
<p><strong>Dr. Juan García</strong> | NIF: 12345678A</p>
<p>Avenida de la Salud, 123 | 28000 Madrid</p>
<p>📞 910.000.000 | ✉️ correo@clinicadental.es</p>
```

### Cambiar Colores

En el `<style>` del archivo `print.blade.php`:

```css
/* Cambiar color principal */
background: linear-gradient(135deg, #TU_COLOR_1 0%, #TU_COLOR_2 100%);

/* Ejemplos: */
/* Verde: #4caf50 → #388e3c */
/* Morado: #9c27b0 → #7b1fa2 */
/* Rojo: #f44336 → #d32f2f */
```

### Agregar Marca de Agua

```css
.print-page::before {
    content: "COPIA NO VÁLIDA";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-45deg);
    font-size: 80px;
    color: rgba(0, 0, 0, 0.05);
    font-weight: bold;
    z-index: -1;
}
```

---

## 📊 ESTRUCTURA DE DATOS

### Modelo Factura

```php
$factura->id                    // ID único
$factura->numero_factura        // Nº de factura
$factura->fecha_emision         // Fecha de emisión
$factura->monto_total           // Monto total
$factura->monto_pagado          // Monto pagado
$factura->saldo_pendiente       // Saldo pendiente
$factura->estado                // pagada/pendiente/cancelada
$factura->metodo_pago           // efectivo/tarjeta/transferencia
$factura->observaciones         // Notas adicionales
```

### Relaciones

```php
$factura->paciente->nombre_completo
$factura->paciente->telefono
$factura->paciente->email
$factura->tratamiento->nombre
$factura->tratamiento->descripcion
```

---

## 🖨️ IMPRESIÓN

### Imprimir desde el Navegador

1. Click en botón "Imprimir Factura"
2. Se abre en nueva pestaña
3. Ctrl + P (Windows) o Cmd + P (Mac)
4. Seleccionar impresora
5. Ajustar márgenes si es necesario
6. Imprimir

### Guardar como PDF

1. Click en botón "Imprimir Factura"
2. Ctrl + P
3. Seleccionar "Guardar como PDF"
4. Elegir ubicación
5. Guardar

### Auto-imprimir (Opcional)

Para que se abra automáticamente el diálogo de impresión:

```html
<script>
    window.onload = function () {
        window.print();
    };
</script>
```

---

## 💡 MEJORAS FUTURAS

### Funcionalidades Adicionales

-   [ ] Exportar a PDF con librería (DomPDF/mPDF)
-   [ ] Enviar factura por email automáticamente
-   [ ] Código QR para pago digital
-   [ ] Código de barras para el número de factura
-   [ ] Firma digital del doctor
-   [ ] Múltiples idiomas
-   [ ] Plantillas personalizables por usuario
-   [ ] Histórico de versiones de factura
-   [ ] Sello de "PAGADA" con imagen
-   [ ] Logo personalizado desde base de datos

### Integraciones

-   [ ] WhatsApp Business API (envío automático)
-   [ ] Pasarela de pago online
-   [ ] Sistema de facturación electrónica
-   [ ] Integración con contabilidad

---

## 📁 ARCHIVOS RELACIONADOS

```
resources/
  └── views/
      └── facturas/
          ├── index.blade.php      # Listado con botón imprimir
          ├── show.blade.php       # Detalle con botón imprimir
          └── print.blade.php      # ⭐ Vista de impresión

app/
  └── Http/
      └── Controllers/
          └── FacturaController.php  # Método print()

routes/
  └── web.php                      # Ruta facturas.print
```

---

## 🎨 EJEMPLO VISUAL

```
╔══════════════════════════════════════════════════════════╗
║  [🦷]  DENTISTA MUELITAS           FACTURA               ║
║         Dr. Juan García            Nº: FAC-001          ║
║         NIF: 12345678A             24/04/2024           ║
║                                    Estado: PAGADA       ║
╠══════════════════════════════════════════════════════════╣
║  📋 Datos del Paciente          📞 Info de Contacto    ║
║  Nombre: María López             Teléfono: 0364.2288   ║
║  DNI: 1234567                    Email: maria@...      ║
╠══════════════════════════════════════════════════════════╣
║  Código | Descripción           | Cant | P.U.  | Total ║
║  LIM001 | Limpieza dental       |  1   | 90.00 | 90.00║
║  EMP002 | Empaste               |  3   | 80.00 | 240.00║
║  RAD003 | Radiografía           |  1   | 30.00 | 30.00║
╠══════════════════════════════════════════════════════════╣
║                                   Subtotal:   250.00 € ║
║                                   IVA (21%):   92.50 € ║
║                                   ─────────────────────  ║
║                                   TOTAL:      302.50 € ║
╠══════════════════════════════════════════════════════════╣
║  💳 Forma de pago: Transferencia bancaria               ║
║  ES00 0000 0000 0000 0000 0000                          ║
╠══════════════════════════════════════════════════════════╣
║  📝 Pago neto a 30 días. Gracias por su confianza.     ║
╠══════════════════════════════════════════════════════════╣
║         The Cherry Health.                              ║
╚══════════════════════════════════════════════════════════╝
```

---

**Fecha de Implementación:** Enero 2025  
**Versión:** 1.0  
**Estado:** ✅ COMPLETO Y FUNCIONAL
