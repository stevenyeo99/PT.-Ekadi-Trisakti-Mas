var size = 0;
var widthImageDimension = 0;
var heightImageDimension = 0;
$(document).ready(function() {
    bindSetRowNumber();
    $('#dtSlideShow').DataTable();
    bindSearchOnTrigger();
    bindBtnAddUploadOnClick();
    bindRemoveDivMessage();
    bindTbodyRowOnClick();
    btnUpdateSlideShowImageOnClick();
    btnDeleteSlideShowImageOnClick();
    bindChangeFile();
    bindSearchOrSortingOnChange();
    bindToggleModifyImage();
    bindOnHoverFormSlideShow();
});

function bindOnHoverFormSlideShow() {
  // slideshow file area
    $('#addImageSlideShowArea').mouseenter(function() {
        $('#addImageSlideShowLabel').show();
    });

    $('#addImageSlideShowArea').mouseleave(function() {
        $('#addImageSlideShowLabel').hide();
    });

    // slideshow description area
    $('#addDescSlideShowArea').mouseenter(function() {
        $('#addDescSlideShowLabel').show();
    });

    $('#addDescSlideShowArea').mouseleave(function() {
        $('#addDescSlideShowLabel').hide();
    });

    // form edit
    // slideshow check box area
    $('#modifyImageChkArea').mouseenter(function() {
        $('#modifyImageChkLabel').show();
    });

    $('#modifyImageChkArea').mouseleave(function() {
        $('#modifyImageChkLabel').hide();
    });

    // input file slideshow
    $('#bodyUploadImage').mouseenter(function() {
        $('#bodyUploadImageLabel').show();
    });

    $('#bodyUploadImage').mouseleave(function() {
        $('#bodyUploadImageLabel').hide();
    });

    // slideshow description
    $('#modifyDescriptionArea').mouseenter(function() {
        $('#modifyDescriptionLabel').show();
    });

    $('#modifyDescriptionArea').mouseleave(function() {
        $('#modifyDescriptionLabel').hide();
    });
}

function bindToggleModifyImage() {
    $('#changeImage').change(function() {
        if($(this).is(':checked')) {
            $('div#bodyUploadImage').prop("hidden", false);
        } else {
            $('div#bodyUploadImage').prop("hidden", true);
        }
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

function bindSetRowNumber() {
    var number = 1;
    $('#dtSlideShow tbody tr').each(function() {
        if(!$(this).find('td:eq(0)').hasClass('dataTables_empty')) {
          $(this).find('td:eq(0)').text("");
          $(this).find('td:eq(0)').append(number);
          number++;
        }
    });
}

function bindSearchOnTrigger() {
    $('input[type="search"]').keyup(function() {
        bindSetRowNumber();
    });
}

function bindChangeFile()
{
    $('#file_name, #input_file_name').bind('change', function()
    {
        var fileImageObject = $(this);
        size = fileImageObject[0].files[0].size;
        var splittedByBackSlash = $(this).val().split("\\");
        var imageValue = splittedByBackSlash[splittedByBackSlash.length - 1];

        var extension = imageValue.substring(imageValue.lastIndexOf('.') + 1).toLowerCase();

        if(extension === "jpeg" || extension === "jpg" || extension === "png") {
            // check whether html5 is supported.
            if(typeof(fileImageObject[0].files) != "undefined") {
                // initiate the file reader object
                var reader = new FileReader();
                // Read the contents of the image
                reader.readAsDataURL(fileImageObject[0].files[0]);
                reader.onload = function(e) {
                  // initiate the javascript image object
                  var image = new Image();
                  // Set the Base64 string return from FileReader as source
                  image.src = e.target.result;
                  image.onload = function() {
                      // determine the width and height
                      widthImageDimension = this.width;
                      heightImageDimension = this.height;
                  }
                }
            }
        }
    });
}

function bindBtnAddUploadOnClick() {
    $('#btnAddImage').click(function() {

        var imageEmpty = "Please Choose Your Image";
        if($('#file_name').val() == "") {
            alert(imageEmpty);
            return false;
        }

        if(size > 2000000) {
          alert('Your Image Cannot Bigger Than 2 MB!');
          return false;
        }

        if(widthImageDimension < 1200 || heightImageDimension < 500) {
            alert('Please Upload Image On SlideShow With Minimum Width = 1200px and height = 500px!');
            return false;
        }

        if($('#alt').val() == "") {
            alert("Please Fill Your Slide Show Image Description");
            return false;
        }

        if($('#alt').val().length < 3) {
            alert("Description Minimum 3 word!");
            return false;
        }

        var confirmation = confirm("Are You Sure Want To Upload This Picture For Slide Show?");
        if(!confirmation) {
            return false;
        }
        $('#frmUploadFile').submit();
    });
}

function bindRemoveDivMessage() {
    $('#alert-crud').delay(10000).fadeOut(1000);
}

function bindTbodyRowOnClick() {
    $('#dtSlideShow tbody').on('click', 'tr', function() {
        setDataToModalBox(this);
    });
}

function setDataToModalBox(dtRow) {
    var dataTable = $('#dtSlideShow').DataTable();

    var dtRow = dataTable.row(dtRow).data();

    $('#hiddenId').val(dtRow[2]);
    // alert($(dtRow[1]).filter('span').text());
    $('#file_nameOld').val($(dtRow[1]).filter('span').text());
    $('#altModal').val($(dtRow[3]).filter('span').text());
}

function btnUpdateSlideShowImageOnClick() {
    $('#btnUpdateSlideShowImage').click(function() {

        if($('#changeImage').is(':checked')) {
            if($('#input_file_name').val() == "") {
                alert("Please Choose Your Image That Want To Be Updated!");
                return false;
            }

            if(size > 2000000) {
              alert('Your Image Cannot Bigger Than 2 MB!');
              return false;
            }

            if(widthImageDimension < 1200 || heightImageDimension < 500) {
                alert('Please Upload Image On SlideShow With Minimum Width = 1200px and height = 500px!');
                return false;
            }
        }

        if($('#altModal').val() == "") {
            alert("Please Fill Your Slide Show Image Description");
            return false;
        }

        if($('#altModal').val().length < 3) {
            alert("Description Minimum 3 word!");
            return false;
        }

        var confirmation = confirm("Are You Sure Want To Update This Image?");
        if(!confirmation) {
            return false;
        }

        $('#frmActionSlideShow').attr({'action': '/ekadi/admin/slideshowUpdate', 'method' : 'POST'});
        $('#frmActionSlideShow').submit();
    });
}

function btnDeleteSlideShowImageOnClick() {
    $('#btnDeleteSlideShowImage').click(function() {
        var confirmation = confirm("Are You Sure Want To Delete This Image?");
        if(!confirmation) {
          return false;
        }
        $('#frmActionSlideShow').attr({'action': '/ekadi/admin/slideShowDelete', 'method' : 'POST'});
        $('#frmActionSlideShow').submit();
    });
}
