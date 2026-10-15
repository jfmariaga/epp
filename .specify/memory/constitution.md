<!--
Sync Impact Report
Version change: none → 1.0.0 (initial ratification)
Modified principles: n/a (new document)
Added sections: Core Principles (I–VI), Technology & Device Constraints, Development Workflow, Governance
Removed sections: none
Follow-up TODOs: TODO(RATIFICATION_DATE) — project had no prior formal constitution; date set to today
  as the ratification date since this is the first adoption, confirm if an earlier date should apply.
-->

# EPP Constitution

## Core Principles

### I. Dual-Device Parity (NON-NEGOTIABLE)
The application MUST work correctly on two distinct device profiles: desktop PCs (mouse/keyboard,
USB 125kHz RFID keyboard-wedge readers, Wacom signature tablets) and the Samsung Galaxy Tab
Active5 5G (touchscreen only, rear camera, NFC at 13.56MHz). Every screen involved in a critical
workflow — identifying a collaborator, recording an EPP delivery, capturing a signature — MUST have
a complete touch-only path that requires no physical keyboard. Device-specific code paths MUST
degrade gracefully: a feature unavailable on one device profile MUST be replaced by an equivalent
flow, never left broken or silently missing.

**Rationale**: the app is used interchangeably at a PC workstation and in the field on a tablet;
regressions on either profile block real deliveries of protective equipment.

### II. No RFID-over-NFC Assumptions
NFC (13.56MHz, ISO 14443) and the 125kHz RFID cards already issued to collaborators are physically
incompatible protocols. The application MUST NOT attempt to read 125kHz RFID cards through the
tablet's NFC radio, and no feature may be designed assuming that capability exists. On the tablet,
collaborator identification MUST use only: (a) camera-based QR scanning of the collaborator's
badge, or (b) manual search by cédula (national ID number). On PC, the existing RFID
keyboard-wedge search flow remains the primary identification method, with manual cédula search as
fallback.

**Rationale**: this is a hardware physics constraint, not a software gap; treating it as solvable
in software wastes implementation effort and creates false expectations.

### III. Audit Integrity Over Convenience
A collaborator ("colaborador"/`Empleado`) that has one or more associated `EntregaEpp` (EPP
delivery) records MUST NOT be deletable, physically or logically, through any user-facing action.
Any delete action on such a record MUST be blocked before mutation, with a clear message directing
the user to mark the collaborator as "Inactivo" instead. Collaborators with zero delivery records
MAY be deleted. This rule applies uniformly across every interface (web UI, future API, console
commands).

**Rationale**: EPP delivery acts are the legal/safety record of protective-equipment issuance;
losing the link between a delivery and the person who received it defeats the purpose of the
system.

### IV. Incremental, Reversible Migration
The upgrade from PHP ^8.0 and Laravel 9 to PHP 8.2 and a supported Laravel LTS (10 or 11) MUST be
executed in independently committed, independently testable phases (e.g., dependency bump,
framework upgrade, deprecation fixes, UI redesign, new features). No phase may break the
already-working production flows — collaborator management, EPP inventory, delivery registration,
manuscript signature capture, and PDF acta generation via FPDI/FPDF — at the end of that phase.
Each phase MUST end in a state that can be deployed or rolled back on its own.

**Rationale**: this is a production tool used daily for safety compliance; a big-bang rewrite risks
an outage with no safe rollback point.

### V. Fixed-Width QR Payload Is Untrusted Until Verified
The collaborator badge QR encodes a fixed-width, space-padded positional string (e.g. cédula,
first surname, second surname, given names, sex, birth date, blood type/RH). Field offsets MUST be
derived from and validated against multiple real sample badges before being hard-coded, and the
parser MUST fail safely (reject/flag for manual entry) rather than silently mis-assigning fields
when a scanned payload's length or shape doesn't match the expected format.

**Rationale**: a wrong offset silently assigns one collaborator's delivery to another collaborator's
record — a safety and audit failure, not just a UI bug.

### VI. Touch-First Visual Redesign
The UI redesign MUST replace the current AdminLTE 3.8/Bootstrap 5 system with a new, cohesive
design system built mobile/touch-first, while remaining fully usable on desktop with mouse and
keyboard. Interactive targets, forms, and modals used in the field (collaborator lookup, delivery
entry, signature capture) MUST be comfortably operable by touch on a tablet screen without zoom.
Redesigned screens MUST preserve or improve on the current functionality (search, pagination,
PDF/acta generation) — no feature regressions introduced for visual polish alone.

**Rationale**: the user chose a full visual overhaul over incremental theming; this principle keeps
that redesign from degrading real field usability in the process.

## Technology & Device Constraints

- Runtime: PHP 8.2; framework target Laravel 10 or 11 LTS (chosen during `/speckit-plan`).
- Supported devices: Windows PC (Wacom signature tablet, USB 125kHz RFID reader) and Samsung
  Galaxy Tab Active5 5G (touchscreen, rear camera for QR, no RFID support).
- Persisted audit artifacts (signatures in `public/signatures`, generated PDFs) MUST remain
  readable by the existing FPDI/FPDF-based acta generation after every migration phase, or that
  generation code MUST be updated in the same phase that changes its inputs.
- New system-user management (login accounts) is a net-new CRUD on `App\Models\User`, distinct
  from the existing `Empleado` (collaborador) CRUD; the two MUST NOT be merged into one entity.

## Development Workflow

- Each feature or migration phase goes through `/speckit-specify` → `/speckit-plan` →
  `/speckit-tasks` → `/speckit-implement` before being considered done.
- Every phase is committed separately to git with a message describing what changed and why;
  no phase is squashed into "various fixes."
- Before marking a migration phase complete, the existing core flows (login, collaborador CRUD,
  inventario CRUD, entrega registration, signature capture, PDF acta generation) MUST be manually
  verified not to have regressed, since the project currently has no automated test suite covering
  them.
- Device-specific behavior (RFID search vs. QR scan vs. manual cédula search) MUST be verified on
  both target device profiles before a phase touching collaborator identification is closed.

## Governance

This constitution supersedes ad-hoc practice for all work on the EPP application. Amendments
require: a documented rationale, an explicit version bump following semantic versioning (MAJOR for
backward-incompatible principle removal/redefinition, MINOR for new/expanded principles, PATCH for
clarifications), and an update to this file's Sync Impact Report. Any plan or task list produced by
`/speckit-plan` or `/speckit-tasks` that conflicts with a principle here MUST either be revised or
justify the deviation explicitly in that artifact's own complexity/deviation tracking — silent
deviation is not permitted.

**Version**: 1.0.0 | **Ratified**: 2026-10-15 | **Last Amended**: 2026-10-15
