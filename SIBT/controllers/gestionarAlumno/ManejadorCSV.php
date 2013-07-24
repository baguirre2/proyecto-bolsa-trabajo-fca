<?php

include_once '../../entities/Alumno.php';

class ManejadorCSV {

    public function abrirArchivo($dirArchivo) {
        return fopen($dirArchivo, "r");
    }
    
    public function cerrarArchivo($archivo) {
        fclose($archivo);
    }

    public function extraerRegistro($file) {
        return fgetcsv($file, 1000, ";");
    }

    public function procesarRegistro($registro) {

        //Separamos las columnas
        $noCta = $registro[0];
        $nombre = $registro[1];
        $apePat = $registro[2];
        $apeMat = $registro[3];
        $carrera = $registro[4];
        $nacion = $registro[5];
        $fecNac = $registro[6];
        $correo = $registro[7];
        
        if ($carrera == 'Administración') {
            $carrera = 1;
        } else if ($carrera == 'Contaduría') {
            $carrera = 2;
        } else {
            $carrera = 3;
        }
        
        //Suponiendo que en el archivo la fecha venga en el formato DD/MM/AAAA
        $fecNac = explode("/", $fecNac);
        $fecNac = $fecNac[2] . "/" . $fecNac[1] . "/" . $fecNac[0];
        
        //echo "<h1>MANEJADOR</h1>";
        
        $alumNew = new Alumno();
        
        return $alumNew->registrarAlumnoPorArchivo($nombre, $apePat, $apeMat, $correo, $noCta, $nacion, $fecNac, $carrera);
    }
}
?>
