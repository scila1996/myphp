<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

<?php if ($message !== null): ?>
    <div class="alert alert-<?php echo $message["type"] ?>"> <?php echo $message["str"] ?> </div>
<?php endif; ?>

<form method="post" class="form-group">
    <label for="contain"> Tin đăng </label>
    <div class="form-group form-inline">
        <input type="text" class="form-control datepicker" name="old"  value="<?php echo $old ?>">
    </div>
    <label for="contain"> Loại tin </label>
    <div class="form-group form-inline">
        <input type="checkbox" checked="checked" name="type[]" value="customer" /> Khách đăng
        <input type="checkbox" checked="checked" name="type[]" value="cms" /> Quản trị đăng
    </div>
    <div class="form-group form-inline">
        <div class="input-group">
            <span class="input-group-addon"> Số tin </span>
            <input type="number" class="form-control" readonly id="count" />
        </div>
    </div>
    <hr />
    <label for="contain"> Cập nhật đến </label>
    <div class="form-group form-inline">
        <input type="text" class="form-control datepicker" name="new"  value="<?php echo $new ?>">
    </div>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> SET </button>
</form>

<script>
    $(document).ready(function () {
        $('form').on('submit', function (e, a) {
            if (a === undefined)
            {
                return true;
            }

            var data = $(this).serializeArray();
            console.log(data);
            $.ajax({
                url: '/update/count',
                method: 'get',
                async: false,
                data: data,
                dataType: 'json'
            }).success(function (r) {
                console.log(r);
                $('#count').val(r);
            });
            return false;
        });
        $('form [name]').on('change', function () {
            $(this).closest('form').trigger('submit', [1]);
        }).first().trigger('change');
    });
</script>

