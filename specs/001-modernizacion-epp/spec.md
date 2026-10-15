# Feature Specification: Modernización integral de la app EPP

**Feature Branch**: `001-modernizacion-epp`

**Created**: 2026-10-15

**Status**: Draft

**Input**: User description: "Subir la app EPP a PHP 8.2, actualización completa de interfaz, agregar CRUD de usuarios del sistema, identificación de colaborador por QR/cédula en tablet (sin RFID por NFC, incompatible), borrado seguro de colaboradores sin entregas de EPP, soporte dual PC (RFID USB + Wacom) y tablet Samsung Galaxy Tab Active5 5G (cámara + táctil)."

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Registrar una entrega de EPP desde la tablet en planta (Priority: P1)

Un supervisor recorre la planta con la Galaxy Tab Active5, aborda a un colaborador, escanea el QR
de su carné con la cámara (o busca por cédula si el QR no se puede leer), selecciona el EPP
entregado y el colaborador firma con el dedo directamente en la pantalla. El acta se genera sin
necesidad de volver a un PC.

**Why this priority**: es el flujo operativo diario que justifica el uso de la tablet; si no
funciona de punta a punta en campo, la tablet no aporta valor sobre el PC actual.

**Independent Test**: con el Empleado ya existente en el sistema, escanear su carné QR en la
tablet debe completar la identificación sin teclado físico, y la firma táctil debe quedar
guardada y visible en el acta generada, igual que ocurre hoy con la firma Wacom en PC.

**Acceptance Scenarios**:

1. **Given** un colaborador activo con carné QR válido, **When** el supervisor escanea el QR
   desde la tablet, **Then** el sistema identifica al colaborador automáticamente (nombre,
   cédula, cargo) sin requerir más entrada manual.
2. **Given** un QR ilegible o dañado, **When** el supervisor intenta escanearlo repetidamente,
   **Then** el sistema ofrece buscar al colaborador manualmente por número de cédula y continuar
   el flujo con normalidad.
3. **Given** una entrega de EPP registrada en la tablet, **When** el colaborador firma con el
   dedo en la pantalla táctil, **Then** la firma se guarda y aparece correctamente en el acta PDF
   generada, con la misma calidad funcional que una firma capturada con Wacom en PC.

---

### User Story 2 - Administrar usuarios del sistema (Priority: P1)

Un administrador necesita dar de alta, editar, desactivar o eliminar cuentas de acceso al sistema
(distintas de los colaboradores/empleados que reciben EPP), asignando roles básicos (p. ej.
Administrador / Operador) para controlar quién puede entrar a la aplicación.

**Why this priority**: hoy no existe ninguna forma de gestionar quién tiene acceso al sistema más
allá del registro abierto de Laravel; es un hueco de seguridad y de operación que bloquea el uso
multiusuario real de la app.

**Independent Test**: un administrador puede crear un nuevo usuario del sistema con nombre, correo
y contraseña, verlo en un listado, editarlo, y eliminarlo, sin afectar ningún registro de
`Empleado` ni de `EntregaEpp`.

**Acceptance Scenarios**:

1. **Given** un administrador autenticado, **When** crea un nuevo usuario con nombre, correo y
   contraseña válidos, **Then** el usuario queda disponible para iniciar sesión y aparece en el
   listado de usuarios.
2. **Given** un usuario del sistema existente, **When** el administrador edita su nombre, correo
   o rol, **Then** los cambios se reflejan de inmediato y, si cambia su contraseña, el usuario
   debe autenticarse con la nueva contraseña en su siguiente inicio de sesión.
3. **Given** un usuario del sistema existente que no es el usuario autenticado actual, **When**
   el administrador lo elimina, **Then** el usuario deja de poder iniciar sesión y se elimina del
   listado.
4. **Given** el usuario autenticado actual, **When** intenta eliminarse a sí mismo, **Then** el
   sistema lo impide y explica por qué (evitar quedarse sin acceso administrativo).

---

### User Story 3 - Eliminar un colaborador sin entregas registradas (Priority: P2)

Un administrador dio de alta un colaborador por error, o un colaborador nunca llegó a recibir
ningún EPP (p. ej. se fue antes de su primera entrega), y necesita eliminarlo del listado para
mantener los datos limpios.

**Why this priority**: es una limpieza de datos necesaria pero menos frecuente que el día a día
de entregas; depende de que el CRUD de colaboradores ya exista (lo cual es cierto hoy).

**Independent Test**: eliminar un colaborador sin entregas asociadas lo quita del listado; intentar
eliminar uno con entregas asociadas lo bloquea con un mensaje claro.

**Acceptance Scenarios**:

1. **Given** un colaborador sin ninguna `EntregaEpp` asociada, **When** el administrador elige
   eliminarlo y confirma, **Then** el colaborador se elimina y deja de aparecer en el listado.
2. **Given** un colaborador con una o más `EntregaEpp` asociadas, **When** el administrador intenta
   eliminarlo, **Then** el sistema bloquea la acción y muestra un mensaje explicando que tiene
   entregas registradas, sugiriendo marcarlo como "Inactivo" en su lugar.
