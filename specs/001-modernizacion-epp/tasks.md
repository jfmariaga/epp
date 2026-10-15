# Tasks: Modernización integral de la app EPP

**Input**: Design documents from `specs/001-modernizacion-epp/` (plan.md, research.md, data-model.md, spec.md)

**Tests**: se incluyen tareas de prueba para las reglas de negocio nuevas/críticas (CRUD de
usuarios, borrado seguro, parser QR), por ser las que más riesgo de seguridad/auditoría tienen. El
resto se verifica con checklists manuales, dado que el proyecto no tiene suite automatizada hoy.

**Organización**: por fase de migración (igual que en plan.md), y dentro de cada fase por historia
de usuario (US1–US4) cuando aplica.

## Format: `[ID] [P?] [Fase] Descripción`

- **[P]**: puede hacerse en paralelo (archivos distintos, sin dependencias)
- Cada tarea referencia archivos concretos del proyecto

---

## Fase A: Upgrade de plataforma (PHP 8.2 + Laravel 12 + Livewire 3)

**Bloquea** todas las demás fases: el rediseño y las features nuevas se construyen sobre esta base.

- [ ] T001 Confirmar versión real de PHP del entorno Laragon (`php -v` → ya es 8.2.30) y fijar
      `"php": "^8.2"` en `composer.json`
- [ ] T002 Actualizar `composer.json`: `laravel/framework` a `^10.0`, `laravel/sanctum` a la versión
      compatible con Laravel 12, `laravel/ui` y `livewire/livewire` a `^3.0`
- [ ] T003 Ejecutar `composer update` y resolver conflictos de versión uno por uno (no forzar con
      `--ignore-platform-reqs`)
- [ ] T004 [P] Migrar sintaxis Livewire 2 → 3 en `app/Http/Livewire/Colaborador/*.php`
      (`emit`/`emitTo` → `dispatch`/`dispatch().to()`)
- [ ] T005 [P] Migrar sintaxis Livewire 2 → 3 en `app/Http/Livewire/Entrega/*.php`
- [ ] T006 [P] Migrar sintaxis Livewire 2 → 3 en `app/Http/Livewire/Inventario/*.php`,
      `app/Http/Livewire/Documento/*.php`, `app/Http/Livewire/Reporte/*.php`
- [ ] T007 Revisar `app/Http/Controllers/Auth/*.php` y `routes/web.php` contra los cambios de
      `laravel/ui` 3.x → 4.x (scaffolding de auth)
- [ ] T008 Verificar que `setasign/fpdi` y `setasign/fpdf` siguen funcionando sin cambios
      (generación real de un acta de prueba vía `SignaturePadController@Addtopdf`)
- [ ] T009 **Checklist de humo manual**: login, listar/crear/editar colaborador, crear entrega,
      firmar con Wacom, generar PDF de acta — todo debe funcionar igual que antes del upgrade
- [ ] T010 Commit de cierre de Fase A únicamente cuando T009 pase completo

**Checkpoint**: la app corre en PHP 8.2 + Laravel 12 + Livewire 3 sin regresiones funcionales.

---

## Fase B: Rediseño visual completo (US4, P2)

**Depende de**: Fase A completa (Livewire 3 ya migrado, para no rediseñar sobre sintaxis vieja).

**Goal**: nuevo sistema de diseño Tailwind, touch-first, sin perder funcionalidad existente.

**Independent Test**: cada pantalla migrada conserva búsqueda/paginación/exportación PDF y es
operable con el dedo en la tablet sin zoom (spec.md, Acceptance Scenarios US4).

- [ ] T011 Instalar y configurar Tailwind CSS en el proyecto (decidir Vite vs mantener Laravel Mix,
      ver research.md); retirar `jeroennoten/laravel-adminlte` cuando ya no se use en ninguna vista
- [ ] T012 [P] Rediseñar `resources/views/layouts/app.blade.php` (layout base, navegación) con
      Tailwind, con targets táctiles ≥44px
- [ ] T013 [P] Rediseñar `resources/views/colaborador/index.blade.php` y
      `resources/views/livewire/colaborador/*.blade.php`
- [ ] T014 [P] Rediseñar `resources/views/inventario/index.blade.php` y
      `resources/views/livewire/inventario/*.blade.php`
- [ ] T015 [P] Rediseñar `resources/views/entrega/index.blade.php` y
      `resources/views/livewire/entrega/*.blade.php`
- [ ] T016 [P] Rediseñar `resources/views/reporte/index.blade.php` y
      `resources/views/livewire/reporte/*.blade.php`
- [ ] T017 [P] Rediseñar modales en `resources/views/modals/*.blade.php`
      (nuevo-usuario/editar-usuario/nueva-entrega/nuevo-epp/editar-epp)
- [ ] T018 Rediseñar `resources/views/auth/login.blade.php` y `register.blade.php`
- [ ] T019 **Checklist manual de uso táctil**: abrir cada pantalla migrada en la Tab Active5 (retrato
      y horizontal) y confirmar que todo control se opera con el dedo sin zoom
