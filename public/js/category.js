$(document).ready(function() {
    bindSetRowNumber();
    $('#dtCategory').DataTable();
    bindBtnAddCategoryOnClick();
    bindRemoveDivMessage();
    btnEditCategoryOnClick();
    bindBtnUpdateOnClickEvent();
    bindBtnDeleteOnClickEvent();
    bindSearchOrSortingOnChange();
    // $('#type').chosen();
    bindSetChosenWidthOnModal();
});

function bindSetChosenWidthOnModal() {
    var id = '#type';
    $(id).chosen();
    $(id).siblings().css("width", "100%");
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
    $('#dtCategory tbody tr').each(function() {
        $(this).find('td:eq(0)').text(number);
        number++;
    });
}

function bindBtnAddCategoryOnClick() {
    $('button#btnAddCategory').click(function() {
        $title = $('#title');
        $type = $('#type');
        $titleVal = $title.val();
        $typeVal = $type.val();

        if($titleVal === "") {
            alert("Please input your category title!");
            return false;
        }

        if($titleVal.length < 3 ) {
            alert("title must more then 3 characters!");
            return false;
        }

        if($titleVal.length > 20) {
            alert("title cannot be more then 20 characters!");
            return false;
        }

        if($typeVal === null || $typeVal === "") {
            alert("Please Choose Your Type!");
            return false;
        }

        var confirmation = confirm("Are You Sure Want To Add This Category?");
        if(!confirmation) {
            return false;
        }
        $('#frmCategory').submit();
    });
}

function bindRemoveDivMessage() {
    $('#alert-crud').delay(10000).fadeOut(1000);
}

function btnEditCategoryOnClick() {
    $('#dtCategory tbody').on('click', 'tr', function() {
        if(!$(this).find('td').hasClass('dataTables_empty')) {
          bindGetDataTableColumnValue(this);
        }
    });
}

function bindGetDataTableColumnValue(dtRow) {
    var dtTable = $('#dtCategory').DataTable();
    // dtTable.$('tr.selected').removeClass('selected');
    // $(this).addClass('selected');
    var dtRowData = dtTable.row(dtRow).data();

    $('#hiddenId').val(dtRowData[1]);
    // console.log($(dtRowData[2]).filter(':input').val());
    // alert($(dtRowData[2]).filter('span').text());
    $('#editTitle').val($(dtRowData[2]).filter('input').val());
    // alert($(dtRowData[3]).filter('input').val());
    // $('#typeEdit').val($(dtRowData[3]).filter('input').val());
    //
    // $('#typeEdit').trigger('chosen:updated');
    // alert($('#editType').val());
}

function bindBtnUpdateOnClickEvent() {
    $('#btnUpdateCategory').click(function() {
      $title = $('#editTitle');
      $type = $('#typeEdit');
      $titleVal = $title.val();
      $typeVal = $type.val();

      if($titleVal === "") {
          alert("Please input your category title!");
          return false;
      }

      if($titleVal.length < 3 ) {
          alert("title must more then 3 characters!");
          return false;
      }

      if($titleVal.length > 20) {
          alert("title cannot be more then 20 characters!");
          return false;
      }

      if($typeVal === null || $typeVal === "") {
          alert("Please Choose Your Type!");
          return false;
      }

        var confirmation = confirm("Are You Sure With This Changes?");
        if(!confirmation) {
            return false;
        }
        $('#frmEdit').submit();
    });
}

function bindBtnDeleteOnClickEvent() {
    $('.btnDeleteCategory').click(function() {
        var confirmation = confirm("Are You Sure Want To Delete This Category?");
        if(!confirmation) {
            return false;
        }
        // var comfirm2 = confirm($(this).closest('td').find('input#txtIdDelete').val());
        // if(!confirm2) {
        //   return false;
        // }
        $(this).closest('td').find('input#txtIdDelete').appendTo('#frmDeleteCategory');
        $('#frmDeleteCategory').submit();
    });
}
