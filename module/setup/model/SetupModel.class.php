<?php
/**
 * Class SetupModel
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
class SetupModel{

    public static function databaseExists($name){

        $query = "SELECT IF(? IN(SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA), 1, 0) AS found";

        $found = (bool) Locator::getAdo()->GetOne($query, $name);

        if(Locator::getAdo()->ErrorNo()){

            return false;
        }

        return $found;
    }

    public static function tableExists($name){

        $query = "SHOW TABLES LIKE ?";

        $found = (bool) Locator::getAdo()->GetOne($query, $name);

        if(Locator::getAdo()->ErrorNo()){

            return false;
        }

        return $found;
    }

    public static function createDatabase($name){

        $query = "CREATE DATABASE IF NOT EXISTS `{$name}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

        Locator::getAdo()->Execute($query);

        if(Locator::getAdo()->ErrorNo()){

            return false;
        }

        Locator::getAdo()->Execute("USE `{$name}`");

        return true;
    }
}
