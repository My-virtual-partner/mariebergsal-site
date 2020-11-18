jQuery(document).ready(function ($) {



    $('#accept_offer_id').val('true');
    $("#lista_reservation_checkbox").click(function () {
        $(".reservationer-type").toggle();
    });
    $("#egen_reservation_checkbox").click(function () {
        $(".reservationEgenText").toggle();
    });

    $('.egen_order_nav_tab').on('click', function () {
        var selected_value = $('#imm-sale-order-status option:selected').val();
        if (selected_value !== 'alla') {
            console.log('kk');

            $('#imm-sale-order-status').val('alla').trigger('change');
        }

    })
    $('#accept_order_checkbox').on('click', function () {
        if ($('#accept_order_checkbox').prop('checked')) {
            alert('yes');

            $('#accept_order_btn').css('background-color', '#8acd6c');
            $('#accept_order_btn').prop('disabled', '');

        } else {
            alert('yes123');
            $('#accept_order_btn').prop('disabled', 'disabled');
            $('#accept_order_btn').css('background-color', '#808080');


        }

    })

    $('#project_type').on('change', function () {


        $('.spara_och_fortsatt').prop("disabled", false);
        $('.spara_och_fortsatt').trigger('click');


    })


    var grid_or_list_load = $('#grid_or_list').val();
    if (grid_or_list_load == 1) {
        $('.order_product_grid').css('color', '#ff5912');
    } else {
        $('.order_product_list').css('color', '#ff5912');
    }


    $('#price_table_pid table thead th').each(function (i) {
        calculateColumn(i);
    });

    $("#retail_price_different").on('click', function () {
        $(".price_table_pi table").slideToggle();


    });


    function calculateColumn(index) {
        var total = 0;

        $('table tr').each(function () {
            var value = parseInt($('td', this).eq(index).text());
            if (!isNaN(value)) {
                total += value;
            }
        });

        if (index != 0 && index != 5) {

            $('table tfoot td').eq(index).text(total);

        }


    }

    function calculateSum() {
        var sum = [];
        //iterate through each textboxes and add the values
        $(".tb_class").each(function (i) {


            var td_val = parseInt($(this).text());
            sum.push(td_val);


        });


        total_r = eval(sum.join("+"))


        var regular_p = $("#regular_p_td").text();
        var percentage = (total_r * 100) / regular_p;
        var percentage_con = percentage.toFixed(2).concat("%");
        $("#result_td_p").html(total_r + '(' + percentage_con + ')');
    }

    calculateSum();


    $(".print_div_icon").on('click', function () {

        setTimeout(() => {
            w = window.open();
            w.document.write($('.printable_area').html());
            w.print();
            setTimeout(() => {
                window.close();
            }, 1000);
        }, 1000);

    })
    $(".print_order_icon").on('click', function () {

        setTimeout(() => {
            w = window.open();
            w.document.write($('.order_printable_area').html());
            w.print();
            setTimeout(() => {
                window.close();
            }, 1000);
        }, 1000);
    })
    $("#steps_btn_modal").live('click', function () {
        $("#help_info_modal").hide();
        $("#price_table_pid").hide();
        $("#steps_info_modal").toggle();
        $("#rot_how").hide();
    });


    $("#mer_info_btn_modal").live('click', function () {
        $("#steps_info_modal").hide();
        $("#price_table_pid").hide();
        $("#rot_how").hide();
        $("#help_info_modal").toggle();
    });
    $("#retail_price_differentt").live('click', function () {
        $("#steps_info_modal").hide();
        $("#help_info_modal").hide();
        $("#rot_how").hide();
        $("#price_table_pid").toggle();
    });
    $("#how_calculate_rut").live('click', function () {
        $("#steps_info_modal").hide();
        $("#help_info_modal").hide();
        $("#rot_how").toggle();
        $("#price_table_pid").hide();
    });


    $("#valj_duplicated_project").live('click', function () {
        $("#valt_duplicated_project").toggle();
    });


    $("#toggle_uploaded_files_project").live('click', function () {
        $("#all_files_project").toggle();
    });


    $('#duplicate_offert_inside_project_new_customer').live('change', function (e) {

        var selected_option_value = $('#duplicate_offert_inside_project_new_customer option:selected').val();
        $('#project_id_inoffert').val(selected_option_value);
        var order_id_value = $('#order_id_inoffert').val();

        var customer_id = $('#duplicate_offert_inside_project_new_customer option:selected').attr('data_customerId');

        $('#duplicate_offert_href').attr('href', '?duplicate_to_new=true&order_id=' + order_id_value + '&project_id=' + selected_option_value + '&customer_id=' + customer_id);


    })

    $('#leverantörsfaturor_submit').live('click', function (e) {
        $.LoadingOverlay('show');
    })

    $('.spara_och_fortsatt').live('click', function (e) {
        /*        if($( ".steps-page h3" ).text()=== 'Skorstensinfo'){*/
        $('.required').each(function () {
            if ($(this).val() == "") {
                $.LoadingOverlay('hide');
                alert('Vänligen fyll i alla obligatoriska fält markerade med *');

                return false;
            } else {
                $.LoadingOverlay('show');

            }
        });


    })


    $('#test_id_ak li a').live('click', function () {
        if ($(this).text() === 'Klart' || $(this).text() === 'Ej aktuellt') {
            /*      $.LoadingOverlay('show');*/
            $('.spara_och_fortsatt').trigger('click');

        }
    })

    var activestepWizard = $('.stepwizard-step').find('a.stepwizard-active');
    var step_EjKlart = $('.done_notdone_pending').find('option[value="0"]');
    var step_Klart = $('.done_notdone_pending').find('option[value="1"]');
    var step_EjAktuelt = $('.done_notdone_pending').find('option[value="2"]');


    if (activestepWizard.hasClass("stepwizard-completed-yes")) {

        step_Klart.attr('selected', 'selected');


    } else if (activestepWizard.hasClass("stepwizard-completed-no")) {

        step_EjKlart.attr('selected', 'selected');

    } else if (activestepWizard.hasClass("stepwizard-completed-between")) {

        step_EjAktuelt.attr('selected', 'selected');
    }


    var done_notdone_pending = $(".done_notdone_pending option:selected").val();

    if (done_notdone_pending == 1 || done_notdone_pending == 2) {

        $(".spara_och_fortsatt").attr('disabled', false);
    } else {
        $(".spara_och_fortsatt").attr('disabled', true);

    }
//Change the title of step to ao


    $(".done_notdone_pending").change(function () {
        var done_notdone_pending = $(".done_notdone_pending option:selected").val();
        if (done_notdone_pending == 0 || done_notdone_pending == 1 || done_notdone_pending == 2) {

            $(".spara_och_fortsatt").attr('disabled', false);
        } else {
            $(".spara_och_fortsatt").attr('disabled', true);
            alert('Glöm inte att markera steget för att fortsätta');
        }
    })
//End changing of the title of step 14

    /*__$('.head_product').attr('checked','checked');__*/
    /*    $('#select_invoice_type').select2OptionPicker();*/
    $('.done_notdone_pending').select2OptionPicker();


    /*
     $.fn.modal.Constructor.prototype.enforceFocus = function () {
     };
     */


    $.LoadingOverlaySetup({

        image: "/wp-content/plugins/imm-sale-system/js/loading.gif", // String


    });

    $('.js-sortable-select').select2(
            {
                theme: "bootstrap",
                width: '100%'
            }
    );

    $(document).on("keypress", ":input:not(textarea)", function (event) {
        return event.keyCode != 13;
    });

    $('#work-planning-calendar-cal').on('click', '.fc-event', function (e) {
        e.preventDefault();
        window.open(jQuery(this).attr('href'), '_blank');
    });

    $('#calendar-tab').click(function () {
        $('#work-planning-calendar-cal').fullCalendar({
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            editable: true,
            aspectRatio: 1,
            scrollTime: '00:00',
            header: {
                left: 'today prev,next',
                center: 'title',
                right: 'timelineWeek,timelineMonth,timelineThreeMonth,timelineYear'
            },
            defaultView: 'timelineMonth',
            views: {
                timelineDay: {
                    buttonText: ':15 slots',
                    slotDuration: '00:15'
                }, timelineWeek: {
                    duration: {weeks: 1},
                    slotDuration: {days: 1},
                }, timelineYear: {
                    buttonText: 'År'
                },
                timelineThreeMonth: {
                    type: 'timeline',
                    duration: {days: 90}
                }
            },
            navLinks: true,

            eventDrop: function (event) {
                var start_date = event.start.format();
                var end_date = event.end.format();
                var event_resource = event.resourceId;
                var project_id = event.project_id;

                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'update_event_drop',
                        start_date: start_date,
                        end_date: end_date,
                        event_resource: event_resource,
                        project_id: project_id

                    },
                    success: function (results) {

                    }
                });
            },
            eventResize: function (event) {
                var start_date = event.start.format();
                var end_date = event.end.format();
                var event_resource = event.resourceId;
                var project_id = event.project_id;

                $.ajax({
                    url: ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'update_event_drop',
                        start_date: start_date,
                        end_date: end_date,
                        event_resource: event_resource,
                        project_id: project_id

                    },
                    success: function (results) {

                    }
                });

            },
            locale: 'sv',
            weekends: true,
            weekNumbers: true,
            events: {
                url: '/wp-content/plugins/imm-sale-system/js/calendar-feed.php',
                data: function () { // a function that returns an object
                    return {
                        office_id: $("#order_calendar_by_office").val()
                    }
                }
            },
            resources: function (callback) {
                getResources(function (resourceObjects) {
                    callback(resourceObjects);
                });
            },

            resourceAreaWidth: '15%',
            resourceColumns: [
                {
                    labelText: 'Användare',
                    field: 'title'
                }
            ],

        });
    });


    $('.toggle-prepayment-invoice-modal').click(function (e) {
        e.preventDefault();
        var order_id = $(".toggle-prepayment-invoice-modal").attr('data-order-id');
        $("#prepayment-invoice-modal").modal('show');
        $(".modal-content #prepayment-invoice-order_id").val(order_id);
        console.log(order_id);

    });


    function getResources(handleData) {
        $.ajax({
            url: "/wp-content/plugins/imm-sale-system/js/calendar-resources.php",
            data: {
                user_logins: $("#order_calendar_by_user").val()
            },
            method: "POST",
            dataType: "json",
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            success: function (data) {
                $.LoadingOverlay("hide");
                handleData(data);
            }
        });
    }

    $("select[id='order_calendar_by_office']").change(function () {
        $('#work-planning-calendar-cal').fullCalendar('refetchEvents');
    });

    $("select[id='order_calendar_by_user']").live("change", function () {
        $('#work-planning-calendar-cal').fullCalendar('refetchResources');
    });


    $("select[id='set_office_connection']").on("change", function () {

        createCookie('office_connection', $(this).val(), 1);

    });


    $(".select-customer").hide();
    $(".create-new-customer").show();

    $('#create_new_customer').click(function () {
        if ($('#create_new_customer').is(':checked')) {
            $("#customer_email").prop('required', true);
            $(".create-new-customer").show();
            $(".select-customer").hide();
        } else {
            $("#customer_email").prop('required', false);

            $(".create-new-customer").hide();
            $(".select-customer").show();
        }
    });
    $('.colorpicker').colorpicker();

    $('#upload-btn').click(function (e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Upload Image',
            multiple: false
        }).open()
                .on('select', function (e) {
                    var uploaded_image = image.state().get('selection').first();

                    var image_url = uploaded_image.toJSON().url;
                    $('#logotype_image_url').val(image_url);
                });
    });


    $('[data-popup-open]').on('click', function (e) {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        var productId = $(this).attr('data-product-id');
        var productTitle = $(this).attr('data-product-title');
        var productExerpt = $(this).attr('data-product-exerpt');

        $('#product-title').html(productTitle);
        $('#product-exerpt').html(productExerpt);

        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);

        e.preventDefault();
    });
    /*
     $('.toggle-product-modal-art').live('click', function (e) {
     var productId = $(this).attr('data-product-id');
     var productImageUrl = $(this).attr('data-product-image-url');
     var productTitle = $(this).attr('data-product-title');
     var productWebshopUrl = $(this).attr('data-product-webshop-url');
     var productAttributes = $(this).attr('data-product-attributes');
     var productContent = $(this).attr('data-product-description');
     var productPrice = $(this).attr('data-product-regular-price');
     var productCat = $(this).attr('data-terms');
     
     var attributesHtml = "";
     
     if (typeof productAttributes != 'undefined') {
     var productAttributesJSON = JSON.parse(productAttributes);
     
     $.each(productAttributesJSON, function (idx, obj) {
     attributesHtml += "<label for='order-status'>" + obj.title + "</label>";
     attributesHtml += "<select data-attribute_product-id='" + productId + "' data-attribute_name='attribute_" + obj.name + "'  id='attribute_" + obj.name + "' class='form-control variation-control product-id" + productId + "'>";
     
     $.each(obj.options, function (index, o) {
     attributesHtml += "<option value='" + o.toLowerCase() + "' >" + o + "</option>";
     
     });
     
     attributesHtml += "</select>";
     
     });
     }
     $(".modal-body #product-attributes").html(attributesHtml);
     
     $(".modal-body #product-variation-id").val(productId);
     $(".product-title").html(productTitle);
     $(".product_category").html(productCat);
     $(".productPrice").html(productPrice);
     $(".modal-body #product-content").html(productContent);
     $(".modal-body #product-webshop-url").attr("href", productWebshopUrl);
     $(".modal-body #product-image").attr("src", productImageUrl);
     $(".modal-body .head_product").attr("id", "head_product_" + productId);
     
     })*/
    $('.toggle-product-modal').live('click', function (e) {

        var productId = $(this).attr('data-product-id');
        var productImageUrl = $(this).attr('data-product-image-url');
        var productTitle = $(this).attr('data-product-title');
        var productWebshopUrl = $(this).attr('data-product-webshop-url');
        var productAttributes = $(this).attr('data-product-attributes');
        var productContent = $(this).attr('data-product-description');
        var productPrice = $(this).attr('data-product-regular-price');
        var dataproductsku = $(this).attr('data-product-sku');
        var productCat = $(this).attr('data-terms');
        var ReaproductPrice = $(this).attr('data-product-rea-price');

        var attributesHtml = "";

        if (typeof productAttributes != 'undefined') {
            var productAttributesJSON = JSON.parse(productAttributes);

            $.each(productAttributesJSON, function (idx, obj) {
                attributesHtml += "<label for='order-status'>" + obj.title + "</label>";
                attributesHtml += "<select data-attribute_product-id='" + productId + "' data-attribute_name='attribute_" + obj.name + "'  id='attribute_" + obj.name + "' class='form-control variation-control product-id" + productId + "'>";

                $.each(obj.options, function (index, o) {
                    attributesHtml += "<option value='" + o.toLowerCase() + "' >" + o + "</option>";

                });

                attributesHtml += "</select>";

            });
        }
        $(".modal-body #product-attributes").html(attributesHtml);

        $(".modal-body #product-variation-id").val(productId);
        $(".product-title").html(productTitle);
        $(".product_category").html(productCat);
        $(".productPrice").html('Ordinarie Pris: ' + productPrice);
        if (ReaproductPrice) {
            $(".productPrice").css('text-decoration', 'line-through');
            $(".ReaproductPrice").css('background-color', '#ff5912');
            $(".ReaproductPrice").css('color', '#fafafa');
            $(".ReaproductPrice").css('padding', '5px');

        }
        $(".ReaproductPrice").html('Nedsatt Pris: ' + ReaproductPrice + ' inkl moms');
        $(".modal-body #product-content").html(productContent);
        $(".modal-body #product-webshop-url").attr("href", productWebshopUrl);
        $(".modal-body #product-image").attr("src", productImageUrl);
        $(".modal-body .head_product").attr("id", "head_product_" + productId);
        $(".modal-body .artikle_nummer_pr").html(dataproductsku);


    });

    //----- CLOSE
    $("#product-modal").on("hidden.bs.modal", function () {
        console.log(1);
        $(".ReaproductPrice").html('');
        $(".ReaproductPrice").removeAttr("style")
    });
    $('[data-popup-close]').on('click', function (e) {
        console.log(2);
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
        $('#quantity').val('');


        e.preventDefault();
    });

    var i = $("#household_vat .dis_row").size() + 1;

    $('#add-line').live('click', function (e) {
        var householdVat = $('#household_vat');


        e.preventDefault();
        var extraForm = "<div class='dis_row'>";

        extraForm += "<div class='col-lg-6'>";
        extraForm += "<label class='top-buffer-half'>Namn</label>";
        extraForm += "<input type='text' value='' class='form-control' name='customer_household_vat_discount_name[" + i + "]' id='customer_household_vat_discount_name[" + i + "]'>";
        extraForm += "</div>";

        extraForm += "<div class='col-lg-3'>";
        extraForm += "<label class='top-buffer-half'>Personnummer</label>";
        extraForm += "<input type='text' value='' class='form-control' name='customer_household_vat_discount_id_number[" + i + "]' id='customer_household_vat_discount_id_number[" + i + "]'>";
        extraForm += "</div>";

        extraForm += "<div class='col-lg-3'>";
        extraForm += "<label class='top-buffer-half'>Fastighetsbeteckning</label>";
        extraForm += "<input type='text' value='' class='form-control' name='customer_household_vat_discount_real_estate_name[" + i + "]' id='customer_household_vat_discount_real_estate_name[" + i + "]'>";
        extraForm += "</div>";

        extraForm += "<div class='col-lg-6'>";
        extraForm += "<label class='top-buffer-half'>BRF org nummer</label>";
        extraForm += "<input type='text' value='' class='form-control' name='customer_household_org_number[" + i + "]' id='customer_household_org_number[" + i + "]'>";
        extraForm += "</div>";

        extraForm += "<div class='col-lg-6'>";
        extraForm += "<label class='top-buffer-half'>Lägenhetsnummer</label>";
        extraForm += "<input type='text' value='' class='form-control' name='customer_household_lagenhets_number[" + i + "]' id='customer_household_lagenhets_number[" + i + "]'>";
        extraForm += "<a href='#' class='text-right btn btn-beta top-buffer-half' id='remove-line'>Ta bort</a>";
        extraForm += "</div>";

        extraForm += "</div>";

        householdVat.append(extraForm);
        i++;
        return false;
    });

    $('#add-line-price-adjust').live('click', function (e) {
        var price_adjust = $('#price_adjust');

        e.preventDefault();
        var extraForm = "<div class='col-lg-12'>";

        extraForm += "<div class='dis_row'>";

        extraForm += "<div class='col-lg-9 col-md-6 col-sm-6'>";
        extraForm += "<label class='top-buffer-half'>Beskrivning:</label>";
        extraForm += "<input required type='text' value='' class='form-control' name='price_adjust[" + i + "][price_adjust_code]' id=''>";
        extraForm += "</div>";
        extraForm += "<div class='col-lg-3 col-md-6 col-sm-6'>";
        extraForm += "<label class='top-buffer-half'>Summa:</label>";
        extraForm += "<input required type='number' value='' class='form-control' name='price_adjust[" + i + "][price_adjust_amount]' id=''>";
        extraForm += "<a href='#' class='text-right btn btn-beta top-buffer-half' id='remove-line'>Ta bort</a>";
        extraForm += "</div>";
        extraForm += "</div>";
        extraForm += "</div>";

        price_adjust.append(extraForm);
        i++;
        return false;
    });


    $('#remove-line').live('click', function (e) {
        e.preventDefault();
        $(this).parent('div').parent('div').remove();
        i--;
    });

    $('#toggle-log').live('click', function (e) {
        e.preventDefault();
        $("#log").slideToggle();
        $(this).toggleClass('btn-toggle-hover');
    });

    $('#toggle-order_documents').live('click', function (e) {
        e.preventDefault();
        $("#order_documents").slideToggle();
        $(this).toggleClass('btn-toggle-hover');
    });

    $('#toggle-checklists').live('click', function (e) {
        e.preventDefault();
        $("#checklists").slideToggle();
        $(this).toggleClass('btn-toggle-hover');
    });

    $('#toggle-dates').live('click', function (e) {
        e.preventDefault();
        $("#dates").slideToggle();
        $(this).toggleClass('btn-toggle-hover');
    });

    $('#toggle-invoices').live('click', function (e) {
        e.preventDefault();
        $("#invoices").slideToggle();
        $(this).toggleClass('btn-toggle-hover');
    });
    $('#toggle-orders').live('click', function (e) {
        e.preventDefault();
        $("#orders").slideToggle();
        $(this).toggleClass('btn-toggle-hover');
    });
    $('#toggle-prepayment-invoices').live('click', function (e) {
        e.preventDefault();
        $("#prepayment-invoices").slideToggle();
        $(this).toggleClass('btn-toggle-hover');
    });
    $('#toggle-external-invoices').live('click', function (e) {
        e.preventDefault();
        $("#external-invoices").slideToggle();
        $(this).toggleClass('btn-toggle-hover');
    });

    $('.steps-btn').live('click', function (e) {
        $.LoadingOverlay('show');
    });

    $('.toggle-btn').live('click', function (e) {
        e.preventDefault();
        $(this).find('.fa').toggleClass('fa-rotate-180');
        $(this).toggleClass('btn-toggle-hover');
    });

    $('.toggles').live('click', function () {
        var toggle_id = $(this).attr('data-toggle-id');
        $('#' + toggle_id).toggle();
    });
    $(".order-checkbox").live('change', function () {
        var closest_datebox = $(this).nextAll('input').first();

        if (this.checked) {

            var now = new Date();

            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);

            var today = now.getFullYear() + "-" + (month) + "-" + (day);
            closest_datebox.val(today);


        } else {
            closest_datebox.val('');

        }
    });

    $(".generate_external_order_notes").live('click', function (e) {
        e.preventDefault();
        var generated_order_notes = $("#generated_order_notes");
        var tableObject = $(this).nextAll('table').first();
        var brand = tableObject.attr('id');
        var ary = [];
        var return_ary = [];
        var return_html = "<ul class='list-unstyled'>";
        return_html += "<li>Varumärke: " + brand + "</li>";

        //ary[0] = {Varumarke: brand};

        $('#' + brand + ' > tbody  > .line_item_row').each(function (a, b) {
            var g = [];
            var qty = $('.qty', b).text();
            var sku = $('.sku', b).text();
            var name = $('.name', b).text();
            ary.push({qty: qty, sku: sku, name: name});

        });

        $.each(ary, function (a, b) {
            return_html += "<li>Antal: " + b.qty + ", " + "Art.nr: " + b.sku + ", " + "Produktnamn: " + b.name + "</li>";


        });

        return_html += "</ul>";
        generated_order_notes.html(return_html);

    });


});

