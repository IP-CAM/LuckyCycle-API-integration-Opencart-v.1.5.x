<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td style="width:250px;"><span class="required">*</span> <?php echo $api_id; ?></td>
            <td><input type="text" name="sdksnippet_text_field" value="<?php echo $sdksnippet_text_field; ?>" size="60"/>
              <?php if ($error_api_id) { ?>
              <span class="error"><?php echo $error_api_id; ?></span>
              <?php } ?></td>
          </tr>
            <tr>
                <td style="width:250px;"><span class="required">*</span> <?php echo $operation_id; ?></td>
                <td><input type="text" name="sdksnippet_operation_id" value="<?php echo $sdksnippet_operation_id; ?>" size="60"/>
                    <?php if ($error_operation_id) { ?>
                    <span class="error"><?php echo $error_operation_id; ?></span>
                    <?php } ?></td>
            </tr>
            <tr>
                <td><?php echo $use_mode; ?></td>
                <td><select name="sdksnippet_use_mode">
                        <?php foreach ($use_mode_datas as $use_mode_data) { ?>
                        <?php if ($use_mode_data['alias'] == $sdksnippet_use_mode) { ?>
                        <option value="<?php echo $use_mode_data['alias']; ?>" selected="selected"><?php echo $use_mode_data['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $use_mode_data['alias']; ?>"><?php echo $use_mode_data['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select></td>
            </tr>
            <tr>
                <td style="width:250px;"><?php echo $iframe_width; ?></td>
                <td><input type="text" name="sdksnippet_iframe_width" value="<?php echo $sdksnippet_iframe_width; ?>" size="60"/>
                </td>
            </tr>
            <tr>
                <td style="width:250px;"><?php echo $iframe_height; ?></td>
                <td><input type="text" name="sdksnippet_iframe_height" value="<?php echo $sdksnippet_iframe_height; ?>" size="60"/>
                </td>
            </tr>
            <tr>
                <td><?php echo $upload_banner; ?></td>
                <td><div class="image"><img src="<?php echo $banner; ?>" alt="" id="thumb-banner" />
                        <input type="hidden" name="luckycycle_banner" value="<?php echo $luckycycle_banner; ?>" id="banner" />
                        <br />
                        <a onclick="image_upload('banner', 'thumb-banner');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb-banner').attr('src', '<?php echo $no_image; ?>'); $('#banner').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
            </tr>
            <tr>
                <td><?php echo $other_information_label; ?></td>
                <td><textarea name="sdksnippet_other_information" cols="40" rows="5"><?php echo $sdksnippet_other_information; ?></textarea></td>
            </tr>
            <tr>
                <td><?php echo $after_information_label; ?></td>
                <td><textarea name="sdksnippet_after_information" cols="40" rows="5"><?php echo $sdksnippet_after_information; ?></textarea></td>
            </tr>
          <tr>
          	<td><?php echo $entry_payment_method; ?></td>
            <td>
            	<div class="scrollbox">
                <?php $class = 'odd'; ?>
                <?php foreach ($extensions as $extension) { ?>
                	<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                	<div class="<?php echo $class; ?>">
                    	<?php if (is_array($sdkextension) && in_array($extension['alias'], $sdkextension)) { ?>
                            <input type="checkbox" name="sdkextension[]" value="<?php echo $extension['alias']; ?>" checked="checked" />
                            <?php echo $extension['name']; ?>
                        <?php } else { ?>
                            <input type="checkbox" name="sdkextension[]" value="<?php echo $extension['alias']; ?>" />
                            <?php echo $extension['name']; ?>
                        <?php } ?>
                	</div>
              	<?php } ?>
              	</div>
              	<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a></td>
          </tr>
        </table>
        <table id="module" class="list" style="display:none;">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_layout; ?></td>
              <td class="left"><?php echo $entry_position; ?></td>
              <td class="left"><?php echo $entry_status; ?></td>
              <td class="right"><?php echo $entry_sort_order; ?></td>
              <td></td>
            </tr>
          </thead>
          <?php $module_row = 0; ?>
          <?php foreach ($modules as $module) { ?>
          <tbody id="module-row<?php echo $module_row; ?>">
            <tr>
              <td class="left"><select name="sdksnippet_module[<?php echo $module_row; ?>][layout_id]">
                  <?php foreach ($layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                  <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="sdksnippet_module[<?php echo $module_row; ?>][position]">
                  <?php if ($module['position'] == 'content_top') { ?>
                  <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                  <?php } else { ?>
                  <option value="content_top"><?php echo $text_content_top; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'content_bottom') { ?>
                  <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                  <?php } else { ?>
                  <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'column_left') { ?>
                  <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                  <?php } else { ?>
                  <option value="column_left"><?php echo $text_column_left; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'column_right') { ?>
                  <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                  <?php } else { ?>
                  <option value="column_right"><?php echo $text_column_right; ?></option>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="sdksnippet_module[<?php echo $module_row; ?>][status]">
                  <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td class="right"><input type="text" name="sdksnippet_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
              <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
            </tr>
          </tbody>
          <?php $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="4"></td>
              <td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = "<?php echo $module_row; ?>";
 
function addModule() {    
    html  = '<tbody id="module-row' + module_row + '">';
    html += '  <tr>';
    html += '    <td class="left"><select name="sdksnippet_module[' + module_row + '][layout_id]">';
    <?php foreach ($layouts as $layout) { ?>
    html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
    <?php } ?>
    html += '    </select></td>';
    html += '    <td class="left"><select name="sdksnippet_module[' + module_row + '][position]">';
    html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
    html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
    html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
    html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
    html += '    </select></td>';
    html += '    <td class="left"><select name="sdksnippet_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
    html += '    <td class="right"><input type="text" name="sdksnippet_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
    html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
    html += '  </tr>';
    html += '</tbody>';
     
    $('#module tfoot').before(html);
     
    module_row++;
}
//--></script>
<script type="text/javascript"><!--
    function image_upload(field, thumb) {
        $('#dialog').remove();

        $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

        $('#dialog').dialog({
            title: '<?php echo $text_image_manager; ?>',
            close: function (event, ui) {
                if ($('#' + field).attr('value')) {
                    $.ajax({
                        url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
                        dataType: 'text',
                        success: function(data) {
                            $('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
                        }
                    });
                }
            },
            bgiframe: false,
            width: 800,
            height: 400,
            resizable: false,
            modal: false
        });
    };
    //--></script>
<?php echo $footer; ?>