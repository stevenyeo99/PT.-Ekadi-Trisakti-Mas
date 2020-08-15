var size = 0;
var widthImageDimension = 0;
var heightImageDimension = 0;
$(document).ready(function() {
  $('#dtManageGallery').dataTable();
  bindSetChosenWidthOnModal();
  bindGetPostIdGallery();
  bindSearchOrSortingOnChange();
  bindSetRowNumber();
  bindBtnAddUploadOnClick();
  bindChangeFile();
  bindBtnUpdateOnClick();
  bindAppendIdHidden();
  bindDeleteImage();
  bindRemoveDivMessage();
  bindToggleModifyImage();

  $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox();
  });
  bindHoverGaleryForm();
});

function bindHoverGaleryForm() {
  $('#typeArea').mouseenter(function() {
    $('#typeLabel').show();
  });

  $('#typeArea').mouseleave(function() {
    $('#typeLabel').hide();
  });

  $('#galleryAddImageArea').mouseenter(function() {
    $('#galleryAddImageLabel').show();
  });

  $('#galleryAddImageArea').mouseleave(function() {
    $('#galleryAddImageLabel').hide();
  });

  $('#galleryAddDescArea').mouseenter(function() {
    $('#galleryAddDescLabel').show();
  });

  $('#galleryAddDescArea').mouseleave(function() {
    $('#galleryAddDescLabel').hide();
  });

  $('#changeImageArea').mouseenter(function() {
    $('#changeImageLabel').show();
  });

  $('#changeImageArea').mouseleave(function() {
    $('#changeImageLabel').hide();
  });

  $('#bodyUploadImage').mouseenter(function() {
    $('#bodyUploadImageLabel').show();
  });

  $('#bodyUploadImage').mouseleave(function() {
    $('#bodyUploadImageLabel').hide();
  });

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

function bindRemoveDivMessage() {
    $('#alert-crud').delay(10000).fadeOut(1000);
}

function bindDeleteImage() {
    $('.deleteBtnImage').click(function() {
        var id = $(this).siblings('input[id="id"]').val();
        $('#deleteId').val(id);

        var confirmation = confirm("Are You Sure Want To Delete This Image?");
        if(!confirmation) {
          return false;
        }

        $('#frmDeleteImage').submit();
    });
}

function bindAppendIdHidden() {
    $('.appendIdBtn').click(function() {
        var id = $(this).siblings('input[id="id"]').val();
        var post_id = $(this).siblings('input[id="post_id"]').val();
        $('#post_id_edit').val(post_id);
        $('#edit_id').val(id);
        var description = $(this).parent().parent().find('td:eq(3) input[type="hidden"]').val();
        $('#edit_description').val(description);
    });
}

function bindChangeFile()
{
    $('#file_name, #input_file_name').bind('change', function() {
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

function bindBtnUpdateOnClick() {
    $('#btnEditImage').click(function() {
        var imageEmpty = "Please Choose Your Image";

        if($('#changeImage').is(':checked')) {
            if($('#input_file_name').val() == "") {
                alert(imageEmpty);
                return false;
            }

            if(size > 2000000) {
              alert('Your Image Cannot Bigger Than 2 MB!');
              return false;
            }

            if(widthImageDimension < 1000 || heightImageDimension < 500) {
                alert('Please Upload Image On SlideShow With Minimum Width = 1000px and height = 500px!');
                return false;
            }
        }

        if($('#edit_description').val() === "") {
            alert("Please Input Your Image Description!");
            return false;
        }

        // alert($('#description').val().length);
        if($('#edit_description').val().length < 4) {
            alert("Please Your Word Dont less then 4 words!");
            return false;
        }

        var confirmation = confirm("Are You Sure Want To Modify This?");
        if(!confirmation) {
            return false;
        }
        $('#frmEditImage').submit();
    });
}

function bindBtnAddUploadOnClick() {
    $('#btnAddPhoto').click(function() {
        var imageEmpty = "Please Choose Your Image";
        if($('#file_name').val() == "") {
            alert(imageEmpty);
            return false;
        }

        if(size > 2000000) {
          alert('Your Image Cannot Bigger Than 2 MB!');
          return false;
        }

        if(widthImageDimension < 1000 || heightImageDimension < 500) {
            alert('Please Upload Image On SlideShow With Minimum Width = 1000px and height = 500px!');
            return false;
        }

        if($('#description').val() === "") {
            alert("Please Input Your Image Description!");
            return false;
        }

        // alert($('#description').val().length);
        if($('#description').val().length < 4) {
            alert("Please Your Word Dont less then 4 words!");
            return false;
        }

        var confirmation = confirm("Are You Sure Want To Upload This Picture For Product?");
        if(!confirmation) {
            return false;
        }
        $('#frmAddPhoto').submit();
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
    $('#dtManageGallery tbody tr').each(function() {
        if(!$(this).find('td:eq(0)').hasClass('dataTables_empty')) {
          $(this).find('td:eq(0)').text(number);
          number++;
        }
    });
}
function bindSetChosenWidthOnModal() {
    var id = '#ddlType';
    $(id).chosen();
    $(id).siblings().css("width", "100%");
}

function bindGetPostIdGallery() {
    $('#ddlType').change(function() {
        var form = $('<form>').attr({method: 'GET', action: '/ekadi/admin/manageGallery/Gallery'});
        var input = $('<input>').attr({name: 'post_id', value: $(this).val()});
        input.appendTo(form);
        $(document.body).append(form);
        form.submit();
    });
}
