<?php
require_once '../config/database.php';
require_once '../models/PlanOperativo.php';

class PlanOperativoController {
    private $db;
    private $plan;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->plan = new PlanOperativo($this->db);
    }

    public function crearPlan($elaborado, $responsable) {
        $this->plan->nombre_elaborado = $elaborado;
        $this->plan->nombre_responsable = $responsable;
        return $this->plan->create();
    }

    public function listarPlanes() {
        return $this->plan->read();
    }

    public function obtenerPlan($id) {
        return $this->plan->getById($id);
    }

    public function actualizarPlan($data) {
        $this->plan->id = $data['id'];
        $this->plan->nombre_elaborado = $data['nombre_elaborado'];
        $this->plan->nombre_responsable = $data['nombre_responsable'];
        $this->plan->elaboracion_estado = $data['elaboracion_estado'];
        $this->plan->elaboracion_contenido = $data['elaboracion_contenido'];
        $this->plan->seguimiento_estado = $data['seguimiento_estado'];
        $this->plan->seguimiento_contenido = $data['seguimiento_contenido'];
        $this->plan->ejecucion_estado = $data['ejecucion_estado'];
        $this->plan->ejecucion_contenido = $data['ejecucion_contenido'];
        return $this->plan->update();
    }

    public function eliminarPlan($id) {
        $this->plan->id = $id;
        return $this->plan->delete();
    }

    public function toggleEstado($id, $tipo) {
        if($this->plan->getById($id)) {
            switch($tipo) {
                case 'elaboracion':
                    $this->plan->elaboracion_estado = !$this->plan->elaboracion_estado;
                    break;
                case 'seguimiento':
                    $this->plan->seguimiento_estado = !$this->plan->seguimiento_estado;
                    break;
                case 'ejecucion':
                    $this->plan->ejecucion_estado = !$this->plan->ejecucion_estado;
                    break;
            }
            return $this->plan->update();
        }
        return false;
    }
}
?>