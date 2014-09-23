<!-- Editor Display -->
<div id = "iKioskCMSeditor" class="ikiosk-cms-editor">
<article id="<?php echo $row_getPage['article_id']; ?>">
  <header>
    <h1><?php echo $row_getPage['title']; ?></h1>
    <p>Posted on <?php echo $timePosted." by ".$author; ?></p>
  </header>
  <section>
    <form id ="iKioskCMS-editArticle" method="post">
      <div class="form-response"></div>
      <section>
        <textarea name="content" class="redactor-editor"><?php echo $row_getPage['content']; ?></textarea>
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