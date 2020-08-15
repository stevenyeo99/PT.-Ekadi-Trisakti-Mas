var modalId = $('#image-gallery');
var current_image = 0;
var selector = 0;
var counter = 0;
$(document).ready(function() {
    bindSetAjaxPageToken();
    bindResetFormOnClick();
    bindSendEmailPostAjax();
    setPlatformForWaPage();
    bindEmailContactFormOnClick();
    loadGallery(true);

    $(document).keydown(function(event) {

        switch(event.which) {
          case 37:
            if((modalId.data('bs.modal') || {})._isShown && $('#show-previous-image').is(":visible")) {
                $('#show-previous-image').click();
            }
            break;

          case 39:
            if((modalId.data('bs.modal') || {})._isShown && $('#show-next-image').is(":visible")) {
                $('#show-next-image').click();
            }
            break;

          default:
            return; // exit this handler for other keys
        }
        event.preventDefault();
    });

});

function openPopUpNewWindows(URL, windowName)
{
    var availHeight = screen.availHeight;
    var availWidth = screen.availWidth;
    var x = 0, y = 0;
    if (document.all) {
        x = window.screentop;
        y = window.screenLeft;
    } else if (document.layers) {
        x = window.screenX;
        y = window.screenY;
    }
    var arguments = 'resizable=1,toolbar=0,location=0,directories=0,addressbar=0,scrollbars=1,status=1,menubar=0,top=0,left=0, screenX=' + x + ',screenY=' + y + ',width=' + availWidth + ',height=' + availHeight;
    newwindow = window.open(URL, windowName, arguments);
    newwindow.moveTo(0, 0);

    return newwindow;
}

//This function disables buttons when needed
function disableButtons(counter_max, counter_current) {
    $('#show-previous-image, #show-next-image').show();
    if(counter_max === counter_current) {
        $('#show-next-image').hide();
    } else if(counter_current === 1) {
        $('#show-previous-image').hide();
    }
}

function loadGallery(setIDs) {
    $('#show-next-image, #show-previous-image').click(function() {
        if($(this).attr('id') === 'show-previous-image') {
            current_image--;
        } else {
            current_image++;
        }

        selector = $('[data-image-id="' + current_image + '"]');
        updateGallery(selector);
    });

    if(setIDs == true) {
        $('[data-image-id]').each(function() {
            counter++;
            $(this).attr('data-image-id', counter);
        });
        if(counter === 1) {
          $('#show-next-image, #show-previous-image').prop('hidden', true);
        }
    }

    $('a.thumbnail').click(function() {
        updateGallery($(this));
    });
}

function updateGallery(selector) {
    var selectorAttribute = selector;
    current_image = selectorAttribute.data('image-id');
    $('#image-gallery-title').text(selectorAttribute.data('title'));
    $('#image-gallery-image').attr('src', selectorAttribute.data('image'));
    disableButtons(counter, selectorAttribute.data('image-id'));
}

function setPlatformForWaPage() {
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        console.log("Mobile");
        $("a#waContact").attr("href", "https://wa.me/6281372647955?text=Halo Steven");
    } else {
        console.log("Website");
        $("a#waContact").attr("href", "https://web.whatsapp.com/send?phone=6281372647955&&text=Halo Steven");
    }
}

function bindEmailContactFormOnClick() {
      $('a#emailContact').click(function() {
          alert("You Can Fill The Contact Form If You Want to Ask Us On Mail :)");
      });
}

function bindSendEmailPostAjax() {
    $('#btnSendMail').click(function(e) {
        var name = $('#txtName');
        var email = $('#txtEmail');
        var subject = $('#txtSubject');
        var message = $('#txtMessage');
        var exceptionYahoo = "yahoo.com";

        var nameValue = name.val().trim();
        var emailValue = email.val().trim();
        var subjectValue = subject.val().trim();
        var messageValue = message.val().trim();

        var patternEmail = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

        if(nameValue === "") {
            alert("Please Input Your Name!");
            return false;
        }

        if(emailValue === "") {
            alert("Please Input Your Email!");
            return false;
        }

        if(!patternEmail.test(emailValue)) {
            alert("Please Input With Valid Mail!");
            return false;
        }

        if(emailValue.split("@")[1] === exceptionYahoo) {
            alert("Please Use Another Mail, Currentlly Yahoo Mail Is Having Issue With Our Site!");
            return false;
        }

        if(subjectValue === "") {
            alert("Please Input Your Subject!");
            return false;
        }

        if(messageValue === "") {
            alert("Please Input Your Message!");
            return false;
        }

        var confirmation = window.confirm("Are You Ready For Sending Mail To US :D");
        if(!confirmation) {
            return false;
        }

        $.ajax({
          url: "/contactFormFooter",
          method: "POST",
          data: {name: nameValue, email: emailValue, subject: subjectValue, message: messageValue},
          success: function(data) {
            if(data.Delivered) {
                alert("Your Mail Has Been Delivered!");
                name.val("");
                email.val("");
                subject.val("");
                message.val("");
            } else {
              alert("Your Mail Cannot Be Delivered, Because Your Mail Doesn't exist!");
            }
          }, fail: function(data) {
              alert("Your Mail Cannot Be Delivered, Because Your Mail Doesn't exist!");
          }
        });
    });
}

function bindSetAjaxPageToken() {
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': token
        }
    });
}

function bindResetFormOnClick() {
    $('#btnReset').click(function() {
        var name = $('#txtName');
        var email = $('#txtEmail');
        var subject = $('#txtSubject');
        var message = $('#txtMessage');

        if(name.val() !== "" || email.val() !== "" || subject.val() !== "" || message.val() !== "") {
            var confirm = window.confirm("Are You Sure Wanna Reset This Form?");
            if(!confirm) {
                return false;
            }
            name.val("");
            email.val("");
            subject.val("");
            message.val("");
        }
    });
}
