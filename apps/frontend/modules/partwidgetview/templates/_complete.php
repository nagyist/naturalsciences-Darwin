<table class="catalogue_table_view">
  <tr>
	<th class="top_aligned"><?php echo __("Status");?></th>
	<td><?php echo $part->getSpecimenStatus() ?></td>
  </tr>
  <tr>
	<th><?php echo ("Complete ? ");?></th>
	<td><?php echo ($part->getcomplete()?__("Yes"):__("No")) ; ?></td>
  </tr>
</table>
