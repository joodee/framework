<?php
/**
 * Class AccountActivityModel
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
class AccountActivityModel{

    public static function getEventCount($actType){

        $query = "SELECT act_count FROM account_activity WHERE act_type=? AND act_ip=? AND act_expire_at>NOW()";

        $args = array($actType, getenv('REMOTE_ADDR'));

        if(empty($_SESSION['account']['id'])){

            $query .= " AND acc_id IS NULL";
        }
        else{

            $query .= " AND acc_id=?";
            $args[] = $_SESSION['account']['id'];
        }

        return (integer) Locator::getAdo()->GetOne($query, $args);
    }

    public static function addEvent($actType, $lifeTime){

        $query = "UPDATE account_activity SET act_count=act_count+1, act_expire_at=(NOW() + INTERVAL ? SECOND) WHERE act_type=? AND act_ip=? AND act_expire_at>NOW()";

        $args = array($lifeTime, $actType, getenv('REMOTE_ADDR'));

        if(empty($_SESSION['account']['id'])){

            $query .= " AND acc_id IS NULL";
        }
        else{

            $query .= " AND acc_id=?";
            $args[] = $_SESSION['account']['id'];
        }

        Locator::getAdo()->Execute($query, $args);

        if(!Locator::getAdo()->Affected_Rows()){

            return self::insertEvent($actType, $lifeTime);
        }

        return true;
    }

    private static function insertEvent($actType, $lifeTime){

        $query = "INSERT INTO account_activity (acc_id, act_type, act_ip, act_count, act_at, act_expire_at) VALUES (?, ?, ?, 1, NOW(), NOW() + INTERVAL ? SECOND)";

        Locator::getAdo()->Execute($query, array(empty($_SESSION['account']['id'])?null:$_SESSION['account']['id'], $actType, getenv('REMOTE_ADDR'), $lifeTime));

        if(Locator::getAdo()->ErrorNo()){

            return false;
        }

        return true;
    }


}
