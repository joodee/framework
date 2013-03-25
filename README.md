# [Joodee Framework v1.0](http://www.joodee.org)

Joodee Framework is an intuitive PHP framework based on MVC pattern implementation for faster and easier web development.

Contains pre-installed Demo Project with Twitter Bootstrap responsive layout and basic modules.

Built to work on high loaded projects, average page generation time on a regular server:
* ~ 05 - 15 ms with PHP APC for configuration files turned On
* ~ 15 - 25 ms with PHP APC turned Off

Check `ExecTime` cookie.


## Try a demo

At: [demo.joodee.org](http://demo.joodee.org)


## Third party libraries included

Smarty, ADOdb, PHPMailer, Securimage, jQuery, Twitter Bootstrap, jQuery UI, jQuery Validation, HTML5 Shiv.


## Modules included

* Application - an empty module for your custom application.
* Account - useful for most common web applications, provides role based access control, account registration, authentication, login name retrieval, password reset, change password form, account management, etc.
* Captcha - displays captcha images by a single call of `{CaptchaController::fetch('key_name')}` from Smarty template file.
* Demo - provides an example of web application with Account module and Twitter Bootstrap responsive layout.
* Joodee - contains most useful basic classes that can be used in all modules.
* Setup - checks settings and creates MySQL tables for Account module, not required on after installation.


## How to setup

* [Download the latest release](https://github.com/joodee/framework/archive/master.zip).
* Or clone the repo: `git clone git://github.com/joodee/framework.git`.
* Make sure you have an Apache v2 or nginx web server with PHP v5.3+ with GD library (for Captcha) and MySQL Server v5+.
* Point web server document root to `~/public` directory.
* Remove `.dist` extension from all `*.php.dist` files in `~/config` directory and `~/config/module` subdirectory.
* Change `'secret'` setting in `~/config/bootstrap.config.php` file.
* If you use Apache web server then remove `.dist` extension from `~/public/.htaccess.dist`.
* Change MySQL connection settings in `~/config/connection.config.php`
* Set write permissions on `~/data` directory and all subdirectories.
* Check settings at `http://your-host-name/` home page.
* If everything is Ok then delete `~/config/module/9999_setup.config.php` configuration file.
* Create an account at `http://your-host-name/registration/`, first account created will get administrative privileges.
* Schedule a cron job `php ~/public/cron.php Account runScheduledActions`, recommended frequency - once per hour.
* Enjoy!


## Quick start

* Create "Hello World" module as described at [www.joodee.org](http://www.joodee.org)
* Read documentation at [http://www.joodee.org/documentation/](http://www.joodee.org/documentation/)
* Examine "Account" and "Demo" modules.


## License

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this work except in compliance with the License.
You may obtain a copy of the License in the LICENSE file, or at:

[http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0)

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

