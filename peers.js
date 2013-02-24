var Peers_XHR,peers;
function getPeers() {
    Peers_XHR = new XMLHttpRequest();
    Peers_XHR.onload = showPeers;
    Peers_XHR.open("POST","action.php",true);
    Peers_XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    Peers_XHR.send("action=Peer_List&token=" + token);
}

function showPeers() {
    response = JSON.parse(Peers_XHR.responseText);
    if(response['error'] != false) {
        switch(response['error']) {
            case "no token":
                // Figure out how to resubmit request
            break;
            case "bad token":
                // Again, figure out how to resubmit
            break;
            case "unable to save config":
                alert("Unable to save config!");
            break;
        }
    } else {
        udpout = "";
        UDPPeers = response['UDPPeer_List'];
        for(peer in UDPPeers) {
            console.log(peer)
            udpout += "<tr><td>" + UDPPeers[peer]['name'] + "</td>";
            udpout += "<td><code>" + peer + "</code></td>";
            udpout += "<td><a href=\"#\" rel=\"tooltip\" class=\"tip-bottom\" title=\"" + UDPPeers[peer]['publicKey'] + "\">[expand]</a></td>";
            udpout += "<td><code>" + UDPPeers[peer]['password'] + "</code></td>";
            udpout += "<td><code>" + UDPPeers[peer]['ipv6'] + "</code></td>";
            udpout += "<td><span class=\"btn-group\">";
            udpout += "<a class=\"btn btn-small btn-danger tip-left\" id=\"peer" + peer + "delete\" href=\"javascript: void(0)\" onclick=\"deletepeer('" + peer + "', true)\" rel=\"tooltip\" title=\"Delete\"><i class=\"icon-trash\"></i></a>";
            udpout += "<a class=\"btn btn-small tip-right\" href=\"javascript: void(0)\" id=\"peer" + peer + "edit\" onclick=\"editpeer('" + peer + "', true)\" rel=\"tooltip\" title=\"Edit\"><i class=\"icon-pencil\"></i></a>";
            udpout += "</span></td></tr>";
        }
        document.getElementById("UDPPeer_List").innerHTML = udpout;
        
        ethout = "";
        ETHPeers = response['ETHPeer_List'];
        for(peer in ETHPeers) {
            ethout += "<tr><td>" + ETHPeers[peer]['name'] + "</td>";
            ethout += "<td><code>" + peer + "</code></td>";
            ethout += "<td><a href=\"#\" rel=\"tooltip\" class=\"tip-bottom\" title=\"" + ETHPeers[peer]['publicKey'] + "\">[expand]</a></td>";
            ethout += "<td><code>" + ETHPeers[peer]['password'] + "</code></td>";
            ethout += "<td><code>" + ETHPeers[peer]['ipv6'] + "</code></td>";
            ethout += "<td><span class=\"btn-group\">";
            ethout += "<a class=\"btn btn-small btn-danger tip-left\" id=\"peer" + peer + "delete\" href=\"javascript: void(0)\" onclick=\"deletepeer('" + peer + "', false)\" rel=\"tooltip\" title=\"Delete\"><i class=\"icon-trash\"></i></a>";
            ethout += "<a class=\"btn btn-small tip-right\" href=\"javascript: void(0)\" id=\"peer" + peer + "edit\" onclick=\"editpeer('" + peer + "', false)\" rel=\"tooltip\" title=\"Edit\"><i class=\"icon-pencil\"></i></a>";
            ethout += "</span></td></tr>";
        }
        document.getElementById("ETHPeer_List").innerHTML = ethout;
    }
    token = response['token'];
    updateTooltips();
}

function addPeer() {
    fields = ["addPeerName","addPeerIP","addPeerKey","addPeerPassword","addPeerCJDNSIP"];
    for(i = 0; i < fields.length; i++) {
        document.getElementById(fields[i]).value = "";
        document.getElementById(fields[i] + "Wrapper").setAttribute("class", "");
        document.getElementById(fields[i] + "Message").innerHTML = ""
    }
    $('#addpeermodal').modal();
}

function validate(field, input) {
    ipv4regex = /([01]?\d\d?|2[0-4]\d|25[0-5])\.([01]?\d\d?|2[0-4]\d|25[0-5])\.([01]?\d\d?|2[0-4]\d|25[0-5])\.([01]?\d\d?|2[0-4]\d|25[0-5])\:([05]?\d\d\d\d?|6[0-4]?\d\d\d?|65[0-4]?\d\d?|655[0-2]?\d\d?|6553[0-5])/g; // Derived from http://www.mkyong.com/regular-expressions/how-to-validate-ip-address-with-regular-expression/
    keyregex = /.{52}\.\k/g;
    nameregex = /.{1}/g;
    macregex = /([0-9A-F]{2}[:-]){5}([0-9A-F]{2})/g;

    regex = {};

    regex['addPeerIP'] = ipv4regex;
    regex['addPeerName'] = nameregex;
    regex['addPeerKey'] = keyregex;
    regex['addPeerPassword'] = nameregex;   // Name Regex matches anything that isn't blank
    regex['addPeerCJDNSIP'] = nameregex;    // Need to write one of these, not at 5am tho
    regex['addPeerMAC'] = macregex;

    if(regex[field].test(input)) {
        document.getElementById(field + 'Wrapper').setAttribute("class","control-group success");
        return true;
    } else {
        document.getElementById(field + 'Wrapper').setAttribute("class","control-group error");
        return false;
    }
}

