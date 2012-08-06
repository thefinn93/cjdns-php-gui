var autofillxhr,settingsxhr;

function autofillv4() {
    autofillxhr = new XMLHttpRequest;
    autofillxhr.onload = showv4;
    autofillxhr.open("GET","action?action=autofillv4&token=" + token,true);
    autofillxhr.send(null);
}

function showv4() {
    result = JSON.parse(autofillxhr.responseText);
    document.getElementById("settingsIpv4").value = result['ip'];
    token = result['token'];
}

function showSettings() {
    $("#settingsmodal").modal();
}

function saveSettings() {
    settingsxhr = new XMLHttpRequest;
    settingsxhr.onload = settingsSaved;
    settingsxhr.open("POST","action",true);
    settingsxhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    settingsxhr.send("action=MyInfo_Update&myname=" + encodeURIComponent(document.getElementById("settingsName").value) + "&ipv4=" + encodeURIComponent(document.getElementById("settingsIpv4").value) + "&token=" + token);
}

function settingsSaved() {
    result = JSON.parse(settingsxhr.responseText);
    token = result['token'];
    if(result['error'] = "false") {
        $("#settingsmodal").modal('hide');
    } else {
        alert("An error occured: " + result['error']);
    }
    myname = document.getElementById("settingsName").value;
    myv4 = document.getElementById("settingsIpv4").value;
}
