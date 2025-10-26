$(function () {
  $('.slick-carousel').slick({
    arrows: false,
    dots: true,
    autoplay: true,
    autoplaySpeed: 3000,
    infinite: true,
    speed: 1000,
    fade: true,
    cssEase: 'linear',
    pauseOnHover: true,
  });

  /** detail-slick */
  $('.slick-carousel-zoom').slick({
    arrows: false,
    dots: true,
    autoplay: true,
    autoplaySpeed: 3000,
    infinite: true,
    speed: 1000,
    fade: true,
    cssEase: 'linear',
    pauseOnHover: true,
    asNavFor: '.slick-carousel-nav-zoom',
  });
  $('.slick-carousel-nav-zoom').slick({
    arrows: true,
    autoplay: false,
    slidesToScroll: 1,
    asNavFor: '.slick-carousel-zoom',
    focusOnSelect: true,
    centerPadding: '60px',
    variableWidth: true,
    draggable:true,
  });

  $('head').append(`<style>
  .slick-carousel-nav-zoom .slick-slide.slick-current.slick-active {
    background: #000;
  }
  .slick-carousel-nav-zoom .slick-slide.slick-current.slick-active .btn-zoom {
    opacity:0;
  }
  .slick-carousel-nav-zoom .btn-zoom{
    padding-right: 30px;
  }
  .slick-carousel-nav-zoom .btn-zoom > div{
    border-radius: 50%;
    background-color: #f9f9f99e;
    border-radius: 50%;
    height: 30px;width: 30px;
    text-align: center;
    cursor:pointer;
  }
  </style`);
  /** */

  /*$('.slide-for').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.slider-nav'
  });

  $('.slide-nav').slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      asNavFor: '.slider-for',
      dots: true,
      centerMode: true,
      focusOnSelect: true
  });*/

  /*$('.center').slick({
      centerMode: true,
      centerPadding: '60px',
      slidesToShow: 3,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            arrows: false,
            centerMode: true,
            centerPadding: '40px',
            slidesToShow: 3
          }
        },
        {
          breakpoint: 480,
          settings: {
            arrows: false,
            centerMode: true,
            centerPadding: '40px',
            slidesToShow: 1
          }
        }
      ]
  });*/
});