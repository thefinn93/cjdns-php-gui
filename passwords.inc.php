<div class="row">
    <div class="span10"><h1>AuthorizedPasswords</h1></div>
    <div class="span2">
        <div class="btn-group">
            <a href="javascript: void(0)" onclick="addpassword()" class="btn btn-success"><i class="icon-plus"></i></a>
            <a href="javascript: void(0)" onclick="getPasswords()" class="btn"><i class="icon-refresh"></i></a>
        </div>
    </div>
</div>
<br /><br />
<table class="table table-condensed">
<thead>
<tr><td>Assigned to</td><td>Password</td><td>Actions</td></tr>
</thead>
<tbody id="AuthorizedPasswords">
</tbody>
</table>


<!-- Modal Dialogs -->
<div class="modal fade hide" id="addpasswordmodal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Add Password</h3>
    </div>
    <div class="modal-body">
        <div id="addPasswordNameWrapper">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-user"></i></span><input id="addPasswordName" placeholder="Name" type="text">
                <span id="addPasswordNameMessage"></span>
            </div>
        </div>
        <div class="controls" id="addPasswordPasswordWrapper">
            <div class="input-prepend input-append">
                <span class="add-on"><i class="icon-lock"></i></span><input id="addPasswordPassword" type="text" placeholder="Password"><span class="add-on"><a href="javascript: void(0)" onclick="generatePassword('addPasswordPassword')">Generate</a></span>
                <span id="addPasswordPasswordMessage"></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript: void(0)" class="btn" data-dismiss="modal">Close</a>
        <a href="javascript: void(0)" class="btn btn-success" onclick="addPasswordSave()">Add</a>
    </div>
</div>

<div class="modal fade hide" id="editpasswordmodal">
    <input type="hidden" id="editPasswordKey" value="null" />
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Edit Password</h3>
    </div>
    <div class="modal-body">
        <div id="editPasswordNameWrapper">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-user"></i></span><input id="editPasswordName" placeholder="Name" type="text">
                <span id="editPasswordNameMessage"></span>
            </div>
        </div>
        <div class="controls" id="editPasswordPasswordWrapper">
            <div class="input-prepend input-append">
                <span class="add-on"><i class="icon-lock"></i></span><input id="editPasswordPassword" type="text" placeholder="Password"><span class="add-on"><a href="javascript: void(0)" onclick="generatePassword('editPasswordPassword')">Generate</a></span>
                <span id="editPasswordPasswordMessage"></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript: void(0)" class="btn" data-dismiss="modal">Close</a>
        <a href="javascript: void(0)" class="btn btn-success" id="editPasswordSave" onclick="editPasswordSave()">Save</a>
    </div>
</div>

<div class="modal fade hide" id="sharepasswordmodal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Share Connection Details</h3>
        <i id="shareto">Sharing with wangs</i>
    </div>
    <div class="modal-body">
        <textarea id="sharepasswordjson" rows="7"></textarea>
    </div>
    <div class="modal-footer">
		<code id="ezcrypturl"></code>
		<a href="#" class="btn" onclick="sendtoezcrypt()" id="ezcrypt-btn">ezcrypt</a>
        <a href="javascript: void(0)" class="btn btn-danger" data-dismiss="modal">Fuck Off</a>
    </div>
</div>
