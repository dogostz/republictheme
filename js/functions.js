(function ($, document, window) {

    $(document).ready(function () {

        var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

        if (isMobile) {
            getPropertyImages();

            $('.range-slider').hide();
            $('.mobile-range-values').show();
        }

        detectPhoneNumbers();

        $('.assoc-broker').on('change', 'select', function () {
            var value = $(this).val();
            window.location.href = value;
        });

        $('#search-in-filter').on('change', function (e) {
            e.preventDefault();
            var formURL = $(this).find(':selected').data('url');
            $(this).parents('form').attr('action', formURL);
        });

        $('.quick-search').on('click', 'input', function (e) {
            e.preventDefault();

            var formURL = $(this).data('url'),
                $form = $('.form-fast-search form');

            $form.attr('action', formURL);
            $form.trigger('submit');
        });

        $('.map').find('g').filter("[id]").each(function () {
            $(this).on('click', function () {

                var $that = $(this),
                    title = $that.attr('title');

                var titleAlt = '';
                if ($that.attr('data-sp-case') && $that.attr('data-sp-case').length > 0) {
                    titleAlt = $that.attr('data-sp-case');
                }

                $('.areas-filter li').each(function () {

                    var areaLabel = $(this).find('label').text(),
                        $input = $(this).find('input');

                    if (areaLabel === title || areaLabel === titleAlt) {
                        if ($input.is(':checked')) {
                            $input.prop('checked', false);
                            $that.removeAttr('class');
                        } else {
                            $input.prop('checked', true);
                            $that.attr('class', 'item-selected');
                        }
                    }

                });

            });
        });

        $('.areas-filter').on('click', 'input', function () {

            var $input = $(this),
                $areaLabel = $input.siblings('label'),
                text = $areaLabel.text();

            if ($areaLabel.data('sp-case').length > 0) {
                text = $areaLabel.data('sp-case');
            }

            var $mapArea = $('.map g[title="' + text + '"]');

            if ($input.is(':checked')) {
                $mapArea.attr('class', 'item-selected');
            } else {
                $mapArea.removeAttr('class');
            }

        });

        $('.form-controls').on('click', '.dd-filter-head', function () {
            $(this)
                .parent('.dd-filter')
                .find('.dd-filter-inner')
                .slideToggle(400);
        });

        gf_placeholder();
        $(document).bind('gform_page_loaded', gf_placeholder);

        $('.property-seconadary:nth-child(2n)').addClass('second');

        // HOME PAGE INTRO
        $('.intro .flexslider').flexslider({
            animation: "fade",
            start: function (slider) {
                $('.intro a.slider-prev').on('click', function (e) {
                    e.preventDefault()
                    slider.flexAnimate(slider.getTarget("next"));
                })

                $('.intro a.slider-next').on('click', function (e) {
                    e.preventDefault()
                    slider.flexAnimate(slider.getTarget("prev"));
                })
            },
            before: function (slider) {
                $('.slider-content').addClass('hide')
            },
            after: function () {
                $('.slider-content').removeClass('hide')
            }
        })

        $('.intro .flexslider .slide').each(function () {
            var currentImage = $(this).find('.slide-image img').attr('src')
            $(this).find('.slide-image').css({
                backgroundImage: 'url(' + currentImage + ')'
            })
        })

        $('.intro-secondary').each(function () {
            var currentImage = $(this).find('.intro-image').attr('src')
            $(this).css({
                backgroundImage: 'url(' + currentImage + ')'
            })
        })

        // HOME PAGE MOST VIEWED
        $('.slider-secondary .flexslider').flexslider({
            animation: "slide",
            slideshow: false,
            start: function (slider) {
                $('.slider-secondary a.slider-next').on('click', function (e) {
                    e.preventDefault()
                    slider.flexAnimate(slider.getTarget("prev"));
                })

                $('.slider-secondary a.slider-prev').on('click', function (e) {
                    e.preventDefault()
                    slider.flexAnimate(slider.getTarget("next"));
                })
            }
        });

        $('.link-menu').on('click', function (e) {

            var status = $(this).data('status');

            switch (status) {
                case 'off':
                    $(this).data('status', 'on');
                    createCookie('navigation-status', 'on', 356);
                    break;
                case 'on':
                    $(this).data('status', 'off');
                    createCookie('navigation-status', 'off', 356);
                    break;
            }

            $('.nav').toggleClass('open');

            e.preventDefault();
        });

        $("a.link-top").click(function (e) {
            e.preventDefault()
            $("html, body").animate({scrollTop: 0});
        });

        $('#sale').fadeIn();

        $('.map g[alt]').hover(function () {
            $(this).attr("style", "fill:#ed5348;")
            var currentTitle = $(this).attr('title')
            $('.map-title').text(currentTitle)
        }, function () {
            var oldStyle = $(this).attr('fill')
            $(this).attr("style", oldStyle)
            $('.map-title').text("")
        })

        $("#fileuploader").uploadFile({
            url: "css/images",
            fileName: "myfile",
            dragDropStr: "<span><b>Провлачи &amp; Пусни Файл</b></span>",
            abortStr: "Спри",
            cancelStr: "Cancel",
            deletelStr: "Изтрии",
            doneStr: "Готово",
            extErrorStr: "Не е позволено. Позволени файлове: ",
            sizeErrorStr: "Не е позволено. Позволен максимален размер: ",
            uploadErrorStr: "Качването не е позволено"
        });

        $('.slider-secondary').each(function () {
            var currentLeft = $('.section-head-primary h1 span').width()
            $(this).find('.slider-actions').css({left: currentLeft + 8})
        })

        $(".list-galleries li a").fancybox({
            loop: true,
            arrows: true,
            infobar: true,
            mobile: {
                // arrows: true,
                // thumbs: {
                //     autoStart: false
                // },
                preventCaptionOverlap: false,
                idleTime: false,
                clickContent: function (current, event) {
                    console.log(current, event)
                    return current.type === "image" ? "zoom" : false;
                },
                // dblclickContent: function(current, event) {
                //     return false;
                // }
            },
            buttons: [
                "zoom",
                // "share",
                "slideShow",
                // "fullScreen",
                // "download",
                "thumbs",
                "close"
            ],
            animationEffect: "fade",
            animationDuration: 400,
            transitionEffect: "slide",
            transitionDuration: 400
            // Goes to next image on click - rather than zoom
            // clickContent: function (current, event) {
            //     return current.type === "image" ? "next" : false;
            // }
        });

        $('.form-btn-trigger').fancybox({
            animationEffect: "fade",
            animationDuration: 400
        });

        $(document)
            .find('.add-video-link a')
            .addClass('youtube-video fancyboxiframe');

        $('.youtube-video').fancybox({
            type: 'iframe',
            scrolling: 'no',
            maxWidth: 800,
            maxHeight: 600,
            fitToView: false,
            width: '70%',
            height: '70%',
            autoSize: false,
            closeClick: false,
            openEffect: 'elastic',
            closeEffect: 'none',
        });

        // Init the range sliders

        var $sqfSlider = $('#slider-sqf'),
            $priceSlider = $('#slider-price'),
            $sqfpSlider = $('#slider-price-sqf');

        var sqfValueMin = $sqfSlider.find('.sqf-min').val(),
            sqfValueMax = $sqfSlider.find('.sqf-max').val();

        $sqfSlider.find('.slider-range').slider({
            min: 0,
            max: 500,
            step: 1,
            values: [sqfValueMin, sqfValueMax],
            range: true,
            slide: function (event, ui) {
                var values = ui.values,
                    min = values[0],
                    max = values[1];

                $sqfSlider.find('.range-from span').text(min);
                $sqfSlider.find('.range-to span').text(max);

                $('.sqf-min').val(min);
                $('.sqf-max').val(max);
            }
        });

        var priceMin = $priceSlider.find('.price-min').val(),
            priceMax = $priceSlider.find('.price-max').val();

        $priceSlider.find('.slider-range').slider({
            min: 0,
            max: 300000,
            step: 500,
            values: [priceMin, priceMax],
            range: true,
            slide: function (event, ui) {
                var values = ui.values,
                    min = values[0],
                    max = values[1];

                $priceSlider.find('.range-from span').text(min);
                $priceSlider.find('.range-to span').text(max);

                $('.price-min').val(min);
                $('.price-max').val(max);
            }
        });

        var sqfpValueMin = $sqfpSlider.find('.sqfp-min').val(),
            sqfpValueMax = $sqfpSlider.find('.sqfp-max').val();

        $sqfpSlider.find('.slider-range').slider({
            min: 0,
            max: 2000,
            step: 1,
            values: [sqfpValueMin, sqfpValueMax],
            range: true,
            slide: function (event, ui) {
                var values = ui.values,
                    min = values[0],
                    max = values[1];

                $sqfpSlider.find('.range-from span').text(min);
                $sqfpSlider.find('.range-to span').text(max);

                $('.sqfp-min').val(min);
                $('.sqfp-max').val(max);
            }
        });

    }) // End Document Ready

    function getPropertyImages() {
        $('.item').on('click', '.listing-item', function (e) {
            e.preventDefault();

            let $this = $(this),
                itemId = $this.data('property-id');

            $.ajax({
                type: "post",
                dataType: "json",
                url: wp_common_ajax.ajax_url,
                data: {
                    action: "get_property_images",
                    propertyId: itemId
                },
                success: function (msg) {
                    if (msg.success) {
                        $.fancybox.open(msg.data, {
                            spinnerTpl: '<div class="fancybox-loading"></div>',
                            loop: false
                        });
                    }
                }
            });
        });
    }

    function createCookie(name, value, days) {

        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            var expires = "; expires=" + date.toGMTString();
        } else {
            var expires = "";
        }

        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function detectPhoneNumbers() {
        let $body = $('body');

        if (!$body.hasClass('page-template-default') && !$body.hasClass('single-property')) {
            return;
        }

        $(".content .post, .estate .estate-body").filter(function () {
            let html = $(this).html();

            let phonePattern = /(\d{4}\s\d{3}\s\d{3})|(\d{3}\/\s\d{3}\s\d{3})|(\d{10})/g;

            let matchedString = $(this).html().match(phonePattern);
            if (matchedString) {
                let text = $(this).html();

                $.each(matchedString, function (index, value) {
                    let phone = value.replace(/\/| /g, '');
                    text = text.replace(value, "<a href='tel:" + phone + "'>" + value + "</a>");
                });
                $(this).html(text);

                return $(this)
            }
        });
    }

    var gf_placeholder = function () {
        $('.gform_wrapper')
            .find('input, textarea').filter(function (i) {
            var $field = $(this);

            if (this.nodeName == 'INPUT') {
                var type = this.type;
                return !(type == 'hidden' || type == 'file' || type == 'radio' || type == 'checkbox');
            }

            return true;
        })
            .each(function () {
                var $field = $(this);

                var id = this.id;
                var $labels = $('label[for=' + id + ']').hide();
                var label = $labels.last().text();

                if (label.length > 0 && label[label.length - 1] == '*') {
                    label = label.substring(0, label.length - 1) + ' *';
                }

                $field[0].setAttribute('placeholder', label);
            });

        var support = (!('placeholder' in document.createElement('input'))); // borrowed from Modernizr.com
        if (support && jquery_placeholder_url)
            $.ajax({
                cache: true,
                dataType: 'script',
                url: jquery_placeholder_url,
                success: function () {
                    $('input[placeholder], textarea[placeholder]').placeholder({
                        blankSubmit: true
                    });
                },
                type: 'get'
            });
    }

    $.fn.hasAttr = function (name) {
        return this.attr(name) !== undefined;
    };

}(jQuery, document, window));