<br /><br />
<div class="row">
    <div class="span10"><h1>UDP Peers</h1></div>
    <div class="span2">
        <div class="btn-group">
            <a href="#" onclick="addPeer()" rel="tooltip" title="Add a UDP peer" class="btn btn-success"><i class="icon-plus"></i></a>
            <a href="#" onclick="getUDPPeers()" rel="tooltip" title="Refresh the list of UDP peers" class="btn"><i class="icon-refresh"></i></a>
        </div>
    </div>
</div>
<table class="table table-condensed">
<thead>
<tr><td>Name</td><td>IP:Port</td><td>Public Key</td><td>Password</td><td>CJDNS IP</td><td>Actions</td></tr>
</thead>
<tbody id="UDPPeer_List">
</tbody>
</table>

<div class="modal fade hide" id="addpeermodal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Add a UDP Peer</h3>
    </div>
    <div class="modal-body">
        <div id="addPeerNameWrapper">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-user"></i></span><input id="addPeerName" placeholder="Name" type="text" onblur="validate(this.id, this.value)">
                <span id="addPeerNameMessage"></span>
            </div>
        </div>
        <div id="addPeerIPWrapper">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-router"></i></span><input id="addPeerIP" type="text" placeholder="IP:port" onblur="validate(this.id, this.value)">
                <span id="addPeerIPMessage"></span>
            </div>
        </div>
        <div id="addPeerKeyWrapper">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-keys"></i></span><input id="addPeerKey" type="text" placeholder="Public Key" onblur="validate(this.id, this.value)">
                <span id="addPeerKeyMessage"></span>
            </div>
        </div>
        <div id="addPeerPasswordWrapper">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-lock"></i></span><input id="addPeerPassword" type="text" placeholder="Password" onblur="validate(this.id, this.value)">
                <span id="addPeerPasswordMessage"></span>
            </div>
        </div>
        <div id="addPeerCJDNSIPWrapper">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-home"></i></span><input id="addPeerCJDNSIP" type="text" placeholder="CJDNS IP" onblur="validate(this.id, this.value)">
                <span id="addPeerCJDNSIPMessage"></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
		<a href="#" class="btn" onclick="addImportJSON()">Import JSON</a>
        <a href="#" class="btn" data-dismiss="modal">Close</a>
        <a href="#" class="btn btn-success" onclick="addPeerSave()">Add</a>
    </div>
</div>

<div class="modal fade hide" id="addpeerJSONmodal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Import Connection details</h3>
    </div>
    <div class="modal-body">
        <textarea id="addpeerJSON" rows="7"></textarea>
    </div>
    <div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Close</a>
        <a href="javascript: void(0)" class="btn btn-success"  onclick="addPeerJSONSave()">Add</a>
    </div>
</div>
