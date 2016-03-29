<?php
/******** © Kwik.Social InterNet Ltd ( http://www.kwik.social ) ***********
*
*
/*********** Author: Ravinder Payal ******************
*
*
/***************Date / Time :- 27 Sept 2015 10:25 PM  *****************/


class OrientDB{
    private $host,$username,$password;
    private $connection;
    function __construct($host,$username,$password){
        if(empty($host)){
            throw "Host Address Not Provide";
            }
            if(empty($username) || empty($password)){
            throw "Provide Username / Password. Receaved Empty Strings";
            }
        $this->host=$host;
        $this->username=$username;
        $this->password=$password;
        }
    function connect(){
        $this->connection=curl_init();
        curl_setopt($this->connection, CURLOPT_USERPWD, $this->username.":".$this->password);
        curl_setopt($this->connection, CURLOPT_RETURNTRANSFER, 1);
        }
    function query($db,$query){
            curl_setopt($this->connection, CURLOPT_URL, $this->host."/batch/".$db);
            curl_setopt($this->connection, CURLOPT_CUSTOMREQUEST, "POST"); 
            curl_setopt($this->connection, CURLOPT_POST,1);
            $json='{ "transaction" : true,"operations" : [{"type" : "script","language" : "sql","script" : [ "'.$query.'" ]}]}';
            curl_setopt($this->connection, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive','Content-Length: ' . strlen($json) ));
            curl_setopt($this->connection, CURLOPT_POSTFIELDS, $json);
            $result=curl_exec($this->connection);
            $http_code=curl_getinfo($this->connection,CURLINFO_HTTP_CODE);
            if($http_code!=200){
                            if($http_code==0){
                                 throw new Exception("Host is not accessible.");
                                }
                $result=json_decode($result);
                 throw new Exception("Server returned  ".$result->errors[0]->content." With code ".$result->errors[0]->code);
            }
            $result=json_decode($result);           
            return $result;

        }
    function close(){
        curl_close($this->connection);
        $this->host=NULL;
        $this->username=NULL;
        $this->password=NULL;
        }   
}
