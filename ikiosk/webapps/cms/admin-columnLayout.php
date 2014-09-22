<?php

$col2 = '<div class="row"><div class="col-md-6"></div><div class="col-md-6"></div></row>';
$col3 = '<div class="row"><div class="col-md-4"></div><div class="col-md-4"></div><div class="col-md-4"></div>
</row>';
$col4 = '<div class="row"><div class="col-md-3"></div><div class="col-md-3"></div><div class="col-md-3"></div><div class="col-md-3"></div></row>';
$col6 = '<div class="row "><div class="col-md-2"></div><div class="col-md-2"></div><div class="col-md-2"></div><div class="col-md-2"></div><div class="col-md-2"></div></row>';
$col12 = '<div class="row"><div class="col-md-1"></div><div class="col-md-1"></div><div class="col-md-1"></div><div class="col-md-1"></div><div class="col-md-1"></div><div class="row"><div class="col-md-1"></div><div class="col-md-1"></div><div class="col-md-1"></div><div class="col-md-1"></div><div class="col-md-1"></div></row>';
?>

<div class="widget-popover-title">Column Layout</div>
<div class="widget-popover-body">
<div id="codePreview" class="hide-me">
	<p class="snippetTitle"></p>
	<pre class="htmlCode prettyprint custom-scroll">
  </pre>
  <div class="align-right">
   <a class="btn btn-default panelToggle" title="Back to Snippet List" data-open="codeList" data-close="codePreview"><i class="fa fa-reply"></i></a>
   <a class="btn btn-primary btn-labeled insertCode" title="Insert Code" data-code="">
   <span class="btn-label"><i class="fa fw fa-code"></i></span> Insert Code</a>
   </div>
</div>
<div id="codeList">
<p>Select number of columns.</p>
	<a class="btn btn-default codePreview panelToggle" data-htmlcode="<?php echo htmlentities($col2); ?>" data-code="<?php echo htmlentities($col2); ?>" data-title="2 Columns" data-close="codeList" data-open="codePreview">2</a>
  
	<a class="btn btn-default codePreview panelToggle" data-htmlcode="<?php echo htmlentities($col3); ?>" data-code="<?php echo htmlentities($col3); ?>" data-title="3 Columns" data-close="codeList" data-open="codePreview">3</a>
  
	<a class="btn btn-default codePreview panelToggle" data-htmlcode="<?php echo htmlentities($col4); ?>" data-code="<?php echo htmlentities($col4); ?>" data-title="4 Columns" data-close="codeList" data-open="codePreview">4</a>
  
	<a class="btn btn-default codePreview panelToggle" data-htmlcode="<?php echo htmlentities($col6); ?>" data-code="<?php echo htmlentities($col6); ?>" data-title="6 Columns" data-close="codeList" data-open="codePreview">6</a>
  
	<a class="btn btn-default codePreview panelToggle" data-htmlcode="<?php echo htmlentities($col12); ?>" data-code="<?php echo htmlentities($col12); ?>" data-title="12 Columns" data-close="codeList" data-open="codePreview">12</a>
  </div>
</div>