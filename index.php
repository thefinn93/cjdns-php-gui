<?
if(!is_file(".htaccess")) {
    echo "No .htaccess file. Try making one like this:";
    echo "<pre>Order deny,allow\ndeny from all\nallow from 127.0.0.1</pre>";
    exit();
}
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

<!-- copied from ezcrypt... -->
<script type="text/javascript">
	var lib = 'CRYPTO_JS';
</script>

<!-- /ezcrypt -->
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
				<li class="btn btn-warning gitcheck" id="cjdns-outdated"></li>
				<li class="btn btn-warning gitcheck" id="self-outdated"></li>
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
<!-- copied from ezcrypt -->
<script src="bootstrap/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="crypto/LAB.min.js"></script>
<script type="text/javascript" src="crypto/core.js"></script>
<script type="text/javascript" charset="utf8" src="crypto/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="crypto/codemirror/codemirror.min.js"></script>
<script type="text/javascript" src="crypto/codemirror/mode/combined.min.js"></script>
<script type="text/javascript" src="crypto/crypt.js"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="passwords.js" type="text/javascript"></script>
<script src="peers.js" type="text/javascript"></script>
<script src="misc.js" type="text/javascript"></script>
<script src="settings.js" type="text/javascript"></script>
<script src="git.js" type="text/javascript"></script>
</body>
</html>
