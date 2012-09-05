<? include("config.inc.php");
$cjdns_git = json_decode(file_get_contents("https://api.github.com/repos/cjdelisle/cjdns/commits"));
$self_git = json_decode(file_get_contents("https://api.github.com/repos/thefinn93/cjdns-php-gui/commits"));
$out = array();
$out["self"] = array("current" => trim(file_get_contents(".git/refs/heads/master")), "latest" => $self_git[0]->sha);
$out["cjdns"] = array("current" => trim(file_get_contents("$cjdnsgit/.git/refs/heads/master")), "latest" => $cjdns_git[0]->sha);

if($_REQUEST['action'] == "pull") {
    $out["pull"] = array();
    exec("git pull", $out["pull"]);
}

echo json_encode($out);
?>
