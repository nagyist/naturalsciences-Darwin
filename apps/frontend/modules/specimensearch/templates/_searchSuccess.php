<div>
      <?php if($is_specimen_search):?>
        <input type="hidden" name="spec_search" value="<?php echo $is_specimen_search;?>" />
      <?php endif;?>
  <?php if(isset($specimensearch) && $specimensearch->count() != 0 && isset($orderBy) && isset($orderDir) && isset($currentPage)):?>   
    <?php
      if($orderDir=='asc')
        $orderSign = '<span class="order_sign_down">&nbsp;&#9660;</span>';
      else
        $orderSign = '<span class="order_sign_up">&nbsp;&#9650;</span>';
    ?>
    <?php include_partial('global/pager', array('pagerLayout' => $pagerLayout)); ?>
    <?php include_partial('global/pager_info', array('form' => $form, 'pagerLayout' => $pagerLayout)); ?>
      <ul class="sf-menu column_menu">
        <li class="head"><?php echo __('Choose columns to display') ; ?><br/><?php echo image_tag('column_display_expand.png', array('id'=>'column_display_expand','alt' => __('expand'))) ; ?>
          <ul>
            <?php
            $cols = array(
              'category' => array(
                'category',
                __('Category'),),
              'collection' => array(
                'collection_name',
                __('Collection'),),
              'taxon' => array(
                'taxon_name_order_by',
                __('Taxon'),),
              'type' => array(
                'with_types',
                __('Type'),),
              'gtu' => array( ///
                false,
                __('Sampling locations'),),
              'codes' => array( ///
                false,
                __('Codes'),),
              'chrono' => array(
                'chrono_name_order_by',
                __('Chronostratigraphic unit'),),
              'litho' => array(
                'litho_name_order_by',
                __('Lithostratigraphic unit'),),
              'lithologic' => array(
                'lithologic_name_order_by',
                __('Lithologic unit'),),
              'mineral' => array(
                'mineral_name_order_by',
                __('Mineralogic unit'),),
              'expedition' => array(
                'expedition_name_indexed',
                __('Expedition'),),
              'count' => array(
                'specimen_count_max',
                __('Count'),),
            );
            foreach($cols as $col_name => $col):?>
              <li class="<?php echo $field_to_show[$col_name]; ?>" id="li_<?php echo $col_name;?>">
                <span class="<?php echo($field_to_show[$col_name]=='uncheck'?'hidden':''); ?>">&#10003;</span>
                <span class="<?php echo($field_to_show[$col_name]=='uncheck'?'':'hidden'); ?>">&#10007;</span>&nbsp;<?php echo $col[1];?>
              </li>
            <?php endforeach;?>
          </ul>
        </li>
      </ul>

      <?php echo $form->getValue('what_searched');?>
      <table class="spec_results">
        <thead>
          <tr>
            <th><!-- checkbox for selected when pinned --></th>
            <th><!-- + / - buttons  --></th>
            <th><!-- Pin -->
               <?php echo image_tag('white_pin_off.png', array('class'=>'top_pin_but pin_off','alt' =>  __('Un-Save this result'))) ; ?>
               <?php echo image_tag('white_pin_on.png', array('class'=>'top_pin_but pin_on', 'alt' =>  __('Save this result'))) ; ?>
            </th>
            <?php foreach($cols as $col_name => $col):?>
              <th class="col_<?php echo $col_name;?>">
                <?php if($col[0] != false):?>
                  <a class="sort" href="<?php echo url_for($s_url.'&orderby='.$col[0].( ($orderBy==$col[0] && $orderDir=='asc') ? '&orderdir=desc' : '').'&page='.
                    $currentPage);?>">
                    <?php echo $col[1];?>
                    <?php if($orderBy == $col[0]) echo $orderSign ?>
                  </a>
                <?php else:?>
                  <?php echo $col[1];?>
                <?php endif;?>
              </th>
            <?php endforeach;?>
            <th><!-- actions --></th>
          </tr>
        </thead>
        <?php foreach($specimensearch as $specimen):?>
          <?php include_partial('result_content_specimen', array('specimen' => $specimen, 'codes' => $codes, 'is_specimen_search' => $is_specimen_search)); ?>
        <?php endforeach;?>
      </table>

      <?php include_partial('global/pager', array('pagerLayout' => $pagerLayout)); ?>
    <?php else:?>
      <?php echo __('No Specimen Matching');?>
    <?php endif;?>
</div>  
<script type="text/javascript">
$(document).ready(function () {
  $('body').catalogue({},link=$('div.check_right').find('a.hidden').attr('href')); 
  o = {"dropShadows":false, "autoArrows":false,  "delay":400};
  $('ul.column_menu').superfish(o);

  $('ul.column_menu > li > ul > li').each(function(){
    hide_or_show($(this));
  });
  initIndividualColspan() ;
  $("ul.column_menu > li > ul > li").click(function(){
    update_list($(this));
    hide_or_show($(this));
  });
  
  /**PIN management **/
  $('.spec_results .pin_but').click(function(){
    if($(this).hasClass('pin_on'))
    {
      $(this).parent().find('.pin_off').removeClass('hidden'); 
      $(this).addClass('hidden') ;
      pin_status = 0;
    }
    else
    {
      $(this).parent().find('.pin_on').removeClass('hidden');
      $(this).addClass('hidden') ;
      pin_status = 1;
    }
    rid = getIdInClasses($(this).closest('tr'));
    $.get('<?php echo url_for('savesearch/pin');?>/id/' + rid + '/status/' + pin_status,function (html){});
  });

  if($('.spec_results tbody .pin_on').not('.hidden').length == $('.spec_results tbody .pin_on').length)
  {
      $('.top_pin_but').parent().find('.pin_on').removeClass('hidden');
      $('.top_pin_but').parent().find('.pin_off').addClass('hidden') ;
  }
  else
  {
      $('.top_pin_but').parent().find('.pin_off').removeClass('hidden');
      $('.top_pin_but').parent().find('.pin_on').addClass('hidden') ;
  }
  
  $('.spec_results .top_pin_but').click(function(){
    /** Multiple pin behavior ***/
    if($(this).hasClass('pin_on'))
    {
      $(this).parent().find('.pin_off').removeClass('hidden'); 
      $(this).addClass('hidden') ;
      pin_status = 0;
    }
    else
    {
      $(this).parent().find('.pin_on').removeClass('hidden');
      $(this).addClass('hidden') ;
      pin_status = 1;
    }
    pins = '';
    $('.spec_results tbody tr').not('.ind_row').each(function(){
      rid = getIdInClasses($(this));
      if(pins == '')
        pins = rid;
      else
        pins += ','+rid;
    });

    if(pin_status == 0)
    {
        $('.spec_results tbody tr .pin_off').removeClass('hidden');
        $('.spec_results tbody tr .pin_on').addClass('hidden') ;
    }
    else
    {
        $('.spec_results tbody tr .pin_off').addClass('hidden');
        $('.spec_results tbody tr .pin_on').removeClass('hidden') ;
    }
    $.get('<?php echo url_for('savesearch/pin');?>/mid/' + pins + '/status/' + pin_status,function (html){});
  }); 

});
</script>
