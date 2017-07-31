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
                url: '/ajax/members'
            },
            columnDefs: [
                {title: "No.", orderable: false, targets: 0},
                {title: "Thành viên", targets: 1},
                {title: "Họ và tên", orderable: false, targets: 2},
                {title: "Số điện thoại", orderable: false, targets: 3},
                {title: "Tổng số tin đăng", targets: 4}
            ],
            order: [[4, 'desc']]
        });

    });
</script>
<table id="data-table" class="table table-striped table-hover table-bodered">
</table>

