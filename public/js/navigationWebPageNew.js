$(document).ready(function() {
    bindMenuToggleOnClick();
    bindDropDownMenuOnClick();
    bindDisplayPageContent();
    // bindCheckModalOnWindow();
    bindSubNavigationActive();
    bindOnClickSubNav();
});

function bindSubNavigationActive() {
    var subMenuMainCategory = $('li.sub-menu');
    if(subMenuMainCategory.find('ul li a').hasClass('active') && !subMenuMainCategory.children('a').hasClass('active')) {
        subMenuMainCategory.find('ul li a').removeClass('active');
        subMenuMainCategory.children('a').addClass('active');
    } else {
        subMenuMainCategory.children('a').removeClass('active');
        if(subMenuMainCategory.find('ul li a').data('selected') === 'yes') {
          // alert('hai');
          $(subMenuMainCategory).find('ul li a[data-selected]').addClass('active');
        }
    }
}

function bindOnClickSubNav() {
    $('li.sub-menu').click(function() {
        bindSubNavigationActive();
    });
}

function bindCheckModalOnWindow() {
    if($(window).width() >= 992) {
        $('#image-gallery').css("margin-top", "5%");
    } else {
        $('#image-gallery').css("margin-top", "30%");
    }
}

function bindDisplayPageContent() {
    $(window).resize(function() {
        if($(window).width() >= 992) {
            $('div#navChooseToggle').css("display", "block");
            $('footer#footerContact div#content').css("display", "block");
            $('#image-gallery').css("margin-top", "0px");
            $('#image-gallery').css("margin-top", "5%");
        } else {
          // if($(window).width() <= 990) {
          //   $('#image-gallery').css("margin-top", "0px");
          //   $('#image-gallery').css("margin-top", "30%");
          // }
          if($('nav').hasClass('active')) {
              $('div#navChooseToggle').css("display", "none");
              $('footer#footerContact div#content').css("display", "none");
          }
        }
    });
}

function bindMenuToggleOnClick() {
    $('.menu-toggle').click(function() {
        $('nav').toggleClass('active');
        $('div#navChooseToggle').toggle();
        $('div.body-content').toggle();
        $('footer#footerContact div#content').toggle();
    });
}

function bindDropDownMenuOnClick() {
    $('ul li').click(function() {
      $(this).siblings().removeClass('active');
      $(this).toggleClass('active');
    });
}
