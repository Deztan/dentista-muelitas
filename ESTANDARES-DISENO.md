# MANUAL DE ESTÁNDARES DE DISEÑO

## Sistema Dentista Muelitas

---

## 📋 ESTÁNDAR PARA EL DISEÑO DE INTERFAZ PRINCIPAL

### Estructura del Layout

```
┌─────────────────────────────────────────────────────────┐
│                      CABECERA                            │
│  Logo + Título del Sistema    Usuario + Perfil          │
└─────────────────────────────────────────────────────────┘
┌──────────┬──────────────────────────────────────────────┐
│          │                                               │
│   MENÚ   │            CONTENIDO / BODY                   │
│  SIDEBAR │                                               │
│          │   - Breadcrumbs                               │
│          │   - Alertas (parte superior)                  │
│          │   - Contenido principal                       │
│          │                                               │
└──────────┴──────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────┐
│                    FOOTER / PIE DE PÁGINA                │
│  Copyright © Sistema   |   Versión   |   Usuario   |    │
└─────────────────────────────────────────────────────────┘
```

### Componentes:

-   **Cabecera**: Fija en la parte superior, contiene logo e información del usuario
-   **Menú Lateral (Sidebar)**: Fijo a la izquierda, ocupa toda la altura
-   **Contenido**: Área principal para el contenido dinámico
-   **Footer**: Fijo en la parte inferior, información del sistema

---

## 📝 ESTÁNDAR PARA FORMULARIOS

### Estructura:

```
┌─────────────────────────────────────────────────────────┐
│  ENCABEZADO (Alineado a la Izquierda)                   │
│  📄 Título del Formulario                                │
│  Descripción breve                                        │
└─────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────┐
│                    CONTENIDO                             │
│                                                          │
│  Label 1:  [___________________]                         │
│  Label 2:  [___________________]                         │
│  Label 3:  [___________________]                         │
│  ...                                                     │
│                                                          │
└─────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────┐
│                              [🔙 Cancelar] [💾 Guardar] │ ← Alineados a la Derecha
└─────────────────────────────────────────────────────────┘
```

### Reglas:

1. **Encabezado**: Título e ícono alineados a la izquierda
2. **Contenido**: Labels arriba de los campos de texto
3. **Botones**: Alineados a la derecha con iconos a la izquierda

**Ejemplo implementado**: `resources/views/pacientes/create.blade.php`

---

## 📊 ESTÁNDAR PARA REPORTES

### Estructura:

```
┌─────────────────────────────────────────────────────────┐
│  ENCABEZADO                                              │
│  📋 Título del Reporte              [➕ Nueva Acción]   │
│  Descripción del reporte                                 │
└─────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────┐
│              CONTENIDO / REPORTE EN TABLAS               │
│                                                          │
│  ┌──────┬──────┬──────┬──────┬──────────┐              │
│  │ Col1 │ Col2 │ Col3 │ Col4 │ Acciones │              │
│  ├──────┼──────┼──────┼──────┼──────────┤              │
│  │ Data │ Data │ Data │ Data │  👁 ✏ 🗑 │              │
│  │ Data │ Data │ Data │ Data │  👁 ✏ 🗑 │              │
│  └──────┴──────┴──────┴──────┴──────────┘              │
│                                                          │
└─────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────┐
│  Mostrando 1-15 de 100        [◀ 1 2 3 4 5 ▶]         │ ← PAGINACIÓN
└─────────────────────────────────────────────────────────┘
```

### Reglas:

1. **Encabezado**: Título con ícono + botón de acción principal
2. **Tabla**: Headers con fondo gris, filas con hover
3. **Paginación**: En la parte inferior con contador de registros

**Ejemplo implementado**: `resources/views/citas/index.blade.php`

---

## 🎨 ESTÁNDAR DE COMPONENTES

### Paleta de Colores de Botones:

