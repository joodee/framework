<?php
/**
 * Class LocatorADOdb
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
class LocatorADOdb{

    protected static $instance;

    /**
     * @static
     * @param string $alias
     * @return ADOConnection
     */
    public static function getInstance($alias = 'default'){

        $config =& Locator::getConfig();
        $connection =& $config['connection']['adodb'][$alias];

        if(empty(self::$instance[$alias])){

            if(!empty($connection['define']) && is_array($connection['define'])){

                foreach($connection['define'] as $key=>$value){

                    if(!defined($key)){

                        define($key, $value);
                    }
                }
            }

            if(!empty($connection['include']) && is_array($connection['include'])){

                foreach($connection['include'] as $filename){

                    include_once $config['path']['vendor']."/ADOdb/{$filename}";
                }
            }

            self::$instance[$alias] = ADONewConnection($connection['driver']);

            if(empty($connection['persistent'])){

                self::$instance[$alias]->Connect($connection['host'], $connection['user'], $connection['password']);
            }
            else{

                self::$instance[$alias]->PConnect($connection['host'], $connection['user'], $connection['password']);
            }

            self::$instance[$alias]->Execute("USE `{$connection['database']}`");

            if(isset($connection['debug'])){

                self::$instance[$alias]->debug = (bool) $connection['debug'];
            }

            self::$instance[$alias]->setFetchMode(ADODB_FETCH_ASSOC);

            if(!empty($connection['execute']) && is_array($connection['execute'])){

                foreach($connection['execute'] as $query){

                    self::$instance[$alias]->Execute($query);
                }
            }
        }

        return self::$instance[$alias];
    }

    public static function instanceExists($alias){

        if(isset(self::$instance[$alias])){

            return true;
        }

        return false;
    }

    public static function destroyInstance($alias){

        if(isset(self::$instance[$alias])){

            self::$instance[$alias]->Disconnect();
        }

        return true;
    }

    private function __construct() {}

    private function __clone() {}

    private function __wakeup() {}

}
