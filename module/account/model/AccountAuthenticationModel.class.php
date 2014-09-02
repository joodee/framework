<?php
/**
 * Class AccountAuthenticationModel
 *
 * Joodee Framework v1.1 - http://www.joodee.org
 * ==========================================================
 *
 * Copyright 2012-2014 Alexandr Zincenco <alex@joodee.org>
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
class AccountAuthenticationModel extends AccountModel{

    public static function updateAccountLastIp($accId, $lastIp){

        $query = "UPDATE account SET last_logged_at=NOW(), last_logged_ip=? WHERE acc_id=?";

        Locator::getAdo()->Execute($query, array($lastIp, $accId));
    }
}
