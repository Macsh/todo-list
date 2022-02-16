<?php

class MyDatabase {

private $login;
private $password;
private $connect;
public $dbname = 'myutils';

    public function __construct($login='userMacsh', $password=''){
        $this->login = $login;
        $this->password = $password;
        $this->connect_to_db();
    }

    function connect_to_db() {
        try {
            $db = new PDO('mysql:host=localhost;dbname='.$this->dbname.';charset=utf8',$this->login,
            $this->password,
        );
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->connect = $db;
        }
        catch (Exception $e){
            die("Connection failed: " . $e->getMessage());
        }
    }

    function check_todo(){

    }
    
    function check_done(){

    }

    public function save_to_db($data, $hobbies, $pw) {
        $sql = "INSERT INTO user(firstname, lastname, birthdate, email, gender, city, active) VALUES(:firstname, :lastname, :birthdate, :mail, :gender, :city, 1)";
        $id = "SELECT MAX(id) as id FROM user";
        $checkUser = "SELECT email FROM user WHERE email LIKE '%{$data['mail']}%'";

        $checkPrepare = $this->connect->prepare($checkUser);
        $checkPrepare->execute();
        $getCheck = $checkPrepare->fetch();

        if($getCheck != ""){
            echo "Mail déjà utilisé.";
        }
        else if($getCheck == ""){
            $insert = $this->connect->prepare($sql);
            $insert->execute($data);

            $executeId = $this->connect->prepare($id);
            $executeId->execute();
            $get_id = $executeId->fetch();
            $lastId = $get_id->id;

            for($i=0;$i<count($hobbies);$i++){
                $hobbiesSQL = "INSERT INTO user_hobby(user_id, hobbies_id) VALUES($lastId, $hobbies[$i])";
                $insertHobby = $this->connect->prepare($hobbiesSQL);
                $insertHobby->execute();
            };

            $pwSQL = "INSERT INTO password(password, user_id) VALUES('$pw', '$lastId')";
            $insertPW = $this->connect->prepare($pwSQL);
            $insertPW->execute();
            echo "Inscription réussie";
        }
    }
}

?>