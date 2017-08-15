/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function lands()
{
    var u = '/html/batdongsan';
    var i = 1;
    this.load = function ()
    {
        if (i++ >= 10)
        {
            i = 1;
        }
        $.ajax({
            url: u + '/' + i,
            type: 'GET',
            dataType: 'html',
            async: false
        }).done(function (response) {
            var area = $('#data');
            area.empty();
            area.html(response);
        });
    }
}

$(document).ready(function () {
    var obj = new lands();
    obj.load();

    setInterval(function () {
        obj.load();
    }, 10000);

});