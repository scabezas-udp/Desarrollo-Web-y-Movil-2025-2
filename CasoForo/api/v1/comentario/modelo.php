<?php

class Comentario
{
    private $id;
    private $titulo;
    private $contenido;
    private $created_at;
    private $categoria_id;
    private $usuario_id;
    private $activo;

    public function __construct() {}

    // accesadores
    public function getId()
    {
        return $this->id;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function getContenido()
    {
        return $this->contenido;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getCategoriaId()
    {
        return $this->categoria_id;
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
    public function setTitulo($_n)
    {
        $this->titulo = $_n;
    }
    public function setContenido($_n)
    {
        $this->contenido = $_n;
    }
    public function setCreatedAt($_n)
    {
        $this->created_at = $_n;
    }
    public function setCategoriaId($_n)
    {
        $this->categoria_id = $_n;
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
        $query = "SELECT id, entrada_id, texto, created_at, usuario_id, activo FROM foro_comentario WHERE entrada_id = ".$_id.";";
        $rs = mysqli_query($con->getConnection(), $query);
        if ($rs) {
            while ($registro = mysqli_fetch_assoc($rs)) {
                $registro['activo'] = $registro['activo'] == 1 ? true : false;
                array_push($lista, $registro);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $lista;
    }

    public function add(Entrada $_nuevo)
    {
        /*
        $con = new Conexion();
        $nuevoId = count($this->getAll()) + 1;
        $query = "INSERT INTO indicador (id, codigo, nombre, unidad_medida_id, valor, activo) VALUES (" . $nuevoId . " ,'" . $_nuevo->getCodigo() . "', '" . $_nuevo->getNombre() . "', " . $_nuevo->getUnidadMedidaId() . ", " . $_nuevo->getValor() . ", TRUE)";
        try {
            $rs = mysqli_query($con->getConnection(), $query);
            $con->closeConnection();
            if ($rs) {
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }*/
    }
}
