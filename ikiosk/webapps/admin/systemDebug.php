<div class="modal fade" id="systemDebug">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">iKiosk Debug Console</h4>
      </div>
      <div class="modal-body">
        <ul id="systemDebug-tabs" class="nav nav-tabs bordered">
          <li class="active"> <a data-toggle="tab" href="#system">System</a> </li>
          <li> <a data-toggle="tab" href="#session">Session</a> </li>
          <li> <a data-toggle="tab" href="#user">User</a> </li>
          <li> <a data-toggle="tab" href="#site">Site</a> </li>
          <li> <a data-toggle="tab" href="#cms">CMS</a> </li>
          <li> <a data-toggle="tab" href="#server">Server</a> </li>
        </ul>
        <div class="tab-content padding-10 custom-scroll">
          <div class="tab-pane fade in active" id="system">
          	<table class="table table-hover table-striped table-bordered">
            <?php foreach ($SYSTEM as $key => $value) { echo "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";} ?>
            </table>
          </div>
          <div class="tab-pane fade in" id="session">
          <table class="table table-hover table-striped table-bordered">
            <?php foreach ($_SESSION as $key => $value) { echo "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";} ?>
            </table>
          </div>
          <div class="tab-pane fade in" id="user">
          <table class="table table-hover table-striped table-bordered">
            <?php foreach ($USER as $key => $value) { echo "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";} ?>
            </table>
          </div>
          <div class="tab-pane fade in" id="site">
          <table class="table table-hover table-striped table-bordered">
            <?php foreach ($SITE as $key => $value) { echo "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";} ?>
            </table>
          </div>
          <div class="tab-pane fade in" id="cms">
          <table class="table table-hover table-striped table-bordered">
            <?php foreach ($CMS as $key => $value) { echo "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";} ?>
            </table>
          </div>
          <div class="tab-pane fade in" id="server">
          <table class="table table-hover table-striped table-bordered">
            <?php foreach ($_SERVER as $key => $value) { echo "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";} ?>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
      </div>
    </div>
  </div>
</div>
