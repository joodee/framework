<?php
/**
 * Class LocatorRoute
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
class LocatorRoute{

    protected static $route;
    protected static $filtered;

    public static function &getRoute($filterBranch = false){

        if($filterBranch){

            if(is_null(self::$filtered)){

                self::$filtered = self::$route;

                foreach(self::$filtered as $key=>$value){

                    if(substr($key, -1)=='/'){

                        unset(self::$filtered[$key]);
                    }
                }
            }

            return self::$filtered;
        }

        return self::$route;
    }

    public static function getUri($absolute=false){

        if($absolute){

            return '//'.getenv('HTTP_HOST').self::$route['uri'];
        }

        return self::$route['uri'];
    }

    public static function setRoute(&$route){

        self::$route =& $route;
    }
}
