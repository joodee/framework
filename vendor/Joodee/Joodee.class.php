<?php
/**
 * Class Joodee
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
class Joodee{

    protected static $output = '';
    protected static $rawOutput = '';
    protected static $widgetRawOutput = array();
    protected static $inhibitRendering = false;
    protected static $displayStdout = false;
    protected static $inhibitOutput = false;
    protected static $routeDenied = false;
    protected static $reroute = false;
    protected static $meta = array();
    protected static $links = array();
    protected static $scripts = array();
    protected static $csrfAttempt = false;

    public static function run($iniSet = true){

        ob_start();

        $config =& Locator::getConfig();
        $smarty = Locator::getSmarty();
        $smarty->assignByRef('__config', $config);

        if(!empty($config['events']['onBeforeRun'])){

            self::callEventHandlers($config['events']['onBeforeRun']);
        }

        if(!empty($config['headers'])){

            foreach($config['headers'] as $value){

                header($value);
            }
        }

        if($iniSet && !empty($config['environment']['ini_set'])){

            foreach($config['environment']['ini_set'] as $key=>$value){

                ini_set($key, $value);
            }
        }

        // If session id exists and session not started
        if(!empty($_COOKIE[session_name()]) && session_id()==''){

            // Begin of CSRF protection

            // Strip port
            $httpHost = current(explode(':', getenv('HTTP_HOST')));

            $refererHost = parse_url(getenv('HTTP_REFERER'), PHP_URL_HOST);

            if(!empty($config['csrf_allow_subdomains']) && !empty($refererHost)){

                $hostPieces = explode('.', $httpHost);
                $lastPiece = array_pop($hostPieces);
                $httpHost = array_pop($hostPieces) . '.' . $lastPiece;

                if(substr($refererHost, -strlen($httpHost)) == $httpHost){

                    $refererHost = $httpHost;
                }
            }

            self::$csrfAttempt = false;

            if($config['csrf_protection_mode'] == 'post'){

                if(Helper::isPost() && (empty($refererHost) || $refererHost != $httpHost)){

                    self::$csrfAttempt = true;
                }
            }
            elseif($config['csrf_protection_mode'] == 'get'){

                if(!empty($refererHost) && $refererHost != $httpHost){

                    self::$csrfAttempt = true;
                }
            }

            if(!self::$csrfAttempt){

                session_start();

                $cookieParams = session_get_cookie_params();

                if(empty($_SESSION['account']['remember'])){

                    $cookieParams['lifetime'] = 0;
                }
                else{

                    $cookieParams['lifetime'] = time() + $cookieParams['lifetime'];
                }

                setcookie(session_name(), session_id(), $cookieParams['lifetime'], $cookieParams['path'], $cookieParams['domain'], $cookieParams['secure'], $cookieParams['httponly']);

                if(empty($_SESSION['session_ip'])){

                    $_SESSION['session_ip'] = getenv('REMOTE_ADDR');
                }
                elseif($_SESSION['session_ip']!=getenv('REMOTE_ADDR')){

                    session_destroy();
                    $_SESSION = array();
                }

                if(!in_array($config['csrf_protection_mode'], array('get', 'post'))){

                    if(!empty($refererHost) && $refererHost != $httpHost){

                        self::$csrfAttempt = true;
                    }
                }
            }

            if(self::$csrfAttempt){

                setcookie('csrf_attempt', getenv('HTTP_REFERER'));
            }

            // End of CSRF protection
        }

        $url = parse_url(substr($_SERVER['REQUEST_URI'], 1));

        $route =& self::getRouteByUri($config['routes']['/'], $url['path']);

        if(self::$routeDenied){

            if(!empty($config['events']['onAfterRun'])){

                self::callEventHandlers($config['events']['onAfterRun']);
            }

            return;
        }

        if(!empty($route['view']['meta'])){

            self::addMeta($route['view']['meta']);
        }

        if(!empty($route['view']['links'])){

            self::addLinks($route['view']['links']);
        }

        if(!empty($route['view']['scripts'])){

            self::addScripts($route['view']['scripts']);
        }

        $smarty->assignByRef('__route', $route);
        $smarty->assignByRef('__view', $route['view']);

        $controller = $route['action']['class'].'Controller';
        $action = $route['action']['method'].'Action';

        $refClass = new ReflectionClass($controller);

        if(strpos($refClass->getFileName(), $config['path']['module']) === 0){

            $module = substr($refClass->getFileName(), strlen($config['path']['module'])+1);

            $smarty->module_dir = substr($module, 0, strpos($module, '/'));

            if(isset($route['view']['asset_path'])){

                $smarty->asset_path = $route['view']['asset_path'];
            }
        }

        if(!empty($config['events']['onBeforeActionCall'])){

            self::callEventHandlers($config['events']['onBeforeActionCall']);
        }

        if(self::$reroute){

            ob_end_clean();
            self::resetVariables();
            self::run(false);
            return;
        }

        if(isset($route['action']['argument'])){

            $output = call_user_func(array($controller, $action), $route['action']['argument']);
        }
        else{

            $output = call_user_func(array($controller, $action));
        }

        if(!empty($route['action']['wrapper']) && !empty($output)){

            if(!empty($route['action']['wrapper']['prefix'])){

                $output = $route['action']['wrapper']['prefix'] . $output;
            }

            if(!empty($route['action']['wrapper']['suffix'])){

                $output .= $route['action']['wrapper']['suffix'];
            }
        }

        if(!empty($config['events']['onAfterActionCall'])){

            self::callEventHandlers($config['events']['onAfterActionCall']);
        }
        
        if(self::$reroute){

            ob_end_clean();
            self::resetVariables();
            self::run(false);
            return;
        }

        if(self::$displayStdout && !self::$inhibitOutput){

            ob_flush();
        }
        elseif(!self::$displayStdout){

            self::$rawOutput = ob_get_clean();
        }

        if(self::$inhibitOutput){

            self::$output = '';
        }
        elseif(self::$inhibitRendering){

            self::$output =& $output;
        }
        else{

            $smarty->module_dir = null;
            $smarty->asset_path = null;

            $smarty->setTemplateDir($config['path']['template']);
            $smarty->assignByRef('controller_output', $output);

            $route['view']['meta'] = self::getMeta();
            $route['view']['links'] = self::getLinks();
            $route['view']['scripts'] = self::getScripts();

            if(!empty($config['events']['onBeforeRendering'])){

                self::callEventHandlers($config['events']['onBeforeRendering']);
            }

            self::$output = Locator::getSmarty()->fetch($route['view']['layout_template']);

            if(!empty($config['events']['onAfterRendering'])){

                self::callEventHandlers($config['events']['onAfterRendering']);
            }

            $smarty->resetTemplateDir();
        }

        /*
         * If session engine not started
         * but $_SESSION variable is set by module
         * then start session engine.
         */
        if(session_id()=='' && !empty($_SESSION)){

            $temp = $_SESSION;
            session_start();
            $_SESSION = $temp;
            $_SESSION['session_ip'] = getenv('REMOTE_ADDR');
        }

        if($config['log_raw_output'] && (!empty(self::$rawOutput)) || !empty(self::$widgetRawOutput)){

            if($config['log_raw_output_env']){

                error_log('RAW OUTPUT: '.self::$rawOutput."\nWIDGET RAW OUTPUT: ".var_export(self::$widgetRawOutput, true)."\nENVIRONMENT: ".var_export(array('CONFIG'=>$config, '_GET'=>$_GET, '_POST'=>$_POST, '_SESSION'=>$_SESSION), true), 0);
            }
            else{

                error_log('RAW OUTPUT: '.self::$rawOutput."\nWIDGET RAW OUTPUT: ".var_export(self::$widgetRawOutput, true), 0);
            }
        }

        if(!empty($config['events']['onAfterRun'])){

            self::callEventHandlers($config['events']['onAfterRun']);
        }

        if(!self::$displayStdout){

            self::$rawOutput .= ob_get_clean();
        }
    }

    public static function fetchWidgets($widgets){

        $smarty = Locator::getSmarty();

        $smarty->resetTemplateDir();

        $config =& Locator::getConfig();

        $output = array();

        $i = 0;

        foreach($widgets as $widget){

            if(empty($widget['class']) || empty($widget['method'])
                || (isset($widget['access']) && !Helper::checkAccess($widget['access']))){

                continue;
            }

            ob_start();

            $controller = $widget['class'].'Controller';
            $action = $widget['method'].'Widget';

            $refClass = new ReflectionClass($controller);

            if(strpos($refClass->getFileName(), $config['path']['module']) === 0){

                $module = substr($refClass->getFileName(), strlen($config['path']['module'])+1);

                $smarty->module_dir = substr($module, 0, strpos($module, '/'));

                if(isset($route['view']['asset_path'])){

                    $smarty->asset_path = $route['view']['asset_path'];
                }
            }

            if(!empty($config['events']['onBeforeWidgetRendering'])){

                self::callEventHandlers($config['events']['onBeforeWidgetRendering'], $widget);
            }

            if(isset($widget['argument'])){

                $output[$i] = call_user_func(array($controller, $action), $widget['argument']);
            }
            else{

                $output[$i] = call_user_func(array($controller, $action));
            }

            if(!empty($widget['wrapper']) && !empty($output[$i])){

                if(!empty($widget['wrapper']['prefix'])){

                    $output[$i] = $widget['wrapper']['prefix'] . $output[$i];
                }

                if(!empty($widget['wrapper']['suffix'])){

                    $output[$i] .= $widget['wrapper']['suffix'];
                }
            }

            $i++;

            if(!empty($config['events']['onAfterWidgetRendering'])){

                self::callEventHandlers($config['events']['onAfterWidgetRendering'], $widget);
            }

            $smarty->module_dir = null;
            $smarty->asset_path = null;

            $rawOutput = ob_get_clean();

            if($rawOutput !== ''){

                self::$widgetRawOutput[$controller.'::'.$action] = $rawOutput;
            }
        }

        return implode('', $output);
    }

    public static function callEventHandlers($handlers, $_target = array()){

        foreach($handlers as $handler){

            if(!isset($handler['argument'])){

                $handler['argument']=array();
            }
            else{

                $handler['argument'] = array('config'=>$handler['argument']);
            }

            if(!empty($_target)){

                $handler['argument']['_target'] = $_target;
            }

            if(isset($handler['argument'])){

                call_user_func(array($handler['class'].'Controller', $handler['method'].'EventHandler'), $handler['argument']);
            }
            else{

                call_user_func(array($handler['class'].'Controller', $handler['method'].'EventHandler'));
            }
        }
    }

    public static function inhibitRendering($displayStdout = false){

        self::$inhibitRendering = true;
        self::$displayStdout = $displayStdout;
    }

    public static function inhibitOutput(){

        self::$inhibitOutput = true;
    }

    protected static function &getRouteByUri(&$rootRoute, $uri){

        $route =& $rootRoute;

        $route['uri'] = '/';

        $pathArray = explode('/', $uri);

        $i=0;

        foreach($pathArray as $path){

            if(!isset($route[$path.'/'])){

                $_GET[$i++] = $path;

                continue;
            }

            $route[$path.'/']['uri'] = $route['uri'].$path.'/';
            $route =& $route[$path.'/'];
        }

        if(isset($_GET[$i-1]) && $_GET[$i-1] === ''){

            unset($_GET[$i-1]);
        }

        return self::checkRoute($route);;
    }

    public static function &checkRoute(&$route){

        $config =& Locator::getConfig();
        
        self::$routeDenied = false;

        while(!empty($route['route'])){

            $route =& self::getRouteByUri($config['routes']['/'], substr($route['route'], 1));
        }

        if(isset($route['action']['access']) && !Helper::checkAccess($route['action']['access'])){

            if(empty($_SESSION['account']['role'])){

                if(Helper::isAjax()){

                    Helper::headerJSON();
                    self::$output = json_encode(array('success'=>false, 'redirect'=>'/login/', 'message'=>'Authentication required!'));
                    self::$routeDenied = true;
                }

                if(isset($config['routes']['/']['login/'])){

                    $route =& self::getRouteByUri($config['routes']['/'], 'login/');
                }
                else{

                    Helper::redirect('/login/');
                    self::$routeDenied = true;
                }
            }
            else{

                if(Helper::isAjax()){

                    Helper::headerJSON();
                    self::$output = json_encode(array('success'=>false, 'message'=>'Authentication required!'));
                    self::$routeDenied = true;
                }

                if(isset($config['routes']['/']['error/'])){

                    Helper::httpStatus(403);
                    $route =& self::getRouteByUri($config['routes']['/'], 'error/403/');
                }
                else{

                    Helper::redirect('/error/403/');
                    self::$routeDenied = true;
                }
            }
        }

        LocatorRoute::setRoute($route);

        return $route;
    }

    public static function reroute($uri){

        $_SERVER['REQUEST_URI'] = $uri;
        self::$reroute = true;
    }

    protected static function resetVariables(){

        self::$output = '';
        self::$rawOutput = '';
        self::$widgetRawOutput = array();
        self::$inhibitRendering = false;
        self::$displayStdout = false;
        self::$inhibitOutput = false;
        self::$routeDenied = false;
        self::$reroute = false;
        self::$meta = array();
        self::$links = array();
        self::$scripts = array();
    }

    public static function addMeta($meta){

        foreach($meta as $key=>$item){

            if(!isset($item['order'])){

                $item['order'] = $key;
            }

            self::$meta[] = $item;
        }
    }

    public static function addLinks($links){

        foreach($links as $key=>$item){

            if(!isset($item['order'])){

                $item['order'] = intval($key);
            }

            self::$links[] = $item;
        }
    }

    public static function addScripts($scripts){

        foreach($scripts as $key=>$item){

            if(!isset($item['order'])){

                $item['order'] = intval($key);
            }

            self::$scripts[] = $item;
        }
    }

    public static function getMeta(){

        $result = '';

        self::$meta =& Helper::order(self::$meta, 'order');

        foreach(self::$meta as $item){

            $result .= "\n".(isset($item['indent'])?$item['indent']:'').'<meta';

            foreach($item as $attr=>$value){

                if(in_array($attr, array('order', 'indent', 'private'))){

                    continue;
                }

                $result .= ' '. $attr . '="' . $value . '"';
            }

            $result .= ' />';
        }

        return $result;
    }

    public static function getLinks(){

        $result = '';

        self::$links =& Helper::order(self::$links, 'order');

        foreach(self::$links as $item){

            $result .= "\n".(isset($item['indent'])?$item['indent']:'').'<link';

            foreach($item as $attr=>$value){

                if(in_array($attr, array('order', 'indent', 'private'))){

                    continue;
                }

                $result .= ' '. $attr . '="' . $value . '"';
            }

            $result .= ' />';
        }

        return $result;
    }

    public static function getScripts(){

        $result = '';

        self::$scripts =& Helper::order(self::$scripts, 'order');

        foreach(self::$scripts as $item){

            $result .= "\n".(isset($item['indent'])?$item['indent']:'').'<script';

            foreach($item as $attr=>$value){

                if(in_array($attr, array('order', 'indent', 'private'))){

                    continue;
                }

                $result .= ' '. $attr . '="' . $value . '"';
            }

            $result .= '></script>';
        }

        return $result;
    }

    public static function flush(){

        if(ini_get('display_errors')){

            if(self::$rawOutput !== '' || !empty(self::$widgetRawOutput)){

                FB::error('Caught in STDOUT buffer:');

                if(self::$rawOutput !== ''){

                    FB::dump('controller', self::$rawOutput);
                }

                if(!empty(self::$widgetRawOutput)){

                    FB::dump('widgets', self::$widgetRawOutput);
                }
            }
        }

        echo self::$output;
    }
}
