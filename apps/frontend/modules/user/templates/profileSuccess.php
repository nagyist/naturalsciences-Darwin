<?php slot('title', __('My Profile'));  ?>       
<?php include_partial('widgets/list', array('widgets' => $widgets, 'category' => 'users', 'eid' => $sf_user->getAttribute('db_user_id'))); ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<div class="page">
  <h1 class="edit_mode"><?php echo __("Edit My Profile");?></h1>
  <form class="edition" action="<?php echo url_for('user/profile') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <table>
  <tbody>
  <?php include_partial('profile', array('form' => $form)) ?>
  <?php if ($sf_user->getAttribute('db_user_type') > Users::ENCODER) : ?>
  <tr class="trusted_user_links">
    <td colspan="2">
	<a href="#" class="display_value">> <?php echo __('Show link with '.(isset($form['title'])?'people':'institution'));?> <</a>
	<a href="#" class="hide_value hidden">< <?php echo __('Hide link with '.(isset($form['title'])?'people':'institution'));?>  ></a>
    </td>
  </tr>
  <tr class="trusted_user hidden">
    <th><?php echo $form['people_id']->renderLabel('Reference to a '.isset($form['title'])?'People':'Institution') ?></th>
    <td class="trust_level_2">
      <?php echo $form['people_id']->renderError() ?>
      <?php echo $form['people_id'] ?>
    </td>
  </tr>
  <?php endif ?>
  <tr class="trusted_user_links">
    <td colspan="2">
	<a id="submit" href="<?php echo url_for('user/widget') ?>"><?php echo __('Edit your widgets');?></a>
    </td>
  </tr>
</tbody>
<tfoot>
  <tr>
    <td colspan="2">
      <?php echo $form->renderHiddenFields(false) ?>
      <a href="<?php echo url_for('@homepage') ?>"><?php echo __('Cancel');?></a>
      <input id="submit" type="submit" value="<?php echo __('Save');?>" />
    </td>
  </tr>
</tfoot>
 </table>
</form>

<script type="text/javascript">
$('.display_value').click(function(){
  $('.trusted_user').show();
  $(this).hide();
  $('.hide_value').show();
});

$('.hide_value').click(function(){
  $('.trusted_user').hide();
  $(this).hide();
  $('.display_value').show();
});
</script>
  <?php include_partial('widgets/screen', array(
	'widgets' => $widgets,
	'category' => 'userswidget',
	'columns' => 1,
	'options' => array('eid' => $form->getObject()->getId(), 'table' => 'users')
	)); ?>
</div>
