<?php

namespace App\Exports;

use DateTime;
use App\Ua;
use App\Controldiario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ReportHrsEquiposUas implements FromCollection, WithHeadings
{
    
    //Fecha más antigua
	private $fecha1;
    //Fecha más reciente
	private $fecha2;

	private $concesionaria;

    private $filaBase;
//    private $dias;

	public function __construct($fecha1,$fecha2,$concesionaria)
    {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
        $this->concesionaria = $concesionaria;

        $base  = [
            '',
            '',
            '',
            ''
        ];

        $fechas = [];
//        $dias = 0;
        while($fecha1 != $fecha2){
            
            $fechas[] = 0;
//            $dias++;
            $fecha1 = date("Y-m-d",strtotime($fecha1."+ 1 day"));
        }
        $fechas[] = 0;
//        $dias++;

//        $this->dias = $dias;
        $this->filaBase =  array_merge($base,$fechas);
        
       
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {


        $fechaInicio = $this->fecha1;
        $fechaFin = $this->fecha2;
        $info = Ua::where('concesionaria_id',$this->concesionaria)
                ->whereHas('controlesdiarios', function($q) use($fechaInicio, $fechaFin){
                    $q->whereBetween('fecha',[$fechaInicio,$fechaFin])->where('hora_total','!=',null);
            	})->select('ua.id','ua.codigo','ua.descripcion')
        		->with(['equipos' => function($q) use($fechaInicio, $fechaFin){
        			$q->select('equipo.id','equipo.descripcion' ,'equipo.ua_id' )->with('ua:id,codigo');
/*        			->with(['controlesdiarios' => function($q) use($fechaInicio, $fechaFin){
        				$q->select('controldiario.id','controldiario.fecha','controldiario.hora_total','controldiario.ua_id', 'controldiario.equipo_id')->where('controldiario.ua_id','=','"UA CODIGO"')
        				->whereBetween('controldiario.fecha',[$fechaInicio,$fechaFin]);
        			}]);
*/;
        		}])->get();


        $collection = collect([]);
        $fechaInicio = $this->fecha1;
        $fechaFin = $this->fecha2;

        //filas de sumas
        $sumas_uas = [];

        //generar tabla
        foreach ($info as $FragUa) {
            //tabla para una Ua
            $HorasUa = collect([]);
            

            $fila = $this->filaBase;
            $fila[0] = $FragUa->codigo;
            $fila[1] = $FragUa->descripcion;
            $fila[2] = $FragUa->equipos[0]->ua->codigo;
            $fila[3] = $FragUa->equipos[0]->descripcion;

            $reglas = [];
            $reglas[] = ['ua_id',$FragUa->id];
            $reglas[] = ['equipo_id',$FragUa->equipos[0]->id];
            $reglas[] = ['hora_total','!=',null];

            $controles = Controldiario::whereBetween('controldiario.fecha',[$fechaInicio,$fechaFin])
                            ->where($reglas)->select('id','hora_total','fecha')->get();
            
            //Fecha de donde inicia a contar
            $fechaInicioDatatime = new DateTime($fechaInicio);

            //Acumulación de horas
            $TotalPorEquipo=0;
            //Agrega datos a la fila del equipo
            foreach ($controles as $control) {
                $fechaFinDatatime = new DateTime($control->fecha);
                $diff = $fechaInicioDatatime->diff($fechaFinDatatime);

                //inserta la hora en el día
                $fila[$diff->days + 4] +=  $control->hora_total;
                $TotalPorEquipo += $control->hora_total;
            }


            $fila[count($fila)  ] = $TotalPorEquipo;
            //$fila->take( -count($fila) + 4)->sum();

            //Agrega la primera fila de la tabla
            $HorasUa->offsetSet(0,$fila);

            //revisa el resto de equipos
            if( count($FragUa->equipos) >= 1 ){
                for($valor = 1 ; $valor < count($FragUa->equipos) ; $valor++){

                    //Acumulación de horas
                    $TotalPorEquipo=0;
                    $fila = $this->filaBase;

                    $reglas = [];
                    $reglas[] = ['ua_id',$FragUa->id];
                    $reglas[] = ['equipo_id',$FragUa->equipos[$valor]->id];
                    $reglas[] = ['hora_total','!=',null];
                    $controles = Controldiario::whereBetween('controldiario.fecha',[$fechaInicio,$fechaFin])
                            ->where($reglas)->select('id','hora_total','fecha')->get();
                    
                    $fila[2] = $FragUa->equipos[$valor]->ua->codigo;
                    $fila[3] = $FragUa->equipos[$valor]->descripcion;

                    //Agrega datos a la fila del equipo
                    foreach ($controles as $control) {
                        $fechaFinDatatime = new DateTime($control->fecha);
                        $diff = $fechaInicioDatatime->diff($fechaFinDatatime);

                        //inserta la hora en el día
                        $fila[$diff->days + 4] +=  $control->hora_total;
                        $TotalPorEquipo += $control->hora_total;

                    }
                    $fila[count($fila)  ] = $TotalPorEquipo;
                    //$fila->take( -count($fila) + 4)->sum();
                    $HorasUa->offsetSet($valor,$fila);     
                }

            }

            //SUMA TOTAL POR UA
            $suma = $this->filaBase;
            $suma[0] = 'TOTAL ' . $FragUa->codigo;
            $cols = count($suma);
            for($columna = 4; $columna <= $cols ; $columna++){
                $suma[$columna] = $HorasUa->sum($columna);
            }

            $HorasUa->offsetSet($valor,$suma);  
            
            //Ingreso de los datos a la tabla final
            $collection = $collection->merge($HorasUa);

            $sumas_uas[] = count($collection) - 1;

           
          
        }


        $SumaGeneral = $this->filaBase;
        $SumaGeneral[0] = 'TOTAL GENERAL';
        $cols = count($SumaGeneral);
        for($columna = 4; $columna <= $cols ; $columna++){
            //suma de las horas totales de cada ua por día
            $sumafila = 0;
            foreach ($sumas_uas as $fila) {

                $sumafila += $collection[$fila][$columna];
            }


            $SumaGeneral[$columna] = $sumafila;

        }
        
        $collection->offsetSet( count($collection) ,$SumaGeneral);

        return $collection;

    }

    public function headings(): array{
        $base  = [
            'UA',
            'Descripción',
            'Código',
            'Descripción Equipo'
        ];

        $fechaInicio = $this->fecha1;
        $fechaFin = $this->fecha2;

        $fechas = [];

        while($fechaInicio != $fechaFin){
        	
        	$fechas[] = $fechaInicio;

        	$fechaInicio = date("Y-m-d",strtotime($fechaInicio."+ 1 day"));
        }
        $fechas[] = $fechaInicio;

        $fechas[] = 'Total';

        $head = array_merge($base,$fechas);

        
        return  $head;
    }


}
