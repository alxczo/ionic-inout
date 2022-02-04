<?php 

 header('Access-Control-Allow-Origin: *');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Methods: POST, GET, PUT DELETE');
 header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,');

 $con = new mysqli('localhost','root','','db_inout');
 
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if(isset($_GET['tecid'])){
        
            $tecid = $_GET['tecid'];
            $sql = $con ->query("select * from tecnico where tecid='$tecid'");
            $data = $sql ->fetch_assoc();

        }else{
            $data = array();
            $sql = $con->query("select * from tecnico");
            while($d = $sql->fetch_assoc()){
                $data[] = $d;
            }
        }
        exit(json_encode($data));
    }
    if($_SERVER['REQUEST_METHOD'] === 'PUT'){
        if(isset($_GET['tecid'])){
         
            $_tecid = $_GET['tecid'];
            $data = json_decode(file_get_contents("php://input"));
            $sql = $con->query("update tecnico set
                tecnome = '".$data->tecnome."',
                tecemeail  = '".$data->tecemail."',
                tecsenha = '".$data->tecsenha."',
                tecempresa = '".$data->tecempresa."',
                tecpfpj = '".$data->tecpfpj."',
                tectelefone = '".$data->tectelefone."',
                tecendereco = '".$data->tecendereco."' 
                where tecid = '$tecid'");
            if($sql){
                exit(json_encode(array('status' => 'Sucesso')));
            }else{
                exit(json_encode(array('status' => 'Não Funcionou')));
            }
         
        }
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $data = json_decode(file_get_contents("php://input"));
        $sql = $con->query("insert into tecnico(tecnome, tecemail, tecsenha, tecempresa, tecpfpj, tectelefone, tecendereco) values ('".$data->tecnome."', '".$data->tecemsail."','".$data->tecsenha."','".$data->tecempresa."','".$data->tecpfpj."','".$data->tecelefone."','".$data->tecendereco."')");
        if($sql){
            $data->tecid = $con->insert_tecid;
            exit(json_encode($data));
        }else{
            exit(json_encode(array('Status' => 'Não Funcionou')));
        }
    }
    if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        if(isset($_GET['tecid'])){
            $tecid = $_GET['tecid'];
            $sql = $con(query("delete from tecnico where tecid='$tecid'"));
            if($sql){
                exit(json_encode(array('status' => 'Sucesso')));
            }else{
                exit(json_encode(array('status' => 'Não Funcionou')));
            }
        }
    }


?>