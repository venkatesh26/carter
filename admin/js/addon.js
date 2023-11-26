var itemLen = 1;
$(document).ready(function () {
    let form = $("#basicform");
    let parsleyConfig = {
        errorsContainer: function (parsleyField) {
            return parsleyField.$element.parent().parent();
        }
    };
    form.parsley();
});
$(document).on("click", ".add-more", function () {
    let thiCatId = $(this).data("catid");
    itemLen++;
    let copyEl = '<div class="row"><div class="col-md-4"><div class="form-group mb-0"><label>Addon Name</label><input type="text" class="form-control item-name ui-autocomplete-input" name="item[' + thiCatId + '][name][' + itemLen + ']" data-parsley-required="" autocomplete="off"></div></div><div class="col-md-4"><div class="form-group mb-0"><label>Price</label><input type="text" class="form-control item-price" name="item[' + thiCatId + '][price][' + itemLen + ']" data-parsley-required=""></div></div><div class="col-md-1 remove-item"><label for="uname">&nbsp;</label><br><i class="fas fa-minus-circle remove-icon" data-catid="'+thiCatId+'"></i></div></div>';
    $(".item-list-" + thiCatId).append(copyEl);
});

// $('#basicform').on('submit', function(e) {
//     // return $('#testForm').jqxValidator('validate');
//     let form = $("#basicform");
//     form.parsley().validate();
//     e.preventDefault();
//     if (form.parsley().isValid()) {
//         form.submit();
//     }
// });