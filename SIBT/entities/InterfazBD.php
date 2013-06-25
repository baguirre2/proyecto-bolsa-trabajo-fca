<?php
class InterfazBD{
    private $conexion;
    private $manejador;
    //"host=localhost port=5432 dbname=li307179654 user=lamb password=bar";
    const CONSTRING = "host=localhost port=5432 dbname=SIBT user=postgres password=mufasa";
    private $resultado;

    /**
    *@params string:manejador
    */
    function __construct($manejador = NULL) {

            $this->manejador = $manejador;

            switch($this->manejador){

                    case 'mysql':
                    break;

                    case 'oracle':
                    break;

                    default:
                    $this->conexion = pg_pconnect(self::CONSTRING);
                    break;
            }
    }

    /**
    *@paramas string:query
    *@return boolean
    **/
    function insertar($query = NULL){
            $this->resultado = false;
            if($query != NULL && $this->conexion != NULL){

                    switch($this->manejador){

                    case 'mysql':
                    break;


                    case 'oracle':
                    break;

                    default:
                            $this->resultado = pg_query($this->conexion,$query);
                    break;
                    }
            }
            return is_resource ($this->resultado);
    }

    /**
    *@paramas string:query
    *@return array
    **/
    function consultar($query = NULL){
            $this->resultado = false;
            if($query != NULL && $this->conexion != NULL){

                            switch($this->manejador){

                            case 'mysql':
                            break;


                            case 'oracle':
                            break;


                            default:
                                    $res = pg_query($this->conexion,$query);
                                    if($res != false){
                                            while($fila = pg_fetch_assoc($res)){
                                                    $this->resultado[] = $fila;
                                            }
                                    }else{
                                            $this->resultado = false;
                                    }
                            break;
                    }
            }
            return $this->resultado;
    }

    /**
    *@return bool
    **/
    function cerrarConexion(){
            return pg_close ($this->conexion);
    }
}
?>