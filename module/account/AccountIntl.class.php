<?php
/**
 * Class AccountIntl
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
class AccountIntl{

    public static $validation_checking = "Checking...";
    public static $validation_ok = "Ok";
    public static $validation_failed = "Invalid data submitted";
    public static $validation_nickname_required = "Nickname required.";
    public static $validation_nickname_length_max = "Nickname should not exceed 32 characters.";
    public static $validation_first_name_required = "First name required.";
    public static $validation_first_name_length_max = "First name should not exceed 32 characters.";
    public static $validation_last_name_required = "Last name required.";
    public static $validation_last_name_length_max = "Last name should not exceed 32 characters.";
    public static $validation_username_required = "Username required.";
    public static $validation_username_length_min = "Username should be at least 4 characters long.";
    public static $validation_username_length_max = "Username should not exceed 24 characters.";
    public static $validation_username_regexp = "Username invalid, only allowed: [a-Z] letters, digits, period and dash.";
    public static $validation_username_taken = "This username is already taken.";
    public static $validation_birthday_date_required = "Birthday date required.";
    public static $validation_birthday_date_not_valid = "Birthday date is not valid.";
    public static $validation_gender_required = "Gender required.";
    public static $validation_gender_not_in_list = "Submitted gender value not in list";
    public static $validation_mobile_phone_required = "Mobile phone required.";
    public static $validation_mobile_phone_length_range = "Please type 10 - 13 digits with \"+\" at the beginning. \nCountry code required.";
    public static $validation_mobile_phone_regexp = "\"+\" at the beginning required, only digits allowed, no spaces and special characters.";

    public static $validation_email_required = "Email address required.";
    public static $validation_email_taken = "This email is already in use by another account. \nIf you forgot your password, please use our password reset tool.";
    public static $validation_email_in_use = "This email is already in use by another account.";
    public static $validation_email_invalid = "Email address is not valid.";
    public static $validation_email_length = "Email address should not exceed 64 characters.";

    public static $validation_activation_code_required = "Activation code required.";
    public static $validation_activation_code_invalid = "Wrong activation code.";
    public static $validation_activation_code_invalid_or_expired = "Wrong activation code or expired.";

    public static $validation_password_required = "Password required.";
    public static $validation_password_length_min = "Password should be at least 8 characters long.";
    public static $validation_password_length_max = "Password should not exceed 32 characters.";
    public static $validation_confirm_password_required = "Password confirmation required.";
    public static $validation_passwords_dont_match = "Passwords don't match.";
    public static $validation_role_required = "Role required.";
    public static $validation_captcha_required = "Captcha code required.";
    public static $validation_captcha_invalid = "Captcha code is wrong, please try again.";
    public static $validation_location_required = "Location required.";
    public static $validation_location_unknown = "Unknown location.";
    public static $validation_timezone_required = "Timezone required.";
    public static $validation_tos_and_pp_agree_required = "You should agree to the Terms of Service and Privacy Policy.";

    public static $reg_mail_subject_activate_account = "Activate your account at {company_name}";
    public static $reg_mail_subject_welcome = "Welcome to {company_name}";

    public static $reg_following_errors_occurred = "Following errors occurred";
    public static $reg_unable_to_send_email = "Unable to send email letter, please contact support team or try again later. We are sorry for inconvenience.";

    public static $reg_success_title = "Welcome!";
    public static $reg_success_message = "Your account has been successfully created.";

    public static $reg_first_account_success_title = "Please Note!";
    public static $reg_first_account_success_message = "Your created first account and it got administrative privileges, other accounts will require activation and will have lower access level, however you can change all these settings in account configuration file.";

    public static $reg_activation_code_sent = "Activation code has been sent to specified email address, please check your email.";

    public static $activation_success_title = "Welcome aboard!";
    public static $activation_success_message = "Your account has been successfully activated.";

    public static $plain_body_use_html_compatible_email_client = "To view the message, please use an HTML compatible email viewer!";

    public static $validation_wrong_password = "Wrong password.";
    public static $validation_new_password_required = "New password required.";
    public static $validation_new_password_confirmation_required = "Please type new password again.";

    public static $auth_username_required = "Username required.";
    public static $auth_password_required = "Password required.";
    public static $auth_account_not_activated = "Your account has not been activated yet";
    public static $auth_please_activate_your_account = "Please check your email for a letter with activation instruction.";
    public static $auth_wrong_username_or_password = "Wrong username or password.";
    public static $auth_account_locked_out = "Your account is locked out.";
    public static $auth_contact_support_to_unlock = "Please contact support team to get help to unlock.";
    public static $auth_validation_failed = "Validation errors";
    public static $auth_cookies_off = "Your browser's cookie functionality is turned off. Please turn it on and try again.";
    public static $auth_remember_title = "Extends session lifetime";
    public static $auth_remember_note = "Untick if on a shared computer.";

    public static $validation_username_or_email_required = "Username or email required.";
    public static $validation_account_not_found = "Account not found.";
    public static $validation_account_not_activated = "Your account has not been activated yet.";
    public static $reset_password_link_not_valid_title = "Reset password link is not valid or expired";
    public static $reset_password_link_not_valid_message = "Please submit your request again.";
    public static $reset_password_mail_subject = "Reset password instructions";
    public static $reset_password_success_mail_subject = "Password successfully changed";
    public static $reset_password_success_message_title = "Password has been changed successfully";
    public static $reset_password_success_message = "Now you can sign in to your account with your new password.";

    public static $change_password_success_mail_subject = "Password successfully changed";
    public static $change_password_success_message_title = "Password has been changed successfully";
    public static $change_password_success_message = "Now you can sign in to your account with your new password.";

    public static $retrieve_username_mail_subject = "Your username";
    public static $retrieve_username_success_title = "Your username has been sent to your email address.";
    public static $retrieve_username_success_message = "If you don't receive email within few minutes, check your email's spam and junk filters, or try resending your request.";

    public static $manager_unknown_error = "Unknown error occurred";
    public static $manager_confirm_change_role = "Are you sure you want to change role of #";
    public static $manager_unknown_role = "Unknown role!";
    public static $manager_you_cant_change_your_own_role = "You can not change your own role!";
    public static $manager_role_changed_successfully = "Account role changed successfully!";
    public static $manager_confirm_sign_in_as = "Are you sure you want to sign in as #";
    public static $manager_confirm_lock = "Are you sure you want to LOCK account #";
    public static $manager_confirm_unlock = "Are you sure you want to UNLOCK account #";
    public static $manager_confirm_deletion = "Are you sure you want to delete account #";
    public static $manager_account_not_found = "Account not found";
    public static $manager_you_cant_lock_your_own_account = "You can not lock your own account!";
    public static $manager_you_cant_delete_your_own_account = "You can not delete your own account!";
    public static $manager_successfully_locked = "Successfully locked!";
    public static $manager_successfully_unlocked = "Successfully unlocked!";
    public static $manager_successfully_deleted = "Successfully deleted!";
    public static $manager_sendmail_to_required = "Email address required.";
    public static $manager_sendmail_subject_required = "Email subject required.";
    public static $manager_sendmail_message_required = "Message required.";
    public static $manager_sendmail_success = "Your message has been sent successfully";
    public static $manager_sendmail_error = "An error occurred while sending email";
    public static $validation_unknown_ordering_column="Unknown ordering column";
    public static $validation_unknown_ordering_direction="Unknown ordering direction";

    public static $profile_updated_successfully_title = "Successfully updated!";
    public static $profile_updated_successfully_message = "Your profile has been successfully updated.";

    public static $access_denied = "Access denied";
    public static $you_should_be_logged_in_for_this_action = "You should be logged in for this action.";

    public static $your_account_role_has_changed_title = "Your account role has changed";

    public static $action_restricted_for_demo_role = "This action is restricted for demo role.";

    public static $error_occurred_title = "Error occurred";
    public static $error_unknown_message = "Unknown error occurred, we are sorry for inconvenience.";
    public static $sendmail_error_message = "An error occurred while sending email, please contact support team or try again later. We are sorry for inconvenience.";

}
