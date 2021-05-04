<?php
namespace App\Models;
use CodeIgniter\Model;

class DetalleModel extends Model{
    protected $table = 'detalles'; // tabla en BD
    protected $allowedFields = ['id', 'servicios_id', 'costo', 'cantidad', 'created','modified', 'reparaciones_id'];

    public function insertar($data){
       return $this->insert($data);
    }
}

