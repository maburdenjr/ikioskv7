<?php
$content = '
<!--=== Content Part ===-->
<div class="container content">
</div>
<!-- End Content Part -->
';
?>
<!-- Grid Layout -->

<div class="acc-section-trigger"><i class="fa fa-fw fa-cubes"></i> General</div>
<div class="acc-section-content custom-scroll">
  <div class="layoutItem ui-element" data-code="<?php echo htmlentities($content); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/default.jpg" /></div>
    <div class="layoutTitle">Empty Content Area</div>
  </div>
</div>
<?php
$col2 = '<div class="row"><div class="col-md-6"></div><div class="col-md-6"></div></row>';
$col3 = '<div class="row"><div class="col-md-4"></div><div class="col-md-4"></div><div class="col-md-4"></div>
</row>';
$col4 = '<div class="row"><div class="col-md-3"></div><div class="col-md-3"></div><div class="col-md-3"></div><div class="col-md-3"></div></row>';
?>

<!-- Grid Layout -->
<div class="acc-section-trigger"><i class="fa fa-fw fa-columns"></i> Columns</div>
<div class="acc-section-content custom-scroll">
  <div class="layoutItem ui-element" data-code="<?php echo htmlentities($col2); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/default.jpg" /></div>
    <div class="layoutTitle">2 Columns</div>
  </div>
  <div class="layoutItem ui-element" data-code="<?php echo htmlentities($col3); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/default.jpg" /></div>
    <div class="layoutTitle">3 Columns</div>
  </div>
  <div class="layoutItem ui-element" data-code="<?php echo htmlentities($col4); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/default.jpg" /></div>
    <div class="layoutTitle">4 Columns</div>
  </div>
</div>


