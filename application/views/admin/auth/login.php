<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo isset($title) ? $title : '';  ?> | FunnyApp</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        body{
            background-color: #f8f8f8 
        }
        .login-panel{
            margin-top: 25%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo base_url(ADMIN_URL) ?>login/process" method="post">
                            <fieldset>
                                <?php 
                                    $message = $this->session->flashdata('error_message');
                                    if (isset($message) && $message!='') { ?>
                                        <div class="alert alert-danger"><?php echo $message ?></div>
                                    <?php }

                                    $message = $this->session->flashdata('success_massage');
                                    if (isset($message) && $message!='') { ?>
                                        <div class="alert alert-success"><?php echo $message ?></div>
                                    <?php }

                                 ?>

                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                               <div class="pull-right">
                                    <a href="<?=base_url(ADMIN_URL)?>forget-password" class="forget-link">Forgot Password?</a>&nbsp;&nbsp;&nbsp;<button class="btn btn-success" type="submit">Login</button>
                                </div>
                                
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="<?php echo base_url() ?>assets/js/jquery.js"></script>
  
    <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
</body>

</html>
