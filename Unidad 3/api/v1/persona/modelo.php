<?php

class DocumentoIdentidad
{
    private $id;
    private $valor;
    private $nombres;
    private $apellidoPaterno;
    private $apellidoMaterno;
    private $ordenApellidoId;
    private $nacionalidadId;
    private $generoId;
    private $tipoId;
    private $activo;

    public function __construct() {}
    
    public function getAll()
    {
        $lista = [];
        $con = new Conexion();
        $query = "SELECT 
                    per.id persona_id, 
                    docid.id documento_identidad_id, 
                    docid.valor documento_identidad_valor,
                    docid.nombres documento_identidad_nombres, 
                    docid.apellido_paterno documento_identidad_apellido_paterno, 
                    docid.apellido_materno documento_identidad_apellido_materno, 
                    docid.orden_apeliido_id documento_identidad_orden_apellido_id,
                    apor.nombre documento_identidad_orden_apellido_nombre,
                    docid.nacionalidad_id documento_identidad_nacionalidad_id,
                    naci.nombre documento_identidad_nacionalidad_nombre,
                    docid.genero_id documento_identidad_genero_id,
                    gene.nombre documento_identidad_genero_nombre,
                    docid.documento_tipo_id documento_identidad_tipo_id,
                    docidti.nombre documento_identidad_tipo_nombre,
                    per.activo persona_activo
                FROM persona per 
                    INNER JOIN documento_identidad docid ON per.id = docid.persona_id
                    INNER JOIN apellido_orden apor ON docid.orden_apeliido_id = apor.id
                    INNER JOIN nacionalidad naci ON docid.nacionalidad_id = naci.id
                    INNER JOIN genero gene ON docid.genero_id = gene.id
                    INNER JOIN documento_identidad_tipo docidti ON docid.documento_tipo_id = docidti.id;";
        
        $rs = mysqli_query($con->getConnection(), $query);
        if ($rs) {
            while ($registro = mysqli_fetch_assoc($rs)) {
                $registro['persona_activo'] = $registro['persona_activo'] == 1 ? true : false;
                
                //debemos trabajar con el objeto
                array_push($lista, array(
                    'id' => $registro['persona_id'],
                    'documento_identidad' => array(
                        'id' => $registro['documento_identidad_id'],
                        'valor' => $registro['documento_identidad_valor'],
                        'nombres' => $registro['documento_identidad_nombres'],
                        'apellidos' => array(
                            'paterno' => $registro['documento_identidad_apellido_paterno'],
                            'materno' => $registro['documento_identidad_apellido_materno'],
                            'orden' => [
                                'id' => $registro['documento_identidad_orden_apellido_id'],
                                'nombre' => $registro['documento_identidad_orden_apellido_nombre']
                            ]
                        ),
                        'nacionalidad' => [
                            'id' => $registro['documento_identidad_nacionalidad_id'],
                            'nombre' => $registro['documento_identidad_nacionalidad_nombre']
                        ],
                        'genero' => [
                            'id' => $registro['documento_identidad_genero_id'],
                            'nombre' => $registro['documento_identidad_genero_nombre']
                        ],
                        'tipo' => [
                            'id' => $registro['documento_identidad_tipo_id'],
                            'nombre' => $registro['documento_identidad_tipo_nombre']
                        ],
                    ),
                    'activo' => $registro['persona_activo']
                ));
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $lista;
    }
}