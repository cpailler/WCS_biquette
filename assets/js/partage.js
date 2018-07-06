import $ from "jquery";

$('.dateclic').on('change', function () {

    var date1 = $('#app_bundle_reservation_type_debut').val();
    var date2 = $('#app_bundle_reservation_type_fin').val();
    if (date1 == 'undefined' || date2 == 'undefined') {
        $('#nuite').val(0);
    }
    else {


        // First we split the values to arrays date1[0] is the year, [1] the month and [2] the day
        date1 = date1.split('-');
        date2 = date2.split('-');

        // Now we convert the array to a Date object, which has several helpful methods
        date1 = new Date(date1[0], date1[1], date1[2]);
        date2 = new Date(date2[0], date2[1], date2[2]);

        // We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)
        var date1_unixtime = parseInt(date1.getTime() / 1000);
        var date2_unixtime = parseInt(date2.getTime() / 1000);

        // This is the calculated difference in seconds
        var timeDifference = (date2_unixtime - date1_unixtime);

        // in Hours
        var timeDifferenceInHours = timeDifference / 60 / 60;

        // and finaly, in days :)
        var timeDifferenceInDays = timeDifferenceInHours / 24;
        if (timeDifferenceInDays <= 0) {
            $('#nbJours').replaceWith(`<h4 id="nbJours">Jours :<span class="badge badge-light">0</span></h4>`);
        } else {
            $('#nbJours').replaceWith(`<h4 id="nbJours"><span  class="badge badge-light">${timeDifferenceInDays} Jours</span></h4>`);


            var points = $('#points').html();
            var pointsCount = ((timeDifferenceInDays * points)*(-1));
            $('#nbPoints').replaceWith(`<h4 id="nbPoints"><span  class="badge badge-light">${pointsCount}PTS</span></h4>`);

            var totalPoints = pointsCount;
            $('#totalPoints').replaceWith(`<h4 id="totalPoints"><span  class="badge badge-light">${totalPoints}PTS</span></h4>`);

            var totalAssurance = (timeDifferenceInDays * 1);
            $('#totalAssurance').replaceWith(`<h4 id="totalAssurance"><span  class="badge badge-light">${totalAssurance}€</span></h4>`);

            var partCaution = $('#partCaution').html();
            var totalEuros = parseInt(partCaution) + parseInt(totalAssurance);
            $('#totalEuros').replaceWith(`<h4 id="totalEuros"><span  class="badge badge-light">${totalEuros}€</span></h4>`);
            console.log(totalEuros);

        }







    }
});