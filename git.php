<? include("config.inc.php");
$cjdns_git = exec("git ls-remote $cjdnsgit origin -h refs/heads/master")
$self_git = exec("git ls-remote origin -h refs/heads/master").substr(0,40);
$out = array();
$out["self"] = array("current" => trim(file_get_contents(".git/refs/heads/master")), "latest" => $self_git[0]->sha);
$out["cjdns"] = array("current" => trim(file_get_contents("$cjdnsgit/.git/refs/heads/master")), "latest" => $cjdns_git[0]->sha);

if($_REQUEST['action'] == "pull") {
    $out["pull"] = array();
    exec("git pull", $out["pull"]);
}

echo json_encode($out);
?>
