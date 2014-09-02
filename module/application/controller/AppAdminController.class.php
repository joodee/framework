<?php

class AppAdminController{

    public static function indexAction(){

        if(isset($_GET[0]) && $_GET[0]!==''){

            return Helper::reroute('/error/404/');
        }

        return Locator::getSmarty()->fetch('backend/page_dashboard.tpl');
    }

    public static function fetchWidget($template = 'backend/widget_blank.tpl'){

        return Locator::getSmarty()->fetch($template);
    }

    public static function navbarWidget($template = 'backend/widget_navbar.tpl'){

        if(empty($_SESSION['account']['id'])){

            $account = array();
        }
        else{

            $account = AccountModel::getAccount($_SESSION['account']['id'], true);
        }

        Locator::getSmarty()->assignByRef('account', $account);

        return Locator::getSmarty()->fetch($template);
    }
}
