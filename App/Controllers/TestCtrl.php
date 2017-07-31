<?php

namespace App\Controllers;

use System\Core\Controller;

class TestCtrl extends Controller
{

    public function index()
    {
        $excel = $this->response->withHeader('Content-type', 'application/vnd.ms-excel');
        $excel = $excel->withHeader('Content-Disposition', 'attachment; filename=data.xls');
        $data = <<<EOF
                <table id="data-table" class="table table-striped table-hover table-bodered dataTable no-footer" role="grid" aria-describedby="data-table_info" style="width: 1140px;">
<thead><tr role="row"><th class="sorting_disabled" rowspan="1" colspan="1" aria-label="No." style="width: 63px;">No.</th><th class="sorting" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Thành viên: activate to sort column ascending" style="width: 205px;">Thành viên</th><th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Họ và tên" style="width: 279px;">Họ và tên</th><th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Số điện thoại" style="width: 197px;">Số điện thoại</th><th class="sorting_desc" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Tổng số tin đăng: activate to sort column ascending" style="width: 272px;" aria-sort="descending">Tổng số tin đăng</th></tr></thead><tbody><tr role="row" class="odd"><td>1</td><td>Ms.Thao</td><td>SevenGroup</td><td>0911868800</td><td class="sorting_1">145</td></tr><tr role="row" class="even"><td>2</td><td>tuanhaivp92</td><td>Nguyễn Tuấn Hải</td><td>0966723370</td><td class="sorting_1">108</td></tr><tr role="row" class="odd"><td>3</td><td>TruongHang</td><td>Trương Hằng</td><td>0976456111</td><td class="sorting_1">103</td></tr><tr role="row" class="even"><td>4</td><td>ThienPhucLand</td><td>Thiên Phúc Land</td><td>0911868793</td><td class="sorting_1">85</td></tr><tr role="row" class="odd"><td>5</td><td>batdongsan361</td><td></td><td></td><td class="sorting_1">55</td></tr><tr role="row" class="even"><td>6</td><td>Tungchu</td><td>chử mạnh tùng</td><td>0974045797</td><td class="sorting_1">51</td></tr><tr role="row" class="odd"><td>7</td><td>hoahoa0893</td><td>Thanh Hoa</td><td>0903253639</td><td class="sorting_1">43</td></tr><tr role="row" class="even"><td>8</td><td>nguyenthilananh</td><td>Nguyễn Thị Lan Anh</td><td>0979099400</td><td class="sorting_1">42</td></tr><tr role="row" class="odd"><td>9</td><td>NguyenThai</td><td>Nguyễn Văn Thái</td><td>0976180495</td><td class="sorting_1">36</td></tr><tr role="row" class="even"><td>10</td><td>Namdatxanh</td><td>Nguyen Dinh Nam</td><td>01627991111</td><td class="sorting_1">36</td></tr></tbody></table>
EOF;
        $excel->write($data);
        return $excel;
    }

}
