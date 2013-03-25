<?php

class DemoAdminController{

    public static function indexAction(){

        return Locator::getSmarty()->fetch('dashboard_admin.tpl');
    }
}
