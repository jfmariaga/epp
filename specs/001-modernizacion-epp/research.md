# Phase 0 Research: Modernización integral de la app EPP

## Laravel 10 vs 12 vs 13 — CORREGIDO durante implementación (2026-10-15)

**Decisión final**: **Laravel 12** (`^12.69`), no Laravel 10 como se planteó originalmente.

**Por qué cambió**: al ejecutar `composer update` se descubrió que, a la fecha de hoy
(2026-10-15), **Laravel 10 y 11 ya salieron de su ventana de soporte de seguridad** — el propio
`composer audit`/resolver de Composer 2.9 bloqueó la instalación de *cualquier* versión 10.x
(hasta la última, 10.50.3) por quedar afectada por varios CVE sin parche retroactivo. Laravel 13
(la major actual) exige PHP `^8.3`, lo que rompería el requisito explícito del usuario de quedarse
en PHP 8.2. **Laravel 12.69.0+ sí recibió los parches de seguridad relevantes y sigue soportando
PHP `^8.2`** (confirmado con `composer why-not laravel/framework 12.70.0`, sin conflicto de PHP) —
es la única opción que cumple ambos requisitos (seguridad vigente + PHP 8.2) al mismo tiempo.

**Alternativa rechazada — Laravel 10**: fuera de soporte de seguridad a esta fecha.

**Alternativa rechazada — Laravel 13**: requiere PHP 8.3, y el usuario pidió explícitamente
quedarse en PHP 8.2.

**Lección operativa**: antes de fijar una versión de framework en el plan, correr
`composer why-not <paquete> <version>` y `composer audit` contra el entorno real en lugar de
asumir la matriz de soporte "de memoria" — las ventanas de EOL de Laravel se mueven con el tiempo
y este plan se escribió asumiendo una fecha de referencia distinta a la real.

## Livewire 2 → 3

**Decisión**: migrar a Livewire 3 en la misma fase que Laravel 12.

**Por qué**: Livewire 2 no recibe soporte activo; mezclar Livewire 2 con Laravel 12 es una
combinación no recomendada por el propio proyecto Livewire. Los cambios de API relevantes para
este proyecto son acotados: `emit`/`emitTo` → `dispatch`, sintaxis de componentes anidados y
binding de eventos (`wire:click` sigue igual). Cada componente Livewire existente (`Colaborador`,
`Entrega`, `Inventario`, `Documento`, `Reporte`) se migra uno por uno dentro de la Fase A.

## Sistema de diseño: Tailwind CSS vs mantener Bootstrap

**Decisión**: Tailwind CSS, aplicado pantalla por pantalla en la Fase B.

**Por qué**: el usuario pidió explícitamente un rediseño visual completo (nuevo sistema de diseño),
no un refresh de AdminLTE. Tailwind da control fino de tamaños táctiles (áreas de toque ≥44px) sin
depender de los componentes de AdminLTE, que están pensados para mouse/teclado de escritorio.

**Alternativa rechazada**: actualizar solo AdminLTE a una versión más nueva — ya fue la opción
descartada explícitamente por el usuario en favor del rediseño completo.

**Build tool**: se evalúa mantener Laravel Mix (ya configurado en `webpack.mix.js`) vs migrar a
Vite (estándar actual de Laravel). Recomendado migrar a Vite en la Fase B, ya que Laravel 12 lo
soporta de forma nativa y el ecosistema de plugins Tailwind está mejor mantenido ahí; no es
bloqueante y puede diferirse si el tiempo aprieta.

## Librería de firma táctil: signature_pad.js vs jquery.signature.js

**Decisión**: `signature_pad` (szimek/signature_pad), reemplazando `public/assets/jquery.signature.js`.

**Por qué**: `signature_pad` usa Pointer Events (mouse, touch y stylus/Wacom con el mismo código),
está activamente mantenida, y no depende de jQuery. El flujo actual (`SignaturePadController`,
`firmaEpp` controller) no cambia su contrato de datos: sigue recibiendo un PNG en base64 y
guardándolo en `public/signatures/`, por lo que el cambio es aislado al frontend.

**Riesgo a validar en campo**: confirmar en la Tab Active5 real que el canvas captura trazos
suaves con el dedo (sin saltos por throttling de eventos táctiles de Android/Chrome) antes de
retirar la librería anterior.

## Librería de escaneo QR en tablet

**Decisión**: `html5-qrcode` (escaneo por cámara en el navegador, sin plugin nativo).

**Por qué**: funciona dentro de Chrome en Android sin requerir una app nativa ni acceso a APIs de
hardware fuera del navegador (`getUserMedia`), que es justamente el contexto de esta app (web
Laravel/Livewire, sin empaquetado nativo). Tiene buen soporte de linterna/zoom y de selección de
cámara trasera, relevante para leer carnés en condiciones de planta.

**Alternativa rechazada**: lectura QR vía app nativa dedicada — fuera de alcance, la app es 100%
web y el usuario no pidió una app nativa.

## Formato del payload del carné QR

**Dato de entrada real** (anonimizado en el spec, usado tal cual aquí para research):
`1067914365MARIAGA                GALEANO                JUAN FRANCISCO                                M19920809A+`

**Hipótesis de ancho fijo** (a confirmar con ≥5 muestras reales antes de codificar en producción):

| Campo | Offset inicio | Longitud aproximada | Ejemplo |
|---|---|---|---|
| Cédula | 0 | 10 | `1067914365` |
| Primer apellido | 10 | 20 (padded) | `MARIAGA` |
| Segundo apellido | 30 | 20 (padded) | `GALEANO` |
| Nombres | 50 | ~40 (padded) | `JUAN FRANCISCO` |
| Sexo | ~90 | 1 | `M` |
| Fecha nacimiento | ~91 | 8 (AAAAMMDD) | `19920809` |
| Grupo sanguíneo/RH | ~99 | 2 | `A+` |

**Por qué no codificar los offsets ya mismo**: el Principio V de la constitución exige validar con
muestras reales antes de confiar en offsets exactos — un error aquí asigna una entrega a la
persona equivocada. La tarea de implementación del parser (Fase D) debe incluir recolectar al
menos 5 carnés reales distintos (largos de nombre/apellido variables) para confirmar si el padding
es de longitud fija por campo o separadores distintos, y debe fallar explícitamente (no asignar
nada) si la longitud total no coincide con lo esperado.

## FPDI/FPDF + PHP 8.2

**Decisión**: mantener `setasign/fpdi` ^2.3 y `setasign/fpdf` ^1.8; son compatibles con PHP 8.2 (no
requieren extensiones ni sintaxis obsoleta). Se valida con una generación de acta real en la Fase A
como parte del checklist de humo, sin necesidad de cambiar de librería.
