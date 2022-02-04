<?php 

 header('Access-Control-Allow-Origin: *');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Methods: POST, GET, PUT DELETE');
 header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,');

 $con = new mysqli('localhost','root','','db_inout');
 
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if(isset($_GET['cliid'])){
        
            $cliid = $_GET['cliid'];
            $sql = $con ->query("select * from cliente where cliid='$cliid'");
            $data = $sql ->fetch_assoc();

        }else{
            $data = array();
            $sql = $con->query("select * from cliente");
            while($d = $sql->fetch_assoc()){
                $data[] = $d;
            }
        }
        exit(json_encode($data));
    }
    if($_SERVER['REQUEST_METHOD'] === 'PUT'){
        if(isset($_GET['cliid'])){
         
            $_cliid = $_GET['cliid'];
            $data = json_decode(file_get_contents("php://input"));
            $sql = $con->query("update cliente set
                clinome = '".$data->clinome."',
                cliemail  = '".$data->cliemail."',
                clitelefone = '".$data->clitelefone."',
                clipfpj = '".$data->clipfpj."',
                cliendereco = '".$data->cliendereco."' 
                where cliid = '$cliid'");
            if($sql){
                exit(json_encode(array('status' => 'Sucesso')));
            }else{
                exit(json_encode(array('status' => 'Não Funcionou')));
            }
         
        }
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $data = json_decode(file_get_contents("php://input"));
        $sql = $con->query("insert into cliente(clinome, cliemail, clitelefone, clipfpj, cliendereco) values ('".$data->clinome."', '".$data->cliemail."','".$data->clitelefone."','".$data->clipfpj."','".$data->cliendereco."')");
        if($sql){
            $data->cliid = $con->insert_cliid;
            exit(json_encode($data));
        }else{
            exit(json_encode(array('Status' => 'Não Funcionou')));
        }
    }
    if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        if(isset($_GET['cliid'])){
            $cliid = $_GET['cliid'];
            $sql = $con(query("delete from cliente where cliid='$cliid'"));
            if($sql){
                exit(json_encode(array('status' => 'Sucesso')));
            }else{
                exit(json_encode(array('status' => 'Não Funcionou')));
            }
        }
    }


?>