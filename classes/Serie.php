<?php
    require_once('DBAbstractModel.php');
    
    class Serie extends DBAbstractModel {
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
        private $titulo;
        private $img; // caratula
        private $id_plan; // 1 basico 2 premium
        private $numero_reproducciones;

        # Obtiene los datos del usuario pasando la id
        public function getDatos($id='') {
            $this->query = "
                SELECT *
                FROM series
                WHERE id = :id
                ";
            $this->parametros['id'] = $id;
            $this->get_results_from_query();
            return $this->rows;
            $this->close_connection();
            $this->mensaje = 'Datos extraidos';
        }

        # Obtiene los datos de una serie
        public function get($titulo='') {		
        if($titulo != '') {
            $this->query = "
                SELECT *
                FROM series
                WHERE usuario = :usuario";
            $this->parametros['titulo'] = $titulo;	
            $this->get_results_from_query();
            $this->close_connection();
        }else {
            $this->mensaje = "Serie no encontrado";
        }
            return $this->rows;
        }

        # Obtiene los datos de una serie
        public function getSerieById($id='') {		
           if($id != '') {
               $this->query = "
                   SELECT *
                   FROM series
                   WHERE id = :id";
               $this->parametros['id'] = $id;	
               $this->get_results_from_query();
               $this->close_connection();
           }else {
               $this->mensaje = "Serie no encontrado";
           }
               return $this->rows;
        }

        # Crear una nueva serie
        public function set($user_data = array()) {                 
                $this->query = "INSERT INTO series
                                    (titulo, img, estado)
                                    VALUES
                                    (:titulo, :img, :estado)";
                    $this->parametros['titulo'] = $user_data["titulo"];
                    $this->parametros['img'] = $user_data["img"];
                    $this->parametros['estado'] = $user_data["estado"];
                    $this->get_results_from_query();
                    $this->close_connection();
                    $this->mensaje = 'Serie agregado exitosamente';
        }

        # Comprueba si el usuario existe
        public function comprobarSerie($titulo='') {        
                if($titulo != '') {
                $this->query = "
                    SELECT usuario
                    FROM secre_usuario
                    WHERE usuario = :usuario";
                $this->parametros['usuario']= $user_data["usuario"];
                $this->get_results_from_query();
                $this->close_connection();
                $this->mensaje = 'El usuario ya existe';
            }else {
                $this->mensaje = "Usuario no encontrado";
            }
                return $this->rows;
            }

     # Busca una serie
      public function buscarSeries($busqueda=''){
        if($busqueda!=''){
            $this->query = "SELECT * FROM series
            WHERE 
            titulo LIKE :filtro
            ";
            $this->parametros['filtro']="%".$busqueda."%";
        }
        $this->get_results_from_query();
        $this->close_connection();
        return $this->rows;
    }
    
    # Activar una serie
    public function aumentarReproduccion($id='') {
        if($id != '') {
            $this->query = "
            UPDATE series SET numero_reproducciones = numero_reproducciones + 1 
            WHERE series.id =:id
            "; 
            $this->parametros['id'] = $id;
            $this->get_results_from_query();
        } 
    }
    
    # Activar una serie
    public function habilitar($id='') {
        if($id != '') {
            $this->query = "
            UPDATE series
            SET estado = :estado
            WHERE id = :id
            ";
        $this->parametros['estado'] = "habilitado";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        } 
    }
        # Bloquear una serie
        public function deshabilitar($id='') {
            if($id != '') {
                $this->query = "
                UPDATE series
                SET estado = :estado
                WHERE id = :id
                ";
                $this->parametros['estado'] = "deshabilitado";
                $this->parametros['id'] = $id;
            $this->get_results_from_query();
            }
        }

        # Muestra todos los usuarios
        public function mostrarSeriesOrdenadas() {		
            $this->query = "
            SELECT * FROM series
            ORDER BY series.numero_reproducciones DESC 
            ";
            $this->get_results_from_query();
            $this->close_connection();
            return $this->rows;
        }

     # Obtiene los datos de una serie
     public function getSeriesOrdenadas($id='') {		
        if($id != '') {
            $this->query = "
            SELECT * FROM series
            ORDER BY series.numero_reproducciones DESC 
            ";
            $this->parametros['id'] = $id;	
            $this->get_results_from_query();
            $this->close_connection();
        }else {
            $this->mensaje = "Serie no encontrado";
        }
            return $this->rows;
     }



       # Añadir serie a favoritos
       public function annandirSerieFavorita($idUser, $idSerie) { 
            $this->query = "INSERT INTO series_user
                                (idUser, idSerie)
                                VALUES
                                (:idUser, :idSerie)";
                $this->parametros['idUser'] = $idUser;
                $this->parametros['idSerie'] = $idSerie;
                $this->get_results_from_query();
                $this->close_connection();
                $this->mensaje = 'Serie añadida a favoritos';
            
    }

       # Eliminar serie a favoritos
       public function eliminarSerieFavorita($idUser, $idSerie) { 
        $this->query = "DELETE FROM series_user 
                        WHERE idUser=:idUser AND idSerie=:idSerie
                        ";
            $this->parametros['idUser'] = $idUser;
            $this->parametros['idSerie'] = $idSerie;
            $this->get_results_from_query();
            $this->close_connection();
    }


       # Añadir serie a favoritos
       public function getFavoritos($idUser, $idSerie) {  
        $this->query = "SELECT * FROM series_user
                        WHERE  idUser=:idUser AND idSerie=:idSerie
                        ";   
            $this->parametros['idUser'] = $idUser;
            $this->parametros['idSerie'] = $idSerie;
            $this->get_results_from_query();
            $this->close_connection();
            return $this->rows;
        }


      # Muestra todas las series recomendadas
      public function mostrarSeriesRecomendadas(){
        $this->query = " SELECT S.* FROM series S, series_user SU
         WHERE su.idSerie = S.id GROUP BY su.idSerie 
         HAVING COUNT(SU.idSerie) > 3";
        $this->get_results_from_query();
        $this->close_connection();
        return $this->rows;
    }

        public function getMensaje(){
            return $this->mensaje;
        }

        # Método constructor
        function __construct() {
            $this->db_name = 'series';
        }
        
        # Método destructor del objeto
        function __destruct() {
        $this->conn = null;
        }

    }
?>