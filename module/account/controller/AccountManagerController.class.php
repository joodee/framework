<?php
/**
 * Class AccountManagerController
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
class AccountManagerController{

    public static function listAction(){

        $rowsPerPage = 20;

        if(!empty($_GET[0])){

            switch($_GET[0]){

                case 'info': return self::ajaxAccountInfo();
                case 'login': return self::ajaxAccountLogin();
                case 'role': return self::jsonChangeAccountRole();
                case 'lock': return self::jsonLockAccount();
                case 'delete': return self::jsonDeleteAccount();
            }
        }

        $rules = array(
            'order_by' => array(
                'in|,acc_id,nickname,full_name,username,email,role,created_at' => AccountIntl::$validation_unknown_ordering_column,
            ),
            'dir' => array(
                'in|,asc,desc' => AccountIntl::$validation_unknown_ordering_direction,
            ),
        );

        $filter = array('order_by'=>'acc_id', 'dir'=>'ASC');

        if(Validator::check($_GET, $rules)){

            if(empty($_GET['order_by'])){

                $filter['order_by'] = 'acc_id';
            }
            else{

                $filter['order_by'] = $_GET['order_by'];
            }

            if(empty($_GET['dir'])){

                $filter['dir'] = 'ASC';
            }
            else{

                $filter['dir'] = strtoupper($_GET['dir']);
            }
        }
        else{

            $errors = Validator::getErrors();

            Alert::addAlert($errors, 'error', AccountIntl::$error_occurred_title);
        }

        $page = abs(@intval($_GET['page']));

        if(empty($page)){

            $page = 1;
        }

        if(!empty($_GET['keywords']) && is_string($_GET['keywords']) && strlen($_GET['keywords'])<256){

            $filter['keywords'] = str_replace(',', ' ', str_replace(';', ' ', $_GET['keywords']));
        }
        else{

            $filter['keywords'] = '';
        }

        if(!empty($_GET['from']) && is_string($_GET['from'])){

            $date = date_parse($_GET['from']);

            if(!is_array($date) || empty($date['year']) || empty($date['month']) || empty($date['day'])){

                $filter['from'] = '';
            }
            else{

                $filter['from'] = $date['year'].'-'.sprintf('%02d', $date['month']).'-'.sprintf('%02d', $date['day']);
            }
        }
        else{

            $filter['from'] = '';
        }


        if(!empty($_GET['to']) && is_string($_GET['to'])){

            $date = date_parse($_GET['to']);

            if(!is_array($date) || empty($date['year']) || empty($date['month']) || empty($date['day'])){

                $filter['to'] = '';
            }
            else{

                $filter['to'] = $date['year'].'-'.sprintf('%02d', $date['month']).'-'.sprintf('%02d', $date['day']);
            }
        }
        else{

            $filter['to'] = '';
        }

        $config =& Locator::getConfig();

        if(!empty($_GET['role']) && is_string($_GET['role']) && isset($config['roles'][$_GET['role']])){

            $filter['role'] = $_GET['role'];
        }
        else{

            $filter['role'] = '';
        }

        $offset = ($page-1)*$rowsPerPage;

        $accountList = AccountManagerModel::getAccountList($rowsPerPage, $offset, $filter);
        Locator::getSmarty()->assignByRef('accountList', $accountList);

        $foundRows = AccountModel::getFoundRows();
        Locator::getSmarty()->assign('foundRows', $foundRows);

        Locator::getSmarty()->assign('rowsPerPage', $rowsPerPage);

        return Locator::getSmarty()->fetch('admin/page_accounts.tpl');
    }

    public static function filterWidget(){

        return Locator::getSmarty()->fetch('admin/account_filter.tpl');
    }

    public static function ajaxAccountInfo(){

        Helper::inhibitRendering();

        if(empty($_GET['acc_id'])){

            return Alert::fetchAlert(AccountIntl::$manager_account_not_found, 'error', '');
        }

        $account = AccountModel::getAccount($_GET['acc_id'], false, false);

        if(empty($account) || $account['deleted']=='Yes'){

            return Alert::fetchAlert(AccountIntl::$manager_account_not_found, 'error', '');
        }

        Locator::getSmarty()->assign('account', $account);

        return Locator::getSmarty()->fetch('admin/account_info.tpl');
    }

    public static function ajaxAccountLogin(){

        if(empty($_GET[1])){

            $accId = 0;
        }
        else{

            $accId = $_GET[1];
        }

        $account = AccountModel::getAccount($accId, false, false);

        if(!empty($account) && $account['acc_id']!=$_SESSION['account']['id']){

            $parentSession = $_SESSION;

            $_SESSION = array(
                'account' => array(
                    'id' => $account['acc_id'],
                    'role' => $account['role'],
                    'remember' => empty($parentSession['account']['remember'])?'0':'1',
                ),
                'parent_session' => $parentSession,
            );

            $logoutRedirect = getenv('HTTP_REFERER');

            if(!empty($logoutRedirect)){

                $_SESSION['logout_redirect'] = $logoutRedirect;
            }
        }

        AccountController::authSuccessRedirect($_SESSION['account']['role']);
    }

    private static function jsonChangeAccountRole(){

        Helper::headerJSON();

        if(empty($_POST['acc_id'])){

            return json_encode(array('success'=>false));
        }

        $config =& Locator::getConfig();

        if(empty($_POST['new_role']) || !isset($config['roles'][$_POST['new_role']])){

            return json_encode(array('success'=>false, 'message'=>AccountIntl::$manager_unknown_role));
        }

        $account = AccountModel::getAccount($_POST['acc_id'], false, false);

        if(empty($account) || $account['deleted']=='Yes'){

            return json_encode(array('success'=>false, 'message'=>AccountIntl::$manager_account_not_found));
        }

        if($account['acc_id']==$_SESSION['account']['id']){

            return json_encode(array('success'=>false, 'message'=>AccountIntl::$manager_you_cant_change_your_own_role));
        }

        if(Helper::isDemoRole()){

            return json_encode(array('success'=>false, 'message'=>AccountIntl::$action_restricted_for_demo_role));
        }

        if(!AccountModel::updateAccountField($account['acc_id'], 'role', $_POST['new_role'])){

            return json_encode(array('success'=>false, 'message'=>AccountIntl::$manager_unknown_error));
        }

        return json_encode(array('success'=>true, 'message'=>AccountIntl::$manager_role_changed_successfully));
    }

    private static function jsonLockAccount(){

        Helper::headerJSON();

        if(empty($_POST['acc_id'])){

            return json_encode(array('success'=>false));
        }

        $account = AccountModel::getAccount($_POST['acc_id'], false, false);

        if(empty($account) || $account['deleted']=='Yes'){

            return json_encode(array('success'=>false, 'message'=>AccountIntl::$manager_account_not_found));
        }

        if($account['acc_id']==$_SESSION['account']['id']){

            return json_encode(array('success'=>false, 'message'=>AccountIntl::$manager_you_cant_lock_your_own_account));
        }

        if(Helper::isDemoRole()){

            return json_encode(array('success'=>false, 'message'=>AccountIntl::$action_restricted_for_demo_role));
        }

        if(!AccountModel::updateAccountField($account['acc_id'], 'locked', $account['locked']=='Yes'?'No':'Yes')){

            return json_encode(array('success'=>false, 'message'=>AccountIntl::$manager_unknown_error));
        }

        if($account['locked']=='Yes'){

            return json_encode(array('success'=>true, 'locked'=>'No', 'message'=>AccountIntl::$manager_successfully_unlocked));
        }
        else{

            return json_encode(array('success'=>true, 'locked'=>'Yes', 'message'=>AccountIntl::$manager_successfully_locked));
        }
    }

    private static function jsonDeleteAccount(){

        Helper::headerJSON();

        if(empty($_POST['acc_id'])){

            return json_encode(array('success'=>false));
        }

        $account = AccountModel::getAccount($_POST['acc_id'], false, false);

        if(empty($account) || $account['deleted']=='Yes'){

            return json_encode(array('success'=>false, 'message'=>AccountIntl::$manager_account_not_found));
        }

        if($account['acc_id']==$_SESSION['account']['id']){

            return json_encode(array('success'=>false, 'message'=>AccountIntl::$manager_you_cant_delete_your_own_account));
        }

        if(Helper::isDemoRole()){

            return json_encode(array('success'=>false, 'message'=>AccountIntl::$action_restricted_for_demo_role));
        }

        $config =& Locator::getConfig();

        if(!AccountModel::deleteAccount($account['acc_id'], $config['environment']['module']['account']['delete_accounts_physically'])){

            return json_encode(array('success'=>false, 'message'=>AccountIntl::$manager_unknown_error));
        }

        return json_encode(array('success'=>true, 'message'=>AccountIntl::$manager_successfully_deleted));
    }

    public static function ajaxSendMailAction(){

        if(!empty($_GET[0])){

            if($_GET[0]=='send'){

                return self::jsonSendMail();
            }
        }

        Helper::inhibitRendering();

        $toAccount = array();

        if(!empty($_GET['acc_id']) && is_numeric($_GET['acc_id'])){

            $toAccount = AccountModel::getAccount($_GET['acc_id']);
        }

        Locator::getSmarty()->assign('toAccount', $toAccount);
        Locator::getSmarty()->assign('fromAccount', AccountModel::getAccount($_SESSION['account']['id']));

        if(!empty($_GET['email']) && is_string($_GET['email'])){

            $email = $_GET['email'];
        }
        else{

            $email = '';
        }

        Locator::getSmarty()->assign('email', $email);

        return Locator::getSmarty()->fetch('admin/sendmail_form.tpl');
    }

    private static function jsonSendMail(){

        Helper::headerJSON();

        $rules = array(
            'to' => array(
                'required' => AccountIntl::$manager_unknown_error
            ),
            'subject' => array(
                'required' => AccountIntl::$manager_unknown_error
            ),
            'message' => array(
                'required' => AccountIntl::$manager_unknown_error
            ),
        );

        if(!Validator::check($_POST, $rules)){

            return json_encode(array('success'=>false));
        }

        $mailTo = array();

        $_POST['to'] = str_replace(';', ',', $_POST['to']);

        $list = explode(',', $_POST['to']);

        foreach($list as $to){

            $to = explode('<', $to);

            if(empty($to[1])){

                $name='';
                $email=trim($to[0]);
            }
            else{

                $name = trim($to['0']);
                $email = trim(current(explode('>', $to[1])));
            }

            if(!empty($email)){

                $mailTo[] = array('name'=>$name, 'email'=>$email);
            }
        }

        $rules = array(
            'email' => array(
                'email|checkdnsrr' => AccountIntl::$validation_email_invalid,
            ),
        );

        foreach($mailTo as $to){

            if(!Validator::check($to, $rules)){

                return json_encode(array('success'=>false, 'message'=>AccountIntl::$validation_email_invalid));
            }
        }

        if(Helper::isDemoRole()){

            return json_encode(array('success'=>false, 'message'=>AccountIntl::$action_restricted_for_demo_role));
        }

        Locator::getSmarty()->assign('message', nl2br($_POST['message']));
        $_POST['message'] = Locator::getSmarty()->fetch('admin/mail_body_message_wrapper.tpl');

        $config =& Locator::getConfig();
        $account = AccountModel::getAccount($_SESSION['account']['id']);

        $mail = new PHPMailer();
        $mail->CharSet='utf-8';
        $mail->SetFrom($config['environment']['global']['noreply_email'], $config['environment']['global']['company_name'], 0);
        $mail->AddReplyTo($account['email'], $account['first_name'].' '.$account['last_name']);
        $mail->Subject = $_POST['subject'];
        $mail->AltBody    = AccountIntl::$plain_body_use_html_compatible_email_client;
        $mail->WordWrap   = $config['environment']['global']['mail_body_word_wrap'];
        $mail->MsgHTML($_POST['message']);
        $mail->IsHTML(true);

        foreach($mailTo as $to){

            $mail->AddBCC($to['email'], $to['name']);
        }

        if($mail->Send()){

            return json_encode(array('success'=>true, 'message'=>AccountIntl::$manager_sendmail_success));
        }

        return json_encode(array('success'=>false, 'message'=>AccountIntl::$manager_sendmail_error));
    }
}
