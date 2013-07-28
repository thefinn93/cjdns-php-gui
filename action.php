<?
session_start();
global $config;
require "cjdns.inc.php";
require "token.inc.php";
require "Bencode.php";
require "Cjdns.php";


$out = array('error' => false);


//// Uncomment the next line to dump all sorts of shit to the log file
//error_log(print_r($_REQUEST,true));

if(!isset($_REQUEST['token'])) {
    $out['error'] = "no token";
} elseif(checktoken($_REQUEST['token'])) {
    $cjdns = new Cjdns($config['admin']['password']);
    switch($_REQUEST['action']) {
        // AuthorizedPasswords
        case "AuthorizedPasswords_Add":
            $config['authorizedPasswords'][] = array("password" => $_REQUEST['password'], "name" => $_REQUEST['name']);
            $out['AuthorizedPassword_List'] = $config['authorizedPasswords'];
            $cjdns->call("AuthorizedPasswords_add", array("password" => $_REQUEST['password']));
            break;
        case "AuthorizedPasswords_Delete":
            unset($config['authorizedPasswords'][intval($_REQUEST['key'])]);
            $config['authorizedPasswords'] = array_values($config['authorizedPasswords']);
            $out['AuthorizedPassword_List'] = $config['authorizedPasswords'];
            break;
        case "AuthorizedPasswords_Edit":
            $config['authorizedPasswords'][intval($_REQUEST['key'])] = array("password" => $_REQUEST['password'], "name" => $_REQUEST['name']);
            $out['AuthorizedPassword_List'] = $config['authorizedPasswords'];
            $cjdns->call("AuthorizedPasswords_add", array("password" => $_REQUEST['password']));
            break;
        case "AuthorizedPasswords_List":
            $out['AuthorizedPassword_List'] = $config['authorizedPasswords'];
            break;

        // Peers
        
        case "Peer_List":
            $out['UDPPeer_List'] = $config['interfaces']['UDPInterface'][0]['connectTo'];
            $out['ETHPeer_List'] = $config['interfaces']['ETHInterface'][0]['connectTo'];
            break;

        case "UDPPeer_List":
            $out['UDPPeer_List'] = $config['interfaces']['UDPInterface'][0]['connectTo'];
            break;

        case "UDPPeer_Update":
            $config['interfaces']['UDPInterface'][0]['connectTo'][$_REQUEST['ip']] = array("name"=>$_REQUEST['name'],"publicKey"=>$_REQUEST['key'],"password"=>$_REQUEST['password'],"ipv6"=>$_REQUEST['ipv6']);
            $out['ETHPeer_List'] = $config['interfaces']['ETHInterface'][0]['connectTo'];
            $out['UDPPeer_List'] = $config['interfaces']['UDPInterface'][0]['connectTo'];
            $cjdns->call("UDPInterface_beginConnection", array("pubkey" => $_REQUEST['key'], "address" => $_REQUEST['ip'], "password" => $_REQUEST['password']));
            break;

        case "UDPPeer_Delete":
            unset($config['interfaces']['ETHInterface'][0]['connectTo'][$_REQUEST['ip']]);
            $out['ETHPeer_List'] = $config['interfaces']['ETHInterface'][0]['connectTo'];
            $out['UDPPeer_List'] = $config['interfaces']['UDPInterface'][0]['connectTo'];
            break;
        
        
        
        case "ETHPeer_List":
            $out['ETHPeer_List'] = $config['interfaces']['ETHInterface'][0]['connectTo'];
            break;

        case "ETHPeer_Update":
            $config['interfaces']['ETHInterface'][0]['connectTo'][$_REQUEST['mac']] = array("name"=>$_REQUEST['name'],"publicKey"=>$_REQUEST['key'],"password"=>$_REQUEST['password'],"ipv6"=>$_REQUEST['ipv6']);
            $out['ETHPeer_List'] = $config['interfaces']['ETHInterface'][0]['connectTo'];
            $out['UDPPeer_List'] = $config['interfaces']['UDPInterface'][0]['connectTo'];
            $cjdns->call("ETHInterface_beginConnection", array("pubkey" => $_REQUEST['key'], "macAddress" => $_REQUEST['mac'], "password" => $_REQUEST['password']));
            break;

        case "ETHPeer_Delete":
            unset($config['interfaces']['ETHInterface'][0]['connectTo'][$_REQUEST['ip']]);
            $out['ETHPeer_List'] = $config['interfaces']['ETHInterface'][0]['connectTo'];
            $out['UDPPeer_List'] = $config['interfaces']['UDPInterface'][0]['connectTo'];
            break;

        // Node Config
        case "MyInfo_Update":
            $config['myname'] = $_REQUEST['myname'];
            $config['ipv4'] = $_REQUEST['ipv4'];
            break;

        case "autofillv4":
            $bind = explode(":",$config['interfaces']['UDPInterface'][0]['bind']);
            $ip = explode("\n",file_get_contents("http://icanhazip.com"));
            $out['ip'] = $ip[0].":".$bind[1];
            break;

        // General Config
        case "GetConfig_ipv6":
            $out['ipv6'] = $config['ipv6'];
            break;

        case "GetConfig_pubkey":
            $out['pubkey'] = $config['pubkey'];
            break;
/* For testing purposes only, shouldn't be enabled
        case "GetConfig":
            $out['config'] = $config;
            break;
*/
    }
    if(!save_config()) {
        $out['error'] = "unable to save config";
    }
} else {
    $out['error'] = "bad token";
}
$out['token'] = maketoken();
echo json_encode($out, JSON_UNESCAPED_SLASHES);
