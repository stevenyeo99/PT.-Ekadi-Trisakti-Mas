var fileSize = 0;
$(document).ready(function() {
  bindSetRowNumber();
  $('#dtManageBrowsure').DataTable();
  bindSetChosenWidthOnModal();
  bindAddBrowsureToProduct();
  bindChangeProductOption();
  bindProductRowValue();
  bindUpdateBrowsureOnClick();
  bindToogleEditBrowsure();
  bindDropDownEditOnChange();
  bindDeleteBrowsureOnClick();
  bindRemoveDivMessage();
  bindChangeFile();
  bindHoverBrochureForm();
});

function bindHoverBrochureForm() {
  $('#productAreaCreate').mouseenter(function() {
    $('#productLabelCreate').show();
  });

  $('#productAreaCreate').mouseleave(function() {
    $('#productLabelCreate').hide();
  });

  $('#productFileCreateArea').mouseenter(function() {
    $('#productLabelCreateArea').show();
  });

  $('#productFileCreateArea').mouseleave(function() {
    $('#productLabelCreateArea').hide();
  });

  $('#editBrocureArea').mouseenter(function() {
    $('#editBrocureLabel').show();
  });

  $('#editBrocureArea').mouseleave(function() {
    $('#editBrocureLabel').hide();
  });

  $('#editBrocureArea').mouseenter(function() {
    $('#editBrocureLabel').show();
  });

  $('#editBrocureArea').mouseleave(function() {
    $('#editBrocureLabel').hide();
  });

  $('#editFileBrochureArea').mouseenter(function() {
    if($('#pdfPreview').prop('hidden') === false) {
        $('#editBrocureALabel').show();
    } else {
        $('#editBrocureFileFileLabel').show();
    }
  });

  $('#editFileBrochureArea').mouseleave(function() {
    if($('#pdfPreview').prop('hidden') === false) {
        $('#editBrocureALabel').hide();
    } else {
        $('#editBrocureFileFileLabel').hide();
    }
  });

  $('#createProductDDLArea').mouseenter(function() {
        $('#createProductDDLLabel').show();
  });

  $('#createProductDDLArea').mouseleave(function() {
        $('#createProductDDLLabel').hide();
  });
}

function bindChangeFile()
{
    $('#input_file_name, #input_file_name_edit').bind('change', function()
    {
        var fileImageObject = $(this);
        fileSize = fileImageObject[0].files[0].size;
    });
}

function bindRemoveDivMessage() {
    $('#alert-crud').delay(10000).fadeOut(1000);
}

function bindDeleteBrowsureOnClick() {
    $('.btnDeleteBrowsure').click(function() {
        var confirmation = window.confirm("Are You Sure Wanna Delete This Browsure?");
        if(!confirmation) {
            return false;
        }
        $('#frmDeleteBrowsureProduct').append($(this).parent().find('input[type="hidden"]'));
        $('#frmDeleteBrowsureProduct').submit();
    });
}

function bindDropDownEditOnChange() {
    $('#post_id_by_sub_category_edit').change(function() {
        var product = $(this).children('option:selected').text();
        $('#txtProductEdit').val(product);
    });

    $('#post_id_by_sub_category').change(function() {
        var product = $(this).children('option:selected').text();
        $('#txtProduct').val(product);
    });
}

function bindToogleEditBrowsure() {
    $('#toggleEditBrowsure').click(function() {
        if($(this).is(':checked')) {
          $('div#pdfPreview').attr("hidden", true);
          $('div#editBrowsurePdf').attr("hidden", false);
        } else {
          $('div#pdfPreview').attr("hidden", false);
          $('div#editBrowsurePdf').attr("hidden", true);
        }
    });
}

function bindUpdateBrowsureOnClick() {
    $('#btnUpdateProductBrowsure').click(function() {
        var post_id = $('#post_id_by_sub_category_edit');
        var file = $('#input_file_name_edit');
        var toggleEditBrowsure = $('#toggleEditBrowsure');
        var hiddenIdVal = $('#hiddenId').val();

        var post_id_val = post_id.val();
        var file_val = file.val();
        var file_wanna_changes = toggleEditBrowsure.val();
        var type = "PDF";

        if(post_id_val === "") {
            alert("Please Choose Your Product Type For Your Browsure!");
            return false;
        }

        if(toggleEditBrowsure.is(':checked')) {
            if(file_val === "") {
                alert("Please Upload Your Browsure for new changes!");
                return false;
            }

            if(file_val.split(".")[1].toUpperCase() !== type) {
                alert("Please Upload PDF File Type!");
                return false;
            }

            if(fileSize > 2000000) {
                alert("Please Upload File Dont Bigger Than 2mb!");
                return false;
            }
        }

        var confirm = window.confirm("Are You Sure Wanna Update This Browsure?");
        if(!confirm) {
          return false;
        }

        var formUpdate = $('#frmUpdateBrowsureProduct');
        formUpdate.attr("action", "/ekadi/admin/manageBrowsure/"+hiddenIdVal);
        formUpdate.submit();
    });
}

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

