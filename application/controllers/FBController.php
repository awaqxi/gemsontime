<?php

class FBController extends Zend_Controller_Action
{

    public function init()
    {
    	
    }

    public function indexAction()
    {
    	$app_id = '468987789814576';
        $app_secret = '078fe33f3182c36111b82543e3c53f2d';
        $my_url = 'http://gemsontime.dev/fb';
        
        $code = $_REQUEST["code"];
        if(empty($code)) {
            $dialog_url = 'https://www.facebook.com/dialog/oauth?client_id=' 
            . $app_id . '&redirect_uri=' . urlencode($my_url) ;
            echo("<script>top.location.href='" . $dialog_url . "'</script>");
        }
        
        //получаем токен
        $token_url = 'https://graph.facebook.com/oauth/access_token?client_id='
        . $app_id . '&redirect_uri=' . urlencode($my_url) 
        . '&client_secret=' . $app_secret 
        . '&code=' . $code;
         
        $access_token = file_get_contents($token_url);
        
        echo($access_token);
        
        /*
        ------------------------------------------
        далее можно делать запросы в виде:
        $fql_query_url = 'https://graph.facebook.com/'   
        . '/fql?q=SELECT+uid+FROM+event_member+WHERE+uid=me()'
        . '&access_token=' . $access_token;
        echo($fql_query_url);
        ------------------------------------------
        */
        
    }
}