| Tipo      | Color     | Uso                                   | Ejemplo      |
| --------- | --------- | ------------------------------------- | ------------ |
| Primary   | `#0d6efd` | Acciones principales (Guardar, Crear) | 💾 Guardar   |
| Success   | `#198754` | Confirmaciones, éxito                 | ✅ Confirmar |
| Danger    | `#dc3545` | Eliminar, cancelar operaciones        | 🗑 Eliminar   |
| Warning   | `#ffc107` | Editar, modificar                     | ✏ Editar     |
| Info      | `#0dcaf0` | Ver detalles                          | 👁 Ver        |
| Secondary | `#6c757d` | Volver, cancelar                      | 🔙 Cancelar  |

### Estructura de Botones:

```html
<!-- CORRECTO: Icono a la izquierda -->
<button class="btn btn-primary"><i class="bi bi-save me-1"></i> Guardar</button>

<!-- INCORRECTO: Icono sin margen -->
<button class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
```

---

## ⚠️ ESTÁNDAR DE ALERTAS

### Estructura:

Las alertas deben desplegarse en la **parte superior** de la interfaz con:

-   Icono grande (1.5rem) a la izquierda
-   Mensaje claro
-   Botón de cerrar (X)

### Tipos de Alertas:

```html
<!-- ÉXITO -->
<div class="alert alert-success">
    <i class="bi bi-check-circle-fill me-3"></i>
    <strong>¡Éxito!</strong> Operación completada correctamente
</div>

<!-- ERROR -->
<div class="alert alert-danger">
    <i class="bi bi-exclamation-triangle-fill me-3"></i>
    <strong>¡Error!</strong> No se pudo completar la operación
</div>

<!-- ADVERTENCIA -->
<div class="alert alert-warning">
    <i class="bi bi-exclamation-circle-fill me-3"></i>
    <strong>Advertencia:</strong> Revisa la información ingresada
</div>

<!-- INFORMACIÓN -->
<div class="alert alert-info">
    <i class="bi bi-info-circle-fill me-3"></i>
    <strong>Información:</strong> Datos importantes para ti
</div>
```

---

## 📂 ARCHIVOS IMPLEMENTADOS

### Estilo Principal:

-   `public/css/estandares.css` - Estilos según manual de calidad

### Layout Base:

-   `resources/views/layouts/app.blade.php` - Layout maestro con estándares

### Ejemplos de Formularios:

-   `resources/views/pacientes/create.blade.php` - Formulario estandarizado
-   `resources/views/pacientes/edit.blade.php` - Formulario de edición

### Ejemplos de Reportes:

-   `resources/views/citas/index.blade.php` - Reporte con tabla y paginación
-   `resources/views/pacientes/index.blade.php` - Listado de pacientes

---

## ✅ CHECKLIST DE CUMPLIMIENTO

### Interfaz Principal ✅

-   [x] Cabecera fija en parte superior
-   [x] Sidebar fijo lateral izquierdo
-   [x] Contenido principal con margen correcto
-   [x] Footer fijo en parte inferior
-   [x] Footer con información profesional (no archivos PHP)

### Formularios ✅

-   [x] Encabezado alineado a la izquierda
-   [x] Labels sobre campos de texto
-   [x] Botones alineados a la derecha
-   [x] Iconos en botones posicionados a la izquierda

### Reportes ✅

-   [x] Encabezado con título y botón de acción
-   [x] Tabla con headers estilizados
-   [x] Paginación en parte inferior
-   [x] Contador de registros

### Componentes ✅

-   [x] Botones con paleta de colores definida
-   [x] Botones con iconos a la izquierda
-   [x] Alertas en parte superior
-   [x] Alertas con iconos grandes

---

## 🎯 APLICACIÓN EN NUEVOS MÓDULOS

Al crear nuevos módulos, seguir estos pasos:

1. **Formularios**: Usar `pacientes/create.blade.php` como plantilla
2. **Listados**: Usar `citas/index.blade.php` como referencia
3. **Botones**: Siempre agregar clase `me-1` después del ícono
4. **Alertas**: Usar estructura con iconos grandes (1.5rem)
5. **CSS**: Incluir `estandares.css` en el layout

---

## 📞 SOPORTE

Para dudas sobre estándares de diseño:

-   Revisar este documento
-   Consultar archivos de ejemplo
-   Verificar `public/css/estandares.css`

---

**Versión**: 1.0.0  
**Fecha**: Diciembre 2025  
**Sistema**: Dentista Muelitas
