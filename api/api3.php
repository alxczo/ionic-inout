<?php 

 header('Access-Control-Allow-Origin: *');
 header('Content-Type: application/json');
 header('Access-Control-Allow-Methods: POST, GET, PUT DELETE');
 header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,');

 $con = new mysqli('localhost','root','','db_inout');
 
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if(isset($_GET['osid'])){
        
            $osid = $_GET['osid'];
            $sql = $con ->query("select * from ordemservico where osid='$osid'");
            $data = $sql ->fetch_assoc();

        }else{
            $data = array();
            $sql = $con->query("select * from ordemservico");
            while($d = $sql->fetch_assoc()){
                $data[] = $d;
            }
        }
        exit(json_encode($data));
    }
    if($_SERVER['REQUEST_METHOD'] === 'PUT'){
        if(isset($_GET['osid'])){
         
            $_osid = $_GET['osid'];
            $data = json_decode(file_get_contents("php://input"));
            $sql = $con->query("update ordemservico set
                osnome = '".$data->osnome."',
                osdia  = '".$data->osdia."',
                ostipo = '".$data->ostipo."',
                osdetalhes = '".$data->osdetalhes."',
                osestatus = '".$data->osestatus."',
                osservico = '".$data->osservico."',
                osobservacoes = '".$data->osobservacoes."',
                osorcamento = '".$data->osorcamento."',
                osresponsavel = '".$data->osresponsavel."' 
                where osid = '$osid'");
            if($sql){
                exit(json_encode(array('status' => 'Sucesso')));
            }else{
                exit(json_encode(array('status' => 'Não Funcionou')));
            }
         
        }
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $data = json_decode(file_get_contents("php://input"));
        $sql = $con->query("insert into ordemservico(osnome, osdia, ostipo, osdetalhes, osestatus, osservico, osobservacoes, osorcamennto, osresponsavel) values ('".$data->osnome."', '".$data->osdia."','".$data->ostipo."','".$data->osdetalhes."','".$data->osestatus."','".$data->tecelefone."','".$data->osobservacoes."','".$data->osorcamento."','".$data->osresponsavel."')");
        if($sql){
            $data->osid = $con->insert_osid;
            exit(json_encode($data));
        }else{
            exit(json_encode(array('Status' => 'Não Funcionou')));
        }
    }
    if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        if(isset($_GET['osid'])){
            $osid = $_GET['osid'];
            $sql = $con(query("delete from ordemservico where osid='$osid'"));
            if($sql){
                exit(json_encode(array('status' => 'Sucesso')));
            }else{
                exit(json_encode(array('status' => 'Não Funcionou')));
            }
        }
    }


?>