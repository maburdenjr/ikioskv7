<div class="modal fade" id="systemDebug">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">iKiosk Debug Console</h4>
      </div>
        <ul id="systemDebug-tabs" class="nav nav-tabs">
          <li class="active"> <a data-toggle="tab" href="#debug-system">System</a> </li>
          <li> <a data-toggle="tab" href="#debug-session">Session</a> </li>
          <li> <a data-toggle="tab" href="#debug-user">User</a> </li>
          <li> <a data-toggle="tab" href="#debug-site">Site</a> </li>
          <li> <a data-toggle="tab" href="#debug-cms">CMS</a> </li>
          <li> <a data-toggle="tab" href="#debug-server">Server</a> </li>
        </ul>
        <div class="tab-content padding-10 custom-scroll">
          <div class="tab-pane fade in active" id="debug-system">
          	<table class="table table-hover table-striped table-bordered">
            <?php foreach ($SYSTEM as $key => $value) { echo "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";} ?>
            </table>
          </div>
          <div class="tab-pane fade in" id="debug-session">
          <table class="table table-hover table-striped table-bordered">
            <?php foreach ($_SESSION as $key => $value) { echo "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";} ?>
            </table>
          </div>
          <div class="tab-pane fade in" id="debug-user">
          <table class="table table-hover table-striped table-bordered">
            <?php foreach ($USER as $key => $value) { echo "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";} ?>
            </table>
          </div>
          <div class="tab-pane fade in" id="debug-site">
          <table class="table table-hover table-striped table-bordered">
            <?php foreach ($SITE as $key => $value) { echo "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";} ?>
            </table>
          </div>
          <div class="tab-pane fade in" id="debug-cms">
          <table class="table table-hover table-striped table-bordered">
            <?php foreach ($CMS as $key => $value) { echo "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";} ?>
            </table>
          </div>
          <div class="tab-pane fade in" id="debug-server">
          <table class="table table-hover table-striped table-bordered">
            <?php foreach ($_SERVER as $key => $value) { echo "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";} ?>
            </table>
          </div>
        </div>
      <div class="modal-footer" style="margin-top:0px;">
      	<div class="system-message"></div>
        <button type="button" class="btn btn-primary icon-action" data-type="purgeDB" data-code="SYS"><i class="fa fa-database"></i> Purge Deleted Records</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
      </div>
    </div>
  </div>
</div>
