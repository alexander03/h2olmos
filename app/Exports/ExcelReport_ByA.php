<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

use App\Concesionaria;
use App\Equipo;
use App\Tipohora;
use App\Controldiario;
use DateTime;
use Exception;
use DB;

class ExcelReport_ByA implements FromView
{
    use Exportable;


    private $data = [], $row = -1, $col = -1, $max_row = -1, $max_col = -1;
    private $span_value = 'span_cell', $free_value = 'free_cell';
    private $start_date, $end_date, $equipo_ids;

    public function __construct(DateTime $start_date, DateTime $end_date, array $equipo_ids)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->equipo_ids = $equipo_ids;
    }

    private function nextRow($quantity = 1)
    {
        $this->row += $quantity;
        $this->col = -1;

        // defino la fila mas grande
        if ( $this->max_row < $this->row ) $this->max_row = $this->row;

        return $this;
    }
    private function nextCol($quantity = 1)
    {
        $this->col += $quantity;

        // En caso que no este vacia, busca la siguiente
        while ( isset($this->data[$this->row][$this->col]) && $this->data[$this->row][$this->col] != $this->free_value ) {
            $this->col++;
        }
        
        // defino la columna mas grande
        if ( $this->max_col < $this->col ) $this->max_col = $this->col;

        return $this;
    }
    private function nextCell(int $nRows = 1, int $nCols = 1)
    {
        $this->nextRow($nRows)->nextCol($nCols);

        return $this;
    }

    /**
     *  @method fixTable(). Esta funcion sirve para reparar un array $table y convertirlo en un table completa.
     *  @param string=>$table. Es el array que tiene los valores y tengo que evaluar para completarlo.
     *  @param int=>$nRows. Es la cantidad de filas que debe tener la tabla. Esta variable puede ser la longitud de la primera dimension de $table o lo puede definir el usuario.
     *  @param string=>$nCols. Es la cantidad de columnas que debe tener la tabla. Esta variable puede ser la mayor longitud de la segunda dimension de $table o lo puede definir el usuario.
     *  @return array. Retorna un array arreglado completado con $nRows filas y $nCols columnas.
     */
    private function fixTable(Array $table, int $nRows = 0, int $nCols = 0): ?Array
    {
        // En caso que el $table este vacio entonces regreso null
        if ( empty($table) ) throw new Exception('var $table is empty.');

        // Defino con mas exactitud las longitudes de las dimensiones del $table
        $nRows = count($table) > $nRows ? count($table) : $nRows; // Defino la maxima cantidad de filas
        foreach ($table as $row) if ( is_array($row) && count($row) > $nCols ) $nCols = count($row); // Defino la maxima cantidad de columnas

        // PRIMERA DIMENSION
        for ($i = 0; $i < $nRows; $i++) {
            // SI: el index $i no esta definido o es null entonces lo defino como array vacio para luego rellenarlo
            if ( !isset($table[$i]) || is_null($table[$i]) ) $table[$i] = [];
            // SI: en caso que sea un array
            else if ( is_array($table[$i]) ) {

                // SEGUNDA DIMENSION
                for ($j = 0; $j < count($table[$i]); $j++) {
                    // SI: el index $j es un array o es null entonces se elimina defrente
                    if ( is_array($table[$i][$j]) || is_null($table[$i][$j]) ) unset($table[$i][$j]);
                } unset($j);
                // En caso que se haya limpiado tengo que asegurarme que los indices mantienen el orden
                $table[$i] = array_merge($table[$i]);

            }
            // SINO: entonces defino el index $i como array para luego rellenarlo
            else $table[$i] = [$table[$i]];
            
            // Relleno las columnas que sean necesarias
            for ($j = count($table[$i]); $j < $nCols; $j++) $table[$i][$j] = "";
        } unset($i);

        // retorno el array arreglado en caso que tenga valores
        return $table;
    }

    /**
     * @method mergeTables(). Sirve para fusionar 2 tablas, ya sea de manera horizontal o vertical
     * @param array=>$tableHead. Tabla que ira primero.
     * @param array=>$tableBody. Table que ira ultima.
     * @param string=>$orientation. Orientacion que tendra la union. Ejemplo: ('v': union vertical), ('h': union horizontal)
     */
    private function mergeTables(array $tableHead = [], array $tableBody = [], string $orientation = 'v'): array
    {
        // Validamos que ninguno de los 2 este vacio
        if ( empty($tableHead) ) throw new Exception('$tableHead array is empty');
        if ( empty($tableBody) ) throw new Exception('$tableBody array is empty');

        // Reparo ambas tables para asegurarse que no existiran errores y tambien el $orientation
        $tableHead = $this->fixTable($tableHead);
        $tableBody = $this->fixTable($tableBody);
        
        // Verificamos la existencia de $orientation
        if ( $orientation == 'v' || $orientation == 'h') {
            $orientation = $orientation == 'v' ? 'v' : 'h';
        } else throw new Exception('Option from var $orientation don\'t found');

        // Fusionamos el $tableHead con el $tableBody de manera $orientation y los ponemos en $tableFinal
        $tableFinal = [];
        
        // SI: el tipo de orientacion es vertical entonces lo fusionamos verticalmente
        if ( $orientation == 'v' ) {
            // SI: la cantidad de columnas de $tableBody es mayor al de $tableHead entonces repararemos $tableHead
            if ( count($tableBody[0]) > count($tableHead[0]) ) {
                // Defino el $nCols como la cantidad de columnas del $tableBody
                $nCols = count($tableBody[0]);
                // Reparo el $tableHead
                $tableHead = $this->fixTable($tableHead, count($tableHead), $nCols);
            }
            // SINO: entonces repararemos $tableBody
            else {
                // Defino el $nCols como la cantidad de columnas del $tableHead
                $nCols = count($tableHead[0]);
                // Reparo el $tableBody
                $tableBody = $this->fixTable($tableBody, count($tableBody), $nCols);
            }
            
            // Fusionamos los datos del $tableHead con los del $tableBody verticalmente
            $tableFinal = array_merge($tableHead, $tableBody);
        }
        // SINO: entonces lo fusionamos horizontalmente
        else {
            // SI: la cantidad de filas de $tableBody es mayor al de $tableHead entonces repararemos $tableHead
            if ( count($tableBody) > count($tableHead) ) {
                // Defino el $nRows como la cantidad de filas del $tableBody
                $nRows = count($tableBody);
                // Reparo el $tableHead
                $tableHead = $this->fixTable($tableHead, $nRows);
            }
            // SINO: entonces repararemos $tableBody
            else {
                // Defino el $nRows como la cantidad de filas del $tableHead
                $nRows = count($tableHead);
                // Reparo el $tableBody
                $tableBody = $this->fixTable($tableBody, $nRows);
            }
            
            // Fusionamos los datos del $tableHead con los del $tableBody horizontalmente
            for ($i = 0; $i < $nRows; $i++) {
                $tableFinal[] = array_merge($tableHead[$i], $tableBody[$i]); // Fusionamos ambos indices de los arreglos
            } unset($i);
        }

        return $tableFinal;
    }

    /**
     * @method addTableHeaders(). Sirve para agregar los headers a una tabla.
     * @param array=>$tableHead. Es la tabla de donde estan todas las cabeceras y fusionaremos al $tableBody
     * @param array=>$tableBody. Es la tabla de datos a la cual le fusionaremos los headers.
     * @return array. Retorna la tabla fusionada con la cabecera
     */
    private function addTableHeaders(array $tableHead = [], array $tableBody = []): array
    {
        // Fusionamos los 2 tables
        return $this->mergeTables($tableHead, $tableBody, 'v');
    }

    /**
     *  @method format(). Esta funcion sirve para dar un arreglo con datos especificos y me devuelva un array con los datos ordenados como para mostrar en el excel.
     *  @param string|array=>$value. Son los datos que quiero ordenar para mostrar. El arreglo puede ser uni o bidireccional. Ejemplo => 'title1', ['title1', 'title2'], [['title1', 'title2'], 'title3']
     *  @param array=>$offset. Es contiene al oX y al oY, estas variables significan la cantidad de columnas o filas a dejar en blanco. Son relativos porque dependen de $trasposed. Ejemplo => ['oX' => 1, 'oY' => 3]
     *  @param boolean=>$trasposed. Esta variable indica si los datos del arreglo iran normal o de manera traspuesta. Ejemplo => true: traspuesta activada, false: traspuesta desactivada
     *  @param array=>$subData. Este array sera usado en el metodo format nuevamente.
     *  @return array. El arreglo de retorno se puede incluir normal en en array principal o en otro array.
     */
    private function formatTable($value, Array $attributes = []): ?Array
    {
        // 1) Defino los atributos para esta tabla
        // Defino los offsets
        $oRows = array_key_exists('oRows', $attributes) ? $attributes['oRows'] : 1; // Se define la longitud del offset de las filas, por defecto 1
        $oCols = array_key_exists('oCols', $attributes) ? $attributes['oCols'] : 1; // Se define la longitud del offset de las columnas, por defecto 1
        $trasposed = array_key_exists('trasposed', $attributes) ? $attributes['trasposed'] : false; // Se define si el array sera traspuesta o no, por defecto no
        $subData = array_key_exists('subData', $attributes) ? $attributes['subData'] : []; // Se define si existen subdatos que iran anexados a esta table, por defecto no

        // 2) Reparo y completo $value
        // SI: $value no es array entonces lo defino
        if ( !is_array($value) ) $value = [$value];
        // Limpiamos y arreglamos el array $value
        $value = $this->fixTable($value, $oRows, $oCols); // Limpio el array de imperfecciones
        if ( is_null($value) || empty($value) ) return []; // En caso que el array este vacio lo regreso de una vez
        $nRows = count($value); $nCols = count($value[0]); // Defino la cantidad real de filas y columnas respectivamente
        
        // 3) Fabricamos el $arrayHead
        // Fabricamos el arrayHead que contendra todos los datos ordenados del value
        $arrayHead = [];
        // SI: la $trasposed es verdadera entonces se hace la traspuesta del arreglo
        if ( $trasposed ) {
            // Iniciamos el proceso de la traspuesta de $value
            for ($i = 0; $i < $nCols; $i++) { 
                // Defino el index $i del $arrayHead en vacio
                $arrayHead[$i] = [];
                // Paso casa index $j de cada columna de $value a la columna $i de $arrayHead
                for ($j = 0; $j < $nRows; $j++) {
                    $arrayHead[$i][] = $value[$j][$i]; // Aqui sigo con algo de duda, espero entenderlo luego, pero es necesario cambiar el orden de $i $j
                } unset($j);
            } unset($i);
        }
        // SINO: solo tendra los valores que ya se encuentran en $value
        else $arrayHead = $value;
        
        // 4) Fabricamos el $arrayBody
        // Fabricamos el $arrayBody que contendra todos los subdatos del $arrayHead
        $arrayBody = [];
        // SI: el $subData es diferente de null y tiene almenos 1 dato
        if ( !is_null($subData) && !empty($subData) ) {
            for ($i = 0; $i < count($subData); $i++) { 
                // Ubico el index $i de $subdata en $newTable
                $newTable = $subData[$i];
                // Verifico que los datos existen
                if ( !isset($newTable['value']) ) $newTable['value'] = [];
                if ( !isset($newTable['offset']) ) $newTable['offset'] = [];
                if ( !isset($newTable['trasposed']) ) $newTable['trasposed'] = false;
                if ( !isset($newTable['subData']) ) $newTable['subData'] = [];
                // Formateo la nueva tabla
                $newTable = $this->formatTable($newTable['value'], [
                    'offset' => $newTable['offset'], 
                    'trasposed' => $newTable['trasposed'], 
                    'subData' => $newTable['subData']
                ]);
                // Fusiono esta tabla con el $arrayBody
                $arrayBody = array_merge($arrayBody, $newTable);
            } unset($i);
        }
        
        // 5) Fusionamos el $arrayHead con el $arrayBody
        // IF: se fabrico algun $arrayBody entonces lo fusiono con $arrayHead
        if ( !empty($arrayBody) ) $arrayFinal = $this->mergeTables($arrayHead, $arrayBody, 'h');
        // ELSE: entonces el $arrayFinal = $arrayHead
        else $arrayFinal = $arrayHead;
        
        // Retornamos el arreglo final
        return $arrayFinal;
    }



    private function set($row, $col, $value)
    {
        // defino el valor en el lugar
        if ( $value == $this->span_value ) {
            $this->data[$row][$col] = $this->span_value;
        } else if ( $value == $this->free_value ) {
            if ( !isset($this->data[$row][$col]) ) $this->data[$row][$col] = $this->free_value;
        } else {
            $this->data[$row][$col] = [];
            $this->data[$row][$col]['value'] = $value;
        }

        // hago existir los espacios libres
        if ( $value != $this->free_value ) {
            for ($r = 0; $r <= $row; $r++) { 
                for ($c = 0; $c <= $col; $c++) { 
                    $this->set($r, $c, $this->free_value);
                }
            }
        }

        // defino la fila y columna mas grande
        if ( $this->max_row < $row ) $this->max_row = $row;
        if ( $this->max_col < $col ) $this->max_col = $col;
    }

   

    /**
     *  @method add(). Sirve para agregar un valor o un array a la tabla principal.
     *  @param string|array=>$value. Si es un array, entonces se redigira a addTable() function, caso contrario se ira a addCell() function.
     *  @param array=>$attributes. Es un array que tendra todos los atributos o condiciones para agregar esta celda.
     */
    private function add($value = null, array $attributes = [])
    {
        // VALIDACIONES: si no han dado ningun valor entonces no se realiza nada
        if ( is_null($value) ) return;

        // SI: $value es cualquier otro valor menos array, entonces se agregara como celda
        if ( !is_array($value) ) $this->addCell(strval($value), $attributes);
        // SI: $value es array entonces se agregara como tabla
        else $this->addTable($value, $attributes);
    }

    /**
     *  @method addTable(). Esta funcion sirve para añadir una tabla secuencial de datos en un punto en especifico
     *  @param array=>$table. Este array contendra todos los datos para ser formateada;
     */
    private function addTable(array $table = [], array $attributes = [])
    {
        // Establesco la siguiente columna
        $this->nextCol();
        
        //Establesco los valores
        $nRow = $this->row;
        $nCol = $this->col;
        
        $this->setTable($table, $nRow, $nCol, $attributes);
    }

    private function setTable(array $table = [], int $nRow = 0, int $nCol = 0)
    {
        $table = $this->fixTable($table);

        // inicio con el posicionamiento de los datos
        for ($rRow = 0; $rRow < count($table); $rRow++) { 
            // SI: la fila es null entonces la defino como una
            if (is_null($table[$rRow])) $table[$rRow] = [];

            // SI: no es un array entonces lo defino como array
            else if ( !is_array($table[$rRow]) ) $table[$rRow] = [$table[$rRow]];

            for ($rCol = 0; $rCol < count($table[$rRow]); $rCol++) { 
                if ( !is_null($table[$rRow][$rCol]) && !is_array($table[$rRow][$rCol]) ) {
                    $this->set($nRow + $rRow, $nCol + $rCol, $table[$rRow][$rCol]);
                }
            } unset($rCol);
        } unset($rRow);
    }

    private function addCell(string $value = '', array $attributes = [])
    {
        // Siguiente columna
        $this->nextCol();

        $nRow = $this->row; // Se define el numero de fila como el numero de fila general
        $nCol = $this->col; // Se define el numero de columna como el numero de columna general

        // Agregar value
        $this->set($nRow, $nCol, $value);
        
        // Si no existen atributos en $attributes entonces no se realiza lo demas
        if ( empty($attributes) ) return; 
        
        // defino las variables a usar
        $sRow = array_key_exists('rowspan', $attributes) ? $attributes['rowspan'] : 1;
        $sCol = array_key_exists('colspan', $attributes) ? $attributes['colspan'] : 1;
        $use = array_key_exists('use', $attributes) ?  $attributes['use'] : true;
        // dd($sRow, $sCol, $use);
        $this->spanCell($nRow, $nCol, $sRow, $sCol, $use);
    }

    private function spanCell(int $nRow = -1, int $nCol = -1, int $sRow = 1, int $sCol = 1, bool $use = true)
    {
        // VALIDACION: SI: el $sRow y el $sCol son 1 entonces no se trabaja nada
        if ( ($sRow == 1 && $sCol == 1) || $nRow < 0 || $nCol < 0 ) return;

        // Si: se usa el span entonces en el blade se definiran los span, en el array los espacios seran llenados con 'span'
        if ( $use ) { // en caso que exista el use en span y sea true entonces se agrega el span
            if ( $sRow > 1 ) $this->data[$nRow][$nCol]['sRow'] = $sRow;
            if ( $sCol > 1 ) $this->data[$nRow][$nCol]['sCol'] = $sCol;
            
            for ($r = $nRow; $r < $nRow + $sRow; $r++) { 
                for ($c = $nCol; $c < $nCol + $sCol; $c++) { 
                    if ( $r != $nRow || $c != $nCol ) $this->set($r, $c, $this->span_value);
                }
            }
        }
        
        // SINO: no usamos el span entonces en el blade NO se definiran los span y en el array los espacios seran llenados con celdas vacias ['value' => '']
        else {
            for ($r = $nRow; $r < $nRow + $sRow; $r++) { 
                for ($c = $nCol; $c < $nCol + $sCol; $c++) { 
                    if ( $r != $nRow || $c != $nCol ) $this->set($r, $c, '');
                }
            }
        }
    }

    private function applyFunction(array $table, int $sRow, int $sCol): array
    {
        // FIRST: defino las nuevas longitudes del arreglo
        $nRows = count($table); // La cantidad de filas de la tabla
        $nCols = count($table[0]); // La cantidad de columnas de la tabla

        // SECOND: se crea la nueva fila, mientras se busca la posicion inicial
        $newRow = [];
        for ($i = 0; $i < $nCols; $i++) { 
            // IF: esta columna esta dentro del cuadro de la formula entonces se calcula el total
            if ( $i >= $sCol ) {
                $total = 0;
                for ($j = 0; $j < $nRows; $j++) {
                    // IF: esta fila esta dentro del cuadro de la formula entonces se calcula el total
                    if ( $j >= $sRow ) {
                        if ( $table[$j][$i] != '' ) $total += floatval($table[$j][$i]);
                    }
                } unset($j);
                $newRow[] = number_format($total, 2);
                unset($total);
            }
            // ELSE: se encuentra dentro del cuadro de la formula entonces solo se crea un espacio vacio
            else {
                if ( $i == 0 ) $newRow[] = 'Total general';
                else $newRow[] = '';
            }
        } unset($i);

        // THIRD: Se agrega la nueva columna a la tabla
        $table[] = $newRow;

        // FOURTH
        return $table;
    }

    private function loadData()
    {
        $concesionaria = Concesionaria::getConcesionariaActual();

        // Parte 1
        $this->nextCell()->add('MEDICIÓN DE ALQUILER DE EQUIPOS', ['colspan' => 12]);
        
        // Parte 2
        $this->nextCell(2)->add([['CONCESIONARIA:', $concesionaria->razonsocial]]);
        $this->nextCell()->add([['SUBCONTRATISTA:', '']]);
        $this->nextCell()->add([['PERIODO:', '(' . $this->start_date->format('d/m/Y') . ' AL ' . $this->end_date->format('d/m/Y') . ')']]);

        // Parte 3
        $this->nextCell(2);
        $this->add('CODIGO', ['rowspan' => 3]);
        $this->add('EQUIPO', ['rowspan' => 3]);
        $this->add('Dias de permanencia', ['rowspan' => 3]);
        $this->add('HORAS TRABAJADAS', ['rowspan' => 3]);
        $this->add('HORAS MANTENIMIENTO', ['rowspan' => 3]);
        $this->add('Horas minimas establecidas', ['rowspan' => 3]);
        $this->add('Horas minimas por derecho', ['rowspan' => 3]);
        $this->add('Horas minimas a pagar', ['rowspan' => 3]);
        $this->add('TOTAL HORAS A PAGAR', ['rowspan' => 3]);
        $this->nextCol()->add('RESPONSABLE POR EQUIPO', ['rowspan' => 3]);

        $summaryEquipos = $this->getSummaryEquipos();
        $this->nextCell(4)->add($summaryEquipos);
        $letRows = count($summaryEquipos);

        // Parte 4
        $header = $this->getEquiposHeader();
        $body = $this->formatTable($this->getEquipos());
        $table = $this->addTableHeaders($header, $body);
        $this->nextCell($letRows)->add($table);
        $letRows = count($table);
        
        // Parte 5
        $this->nextRow($letRows + 10);
        $this->nextCol()->add('_________________________________', ['colspan' => 4]);
        $this->nextCol()->add('_________________________________', ['colspan' => 4]);
        $this->nextCol()->add('_________________________________', ['colspan' => 4]);
        $this->nextRow();
        $this->nextCol()->add('ING. JOSE SALINAS', ['colspan' => 4]);
        $this->nextCol()->add('GUILLERMO CIPAGAUTA', ['colspan' => 4]);
        $this->nextCol()->add('REPRESENTANTE SUBCONTRATISTA', ['rowspan' => 2, 'colspan' => 4]);
        $this->nextRow();
        $this->nextCol()->add('GERENTE DE OPERACIONES Y MANTENIMIENTO', ['colspan' => 4]);
        $this->nextCol()->add('INGENIERÍA (Equipos)', ['colspan' => 4]);
    }

    private function getMonths()
    {
        setlocale(LC_TIME, 'es_ES');

        $months = [];
        $month = new DateTime($this->start_date->format('Y-m-d'));

        while ( $month <= $this->end_date ) {
            $new_month['name'] = substr(strtolower(strftime('%b', $month->getTimestamp())), 0, 3);
            
            $days = [];
            $day = new DateTime($month->format('Y-m-d'));
            while ( $day->format('m') == $month->format('m') && $day <= $this->end_date ) {
                $days[] = $day->format('d');
                $day->modify('+1 day');
            }
            
            $new_month['days'] = $days;
            $month = new DateTime($day->format('Y-m-d'));
            // $date = new DateTime(date('Y-m-d', strtotime($date->format('Y-m-d') . ' + 1 months')));

            $months[] = $new_month;
        }

        return $months;
    }

    private function getSummaryEquipos(): array
    {
        $startDate = $this->start_date->format('Y-m-d');
        $endDate = $this->end_date->format('Y-m-d');
        $thHorasMantenimiento_id = Tipohora::select('id')->where('descripcion', '=', 'horas mantenimiento')->first()['id'];

        $table = [];

        foreach ($this->equipo_ids as $equipo_id) {
            $equipo = Equipo::join('ua', 'ua.id', '=', 'equipo.ua_id')
                            ->join('controldiario', 'controldiario.equipo_id', '=', 'equipo.id')
                            ->select('ua.codigo', 'equipo.descripcion', DB::raw('COUNT(controldiario.id) AS dias_permanencia'))
                            ->where('equipo.id', '=', $equipo_id)
                            ->where('controldiario.fecha', '>=', $startDate)
                            ->where('controldiario.fecha', '<=', $endDate)
                            ->groupBy('ua.codigo', 'equipo.descripcion')->first();

            $codigo = $equipo['codigo'];
            $descripcion = $equipo['descripcion'];
            $dias_permanencia = $equipo['dias_permanencia'];

            $a = Controldiario::select(DB::raw('SUM(hora_total) AS a'))
                            ->where('equipo_id', '=', $equipo_id)
                            ->where('tipohora_id', '=', NULL)
                            ->where('fecha', '>=', $startDate)
                            ->where('fecha', '<=', $endDate)->first()['a'];
            $a = is_null($a) ? 0 : floatval($a);

            $b = Controldiario::select(DB::raw('SUM(hora_total) AS b'))
                            ->where('equipo_id', '=', $equipo_id)
                            ->where('tipohora_id', '=', $thHorasMantenimiento_id)
                            ->where('fecha', '>=', $startDate)
                            ->where('fecha', '<=', $endDate)->first()['b'];
            $b = is_null($b) ? 0 : floatval($b);
            
            $c = (120/31) * intval($dias_permanencia);

            $d = $c > $b ? $c - $b : 0;

            $e = $d > $a ? $d - $a : 0;

            $f = $a + $e;

            $responsable = 'Sin definir';

            $array = $this->formatTable([[
                $codigo, $descripcion, $dias_permanencia, number_format($a, 2), number_format($b, 2), number_format($c, 2), number_format($d, 2), number_format($e, 2), number_format($f, 2), '', $responsable
            ]], ['oRows' => 2]);

            if ( empty($table) ) {
                $table = $array;
            } else {
                $table = array_merge($table, $array);
            }
        }

        return $table;
    }
    
    private function getEquiposHeader(): array
    {
        $months = $this->getMonths();

        $array = ['CODIGO', 'DESC. EQUIPO', 'Tipo Hora'];

        foreach ($months as $month) {
            foreach ($month['days'] as $day) $array = array_merge($array, [$day . '-' . $month['name']]);
        }

        $array = array_merge($array, ['Total general']);

        return [$array];
    }

    private function getEquipos(): array
    {
        $start_date = $this->start_date->format('Y-m-d');
        $end_date = $this->end_date->format('Y-m-d');
        
        $table = [];

        foreach ($this->equipo_ids as $equipo_id) { 
            $equipo = Equipo::join('ua', 'equipo.ua_id', '=', 'ua.id')
                            ->join('controldiario', 'equipo.id', '=', 'controldiario.equipo_id')
                            ->select('ua.codigo AS codigo', 'equipo.descripcion AS descripcion')->distinct()
                            ->where('equipo.id', '=', $equipo_id)
                            ->where('controldiario.fecha', '>=', $start_date)
                            ->where('controldiario.fecha', '<=', $end_date)->first();

            $codigo = $equipo['codigo'];
            $descripcion = $equipo['descripcion'];

            $array = $this->formatTable([[$codigo, $descripcion]], ['subData' => $this->getTipoHora($equipo_id)]);

            if ( !empty($table) ) $table = array_merge($table, $array);
            else $table = $array;

        } unset($equipo_id);

        return $table;
    }

    private function getTipoHora($equipo_id): array
    {
        $start_date = $this->start_date->format('Y-m-d');
        $end_date = $this->end_date->format('Y-m-d');

        $dbTipoHora = TipoHora::rightJoin('controldiario', 'tipohora.id', '=', 'controldiario.tipohora_id')
                            ->select('tipohora.id AS id', 'tipohora.descripcion AS descripcion')->distinct()
                            ->where('controldiario.equipo_id', '=', $equipo_id)
                            ->where('controldiario.fecha', '>=', $this->start_date->format('Y-m-d'))
                            ->where('controldiario.fecha', '<=', $this->end_date->format('Y-m-d'))->get();
        
        $array = [];
        // dd($dbTipoHora);
        for ($i = 0; $i < count($dbTipoHora); $i++) { 
            $tipohora_id = $dbTipoHora[$i]['id'];
            $descripcion = mb_strtoupper($dbTipoHora[$i]['descripcion'], 'utf-8');

            $array[] = [
                'value' => is_null($descripcion) ? 'Horas trabajadas' : $descripcion,
                'subData' => $this->getControlDiario($equipo_id, $tipohora_id)
            ];
        } unset($i);

        return $array;
    }

    private function getControlDiario($equipo_id, $tipohora_id): array
    {
        $start_date = $this->start_date->format('Y-m-d');
        $end_date = $this->end_date->format('Y-m-d');

        $dbControl = Controldiario::select('id', 'fecha', 'hora_total')
                                ->where('equipo_id', '=', $equipo_id)
                                ->where('tipohora_id', '=', $tipohora_id)
                                ->where(function ($query) use ($start_date, $end_date) {
                                    $query->where('controldiario.fecha', '>=', $start_date)
                                        ->where('controldiario.fecha', '<=', $end_date);
                                })->orderBy('fecha', 'ASC')->get();
        
        $value = [];
        $total_general = 0;
        $date = new DateTime($start_date);
        
        while ( $date <= $this->end_date ) {
            $control = null;

            for ($i = 0; $i < count($dbControl); $i++) { 
                if ( $dbControl[$i]['fecha'] == $date->format('Y-m-d') ) {
                    $control = floatval($dbControl[$i]['hora_total']); break;
                }
            }

            $value[] = is_null($control) ? '' : number_format($control, 2);

            $total_general += is_null($control) ? 0 : $control;

            $date->modify('+1 day');
        }
        
        $value[] = number_format($total_general, 2);

        return [
            [
                'value' => $value,
                'trasposed' => true
            ]
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $this->loadData();

        return view('app.controldiario.exports.excelReports.ByA', [
            'data' => $this->data,
            'max_row' => $this->max_row,
            'max_col' => $this->max_col,
            'span_value' => $this->span_value,
            'free_value' => $this->free_value
        ]);
    }
}