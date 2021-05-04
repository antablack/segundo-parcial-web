<?php

namespace App\Controllers;

use App\Models\ReparacionModel;
use App\Models\ClienteModel;
use App\Models\VehiculoModel;
use App\Models\ServicioModel;
use App\Models\DetalleModel;
use PdfReparaciones;

class Reparaciones extends BaseController
{
    protected $modelReparacione;

    protected $modelCliente;

    public function __construct()
    {
        $this->modelReparacion = new ReparacionModel(); //creo objeto modelo
        $this->modelCliente = new ClienteModel();
        $this->modelVehiculo = new VehiculoModel();
        $this->modelServicio = new ServicioModel();
        $this->modelDetalle = new DetalleModel();
        $this->session = session();
    }

    public function index()
    {
        $data['clientes'] = $this->modelCliente->getData();
        $data['clienteId'] = isset($_GET['cliente']) ? $_GET['cliente'] : '';
        $data['vehiculos'] = !empty($data['clienteId']) ? $this->modelVehiculo->getVehiculosxCliente($data['clienteId']) : [];
        $data['titulo'] = '<center>Reparaciones</center>';
        $data['contenido'] = 'reparacion/index';
        return view('welcome_message', $data);
    }

    public function listapdf($id)
    {
        $pdf = new PdfReparaciones();
        $pdf->SetMargins(PDF_MARGIN_LEFT, 30, PDF_MARGIN_RIGHT);
        $pdf->Addpage();
        $reparaciones = $this->modelReparacion->getData($id);

        $i = 0;
        do {
            $reparacion = $reparaciones[$i];
            $i++;
            $html = '
        <style>
            td, th {
                padding: 0px 10px;
            }
        </style>
    
        <table cellspacing="0">
            <tr >
                <td style="background-color: #ffd5bc;font-weight: bold;">
                    Reparacion No
                </td>
                <td style="font-weight: bold;">
                    ' . $reparacion["id"] . '
                </td>
                <td>
                    Fecha
                </td>
                <td>
                    ' . $reparacion["fecha"] . '
                </td>
            </tr>
            <tr>
                <td style="background-color: #ffd5bc;font-weight: bold;">
                    Cliente
                </td>
                <td colspan="3" style="font-weight: bold;">
                    ' . $reparacion["nombre_cliente"] . '
                </td>
            </tr>
            <tr>
                <td style="background-color: #ffd5bc;font-weight: bold;">
                    Conductor
                </td>
                <td colspan="3" style="font-weight: bold;font-weight: bold;">
                    ' . $reparacion["nombre_conductor"] . '
                </td>
            </tr>
            <tr>
                <td style="background-color: #ffd5bc;font-weight: bold;">
                    Dirección cliente
                </td>
                <td colspan="3">
                    ' . $reparacion["direccion"] . '
                </td>
            </tr>
            <tr>
                <td style="background-color: #ffd5bc;font-weight: bold;">
                    Teléfono
                </td>
                <td colspan="3">
                    ' . $reparacion["telefono"] . '
                </td>
            </tr>
            <tr>
                <td style="background-color: #ffd5bc;font-weight: bold;">
                    Email            
                </td>
                <td colspan="3">
                    ' . $reparacion["correo"] . '
                </td>
            </tr>
        </table>';


            $html = $html . '<table border="1">
            <thead>
                <tr>
                    <td colspan="5" style="text-align: center; font-style: italic; font-weight: bold;">Detalles de la reparación</td>
                </tr>
                <tr style="background-color:#d1bfa2;color:#000000; font-weight: bold;">
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            
            <tbody>';

            $reparacionDetalle = $this->modelReparacion->getDetalle($reparacion["id"]);
            $total = 0;
            foreach ($reparacionDetalle as $detalle) {
                $total += (int)$detalle["costo"];

                $html = $html . '
                <tr>
                    <td>' . $detalle["id"] . '</td>
                    <td>' . $detalle["descripcion"] . '</td>
                    <td>' . (string)$detalle["precio"] . '</td>
                    <td>' . (string)$detalle["cantidad"] . '</td>
                    <td>' . (string)$detalle["costo"] . '</td>
                </tr>
                ';
            }


            $html = $html . '
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
        </table>';




            $html .= '<table>
            <tr style="font-weight: bold;">
                <td >TOTAL</td>
                <td></td>
                <td style="text-align: right;">$' . $total . '</td>
            </tr>
        </table>
        ';
            $pdf->writeHTML($html, true, false, true, false, '');
            //echo $i;
            //echo count($reparaciones);
            if ($i < (count($reparaciones))) {
                $pdf->AddPage();
            }
        } while ($i < count($reparaciones));

        $this->response->setHeader("Content-Type", "application/pdf");
        $pdf->Output('Listado_vehiculos.pdf', 'I');
    }

    public function crear()
    {
        $detalles = $this->session->get('detalle') ? $this->session->get('detalle') : [];
        if ($this->request->getPost('btnCancelar') || $this->request->getPost('btnEnviar')) {

            if ($this->request->getPost('btnEnviar')) {
                $total = 0;
                foreach ($detalles as $detalle) {
                    $total += $detalle["precio"];
                }
                $data = [
                    "fecha" => $this->request->getPost('fecha'),
                    "costo" => $total,
                    "observacion" => $this->request->getPost('observacion'),
                    "vehiculos_id" => $this->request->getPost('vehiculo')
                ];
                $reparacionId = $this->modelReparacion->insertar($data);
                foreach ($detalles as $detalle) {
                    $detalle = [
                        "servicios_id" => $detalle['id'],
                        "costo" => $detalle['precio'],
                        "cantidad" => $detalle['cantidad'],
                        "reparaciones_id" => $reparacionId
                    ];
                    $this->modelDetalle->insertar($detalle);
                }
            }

            $this->session->destroy();
            return redirect()->to(site_url('reparaciones/crear'));
        }

        $data["detalles"] = $detalles;
        $data["vehiculos"] = $this->modelVehiculo->getData();
        $data["servicios"] = $this->modelServicio->getData();
        $data["contenido"] = 'reparacion/crear';
        $data["vehiculoId"] = $this->request->getPost('vehiculo');
        $data["fecha"] = $this->request->getPost('fecha');
        $data["observacion"] = $this->request->getPost('observacion');
        $data["servicioId"] = $this->request->getPost('servicio');
        $data["cantidad"] = $this->request->getPost('cantidad');
        $data["precio"] = $this->request->getPost('precio');
        

        if ($this->request->getPost('btnPrecio') || $this->request->getPost('btnAdd')) {
            $servicio = $this->modelServicio->getData($data["servicioId"]);
            $data["precio"] = (int) $data["cantidad"] * (int) $servicio['precio'];
        }

        if ($this->request->getPost('btnAdd')) {
            $servicio = $this->modelServicio->getData($data["servicioId"]);
            array_push($data["detalles"], array("id" => $data["servicioId"], "servicio" => $servicio["descripcion"], "precio" => $data["precio"], "cantidad" => $data["cantidad"]));
            $this->session->set('detalle', $data["detalles"]);
        }

        $data["total"] = 0;
        foreach ($data["detalles"] as $detalle) {
            $data["total"] += $detalle["precio"];
        }

        return view('welcome_message', $data);
    }
}
