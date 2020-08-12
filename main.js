/*$("li.header-desk__nav-list-item").mouseenter({
$(this).addClass("nav-two-visible");
})*/

/*var menuOne = $(".header-desk__nav > ul.header-desk__nav-list").css('height');
var menuTwo =  $(".header-desk__nav-list-item .header-desk__nav-list").bind(function () {
$(this).css('height');
})
$(".result-test").text(menuTwo);
if (menuOne < menuTwo) {

  $(".header-desk__nav-list-item .header-desk__nav-list").css("column-count", "2");

}
*/


var showTabStores = function () {
  var btns = $('.stores-geo__filter-btn');
  var tabList = $('.stores-geo__list');
  var mapTab = $('.stores-geo__map-wrapper');

  btns.click(function () {
    btns.removeClass('stores-geo__filter-btn--current');
    $(this).addClass('stores-geo__filter-btn--current');
    tabList.toggle();
    mapTab.toggle();
  });
}

var showPersonalPagesMob = function () {
  if ($(window).width() < 1024) {

    $('.personal-area__menu-link').removeClass('personal-area__menu-link--current');


    $('.personal-area__menu-link').on('click', function (e) {
      if ($(this).attr('data-id') === 'page-profile') {
        $('.personal-area').attr('data-state', 'page');
        e.preventDefault();

        // change current link
        $('.personal-area__menu-link').removeClass('personal-area__menu-link--current');
        $(this).addClass('personal-area__menu-link--current');

        // show profile
        $('.personal-area__page').removeClass('personal-area__page--current');
        $('.page-profile').addClass('personal-area__page--current');
      }

    });
  }
}

var showAvailabilityProds = function () {
  var itemsAll = $('.choice-info__item[data-availability="false"]');
  $('#availability label').on('click', function () {

    if ($(this).attr('for') === 'btn-all') {
      itemsAll.css('display', 'flex');
      $('.tab-body__choice-value').hide();
    } else {
      itemsAll.hide();
      $('.tab-body__choice-value').show();
    }

    if ($('.tab-body__choice-info').children(':visible').length > 3) {
      $('.tab-body__choice-info').addClass('overflow');
    } else {
      $('.tab-body__choice-info').removeClass('overflow');
    }
  })
}

var setBasketHeight = function () {
  var basketQty = $('.basket-popup__items').children().length;

  if (basketQty > 1) {
    $('.basket-popup__items').addClass('overflow');
  } else {
    $('.basket-popup__items').removeClass('overflow');
  }
}

