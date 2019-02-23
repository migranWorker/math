<?php
    header('content-type:text/html;charset=utf-8');
    header('Access-Control-Allow-Headers:Origin,X-Requested-Width,Content-Type,Accept');
    header('Access-Control-Allow-Methods:GET,POST,PUT,DELETE');
    error_reporting(0);
    $type = $_POST['type'];
    $con = new PDO("mysql:host=127.0.0.1;dbname=math","root","root");
    switch($type){
        case "login":
            $studentId = $_POST['studentId'];
            $studentPsd = $_POST['studentPsd'];
            $sql = "select * from student where studentId=:studentId and studentPsd=:studentPsd";
            $command=$con->prepare($sql);
            $command->execute(array(":studentId"=>$studentId,"studentPsd"=>$studentPsd));
            $result=$command->fetch(PDO::FETCH_ASSOC);
            if(count($result) >=0){
                $result = array("code"=>1,"data"=>$result,"msg"=>"登陆成功");
                $json = json_encode($result);
                echo $json;
            }else{
                $result = array("code"=>0,"msg"=>"登陆失败");
                $json =json_encode($result);
                echo $json;
            }
            break;

        case "change":
            $studentPsd = $_POST['studentPsd'];
            $studentId = $_POST['studentId'];
            $studentName = $_POST['studentName'];
            $sql = "UPDATE student SET studentPsd = :studentPsd,studentName = :studentName WHERE studentId = :studentId";
            $command=$con->prepare($sql);
            $result=$command->execute(array(":studentId"=>$studentId,"studentPsd"=>$studentPsd,"studentName"=>$studentName));
            if($result){
                $sql = "select * from student where studentId=:studentId";
                $command=$con->prepare($sql);
                $command->execute(array(":studentId"=>$studentId));
                $res=$command->fetch(PDO::FETCH_ASSOC);
                $json = json_encode(array("code"=>1,"data"=>$res));
                echo $json;
            }
            break;
        
        case "adminLogin":
            $adminId = $_POST['adminId'];
            $adminPsd = $_POST['adminPsd'];
            $sql = "select * from admin where adminId=:adminId and adminPsd=:adminPsd";
            $command=$con->prepare($sql);
            $command->execute(array(":adminId"=>$adminId,"adminPsd"=>$adminPsd));
            $result=$command->fetch(PDO::FETCH_ASSOC);
            if(count($result) >=0){
                $result = array("code"=>1,"data"=>$result,"msg"=>"登陆成功");
                $json = json_encode($result);
                echo $json;
            }else{
                $result = array("code"=>0,"msg"=>"登陆失败");
                $json =json_encode($result);
                echo $json;
            }
            break;
        case "select":
            $sql = "select * from student";
            $command=$con->prepare($sql);
            $command->execute();
            $arr = array();
           while( $result=$command->fetch(PDO::FETCH_ASSOC)){
                $arr[]=$result;
           }
           $json =json_encode(array("code"=>1,"data"=>$arr));
           echo $json;
           break;
        
        case "add":
           $studentName = $_POST['studentName'];
           $studentId = $_POST['studentId'];
           $studentPsd = $_POST['studentPsd'];
            $sql = "INSERT INTO student (studentId, studentName, studentPsd)
                 VALUES (:studentId, :studentName, :studentPsd)";
           $command=$con->prepare($sql);
           $result=$command->execute(array(":studentId"=>$studentId,"studentPsd"=>$studentPsd,"studentName"=>$studentName));
           if($result){
                $sql = "select * from student";
                $command=$con->prepare($sql);
                $command->execute();
                $arr = array();
                while( $res=$command->fetch(PDO::FETCH_ASSOC)){
                    $arr[]=$res;
                }
                $json =json_encode(array("code"=>1,"data"=>$arr));
                echo $json;
           }
          
          break;
        case "delete":
            $studentId = $_POST['studentId'];
            $sql = "delete from student where studentId=:studentId";    
            $command=$con->prepare($sql);
            $result = $command->execute(array(":studentId"=>$studentId));
           if($result){
                $sql = "select * from student";
                $command=$con->prepare($sql);
                $command->execute();
                $arr = array();
                while( $res=$command->fetch(PDO::FETCH_ASSOC)){
                    $arr[]=$res;
                }
                $json =json_encode(array("code"=>1,"data"=>$arr));
                echo $json;
           };
           break;
        case "questions":
            $sql="select * from questions";
            $command=$con->prepare($sql);
            $command->execute();
            $arr = array();
            while( $res=$command->fetch(PDO::FETCH_ASSOC)){
                $arr[]=$res;
            }
            $json =json_encode(array("code"=>1,"data"=>$arr));
            echo $json;
            break;
        case "test":
            $sql="select * from test";
            $command=$con->prepare($sql);
            $command->execute();
            $arr = array();
            while( $res=$command->fetch(PDO::FETCH_ASSOC)){
                $arr[]=$res;
            }
            $json =json_encode(array("code"=>1,"data"=>$arr));
            echo $json;
            break;
        case "addHomeWork":
            $title = $_POST['title'];
            $opationA = $_POST['opationA'];
            $opationB = $_POST['opationB'];
            if($_POST['opationC']){
                $opationC = $_POST['opationC'];
                $opationD = $_POST['opationD'];
                $answer = $_POST['answer'];
                $sql = "INSERT INTO homework (title, opationA, opationB,opationC,opationD,answer)
                    VALUES (:title, :opationA, :opationB,:opationC,:opationD,:answer)";
                $command=$con->prepare($sql);
                $result=$command->execute(array(":title"=>$title,":opationA"=>$opationA,":opationB"=>$opationB,":opationC"=>$opationC,":opationD"=>$opationD,":answer"=>$answer));
                if($result){
                    $json = json_encode(array("code"=>1));
                    echo $json;
                }
            }else{
                $answer = $_POST['answer'];
                $sql = "INSERT INTO homework (title, opationA, opationB,answer)
                    VALUES (:title, :opationA, :opationB,:answer)";
                $command=$con->prepare($sql);
                $result=$command->execute(array(":title"=>$title,":opationA"=>$opationA,":opationB"=>$opationB,":answer"=>$answer));
                if($result){
                    $json = json_encode(array("code"=>1));
                    echo $json;
                }
            };
            break;
        case "getWork":
            $sql="select * from homework";
            $command=$con->prepare($sql);
            $command->execute();
            $arr = array();
            while( $res=$command->fetch(PDO::FETCH_ASSOC)){
                $arr[]=$res;
            }
            $json =json_encode(array("code"=>1,"data"=>$arr));
            echo $json;
            break;
    }   
            $con = null;
?>