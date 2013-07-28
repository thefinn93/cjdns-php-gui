<?
global $config,$cjdrouteconf;

if(!(include("config.inc.php"))) {
    die("Failed to include <code>config.inc.php</code>, please copy <code>config.inc.example.php</code> to <code>config.inc.php</code> and edit it to fit your requirements");
}

if(phpversion() < 5.4) {
    die("Please get PHP 5.4 (You appear to have ".phpversion().")");
}

if(!($file = file_get_contents($cjdrouteconf))) {
    die("Failed to load $cjdrouteconf");
}

if(!($config = json_decode($file, TRUE))) {
    die("Failed to parse $cjdrouteconf - did you strip the comments out and such? try running it through the cleanconfig binary in the build folder of cjdns.");
}

function save_config() {
    global $cjdrouteconf,$config;
    return file_put_contents($cjdrouteconf, json_encode($config, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
}

function getAuthorizedPasswords() {
    global $config;
    return $config['authorizedPasswords'];
}
