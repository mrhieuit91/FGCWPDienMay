<!DOCTYPE html>
<html >
    <head>
        <base href="<?php echo base_url(); ?>">
        <meta charset="UTF-8">
        <title>Material Login Form</title>
        <link rel="stylesheet" href="public/admin/css/reset.min.css">
        <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
        <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
        <link rel="stylesheet" href="public/admin/css/style.css">
        <link href="public/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <style>
            .container{
                margin-bottom: 0;
            }
            .error{
                color: #ed2553;
                font-size: 13px;
                margin-bottom: -15px;
                position: absolute;
                bottom: -10px;
            }
            .r_error{
                color: #ed2553;
                font-size: 13px;
                margin-bottom: -15px;
                position: absolute;
                top: 12px;
            }
            /* Pen Title */
            .pen-title {
                padding: 50px 0;
                text-align: center;
                letter-spacing: 2px;
            }
            .pen-title h1 {
                margin: 0 0 20px;
                font-size: 48px;
                font-weight: 300;
            }
            .pen-title span {
                font-size: 12px;
            }
            .pen-title span .fa {
                color: #ed2553;
            }
            .pen-title span a {
                color: #ed2553;
                font-weight: 600;
                text-decoration: none;
            }

            /* Rerun */
            .rerun {
                margin: 0 0 30px;
                text-align: center;
            }
            .rerun a {
                cursor: pointer;
                display: inline-block;
                background: #ed2553;
                border-radius: 3px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
                padding: 10px 20px;
                color: #ffffff;
                text-decoration: none;
                -webkit-transition: 0.3s ease;
                transition: 0.3s ease;
            }
            .rerun a:hover {
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
            }

            /* Scroll To Bottom */
            #codepen, #portfolio {
                position: fixed;
                bottom: 30px;
                right: 30px;
                background: #363636;
                width: 56px;
                height: 56px;
                border-radius: 100%;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
                -webkit-transition: 0.3s ease;
                transition: 0.3s ease;
                color: #ffffff;
                text-align: center;
            }
            #codepen i, #portfolio i {
                line-height: 56px;
            }
            #codepen:hover, #portfolio:hover {
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            }

            /* CodePen */
            #portfolio {
                bottom: 96px;
                right: 36px;
                background: #ed2553;
                width: 44px;
                height: 44px;
                -webkit-animation: buttonFadeInUp 1s ease;
                animation: buttonFadeInUp 1s ease;
            }
            #portfolio i {
                line-height: 44px;
            }

            /* Container */
            .container {
                position: relative;
                max-width: 460px;
                width: 100%;
                margin: 0 auto 100px;
            }
            .container.active .card:first-child {
                background: #f2f2f2;
                margin: 0 15px;
            }
            .container.active .card:nth-child(2) {
                background: #fafafa;
                margin: 0 10px;
            }
            .container.active .card.alt {
                top: 20px;
                right: 0;
                width: 100%;
                min-width: 100%;
                height: auto;
                border-radius: 5px;
                padding: 60px 0 40px;
                overflow: hidden;
            }
            .container.active .card.alt .toggle {
                position: absolute;
                top: 40px;
                right: -70px;
                box-shadow: none;
                -webkit-transform: scale(10);
                transform: scale(10);
                -webkit-transition: -webkit-transform .3s ease;
                transition: -webkit-transform .3s ease;
                transition: transform .3s ease;
                transition: transform .3s ease, -webkit-transform .3s ease;
            }
            .container.active .card.alt .toggle:before {
                content: '';
            }
            .container.active .card.alt .title,
            .container.active .card.alt .input-container,
            .container.active .card.alt .button-container {
                left: 0;
                opacity: 1;
                visibility: visible;
                -webkit-transition: .3s ease;
                transition: .3s ease;
            }
            .container.active .card.alt .title {
                -webkit-transition-delay: .3s;
                transition-delay: .3s;

            }
            .container.active .card.alt .input-container {
                -webkit-transition-delay: .4s;
                transition-delay: .4s;
            }
            .container.active .card.alt .input-container:nth-child(2) {
                -webkit-transition-delay: .5s;
                transition-delay: .5s;
            }
            .container.active .card.alt .input-container:nth-child(3) {
                -webkit-transition-delay: .6s;
                transition-delay: .6s;
            }
            .container.active .card.alt .button-container {
                -webkit-transition-delay: .7s;
                transition-delay: .7s;
            }

            /* Card */
            .card {
                position: relative;
                background: #ffffff;
                border-radius: 5px;
                padding: 60px 0 40px 0;
                box-sizing: border-box;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
                -webkit-transition: .3s ease;
                transition: .3s ease;
                /* Title */
                /* Inputs */
                /* Button */
                /* Footer */
                /* Alt Card */
            }
            .card:first-child {
                background: #fafafa;
                height: 10px;
                border-radius: 5px 5px 0 0;
                margin: 0 10px;
                padding: 0;
            }
            .card .title {
                position: relative;
                z-index: 1;
                border-left: 5px solid #ed2553;
                margin: 0 0 35px;
                padding: 10px 0 10px 50px;
                color: #ed2553;
                font-size: 32px;
                font-weight: 600;
                text-transform: uppercase;
            }
            .card .input-container {
                position: relative;
                margin: 0 60px 50px;
            }
            .card.alt .input-container {
                margin: 0 60px 15px;
            }
            .card .input-container input {
                outline: none;
                z-index: 1;
                position: relative;
                background: none;
                width: 100%;
                height: 60px;
                border: 0;
                color: #212121;
                font-size: 24px;
                font-weight: 400;
            }
            .card .input-container input:focus ~ label {
                color: #9d9d9d;
                -webkit-transform: translate(-12%, -50%) scale(0.75);
                transform: translate(-12%, -50%) scale(0.75);
            }
            .card .input-container input:focus ~ .bar:before, .card .input-container input:focus ~ .bar:after {
                width: 50%;
            }
            .card .input-container input:valid ~ label {
                color: #9d9d9d;
                -webkit-transform: translate(-12%, -50%) scale(0.75);
                transform: translate(-12%, -50%) scale(0.75);
            }
            .card .input-container label {
                position: absolute;
                top: 0;
                left: 0;
                color: #757575;
                font-size: 24px;
                font-weight: 300;
                line-height: 60px;
                -webkit-transition: 0.2s ease;
                transition: 0.2s ease;
            }
            .card .input-container .bar {
                position: absolute;
                left: 0;
                bottom: 0;
                background: #757575;
                width: 100%;
                height: 1px;
            }
            .card .input-container .bar:before, .card .input-container .bar:after {
                content: '';
                position: absolute;
                background: #ed2553;
                width: 0;
                height: 2px;
                -webkit-transition: .2s ease;
                transition: .2s ease;
            }
            .card .input-container .bar:before {
                left: 50%;
            }
            .card .input-container .bar:after {
                right: 50%;
            }
            .card .button-container {
                margin: 0 60px;
                text-align: center;
            }
            .card .button-container button {
                outline: 0;
                cursor: pointer;
                position: relative;
                display: inline-block;
                background: 0;
                width: 240px;
                border: 2px solid #e3e3e3;
                padding: 20px 0;
                font-size: 24px;
                font-weight: 600;
                line-height: 1;
                text-transform: uppercase;
                overflow: hidden;
                -webkit-transition: .3s ease;
                transition: .3s ease;
            }
            .card .button-container button span {
                position: relative;
                z-index: 1;
                color: #ddd;
                -webkit-transition: .3s ease;
                transition: .3s ease;
            }
            .card .button-container button:before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                display: block;
                background: #ed2553;
                width: 30px;
                height: 30px;
                border-radius: 100%;
                margin: -15px 0 0 -15px;
                opacity: 0;
                -webkit-transition: .3s ease;
                transition: .3s ease;
            }
            .card .button-container button:hover, .card .button-container button:active, .card .button-container button:focus {
                border-color: #ed2553;
            }
            .card .button-container button:hover span, .card .button-container button:active span, .card .button-container button:focus span {
                color: #ed2553;
            }
            .card .button-container button:active span, .card .button-container button:focus span {
                color: #ffffff;
            }
            .card .button-container button:active:before, .card .button-container button:focus:before {
                opacity: 1;
                -webkit-transform: scale(10);
                transform: scale(10);
            }
            .card .footer {
                margin: 40px 0 0;
                color: #d3d3d3;
                font-size: 24px;
                font-weight: 300;
                text-align: center;
            }
            .card .footer a {
                color: inherit;
                text-decoration: none;
                -webkit-transition: .3s ease;
                transition: .3s ease;
            }
            .card .footer a:hover {
                color: #bababa;
            }
            .card.alt {
                position: absolute;
                top: 40px;
                right: -70px;
                z-index: 10;
                width: 140px;
                height: 140px;
                background: none;
                border-radius: 100%;
                box-shadow: none;
                padding: 0;
                -webkit-transition: .3s ease;
                transition: .3s ease;
                /* Toggle */
                /* Title */
                /* Input */
                /* Button */
            }
            .card.alt .toggle {
                position: relative;
                background: #383636;
                width: 140px;
                height: 140px;
                border-radius: 100%;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
                color: #ffffff;
                font-size: 58px;
                line-height: 140px;
                text-align: center;
                cursor: pointer;
            }
            .card.alt .toggle:before {
                content: '\f040';
                display: inline-block;
                font: normal normal normal 14px/1 FontAwesome;
                font-size: inherit;
                text-rendering: auto;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                -webkit-transform: translate(0, 0);
                transform: translate(0, 0);
            }
            .card.alt .title,
            .card.alt .input-container,
            .card.alt .button-container {
                left: 100px;
                opacity: 0;
                visibility: hidden;
            }
            .card.alt .title {
                position: relative;
                border-color: #ffffff;
                color: #ffffff;
            }
            .card.alt .title .close {
                cursor: pointer;
                position: absolute;
                top: 0;
                right: 60px;
                display: inline;
                color: #ffffff;
                font-size: 58px;
                font-weight: 400;
            }
            .card.alt .title .close:before {
                content: '\00d7';
            }
            .card.alt .input-container input {
                color: #ffffff;
            }
            .card.alt .input-container input:focus ~ label {
                color: #ffffff;
            }
            .card.alt .input-container input:focus ~ .bar:before, .card.alt .input-container input:focus ~ .bar:after {
                background: #ffffff;
            }
            .card.alt .input-container input:valid ~ label {
                color: #ffffff;
            }
            .card.alt .input-container label {
                color: rgba(255, 255, 255, 0.8);
            }
            .card.alt .input-container .bar {
                background: rgba(255, 255, 255, 0.8);
            }
            .card.alt .button-container button {
                width: 100%;
                background: #ffffff;
                border-color: #ffffff;
            }
            .card.alt .button-container button span {
                color: #ed2553;
            }
            .card.alt .button-container button:hover {
                background: rgba(255, 255, 255, 0.9);
            }
            .card.alt .button-container button:active:before, .card.alt .button-container button:focus:before {
                display: none;
            }

            /* Keyframes */
            @-webkit-keyframes buttonFadeInUp {
                0% {
                    bottom: 30px;
                    opacity: 0;
                }
            }
            @keyframes buttonFadeInUp {
                0% {
                    bottom: 30px;
                    opacity: 0;
                }
            }

        </style>

    </head>

    <body>

        <!-- Mixins-->
        <!-- Pen Title-->
        <div class="pen-title">
            <h1>Hãy đăng nhập hoặc đăng ký</h1><span>Hoặc <i class='fa fa-code'></i><a href='#'>Quay lại trang chủ</a></span>
        </div>
        <div class="rerun"><a href="home">Quay lại</a></div>
        <div class="container">
            <div class="card"></div>
            <div class="card">
                <h1 class="title">Đăng nhập</h1>
                <?php
                if (isset($error))
                    echo '<div class="alert alert-danger" role="alert">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              <span class="sr-only">Error:</span>
              ' . $error . '
            </div>';
                elseif (isset($message))
                    echo '<div class="alert alert-info" role="alert">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              ' . $message . '
            </div>';
                if (isset($redirect))
                    echo '<script>setTimeout(function(){window.location.replace("' . $redirect . '");}, 2000);</script>';
                ?>
                <form method="post" action="user/login" name="login">
                    <input type="hidden" name="dologin" value="true"/>
                    <div class="input-container">
                        <input name="email" type="text" id="email"/>
                        <label for="email">Email đăng nhập</label>
                        <div class="error" id="email_error"><?php echo form_error('email') ?></div>

                        <div class="bar"></div>
                    </div>
                    <div class="input-container">
                        <input name="password" type="password" id="password" />
                        <label for="password">Mật khẩu</label>
                        <div class="error" id="password_error"><?php echo form_error('password') ?></div>
                        <div class="bar"></div>
                    </div>
                    <div class="button-container">
                        <button name="login" type="submit"><span>Đăng nhập</span></button>
                    </div>
                    <div class="footer"><a href="login/facebook">Facebook</a> | <a href="login/google">Google</a> | <a href="user/forgot">Quên mật khẩu?</a></div>
                </form>
            </div>
            <div class="card alt">
                <div class="toggle"><a href=""></a></div>
                <h1 class="title">Đăng ký
                    <div class="close"></div>
                </h1>
                <form method="post" action="user/register" name="register">
                    <div class="input-container">
                        <input name="remail" type="text" id="email"/>
                        <label for="email">Email</label>
                        <div class="r_error"><?php echo form_error('remail'); ?></div>
                        <div class="bar"></div>
                    </div>
                    <div class="input-container">
                        <input name="rname" type="text" id="name"/>
                        <label for="name">Họ và tên</label>
                        <div class="r_error"><?php echo form_error('rname'); ?></div>
                        <div class="bar"></div>
                    </div>
                    <div class="input-container">
                        <input name="rpass" type="password" id="password"/>
                        <label for="password">Mật khẩu</label>
                        <div class="r_error"><?php echo form_error('rpass'); ?></div>
                        <div class="bar"></div>
                    </div>
                    <div class="input-container">
                        <input name="rrepass" type="password" id="re_password"/>
                        <label for="re_password">Nhập lại mật khẩu</label>
                        <div class="r_error"><?php echo form_error('rrepass'); ?></div>
                        <div class="bar"></div>
                    </div>
                    <div class="button-container">
                        <button><span>Đăng ký</span></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Portfolio--><a id="portfolio" href="#" onclick="goBack()" title="View my portfolio!"><i class="fa fa-link"></i></a>
        <!-- CodePen--><a id="codepen" href="#" onclick="goBack()" title="Follow me!"><i class="fa fa-codepen"></i></a>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
        <script src='public/themes/js/jquery-1.7.2.min.js'></script>
        <script src="public/admin/js/index.js"></script>

    </body>
</html>
