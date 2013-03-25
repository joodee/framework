<?php
/**
 * Class AccountModel
 *
 * Joodee Framework v1.0 - http://www.joodee.org
 * ==========================================================
 *
 * Copyright 2012-2013 Alexandr Zincenco <alex@joodee.org>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
class AccountModel{

    protected static $account_cache = array();

    public static function getAccount($accId, $cache = true, $fromCache = false){

        if($fromCache && !empty(self::$account_cache[$accId])){

            return self::$account_cache[$accId];
        }

        $query = "SELECT * FROM account WHERE acc_id=?";

        if($cache){

            return self::$account_cache[$accId] = Locator::getAdo()->GetRow($query, $accId);
        }

        return Locator::getAdo()->GetRow($query, $accId);
    }

    public static function encryptPassword($password, $salt, $algorithm){

        return hash($algorithm, $password.$salt);
    }

    public static function getAccountByUsername($username, $activatedOnly = true, $excludeAccId = null, $inclusiveDeleted=false){

        $query = "SELECT * FROM account WHERE username=?";

        $args = array($username);

        if($activatedOnly){

            $query .= " AND activated='Yes'";
        }

        if(!empty($excludeAccId)){

            $query .= " AND acc_id<>?";
            $args[] = $excludeAccId;
        }

        if(!$inclusiveDeleted){

            $query .= " AND deleted='No'";
        }

        return Locator::getAdo()->GetRow($query, $args);
    }

    public static function getAccountByEmail($email, $activatedOnly = true, $excludeAccId = null, $inclusiveDeleted = false){

        if($activatedOnly){

            $query = "SELECT * FROM account WHERE (email=? OR email_canonical=?) AND activated='Yes'";
        }
        else{

            $query = "SELECT * FROM account WHERE (email=? OR email_canonical=?)";
        }

        $args = array($email, $email);

        if(!empty($excludeAccId)){

            $query .= " AND acc_id<>?";
            $args[] = $excludeAccId;
        }

        if(!$inclusiveDeleted){

            $query .= " AND deleted='No'";
        }

        return Locator::getAdo()->GetRow($query, $args);
    }

    public static function updateAccountField($accId, $fieldName, $value){

        $query = "UPDATE account SET {$fieldName}=? WHERE acc_id=?";

        Locator::getAdo()->Execute($query, array($value, $accId));

        if(Locator::getAdo()->ErrorNo()){

            return false;
        }

        return true;
    }

    public static function updateAccountToken($accId, $account){

        $token = substr(hash($account['algorithm'], $account['token'].$account['salt']), 0, 64);

        return self::updateAccountField($accId, 'token', $token);
    }

    public static function deleteAccount($accId, $physically = false){

        if($physically){

            $query = "DELETE FROM account WHERE acc_id=?";
        }
        else{

            $query = "UPDATE account SET deleted = 'Yes' WHERE acc_id=?";
        }

        Locator::getAdo()->Execute($query, $accId);

        if(Locator::getAdo()->ErrorNo()){

            return false;
        }

        return true;
    }

    public static function getFoundRows(){

        return Locator::getAdo()->GetOne('SELECT FOUND_ROWS()');
    }

    /**
     * @return ADORecordSet | false
     */
    public static function getAccountsActivationExpired(){

        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM account WHERE activated='No' AND activation_expires_at IS NOT NULL AND activation_expires_at<NOW() AND deletion_scheduled_at IS NULL AND deleted='No'";

        $recSet = Locator::getAdo()->Execute($query);

        if(Locator::getAdo()->ErrorNo()){

            return false;
        }

        return $recSet;
    }

    /**
     * @return ADORecordSet | false
     */
    public static function getAccountsScheduledForDeletionNrOfDays($nofDays, $deletePhysically){

        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM account WHERE deletion_scheduled_at < DATE_SUB(NOW(), INTERVAL ? DAY) AND deleted='No'";

        if(!$deletePhysically){

            $query .= " AND deleted='No'";
        }

        $recSet = Locator::getAdo()->Execute($query, $nofDays);

        if(Locator::getAdo()->ErrorNo()){

            return false;
        }

        return $recSet;
    }
}
