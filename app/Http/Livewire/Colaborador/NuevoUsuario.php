<?php

namespace App\Http\Livewire\Colaborador;

use App\Models\Empleado;

use Livewire\Component;

class NuevoUsuario extends Component
{
    public $nombre, $cc, $area, $password, $centro, $cargo, $contrato;
    public $user;
    protected $rules = [
        'nombre' => 'required',
        'cc' => 'required',
        'password' => 'required',
        'area' => 'required',
        'centro' => 'required',
        'cargo' => 'required',
        'contrato' => 'required'
    ];

    public function render()
    {
        return view('livewire.colaborador.nuevo-usuario');
    }

    public function guardar()
    {
        $this->validate();

        $datos = [
            'nombre' => $this->nombre,
            'cc' => $this->cc,
            'rfid' => $this->password,
            'area' => $this->area,
            'centro' => $this->centro,
            'cargo' => $this->cargo,
            'tp_contrato' => $this->contrato,
            'estado' => 0,
        ];

        Empleado::create($datos);
        // $user->save();
        $this->emitTo('colaborador.index', 'render');
        $this->reset();
        $this->emit('usuario_ok');
    }

    public function resetear()
    {
        $this->reset();
    }

    public $cargos = [
        'ALMACENISTA DE  MANTENIMIENTO',
        'ANALISTA AMBIENTAL',
        'ANALISTA CONTABLE',
        'ANALISTA CONTABLE ',
        'ANALISTA CONTROL CALIDAD',
        'ANALISTA CONTROL CALIDAD (JUNIOR)',
        'ANALISTA COSTOS Y PRESU JUNIOR',
        'ANALISTA COSTOS Y PRESUPUESTO',
        'ANALISTA DE ALMACEN',
        'ANALISTA DE ASUNTOS REGULATORI',
        'ANALISTA DE BPM',
        'ANALISTA DE COMPENSACION',
        'ANALISTA DE COMPRAS',
        'ANALISTA DE COMPRAS (REP Y SERV)',
        'ANALISTA DE CONTROL CALIDAD',
        'ANALISTA DE CONTROL DE PRODUC',
        'ANALISTA DE I&D',
        'ANALISTA DE INVENTARIOS',
        'ANALISTA DE LOGISTICA',
        'ANALISTA DE MATERIAS PRIMAS',
        'ANALISTA DE MEJORA CONTINUA',
        'ANALISTA DE MICROBIOLOGIA',
        'ANALISTA DE PLANEACION',
        'ANALISTA DE QUEJAS Y RECLAMOS',
        'ANALISTA DE TECNOLOGIA',
        'ANALISTA GENTE Y CULTURA',
        'ANALISTA MATERIAL DE EMPAQUE',
        'ANALISTA PRODUCCION',
        'ANALISTA SIG',
        'ASEADOR DE PLANTA',
        'AUX DE DESPACHOS',
        'AUX DE OFICIOS VARIOS MANTENIM',
        'AUXILIAR ADMINISTRATIVO ALMACEN',
        'AUXILIAR AMBIENTAL PTAR',
        'AUXILIAR AMBIENTAL RECICLAJE',
        'AUXILIAR CAD',
        'AUXILIAR DE DESPACHOS',
        'AUXILIAR DE MICROBIOLOGIA',
        'AUXILIAR DE SERVICIOS GENERALE',
        'AUXILIAR GENTE Y CULTURA',
        'AUXILIAR SST',
        'CALDERISTA ',
        'COMPRADOR',
        'COORDINADOR CAD',
        'COORDINADOR DE COMPENSACION',
        'COORDINADOR DE CONTROL CALIDAD',
        'COORDINADOR DE TECNOLOGIA ',
        'DESARROLLADOR DE ABASTECIMIENTO',
        'ELECTRICISTA ',
        'FORMULADOR',
        'GERENTE ADTIVO Y FINANCIERO',
        'GERENTE DE INNOVACION',
        'GERENTE DE PLANTA',
        'GERENTE GENERAL',
        'INGENIERO DE EMPAQUES',
        'INGENIERO DE MANTENIMIENTO',
        'INGENIERO DE PROCESOS',
        'INGENIERO I&D',
        'INGENIERO JUNIOR DE INVESTIGACION Y DESARROLLO',
        'JEFE  MANTENIMIENTO',
        'JEFE CONTABILIDAD  IMPUESTOS',
        'JEFE DE ALMACEN',
        'JEFE DE CONTROL PRODUCCION',
        'JEFE DE CONTROL y ASEGURAMIENTO DE CALIDAD',
        'JEFE DE COSTOS Y PRESUPUESTOS',
        'JEFE DE LOGISTICA',
        'JEFE DE PLANEACION',
        'JEFE DE PLANTA',
        'JEFE DE PROYECTOS',
        'JEFE DE SISTEMAS INT DE GESTIO',
        'JEFE SST',
        'MECANICO',
        'MECANICO JUNIOR',
        'MENSAJERO',
        'METROLOGO',
        'OPERARIO DE MONTACARGAS',
        'OPERARIO EXPERTO',
        'OPERARIO EXPERTO BOD PROD TERM',
        'OPERARIO EXPERTO CONTROL DE P',
        'OPERARIO EXPERTO SUMINISTROS',
        'OPERARIO GENERAL',
        'OPERARIO GENERAL BOD PROD TERM',
        'PLANEADOR Y PROGRAMADOR DE MAN',
        'PROFESIONAL EN BIENESTAR Y DLL',
        'SUPERVISOR AMBIENTAL',
        'SUPERVISOR DE ALMACEN',
        'SUPERVISOR DE LOGISTICA',
        'SUPERVISOR DE MANTENIMIENTO',
        'SUPERVISOR DE PLANTA',
        'SUPERVISOR DE PLANTA ',
        'TESORERO',
    ];

