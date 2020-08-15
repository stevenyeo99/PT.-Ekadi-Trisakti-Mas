$(document).ready(function() {
  spinner_loading();
  bindButtonSideToggleOnClick();
  // setTinymceEditor();
});

/* Spinner Loading */
function spinner_loading() {
  var div_box = "<div id='load-screen'><div id='loading'></div></div>";
  $("body").prepend(div_box);
  $("#load-screen").delay(700).fadeOut(600, function() {
      $(this).remove();
  });
}

function bindButtonSideToggleOnClick() {
    $('button#sidebarToggle').click(function() {
        showMenuDropDownSideBar();
    });
}

function showMenuDropDownSideBar()
{
    var dropdownItem = $('li.dropdown');
    var dropdownMenu = $('div.dropdown-menu');
    $.each(dropdownItem, function() {
        if($(this).hasClass('show')) {
            if($('ul.sidebar').hasClass('toggled')) {
                $(this).find(dropdownMenu).removeClass('show');
            } else {
                $(this).find(dropdownMenu).addClass('show');
            }
        }
    });
}