- [ ] T020 Commit por cada pantalla migrada (no un solo commit gigante de "rediseño")

**Checkpoint**: todas las pantallas existentes usan el nuevo sistema de diseño y pasan el
checklist táctil, sin perder ninguna función (SC-005, SC-006).

---

## Fase C: CRUD de usuarios del sistema (US2, P1)

**Depende de**: Fase A (Livewire 3). Puede hacerse en paralelo con Fase B si hay más de una persona
disponible (archivos distintos).

**Goal**: administrar cuentas de acceso al sistema, separado del CRUD de colaboradores.

**Independent Test**: crear/editar/eliminar un usuario del sistema sin tocar `Empleado` ni
`EntregaEpp` (spec.md, Acceptance Scenarios US2).

- [ ] T021 Migración: agregar columna `role` (string, default `operador`) a la tabla `users`
      (`database/migrations/..._add_role_to_users.php`)
- [ ] T022 Actualizar `app/Models/User.php`: agregar `role` a `$fillable`, helper
      `isAdmin(): bool`
- [ ] T023 Crear política/middleware de autorización que restrinja el CRUD de usuarios a
      `role = admin` (p. ej. `app/Policies/UserPolicy.php` o middleware dedicado)
- [ ] T024 [P] Crear `app/Http/Livewire/Usuario/Index.php` (listado + búsqueda, igual patrón que
      `Colaborador/Index.php`)
- [ ] T025 [P] Crear `app/Http/Livewire/Usuario/NuevoUsuario.php` (crear usuario con nombre, email,
      password, role)
- [ ] T026 [P] Crear `app/Http/Livewire/Usuario/EditarUsuario.php` (editar datos y role; password
      opcional al editar)
- [ ] T027 Implementar regla "no autoeliminación" y "no eliminar último admin" en la acción de
      borrado de `Usuario/Index.php` (ver data-model.md)
- [ ] T028 [P] Crear vistas `resources/views/usuario/index.blade.php` y
      `resources/views/livewire/usuario/*.blade.php` (ya con el sistema de diseño de la Fase B si
      esta fase corre después; si corre en paralelo, usar el diseño existente y migrar luego)
- [ ] T029 Agregar rutas en `routes/web.php` para el módulo de usuarios, protegidas por el
      middleware/policy de T023
- [ ] T030 [P] Test: `tests/Feature/UsuarioCrudTest.php` — crear, editar, eliminar usuario; intento
      de autoeliminación bloqueado; intento de eliminar último admin bloqueado
- [ ] T031 Agregar enlace al módulo de usuarios en la navegación (solo visible para admin)
- [ ] T032 Commit de cierre de Fase C

**Checkpoint**: un administrador gestiona usuarios del sistema de punta a punta (SC-004).

---

## Fase D: Identificación de colaborador en tablet — QR + cédula (US1, P1)

**Depende de**: Fase A. Idealmente después de Fase B (para no rediseñar dos veces la pantalla de
Entrega), pero puede adelantarse si se acepta rehacer estilos luego.

**Goal**: identificar colaborador en la tablet sin RFID, vía QR o cédula manual.

**Independent Test**: escanear un carné real identifica al colaborador correcto; un carné dañado
cae a búsqueda manual sin romper el flujo (spec.md, Acceptance Scenarios US1, edge cases).

- [ ] T033 Recolectar ≥5 muestras reales de carnés QR (distintos largos de nombre/apellido) para
      confirmar offsets de research.md antes de codificarlos
- [ ] T034 Crear `app/Services/CarneQrParser.php`: parseo de ancho fijo con validación de longitud
      total; MUST devolver "inválido" (no datos parciales) si el payload no calza con el formato
- [ ] T035 [P] Test unitario: `tests/Feature/CarneQrParserTest.php` — payload válido, payload corto,
      payload con caracteres inesperados, payload de otro formato de carné
- [ ] T036 Integrar librería `html5-qrcode` en `resources/js/qr-scanner.js`: abre cámara trasera,
      emite el payload leído a Livewire (`wire:click`/evento custom)
- [ ] T037 En `app/Http/Livewire/Entrega/Index.php` (o componente nuevo), agregar modo "escanear QR"
      que usa `CarneQrParser` para obtener la cédula y buscar el `Empleado` existente por `cc`
- [ ] T038 Si la cédula del QR no coincide con ningún `Empleado`, mostrar aviso y ofrecer búsqueda
      manual o registro (no crear entrega a ciegas — edge case de spec.md)
- [ ] T039 Confirmar que la búsqueda manual por cédula (ya existente en `Entrega/Index.php`, campo
      `search`) sigue disponible y visible como alternativa siempre, no solo en fallback de error
- [ ] T040 **Checklist manual en dispositivo real**: escanear ≥10 carnés reales distintos en la Tab
      Active5 y confirmar identificación correcta en el primer intento en ≥95% de los casos (SC-002)
- [ ] T041 Commit de cierre de Fase D

