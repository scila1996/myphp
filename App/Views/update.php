<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

<?php if ($message): ?>
    <div class="<?= "alert alert-{$message['type']}" ?>"> <?= $message["str"] ?> </div>
<?php endif; ?>

<form method="post" class="form-group">
    <label for="contain"> Tin đăng </label>
    <div class="form-group form-inline">
        <input type="text" class="form-control datepicker" name="day" value="<?= $day ?>" />
    </div>
    <label for="contain"> Loại tin </label>
    <div class="form-group form-inline">
        <select class="form-control" name="type">
            <option value="0">Tất cả</option>
            <option value="1">Khách</option>
            <option value="2">Thành viên</option>
            <option value="3">Quản trị viên</option>
        </select>
    </div>
    <hr />
    <label for="contain"> Tăng số ngày hết hạn </label>
    <div class="form-group form-inline">
        <input class="form-control" type="number" name="add" value="30" />
    </div>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> SET </button>
</form>
