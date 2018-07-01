import $ from "jquery";

$(document).ready(function(){
    $('.velos').change(function(){
        var selectedValue = $(this).val();

        console.log(selectedValue);

        $('.type').each(function() {

            $(this).parent().show();

            if($(this).val() != selectedValue)
            {
                console.log($( this ).val());
                $(this).parent().hide();
            }
        });
    });
});


$(document).ready(function(){
    $('.points').change(function(){
        var selectedValue = $(this).val();

        console.log(selectedValue);

        $('.pts-velo').each(function() {

            $(this).parent().show();

            if(($(this).val() > 249) && (selectedValue == 'area1')) {
                console.log($( this ).val());
                $(this).parent().hide();
            } else if(($(this).val() < 250) && ($(this).val() > 499) && (selectedValue == 'area2'))
            {
                console.log($( this ).val());
                $(this).parent().hide();
            } else if(($(this).val() < 500) && ($(this).val() > 749) && (selectedValue == 'area3'))
            {
                console.log($( this ).val());
                $(this).parent().hide();
            } else if(($(this).val() < 750) && ($(this).val() > 999) && (selectedValue == 'area4'))
            {
                console.log($( this ).val());
                $(this).parent().hide();
            } else if(($(this).val() < 1000) && (selectedValue == 'area5'))
            {
                console.log($( this ).val());
                $(this).parent().hide();
            }
        });
    });
});