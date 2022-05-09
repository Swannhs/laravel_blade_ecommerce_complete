(function ($) {
    "use strict";
    $(window).on('load', function() {
      setTimeout( function() {
        $(".newsletter_form_wrapper").addClass("newsletter_active").fadeIn();
      }, 1500 );
    });

    $('.close_modal').on('click' , function(){
      $('.newsletter_form_wrapper').removeClass('newsletter_active');
    })
    $(document).on('click',function(event){
      if (!$(event.target).closest(".newsletter_form_inner").length) {
          $("body").find(".newsletter_form_wrapper").removeClass('newsletter_active');
      }
    });
    $(document).ready(function(){
      $(".country_list").select2({
          containerCssClass: "currance_list_search",
          dropdownCssClass: "currance_list_search"
      });
      $(".category_list").select2({
          containerCssClass: "category_list_search",
          dropdownCssClass: "category_list_items"
      });

      $(".category_list").select2({
          containerCssClass: "category_list_search",
          dropdownCssClass: "category_list_items"
      });
      //currance select jquery
      $('.select_btn').on('click', function(){
        $('.select_option').toggleClass('list_visiable');
      })
      //single page menu jquery
      $('.mega_menu_icon').on('click', function(){
        $('.single_page_menu').toggleClass('active');
      })
      // owl carousel js
      var banner_slider = $('.banner_slider');
      let dir = $('html').attr('dir');
      let dir_val  = false;
      if(dir == 'rtl'){
        dir_val = true;
      }

      if (banner_slider.length) {
          banner_slider.owlCarousel({
          items: 1,
          loop: true,
          dots: true,
          autoplay: true,
          margin: 40,
          autoplayHoverPause: true,
          autoplayTimeout: 2000,
          nav: false,
          rtl:dir_val,
          smartSpeed: 1000,
        });
      }
      // owl carousel js
      var product_slider_1 = $('.product_slider_1');
      if (product_slider_1.length) {
          product_slider_1.owlCarousel({
          items: 6,
          loop: true,
          dots: false,
          autoplay: false,
          margin: 20,
          autoplayHoverPause: true,
          autoplayTimeout: 5000,
          nav: true,
          rtl:dir_val,
          navText: ['<i class="ti-arrow-left"></i>', '<i class="ti-arrow-right"></i>'],
          responsive: {
              0: {
                items: 1,
                margin: 15
              },
              576: {
                items: 2,
                margin: 15
              },
              991: {
                items: 3,
                margin: 15
              },
              1200: {
                items: 6,
                margin: 12
              }
            }
        });
      }
      // owl carousel js
      var product_slider_2 = $('.product_slider_2');
      if (product_slider_2.length) {
          product_slider_2.owlCarousel({
          items: 3,
          loop: true,
          dots: false,
          autoplay: false,
          margin: 20,
          autoplayHoverPause: true,
          autoplayTimeout: 5000,
          nav: true,
          rtl: dir_val,
          navText: ['<i class="ti-arrow-left"></i>', '<i class="ti-arrow-right"></i>'],
          responsive: {
              0: {
                items: 1,
                margin: 15
              },
              576: {
                items: 2,
                margin: 15
              },
              991: {
                items: 2,
                margin: 15
              },
              1200: {
                items: 3,
                margin: 20
              }
            }
        });
      }
      // owl carousel js
      var feature_slide = $('.feature_slide');
      if (feature_slide.length) {
          feature_slide.owlCarousel({
          items: 4,
          loop: true,
          dots: false,
          autoplay: false,
          margin: 20,
          autoplayHoverPause: true,
          autoplayTimeout: 5000,
          nav: true,
          rtl:dir_val,
          navText: ['<i class="ti-arrow-left"></i>', '<i class="ti-arrow-right"></i>'],
          responsive: {
              0: {
                items: 1,
                margin: 15
              },
              576: {
                items: 2,
                margin: 15
              },
              991: {
                items: 3,
                margin: 15
              },
              1200: {
                items: 4,
                margin: 20
              }
            }
        });
      }
    });


    // $("select_btn").hover(
    //     function () {
    //       $('.select_btn').addClass('list_visiable');
    //     },
    //     function (event) {
    //         if (!$(event.target).closest(".select_option").length) {
    //             $("body").find(".select_option").removeClass("list_visiable");
    //         }
    //     }
    //   );

    //niceselect select jquery
    $(document).ready(function() {
      $('.nc_select, .select_address, #product_short_list, #paginate_by').niceSelect();
      //datepicker js
      $('#datepicker').datepicker();
    });


    $(document).on('click',function(event) {
        if (!$(event.target).closest(".select_option,.select2-container").length) {
            $("body").find(".select_option").removeClass("list_visiable");
        }
    });


    $(document).on('click',function(event) {
      if (!$(event.target).closest(".mega_menu_icon").length) {
          $("body").find(".single_page_menu").removeClass("active");
      }
    });

    //table responsive css
    $(window).on('load resize', function () {
      if ($(this).width() < 640) {
        $('table tfoot').hide();
      } else {
        $('table tfoot').show();
      }
    });

    $(document).ready(function(){
      $('.all_product').simpleLoadMore({
        item: '.single_product_item',
        count: 18,
        itemsToLoad: 6
      });
    });

    //sidebar dropdown
    $('.sub-menu ul').hide();
    $(".sub-menu a").on('click',function () {
      $(this).parent(".sub-menu").children("ul").slideToggle("100");
      $(this).find(".right").toggleClass("ti-plus ti-minus");
    });
    

    // accordion part js
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight){
          panel.style.maxHeight = null;
        } else {
          panel.style.maxHeight = panel.scrollHeight + "px";
        }
      });
    }

    

    $('.menu-item').on('click', function(){
      $('.mega-menu').removeClass('active_megamenu');
    })

    //megamenu hover add class
    if ($(window).width() > 1200) {
      $('.dropdown').hover(
        function(){ $(this).addClass('show') },
        function(){ $(this).removeClass('show') }
      )
    }
    // for multy step form
    $('.view_collaspe_btn').on('click',function(){
    var $this = $(this);
    $this.toggleClass('view_collaspe_btn');
    if($this.hasClass('view_collaspe_btn')){
    $this.text('View More');
    } else {
    $this.text('See Less');
    }
    });

    
    $(document).ready(function () {
    var currentGfgStep, nextGfgStep, previousGfgStep;
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);

    $(".next-step").on('click',function () {

    currentGfgStep = $(this).parent();
    nextGfgStep = $(this).parent().next();

    $("#progressbar li").eq($("fieldset")
    .index(nextGfgStep)).addClass("active");

    nextGfgStep.show();
    currentGfgStep.animate({ opacity: 1 }, {
    step: function (now) {
    opacity = 1 - now;

    currentGfgStep.css({
    // 'display': 'none',
    'position': 'relative'
    });
    nextGfgStep.css({ 'opacity': opacity });
    },
    duration: 500
    });
    setProgressBar(++current);
    });

    $(".previous-step").on('click',function () {

    currentGfgStep = $(this).parent();
    previousGfgStep = $(this).parent().prev();

    $("#progressbar li").eq($("fieldset")
    .index(currentGfgStep)).removeClass("active");

    previousGfgStep.show();

    currentGfgStep.animate({ opacity: 1 }, {
    step: function (now) {
    opacity = 1 - now;

    currentGfgStep.css({
    // 'display': 'none',
    'position': 'relative'
    });
    previousGfgStep.css({ 'opacity': opacity });
    },
    duration: 500
    });
    setProgressBar(--current);
    });

    function setProgressBar(currentStep) {
    var percent = parseFloat(100 / steps) * current;
    percent = percent.toFixed();
    $(".progress-bar")
    .css("width", percent + "%")
    }

    $(".submit").on('click',function () {
    return false;
    })
    });
    $(document).on('submit', 'form', function(e) {
      let summernote = $(this).find('.summernote');
      if (summernote.length) {
          if (summernote.summernote('codeview.isActivated')) {
              summernote.summernote('codeview.deactivate');
          }
      }
    });
}(jQuery));


