<?php
/**
 * Class AccountAuthenticationController
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
class AccountAuthenticationController{

    public static function indexAction(){

        if(Helper::isPost()){

            $rules = array(
                'username' => array(
                    'required' => AccountIntl::$auth_username_required,
                ),
                'password' => array(
                    'required' => AccountIntl::$auth_password_required,
                ),
                'remember' => array(),
                'redirect' => array(),
            );

            if(empty($_COOKIE['TestCookie'])){

                $rules['_cookies_off'] = array(
                    'required' => AccountIntl::$auth_cookies_off,
                );
            }

            $authFailCount = AccountActivityModel::getEventCount('Authentication failed');

            if($authFailCount){

                $rules['captcha_code'] = array(
                    'required' => AccountIntl::$validation_captcha_required,
                );
            }

            if(Validator::check($_POST, $rules)){

                if(!$authFailCount || CaptchaController::check($_POST['captcha_code'], $_POST['namespace'])){

                    $account = AccountAuthenticationModel::getAccountByUsername($_POST['username'], false, null, false);

                    if(empty($account) || AccountModel::encryptPassword($_POST['password'], $account['salt'], $account['algorithm']) != $account['password']){

                        AccountActivityModel::addEvent('Authentication failed', 60*60);

                        $errors = array('password'=>AccountIntl::$auth_wrong_username_or_password);

                        Alert::addAlert($errors, 'error', AccountIntl::$auth_validation_failed);
                    }
                    elseif($account['activated']!='Yes'){

                        $errors = array('message' => AccountIntl::$auth_please_activate_your_account);

                        Alert::addAlert($errors, 'error', AccountIntl::$auth_account_not_activated);
                    }
                    elseif($account['locked']!='No'){

                        $errors = array('message' => AccountIntl::$auth_contact_support_to_unlock);

                        Alert::addAlert($errors, 'error', AccountIntl::$auth_account_locked_out);
                    }
                    else{

                        self::newSession($account);

                        AccountController::authSuccessRedirect($account['role']);
                    }
                }
                else{

                    Alert::AddAlert(AccountIntl::$validation_captcha_invalid, 'error', AccountIntl::$auth_validation_failed);
                }
            }
            else{

                Alert::AddAlert(Validator::getErrors(), 'error', AccountIntl::$auth_validation_failed);
            }
        }

        return self::authFormWidget();
    }

    public static function newSession($account){

        $_SESSION['account'] = array('id'=>$account['acc_id'], 'role'=>$account['role'], 'remember'=>empty($_POST['remember'])?0:1);

        AccountAuthenticationModel::updateAccountLastIp($account['acc_id'], getenv('REMOTE_ADDR'));
    }

    public static function authFormWidget(){

        $authFailCount = AccountActivityModel::getEventCount('Authentication failed');

        Locator::getSmarty()->assign('authFailCount', $authFailCount);

        return Locator::getSmarty()->fetch('login.tpl');
    }

    public static function modalAuthFormWidget(){

        $authFailCount = AccountActivityModel::getEventCount('Authentication failed');

        Locator::getSmarty()->assign('authFailCount', $authFailCount);

        return Locator::getSmarty()->fetch('login_modal.tpl');
    }

    public static function logoutAction($args){

        if(!empty($_SESSION['logout_redirect'])){

            $logoutRedirect = $_SESSION['logout_redirect'];
        }
        else{

            $logoutRedirect = isset($args['redirect'])?$args['redirect']:'/';
        }

        if(empty($_SESSION['parent_session'])){

            session_destroy();
            unset($_SESSION);

            Helper::redirect($logoutRedirect);
        }
        else{

            $_SESSION = $_SESSION['parent_session'];
            Helper::redirect($logoutRedirect);
        }
    }
}
