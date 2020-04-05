(function ($) {
  $('#header__icon').click(function (e) {
    e.preventDefault();
    $('body').toggleClass('with--sidebar')


  })

  $('#site-cache').click(function (e) {
    $('body').removeClass('with--sidebar')

  })



  $('.menu-left .has-sub').on('click', function () {

    $('.menu-right .has-sub').removeClass('tap')

    $(this).addClass('tap').siblings()

      .removeClass('tap');

  })



  $('.menu-right .has-sub').on('click', function () {
    $('.menu-left .has-sub').removeClass('tap')
    $(this).addClass('tap').siblings()
      .removeClass('tap');

  })

  $('.nav-sub .has-sub').on('click', function () {
    $(this).addClass('tap').siblings().removeClass('tap')
  })


})(jQuery);
