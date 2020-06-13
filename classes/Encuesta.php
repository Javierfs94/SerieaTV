<?php
    require_once('DBAbstractModel.php');
    
    class Encuesta extends DBAbstractModel {
        private static $instancia;
        public static function singleton() {
            if (!isset(self::$instancia)) {
                $miClase = __CLASS__;
                self::$instancia = new $miClase;
            }
            return self::$instancia;
        }

        public function __clone() {
            trigger_error('La clonación no es permitida.', E_USER_ERROR);
        }

        private $id;
        private $Titulo;
        private $fechaHoraInicio;
        private $fechaHoraFinal;

        # Obtiene los datos de las encuestas
        public function getTitulo($id='') {
            $this->query = "
                SELECT Titulo FROM encuestas WHERE id=:id
                    ";
            $this->parametros['id']= $id;
            $this->get_results_from_query();
            return $this->rows;
            $this->close_connection();
        }
    
        # Obtiene los datos de las encuestas ordenados en orden descendente
        public function getEncuestas() {
            $this->query = "
                SELECT * FROM encuestas ORDER BY id DESC
                    ";
            $this->get_results_from_query();
            return $this->rows;
            $this->close_connection();
        }

        # Obtiene las encuestas que están disponibles
            public function getEncuestasDisponibles(){
            $this->query = "
            SELECT * FROM encuestas WHERE fechaHoraFinal  > :ahora
            ";
            $this->parametros['ahora']= date("Y-m-d H:i:s");
            $this->get_results_from_query();
            return $this->rows;
        }

        # Obtiene las encuestas que han terminado
        public function getEncuestasTerminadas(){
            $this->query = "
            SELECT * FROM encuestas WHERE fechaHoraFinal < :ahora
            ";
            $this->parametros['ahora']= date("Y-m-d H:i:s");
            $this->get_results_from_query();
            return $this->rows;
        }

        # Crear una nueva encuesta
        public function setEncuesta($user_data = array()) {                 
            $this->query = "
                    INSERT INTO encuestas (Titulo, fechaHoraInicio, fechaHoraFinal) 
                    VALUES (:Titulo, :fechaHoraInicio, :fechaHoraFinal) 
                    ";
                    $this->parametros['Titulo'] = $user_data["Titulo"];
                    $this->parametros['fechaHoraInicio'] = $user_data["fechaHoraInicio"];
                    $this->parametros['fechaHoraFinal'] = $user_data["fechaHoraFinal"];
                    $this->get_results_from_query();
                    $this->close_connection();
                    $this->mensaje = 'Encuesta agregada exitosamente';
        }

        # Crea una nueva pregunta
        public function setPreguntas($user_data = array()) {                 
            $this->query = "
                    INSERT INTO encuestas_preguntas (idEncuesta, pregunta) 
                    VALUES (:idEncuesta, :pregunta);
                ";
                $this->parametros['idEncuesta'] = $user_data["idEncuesta"];
                $this->parametros['pregunta'] = $user_data["pregunta"];
                $this->get_results_from_query();
                $this->close_connection();
                $this->mensaje = 'Pregunta agregada exitosamente';
        }

          # Obtiene los datos de las preguntas de la encuesta
          public function getPreguntas($idEncuesta='') {
            $this->query = "
                SELECT * FROM encuestas_preguntas 
                WHERE idEncuesta = :idEncuesta
                ";
            $this->parametros['idEncuesta'] = $idEncuesta;
            $this->get_results_from_query();
            return $this->rows;
            $this->close_connection();
            $this->mensaje = 'Datos extraidos';
        }

        # Obtiene las IDs de las preguntas de una encuesta
          public function getIdPreguntasById($idEncuesta='') {
            $this->query = "
                    SELECT EP.id FROM encuestas E, encuestas_preguntas EP 
                    WHERE EP.idEncuesta=E.id AND EP.idEncuesta=:idEncuesta
                ";
            $this->parametros['idEncuesta'] = $idEncuesta;
            $this->get_results_from_query();
            return $this->rows;
            $this->close_connection();
        }

        # Crear una nueva respuesta a una encuesta
        public function setRespuestas($user_data = array()) {                 
            $this->query = "
                    INSERT INTO encuestas_respuestas (idEncuestaPregunta, Valor) 
                    VALUES (:idEncuestaPregunta,:Valor)
                ";
                $this->parametros['idEncuestaPregunta'] = $user_data["idEncuestaPregunta"];
                $this->parametros['Valor'] = $user_data["Valor"];
                $this->get_results_from_query();
                $this->close_connection();
                $this->mensaje = 'Encuesta respondida agregada exitosamente';
        }

        # Obtiene la media de los valores de una encuesta
        public function getMediaValores($idEncuesta = '') {                 
            $this->query = "
                        SELECT AVG(Valor) AS ValorMedio FROM encuestas_respuestas 
                        WHERE idEncuestaPregunta in (SELECT id FROM encuestas_preguntas WHERE idEncuesta = :idEncuesta)
                    ";
                $this->parametros['idEncuesta'] = $idEncuesta;
                $this->get_results_from_query();
                return $this->rows;
                $this->close_connection();
        }

        public function getMensaje(){
            return $this->mensaje;
        }

        # Método constructor
        function __construct() {
            $this->db_name = 'encuestas';
        }
        
        # Método destructor del objeto
        function __destruct() {
        $this->conn = null;
        }

    }
?>