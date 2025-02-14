<table class="catalogue_table_view">
<thead>
  <tr>
    <th><?php echo __('Target') ;?></th>
    <th><?php echo __('Type') ;?></th>
    <th><?php echo __('Title');?></th>
    <th><?php echo __('Details') ;?></th>
    <th><?php echo __('Person') ;?></th>
    <th><?php echo __('Date') ;?></th>
    <th><?php echo __('Has files') ;?></th>
    <th></th>
  </tr>
</thead>
<tbody>
  <?php foreach($maintenances as $item):?>
    <tr>
      <td>
        <?php if($item->getReferencedRelation() == 'loans'):?>
          <?php if($table == 'loans'):?>
            <?php echo __('Loans');?>
          <?php elseif($table.'loan_items'):?>
            <?php echo link_to(__("Loan"),'loan/view?id='.$item->getRecordId());?>
          <?php endif;?>
        <?php elseif($item->getReferencedRelation() == 'loan_items'):?>
          <?php if($table == 'loans'):?>
            <?php echo link_to(__("Item #%id%",array('%id%'=>$item->getRecordId())) ,'loanitem/view?id='.$item->getRecordId());?>
          <?php elseif($table.'loan_items'):?>
            <?php echo __('Loan Item');?>
          <?php endif;?>
        <?php endif;?>
      </td>
      <td><?php echo $item->getCategory();?></td>
      <td><?php echo $item->getActionObservation();?></td>
      <td><?php echo $item->getDescription();?></td>
      <td><?php echo $item->People->getFormatedName();?></td>
      <td><?php echo $item->getModificationDateTimeMasked(ESC_RAW);?></td>
      <td><?php if($item->getWithMultimedia()) echo image_tag('attach.png'); else echo '-';?></td>
      <td class="buttons">
        <?php echo link_to(image_tag('blue_eyel.png', array("title" => __("View"))),'maintenances/view?id='.$item->getId());?>
     </td>
    </tr>
  <?php endforeach;?>
</tbody>
</table>
