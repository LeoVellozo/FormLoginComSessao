<?php
    function config(){
        $retorno['host']      = 'localhost';
        $retorno['user']      = 'root';
        $retorno['password']  = '';
        $retorno['db']        = 'login';

        return $retorno;
    }

    function mysqlConnect($config){
        return mysqli_connect($config['host'],$config['user'],$config['password'],$config['db']);
    }

    function login($login, $password, $config){
        $retorno = [
            'success' => false,
            'msg'     => 'Você precisa estar logado para acessar está pagina!'
        ];
        
       
        $sql = mysqli_query(mysqlConnect($config), "SELECT user, password FROM users WHERE user = '$login'  AND password = '".md5($password)."' ");

        if(mysqli_num_rows($sql) < 1){
            return $retorno;           
        }else{
            $retorno['success'] = true;
            $retorno['msg'] = 'Login efetuado';                        
        }

        $arrLogin = [
            'user' => $login,
            'password' => md5($password)
        ];

        montaSessao($arrLogin);
        
        return $retorno;
    }

    function logout(){
        if(count($_SESSION) <=0) return false;
        session_destroy();
    }

    function montaSessao($arrLogin){
        if(count($arrLogin) <= 0) return false;        

        foreach($arrLogin as $key => $value){
            $_SESSION[$key] = $value;
        }        
    }

?>