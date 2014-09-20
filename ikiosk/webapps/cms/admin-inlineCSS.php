<div class="widget-popover-title">CSS Style Editor</div>
<div class="widget-popover-body">
  <ul id="styleMenu" class="nav nav-tabs">
    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Style Category <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#s1" data-toggle="tab">Font</a></li>
        <li><a href="#s2" data-toggle="tab">Size & Position</a></li>
        <li><a href="#s4" data-toggle="tab">Background</a></li>
        <li><a href="#s5" data-toggle="tab">Margins & Padding</a></li>
        <li><a href="#s7" data-toggle="tab">Borders</a></li>
        <li><a href="#s9" data-toggle="tab">List</a></li>
        <li><a href="#s10" data-toggle="tab">Other</a></li>
        <li><a href="#s11" data-toggle="tab">Attributes</a></li>
      </ul>
    </li>
  </ul>
  <form class="smart-form">
  <div id="styleCategories" class="tab-content custom-scroll">
    <div id="s1" class="tab-pane fade in active">
      <p class="widget-label">Font Properties</p>
      <div class="row">
        <div class="col col-6">
          <label class="label">Font Family</label>
          <label class="select">
            <select name="font-family" class="cms-style-update text-input" rel="font-family" id="font-family">
              <option value="" selected="selected"></option>
              <option value="Arial, Helvetica, sans-serif">Arial, Helvetica, sans-serif </option>
              <option value="Arial Black, Gadget, sans-serif">Arial Black, Gadget, sans-serif </option>
              <option value="'Comic Sans MS', cursive, sans-serif">'Comic Sans MS', cursive, sans-serif </option>
              <option value="'Courier New', Courier, monospace">'Courier New', Courier, monospace </option>
              <option value="Impact, Charcoal, sans-serif">Impact, Charcoal, sans-serif </option>
              <option value="'Lucida Console', Monaco, monospace">'Lucida Console', Monaco, monospace </option>
              <option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif">'Lucida Sans Unicode', 'Lucida Grande', sans-serif </option>
              <option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif">'Palatino Linotype', 'Book Antiqua', Palatino, serif</option>
              <option value="Tahoma, Geneva, sans-serif">Tahoma, Geneva, sans-serif </option>
              <option value="'Trebuchet MS', Helvetica, sans-serif">'Trebuchet MS', Helvetica, sans-serif </option>
              <option value="'Times New Roman', Times, serif">'Times New Roman', Times, serif</option>
              <option value="Verdana, Geneva, sans-serif">Verdana, Geneva, sans-serif </option>
            </select>
            <i></i> </label>
        </div>
        <div class="col col-6">
        <label class="label">Color</label>
        <label class="input"><input name="color" type="text" class="cms-style-update text-input colorSelect cms-color-select" id="color" value="<?php echo $row_getRecord['color']; ?>" rel="color" />
        
        </label>
        </div>
      </div>
      <div class="row">
        <div class="col col-6">
        <label class="label">Font Size</label>
        <label class="input"><input name="font-size" type="text" class="cms-style-update text-input cms-size" id="font-size" value="<?php echo $row_getRecord['font-size']; ?>" rel="font-size" /></label>
        </div>
        <div class="col col-6">
        	<label class="label">Line Height</label>
          <label class="input"><input name="line-height" type="text" class="cms-style-update text-input cms-size" id="line-height" value="<?php echo $row_getRecord['line-height']; ?>" rel="line-height" /></label>

        </div>
      </div>
      <div class="row">
       	<div class="col col-6">
        	<label class="label">Text Decoration</label>
          <label class="select"><select name="text-decoration" class="cms-style-update text-input" rel="text-decoration" id="text-decoration">
                      <option value="" <?php if (!(strcmp("", $row_getRecord['text-decoration']))) {echo "selected=\"selected\"";} ?>></option>
                      <option value="none" <?php if (!(strcmp("none", $row_getRecord['text-decoration']))) {echo "selected=\"selected\"";} ?>>none</option>
    <option value="underline" <?php if (!(strcmp("underline", $row_getRecord['text-decoration']))) {echo "selected=\"selected\"";} ?>>underline</option>
                      <option value="overline" <?php if (!(strcmp("overline", $row_getRecord['text-decoration']))) {echo "selected=\"selected\"";} ?>>overline</option>
                      <option value="line-through" <?php if (!(strcmp("line-through", $row_getRecord['text-decoration']))) {echo "selected=\"selected\"";} ?>>line-through</option>
                      <option value="blink" <?php if (!(strcmp("blink", $row_getRecord['text-decoration']))) {echo "selected=\"selected\"";} ?>>blink</option>
                    
                  </select></label>

        </div>
        <div class="col col-6">
        	<label class="label">Font Weight</label>
          <label class="input"><input name="font-weight" type="text" class="cms-style-update text-input cms-size" id="font-weight" value="<?php echo $row_getRecord['font-weight']; ?>" rel="font-weight" /></label>

        </div> 
      </div>
      <div class="row">
       	<div class="col col-6">
        	<label class="label">Font Variant</label>
          <label class="select"><select name="font-variant" class="cms-style-update text-input" rel="font-variant" id="font-variant">
                      <option value="" <?php if (!(strcmp("", $row_getRecord['font-variant']))) {echo "selected=\"selected\"";} ?>></option>
                      <option value="normal" <?php if (!(strcmp("normal", $row_getRecord['font-variant']))) {echo "selected=\"selected\"";} ?>>normal</option>
    <option value="small-caps" <?php if (!(strcmp("small-caps", $row_getRecord['font-variant']))) {echo "selected=\"selected\"";} ?>>small-caps</option>
                  </select><i></i></label>

        </div>
        <div class="col col-6">
        	<label class="label">Text Transform</label>
          <label class="select"><select name="text-transform" class="cms-style-update text-input" rel="text-transform" id="text-transform">
                      <option value="" <?php if (!(strcmp("", $row_getRecord['text-transform']))) {echo "selected=\"selected\"";} ?>></option>
                      <option value="capitalize" <?php if (!(strcmp("capitalize", $row_getRecord['text-transform']))) {echo "selected=\"selected\"";} ?>>capitalize</option>
                      <option value="uppercase" <?php if (!(strcmp("uppercase", $row_getRecord['text-transform']))) {echo "selected=\"selected\"";} ?>>uppercase</option>
                      <option value="lowercase" <?php if (!(strcmp("lowercase", $row_getRecord['text-transform']))) {echo "selected=\"selected\"";} ?>>lowercase</option>
                      <option value="none" <?php if (!(strcmp("none", $row_getRecord['text-transform']))) {echo "selected=\"selected\"";} ?>>none</option>
                    </select><i></i></label>

        </div> 
      </div>
    </div>
    <div id="s2" class="tab-pane fade in ">Hi </div>
    <div id="s4" class="tab-pane fade in ">Hi </div>
    <div id="s5" class="tab-pane fade in ">Hi </div>
    <div id="s7" class="tab-pane fade in ">Hi </div>
    <div id="s9" class="tab-pane fade in ">Hi </div>
    <div id="s10" class="tab-pane fade in ">Hi </div>
    <div id="s11" class="tab-pane fade in ">Hi </div>
  </div>
  </form>
</div>
