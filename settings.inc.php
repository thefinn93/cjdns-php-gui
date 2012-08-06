<div class="modal fade hide" id="settingsmodal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Edit Settings</h3>
    </div>
    <div class="modal-body">
        <div id="settingsNameWrapper">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-user"></i></span><input id="settingsName" placeholder="Your Name" value="<? if(isset($config['myname'])) {echo $config['myname'];};?>" type="text">
            </div>
        </div>
        <div class="controls" id="settingsIpv4Wrapper">
            <div class="input-prepend input-append">
                <span class="add-on"><i class="icon-router"></i></span><input id="settingsIpv4" type="text" placeholder="Your IP:Password" value="<? if(isset($config['ipv4'])) {echo $config['ipv4'];} ?>"><a class="btn add-on" href="#" onclick="autofillv4()">Autofill</a>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript: void(0)" class="btn" data-dismiss="modal">Close</a>
        <a href="javascript: void(0)" class="btn btn-success" onclick="saveSettings()">Save</a>
    </div>
</div>