3. **Given** un colaborador recién marcado como "Inactivo" en vez de eliminado, **When** se
   consulta el listado de entregas o el acta de ese colaborador, **Then** su historial permanece
   intacto y accesible.

---

### User Story 4 - Interfaz rediseñada usable a diario en PC y tablet (Priority: P2)

Los usuarios actuales (auxiliares SST, supervisores, almacenistas) usan la app todos los días desde
un PC de oficina y, a partir de ahora, también desde la tablet en planta. Necesitan una interfaz
visualmente renovada que sea igual de clara en ambos dispositivos: tablas y formularios legibles
en PC, y botones/campos suficientemente grandes para operarse con el dedo en la tablet sin hacer
zoom.

**Why this priority**: es transversal a todas las pantallas existentes (colaboradores, inventario,
entregas, reportes) pero no bloquea, por sí sola, la entrada en producción de las funciones nuevas
(QR, usuarios, borrado); puede entregarse pantalla por pantalla.

**Independent Test**: cada pantalla migrada al nuevo sistema de diseño conserva sus funciones
actuales (búsqueda, paginación, exportación a PDF) y pasa una prueba manual de uso táctil en la
tablet sin necesidad de hacer zoom ni usar un lápiz de precisión.

**Acceptance Scenarios**:

1. **Given** cualquier pantalla ya migrada al nuevo diseño, **When** se abre en la tablet en modo
   retrato u horizontal, **Then** todos los controles son operables con el dedo sin superponerse
   ni requerir zoom.
2. **Given** una tabla con muchos registros (p. ej. listado de colaboradores), **When** se usa en
   PC, **Then** la búsqueda y paginación siguen funcionando igual o mejor que antes del rediseño.
3. **Given** una pantalla migrada, **When** se compara con su versión anterior, **Then** ninguna
   función existente (exportar PDF, firmar, filtrar) se perdió ni cambió de comportamiento sin
   que el usuario lo entienda.

---

### Edge Cases

- ¿Qué pasa si se escanea el QR de un carné que no corresponde a ningún `Empleado` registrado en
  el sistema (cédula desconocida)? → debe mostrarse un mensaje claro y ofrecer registrar al
  colaborador o corregir la búsqueda, nunca crear una entrega "a ciegas".
- ¿Qué pasa si el payload leído del QR no tiene el ancho/formato esperado (carné de otro tipo,
  lectura parcial por mala iluminación)? → el sistema debe rechazar el payload y pedir reintento o
  búsqueda manual, nunca asignar campos a ciegas con offsets incorrectos.
- ¿Qué pasa si dos administradores editan el mismo usuario del sistema o el mismo colaborador casi
  al mismo tiempo? → debe prevalecer la última escritura confirmada; no se requiere bloqueo
  optimista para esta versión, pero no debe corromper el registro.
- ¿Qué pasa si se intenta eliminar el único usuario del sistema con rol administrador? → debe
  bloquearse igual que la autoeliminación, para no dejar la app sin ningún administrador.
- ¿Qué pasa si la tablet pierde conectividad a internet/VPN mientras se está registrando una
  entrega? → el usuario debe recibir un aviso claro de que la entrega no se guardó, sin perder lo
  ya capturado en pantalla (nombre, EPP seleccionado) para poder reintentar.

## Requirements *(mandatory)*

### Functional Requirements

**Plataforma**

- **FR-001**: El sistema MUST ejecutarse sobre PHP 8.2 y una versión LTS de Laravel compatible
  (10 u 11), sin usar funciones o paquetes marcados como obsoletos (deprecated) en esa versión.
- **FR-002**: El sistema MUST seguir generando correctamente las actas en PDF (vía FPDI/FPDF) y
  conservando el acceso a las firmas ya almacenadas en `public/signatures` después de la
  migración de versión.

**Usuarios del sistema**

- **FR-010**: El sistema MUST permitir a un usuario con rol Administrador crear, listar, editar y
  eliminar usuarios del sistema (cuentas de acceso), de forma independiente del CRUD de
  colaboradores (`Empleado`).
- **FR-011**: El sistema MUST impedir que un usuario se elimine a sí mismo o elimine al último
  usuario con rol Administrador restante.
- **FR-012**: El sistema MUST almacenar las contraseñas de los usuarios del sistema de forma
  segura (hash), igual que lo hace hoy el scaffolding de autenticación de Laravel.
- **FR-013**: El sistema MUST distinguir al menos dos roles de usuario del sistema (Administrador
  y Operador), donde solo el rol Administrador accede al CRUD de usuarios.

**Identificación de colaborador en tablet**

- **FR-020**: El sistema MUST ofrecer, en la tablet, un modo de identificación de colaborador por
  lectura de QR del carné usando la cámara del dispositivo.
- **FR-021**: El sistema MUST ofrecer, en la tablet, búsqueda manual de colaborador por número de
  cédula como alternativa siempre disponible (QR dañado, iluminación insuficiente, etc.).
