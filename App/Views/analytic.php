<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" />
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>

<div class="panel-group">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">
				<a data-toggle="collapse" href="#collapse1"><span class="fa fa-search"></span> Tìm kiếm </a>
			</div>
		</div>
		<div id="collapse1" class="panel-collapse collapse">
			<div class="panel-body">
				<form method="get" class="form-group">
					<label for="contain"> Thời gian </label>
					<div class="form-group form-inline">
						<input type="text" class="form-control datepicker" name="date" value="<?php echo $search_date ?>">
					</div>
					<button type="submit" class="btn btn-primary"> Search </button>
				</form>
			</div>
		</div>
	</div>
</div>
<style>
	a:hover
	{
		text-decoration: none;
	}
</style>
<script>
	$(document).ready(function (){
		$('#data-table').DataTable();
	});
</script>
<table id="data-table">
	<thead>
		<tr>
			<th> No. </th>
			<th> Name </th>
		</tr>
	</thead>
	<tbody>
		
	</tbody>
</table>
<?php
//echo $table;
