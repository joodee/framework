<?php

class AppController{

    public static function blankAction(){

        return '';
    }

    public static function fetchTemplateAction($template = 'frontend/page_blank.tpl'){

        if(isset($_GET[0]) && $_GET[0]!==''){

            return Helper::reroute('/error/404/');
        }

        return Locator::getSmarty()->fetch($template);
    }

    public static function accountAreaAction(){

        if(isset($_GET[0]) && $_GET[0]!==''){

            return Helper::reroute('/error/404/');
        }

        return Locator::getSmarty()->fetch('frontend/page_account_home.tpl');
    }

    public static function sidebarLeftWidget(){

        $route =& Locator::getRoute();

        switch($route['uri']){

            case '/': {

                return Locator::getSmarty()->fetch('frontend/widget_sidebar_left.tpl');
            }
            default: {

                return '';
            }
        }
    }

    public static function fetchWidget($template = 'frontend/widget_blank.tpl'){

        return Locator::getSmarty()->fetch($template);
    }

    public static function navbarWidget($template = 'frontend/widget_navbar.tpl'){

        if(empty($_SESSION['account']['id'])){

            $account = array();
        }
        else{

            $account = AccountModel::getAccount($_SESSION['account']['id'], true);
        }

        Locator::getSmarty()->assignByRef('account', $account);

        return Locator::getSmarty()->fetch($template);
    }

    public static function testCron(){

        echo "Successfully executed!\n";
    }
}
