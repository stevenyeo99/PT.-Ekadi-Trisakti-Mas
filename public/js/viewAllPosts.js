var listOfIds = [];

$(document).ready(function()
{
    bindSetRowNumber();
    bindTickDeleteEachRow();
    bindToCheckDeleteAll();
    $('#dtPosts').DataTable();
    bindBtnDeletePost();
    bindRemoveDivMessage();
    $('#ddlCategoryFilter, #ddlSubCategoryFilter').chosen();
    bindSearchOrSortingOnChange();
    bindAjaxGetSubCategory();
    bindFilterPostEvent();
    bindSetChosenWidthOnModal();
});

function bindSetChosenWidthOnModal() {
    var id = '#ddlCategoryFilter, #ddlSubCategoryFilter';
    $(id).chosen();
    $(id).siblings().css("width", "100%");
}

function bindFilterPostEvent() {
    $('#btnFilter').click(function() {
        var category = $('#ddlCategoryFilter');
        var subCategory = $('#ddlSubCategoryFilter');
        var form = $('#frmGetPost');

        if(category.children('option').length !== 0) {
            if(category.val() !== "") {
                if(subCategory.children('option').length > 1) {
                  if(subCategory.val() === "" || subCategory.val() === null) {
                      alert("Please Choose Your Sub-Category!");
                      return false;
                  }
                }
                form.append(category);
                form.append(subCategory);
                form.submit();
            } else {
                alert("Please Choose Your Category!");
                return false;
            }
        } else {
            alert("Your Dont Have Any Category Yet!");
            return false;
        }
    });
}

function bindAjaxGetSubCategory() {
    $('#ddlCategoryFilter').change(function() {
        var category_id = $(this).val();
        var subCategoryId = $('#ddlSubCategoryFilter');
        $.ajax({
            url: "./posts/getSubCategory/" + category_id,
            method: "GET",
            success: function(data) {
                var listOfSubCategory = data.subCategory;
                subCategoryId.empty();

                if(listOfSubCategory.length > 0) {
                    subCategoryId.append('<option value="" selected disabled>-- Please Select Sub-Category --</option>');
                    subCategoryId.append('<option value="0">All</option>');
                    for(var index in listOfSubCategory)
                    {
                        subCategoryId.append('<option value="' + listOfSubCategory[index].id + '">' + listOfSubCategory[index].title + '</option>');
                    }
                } else {
                    subCategoryId.append('<option value="" selected disabled>-- Empty Sub-Category --</option>');
                }
                subCategoryId.trigger('chosen:updated');
            },
            error: function(data) {
                console.log(data);
            }
      });
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

function bindSetRowNumber() {
    var number = 1;
    $('#dtPosts tbody tr').each(function() {
        $(this).find('td:eq(0)').text(number);
        number++;
    });
}

function bindTickDeleteEachRow() {
    $('.tickDelete').click(function() {
        bindCheckCheckedOrNot();
        addListIdToBeDeleted();
    });
}

function bindToCheckDeleteAll() {
    $('input#tickDeleteAll').click(function() {
        $('.tickDelete').prop('checked', this.checked);
        bindCheckCheckedOrNot();
        addListIdToBeDeleted();
    });
}

function bindCheckCheckedOrNot()
{
    $('input.tickDelete').each(function() {
        if($(this).is(':checked')) {
            $(this).parent().find('i').css('opacity', '1');
        } else {
            $(this).parent().find('i').css('opacity', '0');
        }
    });
}

function addListIdToBeDeleted()
{
    $('input.tickDelete').each(function() {
        if($(this).is(':checked')) {
          if(!listOfIds.includes($(this).val())) {
            listOfIds.push($(this).val());
          }
        } else {
            if(listOfIds.includes($(this).val())) {
                listOfIds = listOfIds.splice($.inArray($(this).val(), listOfIds), 1);
            }
        }
    });

    $('#idToBeDelete').val(listOfIds.join());
}

function bindBtnDeletePost()
{
    $('#btnDeletePost').click(function() {
        if($('#idToBeDelete').val() === "") {
            alert("Please Choose The One You Want To Delete!");
            return false;
        }

        var confirmation = confirm("Are You Sure With Delete The Post, Will Be Triggerred Once Approve!");
        if(!confirmation)
        {
            return false;
        }

        $('#frmDeletePost').submit();
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