function swtichUDPETH() {
     udp = document.getElementById("addPeerType-UDP").checked
     console.log("UDP: " + udp);
     if(udp) {
         document.getElementById("addPeerMACWrapper").id = "addPeerIPWrapper";
         document.getElementById("addPeerIP").setAttribute("placeholder", "IP:Port");
     } else {
         document.getElementById("addPeerIPWrapper").id = "addPeerMACWrapper";
         document.getElementById("addPeerIP").setAttribute("placeholder", "MAC Address");
     }
}


function addPeerSave() {
    udp = document.getElementById("addPeerType-UDP").checked
    name = document.getElementById("addPeerName").value;
    ip = document.getElementById("addPeerIP").value;
    key = document.getElementById("addPeerKey").value;
    password = document.getElementById("addPeerPassword").value;
    cjdnsip = document.getElementById("addPeerCJDNSIP").value;

    save = true;

    if(name == "") {
        save = false;
        document.getElementById("addPeerNameMessage").innerHTML = "Please name this peer";
        document.getElementById("addPeerNameWrapper").setAttribute("class","control-group error");
    }
    if(udp && !validate("addPeerIP",ip)) {
        document.getElementById("addPeerIPMessage").innerHTML = "Please provide a valid ip and port (ignore this message if it's a v6)";
    }
    if(!udp && validate("addPeerMAC",ip)) {
        document.getElementById("addPeerIPMessage").innerHTML = "Please provide a valid MAC address";
    }
    if(!validate("addPeerKey",key)) {
        save = false;
        document.getElementById("addPeerKeyMessage").innerHTML = "You probably copied something wrong here...";
    }
    if(password == "") {
        save = false;
        document.getElementById("addPeerPasswordMessage").innerHTML = "You need to provide a password";
        document.getElementById("addPeerPasswordWrapper").setAttribute("class","control-group error");
    }
    if(cjdnsip == "") {
        document.getElementById("addPeerCJDNSIPMessage").innerHTML = "I'd be good to fill this out";
        document.getElementById("addPeerCJDNSIPWrapper").setAttribute("class","control-group error");
    }

    if(save) {
        Peers_XHR = new XMLHttpRequest();
        Peers_XHR.onload = showPeers;
        Peers_XHR.open("POST","action.php",true);
        Peers_XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        if(udp) {
            Peers_XHR.send("action=UDPPeer_Update&token=" + token + "&name=" + encodeURIComponent(name) + "&ip=" + encodeURIComponent(ip) + "&key=" + encodeURIComponent(key) + "&password=" + encodeURIComponent(password) + "&ipv6=" + encodeURIComponent(cjdnsip));
        } else {
            Peers_XHR.send("action=ETHPeer_Update&token=" + token + "&name=" + encodeURIComponent(name) + "&mac=" + encodeURIComponent(ip) + "&key=" + encodeURIComponent(key) + "&password=" + encodeURIComponent(password) + "&ipv6=" + encodeURIComponent(cjdnsip));
        }
        $('#addpeermodal').modal('hide');
    }
}

function deletepeer(ip,udp) {
    if(udp) {
        name = UDPPeers[peer]['name'];
        action = "UDPPeer_Delete";
    } else {
        name = ETHPeers[peer]['name'];
        action = "ETHPeer_Delete";
    }
    $("#peer" + peer + "delete").tooltip("hide");
    document.getElementById("peer" + peer + "delete").innerHTML = "Confirm";
    if(confirm("Are you sure you want to delete " + name + " from your peers?")) {
        Peers_XHR = new XMLHttpRequest();
        Peers_XHR.onload = showPeers;
        Peers_XHR.open("POST","action.php",true);
        Peers_XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        Peers_XHR.send("action=" + action + "&token=" + token + "&ip=" + encodeURIComponent(ip));
    }
    showPeers()
}


function editpeer(ip, udp) {
    if(UDPPeers[ip]['name'] != undefined) {
        document.getElementById("addPeerName").value = UDPPeers[ip]['name'];
    } else {
        document.getElementById("addPeerName").value = "";
    }

    document.getElementById("addPeerIP").value = ip;

    if(UDPPeers[ip]['publicKey'] != undefined) {
        document.getElementById("addPeerKey").value = UDPPeers[ip]['publicKey'];
    } else {
        document.getElementById("addPeerKey").value = "";
    }

    if(UDPPeers[ip]['password'] != undefined) {
        document.getElementById("addPeerPassword").value = UDPPeers[ip]['password'];
    } else {
        document.getElementById("addPeerPassword").value = "";
    }

    if(UDPPeers[ip]['ipv6'] != undefined) {
        document.getElementById("addPeerCJDNSIP").value = UDPPeers[ip]['ipv6'];
    } else {
        document.getElementById("addPeerCJDNSIP").value = "";
    }

    fields = ["addPeerName","addPeerIP","addPeerKey","addPeerPassword","addPeerCJDNSIP"];
    for(i = 0; i < fields.length; i++) {
        document.getElementById(fields[i] + "Wrapper").setAttribute("class", "");
        document.getElementById(fields[i] + "Message").innerHTML = ""
    }
    $('#addpeermodal').modal();    
}

function parseinput(input) {
	/*
    singleLineComment = RegExp("//.*?\\n","");
    multiLineComment = RegExp("/\\*.*?\\/","");

    while(singleLineComment.test(input)) {
        input = input.replace(singleLineComment, "");
        console.log(input);
    }

    while(multiLineComment.test(input)) {
        input = input.replace(multiLineComment, "");
        console.log("Removed a /*");
    }
    */

    try {
        out = JSON.parse(input);
    }
    catch(e) {
        out = e;
    }
    return out;
}

// Unrelated to peering
$('.btn').tooltip({'placement':'bottom'});
