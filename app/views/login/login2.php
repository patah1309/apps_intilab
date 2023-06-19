<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="<?= base_url;?>/assets/login/style.css" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url; ?>/plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="<?= base_url; ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url; ?>/dist/css/adminlte.min.css">
        <title> <?= $data['title']; ?> </title>
    </head>
    <body>
        <div class="container">
            <div class="forms-container">
                <div class="signin-signup">
                    <form action="<?= base_url; ?>/login/prosesLogin" method="post">
                        <h2 class="title">Sign in</h2>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="Username" name="username">
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Password" name="password">
                        </div>
                        <button type="submit" class="btn solid">Sign In</button>
                        <!-- <p class="social-text">Or Sign in with social platforms</p> -->
                        <div class="social-media">
                        <?php
                            Flasher::Message();
                        ?>
                            <!-- <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a><a href="#" class="social-icon"><i class="fab fa-twitter"></i></a><a href="#" class="social-icon"><i class="fab fa-google"></i></a><a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a> -->
                        </div>
                    </form>
                    <!-- <form action="#" class="sign-up-form"><h2 class="title">Sign up</h2><div class="input-field"><i class="fas fa-user"></i><input type="text" placeholder="Username" /></div><div class="input-field"><i class="fas fa-envelope"></i><input type="email" placeholder="Email" /></div><div class="input-field"><i class="fas fa-lock"></i><input type="password" placeholder="Password" /></div><input type="submit" class="btn" value="Sign up" /><p class="social-text">Or Sign up with social platforms</p><div class="social-media"><a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a><a href="#" class="social-icon"><i class="fab fa-twitter"></i></a><a href="#" class="social-icon"><i class="fab fa-google"></i></a><a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a></div></form> -->
                </div>
            </div>
            <div class="panels-container">
                <div class="panel left-panel">
                    <div class="content">
                        <h3>APPS INTILAB</h3>
                    </div>
                    <img src="<?= base_url;?>/assets/login/img/log.svg" class="image" alt="" />
                </div>
                <!-- <div class="panel right-panel"><div class="content"><h3>One of us ?</h3><p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
              laboriosam ad deleniti.
            </p><button class="btn transparent" id="sign-in-btn">
              Sign in
            </button></div><img src="<?= base_url;?>/assets/login/img/register.svg" class="image" alt="" /></div> -->
            </div>
        </div>
        <script src="<?= base_url;?>/assets/login/app.js"></script>
        <!-- jQuery -->
        <script src="<?= base_url; ?>/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="<?= base_url; ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?= base_url; ?>/dist/js/adminlte.min.js"></script>
    </body>
</html>