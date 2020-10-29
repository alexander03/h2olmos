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
                            <td class="text-center text-bold">CANTIDAD (HORA)</td>
                            <td class="text-center text-bold">VALOR UNITARIO (US$)</td>
                            <td class="text-center text-bold">SUBTOTAL (US$)</td>
                        </tr>
                        <tr class="table-borderless"><td class="table-borderless" style="height: 5px;"></td></tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($listSummaryEquipos as $equipo)

                        <tr>
                            <td class="text-center text-bold" style="height: 30px;">{{ $equipo['codigo'] }}</td>
                            <td class="text-center text-bold">{{ $equipo['descripcion'] }}</td>
                            <td class="text-center text-bold">{{ $equipo['cantidad'] }}</td>
                            <td class="text-center text-bold">{{ $equipo['valorUnitario'] }}</td>
                            <td class="text-center text-bold">{{ $equipo['subtotal'] }}</td>
                        </tr>
                        <tr class="table-borderless"><td class="table-borderless" style="height: 5px;"></td></tr>

                        @endforeach

                    </tbody>
                    <tFoot class="table-borderless">
                        <tr>
                            <td colspan="3" class="table-borderless"></td>
                            <td class="text-center text-bold">SUBTOTAL</td>
                            <td class="text-center text-bold">{{ "\$$subtotal" }}</td>
                        </tr>
                    </tFoot>
                </table>

            </td>
            <td class="table-borderless" style="width: 5px;"></td>
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
                    <tFoot>
                        <tr class="table-borderless">
                            <td class="table-borderless"></td>
                        </tr>
                    </tFoot>
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
                        <td class="text-center text-bold table-borderless">SAYRA MONJA</td>
                        <td rowspan="2" class="text-center text-bold table-borderless">REPRESENTANTE SUBCONTRATISTA</td>
                    </tr>
                    <tr class="table-borderless">
                        <td class="text-center text-bold table-borderless">GERENTE DE OPERACION Y MANTENIMIENTO</td>
                        <td class="text-center text-bold table-borderless">COSTOS</td>
                    </tr>
                </table>

            </td>
        </tr>
        
    </table>
</body>
</html>