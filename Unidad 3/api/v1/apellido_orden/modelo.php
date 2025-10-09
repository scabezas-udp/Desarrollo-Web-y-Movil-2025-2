<?php

class ApellidoOrden
{
    private $id;
    private $nombre;
    private $activo;

    public function __construct() {}

    public function getId()
    {
        return intval($this->id);
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function isActivo() //solo para booleanos
    {
        return $this->activo;
    }
    //mutadores
    
    public function setId($_n)
    {
        $this->id = $_n;
    }
    public function setNombre($_n)
    {
        $this->nombre = $_n;
    }
    public function setActivo($_n)
    {
        $this->activo = $_n;
    }
    
    public function getAll()
    {
        $lista = [];
        $con = new Conexion();
        $query = "SELECT id, nombre, activo FROM apellido_orden;";
        
        $rs = mysqli_query($con->getConnection(), $query);
        if ($rs) {
            while ($registro = mysqli_fetch_assoc($rs)) {
                $registro['activo'] = $registro['activo'] == 1 ? true : false;
                $tupla = new ApellidoOrden();
                $tupla->setId($registro['id']);
                $tupla->setNombre($registro['nombre']);
                $tupla->setActivo($registro['activo']);

                //debemos trabajar con el objeto
                array_push($lista, array(
                    'id' => $tupla->getId(),
                    'nombre' => $tupla->getNombre(),
                    'activo' => $tupla->isActivo()
                ));
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $lista;
    }
}