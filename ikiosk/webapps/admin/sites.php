<?php
   /* iKiosk 7.0 Tiger */
   
   $PAGE['application_code'] = "SYS";
   require('../../includes/core/ikiosk.php');
   
   //Action Controller
   switch($_GET['action']) {
       case "edit":
           $panelAction = "edit";
           break;
       case "create":
           $panelAction = "create";
           break;
       default:
           $panelAction = "list";
   }
   
   if ($panelAction == "list") { // List View - Default 
   
   mysql_select_db($database_ikiosk, $ikiosk);
   $query_listView = "SELECT * FROM sys_sites WHERE deleted = '0' ";
   $listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
   $row_listView = mysql_fetch_assoc($listView);
   $totalRows_listView = mysql_num_rows($listView);
   ?>

<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title"><i class="fa fa-sitemap fa-fw "></i> Sites</h1>
  </div>
</div>
<section id="widget-grid">
<!-- Begin Create Record -->
<div class="modal fade" id="createSite">
  <div class="modal-dialog">
    <div class="modal-content">
    <form id = "create-SysSites" class="smart-form" method="post">
      <div class="modal-header">
        <h4 class="modal-title">Create New Site</h4>
      </div>
      <div class="modal-body">
        <div class="form-response"></div>
        <section>
          <label class="label">Site Name</label>
          <label class="input">
            <input type="text" name="site_name" value="<?php echo $row_getRecord['site_name']; ?>">
          </label>
        </section>
        <section>
          <label class="label">Domain Name / URL</label>
          <div class="note">This is the URL or domain name for this site (i.e. http://www.example.com). Do not include the trailing slash.</div>
          <label class="input">
          <label class="input">
            <input type="text" name="site_url" value="<?php echo $row_getRecord['site_url']; ?>">
          </label>
        </section>
        <section>
          <label class="label">Shortname</label>
          <div class="note">The shortname is used to identify your site within the IntelliKiosk system.</div>
          <label class="input">
          <label class="input">
            <input type="text" name="site_root" value="<?php echo $row_getRecord['site_root']; ?>">
          </label>
        </section>
        <section>
          <label class="label">Force SSL?</label>
          <label class="select">
            <select name="force_ssl">
              <option value="No" <?php if (!(strcmp("No", $row_getRecord['force_ssl']))) {echo "selected=\"selected\"";} ?>>No</option>
              <option value="Yes" <?php if (!(strcmp("Yes", $row_getRecord['force_ssl']))) {echo "selected=\"selected\"";} ?>>Yes</option>
            </select>
            <i></i> </label>
        </section>
        <section>
          <label class="label">Default Timezone</label>
          <label class="select">
            <select name="site_timezone">
              <?php selectTimeZone($_POST['site_timezone']); ?>
            </select>
            <i></i> </label>
        </section>
        <input type="hidden" name="formID" value="create-SysSites">
        <input type="hidden" name="iKioskForm" value="Yes">
        <input type="hidden" name="appCode" value="<?php echo $APPLICATION['application_code']; ?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
        <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="create-SysSites"> <i class="fa fa-check"></i> Save </button>
      </div>
      </div>
    </form>
  </div>
</div>
<div id="createCtn-SysSites" class="row hidden-panel">
  <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="jarviswidget" id="add-SysSites" data-widget-editbutton="false" data-widget-deletebutton="false">
      <header> <span class="widget-icon"> <i class="fa fa-plus"></i> </span>
        <h2>Create New Site</h2>
      </header>
      <div>
        <div class="jarviswidget-editbox">
          <input class="form-control" type="text">
        </div>
        <div class="widget-body no-padding"> </div>
      </div>
    </div>
  </article>
</div>
<!-- End Create Record --> 
<!-- Start List View -->
<div id="listCtn-SysSites" class="row">
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="system-message"></div>
  <div class="jarviswidget" id="list-SysSites" data-widget-editbutton="false" data-widget-deletebutton="false">
    <header> <span class="widget-icon"> <i class="fa fa-table"></i> </span>
      <h2>Site List</h2>
    </header>
    <div>
      <div class="jarviswidget-editbox">
        <input class="form-control" type="text">
      </div>
      <div class="widget-body no-padding">
        <table id="dt-SysSites" class="table table-striped table-bordered table-hover" width="100%">
          <thead>
            <tr>
              <th>Site Name</th>
              <th>Site URL</th>
              <th>Site Root</th>
              <th>Force SSL</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php do { 	v7InitSite($row_listView['site_id']); ?>
              <tr class="<?php echo $row_listView['site_id']; ?>">
                <td><a href="webapps/admin/sites.php?action=edit&recordID=<?php echo $row_listView['site_id']; ?>" class="dynamicModal" data-toggle="modal" data-target="#dynamicModal"><?php echo $row_listView['site_name']; ?></a></td>
                <td><a href="<?php echo $row_listView['site_url']; ?>" target="_blank"><?php echo $row_listView['site_url']; ?></a></td>
                <td><?php echo $row_listView['site_root']; ?></td>
                <td><?php echo $row_listView['force_ssl']; ?></td>
                <td><?php echo $row_listView['site_status']; ?></td>
                <td class="icon"><a class="delete-record" data-table="sys_sites" data-record="<?php echo $row_listView['site_id']; ?>" data-code="<?php echo $APPLICATION['application_code']; ?>" data-field="site_id"><i class="fa fa-trash-o"></i></a></td>
              </tr>
              <?php } while ($row_listView = mysql_fetch_assoc($listView)); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</article>
<div>
<!--  End List View -->
</section>
<script type="text/javascript">
   var listView = $('#dt-SysSites').dataTable();
   $('.dataTables_length').before('<button class="btn btn-primary btn-add" data-toggle="modal" data-target="#createSite"><i class="fa fa-plus"></i> Create <span class="hidden-mobile"> Site</span></button>');
</script> 
<script type="text/javascript">
   runAllForms();
   
   $(function() {
       // Validation
       $("#create-SysSites").validate({
       
           rules : {
                		site_name : {
			required : true,
			minlength: 5
		},
		site_root : {
			required : true,
			remote: "includes/core/formProcessor.php?appCode=SYS&ajaxAction=siteRootCheck",
			minlength: 5
		},
		site_url : {
			required : true,
			url: true
		}

            },
						// Messages for form validation
			messages : {
				site_root : {
					remote : 'A site with this shortname already exists'
				},
				site_name : {
					required : 'Please enter a name for this site'
				},
				site_url : {
					required : 'Please enter the domain name or URL for this site'
				}
			},
           
           // Do not change code below
           errorPlacement : function(error, element) {
               error.insertAfter(element.parent());
           },
           //Handler
           submitHandler: function(form) {
               var targetForm = $(this.currentForm).attr("id");
               submitAjaxForm(targetForm);
           }
       });
   });
</script>
<?php } ?>
<?php 
   if ($panelAction == "edit") { // Edit View 
   
   //Get Current Record
   mysql_select_db($database_ikiosk, $ikiosk);
   $query_getRecord = "SELECT * FROM sys_sites WHERE deleted = '0' AND site_id = '".$_GET['recordID']."' ";
   $getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
   $row_getRecord = mysql_fetch_assoc($getRecord);
   $totalRows_getRecord = mysql_num_rows($getRecord);
   
   ?>
<form id= "edit-SysSites" class="smart-form" method="post">
  <div class="modal-header">
    <h4 class="modal-title"><?php echo $row_getRecord['site_name']; ?></h4>
  </div>
  <ul id="editCtn-tabs" class="nav nav-tabs">
    <li class="active"> <a data-toggle="tab" href="#general"> General</a> </li>
    <li> <a data-toggle="tab" href="#images"> Images </a> </li>
    <li class="dropdown">
    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"> Social Media <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li> <a data-toggle="tab" href="#facebook">Facebook</a> </li>
      <li> <a data-toggle="tab" href="#instagram">Instagram</a> </li>
      <li> <a data-toggle="tab" href="#twitter">Twitter</a> </li>
      <li> <a data-toggle="tab" href="#youtube">YouTube</a> </li>
      <li> <a data-toggle="tab" href="#flickr">Flickr</a> </li>
      </li>
    </ul>
    </li>
    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"> Google Apps <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li> <a data-toggle="tab" href="#g-analytics">Google Analytics</a> </li>
        <li> <a data-toggle="tab" href="#g-apps">Google Apps</a> </li>
        <li> <a data-toggle="tab" href="#g-api">Google API</a> </li>
      </ul>
    </li>
  </ul>
  <fieldset>
    <div class="form-response"></div>
    <div class="tab-content">
      <div class="tab-pane fade in active" id="general">
        <div class="row">
          <section class="col col-6">
            <label class="label">Site Name</label>
            <label class="input">
              <input type="text" name="site_name" value="<?php echo $row_getRecord['site_name']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Site URL</label>
            <label class="input">
              <input type="text" name="site_url" value="<?php echo $row_getRecord['site_url']; ?>">
            </label>
          </section>
        </div>
        <div class="row">
          <section class="col col-6">
            <label class="label">Public Home Page</label>
            <label class="input">
              <input type="text" name="public_home" value="<?php echo $row_getRecord['public_home']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">iKiosk Home Page</label>
            <label class="input">
              <input type="text" name="ikiosk_home" value="<?php echo $row_getRecord['ikiosk_home']; ?>">
            </label>
          </section>
        </div>
        <div class="row">
          <section class="col col-6">
            <label class="label">Default Timezone</label>
            <label class="select">
              <select name="site_timezone">
                <?php selectTimeZone($row_getRecord['site_timezone']); ?>
              </select>
              <i></i> </label>
          </section>
          <section class="col col-3">
            <label class="label">Date Format</label>
            <label class="input">
              <input type="text" name="site_dateformat" value="<?php echo $row_getRecord['site_dateformat']; ?>">
            </label>
          </section>
          <section class="col col-3">
            <label class="label">Force SSL</label>
            <label class="select">
              <select name="force_ssl">
                <option value="No" <?php if (!(strcmp("No", $row_getRecord['force_ssl']))) {echo "selected=\"selected\"";} ?>>No</option>
                <option value="Yes" <?php if (!(strcmp("Yes", $row_getRecord['force_ssl']))) {echo "selected=\"selected\"";} ?>>Yes</option>
              </select>
              <i></i> </label>
          </section>
        </div>
        <div class="row">
          <section class="col col-6">
            <label class="label">Support Email</label>
            <label class="input">
              <input type="text" name="support_email" value="<?php echo $row_getRecord['support_email']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Status</label>
            <label class="select">
              <select name="site_status">
                <option value="Active" <?php if (!(strcmp("Active", $row_getRecord['site_status']))) {echo "selected=\"selected\"";} ?>>Active</option>
                <option value="Inactive" <?php if (!(strcmp("Inactive", $row_getRecord['site_status']))) {echo "selected=\"selected\"";} ?>>Inactive</option>
              </select>
              <i></i> </label>
          </section>
        </div>
      </div>
      <div class="tab-pane fade in" id="images">
        <div class="row">
          <section class="col col-6">
            <label class="label">Mini-Thumbnail Width</label>
            <label class="input">
              <input type="text" name="image_mini_thumbnailX" value="<?php echo $row_getRecord['image_mini_thumbnailX']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Mini Thumbnail Height</label>
            <label class="input">
              <input type="text" name="image_mini_thumbnailY" value="<?php echo $row_getRecord['image_mini_thumbnailY']; ?>">
            </label>
          </section>
        </div>
        <div class="row">
          <section class="col col-6">
            <label class="label">Thumbnail Width</label>
            <label class="input">
              <input type="text" name="image_thumbnailX" value="<?php echo $row_getRecord['image_thumbnailX']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Thumbnail Height</label>
            <label class="input">
              <input type="text" name="image_thumbnailY" value="<?php echo $row_getRecord['image_thumbnailY']; ?>">
            </label>
          </section>
        </div>
        <div class="row">
          <section class="col col-6">
            <label class="label">Max Width for Inline Images</label>
            <label class="input">
              <input type="text" name="image_inline" value="<?php echo $row_getRecord['image_inline']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Max Width for Resized Images</label>
            <label class="input">
              <input type="text" name="image_resized" value="<?php echo $row_getRecord['image_resized']; ?>">
            </label>
          </section>
        </div>
      </div>
      <div class="tab-pane fade in" id="facebook">
        <div class="row">
          <section class="col col-6">
            <label class="label">Facebook App ID</label>
            <label class="input">
              <input type="text" name="facebook_app_id" value="<?php echo $row_getRecord['facebook_app_id']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Facebook App Url</label>
            <label class="input">
              <input type="text" name="facebook_app_url" value="<?php echo $row_getRecord['facebook_app_url']; ?>">
            </label>
          </section>
        </div>
        <div class="row">
          <section class="col col-6">
            <label class="label">Facebook Secret</label>
            <label class="input">
              <input type="text" name="facebook_secret" value="<?php echo $row_getRecord['facebook_secret']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Facebook Key</label>
            <label class="input">
              <input type="text" name="facebook_key" value="<?php echo $row_getRecord['facebook_key']; ?>">
            </label>
          </section>
        </div>
        <div class="row">
          <section class="col col-12">
            <label class="label">Facebook Permissions</label>
            <div class="note">Enter a comma-separated list of permissions to be requested during the Facebook authentication process. (ie. 'email, publish_stream')</div>
            <label class="textarea">
              <textarea name="facebook_permissions"><?php echo $row_getRecord['facebook_permissions']; ?></textarea>
            </label>
          </section>
        </div>
      </div>
      <div class="tab-pane fade in" id="instagram">
        <div class="row">
          <section class="col col-6">
            <label class="label">Instagram Client ID</label>
            <label class="input">
              <input type="text" name="instagram_key" value="<?php echo $row_getRecord['instagram_key']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Instagram Secret</label>
            <label class="input">
              <input type="text" name="instagram_secret" value="<?php echo $row_getRecord['instagram_secret']; ?>">
            </label>
          </section>
        </div>
      </div>
      <div class="tab-pane fade in" id="twitter">
        <div class="row">
          <section class="col col-6">
            <label class="label">Twitter API Key</label>
            <label class="input">
              <input type="text" name="twitter_api" value="<?php echo $row_getRecord['twitter_api']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Twitter Consumer Key</label>
            <label class="input">
              <input type="text" name="twitter_consumer_key" value="<?php echo $row_getRecord['twitter_consumer_key']; ?>">
            </label>
          </section>
        </div>
        <div class="row">
          <section class="col col-12">
            <label class="label">Twitter Consumer Secret</label>
            <label class="input">
              <input type="text" name="twitter_consumer_secret" value="<?php echo $row_getRecord['twitter_consumer_secret']; ?>">
            </label>
          </section>
        </div>
      </div>
      <div class="tab-pane fade in" id="photobucket">
        <div class="row">
          <section class="col col-6">
            <label class="label">Photobucket Key</label>
            <label class="input">
              <input type="text" name="photobucket_key" value="<?php echo $row_getRecord['photobucket_key']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Photobucket Secret</label>
            <label class="input">
              <input type="text" name="photobucket_secret" value="<?php echo $row_getRecord['photobucket_secret']; ?>">
            </label>
          </section>
        </div>
      </div>
      <div class="tab-pane fade in" id="youtube">
        <div class="row">
          <section class="col col-6">
            <label class="label">Youtube App Url</label>
            <label class="input">
              <input type="text" name="youtube_app_url" value="<?php echo $row_getRecord['youtube_app_url']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Youtube Client ID</label>
            <label class="input">
              <input type="text" name="youtube_client_id" value="<?php echo $row_getRecord['youtube_client_id']; ?>">
            </label>
          </section>
        </div>
        <div class="row">
          <section class="col col-12">
            <label class="label">Youtube Developer Key</label>
            <label class="input">
              <input type="text" name="youtube_developer_key" value="<?php echo $row_getRecord['youtube_developer_key']; ?>">
            </label>
          </section>
        </div>
      </div>
      <div class="tab-pane fade in" id="flickr">
        <div class="row">
          <section class="col col-6">
            <label class="label">Flickr API Key</label>
            <label class="input">
              <input type="text" name="flickr_api_key" value="<?php echo $row_getRecord['flickr_api_key']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Flickr API Secret</label>
            <label class="input">
              <input type="text" name="flickr_api_secret" value="<?php echo $row_getRecord['flickr_api_secret']; ?>">
            </label>
          </section>
        </div>
        <div class="row">
          <section class="col col-12">
            <label class="label">Flickr API Permissions</label>
            <label class="textarea">
              <textarea name="flickr_api_permissions"><?php echo $row_getRecord['flickr_api_permissions']; ?></textarea>
            </label>
          </section>
        </div>
      </div>
      <div class="tab-pane fade in" id="g-apps">
        <div class="row">
          <section class="col col-6">
            <label class="label">Google Site Verification</label>
            <label class="input">
              <input type="text" name="google_site_verification" value="<?php echo $row_getRecord['google_site_verification']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Google Consumer Key</label>
            <label class="input">
              <input type="text" name="google_consumer_key" value="<?php echo $row_getRecord['google_consumer_key']; ?>">
            </label>
          </section>
        </div>
        <div class="row">
          <section class="col col-12">
            <label class="label">Google Consumer Secret</label>
            <label class="input">
              <input type="text" name="google_consumer_secret" value="<?php echo $row_getRecord['google_consumer_secret']; ?>">
            </label>
          </section>
        </div>
      </div>
      <div class="tab-pane fade in" id="g-api">
        <div class="row">
          <section class="col col-6">
            <label class="label">Google Api Client Id</label>
            <label class="input">
              <input type="text" name="google_api_client_id" value="<?php echo $row_getRecord['google_api_client_id']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Google Api Client Secret</label>
            <label class="input">
              <input type="text" name="google_api_client_secret" value="<?php echo $row_getRecord['google_api_client_secret']; ?>">
            </label>
          </section>
        </div>
        <div class="row">
          <section class="col col-6">
            <label class="label">Google Api Redirect Url</label>
            <label class="input">
              <input type="text" name="google_api_redirect_url" value="<?php echo $row_getRecord['google_api_redirect_url']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Google Api Key</label>
            <label class="input">
              <input type="text" name="google_api_key" value="<?php echo $row_getRecord['google_api_key']; ?>">
            </label>
          </section>
        </div>
      </div>
      <div class="tab-pane fade in" id="g-analytics">
        <div class="row">
          <section class="col col-6">
            <label class="label">Analytics Account ID</label>
            <label class="input">
              <input type="text" name="google_analytics_key" value="<?php echo $row_getRecord['google_analytics_key']; ?>">
            </label>
          </section>
          <section class="col col-6">
            <label class="label">Analytics Web Property ID</label>
            <label class="input">
              <input type="text" name="google_analytics_profile" value="<?php echo $row_getRecord['google_analytics_profile']; ?>">
            </label>
          </section>
        </div>
      </div>
    </div>
  </fieldset>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
    <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="edit-SysSites"> <i class="fa fa-check"></i> Save </button>
    <input type="hidden" name="site_id" value="<?php echo $row_getRecord['site_id']; ?>" />
    <input type="hidden" name="formID" value="edit-SysSites">
    <input type="hidden" name="iKioskForm" value="Yes" />
    <input type="hidden" name="appCode" value="<?php echo $APPLICATION['application_code']; ?>" />
  </div>
</form>
<script type="text/javascript">
   runAllForms();
   
   $(function() {
       // Validation
       $("#edit-SysSites").validate({
            rules : {
                		site_name : {
			required : true
		},
		public_home : {
			required : true
		},
		ikiosk_home : {
			required : true
		},
		site_url : {
			required : true
		},
		site_dateformat: {
					required : true
		},
		image_mini_thumbnailX: {
					required : true,
					number: true
		},
		image_mini_thumbnailY: {
					required : true,
					number: true
		},
		image_thumbnailX: {
					required : true,
					number: true
		},
		image_thumbnailY: {
					required : true,
					number: true
		},
		inline_image: {
					required : true,
					number: true
		},
		image_resized: {
					required : true,
					number: true
		},

            },
           
           // Do not change code below
           errorPlacement : function(error, element) {
               error.insertAfter(element.parent());
           },
           //Handler
           submitHandler: function(form) {
               var targetForm = $(this.currentForm).attr("id");
               submitAjaxForm(targetForm);
           }
       });
   });
</script>
<?php } ?>
<script type="text/javascript">
   pageSetUp();
	

</script>