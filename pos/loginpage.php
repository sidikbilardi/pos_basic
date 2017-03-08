<?php 
session_start();
$_SESSION['d_e'] = '2017-10-10 00:00:00';
//include "inc/check.php";
//include "../kitchenl/check.php";
$today = date("Y-m-d H:i:s");
$d= $_SESSION['d_e'];
 $dd = date('Y-m-d H:i:s', strtotime($d. ' - 7 days'));
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>RAMOS</title>
    <link href="css/img/willert/favicon.png" rel="shortcut icon">
    <link href="css/vinzlee.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="htmllogin">
<div class="col-sm-12 col-xs-12 col-md-4 col-lg-4"></div>
<div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
    <?php if($_SESSION['d_e'] != ''){
        if($today >= $dd){ ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Your License will expired at <?php echo $_SESSION['d_e'];?>!
            </div>             
        <?php }
        if($today >= $_SESSION['d_e']){ ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Your License has expired !
            </div>             
        <?php }        
    }else{ ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        You dont have a License !
    </div>  
    <?php } ?>

    <?php if(isset($_SESSION['error_msg'])){ ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        <?php if(isset($_SESSION['error_msg'])) { echo $_SESSION['error_msg']; }?>
    </div>  
    <?php } ?>
</div>  
<div class="col-sm-12 col-xs-12 col-md-4 col-lg-4"></div>  
    <div class="logologin"></div>
<?php  if($today >= $_SESSION['d_e']){
    include"../kitchenl/index.php";
}else{ ?> 
    <form action="inc/login.php?action=doLogin" method="POST">
<div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
            </div>
<div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
    
        <div align="center">
                    <div class="form-group">
                        <input type="text" autocomplete='off' name="userid" id="userid" class="form-control inputlogin" style="border:2px solid #431d5c" placeholder="User ID or Username"/>
                    </div>
                    <div class="form-group">
                        <input type="password" autocomplete='off' name="password" id="password" class="form-control inputlogin" style="border:2px solid #431d5c" placeholder="Password"/>
                    </div>          
                
                </div>

                <div class="footer">
                                                                                
                    <button type="submit" class="btn btn-success btn-block">Log me in !</button>  
                  
                </div>

        <p class="credit">
        <a target="_blank" href="https://www.willertindo.com">Willertindo Innovation Solution</a>
        - your technology solution
    </p></div>  
<div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
            </div>                
        </div>
    </form>
<?php } ?>
<script src="js/MainJS/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
</body>
</html>