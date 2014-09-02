<?php
/**
 * Custom autoload of FirePHP class
 */

$config =& Locator::getConfig();

require_once $config['path']['vendor'] . '/FirePHP/lib/FirePHPCore/fb.php';