function config(key, default_value){

  let value = _.get(_config, key)

  if(typeof value == 'undefined'){
      return default_value;
  }
  return value;
}

function user_currency(key, default_value){

  let value = _.get(_user_currency, key)

  if(typeof value == 'undefined'){
      return default_value;
  }
  return value;
}

function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
  try {
      decimalCount = Math.abs(decimalCount);
      decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

      const negativeSign = amount < 0 ? "-" : "";

      let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
      let j = (i.length > 3) ? i.length % 3 : 0;

      return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
  } catch (e) {
      console.log(e)
  }
}

window.currency_format = function(amount){
  if(_user_currency.length !== 0){
    if(config('currency_symbol_position') === 'left'){
      return user_currency('symbol')+formatMoney(parseFloat(amount) * parseFloat(user_currency('convert_rate')),config('decimal_limit'));
    }
    else if(config('currency_symbol_position') === 'left_with_space'){
      return user_currency('symbol')+ " " +formatMoney(parseFloat(amount) * parseFloat(user_currency('convert_rate')),config('decimal_limit'));
    }
    else if(config('currency_symbol_position') === 'right'){
      return formatMoney(parseFloat(amount) * parseFloat(user_currency('convert_rate')),config('decimal_limit')) + user_currency('symbol');
    }
    else if(config('currency_symbol_position') === 'right_with_space'){
      return formatMoney(parseFloat(amount) * parseFloat(user_currency('convert_rate')),config('decimal_limit')) + " " + user_currency('symbol');
    }
  }else if(config('currency_symbol')){
    if(config('currency_symbol_position') === 'left'){
      return config('currency_symbol')+formatMoney(parseFloat(amount),config('decimal_limit'));
    }
    else if(config('currency_symbol_position') === 'left_with_space'){
      return config('currency_symbol')+ " " +formatMoney(parseFloat(amount),config('decimal_limit'));
    }
    else if(config('currency_symbol_position') === 'right'){
      return formatMoney(parseFloat(amount),config('decimal_limit')) + config('currency_symbol');
    }
    else if(config('currency_symbol_position') === 'right_with_space'){
      return formatMoney(parseFloat(amount),config('decimal_limit')) + " " + config('currency_symbol');
    }
  }else{
    return "$ " + formatMoney(parseFloat(amount),2);
  }  
  
}


