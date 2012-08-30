<?
session_start();
require_once("cjdns.inc.php");
require_once("token.inc.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>CJDNS Admin Panel</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
</head>
<body data-spy="scroll">
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="javascript:void(0)">CDJNS</a>
            <ul class="nav">
                <li class="active">
                    <a href="#passwords">Authorized Passwords</a>
                </li>
                <li><a href="#peers">UDP Peers</a></li>
                <li><a href="javascript:showSettings()">Settings</a></li>
            </ul>
            <ul class="nav pull-right">
				<li class="btn btn-danger gitcheck" id="cjdns-outdated"></li>
				<li class="btn btn-danger gitcheck" id="self-outdated"></li>
                <li><a href="javascript:showSettings()"><? if(isset($config['myname'])) {echo $config['myname'];} else {echo $config['ipv6'];} ?></a></li>
            </ul>
        </div>
    </div>
</div>
<br /><br /><br />
<div class="container">
<div id="passwords">
<? require("passwords.inc.php"); ?>
</div>
<div id="peers">
<? require("peers.inc.php"); ?>
</div>
</div>
<? require("settings.inc.php"); ?>
<script type="text/javascript">
var token = "<? echo maketoken(); ?>";
var myv6 = "<? echo $config['ipv6']; ?>";
var myv4 = "<? if(isset($config['ipv4'])) {echo $config['ipv4'];} else {echo "set me";} ?>";
var mypubkey = "<? echo $config['publicKey']; ?>";
var myname = "<? if(isset($config['myname'])) {echo $config['myname'];} else {echo "set me";} ?>";
</script>
<script src="bootstrap/js/jquery.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap-tooltip.js" type="text/javascript"></script>
<script src="passwords.js" type="text/javascript"></script>
<script src="peers.js" type="text/javascript"></script>
<script src="misc.js" type="text/javascript"></script>
<script src="settings.js" type="text/javascript"></script>
</body>
</html>
