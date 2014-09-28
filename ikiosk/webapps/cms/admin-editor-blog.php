<!-- Editor Display -->

<div id = "iKioskCMSeditor">
  <article id="<?php echo $row_getPage['article_id']; ?>">
    <header>
      <h1><?php echo $row_getPage['title']; ?></h1>
      <p>Posted on <?php echo $timePosted." by ".$author; ?></p>
    </header>
    <section>
      <form id ="iKioskCMS-editArticle" method="post" class="ikiosk-cms-editor">
        <div class="form-response"></div>
        <section>
          <textarea name="content" class="redactor-editor"><?php echo $row_getPage['content']; ?></textarea>
          <div id="layoutWidget" class="cms-widget">
            <p class="cms-widget-title">Layout Elements<span style="font-size: 11px; line-height:100%; display:block; margin-top:5px; color: #CCC;">Add elements to your page by dragging them onto the canvas.</span></p>
            <?php include($SYSTEM['ikiosk_filesystem_root']."/ikiosk/webapps/cms/admin-layoutElements.php");
  ?>
          </div>
        </section>
        <input type="hidden" name="article_version_id" value="<?php echo $row_getPage['article_version_id']; ?>" />
        <input type="hidden" name="iKioskForm" value="Yes" />
        <input type="hidden" name="formID" value="iKioskCMS-editArticle">
        <input type="hidden" name="iKioskForm" value="Yes" />
        <input type="hidden" name="appCode" value="CMS" />
      </form>
    </section>
  </article>
</div>
