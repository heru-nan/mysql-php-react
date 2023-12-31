<?php
class Database{
    private static $database_name ='myDatabase';
    private static $database_host = 'localhost';
    private static $database_user = 'root';
    private static $database_user_password = 'root';

    private static $connection_status = null;

    public function __construct(){
        die('Init function is not allowed');
    }

    public static function connect()
    {
        if(self::$connection_status == null)
        try{
           self::$connection_status = new PDO('mysql:host='.self::$database_host.';dbname='.self::$database_name.'', self::$database_user, self::$database_user_password);
        }catch(PDOException $e)
        {
            http_response_code(500);
            echo json_encode(array("error" => "Error connecting to database: " . $e->getMessage()));
            exit();
        }
        return self::$connection_status;
    }
    public static function disconnect()
    {
        self::$connection_status = null;
    }
}