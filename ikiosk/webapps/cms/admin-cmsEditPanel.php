<div class ="floatingWidget custom-scroll">
  <div id="redactorControl" class="cms-widget align-right">
    <button class="btn editContentCancel btn-default"><i class="fa fa-times"></i> Cancel</button>
    <button type="submit" class="btn editContentSave btn-primary" data-form="iKioskCMS-editContent"><i class="fa fa-check"></i> Save</button>
  </div>
  <div id="cmsMode" class="cms-widget">
    <p class="cms-widget-title">Editor Mode</p>
    <a class="btn btn-default mainBtn half cmsMode align-center btn-primary" title="Content" data-mode="content">
      <i class="fa fw fa-file-text-o"></i> Content</a>
    <a class="btn btn-default mainBtn half cmsMode align-center" title="Layout" data-mode="layout">
      <i class="fa fw fa-columns"></i> Layout</a>
      <p><input type="checkbox" class="toggleGrid"> Show layout grid</p>
  </div>
  <div id="cmsModeContent">
    <!-- Resources -->
    <div id ="cmsResource" class="cms-widget">
      <p class="cms-widget-title">Insert CMS Resource</p>
      <a class="btn btn-default cmstooltip mainBtn btn-labeled" title="Image" data-arrow="20" data-cmstooltop="183" data-cmstoolright="245" data-panel="insertImage">
        <span class="btn-label"><i class="fa fw fa-image"></i></span> Photo</a>
      <a class="btn btn-default cmstooltip mainBtn btn-labeled" title="Code Snippet" data-arrow="20" data-cmstooltop="183" data-cmstoolright="122" data-panel="codeSnippet"><span class="btn-label"><i class="fa fw fa-code"></i></span> Snippet</a>
    </div>
    <div id="cms-editElement" class="cms-widget hide-me">
      <p class="cms-widget-title">Edit Element</p>
      <a class="btn btn-default btn-labeled half elementResize"><span class="btn-label"><i class="fa fw fa-arrows-alt"></i></span> Resize</a>
      <a class="btn btn-default btn-labeled half elementMove"><span class="btn-label"><i class="fa fw fa-location-arrow"></i></span> Move</a>
      <a class="btn btn-default btn-labeled half cmstooltip mainBtn cssTrigger"  data-arrow="207" data-cmstooltop="260" data-cmstoolright="245" data-panel="cssStyles"><span class="btn-label"><i class="fa fw fa-css3"></i></span> CSS</a>
      <a class="btn btn-default btn-labeled half elementClone"><span class="btn-label"><i class="fa fw fa-copy"></i></span> Clone</a>
      <a class="btn btn-default btn-labeled half elementDelete"><span class="btn-label"><i class="fa fw fa-trash-o"></i></span> Delete</a>
    </div>
  </div>
  <div id="cmsModeLayout" class="hide-me">
  	<div id="layoutInfo" class="cms-widget">
    	<p class="cms-widget-title">Layout Controls</p>
      <p>Rearrage elements by dragging them into the desired position.</p>
    </div>
  </div>
  <div id="cms-widget-popover">
    <i class="fa fa-times cmstooltip-close"></i>
    <div class="widget-popover-wrapper">
      <div class="widget-popover-title">Insert Element</div>
      <div class="widget-popover-body">Test</div>
      <div class="widget-popover-footer"></div>
    </div>
  </div>
</div>
