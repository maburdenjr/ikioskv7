<!-- Editor Display -->
<div id = "iKioskCMSeditor" class="ikiosk-cms-editor">
<form id ="iKioskCMS-editContent" method="post">
	<div class="form-response"></div>
  <section>
  <textarea name="content" class="redactor-editor"><?php echo $row_getPage['content']; ?></textarea>
  </section>
  <input type="hidden" name="page_version_id" value="<?php echo $row_getPage['page_version_id']; ?>" />
  <input type="hidden" name="iKioskForm" value="Yes" />
  <input type="hidden" name="formID" value="iKioskCMS-editContent">
  <input type="hidden" name="iKioskForm" value="Yes" />
  <input type="hidden" name="appCode" value="CMS" />
 </form>
 
   <div id="layoutWidget" class="cms-widget">
    <p class="cms-widget-title">Layout Elements<span style="font-size: 10px; line-height:100%; display:block; margin-top:5px;">Add elements to your page by dragging them onto the canvas.</span></p>
    
    <?php include($SYSTEM['ikiosk_filesystem_root']."/ikiosk/webapps/cms/admin-layoutElements.php");
  ?>
  </div>
</div>