<?
function maketoken() {
    $token = hash("sha256",uniqid());
    $_SESSION["request_token"] = $token;
    return $token;
}

function checktoken($token) {
    if($_SESSION["request_token"] == $token) {
        return true;
    } else {
        return false;
    }
}
