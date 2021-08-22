<?php
    Class Connection{
        //declare variables
        //declaração de variaveis
        function __construct(string $localhost = "127.0.0.1",
        string $user = "root",string $password = "",string $database = "presenca") {
            $this->localhost = $localhost;
            $this->user = $user;
            $this->password = $password;
            $this->database = $database;
        } 
        //making the connection
        //conectando
        function connect(){
            $connected = new mysqli($this->localhost,$this->user,$this->password,$this->database);
            //trying the connection and returning one error, when the connection don't have success.
            //tentando conectar e devolvendo um erro , quando não houver sucesso na mesma.
            if ($connected->error) {
                die("Connection failed: " . $conn->connect_error);
            
            }else{
                return $connected;
            }
                            
        }
        function select($table,$colums,$value){
            $connected = $this->connect();
            if(strcmp($value,"")!=0){
                $table = $table." WHERE ".$value;
            }else{
                $table = $table;
            }
            
                //sql methods
                //metodos sql
                $sqlscript = "SELECT ".$colums." FROM ".$table;
                
                $sql = $connected->query($sqlscript);
                
                
                    if($sql!=FALSE){
                        if ($sql->num_rows > 0) {
                            $result = [];
                            $colum = explode(",",$colums);
                        
                            while($row = $sql->fetch_assoc()) {
                                for($i =0; $i<count($colum);$i++){
                                    array_push($result,$row[$colum[$i]]);
                                }
                            }
                            $this->exitConnection($connected);
                        
                            return $result;
                        }
                        else{
                            return "erro";
                        }
                    }else{
                        
                        return "erro";
                    }
            
            
            
        }
        function insert($table,$colums,$value){
            //connection with database
           //conexão com a database
           $connected = $this->connect();
           
           //sql methods
           //metodos sql
               $sqlscript =  "INSERT INTO ".$table." (".$colums.") VALUES (".$value.")";
             
               if($connected->query($sqlscript) === TRUE){
                   $this->exitConnection($connected);
                   
                   return "";
                   
               }
               else{
                    $this->exitConnection($connected);
                    
                    
                   return "error in query execution";
               }
          
       }
        //update one existent financer data
        //atualiza dados de uma financia existente
        function update($table,$value,$id){
                //connection with database
            //conexão com a database
            $connected = $this->connect();
           
                //sql methods
                //metodos sql
                    $sqlscript = "UPDATE ".$table." SET ".$value." WHERE id = ".$id;
                    if(mysqli_query($connected,$sqlscript)){
                        $this->exitConnection($connected);
                        return "sucess";
                    }
                    else{
                        $this->exitConnection($connected);
                        return "error in query execution";
                    }
                
        }
            // closing the connection
            //fechando a connexão
        function exitConnection($connected){
            mysqli_close($connected);
        }
            
        function __destruct()
        {

        }
        

    }

?>