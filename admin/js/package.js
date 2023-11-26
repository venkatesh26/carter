// "use strict";

var itemLen = 1;
var catId = 1;
            
$(document).ready(function () {
    let form = $(".basicform");
    let parsleyConfig = {
        errorsContainer: function (parsleyField) {
            return parsleyField.$element.parent().parent();
        }
    };
    form.parsley();

    var btnFinish = $("<button></button>")
        .text("Finish")
        .addClass("btn btn-primary")
        .on("click", function (e) {
            form.parsley().validate();
            e.preventDefault();
            if (form.parsley().isValid()) {
                form.submit();
            }
        });

    // SmartWizard initialize
    $('#smartwizard').smartWizard({
        useURLhash: false,
        showStepURLhash: false,
        enableFinishButton: false,
        toolbarSettings: {
            toolbarPosition: "bottom",
            toolbarExtraButtons: [btnFinish],
        }
    });

    $(".sw-btn-prev").addClass('btn-primary').removeClass('btn-secondary');
    $(".sw-btn-next").addClass('btn-primary').removeClass('btn-secondary');
    

    $(".sw-btn-prev").addClass('d-none');
    $(".sw-btn-group-extra").addClass('d-none');
    $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection, stepPosition) {
        if (stepPosition === 'first') {
            $(".sw-btn-next").removeClass('d-none');
            $(".sw-btn-prev").addClass('d-none');
            $(".sw-btn-group-extra").addClass('d-none');
        } else if (stepPosition === 'final') {
            if (form.parsley().validate("step1")) {
                $('#smartwizard').smartWizard("next");
                $(".sw-btn-prev").removeClass('d-none');
                $(".sw-btn-group-extra").removeClass('d-none');
                $(".sw-btn-next").addClass('d-none');
            } else {
                $('#smartwizard').smartWizard("prev");
                $(".sw-btn-group-extra").addClass('d-none');
            }
        }
    });

    // Autocomplete
    var categoryAutoCompRows = categoryRows.map((res, index) => {
        res.value = res.name;
        res = res;
        return res;
    });
    let packageItemRowsObj = {};
    var packageItemAutoCompRows = [];
    let pItems = [];
    packageItems.map((res, index) => {
        if (packageItemRowsObj[res.package_id]) {
            pItems.push(res);
            packageItemRowsObj[res.package_id] = pItems;
        } else {
            pItems = [];
            pItems.push(res);
            packageItemRowsObj[res.package_id] = pItems;
        }
        packageItemAutoCompRows.push({
            value: res.name,
            id: res.id,
            description: res.description,
            spicy: res.spicy
        });
    });

    categoryAutoComplete(categoryAutoCompRows);

    itemAutoComplete(packageItemAutoCompRows);

    $(document).on("click", ".add-cat-more", function () {
        catId++;
        let copyEl = '<div class="card card-'+catId+'"><div class="card-body" style="border: 1px solid grey;"><div class="row"><div class="col-md-12 remove-cat" style="text-align:right;"><label for="uname">&nbsp;</label><br><i class="fas fa-minus-circle remove-cat-icon" data-catid="'+catId+'"></i></div></div><div class="row"><div class="col-md-6"><div class="form-group mb-0"><label for="category_name">Name of the Category</label><input type="text" class="form-control category_name ui-autocomplete-input" name="category_name['+catId+']" id="category_name" data-parsley-required="" autocomplete="off"></div></div><div class="col-md-6"><div class="form-group mb-0"><label for="no_of_items">Enter the number of item</label><input type="text" class="form-control" name="no_of_items['+catId+']" id="no_of_items" data-parsley-required="" data-parsley-type="number" min="1" autocomplete="off"></div></div></div><div class="row"><div class="col-md-12"><p class="add-more text-primary text-right mt-3 mb-3" data-catid="'+catId+'" data-itemlen="1"><i class="fas fa-plus-circle add-icon"></i> Add more item</p></div></div><div class="item-list item-list-'+catId+'"><div class="row"><div class="col-md-4"><div class="form-group mb-0"><label>Item Name</label><input type="text" class="form-control item-name ui-autocomplete-input" name="item[' + catId + '][name][1]" data-parsley-required="" autocomplete="off"></div></div><div class="col-md-4"><div class="form-group mb-0"><label>Item Description</label><input type="text" class="form-control item-description" name="item[' + catId + '][description][1]" data-parsley-required=""></div></div><div class="col-md-3"><div class="form-group mb-0"><label for="uname">Spicy</label><br><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input item-spicy spicy-mild" name="item[' + catId + '][spicy][1]" value="mild" checked="" data-parsley-multiple="itemspicy">Mild</label></div><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input item-spicy spicy-hot" name="item[' + catId + '][spicy][1]" value="hot" data-parsley-multiple="itemspicy">Hot</label></div><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input item-spicy spicy-extra_hot" name="item[' + catId + '][spicy][1]" value="extra_hot">Extra Hot</label></div></div></div><div class="col-md-1 remove-item"><label for="uname">&nbsp;</label><br><i class="fas fa-minus-circle remove-icon" data-catid="'+catId+'"></i></div></div></div></div></div>';
        $(".cat-list").append(copyEl);

        categoryAutoComplete(categoryAutoCompRows);

        itemAutoComplete(packageItemAutoCompRows);
    });

    $(document).on("click", ".add-more", function () {
        let thiCatId = $(this).data("catid");
        itemLen++;
        let copyEl = '<div class="row"><div class="col-md-4"><div class="form-group mb-0"><label>Item Name</label><input type="text" class="form-control item-name ui-autocomplete-input" name="item[' + thiCatId + '][name][' + itemLen + ']" data-parsley-required="" autocomplete="off"></div></div><div class="col-md-4"><div class="form-group mb-0"><label>Item Description</label><input type="text" class="form-control item-description" name="item[' + thiCatId + '][description][' + itemLen + ']" data-parsley-required=""></div></div><div class="col-md-3"><div class="form-group mb-0"><label for="uname">Spicy</label><br><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input item-spicy spicy-mild" name="item[' + thiCatId + '][spicy][' + itemLen + ']" value="mild" checked="" data-parsley-multiple="itemspicy">Mild</label></div><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input item-spicy spicy-hot" name="item[' + thiCatId + '][spicy][' + itemLen + ']" value="hot" data-parsley-multiple="itemspicy">Hot</label></div><div class="form-check-inline"><label class="form-check-label"><input type="radio" class="form-check-input item-spicy spicy-extra_hot" name="item[' + thiCatId + '][spicy][' + itemLen + ']" value="extra_hot">Extra Hot</label></div></div></div><div class="col-md-1 remove-item"><label for="uname">&nbsp;</label><br><i class="fas fa-minus-circle remove-icon" data-catid="'+thiCatId+'"></i></div></div>';
        $(".item-list-" + thiCatId).append(copyEl);
        
        itemAutoComplete(packageItemAutoCompRows);
    });

    $(document).on("click", ".remove-cat-icon", function () {
        let thiCatId = $(this).data("catid");
        if ($(".cat-list .card").length > 1) {
            $(this).closest(".card-"+ thiCatId).remove();
        }
    });

    $(document).on("click", ".remove-icon", function () {
        let thiCatId = $(this).data("catid");
        if ($(".item-list-"+ thiCatId + " .row").length > 1) {
            $(this).closest(".row").remove();
        }
    });
});

