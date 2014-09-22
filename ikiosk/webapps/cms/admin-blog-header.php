<header id="header">
  <div id="logo-group" class="hidden-mobile"> <span><?php echo $SITE['site_name']; ?></span> </div>
  <div class="pull-left">
  <?php if ($blogModule != "index") { ?>
      <!-- Versions -->
      <div id="blogVersions" class="btn-header transparent pull-right"> <span> <a href="/cms/ajaxHandler.php?ajaxAction=blogVersions&recordID=<?php echo $row_getPage['article_id']; ?>&appCode=CMS" title="Versions" class="dynamicModal" rel="tooltip" data-placement="bottom"><i class="fa fa-code-fork"></i></a> </span> </div>
      <!-- Edit Page Properties -->
      <div id="editBlogProperties" class="btn-header transparent pull-right"> <span> <a href="/cms/ajaxHandler.php?ajaxAction=editBlogProperties&recordID=<?php echo $row_getPage['article_version_id']; ?>&appCode=CMS" title="Edit Article Properties" class="dynamicModal" rel="tooltip" data-placement="bottom"><i class="fa fa-wrench"></i></a> </span> </div>
      <!-- Edit Page -->
      <div id="editBlog" class="btn-header transparent pull-right"> <span> <a href="" title="Edit Article Content"  rel="tooltip" data-placement="bottom"><i class="fa fa-edit"></i></a> </span> </div>
  <?php } ?>    

  </div>
  <!-- pulled right: nav area -->
  <div class="pull-right"> 
  <?php if ($SYSTEM['debug'] == "Yes") { ?>
    <div id="debug" class="btn-header transparent pull-right"> <span> <a title="Debug Console" data-toggle="modal" data-target="#systemDebug" rel="tooltip" data-placement="bottom" data-original-title="Debug Console"><i class="fa fa-cogs"></i></a> </span> </div>
    <?php } ?>
            
    <!-- logout button -->
    <div id="logout" class="btn-header transparent pull-right"> <span> <a href="/cms/logout.php" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser" rel="tooltip" data-placement="bottom" data-original-title="Logout"><i class="fa fa-sign-out"></i></a> </span> </div>
    <!-- end logout button --> 
    
    <!-- fullscreen button -->
    <div id="fullscreen" class="btn-header transparent pull-right"> <span> <a href="javascript:void(0);" title="Full Screen" data-action="launchFullscreen" rel="tooltip" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-arrows-alt"></i></a> </span> </div>
    <!-- end fullscreen button -->
    <div id="cmsAdmin" class="btn-header transparent pull-right"><span><a href="/cms/ajaxHandler.php?ajaxAction=cmsAdmin&appCode=CMS" class="dynamicModal" title="CMS Admin" rel="tooltip" data-placement="bottom"><i class="fa fa-cog"></i></a> </span> </div>
    
    <!-- New Page -->
      <div id="createPage" class="btn-header transparent pull-right"> <span> <a href="/cms/ajaxHandler.php?ajaxAction=createBlog&appCode=CMS" title="Create New Post" class="dynamicModal" rel="tooltip" data-placement="bottom"><i class="fa fa-plus"></i></a> </span> </div>
    
  </div>
  <!-- end pulled right: nav area --> 
</header>
