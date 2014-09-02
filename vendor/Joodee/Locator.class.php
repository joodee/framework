<?php
/**
 * Class Locator
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
class Locator{

    public static function &getConfig(){

        return LocatorConfig::getConfig();
    }

    public static function &getRoute($filterBranch=false){

        return LocatorRoute::getRoute($filterBranch);
    }

    public static function getRouteUri($absolute=false){

        return LocatorRoute::getUri($absolute);
    }

    /**
     * @static
     * @param string $alias
     * @return ADOConnection
     */
    public static function getAdo($alias = 'default'){

        return LocatorADOdb::getInstance($alias);
    }

    /**
     * @static
     * @param string $alias
     * @return SmartyWrapper
     */
    public static function getSmarty($module = null){

        return LocatorSmarty::getInstance($module);
    }
}
