// AuthorizedPassword related functions:

var AuthorizedPasswords_XHR,ezcrypt_XHR,pw,token;
var pageload = true;

function addpassword() {
    document.getElementById("addPasswordName").value = "";
    document.getElementById("addPasswordPassword").value = "";
    document.getElementById("addPasswordNameWrapper").setAttribute("class", "control");
    document.getElementById("addPasswordPasswordWrapper").setAttribute("class", "control");
    document.getElementById("addPasswordNameMessage").innerHTML = "";
    document.getElementById("addPasswordPasswordMessage").innerHTML = "";
    $('#addpasswordmodal').modal();
}

function addPasswordSave() {
    name = document.getElementById("addPasswordName").value;
    password = document.getElementById("addPasswordPassword").value;
    if(name == "") {
        document.getElementById("addPasswordNameWrapper").setAttribute("class", "control-group error");
        document.getElementById("addPasswordNameMessage").innerHTML = "Gotta fill this out, bro";
    }
    if(password == "") {
        document.getElementById("addPasswordPasswordWrapper").setAttribute("class", "control-group error");
        document.getElementById("addPasswordPasswordMessage").innerHTML = "C'mon, set a password";
    }

    if(password != "" && name != "") {
        AuthorizedPasswords_XHR = new XMLHttpRequest;
        AuthorizedPasswords_XHR.onload = showPasswords;
        AuthorizedPasswords_XHR.open("POST","action.php",true);
        AuthorizedPasswords_XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        AuthorizedPasswords_XHR.send("action=AuthorizedPasswords_Add&name=" + encodeURIComponent(name) + "&password=" + encodeURIComponent(password) + "&token=" + token)
        $('#addpasswordmodal').modal('hide');
    }
}

function getPasswords() {
    AuthorizedPasswords_XHR = new XMLHttpRequest();
    AuthorizedPasswords_XHR.onload = showPasswords;
    AuthorizedPasswords_XHR.open("GET","action.php?action=AuthorizedPasswords_List&token=" + token,true);
    AuthorizedPasswords_XHR.send(null);
}

function showPasswords() {
    response = JSON.parse(AuthorizedPasswords_XHR.responseText);
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
        out = "";
        passwords = response.AuthorizedPassword_List;
        for(i = 0; i < response.AuthorizedPassword_List.length; i++) {
            name = "unset";
            if(response.AuthorizedPassword_List[i]['person'] != undefined) {
                name = response.AuthorizedPassword_List[i]['person']
            }
            if(response.AuthorizedPassword_List[i]['name'] != undefined) {
                name = response.AuthorizedPassword_List[i]['name'];
            }
            pass = response.AuthorizedPassword_List[i]['password'];
            out += "<tr id=\"password" + i + "\">";
            out += "<td>" + name + "</td>";
            out += "<td><code>" + pass + "</code></td>";
            out += "<td><span class=\"btn-group\">";
            out += "<a class=\"btn btn-small btn-danger tip-left\" id=\"password" + i + "delete\" href=\"javascript: void(0)\" onclick=\"deletepassword(" + i + ")\" rel=\"tooltip\" title=\"Delete\"><i class=\"icon-trash\"></i></a>";
            out += "<a class=\"btn btn-small tip-bottom\" href=\"javascript: void(0)\" id=\"password" + i + "edit\" onclick=\"editpassword(" + i + ")\" rel=\"tooltip\" title=\"Edit\"><i class=\"icon-pencil\"></i></a>";
            out += "<a class=\"btn btn-small tip-right\" href=\"#\" id=\"password" + i + "copy\" onclick=\"sharePassword(" + i + ")\" rel=\"tooltip\" title=\"Copy\"><i class=\"icon-share\"></i></a>"
            out += "</span></td></tr>\n";
        }
        document.getElementById("AuthorizedPasswords").innerHTML = out;
    }
    token = response['token'];
    if(pageload) {
        getUDPPeers();
        pageload = false;
    }
    updateTooltips();
}

