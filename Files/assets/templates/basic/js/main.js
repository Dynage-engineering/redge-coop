'use strict';

$('table td[colspan]').addClass('justify-content-center text-center');

// menu options custom affix
var fixed_top = $(".header");
$(window).on("scroll", function () {
  if ($(window).scrollTop() > 50) {
    fixed_top.addClass("animated fadeInDown menu-fixed");
  }
  else {
    fixed_top.removeClass("animated fadeInDown menu-fixed");
  }
});

function showAmount(number) {
  var str = number.toString().split(".");
  str[0] = str[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  return str.join(".");
}


function snakeCase(string) {
  return string.replace(/ /g, "_").toLowerCase();
};

function titleCase(string) {
  return string.replace("_", ' ').replace(/\w\S*/g, function (txt) { return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase(); });
};

// lightcase plugin init
$('a[data-rel^=lightcase]').lightcase();


// mobile menu js
$(".navbar-collapse>ul>li>a, .navbar-collapse ul.sub-menu>li>a").on("click", function () {
  const element = $(this).parent("li");
  if (element.hasClass("open")) {
    element.removeClass("open");
    element.find("li").removeClass("open");
  }
  else {
    element.addClass("open");
    element.siblings("li").removeClass("open");
    element.siblings("li").find("li").removeClass("open");
  }
});

//preloader js code
$(".preloader").delay(300).animate({
  "opacity": "0"
}, 300, function () {
  $(".preloader").css("display", "none");
});


// wow js init
new WOW().init();

// main wrapper calculator
var bodySelector = document.querySelector('body');
var header = document.querySelector('.header');
var footer = document.querySelector('.footer');
(function () {
  if (bodySelector.contains(header) && bodySelector.contains(footer)) {
    var headerHeight = document.querySelector('.header').clientHeight;
    var footerHeight = document.querySelector('.footer').clientHeight;

    // if header isn't fixed to top
    // var totalHeight = parseInt( headerHeight, 10 ) + parseInt( footerHeight, 10 ) + 'px'; 

    // if header is fixed to top
    var totalHeight = parseInt(footerHeight, 10) + 'px';
    var minHeight = '100vh';
    document.querySelector('.main-wrapper').style.minHeight = `calc(${minHeight} - ${totalHeight})`;
  }
})();

// Animate the scroll to top
$(".scroll-top").on("click", function (event) {
  event.preventDefault();
  $("html, body").animate({ scrollTop: 0 }, 300);
});



var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title], [data-title], [data-bs-title]'))
tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
});


const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))



/* ==============================
          slider area
================================= */

// testimonial-slider 
$('.testimonial-slider').slick({
  autoplay: false,
  autoplaySpeed: 2000,
  dots: false,
  infinite: true,
  speed: 300,
  slidesToShow: 3,
  arrows: false,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 2,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
      }
    }
  ]
});


// brand-slider 
$('.brand-slider').slick({
  autoplay: true,
  autoplaySpeed: 2000,
  dots: false,
  infinite: true,
  speed: 300,
  slidesToShow: 8,
  arrows: false,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 7,
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 5,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 4,
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 3,
      }
    }
  ]
});

$('.story-main-slider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.story-nav-slider'
});
$('.story-nav-slider').slick({
  autoplay: false,
  slidesToShow: 5,
  slidesToScroll: 1,
  asNavFor: '.story-main-slider',
  dots: false,
  focusOnSelect: true,
  arrows: false,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 4,
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 4,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 2,
      }
    }
  ]
});

