<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>


<form method="post" class="form-group">
	<label for="contain"> Tin đăng </label>
	<div class="form-group form-inline">
		<input type="text" class="form-control datepicker" name="old"  value="<?php echo $old ?>">
	</div>

	<label for="contain"> Cập nhật đến </label>
	<div class="form-group form-inline">
		<input type="text" class="form-control datepicker" name="new"  value="<?php echo $new ?>">
	</div>

	<label for="contain"> Loại tin </label>
	<div class="form-group form-inline">
		<input type="checkbox" checked="true" name="type[customer]" /> Khách đăng
		<input type="checkbox" checked="true" name="type[cms]" /> Quản trị đăng
	</div>

	<button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> SET </button>
</form>



