

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

       /*------------------
            FIlter
        --------------------*/
        $('.filter__controls li').on('click', function () {
            $('.filter__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.filter__gallery').length > 0) {
            var containerEl = document.querySelector('.filter__gallery');
            var mixer = mixitup(containerEl);
        }

        if($('.filter__game').length > 0){
            var containerE2 = document.querySelector('.filter__game');
            var selectFilter2 = document.querySelector('.filter__select');
            var selectSort = document.querySelector('.filter__sort');
            var selectFilter3 = document.querySelector('.filter__price');
            var mixer2 = mixitup(containerE2, {
                pagination: {
                    limit:12
                }
            });

            $('.filter__select').on('change', function () {
                $.ajax({
                    url: "function.php?op=selectGame",
                    data: $('#select_form').serialize(),
                    type: "POST",
                    dataType: 'text',
                    success: function(msg) {
                        $("#show_msg").html(msg);//顯示訊息
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if(selectFilter3.value == "all")
                    var selector1 = selectFilter2.value;
                else if(selectFilter2.value == "all")
                    var selector1 = selectFilter3.value;
                else
                    var selector1 = selectFilter2.value + selectFilter3.value;
                
                mixer2.filter(selector1);

                if(selectFilter2.value == ".leisure")
                    $('#type_path').text("休閒");
                else if(selectFilter2.value == ".adventure")
                    $('#type_path').text("冒險");
                else if(selectFilter2.value == ".action")
                    $('#type_path').text("動作");
                else if(selectFilter2.value == ".tactic")
                    $('#type_path').text("策略");
                else if(selectFilter2.value == ".cardType")
                    $('#type_path').text("卡牌");
                else if(selectFilter2.value == ".car")
                    $('#type_path').text("汽機車模擬");
                else if(selectFilter2.value == ".terrible")
                    $('#type_path').text("恐怖");
                else if(selectFilter2.value == ".firstPerson")
                    $('#type_path').text("第一人稱");
                else if(selectFilter2.value == ".single")
                    $('#type_path').text("單人");
                else if(selectFilter2.value == ".multiperson")
                    $('#type_path').text("多人");
                else if(selectFilter2.value == "all")
                    $('#type_path').text("所有類型");

                if(selectFilter3.value == ".free")
                    $('#path').text("免費遊戲");
                else if(selectFilter3.value == ".pay")
                    $('#path').text("付費遊戲");
                else if(selectFilter3.value == "all")
                    $('#path').text("所有遊戲");
                else if(selectFilter3.value == ".like")
                    $('#path').text("我的追隨");
                    
                
            });

            $('.filter__sort').on('change', function () {
                var order = selectSort.value;
                mixer2.sort(order);
            });

            $('.filter__price').on('change', function () {
                $.ajax({
                    url: "function.php?op=selectGame",
                    data: $('#select_form').serialize(),
                    type: "POST",
                    dataType: 'text',
                    success: function(msg) {
                        $("#show_msg").html(msg);//顯示訊息
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if(selectFilter2.value == "all")
                    var selector2 = selectFilter3.value;
                else if(selectFilter3.value == "all")
                    var selector2 = selectFilter2.value;
                else
                    var selector2 = selectFilter2.value + selectFilter3.value;

                mixer2.filter(selector2);

                if(selectFilter2.value == ".leisure")
                    $('#type_path').text("休閒");
                else if(selectFilter2.value == ".adventure")
                    $('#type_path').text("冒險");
                else if(selectFilter2.value == ".action")
                    $('#type_path').text("動作");
                else if(selectFilter2.value == ".tactic")
                    $('#type_path').text("策略");
                else if(selectFilter2.value == ".cardType")
                    $('#type_path').text("卡牌");
                else if(selectFilter2.value == ".car")
                    $('#type_path').text("汽機車模擬");
                else if(selectFilter2.value == ".terrible")
                    $('#type_path').text("恐怖");
                else if(selectFilter2.value == ".firstPerson")
                    $('#type_path').text("第一人稱");
                else if(selectFilter2.value == ".single")
                    $('#type_path').text("單人");
                else if(selectFilter2.value == ".multiperson")
                    $('#type_path').text("多人");
                else if(selectFilter2.value == "all")
                    $('#type_path').text("所有類型");

                if(selectFilter3.value == ".free")
                    $('#path').text("免費遊戲");
                else if(selectFilter3.value == ".pay")
                    $('#path').text("付費遊戲");
                else if(selectFilter3.value == "all")
                    $('#path').text("所有遊戲");
                else if(selectFilter3.value == ".like")
                    $('#path').text("我的追隨");
            });
        }    
    });
    

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    // Search model
    $('.search-switch').on('click', function () {
        $('.search-model').fadeIn(400);
    });

    $('.search-close-switch').on('click', function () {
        $('.search-model').fadeOut(400, function () {
            $('#search-input').val('');
        });
    });
    /*------------------
        DataTable
    --------------------*/

    //Edit Model

    $(document).on('click', '.edit-switch' , function () {
        $('.edit-model').fadeIn(400);
    });

    //View Model
    $('.view-switch').on('click', '.view-switch' , function () {
        $('.view-model').fadeIn(400);
    });
    $(document).on('click', '.view-switch' , function () {
        $('.view-model').fadeIn(400);
    });

    $('.view-close-switch').on('click', function () {
        $('.view-model').fadeOut(400, function () {
            $('#view-input').val('');
        });
    });


    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*------------------
		Hero Slider
	--------------------*/
    var hero_s = $(".hero__slider");
    hero_s.owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: true,
        nav: true,
        navText: ["<span class='arrow_carrot-left'></span>", "<span class='arrow_carrot-right'></span>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        mouseDrag: false
    });

    /*------------------
        Video Player
    --------------------*/
    const player = new Plyr('#player', {
        controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'captions', 'settings', 'fullscreen'],
        seekTime: 25
    });

    /*------------------
        Niceselect
    --------------------*/
    $('select').niceSelect();

    /*------------------
        Scroll To Top
    --------------------*/
    $("#scrollToTopButton").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
     });

})(jQuery);