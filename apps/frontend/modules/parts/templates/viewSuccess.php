<?php slot('title', __('View specimen part'));  ?>
<?php include_partial('widgets/list', array('widgets' => $widgets, 'category' => 'part', 'table' => 'specimen_parts','eid'=> $specimen->getPartRef(),'view' => true)); ?>
<?php use_stylesheet('widgets.css') ?>
<?php use_javascript('widgets.js') ?>
<?php use_javascript('catalogue.js') ?>
<?php use_javascript('button_ref.js') ?>
<div class="page">
  <div class="tabs_view">
		<?php echo link_to(__('View Specimen'), 'specimen/view?id='.$specimen->getSpecRef(), array('class'=>'enabled', 'id' => 'tab_0'));?>  
    <?php echo link_to(__('Individual overview'), 'individuals/overview?spec_id='.$specimen->getSpecRef().'&view=true', array('id'=>'tab_1', 'class'=> 'enabled')); ?>
		<?php echo link_to(__('Part overview'), 'parts/overview?id='.$specimen->getIndividualRef()."&view=true", array('class'=>'enabled', 'id' => 'tab_2'));?>
    <a class="enabled selected" id="tab_3"> &lt; <?php echo sprintf(__('Part %d'),$specimen->getPartRef());?> &gt; </a>		
  </div>

  <div class="panel_view encod_screen edition" id="intro">
   <div>	
      <?php include_partial('widgets/screen', array(
        'widgets' => $widgets,
        'category' => 'partwidgetview',	
        'columns' => 2,	
        'options' => array('eid'=> $specimen->getPartRef(), 'level' => 2, 'view' => true),
      )); ?>
    </div>
    
    <p class="clear"></p>
    <p align="right">
      <?php if ($sf_user->isAtLeast(Users::ENCODER)): ?>
        <?php echo link_to(__('New Part'), 'part/edit?indid='.$specimen->getIndividualRef(), array('class' => 'bt_close')) ?>
       &nbsp;<?php echo link_to(__('Duplicate part'), 'part/edit?indid='.$specimen->getIndividualRef().
      '&duplicate_id='.$specimen->getPartRef(),array('class' => 'duplicate_link bt_close')) ?>
      <?php endif?>
      &nbsp;<a class="bt_close" href="<?php echo url_for('specimensearch/index') ?>" id="spec_cancel"><?php echo __('Back');?></a>
    </p>
  </div>
</div>
