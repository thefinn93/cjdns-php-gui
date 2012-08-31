var git_XHR = new XMLHttpRequest();
git_XHR.onload = gitCB;
git_XHR.open("GET","git.php",true);
git_XHR.send(null);

function gitCB() {
	response = JSON.parse(git_XHR.responseText);
	if(response['self']['current'] != response['self']['latest']) {
		document.getElementById("self-outdated").innerHTML = "GUI not the latest Git";
		document.getElementById("self-outdated").style.display = "inline";
		updateTooltips();
	} else {
		console.log("GUI is up to date (latest commit's sha was " + response['self']['latest'] + ")")
	}
	if(response['cjdns']['current'] != response['cjdns']['latest']) {
		document.getElementById("cjdns-outdated").innerHTML = "CJDNS not the latest Git";
		document.getElementById("cjdns-outdated").style.display = "inline";
		updateTooltips();
	} else {
		console.log("CJDNS is up to date (latest commit's sha was " + response['cjdns']['latest'] + ")")
	}
}
