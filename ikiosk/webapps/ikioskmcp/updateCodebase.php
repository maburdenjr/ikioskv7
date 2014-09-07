<?php
/* iKiosk 7.0 Tiger */

$PAGE['application_code'] = "IKMCP";
require('../../includes/core/ikiosk.php');
?>

<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title">Update Codebase</h1>
  </div>
</div>
<section id="widget-grid">
<div class="row">
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="jarviswidget" id="updateCodebase" data-widget-editbutton="false" data-widget-deletebutton="false">
    <header> <span class="widget-icon"> <i class="fa fa-cog"></i> </span>
      <h2>Update Codebase</h2>
    </header>
    <div>
      <div class="jarviswidget-editbox">
        <input class="form-control" type="text">
      </div>
      <div class="widget-body">
      <p><a class="btn btn-primary icon-action" data-type="updateCodebase" data-code="IKMCP"><i class="fa fa-cogs"></i> Update All Branches</a></p>
        <div class="system-message"></div>

      </div>
    </div>
  </div>
</article>
</div>

</section>
<script type="text/javascript">
   pageSetUp();
</script>