function deletepassword(key) {
    $("#password" + key + "delete").tooltip("hide");
    document.getElementById("password" + key + "delete").innerHTML = "Confirm";
    if(confirm("Are you sure you want to delete " + passwords[key]['name'] + "'s password?")) {
        AuthorizedPasswords_XHR = new XMLHttpRequest;
        AuthorizedPasswords_XHR.onload = showPasswords;
        AuthorizedPasswords_XHR.open("POST","action.php",true);
        AuthorizedPasswords_XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        AuthorizedPasswords_XHR.send("action=AuthorizedPasswords_Delete&key=" + key + "&token=" + token)
    } else {
    showPasswords();
    }
}

function editpassword(key) {
    document.getElementById("editPasswordName").value = passwords[key]['name'];
    document.getElementById("editPasswordPassword").value = passwords[key].password;
    document.getElementById("editPasswordKey").value = key;
    $('#editpasswordmodal').modal();
}

function editPasswordSave() {
    key = document.getElementById("editPasswordKey").value;
    name = document.getElementById("editPasswordName").value;
    password = document.getElementById("editPasswordPassword").value;
    if(name == "") {
        document.getElementById("editPasswordNameWrapper").setAttribute("class", "control-group error");
        document.getElementById("editPasswordNameMessage").innerHTML = "Gotta fill this out, bro";
    }
    if(password == "") {
        document.getElementById("editPasswordPasswordWrapper").setAttribute("class", "control-group error");
        document.getElementById("editPasswordPasswordMessage").innerHTML = "C'mon, set a password";
    }

    if(password != "" && name != "") {
        AuthorizedPasswords_XHR = new XMLHttpRequest;
        AuthorizedPasswords_XHR.onload = showPasswords;
        AuthorizedPasswords_XHR.open("POST","action.php",true);
        AuthorizedPasswords_XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        AuthorizedPasswords_XHR.send("action=AuthorizedPasswords_Edit&key=" + key + "&name=" + encodeURIComponent(name) + "&password=" + encodeURIComponent(password) + "&token=" + token)
        $('#editpasswordmodal').modal('hide');
    }
}

function generatePassword(field) {
    chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-=+_)(*&^%$#@!`~";
    len = 20;
    out = "";
    for(i = 0; i < len; i++) {
        out += chars.charAt(Math.round(Math.random()*chars.length));
    }
    document.getElementById(field).value = out;
}

function sharePassword(key) {
    peeringdetails = "\"" + myv4 + "\":\n                {\n                    \"name\":\"" + myname + "\",\n                    \"publicKey\":\"" + mypubkey + "\",\n                    // This password has been assigned to " +  passwords[key]['name'] + ".\n                    \"password\":\"" + passwords[key].password + "\",\n                    \"ipv6\":\"" + myv6 + "\"\n                }";
    document.getElementById("sharepasswordjson").innerHTML = peeringdetails;
    document.getElementById("shareto").innerHTML = "Password for " + passwords[key]['name'];
    document.getElementById("ezcrypturl").style.display = "none";
    document.getElementById("ezcrypt-btn").style.display = "inline";
    document.getElementById("ezcrypt-btn").innerHTML = "ezcrypt";
    $('#sharepasswordmodal').modal(); 
}

function sendtoezcrypt() {
	ez = this;
	pw = generateKey();
	unencrypted = document.getElementById("sharepasswordjson").value;
	data = encrypt(pw, unencrypted);
	console.log(unencrypted + "\n\n encrypted with password " + pw + " becomes: \n" + data);
	ezcrypt_XHR = new XMLHttpRequest();
	ezcrypt_XHR.onload = ezcryptShowURL;
	ezcrypt_XHR.open("GET","ezcrypt.php?data=" + encodeURIComponent(data) + "&ttl=604800&p=" + encodeURIComponent(pw), true);
	ezcrypt_XHR.send(null);
	document.getElementById("ezcrypt-btn").innerHTML = "Loading...";
}

function ezcryptShowURL() {
	result = JSON.parse(ezcrypt_XHR.responseText);
	url = "https://ezcrypt.it/" + result['id'] + "#" + pw;
	document.getElementById("ezcrypturl").innerHTML = "<a href=\"" + url + "\" target=\"blank\">" + url + "</a>";
	document.getElementById("ezcrypturl").style.display = "inline";
	document.getElementById("ezcrypt-btn").style.display = "none";
}
ezcrypt();
passwords = [];
getPasswords();
