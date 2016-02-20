<? include("config.inc.php");
$cjdns_git = substr(exec("git ls-remote $cjdnsgit origin -h refs/heads/master"),0,40);
$self_git = substr(exec("git ls-remote origin -h refs/heads/master"),0,40);
$out = array();
$out["self"] = array("current" => trim(file_get_contents(".git/refs/heads/master")), "latest" => $self_git);
$out["cjdns"] = array("current" => trim(file_get_contents("$cjdnsgit/.git/refs/heads/master")), "latest" => $cjdns_git);

if( isset($_REQUEST['action']) && $_REQUEST['action'] == "pull") {
    $out["pull"] = array();
    exec("git pull", $out["pull"]);
}

echo json_encode($out);
?>
