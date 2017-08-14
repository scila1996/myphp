/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function lands()
{
    var u = '/ajax/batdongsan';
    this.load = function ()
    {
        $.ajax({
            url: u,
            type: 'GET',
            dataType: 'json',
            async: false
        }).done(function (response) {
            var ul = $('#list ul');
            ul.empty();
            for (item in response)
            {
                item = response[item];
                ul.append("<li class=\"list-group-item\"><b class=\"text-success\">" + item.title + "</b> <b class=\"text-info\"> <span class=\"pull-right\"><span class=\"text-muted fa fa-phone\"></span> " + item.poster_mobile + "</span> </b></li>");
            }
            console.log(response);
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