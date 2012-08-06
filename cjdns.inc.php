<?
global $config,$cjdrouteconf;

$cjdrouteconf = "/etc/cjdroute.conf";

if(!($file = file_get_contents($cjdrouteconf))) {
    die("Failed to load $cjdrouteconf");
}

if(!($config = json_decode($file, TRUE))) {
    die("Failed to parse $cjdrouteconf: ".json_last_error());
}

function save_config() {
    global $cjdrouteconf,$config;
    return file_put_contents($cjdrouteconf, json_encode($config));
}

function getAuthorizedPasswords() {
    global $config;
    return $config['authorizedPasswords'];
}
