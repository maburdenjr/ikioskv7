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
        <p class="widget-label">Font</p>
        <div class="row">
          <div class="col col-6">
            <label class="label">Font Family</label>
            <label class="input">
               <input name="font-family" type="text" class="cms-style-update text-input" id="line-height" value="<?php echo $row_getRecord['line-height']; ?>" rel="font-family" /></label>
          </div>
          <div class="col col-6">
            <label class="label">Color</label>
            <label class="input">
              <input name="color" type="text" class="cms-style-update text-input colorSelect cms-color-select" id="color" value="<?php echo $row_getRecord['color']; ?>" rel="color" />
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col col-6">
            <label class="label">Font Size</label>
            <label class="input">
              <input name="font-size" type="text" class="cms-style-update text-input cms-size" id="font-size" value="<?php echo $row_getRecord['font-size']; ?>" rel="font-size" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Line Height</label>
            <label class="input">
              <input name="line-height" type="text" class="cms-style-update text-input cms-size" id="line-height" value="<?php echo $row_getRecord['line-height']; ?>" rel="line-height" />
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col col-6">
            <label class="label">Text Decoration</label>
            <label class="select">
              <select name="text-decoration" class="cms-style-update text-input" rel="text-decoration" id="text-decoration">
                <option value="" <?php if (!(strcmp("", $row_getRecord['text-decoration']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="none" <?php if (!(strcmp("none", $row_getRecord['text-decoration']))) {echo "selected=\"selected\"";} ?>>none</option>
                <option value="underline" <?php if (!(strcmp("underline", $row_getRecord['text-decoration']))) {echo "selected=\"selected\"";} ?>>underline</option>
                <option value="overline" <?php if (!(strcmp("overline", $row_getRecord['text-decoration']))) {echo "selected=\"selected\"";} ?>>overline</option>
                <option value="line-through" <?php if (!(strcmp("line-through", $row_getRecord['text-decoration']))) {echo "selected=\"selected\"";} ?>>line-through</option>
                <option value="blink" <?php if (!(strcmp("blink", $row_getRecord['text-decoration']))) {echo "selected=\"selected\"";} ?>>blink</option>
              </select>
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Font Weight</label>
            <label class="input">
              <input name="font-weight" type="text" class="cms-style-update text-input cms-size" id="font-weight" value="<?php echo $row_getRecord['font-weight']; ?>" rel="font-weight" />
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col col-6">
            <label class="label">Font Variant</label>
            <label class="select">
              <select name="font-variant" class="cms-style-update text-input" rel="font-variant" id="font-variant">
                <option value="" <?php if (!(strcmp("", $row_getRecord['font-variant']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="normal" <?php if (!(strcmp("normal", $row_getRecord['font-variant']))) {echo "selected=\"selected\"";} ?>>normal</option>
                <option value="small-caps" <?php if (!(strcmp("small-caps", $row_getRecord['font-variant']))) {echo "selected=\"selected\"";} ?>>small-caps</option>
              </select>
              <i></i></label>
          </div>
          <div class="col col-6">
            <label class="label">Text Transform</label>
            <label class="select">
              <select name="text-transform" class="cms-style-update text-input" rel="text-transform" id="text-transform">
                <option value="" <?php if (!(strcmp("", $row_getRecord['text-transform']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="capitalize" <?php if (!(strcmp("capitalize", $row_getRecord['text-transform']))) {echo "selected=\"selected\"";} ?>>capitalize</option>
                <option value="uppercase" <?php if (!(strcmp("uppercase", $row_getRecord['text-transform']))) {echo "selected=\"selected\"";} ?>>uppercase</option>
                <option value="lowercase" <?php if (!(strcmp("lowercase", $row_getRecord['text-transform']))) {echo "selected=\"selected\"";} ?>>lowercase</option>
                <option value="none" <?php if (!(strcmp("none", $row_getRecord['text-transform']))) {echo "selected=\"selected\"";} ?>>none</option>
              </select>
              <i></i></label>
          </div>
        </div>
      </div>
      <div id="s2" class="tab-pane fade in ">
        <p class="widget-label">Size</p>
        <div class="row">
          <div class="col col-6">
            <label class="label">Width</label>
            <label class="input">
              <input name="width" type="text" class="cms-style-update text-input cms-size"  value="<?php echo $row_getRecord['width']; ?>" rel="width" size="10" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Min-Width</label>
            <label class="input">
              <input name="min-width" type="text" class="cms-style-update text-input cms-size"  value="<?php echo $row_getRecord['min-width']; ?>" rel="min-width" size="10" />
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col col-6">
            <label class="label">Max-Width</label>
            <label class="input">
              <input name="max-width" type="text" class="cms-style-update text-input cms-size"  value="<?php echo $row_getRecord['width']; ?>" rel="max-width" size="10" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Height</label>
            <label class="input">
              <input name="height" type="text" class="cms-style-update text-input cms-size" value="<?php echo $row_getRecord['height']; ?>" rel="height" size="10" />
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col col-6">
            <label class="label">Min-Height</label>
            <label class="input">
              <input name="min-height" type="text" class="cms-style-update text-input cms-size"  value="<?php echo $row_getRecord['height']; ?>" rel="min-height" size="10" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Max-Height</label>
            <label class="input">
              <input name="max-height" type="text" class="cms-style-update text-input cms-size"  value="<?php echo $row_getRecord['height']; ?>" rel="max-height" size="10" />
            </label>
          </div>
        </div>
        <p class="widget-label" style="margin-top:15px">Position</p>
        <div class="row">
          <div class="col col-6">
            <label class="label">Float</label>
            <label class="select">
              <select name="float" class="cms-style-update text-input" rel="float" id="float">
                <option value="" <?php if (!(strcmp("", $row_getRecord['float']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="left" <?php if (!(strcmp("left", $row_getRecord['float']))) {echo "selected=\"selected\"";} ?>>left</option>
                <option value="right" <?php if (!(strcmp("right", $row_getRecord['float']))) {echo "selected=\"selected\"";} ?>>right</option>
                <option value="none" <?php if (!(strcmp("none", $row_getRecord['float']))) {echo "selected=\"selected\"";} ?>>none</option>
              </select>
              <i></i></label>
          </div>
          <div class="col col-6">
            <label class="label">Clear</label>
            <label class="select">
              <select name="clear" class="cms-style-update text-input" rel="clear" id="clear">
                <option value="" <?php if (!(strcmp("", $row_getRecord['clear']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="left" <?php if (!(strcmp("left", $row_getRecord['clear']))) {echo "selected=\"selected\"";} ?>>left</option>
                <option value="right" <?php if (!(strcmp("right", $row_getRecord['clear']))) {echo "selected=\"selected\"";} ?>>right</option>
                <option value="both" <?php if (!(strcmp("both", $row_getRecord['clear']))) {echo "selected=\"selected\"";} ?>>both</option>
                <option value="none" <?php if (!(strcmp("none", $row_getRecord['clear']))) {echo "selected=\"selected\"";} ?>>none</option>
              </select>
              <i></i></label>
          </div>
        </div>
      </div>
      <div id="s4" class="tab-pane fade in ">
        <p class="widget-label">Background</p>
        <div class="row">
          <div class="col col-6">
            <label class="label">Background Image</label>
            <label class="input">
              <input name="background-image" type="text" class="cms-style-update text-input cms-url" id="background-image" value="<?php echo $row_getRecord['background-image']; ?>" size="45" rel="background-image" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Repeat</label>
            <label class="select">
              <select name="background-repeat" class="cms-style-update text-input" rel="background-repeat" id="background-repeat">
                <option value="" <?php if (!(strcmp("", $row_getRecord['background-repeat']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="repeat" <?php if (!(strcmp("repeat", $row_getRecord['background-repeat']))) {echo "selected=\"selected\"";} ?>>repeat</option>
                <option value="repeat-x" <?php if (!(strcmp("repeat-x", $row_getRecord['background-repeat']))) {echo "selected=\"selected\"";} ?>>repeat-x</option>
                <option value="repeat-y" <?php if (!(strcmp("repeat-y", $row_getRecord['background-repeat']))) {echo "selected=\"selected\"";} ?>>repeat-y</option>
                <option value="no-repeat" <?php if (!(strcmp("no-repeat", $row_getRecord['background-repeat']))) {echo "selected=\"selected\"";} ?>>no-repeat</option>
              </select>
              <i></i></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-6">
            <label class="label">Background Color</label>
            <label class="input">
              <input name="background-color" type="text" class="cms-style-update text-input colorSelect cms-color-select" id="background-color" value="<?php echo $row_getRecord['background-color']; ?>" rel="background-color" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Background Attatchment</label>
            <label class="select">
              <select name="background-attachment" class="cms-style-update text-input" rel="background-attachment" id="background-attachment">
                <option value="" <?php if (!(strcmp("", $row_getRecord['background-attachment']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="scroll" <?php if (!(strcmp("scroll", $row_getRecord['background-attachment']))) {echo "selected=\"selected\"";} ?>>scroll</option>
                <option value="fixed" <?php if (!(strcmp("fixed", $row_getRecord['background-attachment']))) {echo "selected=\"selected\"";} ?>>fixed</option>
              </select>
              <i></i></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-6">
            <label class="label">Backgrond Position</label>
            <label class="input">
              <input name="background-position" type="text" class="cms-style-update text-input" id="background-position" value="<?php echo $row_getRecord['background-position']; ?>" size="45" rel="background-position" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Background Size</label>
            <label class="input">
              <input name="background-size" type="text" class="cms-style-update text-input" id="background-size" value="<?php echo $row_getRecord['background-size']; ?>" size="45" rel="background-size" />
            </label>
          </div>
        </div>
      </div>
      <div id="s5" class="tab-pane fade in ">
        <p class="widget-label">Margins</p>
        <div class="row">
          <div class="col col-6">
            <label class="label">Left</label>
            <label class="input">
              <input name="margin-left" type="text" class="cms-style-update text-input cms-size" id="margin-left" value="<?php echo $row_getRecord['margin-left']; ?>" rel="margin-left" size="10" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Top</label>
            <label class="input">
              <input name="margin-top" type="text" class="cms-style-update text-input cms-size" id="margin-top" value="<?php echo $row_getRecord['margin-top']; ?>" rel="margin-top" size="10" />
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col col-6">
            <label class="label">Right</label>
            <label class="input">
              <input name="margin-right" type="text" class="cms-style-update text-input cms-size" id="margin-right" value="<?php echo $row_getRecord['margin-right']; ?>" rel="margin-right" size="10" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Bottom</label>
            <label class="input">
              <input name="margin-bottom" type="text" class="cms-style-update text-input cms-size" id="margin-bottom" value="<?php echo $row_getRecord['margin-bottom']; ?>" rel="margin-bottom" size="10" />
            </label>
          </div>
        </div>
        <p class="widget-label" style="margin-top:15px">Padding</p>
        <div class="row">
          <div class="col col-6">
            <label class="label">Left</label>
            <label class="input">
              <input name="padding-left" type="text" class="cms-style-update text-input cms-size" id="padding-left" value="<?php echo $row_getRecord['padding-left']; ?>" rel="padding-left" size="10" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Top</label>
            <label class="input">
              <input name="padding-top" type="text" class="cms-style-update text-input cms-size" id="padding-top" value="<?php echo $row_getRecord['padding-top']; ?>" rel="padding-top" size="10" />
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col col-6">
            <label class="label">Right</label>
            <label class="input">
              <input name="padding-right" type="text" class="cms-style-update text-input cms-size" id="padding-right" value="<?php echo $row_getRecord['padding-right']; ?>" rel="padding-right" size="10" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Bottom</label>
            <label class="input">
              <input name="padding-bottom" type="text" class="cms-style-update text-input cms-size" id="padding-bottom" value="<?php echo $row_getRecord['padding-bottom']; ?>" rel="padding-bottom" size="10" />
            </label>
          </div>
        </div>
      </div>
      <div id="s7" class="tab-pane fade in ">
        <p class="widget-label">Border</p>
        <div class="row">
          <div class="col col-3">
            <label class="label">Left</label>
          </div>
          <div class="col col-3">
            <label class="input">
              <input name="border-left-width" type="text" class="cms-style-update text-input cms-size cms-border" id="border-left-width" value="<?= $row_getRecord['border-left-width']; ?>" rel="border-left-width" size="10" placeholder="width" />
            </label>
          </div>
          <div class="col col-3">
            <label class="select">
              <select name="border-left-style" class="cms-style-update text-input cms-border-width" rel="border-left-style" id="border-left-style">
                <option value="" <?php if (!(strcmp("", $row_getRecord['border-left-style']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="none" <?php if (!(strcmp("none", $row_getRecord['border-left-style']))) {echo "selected=\"selected\"";} ?>>none</option>
                <option value="dotted" <?php if (!(strcmp("dotted", $row_getRecord['border-left-style']))) {echo "selected=\"selected\"";} ?>>dotted</option>
                <option value="dashed" <?php if (!(strcmp("dashed", $row_getRecord['border-left-style']))) {echo "selected=\"selected\"";} ?>>dashed</option>
                <option value="solid" <?php if (!(strcmp("solid", $row_getRecord['border-left-style']))) {echo "selected=\"selected\"";} ?>>solid</option>
                <option value="double" <?php if (!(strcmp("double", $row_getRecord['border-left-style']))) {echo "selected=\"selected\"";} ?>>double</option>
                <option value="groove" <?php if (!(strcmp("groove", $row_getRecord['border-left-style']))) {echo "selected=\"selected\"";} ?>>groove</option>
                <option value="ridge" <?php if (!(strcmp("ridge", $row_getRecord['border-left-style']))) {echo "selected=\"selected\"";} ?>>ridge</option>
                <option value="inset" <?php if (!(strcmp("inset", $row_getRecord['border-left-style']))) {echo "selected=\"selected\"";} ?>>inset</option>
                <option value="outset" <?php if (!(strcmp("outset", $row_getRecord['border-left-style']))) {echo "selected=\"selected\"";} ?>>outset</option>
              </select>
              <i></i></label>
          </div>
          <div class="col col-3">
            <label class="input">
              <input name="border-left-color" type="text" class="cms-style-update text-input colorSelect cms-color-select  cms-border-color" id="border-left-color" value="" rel="border-left-color" placeholder="color" />
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col col-3">
            <label class="label">Top</label>
          </div>
          <div class="col col-3">
            <label class="input">
              <input name="border-top-width" type="text" class="cms-style-update text-input cms-size cms-border" id="border-top-width" value="<?= $row_getRecord['border-top-width']; ?>" rel="border-top-width" size="10" placeholder="width" />
            </label>
          </div>
          <div class="col col-3">
            <label class="select">
              <select name="border-top-style" class="cms-style-update text-input cms-border-width" rel="border-top-style" id="border-top-style">
                <option value="" <?php if (!(strcmp("", $row_getRecord['border-top-style']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="none" <?php if (!(strcmp("none", $row_getRecord['border-top-style']))) {echo "selected=\"selected\"";} ?>>none</option>
                <option value="dotted" <?php if (!(strcmp("dotted", $row_getRecord['border-top-style']))) {echo "selected=\"selected\"";} ?>>dotted</option>
                <option value="dashed" <?php if (!(strcmp("dashed", $row_getRecord['border-top-style']))) {echo "selected=\"selected\"";} ?>>dashed</option>
                <option value="solid" <?php if (!(strcmp("solid", $row_getRecord['border-top-style']))) {echo "selected=\"selected\"";} ?>>solid</option>
                <option value="double" <?php if (!(strcmp("double", $row_getRecord['border-top-style']))) {echo "selected=\"selected\"";} ?>>double</option>
                <option value="groove" <?php if (!(strcmp("groove", $row_getRecord['border-top-style']))) {echo "selected=\"selected\"";} ?>>groove</option>
                <option value="ridge" <?php if (!(strcmp("ridge", $row_getRecord['border-top-style']))) {echo "selected=\"selected\"";} ?>>ridge</option>
                <option value="inset" <?php if (!(strcmp("inset", $row_getRecord['border-top-style']))) {echo "selected=\"selected\"";} ?>>inset</option>
                <option value="outset" <?php if (!(strcmp("outset", $row_getRecord['border-top-style']))) {echo "selected=\"selected\"";} ?>>outset</option>
              </select>
              <i></i></label>
          </div>
          <div class="col col-3">
            <label class="input">
              <input name="border-top-color" type="text" class="cms-style-update text-input colorSelect cms-color-select  cms-border-color" id="border-top-color" value="" rel="border-top-color" placeholder="color" />
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col col-3">
            <label class="label">Right</label>
          </div>
          <div class="col col-3">
            <label class="input">
              <input name="border-right-width" type="text" class="cms-style-update text-input cms-size cms-border" id="border-right-width" value="<?= $row_getRecord['border-right-width']; ?>" rel="border-right-width" size="10" placeholder="width" />
            </label>
          </div>
          <div class="col col-3">
            <label class="select">
              <select name="border-right-style" class="cms-style-update text-input cms-border-width" rel="border-right-style" id="border-right-style">
                <option value="" <?php if (!(strcmp("", $row_getRecord['border-right-style']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="none" <?php if (!(strcmp("none", $row_getRecord['border-right-style']))) {echo "selected=\"selected\"";} ?>>none</option>
                <option value="dotted" <?php if (!(strcmp("dotted", $row_getRecord['border-right-style']))) {echo "selected=\"selected\"";} ?>>dotted</option>
                <option value="dashed" <?php if (!(strcmp("dashed", $row_getRecord['border-right-style']))) {echo "selected=\"selected\"";} ?>>dashed</option>
                <option value="solid" <?php if (!(strcmp("solid", $row_getRecord['border-right-style']))) {echo "selected=\"selected\"";} ?>>solid</option>
                <option value="double" <?php if (!(strcmp("double", $row_getRecord['border-right-style']))) {echo "selected=\"selected\"";} ?>>double</option>
                <option value="groove" <?php if (!(strcmp("groove", $row_getRecord['border-right-style']))) {echo "selected=\"selected\"";} ?>>groove</option>
                <option value="ridge" <?php if (!(strcmp("ridge", $row_getRecord['border-right-style']))) {echo "selected=\"selected\"";} ?>>ridge</option>
                <option value="inset" <?php if (!(strcmp("inset", $row_getRecord['border-right-style']))) {echo "selected=\"selected\"";} ?>>inset</option>
                <option value="outset" <?php if (!(strcmp("outset", $row_getRecord['border-right-style']))) {echo "selected=\"selected\"";} ?>>outset</option>
              </select>
              <i></i></label>
          </div>
          <div class="col col-3">
            <label class="input">
              <input name="border-right-color" type="text" class="cms-style-update text-input colorSelect cms-color-select  cms-border-color" id="border-right-color" value="" rel="border-right-color" placeholder="color" />
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col col-3">
            <label class="label">Bottom</label>
          </div>
          <div class="col col-3">
            <label class="input">
              <input name="border-bottom-width" type="text" class="cms-style-update text-input cms-size cms-border" id="border-bottom-width" value="<?= $row_getRecord['border-bottom-width']; ?>" rel="border-bottom-width" size="10" placeholder="width" />
            </label>
          </div>
          <div class="col col-3">
            <label class="select">
              <select name="border-bottom-style" class="cms-style-update text-input cms-border-width" rel="border-bottom-style" id="border-bottom-style">
                <option value="" <?php if (!(strcmp("", $row_getRecord['border-bottom-style']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="none" <?php if (!(strcmp("none", $row_getRecord['border-bottom-style']))) {echo "selected=\"selected\"";} ?>>none</option>
                <option value="dotted" <?php if (!(strcmp("dotted", $row_getRecord['border-bottom-style']))) {echo "selected=\"selected\"";} ?>>dotted</option>
                <option value="dashed" <?php if (!(strcmp("dashed", $row_getRecord['border-bottom-style']))) {echo "selected=\"selected\"";} ?>>dashed</option>
                <option value="solid" <?php if (!(strcmp("solid", $row_getRecord['border-bottom-style']))) {echo "selected=\"selected\"";} ?>>solid</option>
                <option value="double" <?php if (!(strcmp("double", $row_getRecord['border-bottom-style']))) {echo "selected=\"selected\"";} ?>>double</option>
                <option value="groove" <?php if (!(strcmp("groove", $row_getRecord['border-bottom-style']))) {echo "selected=\"selected\"";} ?>>groove</option>
                <option value="ridge" <?php if (!(strcmp("ridge", $row_getRecord['border-bottom-style']))) {echo "selected=\"selected\"";} ?>>ridge</option>
                <option value="inset" <?php if (!(strcmp("inset", $row_getRecord['border-bottom-style']))) {echo "selected=\"selected\"";} ?>>inset</option>
                <option value="outset" <?php if (!(strcmp("outset", $row_getRecord['border-bottom-style']))) {echo "selected=\"selected\"";} ?>>outset</option>
              </select>
              <i></i></label>
          </div>
          <div class="col col-3">
            <label class="input">
              <input name="border-bottom-color" type="text" class="cms-style-update text-input colorSelect cms-color-select  cms-border-color" id="border-bottom-color" value="" rel="border-bottom-color" placeholder="color" />
            </label>
          </div>
        </div>
        <p class="widget-label" style="margin-top:15px;">Border Radius</p>
        <div class="row">
          <div class="col col-6">
            <label class="label">Top Left</label>
            <label class="input">
              <input name="border-top-left-radius" type="text" class="cms-style-update text-input cms-size" id="border-top-left-radius" value="<?php echo $row_getRecord['border-top-left-radius']; ?>" rel="border-top-left-radius" size="10" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Top Right</label>
            <label class="input">
              <input name="border-top-right-radius" type="text" class="cms-style-update text-input cms-size" id="border-top-right-radius" value="<?php echo $row_getRecord['border-top-right-radius']; ?>" rel="border-top-right-radius" size="10" />
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col col-6">
            <label class="label">Bottom Left</label>
            <label class="input">
              <input name="border-bottom-left-radius" type="text" class="cms-style-update text-input cms-size" id="border-bottom-left-radius" value="<?php echo $row_getRecord['border-bottom-left-radius']; ?>" rel="border-bottom-left-radius" size="10" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Bottom Right</label>
            <label class="input">
              <input name="border-bottom-right-radius" type="text" class="cms-style-update text-input cms-size" id="border-bottom-right-radius" value="<?php echo $row_getRecord['border-bottom-right-radius']; ?>" rel="border-bottom-right-radius" size="10" />
            </label>
          </div>
        </div>
      </div>
      <div id="s9" class="tab-pane fade in ">
        <p class="widget-label">List</p>
        <div class="row">
          <div class="col col-6">
            <label class="label">List Style Type</label>
            <label class="select">
              <select name="list-style-type" class="cms-style-update text-input" rel="list-style-type" id="list-style-type">
                <option value="" <?php if (!(strcmp("", $row_getRecord['list-style-type']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="none" <?php if (!(strcmp("none", $row_getRecord['list-style-type']))) {echo "selected=\"selected\"";} ?>>none</option>
                <option value="disc" <?php if (!(strcmp("disc", $row_getRecord['list-style-type']))) {echo "selected=\"selected\"";} ?>>disc</option>
                <option value="square" <?php if (!(strcmp("square", $row_getRecord['list-style-type']))) {echo "selected=\"selected\"";} ?>>square</option>
                <option value="decimal" <?php if (!(strcmp("decimal", $row_getRecord['list-style-type']))) {echo "selected=\"selected\"";} ?>>decimal</option>
                <option value="lower-roman" <?php if (!(strcmp("lower-roman", $row_getRecord['list-style-type']))) {echo "selected=\"selected\"";} ?>>lower-roman</option>
                <option value="upper-roman" <?php if (!(strcmp("upper-roman", $row_getRecord['list-style-type']))) {echo "selected=\"selected\"";} ?>>upper-roman</option>
                <option value="lower-alpha" <?php if (!(strcmp("lower-alpha", $row_getRecord['list-style-type']))) {echo "selected=\"selected\"";} ?>>lower-alpha</option>
                <option value="upper-alpha" <?php if (!(strcmp("upper-alpha", $row_getRecord['list-style-type']))) {echo "selected=\"selected\"";} ?>>upper-alpha</option>
              </select>
              <i></i></label>
          </div>
          <div class="col col-6">
            <label class="label">List Style Position</label>
            <label class="select">
              <select name="list-style-position" class="cms-style-update text-input" rel="list-style-position" id="list-style-position">
                <option value="" <?php if (!(strcmp("", $row_getRecord['list-style-position']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="inside" <?php if (!(strcmp("inside", $row_getRecord['list-style-position']))) {echo "selected=\"selected\"";} ?>>inside</option>
                <option value="outside" <?php if (!(strcmp("outside", $row_getRecord['list-style-position']))) {echo "selected=\"selected\"";} ?>>outside</option>
              </select>
              <i></i></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-12">
            <label class="label">List Style Image</label>
            <label class="input">
              <input name="list-style-image" type="text" class="cms-style-update text-input cms-url" id="list-style-image" value="<?php echo $row_getRecord['list-style-image']; ?>" size="45" rel="list-style-image" />
            </label>
          </div>
        </div>
      </div>
      <div id="s10" class="tab-pane fade in ">
        <p class="widget-label">Other</p>
        <div class="row">
          <div class="col col-6">
            <label class="label">Word Spacing</label>
            <label class="input">
              <input name="word-spacing" type="text" class="cms-style-update text-input cms-size" id="word-spacing" value="<?php echo $row_getRecord['word-spacing']; ?>" rel="word-spacing" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">Letter Spacing</label>
            <label class="input">
              <input name="letter-spacing" type="text" class="cms-style-update text-input cms-size" id="letter-spacing" value="<?php echo $row_getRecord['letter-spacing']; ?>" rel="letter-spacing" />
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col col-6">
            <label class="label">Vertical Align</label>
            <label class="select">
              <select name="vertical-align" class="cms-style-update text-input" rel="vertical-align" id="vertical-align">
                <option value="" <?php if (!(strcmp("", $row_getRecord['vertical-align']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="baseline" <?php if (!(strcmp("baseline", $row_getRecord['vertical-align']))) {echo "selected=\"selected\"";} ?>>baseline</option>
                <option value="sub" <?php if (!(strcmp("sub", $row_getRecord['vertical-align']))) {echo "selected=\"selected\"";} ?>>sub</option>
                <option value="super" <?php if (!(strcmp("super", $row_getRecord['vertical-align']))) {echo "selected=\"selected\"";} ?>>super</option>
                <option value="top" <?php if (!(strcmp("top", $row_getRecord['vertical-align']))) {echo "selected=\"selected\"";} ?>>top</option>
                <option value="text-top" <?php if (!(strcmp("text-top", $row_getRecord['vertical-align']))) {echo "selected=\"selected\"";} ?>>text-top</option>
                <option value="middle" <?php if (!(strcmp("middle", $row_getRecord['vertical-align']))) {echo "selected=\"selected\"";} ?>>middle</option>
                <option value="bottom" <?php if (!(strcmp("bottom", $row_getRecord['vertical-align']))) {echo "selected=\"selected\"";} ?>>bottom</option>
                <option value="text-bottom" <?php if (!(strcmp("text-bottom", $row_getRecord['vertical-align']))) {echo "selected=\"selected\"";} ?>>text-bottom</option>
              </select>
              <i></i></label>
          </div>
          <div class="col col-6">
            <label class="label">Text Align</label>
            <label class="select">
              <select name="text-align" class="cms-style-update text-input" rel="text-align" id="text-align">
                <option value="" <?php if (!(strcmp("", $row_getRecord['text-align']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="left" <?php if (!(strcmp("left", $row_getRecord['text-align']))) {echo "selected=\"selected\"";} ?>>left</option>
                <option value="right" <?php if (!(strcmp("right", $row_getRecord['text-align']))) {echo "selected=\"selected\"";} ?>>right</option>
                <option value="center" <?php if (!(strcmp("center", $row_getRecord['text-align']))) {echo "selected=\"selected\"";} ?>>center</option>
                <option value="justify" <?php if (!(strcmp("justify", $row_getRecord['text-align']))) {echo "selected=\"selected\"";} ?>>justify</option>
              </select>
              <i></i></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-6">
            <label class="label">Text Indent</label>
            <label class="input">
              <input name="text-indent" type="text" class="cms-style-update text-input cms-size" id="text-indent" value="<?php echo $row_getRecord['text-indent']; ?>" rel="text-indent" />
            </label>
          </div>
          <div class="col col-6">
            <label class="label">White Space</label>
            <label class="select">
              <select name="select-space" class="cms-style-update text-input" rel="white-space" id="white-space">
                <option value="" <?php if (!(strcmp("", $row_getRecord['white-space']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="normal" <?php if (!(strcmp("normal", $row_getRecord['white-space']))) {echo "selected=\"selected\"";} ?>>normal</option>
                <option value="pre" <?php if (!(strcmp("pre", $row_getRecord['white-space']))) {echo "selected=\"selected\"";} ?>>pre</option>
                <option value="nowrap" <?php if (!(strcmp("nowrap", $row_getRecord['white-space']))) {echo "selected=\"selected\"";} ?>>nowrap</option>
              </select>
              <i></i></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-6">
            <label class="label">Display</label>
            <label class="select">
              <select name="display" class="cms-style-update text-input" rel="display" id="display">
                <option value="" <?php if (!(strcmp("", $row_getRecord['display']))) {echo "selected=\"selected\"";} ?>></option>
                <option value="none" <?php if (!(strcmp("none", $row_getRecord['display']))) {echo "selected=\"selected\"";} ?>>none</option>
                <option value="inline" <?php if (!(strcmp("inline", $row_getRecord['display']))) {echo "selected=\"selected\"";} ?>>inline</option>
                <option value="block" <?php if (!(strcmp("block", $row_getRecord['display']))) {echo "selected=\"selected\"";} ?>>block</option>
                <option value="list-item" <?php if (!(strcmp("list-item", $row_getRecord['display']))) {echo "selected=\"selected\"";} ?>>list-item</option>
                <option value="run-in" <?php if (!(strcmp("run-in", $row_getRecord['display']))) {echo "selected=\"selected\"";} ?>>run-in</option>
                <option value="inline-block" <?php if (!(strcmp("inline-block", $row_getRecord['display']))) {echo "selected=\"selected\"";} ?>>inline-block</option>
                <option value="compact" <?php if (!(strcmp("compact", $row_getRecord['display']))) {echo "selected=\"selected\"";} ?>>compact</option>
                <option value="marker" <?php if (!(strcmp("marker", $row_getRecord['display']))) {echo "selected=\"selected\"";} ?>>marker</option>
                <option value="table" <?php if (!(strcmp("table", $row_getRecord['display']))) {echo "selected=\"selected\"";} ?>>table</option>
                <option value="inline-table" <?php if (!(strcmp("inline-table", $row_getRecord['display']))) {echo "selected=\"selected\"";} ?>>inline-table</option>
                <option value="inherit" <?php if (!(strcmp("inherit", $row_getRecord['display']))) {echo "selected=\"selected\"";} ?>>inherit</option>
              </select>
              <i></i></label>
          </div>
        </div>
      </div>
      <div id="s11" class="tab-pane fade in ">
        <p class="widget-label">Attributes</p>
        <div class="row">
          <div class="col col-12">
            <label class="label">ID</label>
            <label class="input">
              <input name="id" type="text" class="cms-attr-update text-input" rel="id" size="10" />
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col col-12">
            <label class="label">HREF</label>
            <label class="input">
              <input name="href" type="text" class="cms-attr-update text-input" rel="href" size="10" />
            </label>
          </div>
        </div>
        <div class="row">
          <div class="col col-12">
            <label class="label">SRC</label>
            <label class="input">
              <input name="src" type="text" class="cms-attr-update text-input" rel="src" size="10" />
            </label>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
