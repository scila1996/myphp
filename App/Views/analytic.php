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
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/Vietnamese.json'
            },
            ajax: {
                url: '/ajax/lands'
            },
            columnDefs: [
                {title: "No.", orderable: false, targets: 0},
                {title: "Tiêu đề", render: function (data) {
                        return '<a href=\"' + data.link + '\" target="_blank">' + data.text + '</a>';
                    }, targets: 1},
                {title: "Thời hạn tin", render: function (data) {
                        return data['start'] + ' <span class="fa fa-arrows-h"></span> ' + data['finish'];
                    }, targets: 2},
                {title: "Người đăng", orderable: false, targets: 3},
                {title: "Số điện thoại", orderable: false, targets: 4},
                {title: "Loại", render: function (data) {
                        return '<span class="text-info">' + data + '</span>';
                    }, orderable: false, targets: 5}
            ],
            order: [[2, 'desc']]
        });

        $('#data-table input.search-date').on('change', function () {
            table.columns(2).search($(this).val()).draw();
        });

        $('#data-table select.search-member-type').on('change', function () {
            //alert('123');
            table.columns(5).search($(this).val()).draw();
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
                    <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                    <input type="text" class="form-control datepicker search-date" placeholder="Tìm theo ngày">
                </div>
            </td>
            <td></td>
            <td></td>
            <td>
                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-user"></span></span>
                    <select class="form-control search-member-type">
                        <option value="0">Tất cả</option>
                        <option value="1">Khách</option>
                        <option value="2">Thành viên</option>
                        <option value="3">Quản trị viên</option>
                    </select>
                </div>
            </td>
        </tr>
    </tfoot>
</table>

