<?php

class Comentario
{
    private $id;
    private $entrada_id;
    private $texto;
    private $created_at;
    private $usuario_id;
    private $activo;

    public function __construct() {}

    // accesadores
    public function getId()
    {
        return $this->id;
    }
    public function getEntradaId()
    {
        return $this->entrada_id;
    }
    public function getTexto()
    {
        return $this->texto;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }
    public function getActivo()
    {
        return $this->activo;
    }

    // mutadores
    public function setId($_n)
    {
        $this->id = $_n;
    }
    public function setEntradaId($_n)
    {
        $this->entrada_id = $_n;
    }
    public function setTexto($_n)
    {
        $this->texto = $_n;
    }
    public function setCreatedAt($_n)
    {
        $this->created_at = $_n;
    }
    public function setUsuarioId($_n)
    {
        $this->usuario_id = $_n;
    }
    public function setActivo($_n)
    {
        $this->activo = $_n;
    }

    public function getByEntradaId($_id)
    {
        $lista = [];
        $con = new Conexion();
        $query = "SELECT fc.id, fc.entrada_id, fc.texto, fc.created_at, fc.usuario_id, fu.username, fc.activo FROM foro_comentario fc JOIN foro_usuario fu ON (fc.usuario_id = fu.id) WHERE fc.entrada_id = " . $_id . ";";
        $rs = mysqli_query($con->getConnection(), $query);
        if ($rs) {
            while ($registro = mysqli_fetch_assoc($rs)) {
                $registro['activo'] = $registro['activo'] == 1 ? true : false;
                $nuevo = [
                    "id" => $registro['id'],
                    "entrada_id" => $registro['entrada_id'],
                    "texto" => $registro['texto'],
                    "created" => [
                        "date" => $registro['created_at'],
                        "user" => [
                            "id" => $registro['usuario_id'],
                            "username" => $registro['username']
                        ]
                    ],
                    "activo" => $registro['activo']
                ];
                array_push($lista, $nuevo);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $lista;
    }

    private function getAll()
    {
        $lista = [];
        $con = new Conexion();
        $query = "SELECT * FROM foro_comentario ;";
        $rs = mysqli_query($con->getConnection(), $query);
        if ($rs) {
            while ($registro = mysqli_fetch_assoc($rs)) {
                $nuevo = $registro['id'];
                array_push($lista, $nuevo);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $lista;
    }

    public function add(Comentario $_nuevo)
    {
        $con = new Conexion();
        $nuevoId = count($this->getAll()) + 1;
        $query = "INSERT INTO foro_comentario (id, entrada_id, texto, usuario_id, activo) VALUES (" . $nuevoId . " , " . $_nuevo->getEntradaId() . ", '" . $_nuevo->getTexto() . "', " . $_nuevo->getUsuarioId() . ", TRUE)";
        // echo $query;
        try {
            $rs = mysqli_query($con->getConnection(), $query);
            $con->closeConnection();
            if ($rs) {
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function update(Comentario $_nuevo)
    {
        $con = new Conexion();
        $query = "UPDATE foro_comentario SET texto = '" . $_nuevo->getTexto() . "' WHERE id = " . $_nuevo->getId();
        // echo $query;
        try {
            $rs = mysqli_query($con->getConnection(), $query);
            $con->closeConnection();
            if ($rs) {
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function disable(Comentario $_nuevo)
    {
        $con = new Conexion();
        $query = "UPDATE foro_comentario SET activo = false WHERE id = " . $_nuevo->getId();
        try {
            $rs = mysqli_query($con->getConnection(), $query);
            $con->closeConnection();
            if ($rs) {
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function enable(Comentario $_nuevo)
    {
        $con = new Conexion();
        $query = "UPDATE foro_comentario SET activo = true WHERE id = " . $_nuevo->getId();
        try {
            $rs = mysqli_query($con->getConnection(), $query);
            $con->closeConnection();
            if ($rs) {
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
}
