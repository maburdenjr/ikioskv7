<?php
/* iKiosk 7.0 Tiger */
$PAGE['application_code'] = "SYS";
require('../../includes/core/ikiosk.php');
?>

<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title"><i class="fa fa-cogs fa-fw "></i> iKiosk MCP</h1>
  </div>
</div>
<section id="widget-grid">
  <div class="row">
    <article class="col-sm-12 col-md-6 col-lg-6">
    <div class="jarviswidget" id="updateCodebase" data-widget-editbutton="false" data-widget-deletebutton="false">
    <header> <span class="widget-icon"> <i class="fa fa-cog"></i> </span>
      <h2>Deploy Codebase</h2>
      <div class="widget-toolbar">
      	<a class="btn btn-primary icon-action" data-type="updateCodebase" data-code="IKMCP">Deploy to Production</a>
      </div>

    </header>
    <div>
      <div class="jarviswidget-editbox">
        <input class="form-control" type="text">
      </div>
      <div class="widget-body">
      <p>This codebase utility will take a snapshot of the IntelliKiosk QA branch (/apps/intellikiosk/v7dev) and deploy it to the IntelliKiosk production branch (/apps/intellikiosk/v7).

</p>
        <div class="system-message"></div>

      </div>
    </div>
  </div>
    </article>
    <article class="col-sm-12 col-md-12 col-lg-12">
    
    </article>
  </div>
</section>
<script type="text/javascript">
		pageSetUp();
</script> 