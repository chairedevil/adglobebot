<?php
    class LineLoginLib
    {
        private $_CLIENT_ID;
        private $_CLIENT_SECRET;
        private $_CALLBACK_URL;
        private $_STATE_KEY = 'random_state_str';
        
        public function __construct($_CLIENT_ID,$_CLIENT_SECRET,$_CALLBACK_URL)
        {
            $this->_CLIENT_ID = $_CLIENT_ID;
            $this->_CLIENT_SECRET = $_CLIENT_SECRET;
            $this->_CALLBACK_URL = $_CALLBACK_URL;
        }   
    
        public function authorize()
        {
            if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
            
            $_SESSION[$this->_STATE_KEY] = $this->randomToken();
    
            $url = "https://access.line.me/oauth2/v2.1/authorize?".
                http_build_query(array(
                    'response_type' => 'code', // ไม่แก้ไขส่วนนี้
                    'client_id' => $this->_CLIENT_ID,
                    'redirect_uri' => $this->_CALLBACK_URL,
                    'scope' => 'profile', // ไม่แก้ไขส่วนนี้
                    'state' => $_SESSION[$this->_STATE_KEY]
                )
            );
            $this->redirect($url);
        }

        public function requestAccessToken($params, $returnResult = NULL, $ssl = NULL)
        {
            $_SSL_VERIFYHOST = (isset($ssl))?2:0;
            $_SSL_VERIFYPEER = (isset($ssl))?1:0;
            if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
                
            if(!isset($_SESSION[$this->_STATE_KEY]) || $params['state'] !== $_SESSION[$this->_STATE_KEY]){
                if(isset($_SESSION[$this->_STATE_KEY])){ unset($_SESSION[$this->_STATE_KEY]); }
                return false;
            }
            
            if(isset($_SESSION[$this->_STATE_KEY])){ unset($_SESSION[$this->_STATE_KEY]); }
            
            $code = $params['code'];
            $tokenURL = "https://api.line.me/oauth2/v2.1/token";
            
            $headers = array(
                'Content-Type: application/x-www-form-urlencoded'
            );
            $data = array(
                'grant_type' => 'authorization_code',
                'code' => (string)$code,
                'redirect_uri' => $this->_CALLBACK_URL,
                'client_id' => $this->_CLIENT_ID,
                'client_secret' => $this->_CLIENT_SECRET              
            );
            
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $tokenURL);
            curl_setopt( $ch, CURLOPT_POST, 1);
            curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, $_SSL_VERIFYHOST);
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, $_SSL_VERIFYPEER);
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec( $ch );
            $httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE);
            curl_close( $ch );
            
            $result = json_decode($result,TRUE);
    
            if($httpCode == 200){
                if(!is_null($result) && array_key_exists('access_token',$result)){
                    if(is_null($returnResult)){
                        return $result['access_token'];                 
                    }else{
                        if(array_key_exists('id_token',$result)){
                            $userData = explode(".",$result['id_token']);
                            list($alg,$data) = array_map('base64_decode',$userData);
                            $result['alg'] = $alg;
                            $result['user'] = $data;
                        }                   
                        return $result;     
                    }
                }else{
                    return NULL;    
                }                   
            }else{
                if(is_null($returnResult)){
                    return NULL;
                }else{
                    return $result;         
                }                           
            }
        }
    }