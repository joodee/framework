<?php
/**
 * Class AccountProfileModel
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
class AccountProfileModel extends AccountModel{

    public static function updateProfile($profile, $accId){

        $query = "UPDATE account SET first_name=?, last_name=?, birthday=?, gender=?, nickname=?, email=?, mobile_phone=?, location_iso2=?, timezone=?, updated_at=NOW() WHERE acc_id=?";

        Locator::getAdo()->Execute($query, array($profile['first_name'], $profile['last_name'], $profile['birthday'], $profile['gender'], $profile['nickname'], $profile['email'], $profile['mobile_phone'], $profile['location_iso2'], $profile['timezone'], $accId));

        if(Locator::getAdo()->ErrorNo()){

            return false;
        }

        return true;
    }

}
