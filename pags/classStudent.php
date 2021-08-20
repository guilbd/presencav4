<?php
    include_once('classConnection.php');
    Class Student{
        // function to make one instance from class
        // função para criar uma instancia da classe
        function  __construct(int $id = 0,string $cpf = "",string $name = ""){
            $this->id = $id;
            $this->cpf = $cpf;
            $this->name = $name;
        }
        // all get functions
        // todas funções get
        function getId(){
            return $this->id;
        }
        function getCpf(){
            return $this->cpf;
        }
        function getName(){
            return $this->name;
        }
        //all set functions to set values
        //todas funções para setar valores
        function setId($value){
            $this->id = $value;
        }
        function setCpf($value){
            $this->cpf = $value;
        }
        function setName($value){
            $this->name = $value;
        }
        //all methods to make actions
        //todos metodos para realizar ações
        //select db method
        //metodo para selecionar no banco 
        function selectStudent($value){
            $mysql = new Connection();
            $valueresponse = $mysql->select('alunos',"id,cpf,nome",$value);
            if(is_array($valueresponse)){
                $this->setId($valueresponse[0]);
                $this->setCpf($valueresponse[1]);
                $this->setName($valueresponse[2]);
                return "";
            }else{
               
                return "erro";
            }
            

        }

    }