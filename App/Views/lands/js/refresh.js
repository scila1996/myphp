/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function News()
{
    var u = '/ajax/news';
    this.load = function ()
    {
        $.ajax({
            url: u,
            type: 'GET',
            dataType: 'json',
            async: false
        }).done(function (response) {
            console.log(response);
        });
    };
}

$(document).ready(function () {
    var news = new News();
    news.load();

});