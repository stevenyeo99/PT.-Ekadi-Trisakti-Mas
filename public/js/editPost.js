$(document).ready(function() {
    // bindSetTaggleTagsWithValue();
    bindSetCheckBoxOnChecked();
    bindUsedCheckBoxOnCheck();
    bindGetSubCategoryAjax();
    bindBtnUpdatePostOnClick();
    bindRemoveDivMessage();
    setTinymceEditor();
    bindProductOnEdit();
    bindSetChosenWidthOnModal();
    hiddenTypeCategoryFirstOpen();
    bindOnHoverFormEditPost();
});

function bindOnHoverFormEditPost() {
  // title
  $('#titleArea').mouseenter(function() {
        $('#titleDescription').show();
  });

  $('#titleArea').mouseleave(function() {
      $('#titleDescription').hide();
  });

  // category
  $('#categoryArea').mouseenter(function() {
      $('#categoryDescription').show();
  });

  $('#categoryArea').mouseleave(function() {
    $('#categoryDescription').hide();
  });

  // sub category
  $('#subcategoryArea').mouseenter(function() {
      $('#subcategoryDescription').show();
  });

  $('#subcategoryArea').mouseleave(function() {
      $('#subcategoryDescription').hide();
  });

  // product
  $('#productDiv').mouseenter(function() {
      $('#productLabel').show();
  });

  $('#productDiv').mouseleave(function() {
    $('#productLabel').hide();
  });

  // content text
  $('#contentTextArea').mouseenter(function() {
      $('#textAreaLabel').show();
  });

  $('#contentTextArea').mouseleave(function() {
      $('#textAreaLabel').hide();
  });
}

function hiddenTypeCategoryFirstOpen() {
    var hiddenFirstRetrieve = $('#category_id').children('option:selected').attr('data-type');
    $('#hiddenTypeCategory').val(hiddenFirstRetrieve);
}

function bindSetChosenWidthOnModal() {
    var id = '#category_id, #subcategory_id';
    $(id).chosen();
    $(id).siblings().css("width", "100%");
}

function setLabelCheckedProduct(radio) {
  $('label[for="'+radio+'"]').css(
    {
      "text-decoration": "underline",
      "color": "green"
    }
  );
}

function bindLabelNotChecked(idLabel) {
    $('label[for="'+idLabel+'"]').css(
      {
        "text-decoration": "none",
        "color": "black"
      });
}

function bindProductOnEdit() {
    var usedRadio = $('#usedRadio');
    var notUsedRadio = $('#notUsedRadio');

    if(usedRadio.is(':checked')) {
        setLabelCheckedProduct('usedRadio');
    }

    if(notUsedRadio.is(':checked')) {
        setLabelCheckedProduct('notUsedRadio');
    }

    var idLabel = "";
    usedRadio.change(function() {
        if($('#hiddenTypeCategory').val() === "ABOUT US") {
          alert("About Us Cannot Use Product Please Choose Another!");
          $('label[for="notUsedRadio"]').css({
            "text-decoration": "none",
            "color": "black"
          });
          $(this).prop("checked", false);
          return false;
        } else {
            setLabelCheckedProduct('usedRadio');
            idLabel = "notUsedRadio";
            bindLabelNotChecked(idLabel);
        }
    });

    notUsedRadio.change(function() {
          setLabelCheckedProduct('notUsedRadio');
          idLabel = "usedRadio";
          bindLabelNotChecked(idLabel);
    });
}

function setTinymceEditor()
{
    var editor_config = {
        path_absolute: "/",
        branding: false,
        selector: "textarea#bodyContent",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        // media not used
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
        relative_urls: false,
        file_browser_callback: function(field_name, url, type, win) {
          var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
          var y = window.innerHeight || document.documentElement.clientHeight || document.getElementByTagName('body')[0].clientHeight;

          var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;

          // alert(cmsURL);
          if(type == 'image') {
            cmsURL = cmsURL + "&type=Images";
          } else {
            cmsURL = cmsURL + "&type=Files";
          }

          tinyMCE.activeEditor.windowManager.open({
            file: cmsURL,
            title: 'PT. Ekadi Trisakti Mas',
            width: x * 0.8,
            height: y * 0.8,
            resizable: "yes",
            close_previous: "no"
          });
        }
    };
    tinymce.init(editor_config);
}

function bindRemoveDivMessage() {
    $('#alert-crud').delay(10000).fadeOut(1000);
}

