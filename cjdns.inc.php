<?
global $config,$cjdrouteconf;

if(!(include("config.inc.php"))) {
    die("Failed to include <code>config.inc.php</code>, please copy <code>config.inc.example.php</code> to <code>config.inc.php</code> and edit it to fit your requirements");
}

if(!($file = file_get_contents($cjdrouteconf))) {
    die("Failed to load $cjdrouteconf");
}

if(!($config = json_decode($file, TRUE))) {
    die("Failed to parse $cjdrouteconf - did you strip the comments out? PHP's JSON parser doesn't suppor them and fuck if I'm gunna write my own. netlore74 suggests this: <code>cat cjdroute.conf | perl -p0e 's!/\\*.*?\\*/!!sg' | grep -v \"//\"</code>");
}

function save_config() {
    global $cjdrouteconf,$config;
    return file_put_contents($cjdrouteconf, json_encode($config));
}

function getAuthorizedPasswords() {
    global $config;
    return $config['authorizedPasswords'];
}
