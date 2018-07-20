import $ from "jquery";

const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);

$(document).ready(function () {
    console.log("ok, JQuery fonctionne !");
});

console.log('Bienvenue sur WebPack!');