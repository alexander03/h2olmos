<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\RegRepVeh;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\Sheet;

class RegRepVehExportExcel implements FromCollection, WithHeadings, WithEvents{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(){
        
        
        $resultQuery = RegRepVeh::select('repuesto.descripcion as DESCRIPCION','unidad.descripcion as UM','descripcionregrepveh.cantidad as CANTIDAD','descripcionregrepveh.monto AS COSTO','regrepveh.tipomantenimiento AS TIPOMANTENIMIENTO','descripcionregrepveh.monto AS COSTO','ua.codigo AS UA','regrepveh.fecharegistro AS FECHAMANTENIMIENTO','regrepveh.kmman AS KMMANTENIMIENTO','regrepveh.kminicial AS KMINICIAL','regrepveh.kmfinal AS KMFINAL','vehiculo.modelo AS UNIDAD','vehiculo.placa AS PLACA')
            -> join('descripcionregrepveh', 'regrepveh.id', '=', 'descripcionregrepveh.regrepveh_id')
            -> join('vehiculo', 'vehiculo.id', '=', 'regrepveh.ua_id')
            -> join('ua', 'ua.id', '=', 'vehiculo.ua_id')
            -> join('repuesto', 'repuesto.id', '=', 'descripcionregrepveh.repuesto_id')
            -> join('unidad', 'unidad.id', '=', 'repuesto.unidad_id')
            -> whereNull('regrepveh.deleted_at')
            -> get();

        $newResult = [];
        $arrId = [];
       
        for($i = 0; $i < count($resultQuery); $i++) { 
        if($resultQuery[$i]->TIPOMANTENIMIENTO==1)$resultQuery[$i]->TIPOMANTENIMIENTO='PREVENTIVO';
        if($resultQuery[$i]->TIPOMANTENIMIENTO==2)$resultQuery[$i]->TIPOMANTENIMIENTO='CORRECTIVO';
        $resultQuery[$i]->COSTO=$resultQuery[$i]->COSTO*$resultQuery[$i]->CANTIDAD;
        array_push($newResult, $resultQuery[$i]);
            
        }

        for($i = 0; $i < count($newResult); $i++) unset($newResult[$i] -> id);
        $collectionResult = collect($newResult);

        

        return $collectionResult;
        //return $resultQuery;
    }

    public function headings(): array{
        return [
            'DESCRIPCION',
            'UM',
            'CANTIDAD',
            'COSTO',
            'TIPOMANTENIMIENTO',
            'UA',
            'FECHAMANTENIMIENTO',
            'KMMANTENIMIENTO',
            'KMINICIAL',
            'KMFINAL',
            'UNIDAD',
            'PLACA'
        ];
    }

    public function registerEvents(): array{
        
        return [
            AfterSheet::class => function(AfterSheet $event) {
                
                $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
                'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X',
                'Y', 'Z'];
                
                foreach($letters as $letter){
                    $event->sheet->getColumnDimension($letter)->setAutoSize(true);
                    
                }
                
                
            }
        ];
    }       
}
