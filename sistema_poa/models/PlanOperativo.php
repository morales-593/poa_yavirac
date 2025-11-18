<?php
class PlanOperativo {
    private $conn;
    private $table_name = "plan_operativo";

    public $id;
    public $nombre_elaborado;
    public $nombre_responsable;
    public $elaboracion_estado;
    public $elaboracion_contenido;
    public $seguimiento_estado;
    public $seguimiento_contenido;
    public $ejecucion_estado;
    public $ejecucion_contenido;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nombre_elaborado=:nombre_elaborado, 
                      nombre_responsable=:nombre_responsable,
                      elaboracion_estado=0,
                      seguimiento_estado=0,
                      ejecucion_estado=0";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nombre_elaborado", $this->nombre_elaborado);
        $stmt->bindParam(":nombre_responsable", $this->nombre_responsable);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre_elaborado=:nombre_elaborado, 
                      nombre_responsable=:nombre_responsable,
                      elaboracion_estado=:elaboracion_estado,
                      elaboracion_contenido=:elaboracion_contenido,
                      seguimiento_estado=:seguimiento_estado,
                      seguimiento_contenido=:seguimiento_contenido,
                      ejecucion_estado=:ejecucion_estado,
                      ejecucion_contenido=:ejecucion_contenido
                  WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nombre_elaborado", $this->nombre_elaborado);
        $stmt->bindParam(":nombre_responsable", $this->nombre_responsable);
        $stmt->bindParam(":elaboracion_estado", $this->elaboracion_estado);
        $stmt->bindParam(":elaboracion_contenido", $this->elaboracion_contenido);
        $stmt->bindParam(":seguimiento_estado", $this->seguimiento_estado);
        $stmt->bindParam(":seguimiento_contenido", $this->seguimiento_contenido);
        $stmt->bindParam(":ejecucion_estado", $this->ejecucion_estado);
        $stmt->bindParam(":ejecucion_contenido", $this->ejecucion_contenido);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->id = $row['id'];
            $this->nombre_elaborado = $row['nombre_elaborado'];
            $this->nombre_responsable = $row['nombre_responsable'];
            $this->elaboracion_estado = $row['elaboracion_estado'];
            $this->elaboracion_contenido = $row['elaboracion_contenido'];
            $this->seguimiento_estado = $row['seguimiento_estado'];
            $this->seguimiento_contenido = $row['seguimiento_contenido'];
            $this->ejecucion_estado = $row['ejecucion_estado'];
            $this->ejecucion_contenido = $row['ejecucion_contenido'];
            return true;
        }
        return false;
    }
}
?>