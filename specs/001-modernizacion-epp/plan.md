# Implementation Plan: Modernización integral de la app EPP

**Branch**: `001-modernizacion-epp` | **Date**: 2026-10-15 | **Spec**: [spec.md](spec.md)

**Input**: Feature specification from `specs/001-modernizacion-epp/spec.md`

## Summary

Migrar la app EPP (Laravel 9 / PHP ^8.0 / Livewire 2 / AdminLTE 3.8) a PHP 8.2 + Laravel 12,
rediseñar la interfaz completa con un sistema de diseño nuevo mobile/touch-first, agregar el CRUD
de usuarios del sistema (hoy inexistente), agregar identificación de colaborador por QR de carné
y búsqueda manual por cédula en tablet (sin intentar RFID por NFC, incompatible por hardware),
habilitar firma manuscrita táctil equivalente a la actual firma Wacom, y agregar borrado de
colaboradores bloqueado cuando existan `EntregaEpp` asociadas. Todo se ejecuta en fases
independientes y commiteadas por separado, preservando los flujos de negocio ya en producción
(entregas, firmas, generación de actas PDF vía FPDI/FPDF).

## Technical Context

**Language/Version**: PHP 8.2 (ya instalado en el entorno Laragon; composer.json hoy restringe a
^8.0.2 y debe actualizarse)

**Primary Dependencies**:
- Laravel 9 → **Laravel 12** (`^12.69`) — corregido durante la implementación: Laravel 10/11 ya
  están fuera de soporte de seguridad a la fecha real de ejecución (2026-10-15), y Laravel 13
  exige PHP 8.3. Laravel 12.69+ es la única versión con parches de seguridad vigentes que sigue
  soportando PHP 8.2. Ver research.md, sección "Laravel 10 vs 12 vs 13".
- Livewire 2 → **Livewire 3** (Livewire 2 está sin mantenimiento activo y no es el objetivo
  recomendado para Laravel 12; el salto de versión de Livewire se hace en la misma fase que el
  framework para no duplicar trabajo de adaptación de componentes).
- AdminLTE 3.8 + Bootstrap 5 (jeroennoten/laravel-adminlte) → se **retira** como parte del
  rediseño visual completo; se sustituye por **Tailwind CSS** + componentes propios, manteniendo
  Laravel Mix o migrando a Vite (decisión en Fase 1, ver Research).
- `jquery.signature.js` (firma Wacom/mouse) → se sustituye por **signature_pad.js**, librería
  basada en canvas con mejor soporte de eventos táctiles (Pointer Events), usada tanto en PC
  (Wacom) como en tablet (dedo).
- Lectura de QR en tablet: librería JS de escaneo por cámara (p. ej. `html5-qrcode` o `jsQR`),
  evaluada en Fase 0 por tamaño, mantenimiento y soporte de Chrome en Android.
- `setasign/fpdi` + `setasign/fpdf`: se mantienen; se valida compatibilidad con PHP 8.2 y Laravel
  10 (ambos paquetes son PHP puro y no dependen de la versión de Laravel).

**Storage**: MySQL/MariaDB (vía Laragon), sin cambios de motor. Nuevas migraciones para rol de
usuario del sistema; sin cambios estructurales a `empleados` ni `entrega_epps` salvo los
estrictamente necesarios para el borrado seguro (ninguno: la regla se aplica en lógica de
aplicación, no en esquema).

**Testing**: el proyecto no tiene suite de pruebas automatizadas relevante hoy (phpunit.xml existe
pero sin tests sustanciales). Se añaden **Feature tests de Laravel/PHPUnit** para: CRUD de
usuarios, regla de borrado bloqueado de colaboradores, y parser del payload QR (unitario, sin
necesidad de navegador). La verificación de cámara/táctil/Wacom en dispositivo real queda como
checklist manual (no automatizable razonablemente en esta fase).

**Target Platform**: navegador de escritorio (Windows, PC de oficina) y Chrome en Android sobre
Samsung Galaxy Tab Active5 5G. Sin app nativa ni empaquetado adicional.

**Project Type**: aplicación web monolítica Laravel + Livewire (server-rendered con islas
interactivas), sin separación backend/frontend.

**Performance Goals**: sin metas de alto volumen (uso interno, decenas de usuarios concurrentes
como máximo); prioridad en tiempo de respuesta percibido en tablet sobre red Wi-Fi/5G corporativa,
no en throughput.

**Constraints**: debe seguir funcionando sin romper los flujos de negocio existentes durante toda
la migración (Principio IV de la constitución); no se puede depender de hardware NFC para RFID
125kHz (Principio II); todo delete de `Empleado` debe respetar el Principio III.

**Scale/Scope**: ~4 módulos existentes (Colaborador, Inventario, Entrega, Reporte) a rediseñar +
2 módulos nuevos (Usuarios del sistema, Identificación QR en tablet) + 1 regla transversal
(borrado seguro).

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

