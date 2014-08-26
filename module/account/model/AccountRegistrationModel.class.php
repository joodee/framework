<?php
/**
 * Class AccountRegistrationModel
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
class AccountRegistrationModel extends AccountModel{

    public static function addAccount($account){

        $account['password'] = self::encryptPassword($account['password'], $account['salt'], $account['algorithm']);

        if(empty($account['token'])){

            $account['token'] = substr(hash($account['algorithm'], $account['password'].$account['salt']), 0, 64);
        }

        $query = "INSERT INTO account (acc_id, first_name, last_name, birthday, gender, nickname, username, activated, email, email_canonical, mobile_phone, location_iso2, timezone, lang_iso2, algorithm, salt, password, token, last_logged_ip, role, locked, activation_expires_at, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW());";

        Locator::getAdo()->Execute($query, array(null, $account['first_name'], $account['last_name'], $account['birthday'], $account['gender'], $account['nickname'], $account['username'], $account['activated'], $account['email'], $account['email_canonical'], $account['mobile_phone'], $account['location_iso2'], $account['timezone'], $account['lang_iso2'], $account['algorithm'], $account['salt'], $account['password'], $account['token'], $account['last_logged_ip'], $account['role'], $account['locked'], $account['activation_expires_at']));

        if(!$accId = Locator::getAdo()->Insert_ID()){

            return false;
        }

        return $accId;
    }

    public static function isAccountTableEmpty(){

        $query = "SELECT acc_id FROM account";

        $accId = Locator::getAdo()->GetOne($query);

        if(Locator::getAdo()->ErrorNo() || !empty($accId)){

            return false;
        }

        return true;
    }
}
