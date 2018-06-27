import $ from "jquery";

function initAutocomplete() {
    // Create the search box and link it to the UI element.
    var input = document.getElementById('search-city');
    var searchBox = new google.maps.places.SearchBox(input);
}