function getAjaxListOfProductEdit(postId, productName) {
    var productPostDropdown = $('#post_id_by_sub_category_edit');
    $.ajax({
      method: "GET",
      url: "./manageBrowsure/getBrowsureEditRequest/" + postId,
      success: function(data) {
          var defaultOption = "<option value=''selected disabled>-- Please Select Your Product --</option>";
          var listOfProduct = data.listOfProductEditId;
          productPostDropdown.empty();
          productPostDropdown.append(defaultOption);
          for(var index in listOfProduct) {
              var optionElement = "<option value='"+listOfProduct[index].id+"'>";
              if(listOfProduct[index].subCatTitle === null) {
                  optionElement += listOfProduct[index].post_title + " &nbsp;&nbsp; " + "["+listOfProduct[index].catTitle+"]";
              } else {
                  optionElement += listOfProduct[index].post_title + " &nbsp;&nbsp; " + "["+listOfProduct[index].catTitle+"("+listOfProduct[index].subCatTitle+")]";
              }
              optionElement += "</option>";
              productPostDropdown.append(optionElement);
          }
          productPostDropdown.val(postId);
          productPostDropdown.trigger('chosen:updated');
      },
      fail: function(data) {
          alert("fail!");
      }
    })
}

function bindProductRowValue() {
    $('#dtManageBrowsure tbody').on('click', 'tr', function() {
        if(!$(this).find('td').hasClass('dataTables_empty')) {
            bindGetDataTableColumnValue(this);
        }
    });
}

function bindGetDataTableColumnValue(dtRow) {
    var dtTable = $('#dtManageBrowsure').DataTable();
    var dropDownProductEdit = $('#post_id_by_sub_category_edit');
    dropDownProductEdit.chosen();
    dropDownProductEdit.siblings().css("width", "100%");
    var dtRowData = dtTable.row(dtRow).data();

    var hiddenIdVal = $(dtRowData[1]).filter('input#browsureId').val();
    var postid = $(dtRowData[1]).filter('input#postId').val();
    var productName = $(dtRowData[2]).filter('input#txtProductName').val();
    var urlBrowsureToView = $(dtRowData[2]).filter('input#txtUrlViewBrowsure').val();
    // alert(urlBrowsureToView);
    var fileName = $(dtRowData[2]).filter('input#txtFileName').val();
    $('#hiddenId').val(hiddenIdVal);
    $('#txtProductEdit').val(productName);

    /*href set*/
    var ankleTagModalBrowsure = $('a#hrefFileName');
    ankleTagModalBrowsure.text(fileName);
    ankleTagModalBrowsure.attr("onclick", "openPopUpNewWindows('"+urlBrowsureToView+"', 'viewCurrentBrowsure')");

    getAjaxListOfProductEdit(postid);
}

function bindSetRowNumber() {
    var number = 1;
    $('#dtManageBrowsure tbody tr').each(function() {
        $(this).find('td:eq(0)').append(number);
        number++;
    });
}

function bindSetChosenWidthOnModal() {
    var id = '#post_id_by_sub_category';
    $(id).chosen();
    $(id).siblings().css("width", "100%");
}

function bindChangeProductOption() {
    $('#post_id_by_sub_category').change(function() {
        var product = $(this).children('option:selected').text();
        $('#txtProduct').val(product);
    });
}

function bindAddBrowsureToProduct() {
    $('#btnAddProductBrowsure').click(function() {
        var post_id = $('#post_id_by_sub_category');
        var file = $('#input_file_name');

        var post_id_val = post_id.val();
        var file_val = file.val();
        var type = "PDF";

        if(post_id_val === null || post_id_val === "") {
            alert("Please Choose Your Product!");
            return false;
        }

        if(file_val === "") {
            alert("Please Upload Your PDF Browsure!");
            return false;
        }

        if(fileSize > 2000000) {
            alert("Please Upload File Dont Bigger Than 2mb!");
            return false;
        }

        if(file_val.split(".")[1].toUpperCase() !== type) {
            alert("Please Upload PDF File Type!");
            return false;
        }

        var confirmation = window.confirm("Are You Sure Wanna Upload This Browsure to the product!");
        if(!confirmation) {
            return false;
        }

        $('#frmAddBrowsureProduct').submit();
    });
}
