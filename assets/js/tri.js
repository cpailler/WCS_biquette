import $ from "jquery";

$(document).ready(function(){
    $('.velos').change(function(){
        var selectedValue = $(this).val();

        $(".annonce").html(selectedValue);
    });
});