<!-- Editor Display -->
<div id = "iKioskCMSeditor" class="ikiosk-cms-editor">
<form id ="iKioskCMS-editContent" class="smart-form" method="post">
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
</div>