var Config = {
  website: "http://capital.404.ge/",
  ajax:"http://capital.404.ge/ajax/index", 
  pleaseWait:"მოთხოვნა იგზავნება..."
};

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

	// $('#HomeMenu').find('.active').removeClass('active');
	

$(document).ready(function(){

    "use strict";
	$('#HomeMenu').find('.active').removeClass('active');
$('#HomeMenu a[href="'+window.location.href.split('/')[3]+'"]').addClass('active');
	
	
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

  $(window).on('hashchange', function(e){
	$('#HomeMenu').find('.active').removeClass('active');
	$('#HomeMenu a[href="'+window.location.href.split('/')[3]+'"]').addClass('active');
	
});

// $(function() {
	
  // $('#HomeMenu a[href="' + location.pathname.split("/")[3] + '"]').addClass('active');
  
// });
 
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


function setMarkers(map, beaches) {
  var image = {
    url: Config.website + 'public/img/map.png',
  };
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

/* gio functions */
var makeStatement = function(){
  var form = $("#loanForm");
  var serial = form.serialize();

  var ajaxFile = "/makeStatement";
  $.ajax({
      method: "POST",
      url: Config.ajax + ajaxFile,
      data: { formData:serial }
    }).done(function( msg ) {
      var obj = $.parseJSON(msg);
      if(obj.Error.Code==1){
        $(".modal-message-box").html(obj.Error.Text);
      }else if(obj.Success.Code==1){
        $(".modal-message-box").html(obj.Success.Text);
        $("#loanForm input[type='text']").each(function(){
          $(this).val('');
        });
      }else{
        $(".modal-message-box").html("E");
      }
  });
};

var calculate = function(){
  var persent = parseInt($("#loan-type").val()); // persent
  var money = parseInt($("#loan-money").val());
  var period = parseInt($("#loan-period").val());

  var calc = (money * persent) / 100;
  var totalMoney = calc + money;
  var moneyBillInMonth = totalMoney / period;
  console.log(totalMoney + " " +moneyBillInMonth);
  $("#total-money span").text(totalMoney.toFixed(2)); 
  $("#month-bill span").text(moneyBillInMonth.toFixed(2)); 
};

var fireChangeType = function(v){
  $("#loan-type").val(v);
}