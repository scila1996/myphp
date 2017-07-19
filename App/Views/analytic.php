<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" />
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>


<style>
	a:hover
	{
		text-decoration: none;
	}
</style>
<script>
	$(document).ready(function () {
		var table = $('#data-table').DataTable({
			serverSide: true,
			processing: true,
			searching: true,
			ajax: {
				url: '/ajax/table/<?php echo $table ?>'
			},
			columnDefs: [
				{title: "No.", orderable: false, targets: 0},
				{title: "Tiêu đề", targets: 1},
				{title: "Thời gian", targets: 2}
			]
		});

		$('#data-table input.search-date').on('change', function () {
			console.log($(this).val());
			table.columns(2).search($(this).val()).draw();
		});

	});
</script>
<table id="data-table" class="table table-striped table-hover table-bodered">
	<tfoot>
		<tr>
			<td></td>
			<td></td>
			<td>
				<div class="input-group">
					<input type="text" class="form-control datepicker search-date" placeholder="Tìm theo ngày">
					<span class="input-group-addon"><span class="fa fa-clock-o"></span>
				</div>
			</td>
		</tr>
	</tfoot>
</table>

