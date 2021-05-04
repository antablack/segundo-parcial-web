<?php
namespace App\Models;
use CodeIgniter\Model;

class ServicioModel extends Model {
    
    protected $table = 'servicios'; // tabla en BD
    protected $allowedFields = ['id', 'descripcion', 'precio'];

    public function getData($id = null){
        if ($id == null)
        {
            return $this->findAll();
        }
        return $this->where('id', $id)->first();
    }

}