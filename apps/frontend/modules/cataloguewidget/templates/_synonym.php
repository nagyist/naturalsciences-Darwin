<table class="catalogue_table<?php echo($sf_user->isA(Users::REGISTERED_USER)?'_view':'') ;?>">
  <thead>
    <tr>
      <th><?php echo __('Type');?></th>
      <th><?php echo __('Items');?></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($synonyms as $group_name => $group):?>
    <tr>
      <td>
	<?php echo __(ucfirst($group_name));?>
      </td>
      <td>
	  <table class="grp_id_<?php echo $group[0]['group_id'];?> widget_sub_table" alt="<?php echo $group_name;?>">
	    <thead>
	      <tr>
		<th></th>
		<th><?php echo __('Name');?></th>
		<th>
		  <?php if($group_name != "homonym" ):?>
		    <?php echo __('Basionym');?>
		  <?php endif;?>
		</th>
		<th></th>
	      </tr>
	    </thead>
	    <tbody >
	    <?php foreach($group as $synonym):?>
	      <tr class="syn_id_<?php echo $synonym['id'];?>" id="id_<?php echo $synonym['id'];?>">
		<td class="handle"><?php echo image_tag('drag.png');?></td>
		<td>
		  <?php if($synonym['record_id'] == $eid):?>
		      <strong><?php echo $synonym['ref_item']->getNameWithFormat();?></strong>
		  <?php else:?>
		    <?php echo $synonym['ref_item']->getNameWithFormat();?>
		  <?php endif;?>
		</td>
		<td class="basio_cell">
		  <?php if($group_name != "homonym" && $level>Users::REGISTERED_USER):?>
		    <a href="#" <?php if($synonym['is_basionym']):?> class="checked"<?php endif;?>></a>
		  <?php endif;?>
		</td>
		<td class="widget_row_delete">	
		  <?php if($synonym['record_id'] == $eid && $level>Users::REGISTERED_USER):?>
		    <a class="widget_row_delete" href="<?php echo url_for('synonym/delete?id='.$synonym['id']);?>" title="<?php echo __('Are you sure ?') ?>">
		     <?php echo image_tag('remove.png'); ?>
		    </a>
		  <?php endif;?>
		
		</td>
	      </tr>
	    <?php endforeach;?>
	    </tbody>
	  </table>
      </td>

    </tr>
    <?php endforeach;?>
  </tbody>
</table>
<br />
<?php if($sf_user->isAtLeast(Users::ENCODER)) : ?>
<?php echo image_tag('add_green.png');?><a title="<?php echo __('Add Synonymies');?>" class="link_catalogue" href="<?php echo url_for('synonym/add?table='.$table.'&id='.$eid); ?>"><?php echo __('Add');?></a>
<?php endif ; ?>
<script type="text/javascript">

function forceHelper(e,ui)
{
   $(".ui-state-highlight").html("<td colspan='3'>&nbsp;</td>");
}

$(document).ready(function()
{

  $("#synonym td.basio_cell a").click(function ()
  {
    was_basio = false;
    if($(this).hasClass('checked')) was_basio = true;
    clicked_el = $(this);
    s_data = { id:  getIdInClasses($(this).parent().parent()), group_id: getIdInClasses($(this).closest('.widget_sub_table')) };
    
    if(was_basio) s_data['uncheck'] = 'true';
    $.ajax({
      type: "POST",
      url: "<?php echo url_for('synonym/setBasionym?table='.$table.'&rid='.$eid); ?>",
      data: s_data,
      success: function(html) {
        if(html=='ok')
        {
          clicked_el.closest('table').find('.checked').removeClass('checked');
          if(!was_basio)
            clicked_el.addClass('checked');
        }
      }
    });
    return false;
  });

  $("#synonym .widget_sub_table tbody").sortable({
    placeholder: 'ui-state-highlight',
    handle: '.handle',
    axis: 'y',
    change: function(e, ui) {
      forceHelper(e,ui);
    },
    deactivate: function(event, ui) {
      el_Array = $(this).sortable('toArray');
      result='';
      for(item in el_Array)
      {
        result += getIdInClasses( $('#'+el_Array[item]) )+',';
      }
      $.ajax({
        type: "POST",
        url: "<?php echo url_for('synonym/editOrder?table='.$table.'&rid='.$eid); ?>",
        data: { order: result, synonym_type: $(this).parent().attr('alt') }
      });
    }
  });

});
</script>