    public $areas = [
        'ALMACEN MATERIA PRIMA-EMPAQUE',
        'ALMACEN MATERIAS PRIMAS',
        'ALMACEN PRODUCTO TERMINADO',
        'BODEGA',
        'PRODUCTO TERMINADO',
        'BPM',
        'CAD',
        'CALDERAS',
        'COMPRAS',
        'CONTABILIDAD GENERAL  IMPUESTOS',
        'CONTABILIDAD GRAL E IMPT',
        'CONTROL AMBIENTAL',
        'CONTROL CALIDAD',
        'CONTROL PRODUCCION',
        'COSTOS Y PRESUPUESTOS',
        'FORMULACION',
        'GENTE Y CULTURA',
        'GERENCIA ADMIVA Y FINANCIERA',
        'GERENCIA GENERAL',
        'GERENCIA PLANTA',
        'INVESTIGACION Y DESARROLLO GEN',
        'JEFATURA DE PLANTA',
        'MEJORAMIENTO CONTINUO',
        'MICROBIOLOGIA',
        'MOD PLANTA',
        'MTTO INDUSTRIAL',
        'PLANEACION',
        'PROYECTOS',
        'PTARD',
        'PTARI',
        'RECICLAJE',
        'RECURSOS INFORMATICOS',
        'SERVICIOS ADMINISTRATIVOS',
        'SERVICIOS GENERALES PLANTA',
        'SIG Y SEGURIDAD',
        'SST',
        'TESORERIA'
    ];

    public $centros = [
        '721870',
        '731080',
        '111200',
        '731130',
        '121100',
        '731030',
        '731040',
        '111500',
        '111100',
        '731133',
        '111201',
        '731050',
        '731053',
        '731020',
        '731070',
        '511100',
        '731031',
        '731011',
        '731025',
        '731110',
        '111600',
        '731010',
        '731060',
        '731100',
        '111202',
        '111400',
        '111203',
        '110900',
        '731071',
        '731105',
        '111300',
        '731012',
        '731013',
        '111501',

    ];
}