| Principio | Chequeo | Estado |
|---|---|---|
| I. Dual-Device Parity | Cada pantalla crítica (identificar colaborador, registrar entrega, firmar) tiene ruta táctil completa en el plan (QR cámara, búsqueda por cédula, signature_pad.js) | PASA |
| II. No RFID-over-NFC | El plan explícitamente excluye lectura RFID en tablet (FR-022); QR + cédula manual son los únicos mecanismos en tablet | PASA |
| III. Audit Integrity | Borrado de `Empleado` se implementa como chequeo de `entregasEpps()->exists()` antes de permitir destroy; bloqueo con mensaje, no soft-delete silencioso | PASA |
| IV. Incremental Migration | Fases independientes definidas abajo (Project Structure) con commit propio cada una | PASA |
| V. QR Payload Untrusted | FR-023 exige rechazo de payload fuera de formato; research.md debe fijar el proceso de validación con muestras reales antes de codificar offsets | PENDIENTE DE RESEARCH (no bloquea plan, se resuelve en Fase 0) |
| VI. Touch-First Redesign | AdminLTE se retira por un sistema Tailwind nuevo; FR-050/051 cubren paridad funcional y usabilidad táctil | PASA |

No hay violaciones que requieran justificación en Complexity Tracking.

## Project Structure

### Documentation (this feature)

```text
specs/001-modernizacion-epp/
├── plan.md              # Este archivo
├── research.md          # Fase 0: decisiones técnicas (Laravel 12, libs QR/firma, Tailwind vs Vite)
├── data-model.md         # Fase 1: entidades nuevas/modificadas (User.role, nada en Empleado/EntregaEpp)
├── quickstart.md          # Fase 1: cómo levantar y probar el entorno tras cada fase
├── contracts/              # Fase 1: rutas/acciones nuevas (usuarios, delete colaborador, qr scan)
└── tasks.md                # Fase 2 (/speckit-tasks) — NO se crea en /speckit-plan
```

### Source Code (repository root)

Aplicación monolítica Laravel existente — se extiende la estructura actual, no se crea un proyecto
nuevo:

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── UserController.php            # NUEVO: CRUD de usuarios del sistema (o Livewire equivalente)
│   └── Livewire/
│       ├── Usuario/                      # NUEVO: Index / NuevoUsuario / EditarUsuario (sistema)
│       │   ├── Index.php
│       │   ├── NuevoUsuario.php
│       │   └── EditarUsuario.php
│       ├── Colaborador/
│       │   ├── Index.php                 # MODIFICADO: agrega acción "eliminar" con guard
│       │   └── ...
│       └── Entrega/
│           └── ...                       # MODIFICADO: soporte de flujo de identificación QR en tablet
├── Models/
│   ├── User.php                          # MODIFICADO: + campo role
│   └── Empleado.php                      # MODIFICADO: + método puedeEliminarse(): bool
└── Services/
    └── CarneQrParser.php                 # NUEVO: parser de ancho fijo del payload QR, con validación

resources/
├── views/
│   ├── usuario/                          # NUEVO
│   └── livewire/usuario/                 # NUEVO
└── js/
    ├── qr-scanner.js                     # NUEVO: integración librería de escaneo QR
    └── signature-pad.js                  # MODIFICADO: migración de jquery.signature.js

tests/
└── Feature/
    ├── UsuarioCrudTest.php               # NUEVO
    ├── ColaboradorDeleteTest.php         # NUEVO
    └── CarneQrParserTest.php             # NUEVO (unit, sin HTTP)
```

**Structure Decision**: se mantiene la convención MVC + Livewire ya usada en el proyecto (un
módulo = carpeta en `Http/Livewire` + vistas en `resources/views/livewire`), para minimizar el
riesgo de la migración y no introducir un segundo patrón arquitectónico a la vez que se cambia de
versión de framework y de sistema de diseño.

## Fases de ejecución (resumen; detalle en tasks.md)

1. **Fase A — Upgrade de plataforma**: PHP 8.2 + Laravel 12 + Livewire 3, resolviendo breaking
   changes de dependencias (`laravel/ui`, `laravel/sanctum`, `jeroennoten/laravel-adminlte` se
   retira aquí mismo o en Fase B). Checklist de humo sobre los flujos existentes antes de
   continuar.
2. **Fase B — Rediseño visual**: nuevo sistema de diseño (Tailwind) aplicado pantalla por pantalla
   (Colaborador → Inventario → Entrega → Reporte), con paridad funcional verificada en cada una.
3. **Fase C — CRUD de usuarios del sistema**: modelo/rol, Livewire Index/Nuevo/Editar, política de
   autorización (solo Administrador), protección contra autoeliminación y contra eliminar al
   último administrador.
4. **Fase D — Identificación en tablet (QR + cédula)**: `CarneQrParser` validado con muestras
   reales, integración de cámara en el flujo de Entrega, fallback a búsqueda manual.
5. **Fase E — Firma táctil**: migración a `signature_pad.js`, verificación en Wacom (PC) y dedo
   (tablet) antes de retirar `jquery.signature.js`.
6. **Fase F — Borrado seguro de colaboradores**: guard en `Empleado`, UI de confirmación, mensaje
   de bloqueo cuando hay entregas asociadas.

Cada fase se corresponde con un bloque de tareas en `tasks.md` y termina con commit propio,
siguiendo el Principio IV de la constitución.

## Complexity Tracking

Sin violaciones de la constitución que requieran justificación.
