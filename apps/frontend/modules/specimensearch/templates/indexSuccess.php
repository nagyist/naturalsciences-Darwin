<?php slot('title', __('Search Specimens'));  ?>  

<?php include_partial('widgets/list', array('widgets' => $widgets, 'category' => 'specimensearch')); ?>      
<div class="encoding">
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<div class="page" id="search_div">
<!--  <div class="check_right hidden" id="back_button"> 
    <input type="submit" name="back" id="back_to_search" value="<?php echo __('Back'); ?>" class="search_submit">
  </div>   -->
  <h1 id="title"><?php echo __('Specimens Search');?></h1>
  <form id="specimen_filter" action="specimensearch/searchResult" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <div class="panel encod_screen" id="intro">
      <input id="fields_to_show" type="hidden" name="fields_to_show" value="<?php echo $fields ;?>">
      <?php include_partial('widgets/screen', array(
        'widgets' => $widgets,
        'category' => 'specimensearchwidget',
        'columns' => 2,
        'options' => array('form' => $form),
      )); ?>  
      <p class="clear"> </p>
		  <p class="form_buttons">
        <div class="check_right"> 
          <input type="submit" name="submit" id="submit" value="<?php echo __('Search'); ?>" class="search_submit">
        </div>
    </div>      
   <div class="check_right" id="save_button"> 
    <input type="button" name="save" id="save_search" value="<?php echo __('Save this search'); ?>" class="save_search">
  </div>   
  </form>
</div>
</div>
