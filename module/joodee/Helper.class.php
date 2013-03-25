<?php
/**
 * Class Helper
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
class Helper{

    public static function isPost(){

        return strtolower(getenv('REQUEST_METHOD')) == 'post' ? true : false;
    }

    public static function isAjax(){

        if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

            return false;
        }

        return true;
    }

    public static function isDemoRole($role=null){

        if(empty($role)){

            if(empty($_SESSION['account']['role'])){

                return false;
            }
            else{

                $role = $_SESSION['account']['role'];
            }
        }

        if(in_array(strtolower(substr($role, 0, 5)), array('demo_', 'demo-'))){

            return true;
        }

        if(in_array(strtolower(substr($role, -5)), array('_demo', '-demo'))){

            return true;
        }

        return false;
    }

    public static function debug($var, $ip='127.0.0.1'){

        if(is_string($ip)){

            $ip = array($ip);
        }

        if(!is_array($ip) || !in_array(getenv('REMOTE_ADDR'), $ip)){

            return;
        }

        $output = '<pre class="helper-debug">';
        $output .= var_export($var, true);
        $output .= '</pre>';

        echo $output;
    }

    public static function &order($array, $by, $direction='asc', $default=null) {

        $default = is_null($default)?'null':"'".str_replace("'", "\\'", $default)."'";

        $code = "if(!isset(\$a['{$by}'])){\$a['{$by}']={$default};}if(!isset(\$b['{$by}'])){\$b['{$by}']={$default};}";

        if($direction=='asc'){

            $code .= "return strnatcmp(\$a['$by'], \$b['$by']);";
        }
        else{

            $code .= "return strnatcmp(\$b['$by'], \$a['$by']);";
        }

        uasort($array, create_function('$a,$b', $code));

        return $array;
    }

    public static function inhibitRendering($displayStdout = false){

        Joodee::inhibitRendering($displayStdout);
    }

    public static function inhibitOutput(){

        Joodee::inhibitOutput();
    }

    public static function headerJSON($charset = 'utf-8', $replace = true){

        header("Content-type: application/json; charset={$charset}", $replace);

        self::inhibitRendering();
    }

    public static function redirect($url, $inhibitOutput = true, $replaceHeader = true){

        header("Location: {$url}", $replaceHeader);

        if($inhibitOutput){

            self::inhibitOutput();
        }

        return '';
    }

    public static function reroute($uri){

        Joodee::reroute($uri);
    }

    public static function httpStatus($code) {

        static $statusList = array (
            100 => "HTTP/1.1 100 Continue",
            101 => "HTTP/1.1 101 Switching Protocols",
            200 => "HTTP/1.1 200 OK",
            201 => "HTTP/1.1 201 Created",
            202 => "HTTP/1.1 202 Accepted",
            203 => "HTTP/1.1 203 Non-Authoritative Information",
            204 => "HTTP/1.1 204 No Content",
            205 => "HTTP/1.1 205 Reset Content",
            206 => "HTTP/1.1 206 Partial Content",
            300 => "HTTP/1.1 300 Multiple Choices",
            301 => "HTTP/1.1 301 Moved Permanently",
            302 => "HTTP/1.1 302 Found",
            303 => "HTTP/1.1 303 See Other",
            304 => "HTTP/1.1 304 Not Modified",
            305 => "HTTP/1.1 305 Use Proxy",
            307 => "HTTP/1.1 307 Temporary Redirect",
            400 => "HTTP/1.1 400 Bad Request",
            401 => "HTTP/1.1 401 Unauthorized",
            402 => "HTTP/1.1 402 Payment Required",
            403 => "HTTP/1.1 403 Forbidden",
            404 => "HTTP/1.1 404 Not Found",
            405 => "HTTP/1.1 405 Method Not Allowed",
            406 => "HTTP/1.1 406 Not Acceptable",
            407 => "HTTP/1.1 407 Proxy Authentication Required",
            408 => "HTTP/1.1 408 Request Time-out",
            409 => "HTTP/1.1 409 Conflict",
            410 => "HTTP/1.1 410 Gone",
            411 => "HTTP/1.1 411 Length Required",
            412 => "HTTP/1.1 412 Precondition Failed",
            413 => "HTTP/1.1 413 Request Entity Too Large",
            414 => "HTTP/1.1 414 Request-URI Too Large",
            415 => "HTTP/1.1 415 Unsupported Media Type",
            416 => "HTTP/1.1 416 Requested Range Not Satisfiable",
            417 => "HTTP/1.1 417 Expectation Failed",
            500 => "HTTP/1.1 500 Internal Server Error",
            501 => "HTTP/1.1 501 Not Implemented",
            502 => "HTTP/1.1 502 Bad Gateway",
            503 => "HTTP/1.1 503 Service Temporarily Unavailable",
            504 => "HTTP/1.1 504 Gateway Time-out"
        );

        header($statusList[$code]);
    }

    public static function checkAccess($accessLevelHaystack, $role = null){

        if(is_null($accessLevelHaystack)){

            return true;
        }
        elseif(empty($accessLevelHaystack)){

            return false;
        }

        if(is_string($accessLevelHaystack)){

            $accessLevelHaystack = array($accessLevelHaystack);
        }

        $config =& Locator::getConfig();
        $allowFrom = $denyFrom = array();

        foreach($accessLevelHaystack as $accessLevel){

            if($accessLevel{0}=='!'){

                $denyFrom = array_merge($denyFrom, $config['access'][substr($accessLevel, 1)]);
            }
            else{

                $allowFrom = array_merge($allowFrom, $config['access'][$accessLevel]);
            }
        }

        $allowFrom = array_diff($allowFrom, $denyFrom);

        if(is_null($role) && !empty($_SESSION['account']['role'])){

            $role = $_SESSION['account']['role'];
        }

        if(!is_null($role) && in_array($role, $allowFrom)){

            return true;
        }

        return false;
    }
}
