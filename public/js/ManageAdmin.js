$(document).ready(function() {
    bindSetRowNumber();
    $('#dtManageAdmin').DataTable();
    bindAddUserOnClick();
    bindDeleteBtnUserOnClick();
    bindRemoveDivMessage();
    bindSearchOrSortingOnChange();
    bindHoverManageAdminForm();
});

function bindHoverManageAdminForm() {
  $('#usernameArea').mouseenter(function() {
      $('#usernameLabel').show();
  });

  $('#usernameArea').mouseleave(function() {
      $('#usernameLabel').hide();
  });

  $('#passwordArea').mouseenter(function() {
      $('#passwordLabel').show();
  });

  $('#passwordArea').mouseleave(function() {
      $('#passwordLabel').hide();
  });

  $('#confirmPasswordArea').mouseenter(function() {
      $('#confirmPasswordLabel').show();
  });

  $('#confirmPasswordArea').mouseleave(function() {
      $('#confirmPasswordLabel').hide();
  });
}

function bindSearchOrSortingOnChange() {
    $('input[type="search"]').keydown(function() {
      bindSetRowNumber();
    });

    $('th.sorting_asc, th.sorting_desc, th.sorting').click(function() {
      bindSetRowNumber();
    });
}

function bindRemoveDivMessage() {
    $('#alert-crud').delay(10000).fadeOut(1000);
}

function bindDeleteBtnUserOnClick() {
    $('.btnDelete').click(function() {
        var confirmation = window.confirm("Are You Sure Wanna Delete This Admin Account?");
        if(!confirmation) {
          return false;
        }

        $(this).parent().find('input.deleteAdminId').appendTo('form#deleteUserAdmin');
        $('form#deleteUserAdmin').submit();
    });
}

function bindSetRowNumber() {
    var number = 1;
    $('#dtManageAdmin tbody tr').each(function() {
        $(this).find('td:eq(0)').text(number);
        number++;
    });
}

function bindAjaxCheckUserNameAndEmailExistOrNot(name) {
    $.ajax({
      method: "GET",
      data: {name: name},
      url: "/ekadi/admin/manageAdmin/checkUserNameAndEmailAjax",
      success: function(data) {
        var name = data.meetName;
        // var email = data.meetEmail;
        // var validMail = data.validMail;
        if(name === false) {
            var confirm = window.confirm("Are You Sure To Add This Admin Account?");
            if(!confirm) {
              return false;
            }

            $('#frmAddAdminAccountProfile').submit();
        } else {
            var alertValue = "";
            if(name === true) {
              alertValue = "User Name Already Exist Please Choose Another Username!";
            }
            // if(name === true && email === false && validMail == true) {
            //     alertValue = "User Name Already Exist Please Choose Another Username!";
            // } else if(name === false && email === true && validMail == true) {
            //     alertValue = "Email Address Already Exist Please Choose Another Email Address!";
            // } else if(name === false && email === false && validMail == false) {
            //     alertValue = "Your Email Address Doesn't Exist On mail!";
            // } else {
            //     alertValue = "this Username and email already exist please Choose Another And Email Doesnt exist on mail!";
            // }
            alert(alertValue);
            return false;
        }
      },
      fail: function(data) {
          alert("Failed Check Ajax!");
      }
    });
}

function bindAddUserOnClick() {
    $('button#btnAddUserAccount').click(function() {
        var name = $('#name');
        // var email = $('#email');
        var password = $('#password');
        var confirm_password = $('#confirm_password');
        var exceptionYahoo = "yahoo.com";

        var nameValue = name.val();
        // var emailValue = email.val();
        var passwordValue = password.val();
        var confirm_passwordValue = confirm_password.val();

        // var patternEmail = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

        if(nameValue === "") {
            alert("Please Input Admin Name!");
            return false;
        }

        // if(emailValue === "") {
        //     alert("Please Input Admin Email!");
        //     return false;
        // }
        //
        // if(!patternEmail.test(emailValue)) {
        //     alert("Please Input With Valid Mail!");
        //     return false;
        // }
        //
        // if(emailValue.split("@")[1] === exceptionYahoo) {
        //     alert("Please Use Another Mail, Currentlly Yahoo Mail Is Having Issue With this System!");
        //     return false;
        // }

        if(passwordValue === "") {
            alert("Please Input Your Password!");
            return false;
        }

        if(passwordValue.length < 8) {
            alert('Please Input Admin Password At Least 8 Characters!');
            return false;
        }

        if(passwordValue !== confirm_passwordValue) {
            alert('Please Confirm Your New Password!');
            return false;
        }

        bindAjaxCheckUserNameAndEmailExistOrNot(nameValue);
    });
}
