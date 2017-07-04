<table class="table table-hover">
	<tbody>
		<?php foreach ($rows as $row): ?>
		<tr>
		<td> <?php echo $row->id ?> </td>
		<td> <?php echo $row->name ?> </td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>