<!DOCTYPE html>
<html lang="es">
<head>
    <title>{{ $namefile }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
    <style type="text/css">
        body{
            font-size: 8px;
            font-family: "Arial";
        }
        table{
            border-collapse: collapse;
            border: 2px;
        }
        tr{
            border-collapse: collapse;
            border: 2px solid;
        }
        td{
            border-collapse: collapse;
            border: 2px solid;
            height: 19px;
        }
        span{
            font-weight: normal;
        }
        .table-bordered{
            border-collapse: collapse;
            border: 2px solid; 
        }
        .table-borderless{
            border-collapse: collapse;
            border: none;
        }
        .table-borderlight{
            border-collapse: collapse;
            border: 0.5px;
        }
        .bg-blue{
            background-color: #0070c0;
        }
        .h1{
            font-size: 16px;
        }
        .h2{
            font-size: 14px;
        }
        .h3{
            font-size: 12px;
        }
        .text-danger{
            color: red;
        }
        .text-primary{
            color: blue;
        }
        .text-top{
            vertical-align: text-top;
        }
        .text-center{
            text-align: center;
        }
        .text-white{
            color: white;
        }
        .text-bold{
            font-weight: bold;
        }
        .fsize{
            font-size: 8px;
        }
        .text-normal{
            font-weight: normal;
        }
    </style>
</head>
<body>
    <table width="100%">
        
        <tr class="table-borderless">
            <td class="table-borderless" colspan="3">
                
                <table width="100%">
                    <tr>
                        <td width="20%" class="text-center table-borderless">
                            <img src="{{ asset('/assets/img/logo-main.png') }}" width="130" height="70">
                        </td>
                        <td width="60%" class="text-center table-borderless">
                            <h1>MEDICIÓN DE ALQUILER DE EQUIPOS</h1>
                        </td>
                        <td width="20%" class="table-borderless"></td>
                    </tr>
                </table>

            </td>
        </tr>

        <tr class="table-borderless">
            <td class="table-borderless" colspan="3">
                
                <table width="70%" class="table-borderless">
                    <tr class="table-borderless">
                        <td width="30%" class="text-left table-borderless text-bold h3">CONCESIONARIA:</td>
                        <td width="70%" class="text-left table-borderless text-bold h3 text-danger">H2Olmos S.A.</td>
                    </tr>
                    <tr class="table-borderless">
                        <td width="30%" class="text-left table-borderless text-bold h3">SUBCONTRATISTA:</td>
                        <td width="70%" class="text-left table-borderless text-bold h3 text-danger">B&A CONTRATISTAS Y TRANSP. GENERALES S.A.C.</td>
                    </tr>
                    <tr class="table-borderless">
                        <td width="30%" class="text-left table-borderless text-bold h3">PERIODO:</td>
                        <td width="70%" class="text-left table-borderless text-bold h3 text-danger">{{ $periodo }}</td>
                    </tr>
                </table>

            </td>
        </tr>

        <tr class="table-borderless">
            <td class="table-borderless">
                
                <table width="100%">
                    <thead>
                        <tr>
                            <td class="text-center text-bold" style="height: 50px;">CODIGO</td>
                            <td class="text-center text-bold">EQUIPO</td>
                            <td class="text-center text-bold">Dias de permanencia</td>
                            <td class="text-center text-bold text-primary">HORAS TRABAJADAS</td>
                            <td class="text-center text-bold text-danger">HORAS MANTENIMIENTO</td>
                            <td class="text-center text-bold">Horas minimas establecidas</td>
                            <td class="text-center text-bold">Horas minimas por derecho</td>
                            <td class="text-center text-bold">Horas minimas a pagar</td>
                            <td class="text-center text-bold">TOTAL HORAS A PAGAR</td>
                        </tr>
                        <tr class="table-borderless"><td class="table-borderless" style="height: 5px;"></td></tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($listSummaryEquipos as $equipo)

                        <tr>
                            <td class="text-center text-bold" style="height: 30px;">{{ $equipo['codigo'] }}</td>
                            <td class="text-center text-bold">{{ $equipo['descripcion'] }}</td>
                            <td class="text-center text-bold">{{ $equipo['dias_permanencia'] }}</td>
                            <td class="text-center text-bold text-primary">{{ $equipo['a'] }}</td>
                            <td class="text-center text-bold text-danger">{{ $equipo['b'] }}</td>
                            <td class="text-center text-bold">{{ $equipo['c'] }}</td>
                            <td class="text-center text-bold">{{ $equipo['d'] }}</td>
                            <td class="text-center text-bold">{{ $equipo['e'] }}</td>
                            <td class="text-center text-bold">{{ $equipo['f'] }}</td>
                        </tr>
                        <tr class="table-borderless"><td class="table-borderless" style="height: 5px;"></td></tr>

                        @endforeach

                    </tbody>
                </table>

            </td>
            <td class="table-borderless">&nbsp;</td>
            <td class="table-borderless">

                <table width="100%">
                    <thead>
                        <tr>
                            <td class="text-center text-bold text-primary" style="height: 50px;">RESPONSABLE</td>
                        </tr>
                        <tr class="table-borderless"><td class="table-borderless" style="height: 5px;"></td></tr>
                    </thead>
                    <tbody>
                        @foreach ($listSummaryEquipos as $equipo)

                        <tr>
                            <td class="text-center text-bold text-primary" style="height: 30px;">{{ $equipo['responsable'] }}</td>
                        </tr>
                        <tr class="table-borderless"><td class="table-borderless" style="height: 5px;"></td></tr>

                        @endforeach
                    </tbody>
                </table>

            </td>
        </tr>

        <tr class="table-borderless">
            <td class="table-borderless" colspan="3">
                
                <table width="100%">
                    @for ($r = 0; $r <= $max_row; $r++)
                        @if ( isset($listEquipos[$r]) )
                            <?php $row = $listEquipos[$r] ?>
                            <tr>
                                @for ($c = 0; $c <= $max_col; $c++)
                                    @if ( isset($row[$c]) )
                                        <?php $col = $row[$c] ?>
                                        @if ( $col == $free_value )
                                            <td></td>
                                        @elseif ( isset($col['value']) )
                                            <td class="text-bold"
                                                @if (array_key_exists('sRow', $col)) rowspan="{{ $col['sRow'] }}" @endif 
                                                @if (array_key_exists('sCol', $col)) colspan="{{ $col['sCol'] }}" @endif
                                                >
                                                {{ $col['value'] }}
                                            </td>
                                        @endif
                                    @endif
                                @endfor
                            </tr>
                        @endif
                    @endfor
                </table>

            </td>
        </tr>

        <tr class="table-borderless">
            <td class="table-borderless" colspan="3">
                
                <table width="100%" class="table-borderless">
                    <tr class="table-borderless">
                        <td class="text-bold text-center text-normal table-borderless" width="33%" style="vertical-align: bottom; height: 120px;">_______________________________</td>
                        <td class="text-bold text-center text-normal table-borderless" width="34%" style="vertical-align: bottom;">_______________________________</td>
                        <td class="text-bold text-center text-normal table-borderless" width="33%" style="vertical-align: bottom;">_______________________________</td>
                    </tr>
                    <tr class="table-borderless">
                        <td class="text-center text-bold table-borderless">ING. JOSE SALINAS</td>
                        <td class="text-center text-bold table-borderless">GUILLERMO CIPAGAUTA</td>
                        <td rowspan="2" class="text-center text-bold table-borderless">REPRESENTANTE SUBCONTRATISTA</td>
                    </tr>
                    <tr class="table-borderless">
                        <td class="text-center text-bold table-borderless">GERENTE DE OPERACION Y MANTENIMIENTO</td>
                        <td class="text-center text-bold table-borderless">INGENIERIA (equipos)</td>
                    </tr>
                </table>

            </td>
        </tr>
        
    </table>
</body>
</html>