function copyToClipboard(element) {
    var temp = jQuery("<input>");
    jQuery("body").append(temp);
    temp.val(jQuery(element).text()).select();
    document.execCommand("copy");
    temp.remove();
}

function sortTable(n, id) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById(id);
    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc";
    /* Make a loop that will continue until
     no switching has been done: */
    while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.getElementsByTagName("TR");
        /* Loop through all table rows (except the
         first, which contains table headers): */
        for (i = 0; i < (rows.length - 1); i++) {
            // Start by saying there should be no switching:
            shouldSwitch = false;
            /* Get the two elements you want to compare,
             one from current row and one from the next: */
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /* Check if the two rows should switch place,
             based on the direction, asc or desc: */
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /* If a switch has been marked, make the switch
             and mark that a switch has been done: */
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            // Each time a switch is done, increase this count by 1:
            switchcount++;
        } else {
            /* If no switching has been done AND the direction is "asc",
             set the direction to "desc" and run the while loop again. */
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

function closeModalAndSendForm() {
    //jQuery("#settings-modal").modal('hide');

    jQuery.LoadingOverlay('show');


}

function closeModalAndSendFormUsers() {
    //jQuery("#settings-modal").modal('hide');
    var data_roll = jQuery('#todo_assigned_department option:selected').val();

    var searched_user_roll = jQuery('#todo_assigned__user option:selected').attr('data_roll');
    var no_value_selected = jQuery('#todo_assigned__user option:selected').text();

    if (data_roll === searched_user_roll) {
        jQuery.LoadingOverlay('show');

    } else if (no_value_selected === 'Inget värde valt') {

        jQuery.LoadingOverlay('show');

    } else {

        alert('Du måste välj rätt avdelning till användare');

    }

    /*    jQuery.LoadingOverlay('show');*/


}

function getProjects() {
    jQuery.ajax({
        url: ajaxUrl,
        type: 'POST',
        data: {
            action: 'get_projects_for_calendar'

        },
        success: function (result) {

            jQuery('#calendar').fullCalendar({
                // put your options and callbacks here
                locale: 'sv',
                weekends: true,
                events: result
            });
        }
    });

}

function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0)
            return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}


	