**Checkpoint**: en la tablet, un supervisor identifica a cualquier colaborador por QR o cédula sin
teclado físico (SC-001).

---

## Fase E: Firma manuscrita táctil (parte de US1, P1)

**Depende de**: Fase A. Puede hacerse junto con Fase D ya que toca las mismas pantallas de entrega/firma.

**Goal**: firma equivalente en PC (Wacom) y tablet (dedo), mismo resultado en el acta PDF.

**Independent Test**: firma capturada en tablet aparece correctamente en el acta PDF generado,
igual que la firma Wacom en PC (spec.md, Acceptance Scenario 3 de US1).

- [ ] T042 Sustituir `public/assets/jquery.signature.js` por `signature_pad` en
      `resources/views/signature-pad.blade.php` y `resources/views/firmaEpp.blade.php`
- [ ] T043 Confirmar que `SignaturePadController@update` y `firmaEpp@update` siguen recibiendo el
      mismo formato de imagen base64 sin cambios de contrato
- [ ] T044 **Checklist manual**: firmar en PC con Wacom y en Tab Active5 con el dedo; confirmar que
      ambas firmas se ven correctamente en el PDF generado (`Addtopdf`, `foso32`)
- [ ] T045 Eliminar `public/assets/jquery.signature.js` y `jquery.signature.css` solo después de que
      T044 pase en ambos dispositivos
- [ ] T046 Commit de cierre de Fase E

**Checkpoint**: firma manuscrita funciona igual de bien en PC y tablet (parte de SC-001).

---

## Fase F: Borrado seguro de colaboradores (US3, P2)

**Depende de**: Fase A. Independiente de las demás fases nuevas (solo toca `Colaborador`).

**Goal**: eliminar colaboradores solo cuando no tienen entregas asociadas.

**Independent Test**: eliminar colaborador sin entregas funciona; con entregas se bloquea con
mensaje claro (spec.md, Acceptance Scenarios US3).

- [ ] T047 Agregar método `puedeEliminarse(): bool` a `app/Models/Empleado.php`
      (`!$this->entregasEpps()->exists()`), ver data-model.md
- [ ] T048 Agregar acción "eliminar" en `app/Http/Livewire/Colaborador/Index.php`
      (`selecItem($userId, 'delete')` ya emite `delete_ok`; falta el método que ejecuta el borrado
      real tras confirmación)
- [ ] T049 Si `puedeEliminarse()` es `false`, mostrar mensaje bloqueando la acción y sugiriendo
      marcar como "Inactivo" (campo `estado` ya existe en `Empleado`)
- [ ] T050 Agregar botón "Eliminar" y modal de confirmación en
      `resources/views/livewire/colaborador/index.blade.php` (con el sistema de diseño de Fase B)
- [ ] T051 [P] Test: `tests/Feature/ColaboradorDeleteTest.php` — eliminar colaborador sin entregas
      (éxito), eliminar colaborador con entregas (bloqueado, mensaje correcto)
- [ ] T052 Commit de cierre de Fase F

**Checkpoint**: ningún colaborador con entregas puede eliminarse desde la UI (SC-003).

---

## Dependencias entre fases

- **Fase A** bloquea todas las demás (base de plataforma).
- **Fase B** (rediseño) es transversal; puede avanzar pantalla por pantalla en paralelo con C/D/E/F,
  aceptando retrabajo visual menor si una fase nueva se termina antes de que su pantalla se
  rediseñe.
- **Fase C** (usuarios del sistema) es independiente de D/E/F — puede hacerse en paralelo.
- **Fases D y E** comparten pantallas (Entrega/Firma) — conviene secuenciarlas juntas para no
  tocar los mismos archivos dos veces.
- **Fase F** es independiente — puede hacerse en cualquier momento después de la Fase A.

## Estrategia recomendada de entrega

1. Fase A primero, siempre (nada más se construye sobre Laravel 9 viejo).
2. Fase C (usuarios del sistema) y Fase F (borrado seguro) en paralelo — son las más acotadas y de
   menor riesgo, buenas para validar el nuevo flujo de trabajo por fases.
3. Fases D + E juntas (identificación QR + firma táctil) — es el valor central de usar la tablet en
   campo (US1, la historia P1 más importante).
4. Fase B (rediseño visual) corre en paralelo a todo lo anterior, pantalla por pantalla, y se cierra
   al final sobre las pantallas que ya tengan sus features nuevas.

## Notas

- No hay tareas marcadas `[P]` entre sí dentro de la misma fase cuando tocan el mismo archivo
  (p. ej. T048–T050 son secuenciales porque todas tocan `Colaborador/Index.php` y su vista).
- Cada fase termina con un commit propio, conforme al Principio IV de la constitución
  (`.specify/memory/constitution.md`).
- Las tareas de "checklist manual" no son opcionales: sustituyen a la suite de tests E2E que el
  proyecto no tiene, y son la única verificación real de los flujos que dependen de hardware físico
  (Wacom, cámara de la tablet, lector RFID USB).