function categoryAutoComplete(categoryAutoCompRows) {
    console.log("==CALING 1", categoryAutoCompRows);
    $(".category_name").autocomplete({
        source: function (request, response) {
            let categoryAutoCompRowsFilter = categoryAutoCompRows.filter(function (item) {
                return item.value.toLowerCase().indexOf(request.term.toLowerCase()) >= 0;
            })
            response(categoryAutoCompRowsFilter);
            return;
        },
        select: function (e, ui) {
            //
        },
        change: function (e, ui) {
            // 
        }
    });
}

function itemAutoComplete(packageItemAutoCompRows) {
    console.log("==CALING 2", packageItemAutoCompRows);
    $(".item-name").autocomplete({
        source: function (request, response) {
            let packageItemAutoCompRowsFilter = packageItemAutoCompRows.filter(function (item) {
                return item.value.toLowerCase().indexOf(request.term.toLowerCase()) >= 0;
            })
            response(packageItemAutoCompRowsFilter);
            return;
        },
        select: function (e, ui) {

            let clickPackageId = ui.item.id;
            $(".item-name:focus").parent().closest(".row").find(".item-description").val(ui.item.description);
            $(".item-name:focus").parent().closest(".row").find(".item-spicy").prop("checked", false);
            if (ui.item.mild) {
                $(".item-name:focus").parent().closest(".row").find(".item-spicy.spicy-mild").prop("checked", true);
            } else if (ui.item.hot) {
                $(".item-name:focus").parent().closest(".row").find(".item-spicy:spicy-hot").prop("checked", true);
            } else if (ui.item.extra_hot) {
                $(".item-name:focus").parent().closest(".row").find(".item-spicy.spicy-extra_hot").prop("checked", true);
            }
        },
        change: function (e, ui) {

        }
    });
}