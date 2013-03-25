<?php

class DemoController{

    public static function fetchTemplateAction($template = 'page_blank.tpl'){

        return Locator::getSmarty()->fetch($template);
    }

    public static function contactAction(){

        return Locator::getSmarty()->fetch('contact.tpl');
    }

    public static function userAreaAction(){

        return Locator::getSmarty()->fetch('dashboard_user.tpl');
    }

    public static function sidebarLeftWidget(){

        $route =& Locator::getRoute();

        switch($route['uri']){

            case '/': {

                return Locator::getSmarty()->fetch('sidebar_left.tpl');
            }
            default: {

                return '';
            }
        }
    }

    public static function sidebarRightWidget(){

        $route =& Locator::getRoute();

        switch($route['uri']){

            case '/': {

                return '';
            }
            default:{

                return Locator::getSmarty()->fetch('sidebar_right.tpl');
            }
        }
    }

    public static function backendSidebarWidget(){

        return Locator::getSmarty()->fetch('sidebar_backend_dashboard.tpl');
    }

    public static function fetchWidget($template = 'widget_blank.tpl'){

        return Locator::getSmarty()->fetch($template);
    }

    public static function userTopMenuWidget(){

        if(empty($_SESSION['account']['id'])){

            $account = array();
        }
        else{

            $account = AccountModel::getAccount($_SESSION['account']['id'], true);
        }

        Locator::getSmarty()->assignByRef('account', $account);

        return Locator::getSmarty()->fetch('menu_top_user.tpl');
    }

    public static function testCron(){

        echo "Successfully executed!\n";
    }
}
