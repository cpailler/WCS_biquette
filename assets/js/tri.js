import $ from "jquery";

// tri par type de velo
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

// tri par palier de points
$(document).ready(function(){
    $('.points').change(function(){
        var selectedValue = $(this).val();

        console.log(selectedValue);

        $('.pts-velo').each(function() {
            var pointsVelo = $(this).val();
            $(this).parent().show();

            if((pointsVelo > 249) && (selectedValue == 'area1')) {
                console.log(pointsVelo);
                $(this).parent().hide();
            } else if(((pointsVelo < 250) || (pointsVelo > 499)) && (selectedValue == 'area2'))
            {
                console.log(pointsVelo);
                $(this).parent().hide();
            } else if(((pointsVelo < 500) || (pointsVelo > 749)) && (selectedValue == 'area3'))
            {
                console.log(pointsVelo);
                $(this).parent().hide();
            } else if(((pointsVelo < 750) || (pointsVelo > 999)) && (selectedValue == 'area4'))
            {
                console.log(pointsVelo);
                $(this).parent().hide();
            } else if((pointsVelo < 1000) && (selectedValue == 'area5'))
            {
                console.log(pointsVelo);
                $(this).parent().hide();
            }
        });
    });
});

// tri / pagination
(function($) {
    $(document).ready(function(){
        $.fn.customPaginate = function(options)
        {
            var default = {
                itmesPerPage : 5
            }

            var settings = {};

            $.extends(settings,);
        }
    });
});
