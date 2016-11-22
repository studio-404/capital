

/*
  $(document).ready(function() {



    function setHeight() {
      windowHeight = $(window).innerHeight();
      $('.resizeDiv').css('min-height', windowHeight);
    };
    setHeight();
    
    $(window).resize(function() {
      setHeight();
    });
  });
*/
 
$(document).ready(function(){

    "use strict";

    var toggles = document.querySelectorAll(".c-hamburger");

    for (var i = toggles.length - 1; i >= 0; i--) {
      var toggle = toggles[i];
      toggleHandler(toggle);
    };

    function toggleHandler(toggle) {
      toggle.addEventListener( "click", function(e) {
        e.preventDefault();
        (this.classList.contains("is-active") === true) ? this.classList.remove("is-active") : this.classList.add("is-active");
      });
    }

  });

$(function() {
  $('#HomeMenu a[href^="/' + location.pathname.split("/")[1] + '"]').addClass('active');
});
 
/*
Material Design Modal Open
*/
$(document).ready(function(){
   $('#HomeMenu a').on('click', function(){
      $('a.active').removeClass('active');
      $(this).addClass('active');
   }); 

   $('#menu li a').on('click', function(){
      $('li.active').removeClass('active');
      $(this).addClass('active');
   });

    $('.OpenModalClick').leanModal();
});


/*
Material Design Selector
*/
$(document).ready(function() {
    $('select').material_select(); 
});


/*
Responsive Menu
*/
$(document).ready(function(){
    $('.nav_bar').click(function(){
        $('.navigation').toggleClass('visible');
        $('body').toggleClass('BodyOpacity');
    });
  $('.MenuCloseClick').click(function(){
        $('.navigation').removeClass('visible');
        $('body').removeClass('BodyOpacity');
    });
  $(".MenuCloseClick2").click(function() {
    $('.navigation').removeClass('visible');
        $('body').removeClass('BodyOpacity');
    $('html, body').animate({
      scrollTop: $("body").offset().top
    }, 1000);
  });
});

$('body').on("click", function (ev) {
   $('body').removeClass('visible');
});




// The following example creates complex markers to indicate beaches near
// Sydney, NSW, Australia. Note that the anchor is set to (0,32) to correspond
// to the base of the flagpole.

function initMap() {

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: {lat: 41.7072608, lng: 45.0963375},
    scrollwheel: false
  });

  setMarkers(map);
}

// Data for the markers consisting of a name, a LatLng and a zIndex for the
// order in which these markers should display on top of each other.
var beaches = [
  ['Tbilisi', 41.7323742, 44.6987698, 4],
  ['Tbilisi', 41.7072608, 45.0963375, 5],
  ['Tbilisi', 41.6174901, 45.2686856, 5]
];

function setMarkers(map) {
  // Adds markers to the map.

  // Marker sizes are expressed as a Size of X,Y where the origin of the image
  // (0,0) is located in the top left of the image.

  // Origins, anchor positions and coordinates of the marker increase in the X
  // direction to the right and in the Y direction down.
  var image = {
    url: '../img/map.png',
    // This marker is 20 pixels wide by 32 pixels high.
     
  };
  // Shapes define the clickable region of the icon. The type defines an HTML
  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
  // The final coordinate closes the poly by connecting to the first coordinate.
  var shape = {
    coords: [1, 1, 1, 20, 18, 20, 18, 1],
    type: 'poly'
  };
  for (var i = 0; i < beaches.length; i++) {
    var beach = beaches[i];
    var marker = new google.maps.Marker({
      position: {lat: beach[1], lng: beach[2]},
      map: map,
      icon: image,
      shape: shape,
      title: beach[0],
      zIndex: beach[3]
    });
  }
}










if (document.documentElement.clientWidth > 900) {

    $(function(){
        var windowH = $(window).height();
        var wrapperH = $('.height100').height();
        if(windowH > wrapperH) {                            
            $('.height100').css({'height':($(window).height())+'px'});
        }                                                                               
        $(window).resize(function(){
            var windowH = $(window).height();
            var wrapperH = $('.height100').height();
            var differenceH = windowH - wrapperH;
            var newH = wrapperH + differenceH;
            var truecontentH = $('.height100').height();
            if(windowH > truecontentH) {
                $('.height100').css('height', (newH)+'px');
            }

        })          
    });

}

 




$(document).ready(function() {
    $('#ShowCurrency').click(function() {
        $('.CurrencyDiv').slideToggle("fast");
    });
});








(function ($) {
    "use strict";
    function centerModal() {
        $(this).css('display', 'block');
        var $dialog  = $(this).find(".modal"),
        offset       = ($(window).height() - $dialog.height()) / 2,
        bottomMargin = parseInt($dialog.css('marginBottom'), 10);

        // Make sure you don't hide the top part of the modal w/ a negative margin if it's longer than the screen height, and keep the margin equal to the bottom margin of the modal
        if(offset < bottomMargin) offset = bottomMargin;
        $dialog.css("margin-top", offset);
    }

    $(document).on('show.bs.modal', '.modal', centerModal);
    $(window).on("resize", function () {
        $('.modal:visible').each(centerModal);
    });
}(jQuery));



 


















