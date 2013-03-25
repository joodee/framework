<?php
/**
 * Custom autoload of PHPMailer class
 */

$config =& Locator::getConfig();

require_once $config['path']['vendor'] . '/PHPMailer/class.phpmailer.php';
