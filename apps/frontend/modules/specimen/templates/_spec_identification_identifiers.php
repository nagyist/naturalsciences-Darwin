          <tr id="spec_ident_<?php echo $identnum ?>_identifiers_data_<?php echo $rownum;?>">
            <td class="spec_ident_identifiers_handle"><?php echo image_tag('drag.png');?></td>
            <td>  
              <?php echo $form->renderError();?>
              <?php echo $form['people_ref']->renderLabel();?>
            </td>
            <td class="widget_row_delete">
              <?php echo image_tag('remove.png', 'alt=Delete class=clear_code id=clear_ident_'.$identnum.'_identifiers_'.$rownum); ?>
              <?php echo $form->renderHiddenFields();?>
              <script  type="text/javascript">
              $(document).ready(function () {
                $("#clear_ident_<?php echo $identnum ?>_identifiers_<?php echo $rownum;?>").click( function()
                {
                  parent = $(this).closest('tr');
                  parentTableId = $(parent).closest('table').attr('id');
                  $(parent).find('input[id$=\"_people_ref\"]').val('');
                  $(parent).hide();
                  $.fn.catalogue_people.reorder($(parent).closest('table'));
                  if(!$('table#'+parentTableId+' .spec_ident_collectors_data:visible').size())
                  {
                    $(this).closest('table#'+parentTableId).find('thead').hide();
                    $(this).closest('table#'+parentTableId).removeClass('green_border');
                  }
                });
              });
            </script>
            </td>
          </tr>