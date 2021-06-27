<?php 
namespace  App\DataBase;

use Mysqli;

class DBmanager {
    

    private $host ='127.0.0.1';
    private $user ='user_gdh';
    private $pwd = 'user_gdh';
    private $dbName ='proba_gdh';

    public function connect(){
        $connection = mysqli_connect($this->host, $this->user, $this->pwd, $this->dbName);
        if($connection->connect_error){
            die("ERROR IN DB CONNECTION: ". $connection->connect_error);
            
            
        }else{
            return $connection;
        }
        
    }
    public function disconnect($connection){
        mysqli_close($connection);
    }

}
