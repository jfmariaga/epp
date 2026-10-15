# Phase 1 Data Model: Modernización integral de la app EPP

## Entidades modificadas

### `User` (usuarios del sistema)

Tabla `users` ya existe (`2014_10_12_000000_create_users_table.php`). Se agrega:

| Campo | Tipo | Notas |
|---|---|---|
| `role` | string/enum (`admin`, `operador`) | NUEVO. Default `operador`. Determina acceso al CRUD de usuarios. |

**Reglas**:
- No se puede eliminar el propio usuario autenticado (FR-011).
- No se puede eliminar el último usuario con `role = admin` (FR-011).
- La contraseña se sigue almacenando con hash (bcrypt, ya provisto por Laravel).

### `Empleado` (colaborador)

Sin cambios de esquema. Se agrega comportamiento (no columna nueva):

- Método `puedeEliminarse(): bool` → `!$this->entregasEpps()->exists()`.
- El controlador/Livewire que maneje "eliminar" MUST llamar este método antes de `delete()` y
  MUST mostrar el mensaje de bloqueo (FR-031) si devuelve `false`.

### `EntregaEpp`

Sin cambios. Sigue siendo la entidad cuya existencia bloquea el borrado del `Empleado` relacionado
(FK `empleado_id`, ya presente).

## Entidades nuevas (no persistidas)

### Payload del carné QR (valor transitorio)

No se persiste tal cual; se parsea en el momento del escaneo a un objeto con:

| Campo | Origen (offset fijo, ver research.md) | Uso |
|---|---|---|
| `cedula` | posición 0, 10 chars | Clave de búsqueda contra `Empleado.cc` |
| `apellido1` | posición 10, ~20 chars (trim) | Solo para mostrar/confirmar visualmente, no se escribe sobre `Empleado` existente |
| `apellido2` | posición 30, ~20 chars (trim) | idem |
| `nombres` | posición 50, ~40 chars (trim) | idem |
| `sexo` | 1 char | No usado en esta versión (informativo) |
| `fecha_nacimiento` | 8 chars (AAAAMMDD) | No usado en esta versión (informativo) |
| `grupo_sanguineo_rh` | 2 chars | No usado en esta versión (informativo) |

**Regla crítica**: el parser nunca crea ni actualiza un `Empleado` a partir del QR; solo lo usa
para **buscar** un `Empleado` existente por `cedula`. Si no hay match, se sigue el edge case
definido en spec.md ("ofrecer registrar o corregir la búsqueda"). Esto evita que un QR mal leído
sobrescriba datos reales de otro colaborador.

## Relaciones (sin cambios)

```text
Empleado 1---N EntregaEpp N---1 Epp
User (independiente, sin relación con Empleado/EntregaEpp)
```

La independencia explícita entre `User` (acceso al sistema) y `Empleado` (receptor de EPP) es
intencional (constitución, sección "Technology & Device Constraints"): nunca deben fusionarse en
una sola entidad.
