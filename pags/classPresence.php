<?php
    include_once('classConnection.php');
    Class Presence{
        // function to make one instance from class
        // função para criar uma instancia da classe
        function  __construct(int $id = 0,string $ip="",$idstudent="",time $firstpresence = NULL,
        time $secondpresence = NULL,time $thirdpresence = NULL,date $datepresence = NULL){
            $this->id = $id;
            $this->ip = $ip;
            $this->idstudent = $idstudent;
            $this->firstpresence = $firstpresence;
            $this->secondpresence = $secondpresence;
            $this->thirdpresence = $thirdpresence;
            $this->datepresence = $datepresence;
        }
        // all get functions
        // todas funções get
        function getId(){
            return $this->id;
        }
        function getIp(){
            return $this->ip;
        }
        function getIdStudent(){
            return $this->idstudent;
        }
        function getFirstPresence(){
            return $this->firstpresence;
        }
        function getSecondPresence(){
            return $this->secondpresence;
        }
        function getThirdPresence(){
            return $this->thirdpresence;
        }
        function getDatePresence(){
            return $this->datepresence;
        }
        //all set functions to set values
        //todas funções para setar valores
        function setId($value){
            $this->id = $value;
        }
        function setIp($value){
            $this->ip = $value;
        }
        function setIdStudent($value){
            $this->idstudent = $value;
        }
        function setFirstPresence($value){
            $this->firstpresence = $value;
        }
        function setSecondPresence($value){
            $this->secondpresence = $value;
        }
        function setThirdPresence($value){
            $this->thirdpresence = $value;
        }
        function setDatePresence($value){
            $this->datepresence = $value;
        }
        //all methods to make actions
        //todos metodos para realizar ações
        //select db method
        //metodo para selecionar no banco 
        function selectPresence($value){
            $mysql = new Connection();
            $colums = "id,IPdispositivo,Presenca1,Presenca2,Presenca3,id_cadastro,data";
            $valueresponse = $mysql->select("listadepreseca",$colums,$value);
            
            if(is_string($valueresponse)){
                
                return "erro";
                
            }
            else{
                $this->setId($valueresponse[0]);
                $this->setIp($valueresponse[1]);
                $this->setFirstPresence($valueresponse[2]);
                $this->setSecondPresence($valueresponse[3]);
                $this->setThirdPresence($valueresponse[4]);
                $this->setIdStudent($valueresponse[5]);
                $this->setDatePresence($valueresponse[6]);
                
                return "";
            }

        }
        //insert db function
        //função para inserir no banco
        function insertPresence($default){
            $mysql = new Connection();
            $value ="";
            
            if(strcmp($default,'Presenca1')==0){
                $value ="'".$this->getIp()."','".
                $this->getFirstPresence()."','".
                $this->getIdStudent()."','".
                $this->getDatePresence()."'";
                
            }else if(strcmp($default,'Presenca2')==0){
                $value ="'".$this->getIp()."','".
                $this->getSecondPresence()."','".
                $this->getIdStudent()."','".
                $this->getDatePresence()."'";
            }else if(strcmp($default,'Presenca3')==0){
                $value ="'".$this->getIp()."','".
                $this->getThirdPresence()."','".
                $this->getIdStudent()."','".
                $this->getDatePresence()."'";
            }
                
                $colums = " IPdispositivo,".$default.",id_cadastro,data";
               
            return $mysql->insert("listadepreseca",$colums,$value);
        }
        //update db method
        //metodo para atualizar no banco 
        function updatePresence($value){
            $mysql = new Connection();
            return $mysql->update("listadepreseca",$value,$this->getId());
        }


    }
?>