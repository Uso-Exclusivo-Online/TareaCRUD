<!-- /*app es el cerebro del sistema;*/
/*investigar PDO en php -->

<?php
    require_once realpath('../../vendor/autoload.php');
    $dotenv = Dotenv\Dotenv::createImmutable('../../');
    $dotenv->load();
    define('SERVIDOR',$_ENV ['SERVIDOR']);
    define('USUARIO',$_ENV ['USUARIO']);
    define('PASSWORD',$_ENV ['PASSWORD']);
    define('PUERTO',$_ENV['PUERTO']);
    define('BD',$_ENV['BD']);

    class Conexion{
        private static $conexion;
        public static function abrir_conexion(){
            if(!isset(self:: $conexion)){
                try{
                    self::$conexion = new PDO('mysql:host='.SERVIDOR.';dbname='.BD,USUARIO,PASSWORD);
                    self::$conexion-> exec ('SET CHARACTER SET utf8');
                    return self::$conexion;
                }catch(PDOException $e){
                    echo "Error en la Conexion: ".$e;  
                    die();
                }    
            }else{
                return self::$conexion;
            }
         }
         public static function obtener_conexion(){
                $conexion = self::abrir_conexion();
                return $conexion;
            }
        public static function cerrar_conexion(){
            self:: $conexion = null;
        
        }
    }

    class CRUD{
        public static function consulta(){
            $consulta = Conexion::obtener_conexion()->prepare("SELECT * FROM tabla_prueba");
            if($consulta->execute()){
                $data = $consulta->fetchAll(PDO::FETCH_ASSOC);
                echo print_r($data);
                echo "Consulta Completada";
            }else{
                echo "Error al consultar";
            }
        }
    
        public static function insertar($dato1, $dato2){
            $insercion = Conexion::obtener_conexion()->prepare("INSERT INTO tabla_prueba (columna1, columna2) VALUES (?, ?)");
            if($insercion->execute([$dato1, $dato2])){
                echo "Insertar Exitoso";
            }else{
                echo "Error al insertar";
            }
        }
    
        public static function actualizar($id, $nuevoDato){
            $actualizacion = Conexion::obtener_conexion()->prepare("UPDATE tabla_prueba SET columna1 = ? WHERE id = ?");
            if($actualizacion->execute([$nuevoDato, $id])){
                echo "Actualización completada";
            }else{
                echo "Error al actualizar";
            }
        }
    
        public static function eliminar($id){
            $eliminacion = Conexion::obtener_conexion()->prepare("DELETE FROM tabla_prueba WHERE id = ?");
            if($eliminacion->execute([$id])){
                echo "Eliminación completa";
            }else{
                echo "Error al eliminar";
            }
        }
    }
    
 
    CRUD::consulta();
    
    CRUD::insertar("Daniel", "Perez"); 
    
    CRUD::actualizar(1, "HOLA "); 
    
    CRUD::eliminar(1); 
    
    echo print_r(Conexion::obtener_conexion()); 
    
    ?>