- **FR-022**: El sistema MUST NOT intentar leer tarjetas RFID de 125kHz a través del NFC de la
  tablet; esa vía queda fuera de alcance por incompatibilidad de hardware.
- **FR-023**: El sistema MUST interpretar el payload del QR del carné (cadena de ancho fijo con
  cédula, apellidos, nombres, sexo, fecha de nacimiento y grupo sanguíneo/RH) y, si el payload no
  cumple el formato/longitud esperada, MUST rechazarlo y pedir reintento o búsqueda manual en
  lugar de asignar datos incorrectos.
- **FR-024**: El sistema MUST seguir soportando, sin cambios de comportamiento, la identificación
  por lector RFID USB (keyboard-wedge) y búsqueda por cédula ya existente en PC.

**Borrado seguro de colaboradores**

- **FR-030**: El sistema MUST permitir eliminar un colaborador (`Empleado`) únicamente cuando no
  tiene ninguna `EntregaEpp` asociada.
- **FR-031**: El sistema MUST bloquear la eliminación de un colaborador con entregas asociadas y
  MUST mostrar un mensaje explicando el motivo y sugiriendo marcarlo como "Inactivo".
- **FR-032**: El sistema MUST pedir confirmación explícita antes de eliminar un colaborador (acción
  irreversible).

**Firma manuscrita en tablet**

- **FR-040**: El sistema MUST permitir capturar la firma manuscrita del colaborador mediante el
  dedo sobre la pantalla táctil de la tablet, con el mismo resultado funcional (imagen embebida en
  el acta PDF) que la firma capturada hoy con Wacom en PC.

**Interfaz**

- **FR-050**: El sistema MUST ofrecer una interfaz rediseñada, consistente entre PC y tablet, que
  conserve toda la funcionalidad existente (búsqueda, paginación, filtros, exportación a PDF) en
  cada pantalla migrada.
- **FR-051**: El sistema MUST asegurar que, en la tablet, los controles interactivos de las
  pantallas rediseñadas sean operables con el dedo sin necesidad de hacer zoom.

### Key Entities

- **Empleado (Colaborador)**: persona que recibe EPP. Atributos existentes: rfid, nombre, cédula
  (cc), centro de costos, cargo, área, estado (activo/inactivo), tipo de contrato, firma. Relación
  1-N con `EntregaEpp`. No se elimina si tiene entregas asociadas.
- **EntregaEpp**: registro de una entrega de un EPP a un colaborador en una fecha, con motivo,
  responsable que la registró, línea, observación y firma propia de esa entrega. Es el registro de
  auditoría que protege a `Empleado` de ser eliminado.
- **Epp**: ítem de inventario de protección personal entregable (descripción, ítem, acta).
- **Usuario del sistema**: cuenta de acceso a la aplicación, con nombre, correo, contraseña y rol
  (Administrador/Operador). Entidad nueva en esta especificación, independiente de `Empleado`.
- **Carné QR**: no es una entidad persistida; es un payload de ancho fijo escaneado en el momento
  que se usa para encontrar o confirmar un `Empleado` existente por su cédula.

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: Un supervisor puede identificar a un colaborador y registrar una entrega de EPP
  completa (incluida la firma) desde la tablet, de principio a fin, sin tocar un teclado físico.
- **SC-002**: El escaneo de un carné QR legible identifica al colaborador correcto en un solo
  intento en al menos el 95% de los casos de prueba con carnés reales.
- **SC-003**: Ningún colaborador con entregas de EPP registradas puede ser eliminado desde la
  interfaz, verificado con pruebas manuales sobre casos reales con y sin entregas.
- **SC-004**: Un administrador puede crear, editar y eliminar un usuario del sistema en menos de
  1 minuto por operación, sin tocar la base de datos directamente.
- **SC-005**: Todas las pantallas existentes (colaboradores, inventario, entregas, reportes) siguen
  generando sus actas/reportes en PDF correctamente después de la migración a PHP 8.2 y del
  rediseño visual, sin regresiones detectadas en pruebas manuales de humo.
- **SC-006**: En la tablet, un usuario puede completar cualquier pantalla rediseñada únicamente con
  el dedo (sin lápiz de precisión ni zoom) en una prueba de uso guiada.

## Assumptions

- La tablet Samsung Galaxy Tab Active5 5G tendrá conectividad de red (Wi-Fi o 5G/VPN corporativa)
  suficiente para operar contra la misma instancia web del sistema; no se requiere modo offline en
  esta versión.
- El formato exacto del QR (anchos de campo) se terminará de confirmar y validar con varias
  muestras reales de carnés durante la fase de implementación, no durante la especificación.
- Los roles de usuario del sistema se limitan a Administrador y Operador para esta versión; no se
  modela un sistema de permisos granular más allá de "acceso al CRUD de usuarios sí/no".
- El navegador por defecto de la tablet (Chrome en Android) soporta acceso a cámara y a eventos
  táctiles de canvas sin plugins adicionales.
- No se requiere soporte retroactivo de PHP 8.0/8.1 ni de Laravel 9 una vez completada la
  migración; el entorno de producción se actualiza junto con el código.
