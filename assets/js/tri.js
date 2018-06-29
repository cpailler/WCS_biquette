import $ from "jquery";

$(document).ready(function(){
    $('.velos').change(function(){
        var selectedValue = $(this).val();

        console.log(selectedValue);

        $('.type').each(function() {

            $(this).parent().show();

            if($( this ).val() != selectedValue)
            {
                console.log($( this ).val());
                $(this).parent().hide();
            }
        });
    });
});

