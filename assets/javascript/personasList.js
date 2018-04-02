/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$(".pag-link").click(function(event) {
    event.preventDefault();
    $("#form-busquedaAvanzada").attr('action', $(this).attr('href'));
    $("#form-busquedaAvanzada").submit();
});