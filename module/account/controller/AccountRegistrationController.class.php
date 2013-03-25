<?php
/**
 * Class AccountRegistrationController
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
class AccountRegistrationController{

    public static function registrationAction($argument){

        if(!empty($_GET[0])){

            switch($_GET[0]){

                case 'check': return AccountController::ajaxCheck();
            }
        }

        $config =& Locator::getConfig();

        if(Helper::isPost()){

            $rules = array(
                'first_name' => array(
                    'required' => AccountIntl::$validation_first_name_required,
                    'length_max|32' => AccountIntl::$validation_first_name_length_max,
                ),
                'last_name' => array(
                    'required' => AccountIntl::$validation_last_name_required,
                    'length_max|32' => AccountIntl::$validation_last_name_length_max,
                ),
                'username' => array(
                    'required' => AccountIntl::$validation_username_required,
                    'length_min|4' => AccountIntl::$validation_username_length_min,
                    'length_max|24' => AccountIntl::$validation_username_length_max,
                    $config['environment']['module']['account']['username_regexp'] => AccountIntl::$validation_username_regexp,
                ),
                'password' => array(
                    'required' => AccountIntl::$validation_password_required,
                    'length_min|8' => AccountIntl::$validation_password_length_min,
                    'length_max|32' => AccountIntl::$validation_password_length_max,
                ),
                'confirm_password' => array(
                    'required' => AccountIntl::$validation_confirm_password_required,
                    'equals|password' => AccountIntl::$validation_passwords_dont_match,
                ),
                'birthday_day' => array(
                    'required' => AccountIntl::$validation_birthday_date_required,
                    'number' => AccountIntl::$validation_birthday_date_not_valid,
                    'range|1:31' => AccountIntl::$validation_birthday_date_not_valid,
                ),
                'birthday_month' => array(
                    'required' => AccountIntl::$validation_birthday_month_required,
                    'number' => AccountIntl::$validation_birthday_month_not_valid,
                    'range|1:12' => AccountIntl::$validation_birthday_month_not_valid,
                ),
                'birthday_year' => array(
                    'required' => AccountIntl::$validation_birthday_year_required,
                    'number' => AccountIntl::$validation_birthday_year_not_valid,
                    'range|'.(date('Y')-120).':'.date('Y') => AccountIntl::$validation_birthday_year_not_valid,
                ),
                'gender' => array(
                    'required' => AccountIntl::$validation_gender_required,
                    'in|Male,Female,Other' => AccountIntl::$validation_gender_not_in_list,
                ),
                'mobile_phone' => array(
                    'required' => AccountIntl::$validation_mobile_phone_required,
                    'length_range|11:14' => AccountIntl::$validation_mobile_phone_length_range,
                    '/^[\+][0-9]+$/' => AccountIntl::$validation_mobile_phone_regexp,
                ),
                'email' => array(
                    'required' => AccountIntl::$validation_email_required,
                    'email|checkdnsrr' => AccountIntl::$validation_email_invalid,
                    'length_max|64' => AccountIntl::$validation_email_length
                ),
                'captcha_code' => array(
                    'required' => AccountIntl::$validation_captcha_required,
                ),
                'location_iso2' => array(
                    'required' => AccountIntl::$validation_location_required,
                ),
                'i_agree' => array(
                    'required' => AccountIntl::$validation_tos_and_pp_agree_required,
                ),
            );

            $errors = array();

            if(empty($_COOKIE)){

                $errors['cookie'] = AccountIntl::$auth_cookies_off;
            }

            if(!Validator::check($_POST, $rules)){

                $errors = array_merge($errors, Validator::getErrors());
            }

            if(empty($errors['username'])){

                $found = AccountModel::getAccountByUsername($_POST['username'], false);

                if(!empty($found)){

                    $errors['username'] = AccountIntl::$validation_username_taken;
                }
            }

            if(empty($errors['email'])){

                $found = AccountModel::getAccountByEmail($_POST['email'], false);

                if(!empty($found)){

                    $errors['email'] = AccountIntl::$validation_email_taken;
                }
            }

            if(empty($errors['captcha_code'])){

                if(!CaptchaController::check($_POST['captcha_code'], 'registration')){

                    $errors['captcha_code'] = AccountIntl::$validation_captcha_invalid;
                }
            }

            if(empty($errors['location_iso2'])){

                if(!isset(CountryList::$items[$_POST['location_iso2']])){

                    $errors['location_iso2'] = AccountIntl::$validation_location_unknown;
                }
            }

            if(empty($errors)){

                $route =& Locator::getRoute();

                $account = $_POST;

                $account['nickname'] = $account['first_name'];
                $account['email_canonical'] = $account['email'];
                $account['algorithm'] = $config['environment']['module']['account']['encryption_algorithm'];
                $account['salt'] = md5(mt_rand(1, mt_getrandmax()).$config['secret']);
                $account['last_logged_ip'] = getenv('REMOTE_ADDR');
                $account['locked'] = 'No';
                $account['lang_iso2'] = $route['view']['lang_iso2'];
                $account['activation_expires_at'] = date('Y-m-d H:i:s', intval($config['environment']['module']['account']['schedule_deletion_if_not_activated_x_days'])*60*60*24 + time());

                $firstAccount = false;

                if($config['environment']['module']['account']['registration_role_first_account']
                        && AccountRegistrationModel::isAccountTableEmpty()){

                    $account['role'] = $config['environment']['module']['account']['registration_role_first_account'];
                    $account['activated'] = 'Yes';
                    $firstAccount = true;
                }
                else{

                    $account['role'] = $config['environment']['module']['account']['registration_role_default'];
                    $account['activated'] = $config['environment']['module']['account']['activate_accounts_automatically']?'Yes':'No';
                }

                if(isset(CountryList::$items[$_POST['location_iso2']]['time'])){

                    $account['timezone'] = CountryList::$items[$_POST['location_iso2']]['time'];
                }
                else{

                    $account['timezone'] = date_default_timezone_get();
                }

                $accId = AccountRegistrationModel::addAccount($account);

                if(empty($accId)){

                    Alert::addAlert('', 'error', AccountIntl::$manager_unknown_error);
                }
                else{

                    $account = AccountModel::getAccount($accId);
                    Locator::getSmarty()->assign('account', $account);

                    if($account['activated']=='Yes'){

                        $welcomeEmailSent = false;

                        if($config['environment']['module']['account']['welcome_email_required']){

                            $mail = new PHPMailer();
                            $mail->AddAddress($account['email'], $account['first_name'].' '.$account['last_name']);
                            $mail->SetFrom($config['environment']['global']['noreply_email'], $config['environment']['global']['company_name']);
                            $mail->Subject = str_replace('{company_name}', $config['environment']['global']['company_name'], AccountIntl::$reg_mail_subject_welcome);
                            $mail->AltBody    = AccountIntl::$plain_body_use_html_compatible_email_client;
                            $mail->WordWrap   = $config['environment']['global']['mail_body_word_wrap'];
                            $mail->MsgHTML(Locator::getSmarty()->fetch('mail_body_registration_welcome.tpl'));
                            $mail->IsHTML(true);

                            $welcomeEmailSent = $mail->Send();
                        }

                        if(!$config['environment']['module']['account']['welcome_email_required'] || $welcomeEmailSent){

                            Alert::addAlert(AccountIntl::$reg_success_message, 'success', AccountIntl::$reg_success_title);

                            if($firstAccount){

                                Alert::addAlert(AccountIntl::$reg_first_account_success_message, 'info', AccountIntl::$reg_first_account_success_title);
                            }

                            if($config['environment']['module']['account']['automatic_authentication']){

                                AccountAuthenticationController::newSession($account);
                            }

                            AccountController::authSuccessRedirect($account['role']);

                            return '';
                        }
                        else{

                            AccountModel::deleteAccount($accId, $config['environment']['module']['account']['delete_accounts_physically']);
                            Alert::addAlert(AccountIntl::$reg_unable_to_send_email, 'error', AccountIntl::$reg_following_errors_occurred);

                            return Locator::getSmarty()->fetch('registration.tpl');
                        }
                    }
                    else{

                        $activationCode = md5($account['token']);
                        Locator::getSmarty()->assign('activation_code', $activationCode);

                        $activationUrl = 'http'.($config['environment']['module']['account']['secure_authentication']?'s':'').'://'.getenv('HTTP_HOST').$argument['activation_route'];

                        Locator::getSmarty()->assign('activation_url', $activationUrl.$accId.'/'.$activationCode.'/');

                        $mail = new PHPMailer();
                        $mail->AddAddress($account['email'], $account['first_name'].' '.$account['last_name']);
                        $mail->SetFrom($config['environment']['global']['noreply_email'], $config['environment']['global']['company_name']);
                        $mail->Subject = str_replace('{company_name}', $config['environment']['global']['company_name'], AccountIntl::$reg_mail_subject_activate_account);
                        $mail->AltBody    = AccountIntl::$plain_body_use_html_compatible_email_client;
                        $mail->WordWrap   = $config['environment']['global']['mail_body_word_wrap'];
                        $mail->MsgHTML(Locator::getSmarty()->fetch('mail_body_registration_activation.tpl'));
                        $mail->IsHTML(true);

                        if($mail->Send()){

                            Alert::addAlert(AccountIntl::$reg_success_message, 'success', AccountIntl::$reg_success_title);
                            Alert::addAlert(AccountIntl::$reg_activation_code_sent, 'info');

                            $_SESSION['activate_username'] = $account['username'];

                            Helper::redirect($activationUrl);
                            return '';
                        }
                        else{

                            AccountModel::deleteAccount($accId, $config['environment']['module']['account']['delete_accounts_physically']);
                            Alert::addAlert(AccountIntl::$reg_unable_to_send_email, 'error', AccountIntl::$reg_following_errors_occurred);
                        }
                    }
                }
            }
            else{

                Locator::getSmarty()->assign('registration_errors', $errors);
                Alert::addAlert($errors, 'error', AccountIntl::$validation_failed);
            }
        }

        return Locator::getSmarty()->fetch('registration.tpl');
    }

    public static function activationAction(){

        $errors = array();

        $activateUsername = '';
        $activationCode = '';

        if(Helper::isPost()){

            $rules = array(
                'username' => array(
                    'required' => AccountIntl::$validation_username_required
                ),
                'activation_code' => array(
                    'required' => AccountIntl::$validation_activation_code_required
                ),
            );

            if(empty($_COOKIE)){

                $errors['cookie'] = AccountIntl::$auth_cookies_off;
            }

            if(!Validator::check($_POST, $rules)){

                $errors = array_merge($errors, Validator::getErrors());
            }

            if(empty($errors)){

                $account = AccountModel::getAccountByUsername($_POST['username'], false);

                if(empty($account)){

                    $errors['invalid_or_expired'] = AccountIntl::$validation_activation_code_invalid_or_expired;
                }
                else{

                    if(md5($account['token']) == $_POST['activation_code']){

                        if($account['username'] == $_POST['username']){

                            $activated = AccountModel::updateAccountField($account['acc_id'], 'activated', 'Yes');

                            if($activated){

                                Alert::addAlert(AccountIntl::$activation_success_message, 'success', AccountIntl::$activation_success_title);

                                $config =& Locator::getConfig();

                                if($config['environment']['module']['account']['automatic_authentication']){

                                    AccountAuthenticationController::newSession($account);
                                }

                                AccountController::authSuccessRedirect($account['role']);

                                if($config['environment']['module']['account']['welcome_email_required']){

                                    Locator::getSmarty()->assign('account', $account);

                                    $mail = new PHPMailer();
                                    $mail->AddAddress($account['email'], $account['first_name'].' '.$account['last_name']);
                                    $mail->SetFrom($config['environment']['global']['noreply_email'], $config['environment']['global']['company_name']);
                                    $mail->Subject = str_replace('{company_name}', $config['environment']['global']['company_name'], AccountIntl::$reg_mail_subject_welcome);
                                    $mail->AltBody    = AccountIntl::$plain_body_use_html_compatible_email_client;
                                    $mail->WordWrap   = $config['environment']['global']['mail_body_word_wrap'];
                                    $mail->MsgHTML(Locator::getSmarty()->fetch('mail_body_registration_welcome.tpl'));
                                    $mail->IsHTML(true);
                                    $mail->Send();
                                }

                                return '';
                            }
                            else{

                                Alert::addAlert(AccountIntl::$error_unknown_message, 'error', AccountIntl::$error_occurred_title);
                            }
                        }
                    }
                    else{

                        $errors['invalid_or_expired'] = AccountIntl::$validation_activation_code_invalid_or_expired;
                    }
                }
            }

            if(!empty($_POST['username']) && is_string($_POST['username'])){

                $activateUsername = $_POST['username'];
            }

            if(!empty($_POST['activation_code']) && is_string($_POST['activation_code'])){

                $activationCode = $_POST['activation_code'];
            }
        }
        elseif(!empty($_GET[0]) && is_numeric($_GET[0]) && !empty($_GET[1]) && is_string($_GET[1])){

            $account = AccountModel::getAccount($_GET[0]);

            if(!empty($account) && md5($account['token'])==$_GET[1]){

                $activateUsername = $account['username'];
            }

            $activationCode = $_GET[1];
        }
        elseif(!empty($_SESSION['activate_username'])){

            $activateUsername = $_SESSION['activate_username'];
        }

        Locator::getSmarty()->assign('username', $activateUsername);
        Locator::getSmarty()->assign('activation_code', $activationCode);

        if(!empty($errors)){

            Alert::addAlert($errors, 'error', AccountIntl::$validation_failed);
        }

        Locator::getSmarty()->assign('activation_errors', $errors);

        return Locator::getSmarty()->fetch('activation.tpl');
    }
}
