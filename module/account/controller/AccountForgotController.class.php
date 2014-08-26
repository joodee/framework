<?php
/**
 * Class AccountForgotController
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
class AccountForgotController{

    public static function forgotAction(){

        return Locator::getSmarty()->fetch('page_forgot.tpl');
    }

    public static function retrieveUsernameAction(){

        $errors = array();

        if(Helper::isPost()){

            $rules = array(
                'email' => array(
                    'required' => AccountIntl::$validation_email_required,
                    'email' => AccountIntl::$validation_email_invalid,
                ),
                'captcha_code' => array(
                    'required' => AccountIntl::$validation_captcha_required
                ),
            );

            if(empty($_COOKIE)){

                $errors['cookie'] = AccountIntl::$auth_cookies_off;
            }

            if(!Validator::check($_POST, $rules)){

                $errors = array_merge($errors, Validator::getErrors());
            }
            elseif(!CaptchaController::check($_POST['captcha_code'], 'retrieve_username')){

                $errors['captcha_code'] = AccountIntl::$validation_captcha_invalid;
            }
            else{

                $account = AccountModel::getAccountByEmail($_POST['email'], false);

                if(empty($account)){

                    $errors['email'] = AccountIntl::$validation_account_not_found;
                }
                elseif($account['activated']!='Yes'){

                    $errors['email'] = AccountIntl::$validation_account_not_activated;
                }
                else{

                    Locator::getSmarty()->assign('account', $account);

                    $config =& Locator::getConfig();

                    $mail = new PHPMailer();
                    $mail->CharSet='utf-8';
                    $mail->AddAddress($_POST['email'], $account['first_name'].' '.$account['last_name']);
                    $mail->SetFrom($config['environment']['global']['noreply_email'], $config['environment']['global']['company_name']);
                    $mail->Subject    = AccountIntl::$retrieve_username_mail_subject;
                    $mail->AltBody    = AccountIntl::$plain_body_use_html_compatible_email_client;
                    $mail->WordWrap   = $config['environment']['global']['mail_body_word_wrap'];
                    $mail->MsgHTML(Locator::getSmarty()->fetch('mail_body_username_retrieve.tpl'));
                    $mail->IsHTML(true);

                    if($mail->Send()){

                        Alert::addAlert(AccountIntl::$retrieve_username_success_message, 'success', AccountIntl::$retrieve_username_success_title);
                        AccountController::authSuccessRedirect($account['role']);
                        return '';
                    }
                    else{

                        $errors['sendmail'] = AccountIntl::$sendmail_error_message;
                        Alert::addAlert($errors['sendmail'], 'error');
                    }
                }
            }
        }

        Locator::getSmarty()->assign('retrieve_errors', $errors);

        return Locator::getSmarty()->fetch('page_retrieve_username.tpl');
    }

    public static function resetPasswordAction(){

        if(!empty($_GET[0]) && !empty($_GET[1])){

            $account = AccountModel::getAccount($_GET[0]);

            // If reset link expired (> 3hours) or not valid
            if(empty($account['password_requested_at'])
                    || (time() - strtotime($account['password_requested_at'])) > 60*60*3
                            || md5($account['token']) != $_GET[1]){

                Alert::addAlert(AccountIntl::$reset_password_link_not_valid_message, 'error', AccountIntl::$reset_password_link_not_valid_title);
            }
            else{

                return self::resetForm($account);
            }
        }

        $errors = array();

        if(Helper::isPost()){

            $rules = array(
                'username' => array(
                    'required' => AccountIntl::$validation_username_or_email_required
                ),
                'captcha_code' => array(
                    'required' => AccountIntl::$validation_captcha_required
                ),
            );

            if(empty($_COOKIE)){

                $errors['cookie'] = AccountIntl::$auth_cookies_off;
            }

            if(!Validator::check($_POST, $rules)){

                $errors = array_merge($errors, Validator::getErrors());
            }
            elseif(!CaptchaController::check($_POST['captcha_code'], 'reset_password')){

                $errors['captcha_code'] = AccountIntl::$validation_captcha_invalid;
            }
            else{

                $account = AccountModel::getAccountByUsername($_POST['username'], false);

                if(empty($account)){

                    $account = AccountModel::getAccountByEmail($_POST['username'], false);
                }

                if(empty($account)){

                    $errors['username'] = AccountIntl::$validation_account_not_found;
                }
                elseif($account['activated']!='Yes'){

                    $errors['username'] = AccountIntl::$validation_account_not_activated;
                }
                else{

                    $config =& Locator::getConfig();
                    $route =& Locator::getRoute();

                    AccountModel::updateAccountToken($account['acc_id'], $account);
                    AccountModel::updateAccountField($account['acc_id'], 'password_requested_at', date('Y-m-d H:i:s'));
                    $account = AccountModel::getAccount($account['acc_id']);

                    $confirmationCode = md5($account['token']);
                    $confirmationUrl = 'http'.($config['environment']['module']['account']['secure_authentication']?'s':'').'://'.getenv('HTTP_HOST').$route['uri'].$account['acc_id'].'/'.$confirmationCode.'/';

                    Locator::getSmarty()->assign('account', $account);
                    Locator::getSmarty()->assign('confirmation_url', $confirmationUrl);

                    $mail = new PHPMailer();
                    $mail->CharSet='utf-8';
                    $mail->AddAddress($account['email'], $account['first_name'].' '.$account['last_name']);
                    $mail->SetFrom($config['environment']['global']['noreply_email'], $config['environment']['global']['company_name']);
                    $mail->Subject    = AccountIntl::$reset_password_mail_subject;
                    $mail->AltBody    = AccountIntl::$plain_body_use_html_compatible_email_client;
                    $mail->WordWrap   = $config['environment']['global']['mail_body_word_wrap'];
                    $mail->MsgHTML(Locator::getSmarty()->fetch('mail_body_password_reset.tpl'));
                    $mail->IsHTML(true);

                    if(!$mail->Send()){

                        $errors['sendmail'] = AccountIntl::$sendmail_error_message;
                        Alert::addAlert($errors['sendmail'], 'error');
                    }
                }
            }
        }

        Locator::getSmarty()->assign('reset_errors', $errors);

        return Locator::getSmarty()->fetch('page_password_reset_request.tpl');
    }

    private static function resetForm($account){

        $errors = array();

        if(Helper::isPost()){

            $rules = array(
                'password' => array(
                    'required' => AccountIntl::$validation_password_required,
                    'length_min|8' => AccountIntl::$validation_password_length_min,
                    'length_max|32' => AccountIntl::$validation_password_length_max,
                ),
                'confirm_password' => array(
                    'required' => AccountIntl::$validation_confirm_password_required,
                    'equals|password' => AccountIntl::$validation_passwords_dont_match,
                ),
            );

            if(Validator::check($_POST, $rules)){

                $config =& Locator::getConfig();

                $password = AccountModel::encryptPassword($_POST['password'], $account['salt'], $config['environment']['module']['account']['encryption_algorithm']);

                if(AccountModel::updateAccountField($account['acc_id'], 'password', $password)){

                    AccountModel::updateAccountField($account['acc_id'], 'algorithm', $config['environment']['module']['account']['encryption_algorithm']);

                    AccountModel::updateAccountToken($account['acc_id'], $account);

                    Locator::getSmarty()->assign('account', $account);

                    $config =& Locator::getConfig();

                    $mail = new PHPMailer();
                    $mail->CharSet='utf-8';
                    $mail->AddAddress($account['email'], $account['first_name'].' '.$account['last_name']);
                    $mail->SetFrom($config['environment']['global']['noreply_email'], $config['environment']['global']['company_name']);
                    $mail->Subject    = AccountIntl::$reset_password_success_mail_subject;
                    $mail->AltBody    = AccountIntl::$plain_body_use_html_compatible_email_client;
                    $mail->WordWrap   = $config['environment']['global']['mail_body_word_wrap'];
                    $mail->MsgHTML(Locator::getSmarty()->fetch('mail_body_password_reset_success.tpl'));
                    $mail->IsHTML(true);
                    $mail->Send();

                    Alert::addAlert(AccountIntl::$reset_password_success_message, 'success', AccountIntl::$reset_password_success_message_title);
                    AccountController::authSuccessRedirect($account['role']);

                    return '';
                }
                else{

                    Alert::addAlert(AccountIntl::$error_unknown_message, 'error', AccountIntl::$error_occurred_title);
                }
            }
            else{

                $errors = Validator::getErrors();
                Alert::addAlert($errors, 'error', AccountIntl::$validation_failed);
            }
        }

        Locator::getSmarty()->assign('reset_errors', $errors);

        return Locator::getSmarty()->fetch('page_password_reset_form.tpl');
    }
}
