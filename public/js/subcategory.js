$(document).ready(function() {
    bindAppendRowNumber();
    $('#dtSubCategory').DataTable();
    bindBtnAddSubCategoryOnClick();
    bindRemoveDivMessage();
    btnEditSubCategoryOnClick();
    bindBtnUpdateOnClick();
    bindBtnDeleteOnClick();
    bindSearchOrSortingOnChange();
    bindSetChosenWidthOnModal();
});

function bindSetChosenWidthOnModal() {
    var id = '#ddlCategory, #ddlCategoryId';
    $(id).chosen();
    $(id).siblings().css("width", "100%");
}


function bindSearchOrSortingOnChange() {
    $('input[type="search"]').keydown(function() {
      bindAppendRowNumber();
    });

    $('th.sorting_asc, th.sorting_desc, th.sorting').click(function() {
      bindAppendRowNumber();
    });
}

function bindAppendRowNumber() {
    var number = 1;
    $('#dtSubCategory tbody tr').each(function() {
        $(this).find('td:eq(0)').text(number);
        number++;
    });
}

function bindBtnAddSubCategoryOnClick() {
    $('#btnAddSubCategory').click(function() {
        if($('#ddlCategory').val() == null) {
            // var validationDiv = "<div class='alert alert-danger' id='alert-crud'> Please Choose Your Category Type </div>";
            // $('#validateDropDown').append(validationDiv);
            // $('#alert-crud').delay(10000).fadeOut(1000);
            alert("Please Choose Your Category Type!");
            return false;
        }

        if($('#txtTitle').val() === "") {
            // var validationDiv = "<div class='alert alert-danger' id='alert-crud'> Please Input Your Title</div>";
            // $('#validateDropDown').append(validationDiv);
            // $('#alert-crud').delay(10000).fadeOut(1000);
            alert("Please Input Your Title!");
            return false;
        }

        var confirmation = confirm("Are You Sure Want To Add This SubCategory?");
        if(!confirmation) {
            return false;
        }
        $('#frmAddSubCategory').submit();
    });
}

function bindRemoveDivMessage() {
    $('#alert-crud').delay(10000).fadeOut(1000);
}

function btnEditSubCategoryOnClick() {
    $('#dtSubCategory tbody').on('click', 'tr', function() {
        if(!$(this).find('td').hasClass('dataTables_empty')) {
            bindEditDataTableData(this);
        }
    });
}

function bindEditDataTableData(dtRow) {
    var dtTable = $('#dtSubCategory').DataTable();

    var dtRowData = dtTable.row(dtRow).data();

    $('#hiddenId').val(dtRowData[1]);
    $('#ddlCategoryId').val($(dtRowData[2]).filter('input').val());
    $('#ddlCategoryId').trigger('chosen:updated');
    $('#txtSubCategory').val($(dtRowData[3]).filter('input').val());
}

function bindBtnUpdateOnClick() {
    $('#btnUpdateSubCategory').click(function() {
        var confirmation = confirm("Are You Sure With This Changes?");
        if(!confirmation) {
            return false;
        }
        $('#frmEdit').submit();
    });
}

function bindBtnDeleteOnClick() {
    $('.btnDeleteSubCategory').click(function() {
        var confirmation = confirm("Are You Sure Want To Delete This Sub Category?");
        if(!confirmation) {
            return false;
        }
        // alert($(this).closest('td').find('input#idHidden').val());
        $(this).closest('td').find('input#idHidden').appendTo('#frmDltSubCat');
        $('#frmDltSubCat').submit();
    });
}
