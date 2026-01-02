<?php
require_once 'config/database.php';

class Plan {

    private static function db(){
        return Database::connect();
    }

    // LISTAR
    public static function all(){
        return self::db()->query("
            SELECT * FROM planes ORDER BY fecha_creacion DESC
        ")->fetchAll();
    }

    // CREAR
    public static function create($data){
        $sql = "INSERT INTO planes(nombre_elaborado,nombre_responsable,id_usuario)
                VALUES(?,?,?)";
        $stmt = self::db()->prepare($sql);
        return $stmt->execute([
            $data['nombre_elaborado'],
            $data['nombre_responsable'],
            $_SESSION['usuario']['id_usuario']
        ]);
    }

    // ELIMINAR
    public static function delete($id){
        return self::db()->prepare("DELETE FROM planes WHERE id_plan=?")
                        ->execute([$id]);
    }

    // ======== ELABORACIÓN ========

    public static function elaboracionPorPlan($id_plan){
        $stmt = self::db()->prepare("SELECT * FROM elaboracion WHERE id_plan=?");
        $stmt->execute([$id_plan]);
        return $stmt->fetch();
    }

    public static function guardarElaboracion($data){
        // Si existe → UPDATE
        if(!empty($data['id_elaboracion'])){
            $sql="UPDATE elaboracion SET
                id_tema=?,id_indicador=?,linea_base=?,politicas=?,metas=?,actividades=?,indicador_resultado=?,id_responsable=?
                WHERE id_elaboracion=?";
            return self::db()->prepare($sql)->execute([
                $data['id_tema'],$data['id_indicador'],$data['linea_base'],$data['politicas'],
                $data['metas'],$data['actividades'],$data['indicador_resultado'],$data['id_responsable'],
                $data['id_elaboracion']
            ]);
        }

        // Si no existe → INSERT
        $sql="INSERT INTO elaboracion(id_tema,id_plan,id_indicador,linea_base,politicas,metas,actividades,indicador_resultado,id_responsable)
              VALUES(?,?,?,?,?,?,?,?,?)";

        return self::db()->prepare($sql)->execute([
            $data['id_tema'],$data['id_plan'],$data['id_indicador'],$data['linea_base'],
            $data['politicas'],$data['metas'],$data['actividades'],$data['indicador_resultado'],$data['id_responsable']
        ]);
    }

    // Selects
    public static function temas(){
        return self::db()->query("SELECT * FROM temas_poa WHERE estado='ACTIVO'")->fetchAll();
    }
    public static function indicadores(){
        return self::db()->query("SELECT * FROM indicadores")->fetchAll();
    }
    public static function responsables(){
        return self::db()->query("SELECT * FROM responsables WHERE estado='ACTIVO'")->fetchAll();
    }
}
