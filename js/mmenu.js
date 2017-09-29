$(document).ready(function() {
      $("#my-menu").mmenu({
         // options
      }, {
         // configuration
         offCanvas: {
            pageSelector: "#myPage"
         }
      });
      
   });

 var $menu = $("#my-menu").mmenu({
   //   options
});
var $icon = $("#my-icon");
var API = $menu.data( "mmenu" );

$icon.on( "click", function() {
   API.open();
});

API.bind( "open:finish", function() {
   setTimeout(function() {
      $icon.addClass( "is-active" );
   }, 100);
});
API.bind( "close:finish", function() {
   setTimeout(function() {
      $icon.removeClass( "is-active" );
   }, 100);
});