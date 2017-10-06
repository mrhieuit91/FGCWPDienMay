<?php

/**
 * Plugin Name: FGC Login Customizes
 * Plugin URI: http://localhost:8080/
 * Description: Tùy biến giao diện trang Login 
 * Version: 1.0
 * Author: Phạm Hiếu
 * Author URI: http://vanhieu.wdev.fgct.net
 */
if (!function_exists('fgc_custom_login')) {

    function fgc_custom_login() {
        ?>
        <style type="text/css">
            body {
                background: #e9e9e9;
                color: #666666;
                font-family: 'RobotoDraft', 'Roboto', sans-serif;
                font-size: 14px;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            body.login {}
            body.login div#login {
                
            }
            body.login div#login h1 {
                
            }
            body.login div#login h1 a {}
            body.login div#login form#loginform {
                position: relative;
                max-width: 460px;
                width: 100%;
                margin: 0 auto 100px;
                
                border-radius: 4px;
            }
            body.login div#login form#loginform p {}
            body.login div#login form#loginform p label {}
            body.login div#login form#loginform input {}
            body.login div#login form#loginform input#user_login {}
            body.login div#login form#loginform input#user_pass {}
            body.login div#login form#loginform p.forgetmenot {}
            body.login div#login form#loginform p.forgetmenot input#rememberme {}
            body.login div#login form#loginform p.submit {
                
            }
            body.login div#login form#loginform p.submit input#wp-submit {
                width: 240px;
                height: 68px;
                border-width: 2px;
            }
            body.login div#login p#nav {}
            body.login div#login p#nav a {}
            body.login div#login p#backtoblog {}
            body.login div#login p#backtoblog a {}
        </style>

        <?php

    }
    add_action('login_enqueue_scripts', 'fgc_custom_login');

}