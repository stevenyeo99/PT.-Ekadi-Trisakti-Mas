/** global variable **/
// var email = "";
var token = "";

$(document).ready(function() {
    // gettingEmailValueOnFirstLoad();
    bindNameAndEmailOnUpdate();
    bindRemoveDivMessage();
    // bindSetEmailAddressValueOnModal();
    bindResetPasswordOnUpdate();
    bindSetAjaxPageToken();
    bindAjaxGenerateToken();
    bindOnHoverFormProfile();
});

function bindOnHoverFormProfile() {
  // user name admin
  $('#userNameArea').mouseenter(function() {
    $('#userNameLabel').show();
  });

  $('#userNameArea').mouseleave(function() {
    $('#userNameLabel').hide();
  });

  // captcha
  $('#captchaArea').mouseenter(function() {
    $('#captchaLabel').show();
  });

  $('#captchaArea').mouseleave(function() {
    $('#captchaLabel').hide();
  });

  // password
  $('#passwordArea').mouseenter(function() {
    $('#passwordLabel').show();
  });

  $('#passwordArea').mouseleave(function() {
    $('#passwordLabel').hide();
  });

  // confirmation password
  $('#confirmPasswordArea').mouseenter(function() {
    $('#confirmPasswordLabel').show();
  });

  $('#confirmPasswordArea').mouseleave(function() {
    $('#confirmPasswordLabel').hide();
  });
}

function bindSetAjaxPageToken()
{
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': token
        }
    });
}

function bindAjaxGenerateToken()
{
    $('#modalResetProfile').click(function() {
        var id = $('#userId').val();
        $.ajax({
            url: "/profile/generatingToken",
            method: "POST",
            data: {id: id},
            success: function(data) {
                $('#token').val(data.token);
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
}

function bindResetPasswordOnUpdate()
{
    $('#btnResetPassword').click(function()
    {
        var password = $('#password').val();
        var confirmation_password = $('#confirmation_password').val();

        if(password.length < 8) {
            alert('Please Input Your Password At Least 8 Characters!');
            return false;
        }

        if(password !== confirmation_password) {
            alert('Please Confirm Your New Password!');
            return false;
        }

        var confirmation = confirm("Are You Sure Want To Change This Password?");
        if(!confirmation) {
            return false;
        }

        $('#frmEditPassword').submit();
    });
}

// function bindSetEmailAddressValueOnModal()
// {
//     $('#emailModal').val(email);
// }

// function gettingEmailValueOnFirstLoad()
// {
//     email = $('#email').val().trim();
// }

function bindRemoveDivMessage() {
    $('#alert-crud').delay(10000).fadeOut(1000);
}

function bindNameAndEmailOnUpdate()
{
    $('#btnUpdateUserNameAndEmail').click(function()
    {
        if($('#name').val() === "") {
            alert("Please Input Your Username!");
            return false;
        }

        // if($('#email').val() === "")
        // {
        //     alert("Please Input Your Email!");
        //     return false;
        // }
        //
        // var checkYahoo = $('#email').val().split('@');
        // if(checkYahoo[1] === 'yahoo.com') {
        //     alert('Yahoo Email Is Not Supported On The Server Right Now!');
        //     return false;
        // }

        // if($('#email').val() === email) {
        //     alert("Please Change Email If Want To Update!");
        //     return false;
        // }

        var confirmation = confirm("Are You Sure Wanna Save This Changes?");
        if(!confirmation)
        {
            return false;
        }

        $('#frmEditUserNameAndEmail').submit();
    })
}

// function getAjaxCheckEmailValidator($email)
// {
//     $.ajax({
//         'url': '/profile/checkEmailValid/'+$email,
//         'method': 'GET',
//         success:function(data) {
//
//         },
//         fail: function(data) {
//
//         }
//     });
// }
