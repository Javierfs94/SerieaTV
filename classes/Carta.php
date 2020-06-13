<?php
class Carta{
    private $_datos = array();

    /**
     * Constructor de Carta
     */
    public function __construct($usuario){
        $fecha = date('d\/m\/Y');
        array_push($this ->_datos, $usuario, $fecha); 
    }
    
    /**
     * Escribe la carta
     */
    public function escribirCartaPago(){
            $entrada = fopen("./archivos/cartapago.txt", "r");
            $salida = fopen("./archivos/cartapago".$this ->_datos[0].".txt", "w");
            do {
            $filaEntrada = fgets($entrada);

            $filaIntermedia = str_replace("{{nombre}}", $this ->_datos[0], $filaEntrada);
            $filaSalida = str_replace("{{fecha}}", $this ->_datos[1], $filaIntermedia);

            fwrite($salida, $filaSalida);
            } while (!feof($entrada));
            fclose($entrada); 
            fclose($salida);  
    }

    /**
     * Devuelve los datos de la carta de pago
     */
    public function getDatos(){
        return $this ->_datos;
    }

}
?>