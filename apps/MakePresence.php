<?php
    include_once('pags/classStudent.php');
    include_once('pags/classPresence.php');
    Class MakePresence{
        // construct method
        // metodo construtor
        function __construct(string $sessionid = "",string $sessionpresenceid = "",date $sessiondate = Null,time $sessiontime = NULL,
        string $sessioncpf = "",string $sessionip = "",string $sessionname = ""){
            $this->sessionid = $sessionid;
            $this->sessionpresenceid = $sessionpresenceid;
            $this->sessiondate = $sessiondate;
            $this->sessiontime = $sessiontime;
            $this->sessioncpf = $sessioncpf;
            $this->sessionip = $sessionip;
            $this->sessionname = $sessionname;
        }
        //get methods
        //metodos para pegar
        function getSessionId(){
            return $this->sessionid;
        }
        function getSessionPresenceId(){
            return $this->sessionpresenceid;
        }
        function getSessionDate(){ 
            return $this->sessiondate;
        }
        function getSessionTime(){
            return $this->sessiontime;
        }
        function getSessionCpf(){
            return $this->sessioncpf;
        }
        function getSessionIp(){
            return $this->sessionip;
        }
        function getSessionName(){
            return $this->sessionname;
        }
        //set methods
        //metodos para setar
        function setSessionId($value){
            $this->sessionid = $value;
        }
        function setSessionPresenceId($value){
            $this->sessionpresenceid = $value;
        }
        function setSessionDate($value){
            $this->sessiondate = $value;
        }
        function setSessionTime($value){
            $this->sessiontime = $value;
        }
        function setSessionCpf($value){
            $this->sessioncpf = $value;
        }
        function setSessionIp($value){
            $this->sessionip = $value;
        }
        function setSessionName($value){
            $this->sessionname = $value;
        }
        //action methods
        //metodos para as ações
        //gera mensagens
        function messages($code,$value){
            $message = "nao existe";
            $data = explode("-",$this->getSessionDate());
            switch ($code) {
                case 0:
                    // Case the new presence ok
                    // no caso de uma nova presença
                    $message = ucfirst(strtolower($this->getSessionName())).
                            ".<br>Sua ".substr($value, -1).
                            "ª Presença foi registrada em: <br>".
                            $this->getSessionTime()."<br> do dia <br>".$data[2].
                            "/".$data[1]."/".$data[0]."!";
                    break;
                case 1:
                    // case the presence has existence
                    // caso a presenca exista
                    $message = ucfirst(strtolower($this->getSessionName())).
                            ". <br>A sua ".substr($value, -1).
                            "ª presença já foi registrada em: <br>".
                            $data[2]."/".$data[1]."/".$data[0].
                            " <br>às: <br>".$this->getSessionTime();
                    break;
                case 2:
                    //case not have cookie or ip registered
                    //caso não haja cookie ou ip registrado
                    $message = "Seu CPF não está cadastrado em nosso banco de alunos matriculados.<br> Por favor entre em contato com a Blue no discord.";
                    break;
                case 3:
                    //case out of time
                    //caso fora de horário
                    $message = ucfirst(strtolower($this->getSessionName())).".<br> O horário do registro de chamada está incorreto.";
                    break;
                case 4:
                    //case dont have ip
                    //caso não tenha ip
                    $message = "Desative seu ADBLOCK para que possamos capturar o IP";
                    break;
                case 5:
                    $message = "Error Ao Efetuar Presença";
                    break;
               
            }
            return $message;
        }
        //verifica presença
        function verifyPresence($default){
            
            $presence = new Presence();
            if(strcmp($this->getSessionId(),"0")!=0 && strcmp($this->getSessionId(),"")!=0){
                
               return $this->markPresence($presence,$default);
            }else if($this->getSessionIp()!=""){
                $presenceresponse = $presence->selectPresence("IPdispositivo='".$this->sessionip."'");
                if(strcmp($presenceresponse,"")==0){
                    $this->setSessionId($presence->getIdStudent());
                   return $this->markPresence($presence,$default);
                }
                else{
                    if(strcmp($this->getSessionCpf(),"")==0){
                        return "register";
                    }else{
                        $response = $this->verifyRegister();
                        if(strcmp($response,"")==0){
                            return $this->verifyPresence($default);
                        }else{
                            return $this->messages(2,"");
                        }
                    }
                }
            }else{
                return $this->messages(4,"");
            }
        }
        //verifica registro
        function verifyRegister(){
            $student = new Student();
            $studentresponse = "nada";
            
            if(strcmp($this->getSessionCpf(),"")!=0){
                
                $studentresponse = $student->selectStudent("cpf='".$this->getSessionCpf()."'");
                if(strcmp($studentresponse,"")==0){
                    setcookie("blueid",$student->getId(), time()+2*24*60*60);
                    $this->setSessionId($student->getId());
                    $this->setSessionName($student->getName());
                    return "";
                }else{
                    return "erro";
                }
                
            }
            else if(strcmp($this->getSessionId(),"0")!=0&&strcmp($this->getSessionId(),"")!=0){
                $studentresponse = $student->selectStudent("id='".$this->getSessionId()."'");
                if(strcmp($studentresponse,"")==0){
                    
                    setcookie("blueid",$student->getId(), time()+2*24*60*60);
                    $this->setSessionId($student->getId());
                    $this->setSessionName($student->getName());
                    return "";
                }else{
                    return "erro";
                }

            }else{
                
                return "erro";
            }
            
            
        }
        //marca presença
        function markPresence($presence,$default){
            $studentresponse = $this->verifyRegister();
            
            // in case the student exist
            //caso exista o cadastro do estudante
            if(strcmp($studentresponse,"")==0){
                
                $presenceresponse = $presence->selectPresence("id_cadastro='".$this->getSessionId()."'AND data='".$this->getSessionDate()."'");
                
                // in case the presence dont exist
                // no caso da presença não existir
                if(strcmp($presenceresponse,"erro")==0){
                    
                    $presence->setIp($this->getSessionIp());
                    $presence->setIdStudent($this->getSessionId());
                    $presence->setDatePresence($this->getSessionDate());
                    
                    // in case presence 1
                    // no caso pra primeira presença
                    if(strcmp($default,'Presenca1')==0){
                       
                        if($presence->getFirstPresence()==NULL){
                            $presence->setFirstPresence($this->getSessionTime());
                            $responseinsert = $presence->insertPresence($default);
                            if (strcmp($responseinsert,"")==0){
                                return $this->messages(0,"Presenca1");
                            }else{
                                return $this->messages(5,"Presenca1");
                            }
                        }
                        else{
                            setFirstPresence($presence->getFirstPresence());
                            return $this->messages(1,"Presenca1");
                        }
                     // in case presence 2
                    // no caso pra segunda presença
                    }else if(strcmp($default,'Presenca2')==0){
                        if($presence->getSecondPresence()==NULL){
                            $presence->setSecondPresence($this->getSessionTime());
                            
                            $responseinsert = $presence->insertPresence($default);
                            if (strcmp($responseinsert,"")==0){
                                return $this->messages(0,"Presenca2");
                            }else{
                                return $this->messages(5,"Presenca2");
                            }
                        }
                        else{
                            $this->setSecondPresence($presence->getSecondPresence());
                            return $this->messages(1,"Presenca2");
                        }
                     // in case presence 3
                    // no caso pra terceira presença
                    }else if(strcmp($default,'Presenca3')==0){
                        if($presence->getThirdPresence()==NULL){
                            $presence->setThirdPresence($this->getSessionTime());
                            
                            $responseinsert = $presence->insertPresence($default);
                            if (strcmp($responseinsert,"")==0){
                                return $this->messages(0,"Presenca3");
                            }else{
                                return $this->messages(5,"Presenca3");
                            }
                        }
                        else{
                            $this->setThirdPresence($presence->getThirdPresence());
                            return $this->messages(1,"Presenca3");
                        }
                    }else{
                        return $this->messages(3,"");
                    }
                    
                // in case the presence exist
                // no caso da presença existir
                }else{
                    
                    $this->setSessionPresenceId($presence->getId());
                     // in case presence 1
                    // no caso pra primeira presença
                    if(strcmp($default,'Presenca1')==0){
                        
                        if($presence->getFirstPresence()==NULL){
                           $presence->updatePresence("Presenca1='".$this->getSessionTime()."'");
                           return $this->messages(0,"Presenca1");
                        }
                        else{
                            $this->setSessionTime($presence->getFirstPresence());
                            return $this->messages(1,"Presenca1"); 
                        }
                     // in case presence 2
                    // no caso pra segunda presença
                    }else if(strcmp($default,'Presenca2')==0){
                        if($presence->getSecondPresence()==NULL){
                            $presence->updatePresence("Presenca2='".$this->getSessionTime()."'");
                            return $this->messages(0,"Presenca2");
                        }
                        else{
                            $this->setSessionTime($presence->getSecondPresence());
                            return $this->messages(1,"Presenca2");
                        }
                     // in case presence 3
                    // no caso pra terceira presença
                    }else if(strcmp($default,'Presenca3')==0){
                        if($presence->getThirdPresence()==NULL){
                            $presence->updatePresence("Presenca3='".$this->getSessionTime()."'");
                            return $this->messages(0,"Presenca3");
                        }
                        else{
                            $this->setSessionTime($presence->getThirdPresence());
                            return $this->messages(1,"Presenca3");
                        }
                    }else{
                        return $this->messages(3,"");
                    }
                }
                //In case the student dont exist
            }else{  
                         
                return $this->messages(2,"");     
            }
        }
        
    }
?>