<?php

class ErrorController{

    public static function indexAction(){

        $errorAlias = '';

        if(!empty($_GET[0]) && is_string($_GET[0])){

            $errorAlias = $_GET[0];
        }

        switch($errorAlias){

            case '403':{

                Helper::httpStatus(403);
                return Locator::getSmarty()->fetch('page_error_403.tpl');
            }
            case '404':{

                Helper::httpStatus(404);
                return Locator::getSmarty()->fetch('page_error_404.tpl');
            }
            case 'connection':{

                Helper::httpStatus(503);
                Helper::inhibitRendering();
                return Locator::getSmarty()->fetch('page_error_connection.tpl');
            }
            default: {

                Helper::httpStatus(500);
                return Locator::getSmarty()->fetch('page_error_500.tpl');
            }
        }
    }

    public static function onBeforeActionCallCheckDatabaseConnectionEventHandler(){

        static $rerouted = false;

        $route =& Locator::getRoute(true);

        if($route['action']['class']=='Setup'){

            return;
        }

        if(empty(Locator::getAdo()->_connectionID) && !$rerouted){

            $rerouted = true;

            Helper::reroute('/error/connection/');
        }
        elseif(!Locator::getAdo()->GetOne('SELECT DATABASE()') && !$rerouted){

            $rerouted = true;

            Helper::reroute('/error/connection/');
        }
    }
}
