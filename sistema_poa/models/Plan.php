<?php
require_once 'config/database.php';

class Plan
{

    private static function db()
    {
        return Database::connect();
    }

    // ================= PLANES =================

    public static function all()
    {
        return self::db()->query("SELECT * FROM planes ORDER BY fecha_creacion DESC")->fetchAll();
    }

    public static function find($id)
    {
        $stmt = self::db()->prepare("SELECT * FROM planes WHERE id_plan=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($data)
    {
        $sql = "INSERT INTO planes(nombre_elaborado,nombre_responsable,id_usuario)
              VALUES(?,?,?)";
        self::db()->prepare($sql)->execute([
            $data['nombre_elaborado'],
            $data['nombre_responsable'],
            $_SESSION['usuario']['id_usuario']
        ]);
    }

    public static function delete($id)
    {
        self::db()->prepare("DELETE FROM planes WHERE id_plan=?")->execute([$id]);
    }

    // ================= ELABORACIÓN =================

    public static function elaboracionPorPlan($id)
    {
        $stmt = self::db()->prepare("SELECT * FROM elaboracion WHERE id_plan=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function guardarElaboracion($d)
    {

        // UPDATE
        if (!empty($d['id_elaboracion'])) {
            $sql = "UPDATE elaboracion SET
                id_tema=?, id_indicador=?, linea_base=?, politicas=?, metas=?, actividades=?, indicador_resultado=?, id_responsable=?
                WHERE id_elaboracion=?";
            self::db()->prepare($sql)->execute([
                $d['id_tema'],
                $d['id_indicador'],
                $d['linea_base'],
                $d['politicas'],
                $d['metas'],
                $d['actividades'],
                $d['indicador_resultado'],
                $d['id_responsable'],
                $d['id_elaboracion']
            ]);
            $id_elab = $d['id_elaboracion'];
        }
        // INSERT
        else {
            $sql = "INSERT INTO elaboracion(id_tema,id_plan,id_indicador,linea_base,politicas,metas,actividades,indicador_resultado,id_responsable)
                  VALUES(?,?,?,?,?,?,?,?,?)";
            self::db()->prepare($sql)->execute([
                $d['id_tema'],
                $d['id_plan'],
                $d['id_indicador'],
                $d['linea_base'],
                $d['politicas'],
                $d['metas'],
                $d['actividades'],
                $d['indicador_resultado'],
                $d['id_responsable']
            ]);
            $id_elab = self::db()->lastInsertId();
        }

        // Medios de verificación
        self::db()->prepare("DELETE FROM medios_verificacion WHERE id_elaboracion=?")->execute([$id_elab]);

        if (!empty($d['detalle'])) {
            foreach ($d['detalle'] as $i => $det) {
                if ($det != '') {
                    self::db()->prepare("
                        INSERT INTO medios_verificacion(detalle,id_plazo,id_elaboracion)
                        VALUES(?,?,?)
                    ")->execute([$det, $d['id_plazo'][$i], $id_elab]);
                }
            }
        }
    }

    // ================= SELECTS =================

    public static function ejes()
    {
        return self::db()->query("SELECT * FROM ejes")->fetchAll();
    }

    public static function temas()
    {
        return self::db()->query("SELECT * FROM temas_poa WHERE estado='ACTIVO'")->fetchAll();
    }

    public static function indicadoresPorEje($id)
    {
        $stmt = self::db()->prepare("SELECT * FROM indicadores WHERE id_eje=?");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public static function responsables()
    {
        return self::db()->query("SELECT * FROM responsables WHERE estado='ACTIVO'")->fetchAll();
    }

    public static function plazos()
    {
        return self::db()->query("SELECT * FROM plazos")->fetchAll();
    }
}
