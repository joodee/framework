<?php
/**
 * Class CaptchaController
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
class CaptchaController {

    public static function showAction($args){

        $rules = array(
            'namespace' => array(
                'required' => 'Namespace required'
            ),
            'hash' => array(
                'required' => 'Namespace hash required'
            )
        );

        if(!Validator::check($_GET, $rules)){

            $errors = Validator::getErrors();
            Alert::addAlert($errors, 'error', 'Error: Bad request');
            return '';
        }

        $config =& Locator::getConfig();

        if(empty($_GET['namespace'])){

            $_GET['namespace'] = 'default';
        }

        if(sha1($_GET['namespace'].$config['secret'])!=$_GET['hash']){

            Alert::addAlert('', 'error', 'Error: Invalid hash');
            return '';
        }

        Helper::inhibitRendering(true);

        require_once $config['path']['vendor'].'/Securimage/securimage.php';

        $image = new Securimage();

        $image->namespace = $_GET['namespace'];

        if(!empty($args['image_bg_color'])){

            $image->image_bg_color = new Securimage_Color($args['image_bg_color']);
        }

        if(!empty($args['text_color'])){

            $image->text_color = new Securimage_Color($args['text_color']);
        }

        if(!empty($args['line_color'])){

            $image->line_color = new Securimage_Color($args['line_color']);
        }

        if(!empty($args['background_directory'])){

            $image->background_directory = $args['background_directory'];
        }

        if(!empty($args['ttf_file'])){

            $image->ttf_file = $args['ttf_file'];
        }

        if(!empty($args['perturbation'])){

            $image->perturbation = $args['perturbation'];
        }

        if(!empty($args['num_lines'])){

            if(is_array($args['num_lines'])){

                $image->num_lines = mt_rand($args['num_lines'][0], $args['num_lines'][1]);
            }
            else{

                $image->num_lines = $args['num_lines'];
            }
        }

        if(!empty($args['image_width'])){

            $image->image_width = $args['image_width'];
        }

        if(!empty($args['image_height'])){

            $image->image_height = $args['image_height'];
        }

        if(!empty($args['charset'])){

            $image->charset = $args['charset'];
        }

        if(!empty($args['code_length'])){

            if(is_array($args['code_length'])){

                $image->code_length = mt_rand($args['code_length'][0], $args['code_length'][1]);
            }
            else{

                $image->code_length = $args['code_length'];
            }
        }

        if(!empty($args['image_signature'])){

            $image->image_signature = $args['image_signature'];
        }

        if(!empty($args['signature_color'])){

            $image->signature_color = new Securimage_Color($args['signature_color']);
        }



        $image->show();
    }

    public static function playAction(){

        $rules = array(
            '0' => array(
                'required' => 'Namespace required'
            ),
            '1' => array(
                'required' => 'Namespace hash required'
            )
        );

        if(!Validator::check($_GET, $rules)){

            $errors = Validator::getErrors();
            Alert::addAlert($errors, 'error', 'Error: Bad request');
            return '';
        }

        $config =& Locator::getConfig();

        if(empty($_GET[0])){

            $_GET[0] = 'default';
        }

        if(sha1($_GET[0].$config['secret'])!=$_GET[1]){

            Alert::addAlert('', 'error', 'Error: Invalid hash');
            return '';
        }


        Helper::inhibitRendering(true);

        require_once $config['path']['vendor'].'/Securimage/securimage.php';

        $image = new Securimage();

        $image->namespace = $_GET[0];

        $image->outputAudioFile();
    }

    public static function fetch($namespace='default', $module = 'captcha', $template = 'captcha.tpl'){

        $config =& Locator::getConfig();

        if(empty($namespace)){

            $namespace ='default';
        }

        Locator::getSmarty()->assign('captchaNamespace', $namespace);
        Locator::getSmarty()->assign('captchaNamespaceHash', sha1($namespace.$config['secret']));

        return Locator::getSmarty($module)->fetch($template);
    }

    public static function check($code, $namespace = 'default'){

        $config =& Locator::getConfig();

        if(empty($namespace)){

            $namespace ='default';
        }

        require_once $config['path']['vendor'].'/Securimage/securimage.php';

        $image = new Securimage();

        $image->namespace = $namespace;

        $result = $image->check($code);

        if(isset($_SESSION['securimage_code_disp'][$namespace])){

            unset($_SESSION['securimage_code_disp'][$namespace]);
        }

        if(isset($_SESSION['securimage_code_value'][$namespace])){

            unset($_SESSION['securimage_code_value'][$namespace]);
        }

        if(isset($_SESSION['securimage_code_ctime'][$namespace])){

            unset($_SESSION['securimage_code_ctime'][$namespace]);
        }

        return $result;
    }
}
