<?php

class DemoModel{

    /**
     * This is just an example
     *
     * @static
     * @param null $accId
     * @return string
     */
    public static function getAccountFirstNameExample($accId = null){

        if(empty($accId) && !empty($_SESSION['account']['id'])){

            $accId = $_SESSION['account']['id'];
        }

        if(!empty($accId)){

            $query = "SELECT first_name FROM account WHERE acc_id=?";

            return (string) Locator::getAdo()->GetOne($query, $accId);
        }

        return '';
    }
}