function bindBtnUpdatePostOnClick()
{
    $('#btnPostUpdate').click(function() {
        tinyMCE.triggerSave();
        // $('#tags').remove();
        var title = $('#title');
        // var tags = $('#divTags ul.taggle_list li');
        var category = $('#category_id');
        var subChk = $('#chkUsed');
        var subCategory = $('#subcategory_id');
        var content = $('textarea#bodyContent');
        // var tagsSet = false;
        // var tagsInput = $('<input>').attr({
        //     id: "tags",
        //     name: "tags",
        //     value: "",
        //     hidden: true
        // });
        // var tagEachValueTotal = "";

        if(title.val() === "") {
            alert("Please Input Your Title!");
            return false;
        }

        // tags.each(function() {
        //     if($(this).hasClass('taggle')) {
        //         tagsSet = true;
        //         var valueEachTags = $(this).find('input').val();
        //         // console.log(valueEachTags);
        //         if(tagEachValueTotal === "") {
        //             tagEachValueTotal += valueEachTags;
        //         } else {
        //             tagEachValueTotal += ", " + valueEachTags;
        //         }
        //     }
        // });
        // tagsInput.val(tagEachValueTotal);
        //
        // if(!tagsSet) {
        //     alert("Please Set Your Post Tags!");
        //     return false;
        // }


        if(category.val() === "" || category.val() == null) {
            alert("Please Select Your Category!");
            return false;
        }

        /*
          check sub category exist or not and if checked to used exist or not!
        */
        var gotSubCategory = false;
        if(subChk.is(':checked'))
        {
            gotSubCategory = getSubCategoryExistOrNot(subCategory);
            if(!gotSubCategory)
            {
                alert("You Dont Have This Sub-Category Base On The Category!");
                return false;
            }

            if(subCategory.val() == "" || subCategory.val() == null)
            {
                alert("Please Select Your Sub-Category!");
                return false;
            }
        }
        else
        {
            gotSubCategory = getSubCategoryExistOrNot(subCategory);
            if(gotSubCategory)
            {
                alert("Please Use Sub Category Base On Category!");
                return false;
            }
        }

        if(content.val() === "") {
            alert("Please Write Your Post Content!");
            return false;
        }

        var confirmation = confirm("Are You Sure Want To Update This Post?");
        if(!confirmation) {
            return false;
        }

        var form = $('#frmPost');
        // tagsInput.appendTo(form);
        form.submit();
    });
}

function getSubCategoryExistOrNot(subCategory)
{
    var exist = false;
    $.each(subCategory.find('option'), function() {
        if($(this).val() !== "") {
            exist = true;
        }
    });
    return exist;
}

function bindGetSubCategoryAjax()
{
    $('#category_id').change(function() {
        var category_id = $(this).val();
        var subCategoryId = $('#subcategory_id');
        $.ajax({
              url: "/ekadi/admin//posts/getSubCategory/" + category_id,
              method: "GET",
              success: function(data) {
                  var listOfSubCategory = data.subCategory;
                  subCategoryId.empty();
                  subCategoryId.append('<option value="" selected disabled>-- Please Select Sub-Category Type --</option>');
                  for(var index in listOfSubCategory)
                  {
                      subCategoryId.append('<option value="' + listOfSubCategory[index].id + '">' + listOfSubCategory[index].title + '</option>');
                  }

                  var bool = checkDropDownSubCategoryLinkToCategory(subCategoryId);
                  if(bool) {
                      alert("Remember To Choose Sub Category!");
                      subCategoryId.prop('disabled', false);
                  } else {
                      subCategoryId.prop('disabled', true);
                      $('#chkUsed').prop('checked', false);
                  }
                  subCategoryId.trigger("chosen:updated");
              },
              error: function(data) {
                  alert(data);
              }
          });

          $('#hiddenTypeCategory').val($('#category_id').children("option:selected").attr("data-type"));
          if($('#hiddenTypeCategory').val() === "ABOUT US" && $('#usedRadio').is(':checked')) {
              alert("About Us Cannot Use Product Please Choose Another!");
              $('#usedRadio').prop('checked', false);
              bindLabelNotChecked('usedRadio');
              return false;
          }
    });
}

function checkDropDownSubCategoryLinkToCategory(subCategoryId)
{
    var subCategorySize = subCategoryId.children('option').length;
    if(subCategorySize > 1) {
        return true;
    }
    return false;
}

function bindUsedCheckBoxOnCheck()
{
    var checkBox = $('#chkUsed');
    var subCategoryDropDown = $('#subcategory_id');

    checkBox.click(function() {
        var optionSubCategoryCount = subCategoryDropDown.children('option').length;
        var thisCheckBox = $(this);
        if(thisCheckBox.is(':checked')) {
            if(optionSubCategoryCount > 1) {
                subCategoryDropDown.prop('disabled', false);
            } else {
                alert("This Doens't have an Sub-Category Base On The Category!");
                thisCheckBox.prop('checked', false);
            }
        } else {
            subCategoryDropDown.prop('disabled', true);
        }
    });
}

function bindSetCheckBoxOnChecked()
{
    var subCatValue = $('#subcategory_id');
    if(subCatValue.val() != null) {
        $('#chkUsed').prop('checked', true);
        subCatValue.prop('disabled', false);
    } else {
        subCatValue.prop('disabled', true);
    }
}

function bindSetTaggleTagsWithValue()
{
    var tags = $('#txtTagByPost').val();
    var listOfTags = tags.split(',');
    var tagsId = $('#divTags')[0];
    if(listOfTags.length > 0) {
        new Taggle(tagsId, {
            tags: listOfTags
        });
    } else {
        new Taggle(tagsId);
    }
}
