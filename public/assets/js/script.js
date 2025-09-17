  /*====================================
                                                                                                fancybox js
                                                                                                =====================================*/
  $(".fancybox").fancybox({});

  // Preloader
  $("#preloader").delay("10").fadeOut(2000);
  setTimeout(page_anim_remove_preloader, "11000");

  function page_anim_remove_preloader() {
      $("#preloader").remove();
  }

  // number count for stats, using jQuery animate

  $('.counting').each(function() {
      var $this = $(this),
          countTo = $this.attr('data-count');

      $({ countNum: $this.text() }).animate({
              countNum: countTo
          },

          {

              duration: 3000,
              easing: 'linear',
              step: function() {
                  $this.text(Math.floor(this.countNum));
              },
              complete: function() {
                  $this.text(this.countNum);
                  //alert('finished');
              }

          });


  });


  // number count for stats, using jQuery animate

  /*====================================
      Counter
      =====================================*/
  $(".count").each(function() {
      $(this)
          .prop("Counter", 0)
          .animate({
              Counter: $(this).text(),
          }, {
              duration: 4000,
              easing: "swing",
              step: function(now) {
                  $(this).text(Math.ceil(now));
              },
          });
  });




  /*--- Folio Silder ---*/
  if ($(".rankers_package_slider").length > 0) {
      $('.rankers_package_slider').owlCarousel({
          loop: false,
          // margin: 30,
          responsiveClass: true,
          dots: false,
          autoplay: true,
          smartSpeed: 700,
          animateIn: 'slideInLeft',
          animateOut: 'slideOutRight',
          nav: true,
          navText: ['<i class="fas fa-arrow-left fa-fw"></i>', '<i class="fas fa-arrow-right fa-fw"></i>'],
          items: 4,
          responsive: {
              0: {
                  items: 1
              },
              760: {
                  items: 1
              },
              991: {
                  items: 2
              },
              1600: {
                  items: 4
              },
          }
      });
  }

  $(document).ready(function() {
    $('.schools_slider').owlCarousel({

        loop: true,
        margin: 15,
        nav: false,
        autoplay: true,
        dots: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4

            }
        }
    });

});
  /*--testimonial-slider  ---*/

  $('.testimonial-slider ').owlCarousel({
      loop: false,
      margin: 30,
      responsiveClass: true,
      dots: false,
      autoplay: true,
      smartSpeed: 700,
      animateIn: 'slideInLeft',
      animateOut: 'slideOutRight',
      nav: true,
      navText: ['<i class="fas fa-arrow-left fa-fw"></i>', '<i class="fas fa-arrow-right fa-fw"></i>'],
      items: 4,
      responsive: {
          0: {
              items: 1
          },
          760: {
              items: 2
          },
          1023: {
              items: 2
          },

      }
  });



  $('.video_session_slider').owlCarousel({
    loop: true,
    responsiveClass: true,
    nav: true,
    margin: 0,    
    autoplayTimeout: 4000,
    smartSpeed: 400,
    center: true,
    navText: ['<i class="fas fa-arrow-left fa-fw"></i>', '<i class="fas fa-arrow-right fa-fw"></i>'],
    items: 4,
    responsive: {
        0: {
            items: 1
        },
        760: {
            items: 2
        },
        1023: {
            items: 3
        },

    }
});


  $('.app_slider').owlCarousel({
    loop: true,
    autoplay: true,
    responsiveClass: true,
    dots:true,
    smartSpeed: 700,
    nav: false,
    margin: 0,   
    autoplayTimeout: 4000,
    center: true,
    navText: ['<i class="fas fa-arrow-left fa-fw"></i>', '<i class="fas fa-arrow-right fa-fw"></i>'],
    items: 4,
    responsive: {
        0: {
            items: 1
        },
        760: {
            items: 2
        },
        1023: {
            items: 3
        },

    }
});



  $('.coaching_system_slider ').owlCarousel({
      loop: true,

      // margin: 30,
      responsiveClass: true,
      autoplay: true,
      dots: false,
      smartSpeed: 700,
      animateIn: 'slideInLeft',
      animateOut: 'slideOutRight',
      nav: true,
      navText: ['<i class="fas fa-arrow-left fa-fw"></i>', '<i class="fas fa-arrow-right fa-fw"></i>'],
      items: 4,
      responsive: {
          0: {
              items: 1
          },
          760: {
              items: 2
          },
          1023: {
              items: 4
          },

      }
  });

  $('.our_achievers_slider').owlCarousel({
      loop: true,
      // margin: 30,
      autoplay: true,
      responsiveClass: true,
      dots: false,
      smartSpeed: 700,
      nav: true,
      navText: ['<i class="fas fa-arrow-left fa-fw"></i>', '<i class="fas fa-arrow-right fa-fw"></i>'],
      items: 1,

  });


  $('.testimonial_slider').owlCarousel({
    loop: true,
    // margin: 30,
    autoplay: true,
    responsiveClass: true,
    dots:true,
    smartSpeed: 700,
    nav: false,
    navText: ['<i class="fas fa-arrow-left fa-fw"></i>', '<i class="fas fa-arrow-right fa-fw"></i>'],
    items: 1,

});

  /*====================================
    Isotope Filter
    =====================================*/




  $(".grid").isotope({
      itemSelector: ".grid-item",
      filter: defaultGrid
  });

  // $('.grid').isotope('reLayout');
  // filter items on button click
  $(".filter-button-group").on("click", "li", function() {
      var filterValue = $(this).attr("data-filter");
      $(".grid").isotope({ filter: filterValue });
      $(".filter-button-group li").removeClass("active");
      $(this).addClass("active");
  });
  /*====================================
  fancybox js
  =====================================*/


  // var card = $(".slider-img");

  // $(document).on("mousemove", function (e) {
  //     var ax = -($(window).innerWidth() / 2 - e.pageX) / 20;
  //     var ay = ($(window).innerHeight() / 2 - e.pageY) / 10;
  //     card.attr("style", "transform: rotateY(" + ax + "deg) rotateX(" + ay + "deg);-webkit-transform: rotateY(" + ax + "deg) rotateX(" + ay + "deg);-moz-transform: rotateY(" + ax + "deg) rotateX(" + ay + "deg)");
  // });



  /*====================================
      Scroll To Top 
      =====================================*/

  var btn = $(".back-to-top");

  $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
          btn.addClass("show");
      } else {
          btn.removeClass("show");
      }
  });

  btn.on("click", function(e) {
      e.preventDefault();
      $("html, body").animate({ scrollTop: 0 }, "300");
  });

  /*====================================
    Preloader
    =====================================*/

  $("#preloader").delay("10").fadeOut(2000);
  setTimeout(page_anim_remove_preloader, "11000");

  function page_anim_remove_preloader() {
      $("#preloader").remove();
  }


  $(window).scroll(function() {
    $(window).scrollTop();
    if ($(window).scrollTop() > 600) {
        $(".mini_header").addClass("navbar-fixed");
    }
    if ($(window).scrollTop() < 1) {
        $(".mini_header").removeClass("navbar-fixed");
    }
});

  /*====================================
       Sticky Menu
   =====================================*/




  $(window).scroll(function() {
      $(window).scrollTop();
      if ($(window).scrollTop() > 0) {
          $(".navbar").addClass("navbar-fixed");
      }
      if ($(window).scrollTop() < 1) {
          $(".navbar").removeClass("navbar-fixed");
      }
  });

  $(document).ready(function() {
      "use strict";
      var c,
          currentScrollTop = 1,
          navbar = $(".navbar");

      $(window).scroll(function() {
          var a = $(window).scrollTop();
          var b = navbar.height();

          currentScrollTop = a;

          if (c < currentScrollTop && a > b + b) {
              navbar.addClass("scrollUp");
          } else if (c > currentScrollTop && !(a <= b)) {
              navbar.removeClass("scrollUp");
          }

          c = currentScrollTop;
      });
  });