<ul class="hidden error_list">
  <li></li>
</ul>
<div class="catalogue_ref"><?php echo $linkItem->getName();?></div>
<?php if($sf_params->get('type')=='rename'):?>
  <label class="catalogue_action_type"><?php echo __('is renamed in');?> :</label>
<?php else:?>
  <label class="catalogue_action_type"><?php echo __('is recombined from');?> :</label>
<?php endif;?>
<form method="post" action="<?php echo url_for('catalogue/SaveRelation?type='.($sf_params->get('type')=='rename'? 'rename': 'recombined') .'&table='.$sf_params->get('table').'&id='.$linkItem->getId());?>" class="renamed">
  <table class="bottom_actions">
    <tbody>
      <tr>
        <td>
          <input type="hidden" name="record_id_2" id="relation_catalogue_id" value="<?php echo $relation->getRecordId2(); ?>" />
        </td>
      </tr>
      <tr>
        <td>
          <input type="hidden" name="relation_id" value="<?php echo $relation->getId(); ?>"/>
        </td>
      </tr>
      <tr>
        <td>
          <div id="relation_catalogue_name" <?php if($remoteItem->getId()==0):?> class="hidden"> <?php else: ?>> <?php echo $remoteItem->getName();?><?php endif;?></div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="clear"> </div>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td>
          <a href="#" class="cancel_qtip">Cancel</a>
          <button id="modify" class="modify"><?php echo __('Modify');?></button>
          <button id="delete" class="delete" <?php if($remoteItem->getId()==0):?> style="display:none" <?php endif;?>><?php echo __('Delete');?></button>
          <input id="save" class="hidden save" type="submit" name="submit" value="<?php echo __('Save');?>" />
        </td>
      </tr>
    </tfoot>
  </table>
</form>

 <script type="text/javascript">
  $(document).ready(function () {
    $('.result_choose').live('click',function () {
	el = $(this).closest('tr');
	$("#relation_catalogue_id").val(getIdInClasses(el));
	$("#relation_catalogue_name").text(el.find('span.item_name').text()).show();
    });

    function addError(html)
    {
      $('.error_list li').text(html);
      $('.error_list').show();
    }
    function removeError()
    {
	$('.error_list').hide();
	$('.error_list li').text(' ');
    }
      $(".renamed").submit(function()
      {
	removeError();
	$.ajax({
	  type: "POST",
	  url: $('.renamed').attr('action'),
	  data: $('.renamed').serialize(),
	  success: function(html){
	    if(html == "ok" )
	    {
	     $('.qtip-button').click();
	    }
	    else
	    {
	      addError(html);
	    }
	  },
	  error: function(xhr)
	  {
	    addError('Error!  Status = ' + xhr.status);
	  }});
	return false;
      });

      $(".delete").click(function()
      {
	if(confirm('<?php echo __('Are you sure?');?>'))
	{
	  removeError();
	  $.ajax({
	    url: '<?php echo url_for('catalogue/deleteRelation?relid='.$relation->getId())?>',
	    success: function(html){
	      if(html == "ok" )
	      {
		$('.qtip-button').click();
	      }
	      else
	      {
		addError(html);
	      }
	    },
	    error: function(xhr)
	    {
	      addError('Error!  Status = ' + xhr.status);
	    }});
	  }
	return false;
      });

      $(".modify").click(function()
      {
	$(this).hide();
	$(".search_box").show();
	$(".save").show();
	return false;
      });      
  }); 
  </script>
<div class="search_box show">
  <?php include_partial('catalogue/chooseItem', array('searchForm' => $searchForm,'is_choose'=>true)) ?>
</div>