function basketSliders() {
  var giftBasketSlider = new Swiper(".js-gift__slider", {
    slidesPerView: 'auto',
    spaceBetween: 20,
    breakpoints: {
      600: {
        spaceBetween: 16
      }
    },
    navigation: {
      nextEl: '.gift__btn-next',
      prevEl: '.gift__btn-prev'
    }
  })
  var recommendBasketSlider = new Swiper(".js-recommend__slider", {
    slidesPerView: 'auto',
    spaceBetween: 20,
    breakpoints: {
      600: {
        spaceBetween: 10
      }
    },

    navigation: {
      nextEl: '.recommend__btn-next',
      prevEl: '.recommend__btn-prev'
    }
  })
  var consultantsBasketSlider = new Swiper(".js-consultants__slider", {
    slidesPerView: 'auto',
    spaceBetween: 20,
    breakpoints: {
      600: {
        spaceBetween: 10
      }
    },

    navigation: {
      nextEl: '.consultants__btn-next',
      prevEl: '.consultants__btn-prev'
    }
  })

  var gifts = $(".gift__slide")

  for (var i = 0; i < gifts.length; i++) {
    $(gifts[i]).click(function (e) {
      e.preventDefault();
      gifts.removeClass("gift--is-selected");
      $(this).addClass("gift--is-selected");
    })
  }


  var giftSliderShow = $(".js-show-gift"),
    giftSliderHide = $(".js-hide-gift");

  giftSliderShow.click(function () {
    $(".gift").fadeIn("fast")
  })

  giftSliderHide.click(function () {
    $(".gift").fadeOut("fast")
  })

  $(".checkout__go-to-registration").click(function (e) {
    e.preventDefault();
    $(".checkout-popup").fadeIn("fast");
    $("body").addClass("popups-active")
  })

  $(".js-btn-close--checkout-popup").click(function (e) {

    $(".checkout-popup").fadeOut("fast");
    $("body").removeClass("popups-active")
  })

  $(".checkout-popup").click(function (e) {
    $(".checkout-popup").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".checkout-popup__body").click(function (e) {
    e.stopPropagation();
  })


  var removeGoodBasket = $(".js-remove-good");

  removeGoodBasket.click(function () {
    var root = $(this).closest('.basket-page__good');
    root.addClass("basket-page__good-removed");
    setBasketHeight();
  })


  var restoreGoodBasket = $(".js-basket-restore");


  restoreGoodBasket.click(function () {
    var root = $(this).closest('.basket-page__good');
    root.removeClass("basket-page__good-removed");
    setBasketHeight();
  })



  var btnPlus = $(".js-counter-basket-more-btn"),
    btnMinus = $(".js-counter-basket-less-btn");

  var value = 1;

  for (var i = 0; i < btnPlus.length; i++) {
    $(btnPlus[i]).click(function () {
      var valueDiv = $(this).siblings(".js-counter-basket-value")
      value++
      valueDiv.text(value)
    })
  }

  for (var i = 0; i < btnMinus.length; i++) {
    $(btnMinus[i]).click(function () {
      var valueDiv = $(this).siblings(".js-counter-basket-value")
      if (value > 1) {
        value--
      }
      valueDiv.text(value)
    })
  }


  $(".basket-popup .js-remove-good").click(function () {
    $(this).siblings(".basket-popup__item-name").hide();
    $(this).siblings(".basket-popup__good-counter").hide();
    $(this).siblings(".basket-popup__good-price-group").hide();
    $(this).hide();
    $(this).siblings(".basket-popup__item-remove-desc").show();
    setBasketHeight();
  })

  $(".basket-popup .js-basket-restore").click(function () {
    $(this).closest(".basket-popup__item-remove-desc").siblings(".basket-popup__item-name").show();
    $(this).closest(".basket-popup__item-remove-desc").hide();
    $(this).closest(".basket-popup__item-remove-desc").siblings(".basket-popup__item-name").show();
    $(this).closest(".basket-popup__item-remove-desc").siblings(".basket-popup__good-counter").show();
    $(this).closest(".basket-popup__item-remove-desc").siblings(".basket-popup__good-price-group").show();
    $(this).closest(".basket-popup__item-remove-desc").siblings(".basket-popup .js-remove-good").show();
    setBasketHeight();
  })

  $(".header-desk__bottom .js-open-basket").hover(function (e) {

    e.preventDefault();
    e.stopPropagation();

    if ($('.basket-popup__item').length > 0) {
      $(".basket-popup").addClass('active');
    }
  }
  )

  $(".basket-popup").mouseleave(function () {
    $(".basket-popup").removeClass('active');
  })

  $(".basket-popup").click(function (e) {
    e.stopPropagation();
  })
}

function catalogPageSliders() {

  var popularProdSlider = new Swiper('.js-popular-prod__slider', {
    slidesPerView: 'auto',
    spaceBetween: 20,
    breakpoints: {
      600: {
        spaceBetween: 10
      }
    },
    navigation: {
      nextEl: '.popular-prod__btn-next',
      prevEl: '.popular-prod__btn-prev'
    }
  })

  var saleProdSlider = new Swiper(".js-sale-prod__slider", {
    slidesPerView: 'auto',
    spaceBetween: 20,
    breakpoints: {
      600: {
        spaceBetween: 10
      }
    },

    navigation: {
      nextEl: '.sale-prod__btn-next',
      prevEl: '.sale-prod__btn-prev'
    }
  })
}

function checkOutCombineOrders() {

  var btnsOpen = $(".js-btn-go-another-checkout");

  for (var i = 0; i < btnsOpen.length; i++) {
    $(btnsOpen[i]).click(function (e) {
      e.preventDefault();
      $(".checkout-combine-orders").fadeIn("fast");
      $("body").addClass("popups-active");
    })
  }

  $(".js-btn-close--checkout-combine-orders").click(function (e) {
    e.preventDefault();
    $(".checkout-combine-orders").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".js-checkout-combine-orders__link-disagree").click(function (e) {
    e.preventDefault();
    $(".checkout-combine-orders").fadeOut("fast");
    $("body").removeClass("popups-active");
  })


  $(".checkout-combine-orders").click(function (e) {
    $(".checkout-combine-orders").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".checkout-combine-orders__body").click(function (e) {
    e.stopPropagation();
  })
}


function checkOutChangeGeo() {

  var btnsOpen = $(".js-change-geo");

  for (var i = 0; i < btnsOpen.length; i++) {
    $(btnsOpen[i]).click(function (e) {
      e.preventDefault();
      $(".checkout-change-geo").fadeIn("fast");
      $("body").addClass("popups-active");
    })
  }

  $(".js-btn-close--checkout-change-geo").click(function (e) {
    e.preventDefault();
    $(".checkout-change-geo").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  var tabsName = $(".checkout-change-geo__tab-name")
  var tabsBody = $(".checkout-change-geo__tab-body")
  for (var i = 0; i < tabsName.length; i++) {
    $(tabsName[i]).click(function (e) {
      tabsName.removeClass("checkout-change-geo__tab-name--is-active")
      $(this).addClass("checkout-change-geo__tab-name--is-active")

      var curIndex = $(this).index();

      tabsBody.removeClass("checkout-change-geo__tab-body--is-active")
      $(tabsBody[curIndex]).addClass("checkout-change-geo__tab-body--is-active")
    })
  }

  var btnChangeStore = $(".btn-change-store")
  for (var i = 0; i < btnChangeStore.length; i++) {

    $(btnChangeStore[i]).click(function () {
      btnChangeStore.removeClass("btn-change-store--is-active")
      $(this).addClass("btn-change-store--is-active")
    })
  }



  $(".checkout-change-geo").click(function (e) {
    $(".checkout-change-geo").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".checkout-change-geo__body").click(function (e) {
    e.stopPropagation();
  })
}

function checkOutChangeTown() {
  var input = $(".order-delivery__self-geo");
  var inputVal = $(".js-change-geo-order-store__item");



  for (var i = 0; i < input.length; i++) {
    $(input[i]).click(function () {

      var inputIndex = input.index(this);

      $(".js-geo-select").fadeIn("fast");
      $("body").addClass("popups-active");

      for (var j = 0; j < inputVal.length; j++) {
        $(inputVal[j]).click(function () {

          var val = $(this).text();
          console.log(inputIndex)

          $(input[inputIndex]).text(val);
          $(".js-change-geo-store").fadeOut("fast");
          $("body").removeClass("popups-active");
        })
      }
    })
  }
}

var cutText = function () {
  var elements = $('.card-blog__desc');

  elements.each(function (index, element) {
    var elementText = $(element).text();
    var elementTextSliced = elementText.slice(0, 71);
    var elementTextSlicedDesk = elementText.slice(0, 140);


    if ($(window).width() < 1240) {
      if (elementText.length >= 71) {
        $(element).text(elementTextSliced + "...");
      }
    } else {
      if (elementText.length >= 143) {
        $(element).text(elementTextSlicedDesk + "...");
      }
    }
  });
}

var setFilterStatusOnReload = function () {
  var filtersQty = $('.category-catalog-page .filter .checkbox input:checked').length;
  if (filtersQty > 0) {
    $('.category-catalog-page .filter-status').removeClass('filter-status--is-empty');
    $('.category-catalog-page .filter-status').text(filtersQty);
  } else {
    $('.category-catalog-page .filter-status').addClass('filter-status--is-empty');
    $('.category-catalog-page .filter-status').text('');
  }
}

var setPositionChildMenu = function (heightContentn) {
  var childMenu = $('.header-desk__nav-list-item .header-desk__nav-list');

/*  childMenu.each(function (index, element) {

    var currentHeight = $(element).height();
    var parentElement = $(element).closest('.header-desk__nav-list-item');

  if (currentHeight > heightContentn) {
      $(element).css('max-height', heightContentn);
      $(element).addClass('menu-overflow');
      $(element).css('top', '0');
    } else {
      parentElement.addClass('menu-item-relative');
      if (parentElement.position().top < Math.floor(heightContentn / 2)) {
        $(element).css('top', '0');
      } else {
        $(element).css('bottom', '0');
      }
    }

  })*/
}

var removeSliderArrows = function (sliderClassName) {
  var sliderItems = $('.' + sliderClassName + ' .swiper-wrapper ').children().length;
  var clientWidth = $(window).width();
  if (clientWidth < 1239 && clientWidth > 767 && sliderItems < 5) {
    $('.' + sliderClassName + ' .swiper-button-prev, .' + sliderClassName + ' .swiper-button-next').hide()
  }
  if (clientWidth < 768 && sliderItems < 3) {
    $('.' + sliderClassName + ' .swiper-button-prev, .' + sliderClassName + ' .swiper-button-next').hide()
  }
  if (clientWidth > 1239 && sliderItems < 7) {
    $('.' + sliderClassName + ' .swiper-button-prev, .' + sliderClassName + ' .swiper-button-next').hide()
  }
}

var setBannerHelpPosition = function () {
  var catalogItems = $('.goods').children().length;
  var clientWidth = $(window).width();

  if (clientWidth < 1239 && clientWidth > 767) {

    if (catalogItems > 12) {
      $('.goods .card-prod:nth-child(12)').after($('#request-help'));
    } else {
      $('.goods').append($('#request-help'));
    }
  }

  if (clientWidth < 768) {

    if (catalogItems > 10) {
      $('.goods .card-prod:nth-child(10)').after($('#request-help'));
    } else {
      $('.goods').append($('#request-help'));
    }
  }

  if (clientWidth > 1239) {
    if (catalogItems > 15) {
      $('.goods .card-prod:nth-child(15)').after($('#request-help'));
    } else {
      $('.goods').append($('#request-help'));
    }
  }
}

var updateScript = function() {
    $(".js-masked-phone").mask('9 (999) 999-99-99');
    if ($('sel ect').length > 0) {
        $('sel ect').selectric({
            disableOnMobile: false,
            nativeOnMobile:false,
            multiple: {
                separator: '',
                keepMenuOpen: true,
                maxLabelEntries: 1
            }
        });
        $('.filter-display sel ect').prop('selectedIndex', -1).selectric('refresh');
        $('.filter-options sel ect').prop('selectedIndex', -1).selectric('refresh');
    }
    if($( ".js-range-slider" ).length > 0) {
        setIonRange();
    }

    if($( ".js-files" ).length > 0) {
        addFile();
    }

    if($( ".js-only-number" ).length > 0) {
        onlyNumber();
    }
}

$.fn.serializeObject = function () {
    var self = this,
        json = {},
        push_counters = {},
        patterns = {
            "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
            "key": /[a-zA-Z0-9_]+|(?=\[\])/g,
            "push": /^$/,
            "fixed": /^\d+$/,
            "named": /^[a-zA-Z0-9_]+$/
        };
    this.build = function (base, key, value) {
        base[key] = value;
        return base;
    };
    this.push_counter = function (key) {
        if (push_counters[key] === undefined) {
            push_counters[key] = 0;
        }
        return push_counters[key]++;
    };
    $.each($(this).serializeArray(), function () {
        // skip invalid keys
        if (!patterns.validate.test(this.name)) {
            return;
        }
        var k,
            keys = this.name.match(patterns.key),
            merge = this.value,
            reverse_key = this.name;
        while ((k = keys.pop()) !== undefined) {
            // adjust reverse_key
            reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');
            // push
            if (k.match(patterns.push)) {
                merge = self.build([], self.push_counter(reverse_key), merge);
            }
            // fixed
            else if (k.match(patterns.fixed)) {
                merge = self.build([], k, merge);
            }
            // named
            else if (k.match(patterns.named)) {
                merge = self.build({}, k, merge);
            }
        }
        json = $.extend(true, json, merge);
    });
    return json;
};

function onlyNumber() {
    $( ".js-only-number" ).keydown(function(event) {

        // Разрешаем: backspace, delete, tab и escape
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 ||
            // Разрешаем: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) ||
            // Разрешаем: home, end, влево, вправо
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            // Ничего не делаем
            return;
        } else {
            // Запрещаем все, кроме цифр на основной клавиатуре, а так же Num-клавиатуре
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
        }
    });
}

function myValidateForm(form) {
    var _items = form.find(".js-req");
    form.find(".js-req").closest('.b-commission__group').removeClass("error");
    $('.js-commission-error-btn').closest('.b-commission__group').removeClass('error');
    var _valid = true;
    _items.each(function (index, el) { /*проверка заполнения*/
        var _input = $(el);
        if (_input.val() == "" && _input.attr("name") !== "FILES") {
            $(el).closest('.b-commission__group').find('.b-commission__error').text('Поле обязательно для заполнения');
            $(el).closest('.b-commission__group').addClass('error');
            _valid = false;
        }

        if (_input.attr("type") == "checkbox" && _input.prop("checked") == false) {
            $(el).closest('.b-commission__group').find('.b-commission__error').text('Поле обязательно для заполнения');
            $(el).closest('.b-commission__group').addClass('error');
            _valid = false;
        }

        if (_input.attr("name") === "EMAIL" && _input.val() === "") {
            $(el).closest('.b-commission__group').find('.b-commission__error').text('Поле обязательно для заполнения');
            $(el).closest('.b-commission__group').addClass('error');
            _valid = false;
        } else if (_input.attr("name") === "EMAIL_USER" && !isValidEmailAddress(_input.val())) {
            $(el).closest('.b-commission__group').find('.b-commission__error').text('Некорректное значение');
            $(el).closest('.b-commission__group').addClass('error');
            _valid = false;
        }

        if (_input.attr("name") === "COMMENT" && _input.val() === "") {
            $(el).closest('.b-commission__group').find('.b-commission__error').text('Поле обязательно для заполнения');
            $(el).closest('.b-commission__group').addClass('error');
            _valid = false;
        } else if (_input.attr("name") === "COMMENT" && isValidText(_input.val())) {
            $(el).closest('.b-commission__group').find('.b-commission__error').text('Некорректное значение');
            $(el).closest('.b-commission__group').addClass('error');
            _valid = false;
        }

        if (_input.attr("name") === "FILES" && $('input[name="FILES_SRC[]"]').length === 0) {
            $(el).closest('.b-commission__group').find('.b-commission__error').text('Поле обязательно для заполнения');
            $(el).closest('.b-commission__group').addClass('error');
            _valid = false;
        }
    });
    if(!_valid) {
        $('.js-commission-error-btn').closest('.b-commission__group').addClass('error');
    }
    return _valid;
}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/.+@.+\..+/i);
    return pattern.test(emailAddress);
}

function isValidText(text) {
    var pattern = new RegExp(/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/);
    return pattern.test(text);
}

function addFile() {
    $(".js-files").dmUploader({
        url: '/ajax/files-upload.php',

        onUploadSuccess: function(id, data) {
            if(data.status === 'ok') {
                var html = ' <div class="b-commission__file">\n' +
                    '                            <img src="' + data.src + '" alt="">\n' +
                    '<span class="b-commission__file-delete js-file-delete"></span>' +
                    '<input type="hidden" name="FILES_SRC[]" value="' + data.src + '">' +
                    '                        </div>';
                $('.js-file-upload').prepend(html);
                $('.js-file-upload').closest('.b-commission__group').removeClass('error');
                if($('.b-commission__file').length > 4) {
                    $( ".js-files" ).hide();
                }
            }

        }

    });
}

function setIonRange() {
    $( ".js-range-slider" ).each(function(indx, element){
        var min = $(element).attr('data-min'),
            max = $(element).attr('data-max'),
            value = (Number.parseInt($(element).attr('data-max')) + Number.parseInt($(element).attr('data-min'))) / 2;
        $(element).ionRangeSlider({
            from: value,
            min: min,
            max: max,
            onStart: function (data) {
                $(element).parent().find('.js-range-value').val(data.from)
            },
            onChange: function (data) {
                $(element).parent().find('.js-range-value').val(data.from)
            }
        });
        var sl = $(element).data("ionRangeSlider");
        $(element).closest('.b-commission__range').find('.js-range-value').change(function () {
            var val = Number.parseInt($(this).val()),
                min = Number.parseInt($(this).attr('data-min')),
                max = Number.parseInt($(this).attr('data-max'));

            if(val < min) {
                val = min;
                $(this).val(val);
            } else if(val > max) {
                val = max;
                $(this).val(val);
            }

            sl.update({
                from: val,
            });
        });
    });
}

$(document).ready(function () {
  heightContentn = $(window).height() - $('header').height();

  $(function () {
    // remove arrows
    removeSliderArrows('js-viewed-prod__slider');
    setBannerHelpPosition();
    setBasketHeight();

    if ($('select').length > 0) {
      $('select').selectric({
          disableOnMobile: false,
          nativeOnMobile:false,
        multiple: {
          separator: '',
          keepMenuOpen: true,
          maxLabelEntries: 1
        }
      });
      $('.filter-display select').prop('selectedIndex', -1).selectric('refresh');
      $('.filter-options select').prop('selectedIndex', -1).selectric('refresh');
    }

      if($( ".js-max-text" ).length > 0) {

      }
      if($( ".js-only-number" ).length > 0) {
          onlyNumber();
      }
    if($( ".js-range-slider" ).length > 0) {
        setIonRange();
    }

      if($( ".js-files" ).length > 0) {
          addFile();
      }

      $('body').on('click', '.js-file-delete', function () {
        var parent = $(this).parent(),
            _data = {};
        _data["src"] = parent.find('input').val();
          $.ajax({
              url: '/ajax/files-upload.php',
              dataType: 'json',
              type: 'POST',
              data: {
                  'action': 'delete',
                  'data': _data
              },
              error: function (data) {
                  console.log(data);
              },
          }).done(function (data) {
              if(data.error === "0") {
                  parent.remove();
                  if($('.b-commission__file').length < 5) {
                      $( ".js-files" ).show();
                  }
              }
          });
      });

      $('body').on('change', '.js-change-type', function () {
          $('.js-commission-form').css('opacity', 0.5);
          var $this = $(this);
          $.ajax({
              url: "/personal/commission/",
              type: "POST",
              dataType: 'html',
              data: {
                  AJAX: 'Y',
                  type: $this.val()
              }
          })
              .done(function (html) {
                  $('.js-commission-form').html(html);
                  updateScript();
                  $('.js-commission-form').css('opacity', 1);
              });
      });

      $('body').on('change', '.js-other', function () {
          console.log($(this).val());
            if($(this).val() === "0") {
                $(this).closest('.b-commission__group').find('.b-commission__hide-input').show();
                if($(this).hasClass('js-req')) {
                    $(this).closest('.b-commission__group').find('.b-commission__hide-input input').addClass('js-req');
                }
            } else {
                $(this).closest('.b-commission__group').find('.b-commission__hide-input').hide();
                $(this).closest('.b-commission__group').find('.b-commission__hide-input input').removeClass('js-req');
            }
      });

      $('body').on('change', '.js-req', function () {
          var _form = $(this).closest('form');
          // $(this).closest('.b-commission__group').removeClass("error");
          if($(this).closest('.b-commission__group').hasClass('error')) {
              myValidateForm($(_form));
          }
      });

      $('body').on('submit', '#commissionForm', function (e) {
          e.preventDefault();
          var form = this,
              _data = $(form).serializeObject();
          if(myValidateForm($(form))) {
              $.ajax({
                  url: '/ajax/add-commission.php',
                  dataType: 'json',
                  type: 'POST',
                  data: {
                      'action': "addProduct",
                      'data': _data
                  },
                  error: function (data) {
                      console.log(data);
                  },
              }).done(function (data) {
                  console.log(data);
                  window.location.href = '/personal/commission-list/';
              });
          }
      });

    if ($('.tab-body__choice-info').children(':visible').length > 3) {
      $('.tab-body__choice-info').addClass('overflow');
    }

    if ($('.pagination__item').first().find('.pagination__link').hasClass('pagination__link--current')) {
      $('.pagination__arrow-prev').addClass('disabled');
    } else {
      $('.pagination__arrow-prev').removeClass('disabled');
    }

    if ($('.pagination__item').last().find('.pagination__link').hasClass('pagination__link--current')) {
      $('.pagination__arrow-next').addClass('disabled');
    }

    setFilterStatusOnReload();

    $('.js-callback-btn').css('top', $('header').height() + 10 + 'px');
    $('#availability input[data-availability="true"]').prop('checked', true);
    $('#availability input[data-availability="false"]').prop('checked', false);
    if ($(window).width() < 1024) {
      $('.stores-geo__filter-btn').removeClass('stores-geo__filter-btn--current');
      $('.stores-geo__filter-btn--list').addClass('stores-geo__filter-btn--current');
      $('.stores-geo__map-wrapper').hide();
      $('.stores-geo__list').show();
    }

    if ($('.content-page table').length > 0) {
      $('.content-page table').wrap('<div class="content-page__table"></div>');
    }

    if ($(".product-info__tab").length > 0 && $(window).width() < 1240) {
      $(".product-info__tab").each(function (index, element) {
        $(element).css('order', index * 2);
      })

      $(".product-info__tab-body").each(function (index, element) {
        $(element).css('order', index * 2 + 1);
      })
    }
  });

  setPositionChildMenu(heightContentn)

  $('.js-filter-reset').on('click', function () {
    $('.filter-options select').prop('selectedIndex', -1).selectric('refresh');
    $('.news-page .filter-status').text('');
    $('.news-page .filter-status').addClass('filter-status--is-empty');
  })

  $('.filter-options select').on('change', function () {
    var counter = $('.filter-options .selectric-items li.selected').length;
    console.log(counter)
    if (counter > 0) {
      $('.news-page .filter-status').text(counter);
      $('.news-page .filter-status').removeClass('filter-status--is-empty');
    } else {
      $('.news-page .filter-status').text('');
      $('.news-page .filter-status').addClass('filter-status--is-empty');
    }

  })

  showPersonalPagesMob();
  showAvailabilityProds();
  showTabStores();
  cutText();
  changeGeo();
  navigation();
  fos();
  search();
  searchUrl();
  scrollAnchor();
  footerMenu();
  paLogin();

  indexPageSliders();
  catalogPageSliders();
  productPageSliders();
  basketSliders();
  contentPageSliders();


  productTab();
  counterProd();
  addToBasket();
  quickOrder();

  $(".js-quick-order #phone").mask('8 (999) 999-99-99');
  $(".callback #phone").mask('8 (999) 999-99-99');
  $(".js-masked-phone").mask('9 (999) 999-99-99');

  $(".callback #phone").keyup(function () {
    var phone = $(this).val().replace(/\D+/g, "")
    console.log(phone)
    if (phone.length == 11) {
      $(".callback__submit").attr("disabled", false)
    } else {
      $(".callback__submit").attr("disabled", true)
    }
  });

  if ($(window).width() < 1240) {
    filter();
  } else {
    $(".js-filter-options__title").on('click', function () {
        $(this).toggleClass("filter-options__title--is-active")
    })

    $(".filter-sort__desc").click(function (e) {
      $(this).toggleClass("filter-sort__desc--is-active")
      e.stopPropagation();
      $(".js-filter-sort").fadeToggle();
    })

    $(".js-filter-sort").click(function (e) {
      $(".filter-sort__desc").removeClass("filter-sort__desc--is-active")
      $(".js-filter-sort").fadeOut();
    })

    $(".filter-sort__list .radio").click(function () {
      var value = $(this).text();

      $(".filter-sort__desc").text(value)
    })

    $(".js-filter-reset").click(function () {
      var checkboxes = $(".filter .checkbox-styled input:checkbox");
      for (var i = 0; i < checkboxes.length; i++) {
        $(".filter .checkbox-styled input:checkbox:checked").prop("checked", false)
        $(".filter-status").addClass("filter-status--is-empty")
        $(".filter-status").text("")
      }
    })
  }

  if ($(window).width() >= 1240) {
    $("body").click(function () {
      $(".js-search-list").slideUp();
      $(".js-filter-sort").fadeOut();
      $(".filter-them__select-list").slideUp();
      $(".filter-them__select").removeClass("filter-them__select--is-active")
    })

    $(".card-stock").hover(function () {
      $(this).siblings(".card-stock").css("opacity", 0.8)
    }, function () {
      $(this).siblings(".card-stock").css("opacity", 1)
    })

    $(".header-desk__logo").hover(
      function () {
        $(this).find("img").attr("src", "img/logo-desc-hover.svg")
      },
      function () {
        $(this).find("img").attr("src", "img/logo-desc.svg")
      }
    )
  }

var currentHeight = $("header").height();
var h_mrg = 0;
 $(function(){
    $(window).scroll(function(){
       var topHeight = $(this).scrollTop();
       var elem = $('.background-menu-popup');
       if (topHeight + h_mrg < currentHeight) {
        elem.css('top', (currentHeight-topHeight));
       } else {
        elem.css('top', h_mrg);
       }
     });
   });

$(".background-menu-popup").css("top", currentHeight);

/*  if ($(".header #panel").length) {
    var currentHeight = $("header").height();

    $("main").css("margin-top", currentHeight);
$(".background-menu-popup").css("top", currentHeight);
  } else {
    var currentHeight = $("header").height();
    $("main").css("margin-top", currentHeight);
$(".background-menu-popup").css("top", currentHeight);
  }*/

  checkOutCombineOrders();
  checkOutChangeGeo();

  checkOutChangeTown();

  deskMenuCatalog();

  if ($(window).width() <= 768) {
    $(window).scroll(function () {
      var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();
      if (scrollBottom <= 0) {
        $(".menu-mob").slideUp("fast");
      } else {
        $(".menu-mob").slideDown("fast");
      }
    })
  } else {
    $(window).scroll(function () {
      var x = $(window).scrollTop();
      if (x > 0) {
        $(".header-desk__inner").addClass("header-desk--is-fixed")
      } else {
        $(".header-desk__inner").removeClass("header-desk--is-fixed")
      }
    })
  }

  $(".filter-them__select").click(function (e) {
    e.stopPropagation();
    $(".filter-them__select").toggleClass("filter-them__select--is-active")
    $(this).find(".filter-them__select-list").slideToggle();
  })

  $(".filter-them__select-list").click(function (e) {
    e.stopPropagation();
  })

  $(".filter-form").click(function () {
    $(".filter-form__select").toggleClass("filter-form__select--is-active")
    $(this).find(".filter-form__select-list").slideToggle();
  })

  $(".filter-form__select-item").click(function () {
    var text = $(this).text();
    $(".filter-form__selected").text(text)
  })



  var btnsMore = $(".seo .js-btn-more");
  btnsMore.click(function () {
    $(this).hide();
    $('.seo .category-seo__desc').children().not(':first').slideDown('fast');
  })

  var btnsMoreCat = $(".category-seo .js-btn-more");
  btnsMoreCat.click(function () {
    $(this).hide();
    $('.category-seo__desc').children().not(':first').slideToggle('fast');
  })

  $(document).ready(function(){
	  $('.js-btn-more').click();
  });

  /*
  var iProdFav = 0;
  var prodFav = $(".js-fav-prod")
  for (var i = 0; i < prodFav.length; i++) {
    $(prodFav[i]).click(function (e) {
      e.preventDefault();
      $(this).toggleClass("js-fav-prod--is-active");

      if ($(this).hasClass("js-fav-prod--is-active")) {
        iProdFav++
      } else {
        iProdFav--
      }

      if (iProdFav > 0) {
        $(".menu-mob__item-counter--fav").removeClass("menu-mob__item-counter--empty");
        $(".menu-mob__item-counter--fav").text(iProdFav);
        $(".header-desk__menu-item-counter--fav").removeClass("header-desk__menu-item-counter--empty");
        $(".header-desk__menu-item-counter--fav").text(iProdFav);
      } else {
        $(".menu-mob__item-counter--fav").addClass("menu-mob__item-counter--empty");
        $(".menu-mob__item-counter--fav").text("");
        $(".header-desk__menu-item-counter--fav").addClass("header-desk__menu-item-counter--empty");
        $(".header-desk__menu-item-counter--fav").text("");
      }
    })

  }
  */

  /*
  var iProdCompare = 0;
  $(".js-compare-prod").click(function () {
    $(this).toggleClass("js-compare-prod--is-active")

    if ($(this).hasClass("js-compare-prod--is-active")) {
      iProdCompare++;
    } else {
      iProdCompare--;
    }


    if (iProdCompare > 0) {
      $(".header-desk__menu-item-counter--compare").removeClass("header-desk__menu-item-counter--empty");
      $(".header-desk__menu-item-counter--compare").text(iProdCompare);
    } else {
      $(".header-desk__menu-item-counter--compare").addClass("header-desk__menu-item-counter--empty");
      $(".header-desk__menu-item-counter--compare").text("");
    }

  })


  $(".product-intro__actions-compare").click(function () {
    $(this).toggleClass("product-intro__actions-compare--is-active")
  })
  */



  var btnsAddProdBasket = $(".card-prod__add");
  var iAddProdBasket = $(".header-desk__menu-item-counter--basket").html();
  var hiddencounter = $("#basket_counter").val();

  $(btnsAddProdBasket).click(function (e) {
    e.preventDefault()
    $(this).addClass("card-prod__add--is-active yellow")
    setBasketHeight();
    $(this).html('В корзине');
    //console.log(iAddProdBasket++);
    iAddProdBasket++;
    $(".header-desk__menu-item-counter--basket").html(iAddProdBasket);
  })



  var radios = $(".checkout-page__order .radio-styled");
  for (var i = 0; i < radios.length; i++) {
    $(radios[i]).click(function () {
      $(this).siblings(".radio-styled").find("input").attr("checked", false);
      $(this).find("input").attr("checked", true);



      if ($(this).attr("id") == "self") {
        $(this).closest(".order-delivery").find("#body-post").slideUp("fast");
        $(this).closest(".order-delivery").find("#body-courier").slideUp("fast");
        $(this).closest(".order-delivery").find("#body-self").slideDown("fast");
      } else if ($(this).attr("id") == "courier") {
        $(this).closest(".order-delivery").find("#body-post").slideUp("fast");
        $(this).closest(".order-delivery").find("#body-self").slideUp("fast");
        $(this).closest(".order-delivery").find("#body-courier").slideDown("fast");
      } else if ($(this).attr("id") == "post") {
        $(this).closest(".order-delivery").find("#body-self").slideUp("fast");
        $(this).closest(".order-delivery").find("#body-courier").slideUp("fast");
        $(this).closest(".order-delivery").find("#body-post").slideDown("fast");
      }

    })
  }



  // change geo store

  $(".stores-page-geo__input").click(function () {
    $(".js-change-geo-store").fadeIn("fast");
    $("body").addClass("popups-active")
  })

  $(".js-btn-close--change-geo-store").click(function () {
    $(".js-change-geo-store").fadeOut("fast");
    $("body").removeClass("popups-active")
  })

  $(".js-change-geo-store").click(function (e) {
    $(".js-change-geo-store").fadeOut("fast");
    $("body").removeClass("popups-active");
  })



  var geoStores = $(".js-change-geo-store__item")

  for (var i = 0; i < geoStores.length; i++) {
    $(geoStores[i]).click(function () {
      $("body").removeClass("popups-active");
      var innerText = $(this).text();
      $(".stores-page-geo__input").text(innerText);
      $(".js-change-geo-store").fadeOut("fast");
      if (innerText == "Все города") {
        $(".stores-page-geo__tabs-body").removeClass("stores-page-geo__tabs-body--is-active")
        $(".stores-page-geo__tabs-body--all").addClass("stores-page-geo__tabs-body--is-active")
      } else {
        $(".stores-page-geo__tabs-body").removeClass("stores-page-geo__tabs-body--is-active")
        $(".stores-page-geo__tabs-body--one").addClass("stores-page-geo__tabs-body--is-active")
      }
    })
  }

  var tabsName = $(".stores-page-geo__tab-name")
  var tabsBodyAll = $(".stores-page-geo__tabs-body--all .stores-page-geo__tab-body")
  var tabsBodyOne = $(".stores-page-geo__tabs-body--one .stores-page-geo__tab-body")

  for (var i = 0; i < tabsName.length; i++) {
    $(tabsName[i]).click(function (e) {
      tabsName.removeClass("stores-page-geo__tab-name--is-active")
      $(this).addClass("stores-page-geo__tab-name--is-active")

      var curIndex = $(this).index();

      tabsBodyAll.removeClass("stores-page-geo__tab-body--is-active")
      $(tabsBodyAll[curIndex]).addClass("stores-page-geo__tab-body--is-active")

      tabsBodyOne.removeClass("stores-page-geo__tab-body--is-active")
      $(tabsBodyOne[curIndex]).addClass("stores-page-geo__tab-body--is-active")
    })
  }

  // cookies
  /*
  if (!$.cookie('was')) {
    $(".js-geo").fadeIn("fast");
    $("body").addClass("popups-active");
  }

  $.cookie('was', true, {
    expires: 30,
    path: '/'
  });
  */
})


function contentPageSliders() {
  var contentPageSlider = new Swiper('.js-content-page__slider', {
    spaceBetween: 10,

    pagination: {
      el: '.js-content-page__slider-pagination'
    },

    navigation: {
      nextEl: '.content-page__btn-next',
      prevEl: '.content-page__btn-prev'
    }
  })

  var blogInterestingSlider = new Swiper('.js-blog-interesting__slider', {
    slidesPerView: 2,
    spaceBetween: 30,
    breakpoints: {
      600: {
        slidesPerView: 'auto',
        spaceBetween: 10
      }
    },

    navigation: {
      nextEl: '.blog-interesting__btn-next',
      prevEl: '.blog-interesting__btn-prev'
    }
  })

}
function filter() {
  var filterDisplay = $(".filter-display ");

//  $(window).scroll(function () {
//    var x = $(window).scrollTop();

//    if (x >= 459 && x <= 7000) {
//      filterDisplay.addClass("filter-display--is-fixed");

//    } else {
//      filterDisplay.removeClass("filter-display--is-fixed");

//    }
//  })



  var filterOpen = $(".js-filter-open"),
    filter = $(".filter");


  filterOpen.click(function () {
    filter.fadeIn("fast");
    $("body").addClass("popups-active");
  })

  var rootItemList = $(".js-filter-options__title"),
    resetBtn = $(".js-filter-reset"),
    closeBtn = $(".js-filter-close"),
    checkboxes = $(".checkbox input");

  rootItemList.on('click', function () {
      $(this).toggleClass("filter-options__title--is-active")
  });

  closeBtn.click(function () {
    filter.fadeOut("fast");
    $("body").removeClass("popups-active");
  })


  $(".js-filter-btn").click(function () {
    filter.fadeOut("fast");
    $("body").removeClass("popups-active");
  })


  var filterSortOpen = $(".filter-sort__desc"),
    filterSort = $(".js-filter-sort");

  filterSortOpen.click(function (e) {
    $(this).toggleClass("filter-sort__desc--is-active")
    filterSort.fadeToggle("fast");
  })

  $(".js-filter-sort").click(function (e) {
    filterSortOpen.removeClass("filter-sort__desc--is-active")
    filterSort.fadeOut("fast");
  })

  var filterValue = $(".filter-sort__list .radio")

  for (var i = 0; i < filterValue.length; i++) {
    $(filterValue[i]).click(function () {
      var value = $(this).text();

      $(".js-filter-sort-btn span").text(value)
    })
  }

  var checkboxFilter = $(".filter .checkbox-styled input:checkbox");
  var checkboxFilterCounter = 0;

  resetBtn.click(function () {
    for (var i = 0; i < checkboxes.length; i++) {
      $(".filter .checkbox-styled input:checkbox:checked").prop("checked", false)
      $(".filter-status").addClass("filter-status--is-empty")
      $(".filter-status").text("")
    }
  })

  for (var i = 0; i < checkboxFilter.length; i++) {
    $(checkboxFilter[i]).click(function () {

      checkboxFilterCounter = $(".filter .checkbox-styled input:checkbox:checked").length;

      if (checkboxFilterCounter > 0) {
        $(".filter-status").removeClass("filter-status--is-empty")
        $(".filter-status").text(checkboxFilterCounter)
      } else {
        $(".filter-status").addClass("filter-status--is-empty")
        $(".filter-status").text("")
      }

    })
  }




}

function footerMenu() {
  var rootItem = $(".list__root-item");
  for (var i = 0; i < rootItem.length; i++) {
    $(rootItem[i]).click(function () {
      $(this).toggleClass("list__root-item--is-clicked");
      $(this).find(".list__items").slideToggle();

    })
  }
}



function fos() {
  var callbackBtn = $(".js-callback-btn"),
    callbackBtnClose = $(".js-btn-close--callback"),
    callbackPopup = $(".callback ");

  callbackPopup.click(function (e) {
    callbackPopup.fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".callback__body").click(function (e) {
    e.stopPropagation();
  })

  callbackBtn.click(function () {
    callbackPopup.fadeIn("fast");
    $("body").addClass("popups-active");
  })

  $(".banner-help__submit").click(function () {
    callbackPopup.fadeIn("fast");
    $("body").addClass("popups-active");
  })

  callbackBtnClose.click(function () {
    callbackPopup.fadeOut("fast");
    $("body").removeClass("popups-active");
  })


  var subsSucces = $(".subs-succes"),
    subsSuccesForm = $(".subs__form"),
    subsSuccesClose = $(".js-btn-close--subs");

  subsSuccesForm.submit(function (e) {
    /*
	subsSucces.fadeIn("fast");
    $("body").addClass("popups-active");
	*/
  })

  subsSuccesClose.click(function () {
    subsSucces.fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  subsSucces.click(function (e) {
    var target = $(e.target);

    if (target.hasClass("subs-succes")) {
      subsSucces.fadeOut("fast");
      $("body").removeClass("popups-active");
    }
  })


  $(".subs-succes").click(function (e) {
    $(".subs-succes").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".subs-succes__body").click(function (e) {
    e.stopPropagation();
  })

}
function changeGeo() {
  var btnGeo = $(".js-header__geo"),
    btnClosePopupGeoAgree = $(".js-btn-close--geo"),
    btnClosePopupGeoSelect = $(".js-btn-close--geo-select"),
    btnAgreePopupGeoAgree = $(".js-geo-btn--agree"),
    btnAgreePopupGeoAnother = $(".js-geo-btn--another"),
    popupGeoAgree = $(".js-geo"),
    popupGeoChange = $(".js-geo-select"),
    geoNewValue = $(".js-geo-select__list").children();

  $(document).on('click', '.geo__body', function (e) {
    e.stopPropagation();
  });

  btnAgreePopupGeoAgree.click(function () {
    popupGeoAgree.fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  btnClosePopupGeoAgree.click(function () {
    popupGeoAgree.fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(document).on('click', '.geo-select__body', function (e) {
    e.stopPropagation();
  });

  btnGeo.click(function () {
    popupGeoChange.fadeIn("fast");
    $("body").addClass("popups-active");
  })

  btnAgreePopupGeoAnother.click(function () {
    $("body").addClass("popups-active");
    popupGeoAgree.fadeOut("fast");
    popupGeoChange.fadeIn("fast");
  })

  $(document).on('click', '.js-btn-close--geo-select', function () {
    $('.js-geo-select').fadeOut('fast');
    $('body').removeClass('popups-active');
  });

  $(document).on('click', '.geo-select__list-item', function () {
    changeGeoInHeader($(this));
    $('.js-geo-select').fadeOut('fast');
    $('body').removeClass('popups-active');
  });

  $(document).on('click', '.js-bxmaker__geoip__popup-search-option', function () {
    $('.js-geo-select').fadeOut('fast');
    $('body').removeClass('popups-active');
  });
}

function changeGeoInHeader(element) {
  var geoAgree = element.text().replace("?", "");
  $(".js-header__geo").text(geoAgree);
  $(".js-geo-value").text(geoAgree);
}

function navigation() {
  var btnNav = $(".js-btn-nav"),
    nav = $(".js-nav-bar"),
    navBody = $(".js-nav-bar__body");

  nav.click(function (e) {
    nav.fadeOut("fast");
    $("body").removeClass("popups-active");
    btnNav.removeClass("btn-nav--is-clicked");
    navBody.removeClass("nav-bar__body--is-active");
  })

  navBody.click(function (e) {
    e.stopPropagation();
  })


  btnNav.click(function () {
    $("body").toggleClass("popups-active");
    btnNav.toggleClass("btn-nav--is-clicked");
    nav.fadeToggle("fast");
    navBody.toggleClass("nav-bar__body--is-active");
  })
}

function search() {
  var btnSearch = $(".js-btn-search"),
    search = $(".js-search"),
    input = $(".js-search__field"),
    btnClose = $(".js-btn-close--search"),
    searchList = $(".js-search-list"),
    btnNav = $(".js-btn-nav"),
    logo = $('.js-logo'),
    shadow = $('.header__bottom');

  btnSearch.click(function () {
    shadow.addClass('header__bottom--is-active')
    search.addClass("search--is-active");
    btnNav.hide("fast");
    logo.hide("fast");
    input.focus();
    $(this).hide();

  })



  btnClose.click(function () {
    search.removeClass("search--is-active");
    searchList.fadeOut("fast");
    btnNav.show("fast");
    logo.show("fast");
    btnSearch.show("fast");
  })

  input.keyup(function () {
    searchList.fadeIn("fast");
    var inputValue = input.val();
    if (inputValue == 0) {
      searchList.fadeOut("fast");
    }
  })

  $(".header-desk__menu-search-field").keyup(function (e) {
    e.stopPropagation();
    searchList.fadeIn("fast");
    var inputValue = $(".header-desk__menu-search-field").val();
    if (inputValue == 0) {
      searchList.fadeOut("fast");
    }
  })
}


function searchUrl() {
  $(".header-desk__menu-search form").submit(function () {
    var inputVal = $(".header-desk__menu-search-field").val();
    var currentUrl = $("location").attr("href");
    $("location").attr("href", currentUrl + inputVal);
  })
}

function deskMenuCatalog() {
  $(".header-desk__bottom .js-open-catalog").click(function (e) {
    e.preventDefault();
    e.stopPropagation();

    $(".header-desk__bottom .header-desk__nav").slideDown("fast");



    $(".header-desk__bottom .header-desk__nav").addClass('header-desk__nav--visible');

	 $(".background-menu-popup").addClass('background-menu-popup-visible');
  })


// $(".header-desk__bottom .header-desk__nav").mouseleave(function (e) {
//   $(this).removeClass('header-desk__nav--visible');
// })
//
	  $(".background-menu-popup").click(function (e) {
    $(".header-desk__bottom .header-desk__nav").removeClass('header-desk__nav--visible');
	$(".background-menu-popup.background-menu-popup-visible").removeClass('background-menu-popup-visible');
  })

$(".header-desk").click(function (e) {
 $(".header-desk__bottom .header-desk__nav").removeClass('header-desk__nav--visible');
	$(".background-menu-popup.background-menu-popup-visible").removeClass('background-menu-popup-visible');
  })



  $(".js-search-list").click(function (e) {
    e.stopPropagation();
  })

}





function indexPageSliders() {

  var introSliderMob = new Swiper('.js-intro__slider--mob', {
    pagination: {
      el: '.js-intro__slider-pagination--mob'
    }
  })


  var introSliderDesk = new Swiper('.js-intro__slider--desk', {
    pagination: {
      el: '.js-intro__slider-pagination--desk'
    }
  })


  var newProdSlider = new Swiper('.js-new-prod__slider', {
    slidesPerView: 'auto',
    spaceBetween: 20,
    breakpoints: {
      767: {
        slidesPerView: 2,
        spaceBetween: 10
      }
    },

    navigation: {
      nextEl: '.new-prod__btn-next',
      prevEl: '.new-prod__btn-prev'
    },
  })

  var stocksSlider = new Swiper(".js-stocks__slider", {
    slidesPerView: 'auto',
    spaceBetween: 20,
    breakpoints: {
      600: {
        spaceBetween: 10
      }
    },

    navigation: {
      nextEl: '.new-prod__btn-next',
      prevEl: '.new-prod__btn-prev'
    }
  })


  var categoryMobile = new Swiper(".real_mobile_categories", {
    slidesPerView: 2,
    spaceBetween: 10,
    slideToClickedSlide: true,
    centerInsufficientSlides: true,
    loop: true,
    longSwipes: false,
    navigation: {
      nextEl: '.cat_mob__btn-next',
      prevEl: '.cat_mob__btn-prev'
    }
  })

  // $(".new-prod__btn-next").click(function() {

  //   if(stocksSlider.isEnd) {
  //     $(".stock__slide").addClass("stock-slide--without-bg")
  //   } else {
  //     $(".stock__slide").removeClass("stock-slide--without-bg")
  //   }

  // })





  var weekSlider = new Swiper(".js-week-prod__slider", {
    slidesPerView: 'auto',
    spaceBetween: 20,
    breakpoints: {
      767: {
        slidesPerView: 2,
        spaceBetween: 10
      }
    },
    navigation: {
      nextEl: '.week-prod__btn-next',
      prevEl: '.week-prod__btn-prev'
    }
  })

  var blogSlider = new Swiper(".js-blog__slider", {
    slidesPerView: 2,
    spaceBetween: 28,
    breakpoints: {
      600: {
        slidesPerView: 'auto',
        spaceBetween: 10
      }
    },
    navigation: {
      nextEl: '.blog__btn-next',
      prevEl: '.blog__btn-prev'
    }
  })

  var viewedProdSlider = new Swiper(".js-viewed-prod__slider", {
    slidesPerView: 'auto',
    spaceBetween: 20,
    breakpoints: {
      767: {
        slidesPerView: 2,
        spaceBetween: 10
      }
    },
    navigation: {
      nextEl: '.viewed-prod__btn-next',
      prevEl: '.viewed-prod__btn-prev'
    }
  })
}

function scrollAnchor() {
var btnst = $('a[href="#start"]');
  $(window).scroll(function() {
    if ($(window).scrollTop() > 400) {
       btnst.addClass('show');
     } else {
       btnst.removeClass('show');
     }
   });
  $('a[href="#start"]').on('click', function (e) {
    e.preventDefault()
    $('html, body').animate({ scrollTop: 0 },
      350,
      'linear'
    )
  });

  $('a[href="#product-info"]').on('click', function (e) {
    e.preventDefault()
    $(".product-info__tab-body").hide();
    $(".product-info__tab-name").removeClass("product-info__tab-name--is-active")
    $("#product-info-name").find(".product-info__tab-name").addClass("product-info__tab-name--is-active")
    $('html, body').animate({ scrollTop: $("#product-info-name").offset().top - 200 },
      350,
      'linear'
    );

    $("#product-info").slideDown();


  })

  $('a[href="#availability"]').on('click', function (e) {
    e.preventDefault()
    $(".product-info__tab-body").hide();
    $(".product-info__tab-name").removeClass("product-info__tab-name--is-active")
    $("#availability-name").find(".product-info__tab-name").addClass("product-info__tab-name--is-active")
    $('html, body').animate({ scrollTop: $("#availability-name").offset().top - 200 },
      350,
      'linear'
    );


    $("#availability").slideDown();
  })


}


function paLogin() {
 /* $(".pa-login__login--clean").click(function (e) {
    e.preventDefault();
    $(".pa-login").fadeIn("fast");
    $("body").addClass("popups-active");
  })

  $(".pa-login__register").click(function (e) {
	e.preventDefault();
    $("body").addClass("popups-active");
    $(".pa-login").fadeOut("fast");
    $(".pa-register").fadeIn("fast");
  })
*/

  $(".pa-register__get-code").submit(function () {
    $(".pa-register").fadeOut("fast");
    $(".pa-register-code").fadeIn("fast");
  })

  $(".pa-register-code").submit(function () {
    $(".pa-register-code").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  // $(".pa-login__recovery-pass").click(function () {
  //   $(".pa-login").fadeOut("fast");
  //   $(".pa-recovery").fadeIn("fast");
  // })

  $(".pa-recovery__submit").submit(function () {
    $(".pa-recovery").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".js-btn-close--pa-login").click(function () {
    $(".pa-login").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".js-btn-close--pa-recovery").click(function () {
    $(".pa-recovery").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".js-btn-close--pa-register").click(function () {
    $(".pa-register").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".js-btn-close--pa-register-code").click(function () {
    $(".pa-register-code").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".btn-send-review").click(function () {
    $(".order-review").fadeIn("fast");
    $("body").addClass("popups-active");
  })

  $(".js-btn-close--order-review").click(function () {
    $(".order-review").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".pa-login").click(function (e) {
    $(".pa-login").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".pa-login__body").click(function (e) {
    e.stopPropagation();
  })

  $(".pa-register").click(function (e) {
    $(".pa-register").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".pa-register__body").click(function (e) {
    e.stopPropagation();
  })

  $(".pa-register-code").click(function (e) {
    $(".pa-register-code").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".pa-register-code__body").click(function (e) {
    e.stopPropagation();
  })

  $(".pa-recovery").click(function (e) {
    $(".pa-recovery").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".pa-recovery__body").click(function (e) {
    e.stopPropagation();
  })

  $(".order-review").click(function (e) {
    $(".order-review").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".order-review__body").click(function (e) {
    e.stopPropagation();
  })

  var paCompareTableSlider = new Swiper('.js-pa-compare-table__slider', {
    slidesPerView: 6,
    spaceBetween: 0,
    breakpoints: {
      767: {
        slidesPerView: 2,
        spaceBetween: 10
      }
    },
    scrollbar: {

      el: '.pa-compare-table__scrollbar',
      draggable: true,
    }
  })

  var paCompareSlider = new Swiper('.js-pa-compare__slider', {
    slidesPerView: 'auto',
    spaceBetween: 20,
    breakpoints: {
      767: {
        slidesPerView: 2,
        spaceBetween: 10
      }
    },

    navigation: {
      nextEl: '.pa-compare__btn-next',
      prevEl: '.pa-compare__btn-prev'
    }
  })

  $(".js-btn-close--compare-item").click(function (e) {
    e.preventDefault();
  })


  var geoItems = $(".js-change-geo-store__item");

  for (var i = 0; i < geoItems.length; i++) {
    $(geoItems[i]).click(function () {
      var val = $(this).text();
      $(".order-delivery__self-geo").text(val);
      $(".js-change-geo-store").fadeOut("fast");
      $("body").removeClass("popups-active");
    })
  }
}
function productPageSliders() {
  var productIntroSlider = new Swiper(".js-product-intro__slider", {
    slidesPerView: 1,
    spaceBetween: 20,
    breakpoints: {
      600: {
        spaceBetween: 10
      }
    },

    navigation: {
      nextEl: '.product-intro__btn-next',
      prevEl: '.product-intro__btn-prev'
    },

    pagination: {
      el: '.js-product-intro__slider-pagination'
    },

    thumbs: {
      swiper: {
        el: '.js-product-intro__slider-thumb',
        slidesPerView: "auto",
        spaceBetween: 20
      }
    }
  })

  var analogProdSlider = new Swiper(".js-analog-prod__slider", {
    slidesPerView: 'auto',
    spaceBetween: 20,
    breakpoints: {
      767: {
        slidesPerView: 2,
        spaceBetween: 10
      }
    },

    navigation: {
      nextEl: '.analog-prod__btn-next',
      prevEl: '.analog-prod__btn-prev'
    }
  })

  var relatedProdSlider = new Swiper(".js-related-prod__slider", {
    slidesPerView: 'auto',
    spaceBetween: 20,
    breakpoints: {
      767: {
        slidesPerView: 2,
        spaceBetween: 10
      }
    },

    navigation: {
      nextEl: '.related-prod__btn-next',
      prevEl: '.related-prod__btn-prev'
    }
  })
}

function productTab() {
  var tabs = $(".product-info__tab");
  var tabsBody = $(".product-info__tab-body");

  if ($(window).width() < 1240) {
    tabs.click(function () {
      $(this).toggleClass("product-info__tab-name--is-active")
    })
  }


  tabs.click(function () {
    var index = $(this).index();
    if ($(window).width() < 1240) {
      $(tabsBody[index]).slideToggle();
      $(this).find(".product-info__tab-name").toggleClass("product-info__tab-name--is-active")
    } else {
      tabsBody.hide();
      $(tabsBody[index]).show();

      $(".product-info__tab-name").removeClass("product-info__tab-name--is-active")
      $(this).find(".product-info__tab-name").addClass("product-info__tab-name--is-active")
    }

    if ($('.tab-body__choice-info').children(':visible').length > 3) {
      $('.tab-body__choice-info').addClass('overflow');
    } else {
      $('.tab-body__choice-info').removeClass('overflow');
    }
  })


  $("#availability .choice-btn").click(function (e) {
    e.preventDefault();
	/*

    if ($(this).hasClass('choice-btn--is-active')) {

      $(this).removeClass("choice-btn--is-active");
      $(this).text('Выбрать');
      if ($(this).hasClass('choice-btn--order')) {
        $(this).text('Под заказ');
      }
    } else {
      $(this).text('Выбрано');
      $(this).addClass("choice-btn--is-active");

    }
	*/
  })

}

$('.mybuttonlol').click(function() {
	let buttonid = $(this).attr('id');
	let url = $(this).attr('data-url');
 let quantity = $(this).attr('data-quantity');
	event.preventDefault();
  $.get( url +"?action=ADD2BASKET&id="+ buttonid +"&ajax_basket=Y&quantity="+ quantity +"&prop[0]=0",  function() { //  передаем и загружаем данные с сервера с помощью HTTP запроса методом GET
	console.log(quantity);
	//console.log(url);
	    })
    });


/* *** */
$('.show_me_order_form').click(function() {
  let id = $(this).attr('id');
  let url = $(this).attr('data-url');
  let current_price = $(this).attr('data-current-price');
  let old_price = $(this).attr('data-old-price');
  let title = $(this).attr('data-name');
  event.preventDefault();
//$('.show_me_order_form').val('Запрос отправлен').prop('disabled', true);
//$(this).html('Запрос отправлен');
$(this).addClass("yellow");
$('.custom_order_form').addClass("show");
//console.log(url);
$(".product_id").val(id);
$(".product_title").val(title);
$(".product_url").val(url);
$(".product_name").text(title);
$(".order_product_price_current").text(current_price);
$(".order_product_price_old").text(old_price);
});

$('.order_close').click(function() {
$('.custom_order_form').hide();
$('.help_me_buy').hide();
});
/* *** */

$(".form_form_order").submit(function (e) {
e.preventDefault();
var form_data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "/12dev/email_send/email_send.php",
                data: form_data,
                success: function () {
                    $('.order_thy').html("<div id='thy_4_order'></div>");
          $('#thy_4_order').html('<h2>Спасибо!<br>Ваш заказ принят</h2><div class="info">Ожидайте звонка оператора, в ближайшее время он свяжется с Вами для уточнения необходимых деталей.<br><br>Если заказ оформлен в ночное время, оператор свяжется с Вами после 9-00 по МСК</div>');
                }
            });
$(".order_info").hide();
//$(".show_me_order_form").html('Запрос отправлен');
        });

$('.order_phone_user').on('input', function() {
    $(this).val($(this).val().replace(/[A-Za-zА-Яа-яЁё]/, ''))
});

$('.order_email_user').on('input', function() {
    $(this).val($(this).val().replace(/[А-Яа-яЁё]/, ''))
});

/* *** */

/* *** */
$('.help_me_btn').click(function() {

$('.help_me_buy').addClass("show");


});

$(".form_form_order_help").submit(function (e) {
e.preventDefault();
var form_data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "/12dev/email_send/email_send_help.php",
                data: form_data,
                success: function () {
                    $('.order_thy_help').html("<div id='thy_4_order_help'></div>");
                    $('#thy_4_order_help').html('<h2>Спасибо!<br>Ваш заказ принят</h2><div class="info">Ожидайте звонка оператора, в ближайшее время он свяжется с Вами для уточнения необходимых деталей.<br><br>Если заказ оформлен в ночное время, оператор свяжется с Вами после 9-00 по МСК</div>');
                }
            });
$(".order_info_help").hide();
//$(".show_me_order_form").html('Запрос отправлен');
        });
/* *** */

$(".js-counter-plus-btn").click(function() {
var value = $(".js-amount-value").val() * 1;
	value = value + 1;
	$(".js-amount-value").val(value);
$('.mybuttonlol.real_order').attr('data-quantity',value);
})
$(".js-counter-minus-btn").click(function() {
var value = $(".js-amount-value").val() * 1;
	value = value - 1;
	if (value > 0) {
	$(".js-amount-value").val(value);
  $('.mybuttonlol.real_order').attr('data-quantity',value);
	}
})
$(".js-amount-value").keyup(function() {
var value = $( this ).val() * 1;
	if (value > 0) {
	$(".js-amount-value").val(value);
  $('.mybuttonlol.real_order').attr('data-quantity',value);
	}
	else  {
$(".js-amount-value").val(1);
	}
})


function counterProd() {
  var prodCountBtnMore = $(".js-counter-more-btn"),
    prodCountBtnLess = $(".js-counter-less-btn"),
    limit = $(".js-counter-limit").text() * 1;

  prodCountBtnMore.click(function () {
    var value = $(".js-counter-value").text() * 1;
    if (value < limit) {
		value = value + 1;
      $(".js-counter-value").text(value)
	  $('.card-prod').data('quantity', value);
    }
  })

  prodCountBtnLess.click(function () {
    var value = $(".js-counter-value").text() * 1;

    if (value > 1) {
		value = value - 1;
      $(".js-counter-value").text(value);
	  $('.card-prod').data('quantity', value);
    }
  })
}

function addToBasket() {
  var btnOpen = $(".js-btn-add-basket"),
    btnClose = $(".js-btn-close--add-basket"),
    popup = $(".js-add-basket");

  btnOpen.click(function () {
    popup.fadeIn("fast");
    $("body").addClass("popups-active");
  })

  btnClose.click(function () {
    popup.fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  popup.click(function (e) {
    popup.fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".add-basket__body").click(function (e) {
    e.stopPropagation();
  })
}


function quickOrder() {
  var btnOpen = $(".js-btn-quick-order"),
    btnClose = $(".js-btn-close--quick-order"),
    popup = $(".js-quick-order");

  btnOpen.click(function () {
    popup.fadeIn("fast");
    $("body").addClass("popups-active");
  })

  btnClose.click(function () {
    popup.fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  popup.click(function (e) {
    popup.fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".quick-order__body").click(function (e) {
    e.stopPropagation();
  })
/**/
$(".no_return_link").click(function (e) {
  e.preventDefault();
  $(".js-popup-no_return").fadeIn("fast");
  $("body").addClass("popups-active");
})
$(".js-btn-close--popup-no_return").click(function () {
  $(".js-popup-no_return").fadeOut("fast");
  $("body").removeClass("popups-active");
})
$(".js-popup-no_return").click(function (e) {
  $(".js-popup-no_return").fadeOut("fast");
  $("body").removeClass("popups-active");
})
/**/

  $(".license__link").click(function (e) {
    e.preventDefault();
    $(".js-popup-licens").fadeIn("fast");
    $("body").addClass("popups-active");
  })

  $(".basket-page__good-license-desc a").click(function (e) {
    e.preventDefault();
    $(".js-popup-licens").fadeIn("fast");
    $("body").addClass("popups-active");
  })

  $(".js-btn-close--popup-licens").click(function () {
    $(".js-popup-licens").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".js-popup-licens").click(function (e) {
    $(".js-popup-licens").fadeOut("fast");
    $("body").removeClass("popups-active");
  })

  $(".quick-order__body").click(function (e) {
    e.stopPropagation();
  })
}

window.addEventListener("load", function()
{
  $("img.lazy").each((i, e) => { $(e).attr("src", $(e).attr("data-original")).css("visibility", "visible") });
});


$('a[href="#opt_contacts"]').on('click', function (e) {
  var id_opt  = $(this).attr('href'),
      top_opt = $(id_opt).offset().top;
  e.preventDefault()
  $('html, body').animate({ scrollTop: top_opt},
    500,
    'linear'
  )
});
let secondlist = $(".header .header-desk .header-desk__bottom .header-desk__nav").width() - 300;
$(".second_list_nav").width(secondlist);
//  let heightlist = $(".header .header-desk .header-desk__bottom .header-desk__nav").height();
// let heightlisttwoitem = $(".second_list_nav .header-desk__nav-list-link").height();
// let heightlisttwo = 0;
// $( ".second_list_nav .header-desk__nav-list-link" ).each(function(heightlisttwoitem) {
//   (heightlisttwo = heightlisttwo + heightlisttwoitem)
// });
// if (heightlisttwo > heightlist) {
//   $(".header-desk__nav-list-item .header-desk__nav-list").css("column-count", "2");
// }
