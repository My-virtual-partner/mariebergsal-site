var ajaxUrl = "/wp-admin/admin-ajax.php";
function save(event) {
    var project_heading = jQuery('#project_heading').val();
    var orderid = jQuery('#order-id').val();
    var project_description = jQuery('#project_description').val();
    var order_summary_addon_heading = jQuery('#order_summary_addon_heading').val();
    var order_summary_addon_description = jQuery('#order_summary_addon_description').val();
    var affarsforslaget_gallertom = jQuery('#affarsforslaget_gallertom').val();
    save_auto_pi(orderid, project_heading, project_description, order_summary_addon_heading, order_summary_addon_description, affarsforslaget_gallertom);
//alert(project_heading+project_description+order_summary_addon_heading+order_summary_addon_description+affarsforslaget_gallertom);
}
function jqueryshow_loader(display) {
    if (display == 'show') {
        jQuery(".front-loader").show();
    } else {
        jQuery(".front-loader").hide();
    }
    jQuery(".front-loader").html('<div class="loading_overlay" style="background-color: rgba(255, 255, 255, 0.8);/* position: absolute; */ display: block; /* flex-direction: column; *//* align-items: center; *//* justify-content: center; */z-index: 9999;background-image: url(&quot;/wp-content/plugins/imm-sale-system/js/loading.gif&quot;);background-position: center center;background-repeat: no-repeat;top: 0px;left: 0px;width: 100%;height: 100%;background-size: 100px;"></div><span>Laddar...</span>');
}
function save_auto_pi(orderid, project_heading, project_description, order_summary_addon_heading, order_summary_addon_description, affarsforslaget_gallertom) {
    jQuery.ajax({
        url: ajaxUrl,
        type: 'POST',
        data: {
            action: 'save_auto_pi',
            orderid: orderid,
            project_heading: project_heading,
            project_description: project_description,
            order_summary_addon_heading: order_summary_addon_heading,
            order_summary_addon_description: order_summary_addon_description,
            affarsforslaget_gallertom: affarsforslaget_gallertom

        },
        success: function (results) {
//            alert(results);
        }
    });
}
jQuery(document).on('click', 'a#submit-order',function (e) {
    e.preventDefault();
    jQuery("#save_order").val('1');
    jQuery("#invoice-form").submit();
    return false;
});
jQuery(document).on('click', 'a#removeorder',function (e) {
    e.preventDefault();
    if (!confirm("Vill du ta bort detta fakturaunderlag? Observera att den inte kommer att tas bort i fakturasystemet.")) {
        return false;
    }
    var invoicedid = jQuery(this).attr('data-order-id');
    jQuery.ajax({
        url: ajaxUrl,
        type: 'POST',
        data: {
            action: 'deleteinoviced',
            invoicedid: invoicedid,
        },
        beforeSend: function () {
//            jQuery.LoadingOverlay("show");
            jqueryshow_loader("show");
        },
        success: function (result) {
//            jQuery.LoadingOverlay("hide");
            jqueryshow_loader("hide");
            jQuery('.remove' + invoicedid).fadeOut(1000);
        }
    });
});
jQuery(document).on('click','.increment_product', function (e) {
    e.preventDefault();
    var orderId = jQuery("#order_id").val();
    var lineid = jQuery(this).attr('data-attribute-line-item-id');
    var minus = jQuery(this).attr('data-minus');
    jQuery.ajax({
        url: ajaxUrl,
        type: 'POST',
        data: {
            action: 'update_order_quantity',
            lineid: lineid,
            orderId: orderId,
            minus: minus
        },
        beforeSend: function () {
            jqueryshow_loader("show");
//            jQuery.LoadingOverlay("show");
        },
        success: function (result) {
            location.reload();
//            jQuery.LoadingOverlay("hide");
            jqueryshow_loader("hide");
        }
    });
});
jQuery(document).on("change",'.edit_customer #customer_email1', function (event) {
//    alert('yes1');
    var email = jQuery(this).val();
    jQuery('.exist_email').show();
    jQuery.ajax({
        url: 'https://mariebergsalset.com/lead.php',
        type: 'post',
        data: {
            email: email
        },
        dataType: 'JSON',
        success: function (result) {
            if (result == '1') {
                jQuery('.exist_email').html('E-post adressen finns redan');
                jQuery('.exist_email').css({'color': 'red', 'padding-left': '14px'});
                jQuery('.update_customer').hide();
            } else {

                jQuery('.exist_email').hide();
                jQuery('.update_customer').show();
            }
        }
    });
});
jQuery(document).on("change",'.customeremail #customer_email', function (event) {
    var email = jQuery(this).val();
    jQuery('.exist_email').show();
    jQuery.ajax({
        url: 'https://mariebergsalset.com/lead.php',
        type: 'post',
        data: {
            email: email
        },
        dataType: 'JSON',
        success: function (result) {
            if (result == '1') {
                jQuery('.exist_email').html('E-post adressen finns redan');
                jQuery('.exist_email').css({'color': 'red', 'padding-left': '14px'});
                jQuery('.create_project_btn').hide();
            } else {

                jQuery('.exist_email').hide();
                jQuery('.create_project_btn').show();
            }
        }
    });
});
jQuery(document).on("change",'#customer_email', function (event) {
    var email = jQuery('#customer_email').val();
    var disabled = jQuery('#disabled').val();
    if (email) {
//         alert('dfdf');
        get_create_leads(email);
    }
});
function get_create_leads(email) {

    jQuery.ajax({
        url: ajaxUrl,
        type: 'post',
        data: {
            action: 'get_create_lead',
            email: email
        },
        dataType: 'JSON',
        success: function (result) {
//            alert(result.lead_typavlead);
            jQuery('#customer_first_name').val(result.firstname);
//                        jQuery('#customer_last_name').val(result.last_name);
            jQuery('#customer_phone').val(result.lead_phone);
            jQuery('#customer_city').val(result.lead_city);
            jQuery('#customer_postnummer').val(result.lead_postnummer);
            jQuery('#customer_levernadress').val(result.lead_customer_levernadress);
            jQuery('#customer_homenummer').val(result.lead_customer_homenummer);
            if (result.braskamin_cb == 'checked') {
                jQuery("#braskamin_cb").prop("checked", true);
            }
            if (result.kakelugn_cb == 'checked') {
                jQuery("#kakelugn_cb").prop("checked", true);
            }
//                jQuery('#kakelugn_cb').val(result.kakelugn_cb);
            if (result.kakelugn_cb == 'checked') {
                jQuery("#kakelugn_cb").prop("checked", true);
            }
            if (result.frimurning_cb == 'checked') {
                jQuery("#frimurning_cb").prop("checked", true);
            }
            if (result.murspis_cb == 'checked') {
                jQuery("#murspis_cb").prop("checked", true);
            }
            if (result.etanol_cb == 'checked') {
                jQuery("#etanol_cb").prop("checked", true);
            }
            if (result.kassett_cb == 'checked') {
                jQuery("#kassett_cb").prop("checked", true);
            }
            if (result.vedspis_cb == 'checked') {
                jQuery("#vedspis_cb").prop("checked", true);
            }
            if (result.taljstensugn_cb == 'checked') {
                jQuery("#taljstensugn_cb").prop("checked", true);
            }
            if (result.service_cb == 'checked') {
                jQuery("#service_cb").prop("checked", true);
            }
            if (result.reservdel_cb == 'checked') {
                jQuery("#reservdel_cb").prop("checked", true);
            }
            if (result.tillbehor_cb == 'checked') {
                jQuery("#tillbehor_cb").prop("checked", true);
            }

            if (result.enplans_cb == 'checked') {
                jQuery("#enplans_cb").prop("checked", true);
            }
            if (result.ett_och_halva_plan == 'checked') {
                jQuery("#ett_och_halva_plan").prop("checked", true);
            }
            if (result.plans_cb == 'checked') {
                jQuery("#2_plans_cb").prop("checked", true);
            }
            if (result.Fritishus_cb == 'checked') {
                jQuery("#Fritishus_cb").prop("checked", true);
            }
            if (result.souterrang_cb == 'checked') {
                jQuery("#souterrang_cb").prop("checked", true);
            }
            if (result.nybygge_cb == 'checked') {
                jQuery("#nybygge_cb").prop("checked", true);
            }
            if (result.flerbistadshus_cb == 'checked') {
                jQuery("#flerbistadshus_cb").prop("checked", true);
            }
            if (result.torpargrundkrypgrund_cb == 'checked') {
                jQuery("#torpargrundkrypgrund_cb").prop("checked", true);
            }
            if (result.solceller_cb == 'checked') {
                jQuery("#solceller_cb").prop("checked", true);
            }
            if (result.platta_pa_mark_cb == 'checked') {
                jQuery("#platta_pa_mark_cb").prop("checked", true);
            }
            if (result.kallare_cb == 'checked') {
                jQuery("#kallare_cb").prop("checked", true);
            }
            if (result.taksakerhet_finnssaknas_cb == 'checked') {
                jQuery("#taksakerhet_finnssaknas_cb").prop("checked", true);
            }
            jQuery('#takhojdbv_cb').val(result.takhojdbv_cb);
            jQuery("#customer_typavlead option:selected").html(result.lead_typavlead);
            jQuery('#byggar_cb').val(result.byggar_cb);
            jQuery('#annat_yttertak_cb').val(result.annat_yttertak_cb);
            jQuery('#antal_kanaler_cb').val(result.antal_kanaler_cb);
            jQuery('#ca_meter_cb').val(result.ca_meter_cb);
            jQuery('textarea#customer_other').val(result.lead_other);
//                jQuery('.showdata').html(result);
        }
    });
}
jQuery(function () {
    jQuery('textarea').each(function () {
        jQuery(this).height(jQuery(this).prop('scrollHeight'));
//           alert(min-height(jQuery(this).prop('scrollHeight')));
//           jQuery(this).min-height(jQuery(this).prop('scrollHeight'));
    });
});
jQuery(document).on('change',"select#store_Address", function () {
    var idBrand = jQuery('option:selected', this).attr('data');
    jQuery('#getBrand').val(idBrand);
});
jQuery(document).on('click','#popup #close', function (evt) {

    jQuery("#popup").hide();
});
jQuery(document).on('click', "#group", function () {
    var invoiceval = jQuery('input[name=group]:checked').val();
    jQuery("#get-invoice").val(invoiceval);
    jQuery("#popup").hide();
});
jQuery(document).on('change', "#order-customer-status", function () {

    if (jQuery("#order-customer-status").val() == 'false') {
        jQuery("#popup").show();
    }

});
jQuery(document).ready(function () {
    jQuery('.rapportTrigger').click(function () {
        if (jQuery('select#turn_around_time option:selected').val() == 'tbCost') {



            var role_status = jQuery('div#rapporter_tab select#internal_project_status_dropdown').val().split('#');
            if (role_status == 'Alla') {
                var current_status = "Alla";
                var roles = "Alla";
            } else {
                var current_status = role_status[0];
                var roles = role_status[1];
            }
            jQuery.ajax({
                url: '/wp-content/plugins/imm-sale-system/ajax/projectGet.php',
                type: 'POST',
                data: {
                    seller: jQuery('#rapport_Seller option:selected').val(),
                    butik: jQuery('#RapportoOfficeConnectionFilter option:selected').val(),
                    fromDate: jQuery('#rapporter_tab .FromDateRapport').val(),
                    toDate: jQuery('#rapporter_tab .ToDateRapport').val(),
                    project_ongoing: jQuery('#rapporter_tab select#order-by-this-project-status_project-ongoing').val(),
                    status: jQuery('#statusRapport option:selected').val(),
                    projectType: jQuery('#rapporter_tab #project_type').val(),
                    paymentType: jQuery('#rapporter_tab #payment_type').val(),
                    project_status: jQuery('#internal_project_status_dropdown').val(),
                    role_status: current_status,
                    roles: roles,
                    finishedProjectto: jQuery('#rapporter_tab .finishedProjectto').val(),
                    finishedProjectfrom: jQuery('#rapporter_tab .finishedProjectfrom').val()
                },
                success: function (result) {

                    jQuery("tbody#rapportTable,tbody.report_table").empty();
                    jQuery("tbody#rapportTable,.tbcost").show();
                    jQuery(".nottbcost,.exportdata").hide();

                    var data = jQuery.parseJSON(result);
//                alert(data);
                    if (data.length != 0) {

                        jQuery('textarea#exportdatain_tb').html(result);
                        jQuery('.exportdata_tb').show();


                        jQuery.each(jQuery(data), function (i, ob) {
                            var paymenttetm = ob["paymenttetm"];
                            var external_invoice_sum = ob["external_invoice_sum"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                            var i = ob["i"];
                            var order_id = ob["id"];
                            var skapat = ob["skapat"];
                            var order_date = ob["order_date"];
                            var status = ob["status"];
                            var pid = ob["pid"];
                            var namn = ob["namn"];
                            var saljare = ob["saljare"];
                            var custname = ob["custname"];
                            var butik = ob["butik"];
                            var office_connection = ob["office_connection"];
                            var totaltDagar = ob["totalamtformat"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                            var totalamount = ob["totalamount"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                            var external_invoice_date = ob["external_invoice_date"];
                            var project_type = ob["project_type"];
                            var supplier_cost = ob['supplier_cost'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                            jQuery("#rapportTable").append('<tr><td>' + i + '</td><td>' + order_id + '</td><td>' + skapat + '</td><td>' + order_date + '</td><td>' + external_invoice_date + '</td><td>' + status + '</td><td><a href="/project?pid=' + pid + '">' + pid + '</a></td><td>' + custname + '</td><td>' + saljare + '</td><td>' + butik + '</td><td style="float:left;width:120px;">' + paymenttetm + '</td><td style="width:140px;">' + project_type + '</td><td><b>' + totalamount + ' Kr</b></td><td><b>' + totaltDagar + ' Kr</b></td><td><b>' + external_invoice_sum + ' Kr</b></td><td><b>' + supplier_cost + ' Kr</b></td></tr>');
                        });

                    } else {
                        jQuery("#rapportTable").append('<tr>Inga resultat hittades</tr>');
                    }
                }
            })
        } else if (jQuery('select#turn_around_time option:selected').val() == 'tbkassa') {

            jQuery.ajax({
                url: '/wp-content/plugins/imm-sale-system/ajax/projectKasa.php',
                type: 'POST',
                data: {
                    seller: jQuery('#rapport_Seller option:selected').val(),
                    butik: jQuery('#RapportoOfficeConnectionFilter option:selected').val(),
                    fromDate: jQuery('#rapporter_tab .FromDateRapport').val(),
                    toDate: jQuery('#rapporter_tab .ToDateRapport').val(),
                    project_ongoing: jQuery('#rapporter_tab select#order-by-this-project-status_project-ongoing').val(),
                    status: jQuery('#statusRapport option:selected').val(),
                    projectType: jQuery('#rapporter_tab #project_type').val(),
                    paymentType: jQuery('#rapporter_tab #payment_type').val(),

                },
                success: function (result) {

                    jQuery("tbody#rapportTable,tbody.report_table").empty();
                    jQuery("tbody#rapportTable,.tbcost").show();
                    jQuery(".nokasas,.nottbcost,.exportdata").hide();

                    var data = jQuery.parseJSON(result);
//                alert(data);
                    if (data.length != 0) {

                        jQuery('textarea#kasa_export_data').html(result);
                        jQuery('.kasa_exportdata').show();

                        var incl_moms = 0;
                        var excul_moms = 0;
                        jQuery.each(jQuery(data), function (i, ob) {
                            var paymenttetm = ob["paymenttetm"];
                            incl_moms += Number(ob["totalamount"]);
                            excul_moms += Number(ob["excul_moms"]);
                            var i = ob["i"];
                            var order_id = ob["id"];
                            var skapat = ob["skapat"];
                            var order_date = ob["order_date"];
                            var status = ob["status"];
                            var pid = ob["pid"];
                            var namn = ob["namn"];
                            var saljare = ob["saljare"];
                            var custname = ob["custname"];
                            var butik = ob["butik"];
                            var project_type = ob["project_type"];
                            var totalamount = ob["totalamount"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                            var exclamount = ob["excul_moms"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");

                            jQuery("#rapportTable").append('<tr><td>' + i + '</td><td>' + order_id + '</td><td>' + skapat + '</td><td>' + order_date + '</td><td>' + status + '</td><td><a href="/project?pid=' + pid + '">' + pid + '</a></td><td>' + custname + '</td><td>' + saljare + '</td><td>' + butik + '</td><td style="float:left;width:120px;">' + paymenttetm + '</td><td>' + project_type + '</td><td><b>' + exclamount + ' Kr</b></td><td><b>' + totalamount + ' Kr</b></td></tr>');
                        });
                        jQuery(".report_table").append('<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td ></td><td></td><td style="float:right;"><b>Totalt inkl. moms</b></td><td><b style="float:right;">' + incl_moms.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' Kr</b></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td ></td><td></td><td style="float:right;"><b>Totalt exkl. moms</b></td><td ><b style="float:right;">' + excul_moms.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' Kr</b></td></tr>');
                    } else {
                        jQuery("#rapportTable").append('<tr>Inga resultat hittades</tr>');
                    }
                }
            })
        }

    });
    jQuery("ul#product-list_head").sortable({

        delay: 300,
        stop: function () {
            var selectedData = new Array();
            jQuery('ul#product-list_head .sortingorder').each(function () {
                selectedData.push(jQuery(this).attr("data-attribute-line-item-ids"));
            });
            var orderid = jQuery(this).attr("data-orderid");
            updatesortOrder(selectedData, orderid, 'head');
        }
    });
    jQuery("ul#product-list").sortable({

        delay: 300,
        stop: function () {
            var selectedData = new Array();
            jQuery('ul#product-list .sortingorder').each(function () {
                selectedData.push(jQuery(this).attr("data-attribute-line-item-ids"));
            });
            var orderid = jQuery(this).attr("data-orderid");
            updatesortOrder(selectedData, orderid);
        }
    });
    function updatesortOrder(data, orderid, head = false) {
//alert(data+"  --  "+orderid);
        jQuery.ajax({
            url: '/wp-content/plugins/imm-sale-system/ajax/sortorderitems.php',
            type: 'POST',
            data: {position: data, orderid: orderid, head, head},
            success: function (result) {

                //alert("successfully updated");
            }
        })
    }

    jQuery('#previewsent').click(function () {
        var supplier_email = jQuery("div#settings-mail-project #supplier_email").val();
        var copy_email = jQuery("div#settings-mail-project #copy_email").val();
        var user_subject = jQuery("div#settings-mail-project #newsubject").text();
        var newblock = jQuery("div#settings-mail-project #newblock").text();
        var address = jQuery("div#settings-mail-project #pofficeaddress").text();
        var body = jQuery("div#settings-mail-project #user_texstarea").html();
        var otherinforadd = [];
        jQuery('div#settings-mail-project table#otherinforadd tr').each(function () {

            otherinforadd.push({'title': jQuery(this).children('td').eq(0).text(), 'value': jQuery(this).children('td').eq(1).text()});
        });
        var product_data = [];
        jQuery('div#settings-mail-project table#product_data tr').each(function () {
            if (jQuery(this).children('td').eq(0).text() != '') {
                product_data.push({'name': jQuery(this).children('td').eq(0).text(), 'article': jQuery(this).children('td').eq(1).text(), 'quantity': jQuery(this).children('td').eq(2).text()});
            }
        });
        var brand_nameget = jQuery("#brand_nameget").val();
        var orderid = jQuery("input[name = 'quick-order-id']").val();
        jQuery.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'preview_sent',
                supplier_email: supplier_email,
                user_subject: user_subject,
                product_data: product_data,
                otherinforadd: otherinforadd,
                copy_email: copy_email,
                brand_nameget: brand_nameget,
                orderid: orderid,
                newblock: newblock,
                address, address,
                body: body
            },
            success: function (results) {

                jQuery('#settings-mail-project a.close').trigger('click');
            }
        });
    });
    jQuery(document).on("click","a.generate_external_order_notes", function () {
        jQuery('.projectappend').html('');
        jQuery('div#settings-mail-project .modal-content-mail #otherinforadd tr').remove();
        jQuery('div#settings-mail-project .modal-content-mail #product_data tr').remove();
        jQuery('#officeaddress').html('');
        var getbrands = jQuery(this).attr('data-brands');
        var orderitemsid = [];
        var lastNote = [];
        jQuery('#' + getbrands + " tr.line_item_row").each(function () {
            var getorderitemids = jQuery(this).attr('id')
            orderitemsid.push(getorderitemids);
            lastNote.push(jQuery('#' + getorderitemids + ' td:last-child input').val());
        });
        var projectid = jQuery('input[name="quick-order-id"]').val();
        var GetOfficeAddress = jQuery('#customer_address option:selected').val();
        if (GetOfficeAddress != '') {
            var officeaddress = GetOfficeAddress;
        } else {
            var officeaddress = jQuery('select#office_connection option:selected').val();
        }
        var brandid = jQuery(this).attr('data-id');
        jQuery('#user_subject,#user_subject_below,#user_subject_middle').html(projectid);
        jQuery.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'callback_send_email',
                projectid: projectid,
                orderitemsid: orderitemsid,
                officeaddress: officeaddress,
                brandid: brandid

            },
            success: function (results) {
                jQuery("#settings-mail-project").modal('show');
                results = JSON.parse(results);
                var orderid = jQuery("div#settings-modal input#order-id").val();
                jQuery('div#settings-mail-project input#supplier_email').val(results['supplier_email']);
                jQuery('.projectappend').html(orderid);
                jQuery('input#brand_nameget').val(brandid);
                jQuery(results['product_data']).each(function (j, obs) {

                    jQuery('div#settings-mail-project .modal-content-mail #product_data').append("<tr><td contenteditable='true' style='padding: 4px;'>" + obs[0] + "</td><td contenteditable='true' style='padding: 4px;'>" + obs[1] + "</td><td contenteditable='true' style='padding: 4px;'>" + obs[2] + "</td></tr>");
                });
                var k = 1;
                Object(lastNote).forEach(function (j, not) {

                    jQuery('div#settings-mail-project .modal-content-mail #product_data tr:nth-child(' + k + ')').append("<td contenteditable='true' style='padding: 4px;'>" + j + "</td>");
                    k = k + 1;
                });
                jQuery.each(jQuery(results['otherinfo']), function (i, ob) {
                    jQuery('div#settings-mail-project .modal-content-mail #otherinforadd').append("<tr ><td contenteditable='true' style='padding: 4px;'> " + ob[0] + "</td><td contenteditable='true' style='padding: 4px;'> " + ob[1] + "</td></tr>");
                });
                jQuery('#officeaddress').html(results['officeaddress']);
                jQuery('#store_title').html(results['store_title']);
            }
        });
    });
    jQuery(document).on("click", "#previewallsent",function () {
        var brandid = jQuery(this).attr('data-id');
        var orderid = jQuery('input[name="quick-order-id"]').val();
        jQuery('div#settings-mail-project_previewmode .modal-content-mail .nav-tabs').html('');
        jQuery('div#settings-mail-project_previewmode .modal-content-mail .tab-content').html('');
        jQuery.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'previewcallback',
                brandid: brandid,
                orderid: orderid,
            },
            success: function (results) {
                results = JSON.parse(results); //console.log(results);
                jQuery("#settings-mail-project_previewmode").modal('show');
                jQuery.each(results[0], function (i, ob) {
                    if (i === 0)
                    {
                        var active = 'active in';
                        var actives = 'active';
                    } else {
                        var active = '';
                        var actives = '';
                    }
                    var dt = eval(ob['timestamp'] * 1000);
                    var myDate = new Date(dt);
                    jQuery('div#settings-mail-project_previewmode .modal-content-mail .nav-tabs').append('<li class="' + actives + '"><a data-toggle="tab" href="#menu' + i + '">' + myDate.toLocaleString() + '</a></li>');
                    var subject = '<div class="col-xs-1">	<label for="subject">�mne</label></div><div class="col-xs-11"><p id="user_subject">' + ob['subject'] + '</p></div>';
                    var productdata = '';
                    jQuery(ob['product_data']).each(function (j, obs) {
                        var divHtml = "<tr><td style='padding: 4px;'>" + obs['name'] + "</td><td style='padding: 4px;'>" + obs['article'] + "</td><td style='padding: 4px;'>" + obs['quantity'] + "</td><tr>";
                        productdata += divHtml;
                    });
                    var newotherinfos = '';
                    jQuery(ob['otherinforadd']).each(function (j, obj) {
                        var otherHtml = "<tr><td style='padding: 4px;'>" + obj['title'] + "</td><td style='padding: 4px;'>" + obj['value'] + "</td><tr>";
                        newotherinfos += otherHtml;
                    });
                    var newotherinfo = "<p >Skorstensinfo</p><table id='otherinforadd'>" + newotherinfos + "</table>";
                    var addhtml = '<div id="menu' + i + '" class="tab-pane fade ' + active + '"><div class="row">' + subject + '<div class="col-xs-12"><p id="newblock" >' + ob['newblock'] + '</p>' + newotherinfo + '</div></div><div id="user_texstarea" class="row"><div class="col-xs-12"><br><p >Orderrader:</p><table id="product_data">' + productdata + '</table><p  id ="address" >' + ob['address'] + '</p></div></div></div>';
                    jQuery('div#settings-mail-project_previewmode .modal-content-mail .tab-content').append(addhtml);
                });
            }
        });
    });
    jQuery('select#order-department_project-ongoing').on('change', function () {
        getDepartmentValue(jQuery(this).val(), 'get_internal_status', jQuery(this).attr('data-table_name'), 'filter_project_tab1', 'internal_project_status_user')
    });
    function getDepartmentValue(department, class_name, table_name = false, classes, newid) {
        var department = department;
        jQuery.ajax({
            url: ajaxUrl,
            type: 'post',
            data: {
                action: 'getDepartmentValue',
                department: department,
                table_name: table_name,
                classes: classes,
                newid: newid
            },
            success: function (result) {

                jQuery('#' + class_name).html(result);
                jQuery('.js-sortable-select').select2(
                        {
                            theme: "bootstrap",
                            width: '100%'
                        });
            }
        });
    }
    jQuery('select#todo-order-department_project-ongoing').on('change', function () {
        get_department(jQuery(this).val(), 'get_internal_status1', jQuery(this).attr('data-table_name'), 'filter_todo_tab', 'internal_project_status_user_todo')
    });
    function get_department(department, class_name, table_name = false, classes, newid) {
        var department = department;
        jQuery.ajax({
            url: ajaxUrl,
            type: 'post',
            data: {
                action: 'getDepartment',
                department: department,
                table_name: table_name,
                classes: classes,
                newid: newid
            },
            success: function (result) {

                jQuery('#' + class_name).html(result);
                jQuery('.js-sortable-select').select2(
                        {
                            theme: "bootstrap",
                            width: '100%'
                        });
            }
        });
    }

    jQuery("#updatelead").click(function () {
//var beskrivning =  jQuery('textarea#beskrivning').val();
        var customer_first_name = jQuery('input#customer_first_name').val();
        var customer_last_name = jQuery('input#customer_last_name').val();
        var customer_email = jQuery('input#customer_email').val();
        var customer_phone = jQuery('input#customer_phone').val();
        var customer_city = jQuery('input#customer_city').val();
        var customer_levernadress = jQuery('input#customer_levernadress').val();
        var customer_homenummer = jQuery('input#customer_homenummer').val();
        var customer_other = jQuery('#customer_other').val();
        var uid = jQuery('#uid').val();
        var allcheck = new Array();
        jQuery('input#lead_checkbox').each(function () {
            if (jQuery(this).prop("checked") == true) {
                allcheck.push(jQuery(this).val());
            } else {
                allcheck.push(jQuery(this).val() + '-1');
            }
        });
        var leadid = jQuery('input#leadid').val();
        var takhojdbv_cb = jQuery('input[name="takhojdbv_cb"]').val();
        var byggar_cb = jQuery('input[name="byggar_cb"]').val();
        var annat_yttertak_cb = jQuery('input[name="annat_yttertak_cb"]').val();
        var antal_kanaler_cb = jQuery('input[name="antal_kanaler_cb"]').val();
        var ca_meter_cb = jQuery('input[name="ca_meter_cb"]').val();
        jQuery.ajax({
            url: ajaxUrl,
            type: 'post',
            data: {
                action: 'update_customerdata',
                customer_first_name: customer_first_name,
                customer_last_name: customer_last_name,
                customer_email: customer_email,
                customer_phone: customer_phone,
                customer_city: customer_city,
                customer_levernadress: customer_levernadress,
                customer_homenummer: customer_homenummer,
                customer_other: customer_other,
                uid: uid,
                lead_checkbox: allcheck,
                leadid: leadid,
                takhojdbv_cb: takhojdbv_cb,
                byggar_cb: byggar_cb,
                antal_kanaler_cb: antal_kanaler_cb,
                ca_meter_cb: ca_meter_cb,
                annat_yttertak_cb: annat_yttertak_cb
            }, beforeSend: function () {
                jqueryshow_loader("show");
//                jQuery.LoadingOverlay("show");
            },
            success: function (result) {
                jqueryshow_loader("hide");
//                jQuery.LoadingOverlay("hide");
            }
        });
    });
});
jQuery(document).ready(function () {
    jQuery("#svedaara").click(function () {
        var beskrivning = jQuery('textarea#beskrivning').val();
        var pid = jQuery('input#pid').val();
        var typeservices = jQuery('#typeservice :selected').text();
//var ordprojectid =  jQuery('input[name="quick-project-id"]').val();
        jQuery.ajax({
            url: ajaxUrl,
            type: 'post',
            data: {
                action: 'call_meta',
                beskrivning: beskrivning,
                pid: pid,
                typeservices: typeservices
            }, beforeSend: function () {
                jqueryshow_loader("show");
//                jQuery.LoadingOverlay("show");


            },
            success: function (result) {
                jqueryshow_loader("hide");
//                jQuery.LoadingOverlay("hide");

            }
        });
    });
});
function delay(callback, ms) {

    var timer = 0;
    return function () {

        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {

            callback.apply(context, args);
        }, ms || 0);
    };
}
jQuery(document).ready(function ($) {
    $(document).on('click','.toggle-product-modal', function () {
        $("#not_sale").prop('checked', false);
        if ($(this).attr('data-order-price') == 'true') {

            $('#checksale').show();
        } else {

            $('#checksale').hide();
        }
    });
    $('.turn-off').hide();
    $('.orderterm').show();
    $('#turn_around_time').change(function () {
        $(".exportdata_tb,.exportdata,.hidefor").hide();
        $('.projekttyp').html('Intern Projektstatus');
        $('.time_around_text').html('Total summa ex moms');
        if ($('#turn_around_time').val() == 'leadTid') {
            $('.main_off').hide();
            $('.orderterm').hide();
            $("#rapportTable").hide();
            $(".turn-off,.no_kassa,.no_tbcost").show();
            $('.time_around_text').html('Totalt dagar');

        } else if ($('#turn_around_time').val() == 'tbCost') {
            $('#from').html('Orderdatum från');
            $('#to').html('Orderdatum till');
            $('.main_off,.no_tbcost').hide();
            $('.tbcosthosw,.no_kassa').show();
            $('.projekttyp').html('Projekttyp');
        } else if ($('#turn_around_time').val() == 'tbkassa') {
            $('.main_off,.no_kassa').hide();
            $('.showkasa,.no_tbcost').show();

            $('.kasa_text').html('Exkl. moms');
            $('.projekttyp').html('Projekttyp');
        } else {
            $('.main_off').hide();
            $('.orderterm,.no_kassa,.no_tbcost').show();



        }
    });
    $('.rapportTrigger').click(function (e) {
        e.preventDefault();
        if ($('select#turn_around_time option:selected').val() == 'tbCost' || $('select#turn_around_time option:selected').val() == 'tbkassa') {
            return false;
        }
        var stepfrom = $('#rapport_Step_from option:selected').val();
        var stepto = $('#rapport_Step_till option:selected').val();
//alert(stepfrom + stepto);
        if (stepfrom == 'none' || stepto == 'none') {
            var stepFrom = 'leadTid';
            var stepTo = 'projectcompleted';
        } else {
            var stepFrom = stepfrom;
            var stepTo = stepto;
        }

        var seller = $('#rapport_Seller option:selected').val();
        var butik = $('#RapportoOfficeConnectionFilter option:selected').val();
        var status = $('#statusRapport option:selected').val();
        var fromDate = $('#rapporter_tab .FromDateRapport').val();
        var toDate = $('#rapporter_tab .ToDateRapport').val();
        var projectType = $('#rapporter_tab #project_type').val();
        var paymentType = $('#rapporter_tab #payment_type').val();
        var project_ongoing = $('#rapporter_tab select#order-by-this-project-status_project-ongoing').val();
        var project_status = $('#internal_project_status_dropdown').val();
        var syn_fortnox1 = $('#syn_fortnox1 option:selected').val();
        var syn_fortnox2 = $('#syn_fortnox2 option:selected').val();

        if ($('#turn_around_time').val() == 'leadTid') {
            var turnoff = 0;
            var stepFrom = $('#rapport_Step_from option:selected').val();
            var stepTo = $('#rapport_Step_till option:selected').val();
        } else {
            var turnoff = 1;
        }
        var role_status = $('div#rapporter_tab select#internal_project_status_dropdown').val().split('#');
        if (role_status == 'Alla') {
            var current_status = "Alla";
            var roles = "Alla";
        } else {
            var current_status = role_status[0];
            var roles = role_status[1];
        }



        $.ajax({
            type: "POST",
//            url: ajaxUrl,
            url: '/wp-content/plugins/imm-sale-system/reportajax.php',
            data: {
//                action: 'filter_table_rapport',
                action: 'filter_table_rapport1',
                stepFrom: stepFrom,
                stepTo: stepTo,
                seller: seller,
                butik: butik,
                fromDate: fromDate,
                toDate: toDate,
                project_ongoing: project_ongoing,
                status: status,
                turnoff: turnoff,
                projectType: projectType,
                paymentType: paymentType,
                project_status: project_status,
                role_status: current_status,
                roles: roles,
                syn_fortnox1: syn_fortnox1,
                syn_fortnox2: syn_fortnox2


            },
            beforeSend: function () {
//                $.LoadingOverlay("show");
                show_loader("show");
                $("#rapportTable tr").remove();
                $(".report_table tr").remove();
            },
            success: function (result) {

                $(".tbcost,.exportdata_tb").hide();
                $("#rapportTable,.nottbcost").show();

                show_loader("hide");
                var data = $.parseJSON(result);
//                alert(data);
                if (data.length != 0) {

                    $('textarea#exportdatain').html(result);
                    $('.exportdata').show();
                    var sum = 0;
                    var advance_total_amount = 0;
                    var final_total_amount = 0;
                    $.each($(data), function (i, ob) {
                        var paymenttetm = ob["paymenttetm"];
                        // var external_invoice_sum = ob["external_invoice_sum"].toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                        var i = ob["i"];
                        var order_id = ob["id"];
                        var skapat = ob["skapat"];
                        var order_date = ob["order_date"];
                        var status = ob["status"];
                        var pid = ob["pid"];
                        var namn = ob["namn"];
                        var saljare = ob["saljare"];
                        var custname = ob["custname"];
                        var advance = ob["advance"];
                        var finals = ob["final"];
                        var butik = ob["butik"];
                        var office_connection = ob["office_connection"];
                        var internal_status = (ob["internal_status"] != 'Alla' || ob["internal_status"] != '') ? ob["internal_status"] : "";
                        var totaltDagar = ob["totaltDagar"];
                        var totaltDay = ob['totaltDay'];
                        var advance_total = Number(ob["advance_total_amount"]);
                        var final_total = Number(ob["final_total_amount"]);
                        advance_total_amount += Number(ob["advance_total_amount"]);
                        final_total_amount += Number(ob["final_total_amount"]);
                        // alert(totaltDay);
                        if (turnoff == 0) {
                            totaltDagar = totaltDay;
                        }
                        if (turnoff == 1) {
                            sum += Number(ob["totalamtformat"]);
                        } else {
                            sum += Number(totaltDay);
                        }
                        var totaltDagarIncluMom = (sum * 25) / 100;
                        $("#rapportTable").append('<tr><td>' + i + '</td><td>' + order_id + '</td><td>' + skapat + '</td><td>' + order_date + '</td><td>' + status + '</td><td><a href="/project?pid=' + pid + '">' + pid + '</a></td><td>' + custname + '</td><td>' + saljare + '</td><td>' + butik + '</td><td style="float:left;width:120px;">' + paymenttetm + '</td><td style="width:140px;">' + internal_status + '</td><td>' + totaltDagar + '</td><td>' + advance + '</td><td><b>' + advance_total + ' kr</b></td><td>' + finals + '</td><td><b>' + final_total + ' kr</b></td></tr>');
                    });
                    var myrecord = sum / data.length;
                    if (myrecord % 1 == 0) {
                        var myrecorddata = myrecord;
                    } else {
                        var myrecorddata = myrecord.toFixed(2);
                    }
                    var totalsum = Math.round((sum * 25) / 100);
//                    alert(totalsum);

                    var recorddata = Math.round(myrecorddata);
                    var totalrecord = Math.round(recorddata);
//                    alert(recorddata);

                    if (turnoff == 1) {
                        var totalround = Math.round(sum);
                        var totalinclmom = Math.round(totalsum + sum);

                        $(".report_table").append('<tr class="lastamount"><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="width: 250px;text-align: right;"><strong style="width: 116px !important;float: right;">Faktura 1 Summa:</td><td style="font-weight:bold;    color: #000000; width:150px;text-align: right;">' + advance_total_amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' Kr</td><td style="width: 250px;text-align: right;"><strong style="width: 116px !important;float: right;">Totalt ordervärde exkl moms</strong></td><td style="font-weight:bold;    color: #000000; width:150px;text-align: right;">' + totalround.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' Kr</td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="width: 250px;text-align: right;"><strong style="width: 116px !important;float: right;">Faktura 2 Summa:</td><td style="font-weight:bold;    color: #000000; width:150px;text-align: right;">' + final_total_amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' Kr</td><td style="width: 250px;text-align: right;"><strong style="width: 116px !important;float: right;">Totalt ordervärde inkl moms</strong></td><td style="font-weight:bold;color: #000000;width:150px;text-align: right;">' + totalinclmom.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' Kr</td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="width: 250px;text-align: right;"><strong style="width: 116px !important;float: right;">Genomsnitt ordervärde</strong></td><td style="font-weight:bold;color: #000000;width:150px;text-align: right;">' + totalrecord.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' Kr</td><td></td></tr>');
                    } else {
                        $(".report_table").append('<tr class="lastamount"><td></td><td></td><td></td><td></td><td></td><td></td><td style="width: 250px;text-align: right;"><strong style="width: 116px !important;float: right;">Genomsnitt antal dagar</strong></td><td style="font-weight:bold;width:150px;text-align: right;">' + sum + '</td></tr>');
                    }


                } else {
                    $("#rapportTable").append('<tr>Inga resultat hittades</tr>');
                }
            }
        });
    })

    $('.upload-form-order-files .form-group input:file').change(
            function () {
                if ($(this).val()) {
                    $('.btn-upload-order').attr('disabled', false);
                } else {
                    $('.btn-upload-order').attr('disabled', true);
                }
            });
    $('.upload-form-order-files .form-group input:file').change(
            function () {
                if ($(this).val()) {
                    $('.btn-upload-order').attr('disabled', false);
                } else {
                    $('.btn-upload-order').attr('disabled', true);
                }
            });
    $('.upload-arbet-form-order-files .form-group input:file').change(
            function () {
                if ($(this).val()) {
                    $('.btn-upload-order').attr('disabled', false);
                } else {
                    $('.btn-upload-order').attr('disabled', true);
                }
            });
    $('.upload-arbet-form-order-files .form-group input:file').change(
            function () {
                if ($(this).val()) {
                    $('.btn-upload-order').attr('disabled', false);
                } else {
                    $('.btn-upload-order').attr('disabled', true);
                }
            });
    $('body').on('click', '.upload-arbet-form-order-files .btn-upload-order', function (e) {
        e.preventDefault();
        var projectId = $('input[name=order_id]').val();
        var arbetfile = $('#arbet_file').val();
        var fd = new FormData();
        var files_data = $('.upload-arbet-form-order-files .files-data'); // The <input typenumber-of-products="file" /> field
        // Loop through each data and create an array file[] containing our files data.
        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('files[' + j + ']', file);
            })
            f
        });
        // our AJAX identifier
        fd.append('action', 'order_files_upload');
        fd.append('projectId', projectId);
        fd.append('arbetfile', arbetfile);
        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: fd,
            contentType: false,
            projectId: projectId,
            arbetfile: arbetfile,
            processData: false,
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (response) {
                location.reload(true);
                // $('.upload-response').html(response); // Append Server Response
//                $.LoadingOverlay("hide");
                show_loader("hide");
                $('.btn-upload-order').attr('disabled', true);
                files_data.val('');
                $('.upload-response').html(response);
            }
        });
    });
    $('body').on('click', '.upload-form-order-files .btn-upload-order', function (e) {
        e.preventDefault();
        var projectId = $('input[name=order_id]').val();
        var fd = new FormData();
        var files_data = $('.upload-form-order-files .files-data'); // The <input typenumber-of-products="file" /> field
        // Loop through each data and create an array file[] containing our files data.
        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('files[' + j + ']', file);
            })
        });
        // our AJAX identifier
        fd.append('action', 'order_files_upload');
        fd.append('projectId', projectId);
        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: fd,
            contentType: false,
            projectId: projectId,
            processData: false,
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (response) {
                location.reload();
                // $('.upload-response').html(response); // Append Server Response
//                $.LoadingOverlay("hide");
                show_loader("hide");
                $('.btn-upload-order').attr('disabled', true);
                files_data.val('');
                $('.upload-response').html(response);
            }
        });
    });
//     $('#price_adjust_amount').on('change', function () {
//        if ($('#price_adjust_amount').val()) {
//            $('#price_adjust_inkopprice').prop("disabled", true);
//        } else {
//            $('#price_adjust_inkopprice').prop("disabled", false);
//        }
//
//    })
//    
//    $('#price_adjust_inkopprice').on('change', function () {
//        if ($('#price_adjust_inkopprice').val()) {
//            $('#price_adjust_amount').prop("disabled", true);
//        } else {
//            $('#price_adjust_amount').prop("disabled", false);
//        }
//
//    })

    $('#imm_sale_product_descount_value').on('change', function () {
        if ($('#imm_sale_product_descount_value').val()) {
            $('#imm_sale_product_amount_descount_value').prop("disabled", true);
        } else {
            $('#imm_sale_product_amount_descount_value').prop("disabled", false);
        }

    })

    $('#imm_sale_product_amount_descount_value').on('change', function () {
        if ($('#imm_sale_product_amount_descount_value').val()) {
            $('#imm_sale_product_descount_value').prop("disabled", true);
        } else {
            $('#imm_sale_product_descount_value').prop("disabled", false);
        }
    })

    $(document).on('click','.submit_discount', function (e) {
        e.preventDefault();
        var discount_value = $('#imm_sale_product_descount_value').val();
        var discount_amount_value = $('#imm_sale_product_amount_descount_value').val();
        var order_id = $('#order_id').val();
        var discount_product_name = $('#imm_sale_product_descount option:selected').text();
        var discount_product_val = $('#imm_sale_product_descount option:selected').val();
        var discount_product_id = $('#imm_sale_product_descount option:selected').attr('data-product_id');
        var discount_product_price = $('#imm_sale_product_descount option:selected').attr('data-product_price');
        var discount_product_qty = $('#imm_sale_product_descount option:selected').attr('data-product_qty');
        var lineItemId = $('#imm_sale_product_descount option:selected').attr("data-attribute-line-item-id");
//        alert(discount_product_price + discount_amount_value);

        /*      var discount_calculated_value = (discount_value * discount_product_price) / 100 ;
         var discount_product_name_li = '<li data-product_id="'+discount_product_id+'">Rabatt-' + discount_product_name + '<strong>-' + Math.round(discount_calculated_value) +'kr</strong></li>'
         */
//        alert(discount_value + discount_amount_value);
        if ((discount_value > 100 || discount_value < 1) && discount_amount_value == '') {
            alert('Vänligen skriv mellan 1 och 100% rabatt.');
        } else {

            if ((discount_value.length > 0 || discount_amount_value.length > 0) && discount_product_val != 'none') {

                $.ajax({
                    type: "POST",
                    url: ajaxUrl,
                    data: {
                        action: 'add_discount_product_to_offert',
                        discount_value: discount_value,
                        discount_amount_value: discount_amount_value,
                        order_id: order_id,
                        discount_product_name: discount_product_name,
                        discount_product_id: discount_product_id,
                        discount_product_price: discount_product_price,
                        discount_product_qty: discount_product_qty

                    },
                    beforeSend: function () {
                        show_loader("show");
                    },
                    success: function (result) {
                        show_loader("hide");
                        location.reload();
                        /*   $('input[name=forward-step]').trigger('click');*/
                        /*         $("#product-list").append(discount_product_name_li);*/

                        /*   /!*    location.reload();*!/*/

                    }

                });
            } else {
                alert('Välj produkt eller skriv i procent');
            }
        }

    })


    $(document).on('click','.tabort_repeater_row_offert', function (e) {
        e.preventDefault();
        var projectId = $('input[name=order_id]').val();
        var rowNummber = $(this).attr('data_row');
        var filUrl = $(this).attr('data_url');
        var parentUrl = $(this).parent('tr');
        // console.log(filUrl);
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                action: 'delete_order_file_function',
                projectId: projectId,
                rowNummber: rowNummber,
                filUrl: filUrl


            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (result) {
                show_loader("hide");
//                $.LoadingOverlay("hide");
                parentUrl.remove();
            }

        });
    })

    $(document).on('click','.tabort_arbet_repeater_row_offert', function (e) {
        e.preventDefault();
        var projectId = $('input[name=order_id]').val();
        var rowNummber = $(this).attr('data_row');
        var filUrl = $(this).attr('data_url');
        var parentUrl = $(this).parent('tr');
        // console.log(filUrl);
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                action: 'delete_order_file_function',
                projectId: projectId,
                arbet_file: 'yes',
                rowNummber: rowNummber,
                filUrl: filUrl


            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (result) {
                show_loader("hide");
//                $.LoadingOverlay("hide");
                parentUrl.remove();
            }

        });
    })

    $(document).on('click','.tabort_bild_render', function (e) {
        e.preventDefault();
        var offertId = $(this).attr('data_order');
        var placmentId = $(this).attr('data_placement');
        var jsonName = $(this).attr('data_name');
        var data_div_id = $(this).attr('data_div_id');
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                action: 'delete_bild_render',
                offertId: offertId,
                placmentId: placmentId,
                jsonName: jsonName


            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (result) {
                show_loader("hide");
//                $.LoadingOverlay("hide");
                /*      var t = JSON.parse(result);*/
                $('#' + data_div_id).remove();
                location.reload();
            }

        });
    })

    function doConfirm(msg, yesFn, noFn) {
        var confirmBox = jQuery("#confirmBox");
        confirmBox.find(".message").text(msg);
        confirmBox.find(".yes,.no").unbind().click(function () {
            confirmBox.hide();
        });
        confirmBox.find(".yes").click(yesFn);
        confirmBox.find(".no").click(noFn);
        confirmBox.show();
    }

    $(document).on('click','.redigera_sale_sub_contractor_btn', function () {

        var ue_id = $(this).attr('data_id');
        $('#sub_contractor_id_hidden_field').val(ue_id);
    })

    $(document).on('click', '.create_new_ue',function () {

        var sub_fornamn = $('.sub_cont_fornamn_new').val();
//        var sub_efternamn = $('.sub_cont_efternamn_new').val();
        var sub_epost = $('.sub_cont_epost_new').val();
        var sub_tel = $('.sub_cont_tel_new').val();
        var sub_company = $('.sub_cont_company_new').val();
        var sub_shortname = $('.sub_cont_shortname_new').val();
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                action: 'create_subcontractor',
                sub_fornamn: sub_fornamn,
//                        sub_efternamn: sub_efternamn,
                sub_epost: sub_epost,
                sub_tel: sub_tel,
                sub_company: sub_company,
                sub_shortname: sub_shortname


            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (result) {
                show_loader("hide");
//                $.LoadingOverlay("hide");

                alert(result);
                location.reload();
            }

        });
    })

    $(document).on('click','.spara_sub_contractor_info', function () {

        var ue_id = $(this).attr('data_id');
        var sub_fornamn = $('.sub_cont_fornamn' + ue_id).val();
//        var sub_efternamn = $('.sub_cont_efternamn' + ue_id).val();
        var sub_epost = $('.sub_cont_epost' + ue_id).val();
        var sub_tel = $('.sub_cont_tel' + ue_id).val();
        var sub_company = $('.sub_cont_company' + ue_id).val();
        var sub_shortname = $('.sub_cont_shortname' + ue_id).val();
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                action: 'edit_subcontractor_info',
                ue_id: ue_id,
                sub_fornamn: sub_fornamn,
//                        sub_efternamn: sub_efternamn,
                sub_epost: sub_epost,
                sub_tel: sub_tel,
                sub_company: sub_company,
                sub_shortname: sub_shortname


            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (result) {
                show_loader("hide");
//                $.LoadingOverlay("hide");
                alert('Informationen har sparats');
            }

        });
    })


    $(document).on('click','.delete_sub_contractor_info', function () {
        var ue_id = $(this).attr('data_id');
        var ue_fname = $(this).attr('data_name');
        var r = confirm("Vill du verkligen markera UE som borttagen?");
        if (r == true) {
// console.log(ue_fname);
            $.ajax({
                type: "POST",
                url: ajaxUrl,
                data: {
                    action: 'delete_subcontractor_info',
                    ue_id: ue_id,
                    ue_fname: ue_fname

                },
                beforeSend: function () {
                    show_loader("show");
//                    $.LoadingOverlay("show");
                },
                success: function (result) {
                    show_loader("hide");
//                    $.LoadingOverlay("hide");
                    alert('UE är markerat som borttagen');
                    location.reload();
                }

            });
        }


    })
    jQuery(document).on('click',"#esimateid", function () {
//        alert(jQuery("#order_id").val());
        jQuery.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'sendEstimate',
                salesmanid: jQuery('#salesmanidPI').val(),
                subject: jQuery('#estimate_edits #subject').html(),
                body: jQuery('#estimate_edits #message').html(),
                userid: jQuery('#useridPI').val(),
                order_id: jQuery('#custom_mypop #quickorder').val(),
                emails: jQuery('#receipt').val()

            },
            success: function (results) {
                jQuery('#estimate_edits .close').trigger('click');
            }
        });

    });
    jQuery(document).on('click',".send_sms1", function (e) {
        e.preventDefault();
        var summary_url = jQuery(this).attr('data-url');
        jQuery('#sms_edits #links').val(summary_url);
        var phone = jQuery('#custom_mypop #userPhone').val();
        jQuery('#sms_edits #phone').val(phone);
        var msg = jQuery(this).attr('data_msg');
        jQuery('#sms_edits #message').val(msg);
        jQuery("#sms_edits").modal('show');


    });
    jQuery(document).on('click','#send_invoice_to_customer1', function () {
        var newdagta = jQuery('#estimate_edits #receipt');
        var newData = jQuery(this);
        jQuery.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'send_estimate',
                salesmanid: jQuery('#salesmanidPI').val(),
                userid: jQuery('#useridPI').val(),
                print: jQuery(this).attr('data-print'),
                order_id: jQuery('#custom_mypop #quickorder').val()
            },
            success: function (results) {
               // console.log(results);
                var data = JSON.parse(results);
                jQuery('#estimate_edits #order_id').val(data.order_id);
                jQuery('#estimate_edits #subject').html(data.subject);
                jQuery('#estimate_edits #message').html(data.message);

                newdagta.tagsinput('add', data.filterEmail);
                var summary_url = newData.attr('data-url');
                jQuery('a.url_form').attr('href', summary_url);
                jQuery("#estimate_edits").modal('show');
                //  jQuery('#estimate_edits .close').trigger('click');
            }
        });
    });
    jQuery('#smsid').click(function () {

        jQuery.ajax({

            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'sendSMS',
                message: jQuery('#sms_edits #message').text(),
                links: jQuery('#sms_edits #links').val(),
                phone: jQuery('#sms_edits #phone').val(),
                order_id: jQuery('#sms_edits #order_id').val(),

            },
            success: function (results) {
                jQuery('#sms_edits .close').trigger('click');
            }
        });
    });
    $(document).on('click','.send_sms', function (e) {
		     e.preventDefault();
        var order_id = $('#custom_mypop #quickorder').val();
        var tel_num = $(this).attr('data_tel');
        var tel_msg = $(this).attr('data_msg');
        var tel_lank = $(this).attr('data_lank');
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                action: 'send_msg_to_customer',
                tel_num: tel_num,
                tel_msg: tel_msg,
                tel_lank: tel_lank,
                order_id: order_id


            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (result) {
                show_loader("hide");
//                $.LoadingOverlay("hide");
                alert('Tack,meddelande har skickats');
            }

        });
    })

    $(document).on('click','.redigera_offert_verktyg', function (e) {
//        e.preventDefault();
if($('#custom_mypop #quickorder').val()){
     var order_id = $('#custom_mypop #quickorder').val();
        var user_id = $('#custom_mypop #useridPI').val();
}else{
	     var order_id = $(this).attr('data_orderid');
        var user_id =  $(this).attr('data_current_user_id');
}
        $.ajax({
            type: "POST",
            url: '/wp-content/plugins/imm-sale-system/ajax/single_order/edit.php',
            data: {
               // action: 'update_offert_status_when_editing',
			   
                order_id: order_id,
                user_id: user_id,
				checknew:1
            },
            beforeSend: function () {
                modal_loader("show");
            },
            success: function (result) {
                modal_loader("hide");
                $(location).attr('href', '/system-dashboard/order-steps?order-id=' + order_id + '&step=0');
            }
        });
    });
    $(document).on('click','.edit_by', function (e) {
   var order_id = $('#custom_mypop #quickorder').val();
        var user_id = $('#custom_mypop #useridPI').val();
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                action: 'update_offert_status',
                order_id: order_id,
                user_id: user_id
            },
            beforeSend: function () {
                modal_loader("show");
            },
            success: function (result) {
                modal_loader("hide");
                $(location).attr('href', '/system-dashboard/order-steps?order-id=' + order_id + '&step=0');
            }

        });
    });
    /*    $('#imm-sale-order-date_from').datepicker();*/

    $('.imm-sale-order-filter-status').bind('change', function (e) {
        e.preventDefault();
        var status = $('#imm-sale-order-status').val();
        var from_date = $('.date_from').val();
        var to_date = $('.date_to').val();
        var all_office_in_mb = $('#office_connection_filter :selected').val();
        var imm_sale_order_saljare_filter = $('#imm_sale_order_saljare_filter :selected').val();
        //   console.log(from_date);
//console.log(to_date);

        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                action: 'filter_table_ordrar',
                status: status,
                from_date: from_date,
                to_date: to_date,
                all_office_in_mb: all_office_in_mb,
                imm_sale_order_saljare_filter: imm_sale_order_saljare_filter


            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
                $("#alla-ordrar-table tr").remove();
                $("#tatal_egen_order ").text('');
            },
            success: function (result) {
 
                show_loader("hide");
//                $.LoadingOverlay("hide");
                var data = $.parseJSON(result);
                var totalArrayForAllOrders = [];
                $.each($(data), function (i, ob) {
                    var i = ob["i"];
                    var order_id = ob["id"];
                    var skapat = ob["skapat"];
                    var exl_moms = ob["exl_moms"];
                    var moms = ob["moms"];
                    var totalt = ob["totalt"];
                    var status = ob["status"];
                    var pid = ob["pid"];
                    var namn = ob["namn"];
                    var saljare = ob["saljare"];
                    var butik = ob["butik"];
                    var total2 = ob["totalt2"];
                    var office_connection = ob["office_connection"];
                    totalArrayForAllOrders.push(total2);
                    $("#alla-ordrar-table ").append('<tr><td>' + i + '</td><td>' + order_id + '</td><td>' + skapat + '</td><td>' + exl_moms + '</td><td>' + moms + '</td><td>' + totalt + '</td><td>' + status + '</td><td><a href="/project?pid=' + pid + '">' + pid + '</a></td><td>' + namn + '</td><td>' + saljare + '</td><td>' + butik + '</td></tr>');
                })

                var totaltavordrar = 0;
                for (var i = 0; i < totalArrayForAllOrders.length; i++) {
                    totaltavordrar += totalArrayForAllOrders[i] << 0;
                }
                $('#total_price_for_all_self_order').html(currencyFormat(totaltavordrar));
            }

        });
    })

    function currencyFormat(num) {
        return num.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ') + ' kr'
    }

    $(document).on('click','.tabort_repeater_row', function (e) {
        e.preventDefault();
        var projectId = $('input[name=quick-project-id]').val();
        var rowNummber = $(this).attr('data_row');
        var filUrl = $(this).attr('data_url');
        var parentUrl = $(this).parent('tr');
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                action: 'delete_project_file_function',
                projectId: projectId,
                rowNummber: rowNummber,
                filUrl: filUrl


            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (result) {
                show_loader("hide");
//                $.LoadingOverlay("hide");

                parentUrl.remove();
            }

        });
    })


    $('.upload-form-project-files .form-group input:file').change(
            function () {
                if ($(this).val()) {
                    $('.btn-upload').attr('disabled', false);
                    // or, as has been pointed out elsewhere:
                    // $('input:submit').removeAttr('disabled');
                }
            });
    $('body').on('click', '.upload-form-project-files .btn-upload', function (e) {
        e.preventDefault();
        var projectId = $('input[name=quick-project-id]').val();
        var fd = new FormData();
        var files_data = $('.upload-form-project-files .files-data'); // The <input type="file" /> field
        // Loop through each data and create an array file[] containing our files data.
        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('files[' + j + ']', file);
            })
        });
        // our AJAX identifier
        fd.append('action', 'project_files_upload');
        fd.append('projectId', projectId);
        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: fd,
            contentType: false,
            projectId: projectId,
            processData: false,
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (response) {
                // $('.upload-response').html(response); // Append Server Response
//                $.LoadingOverlay("hide");
                show_loader("hide");
                $('.btn-upload').attr('disabled', true);
                files_data.val('');
                $('.upload-response').html(response);
            }
        });
    });
    if ($('#get_products_related_to_head').prop("checked")) {
        filter_and_return_products_related();
    } else if ($('#get_products_related_to_head').not(':checked').length) {
        filter_and_return_products(); //round
    }

    $('#get_products_related_to_head').click(function () {
        if ($('#get_products_related_to_head').prop("checked")) {
            filter_and_return_products_related();
        } else {
            filter_and_return_products();
        }


    });
    $("select[name='prod_id']").on("change", function () {

        if ($('#get_products_related_to_head').prop("checked")) {
            filter_and_return_products_related();
        } else {
            filter_and_return_products();
        }


    });
    $("select[name='brand_id']").on("change", function () {

        if ($('#get_products_related_to_head').prop("checked")) {
            filter_and_return_products_related();
        } else {
            filter_and_return_products();
        }


    });
    /*
     $('.projects_nav').on('click', function () {
     
     var selected_Val = $('select[name=order-by-mine-or-all] option:selected').text();
     if (selected_Val === 'Alla') {
     
     var selected_option = $('select[name=order-by-mine-or-all]').find('[data_val="mina"]');
     selected_option.prop('selected', 'selected').change();
     }
     
     });
     */


    /*Uppgift->project->display only users for selected department*/


    $(document).on('change','#todo_project_connection', function (e) {

        var project_id = $('#todo_project_connection option:selected').val();
        var project_title = $('#todo_project_connection option:selected').text();
        $('.till_project_link_class').show();
        $('.till_project_link_class').attr('href', 'http://mariebergsalset.com/project?pid=' + project_id);
    })



//    $('#todo_assigned_user').live('change', function (e) {
//
//        var data_roll = $('#todo_assigned_user option:selected').attr('data_roll');
//        var data_roll_value = $('#todo_assigned_user option:selected').val();
//        var searched_department_val = $('#todo_assigned_department option:selected').val();
//        var searched_department_roll = $('#todo_assigned_department').find('[value="' + data_roll + '"]');
//
//
//        if (data_roll == undefined) {
//            console.log('data_roll');
//        } else if (data_roll !== undefined && data_roll === searched_department_val) {
//            console.log('data_roll');
//        } else {
//            $('#selected_user_value').val(data_roll_value);
//            searched_department_roll.prop('selected', 'selected').change();
//
//        }
//
//
//    })


    /*end isplay only users for selected department*/


    var $all_options = $('#assigned-technician-select').children().clone();
    $('#order_salesman_hiden_Select').append($all_options);
    var data_roll = $('#imm-sale-order-department option:selected').val();
    var searched_user_roll = $('#order_salesman_hiden_Select').find('[data_roll="' + data_roll + '"]');
    if (data_roll === 'alla') {
        $('#assigned-technician-select').empty();
        var $choosen_options = $('#order_salesman_hiden_Select').children().clone();
        $('#assigned-technician-select').append($choosen_options);
    } else {

        $('#assigned-technician-select').empty();
        var $choosen_options = searched_user_roll.clone();
        $('#assigned-technician-select').append('<option value=""> Inget värde valt </option>');
        $('#assigned-technician-select').append($choosen_options);
    }

    /*
     var order_salesman_selected_option = $('#order_salesman option:selected').val();
     $('#assigned-technician-select').val(order_salesman_selected_option);
     $('#assigned-technician-select').prop('selected', 'selected').change();
     */


    /*Uppgift->project->display only users for selected department*/
    $(document).on('change','#imm-sale-order-department', function (e) {

        var data_roll = $('#imm-sale-order-department option:selected').val();
        var searched_user_roll = $('#order_salesman_hiden_Select').find('[data_roll="' + data_roll + '"]');
        if (data_roll === 'alla') {
            $('#assigned-technician-select').empty();
            var $choosen_options = $('#order_salesman_hiden_Select').children().clone();
            $('#assigned-technician-select').append($choosen_options);
        } else {

            $('#assigned-technician-select').empty();
            var $choosen_options = searched_user_roll.clone();
            $('#assigned-technician-select').append('<option value=""> Inget värde valt </option>');
            $('#assigned-technician-select').append($choosen_options);
        }
    })

    /*end isplay only users for selected department*/


    $(document).on("change",".variation-control", function () {
        var dataAttributeProductId = $(this).data('attribute_product-id');
        var selectedValues = [];
        $('.modal-body  .product-id' + dataAttributeProductId).each(function () {
            selectedValues.push([$(this).data('attribute_name'), $(this).val()]);
        });
        $.ajax({
            type: "GET",
            url: ajaxUrl,
            data: {
                action: 'sales_get_variation_id',
                prod_id: dataAttributeProductId,
                selected_values: selectedValues
            },
            beforeSend: function () {
                show_loader("show");
//                $(".modal-content").LoadingOverlay("show");
            },
            success: function (result) {
                show_loader("hide");
//                $(".modal-content").LoadingOverlay("hide");
                $("#product-variation-id").val(result);
            }
        });
    });
    $(document).on("click", 'div#product-modal .close',function (e) {
        $(".modal-body #line_item_special_note").val('');

    });
    $(document).on("click",'.add-to-invoice', function (e) {
        e.preventDefault();
        var orderId = $("#order_id").val();
        var quantity = $("#quantity").val();
        var not_sale = $("#not_sale:checked").val();
        var productId = $(".modal-body #product-variation-id").val();
        var line_item_special_note = $(".modal-body #line_item_special_note").val();
        var head_product = $(".modal-body .head_product").prop('checked');
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                action: 'add_product_to_order',
                product_id: productId,
                order_id: orderId,
                quantity: quantity,
                not_sale: not_sale,
                head_product: head_product,
                line_item_special_note: line_item_special_note
            },
            beforeSend: function () {
                show_loader("show");
//                $(".modal-content").LoadingOverlay("show");
            },
            success: function (result) {

                var res = JSON.parse(result);
                show_loader("hide");
//                $(".modal-content").LoadingOverlay("hide");
                $(".close").trigger("click");
                $(".head_product").prop('checked', false);
                $('#selected-products_head #product-list_head').append(res["head"]);
                $('#selected-products #product-list').append(res["other"]);
                $("#total-price #total-price-container").html(res["formatted_total"]);
                $("#selected_cat_sum").html(res["selected_cat_sum"]);
                $("#tax-price-container").html(res["tax_total"]);
                $("#no_tax-price-container").html(res["no_tax-price-container"]);
                $('#quantity').val(1);
                $(".modal-body #line_item_special_note").val('');
                $("#not_sale").attr('checked', false);
                var selectedData = new Array();
                if (res['heading'] == 'true') {
                    $('ul#product-list_head .sortingorder').each(function () {
                        selectedData.push($(this).attr("data-attribute-line-item-ids"));
                    });
                    newupdatesortOrder(selectedData, orderId, 'head');
                } else {
                    $('ul#product-list .sortingorder').each(function () {
                        selectedData.push($(this).attr("data-attribute-line-item-ids"));
                    });
                    newupdatesortOrder(selectedData, orderId);
                }
            }
        });
    });
    $(document).on("click",'.add-to-invoice-quick', function (e) {
        e.preventDefault();
        var orderId = $("#order_id").val();
        var quantity = 1;
        var productId = $(this).attr('data-product-id');
        var head_product = $(this).attr('data-head');
        /*       var head_product = false;*/

        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                action: 'add_product_to_order',
                product_id: productId,
                order_id: orderId,
                quantity: quantity,
                head_product: head_product
            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (result) {
                var res = JSON.parse(result);
                show_loader("hide");
//                $.LoadingOverlay("hide");
                $('#selected-products_head #product-list_head').append(res["head"]);
                $('#selected-products #product-list').append(res["other"]);
                $("#total-price #total-price-container").html(res["formatted_total"]);
                $("#total-price i.vat-tax").html("varav <span id='tax-price-container'><strong>" + res["tax_total"] + "</strong></span> kr moms");
                $("#total-price i.exkl-vat").html("varav <span id='no_tax-price-container'><strong>" + res["no_tax-price-container"] + "</strong></span> exkl. moms");
                $("#selected_cat_sum").html(res["selected_cat_sum"]);
                var selectedData = new Array();
                if (res['heading'] == 'true') {
                    $('ul#product-list_head .sortingorder').each(function () {
                        selectedData.push($(this).attr("data-attribute-line-item-ids"));
                    });
                    newupdatesortOrder(selectedData, orderId, 'head');
                } else {
                    $('ul#product-list .sortingorder').each(function () {
                        selectedData.push($(this).attr("data-attribute-line-item-ids"));
                    });
                    newupdatesortOrder(selectedData, orderId);
                }
            }
        });
    });
    function newupdatesortOrder(data, orderid, head = false) {
//alert(data+"  --  "+orderid);
        $.ajax({
            url: '/wp-content/plugins/imm-sale-system/ajax/sortorderitems.php',
            type: 'POST',
            data: {position: data, orderid: orderid, head, head},
            success: function (result) {

                //  alert(result);
            }
        })
    }
    $(document).on("click",'.remove-product', function (e) {
        e.preventDefault();
        var lineItemId = $(this).data("attribute-line-item-id");
        var orderId = $("#order_id").val();
        var thisEl = $(this);
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                action: 'remove_order_line_item_from_order',
                order_id: orderId,
                line_item_id: lineItemId
            },
            beforeSend: function () {
                show_loader("show");
            },
            success: function (result) {
                var res = JSON.parse(result);
                console.log(res);
                thisEl.closest('li').remove();
                $("#total-price-container").html(res[0]);
                $("#selected_cat_sum").html(res[1]);
                $("#tax-price-container").html(res[2]);
                $("#no_tax-price-container").html(res[3]);
                show_loader("hide");
                var selectedData = new Array();
                if (res['heading'] == '1') {
                    $('ul#product-list_head .sortingorder').each(function () {
                        selectedData.push($(this).attr("data-attribute-line-item-ids"));
                    });
                    newupdatesortOrder(selectedData, orderId, 'head');
                } else {
                    $('ul#product-list .sortingorder').each(function () {
                        selectedData.push($(this).attr("data-attribute-line-item-ids"));
                    });
                    newupdatesortOrder(selectedData, orderId);
                }
            }
        });
    });
    var delayTimer;
    $('input#imm-sale-search').on('input', function () {

        filter_and_return_products();
    });
    $('input#imm-sale-search-prepayment').on('input', function () {

        search_and_display_product_prepayment();
    });
    $("select[name='number-of-products']").on("change", function () {


        if ($('#get_products_related_to_head').prop("checked")) {
            filter_and_return_products_related();
        } else {
            filter_and_return_products();
        }



    });
    jQuery(document).on('click','input#vatremove', function () {
        var vatNumber = jQuery('input#vat_number').val();
        var checkVat = '';
        if (jQuery(this).is(':checked')) {
            var checkVat = 1;
        }
        jQuery.ajax({
            url: ajaxUrl,
            type: 'post',
            data: {
                action: 'removeVat',
                id: jQuery(this).val(),
                checkVat: checkVat,
                vatNumber: vatNumber
            },
            success: function (result) {
                location.reload();
            }
        });
    });
    $('#imm-sale-search-project_customer-register-table').on('input', function () {

        clearTimeout(delayTimer);
        delayTimer = setTimeout(function () {
            var search_input = $('#imm-sale-search-project_customer-register-table');
            var search_term = search_input.val();
            var dataAttributeTableName = search_input.attr('data-table_name');
            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    action: 'search_and_display_customers',
                    search_term: search_term,
                    table_name: dataAttributeTableName

                },
                beforeSend: function () {
                    show_loader("show");
//                    $(".table").LoadingOverlay("show");
                },
                success: function (results) {
                    show_loader("hide");
//                    $(".table").LoadingOverlay("hide");
                    $("#" + dataAttributeTableName).html(results);
                }
            });
        }, 500);
    });
    $('.imm-sale-search-lead').on('input', function () {
        clearTimeout(delayTimer);
        var dataAttributeTableName = $(this).attr('data-table_name');
        delayTimer = setTimeout(function () {
            var search_term = $('#imm-sale-search-lead_' + dataAttributeTableName).val();
            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    action: 'search_and_display_leads',
                    search_term: search_term,
                    table_name: dataAttributeTableName

                },
                beforeSend: function () {

//                    $(".table").LoadingOverlay("show");
                    show_loader("show");
                },
                success: function (results) {
                    show_loader("hide");
//                    $(".table").LoadingOverlay("hide");
                    $("#" + dataAttributeTableName).html(results);
                }
            });
        }, 500);
    });
    $('.filter_lead_tab').on('change', function () {
        clearTimeout(delayTimer);
        var dataAttributeTableName = $(this).attr('data-table_name');
        var from_date = $("#imm-sale-order-date_from_lead").val();
        var to_date = $("#imm-sale-order-date_to_lead").val();
        var lead_salesman = $("#user_kontakt_person").val();
        var lead_typavlead = $("#lead_typavlead").val();
        var data_role = $("#lead_typavlead").attr('data_role');
        delayTimer = setTimeout(function () {

            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    action: 'search_and_display_leads_filter',
                    from_date: from_date,
                    to_date: to_date,
                    lead_salesman: lead_salesman,
                    lead_typavlead: lead_typavlead,
                    table_name: dataAttributeTableName,
                    data_role: data_role

                },
                beforeSend: function () {
                    show_loader("show");
//                    $(".table").LoadingOverlay("show");
                },
                success: function (results) {
                    show_loader("hide");
//                    $(".table").LoadingOverlay("hide");
                    $("#" + dataAttributeTableName).html(results);
                }
            });
        }, 500);
    });
    /**
     * Sync order
     */
    $(document).on('click','.syncOrderToFortnox', function (event) {
        event.preventDefault();
        var orderId = $(this).data('order-id');
        var nonce = $(this).data('nonce');
        var status = $(this).siblings('.wetail-fortnox-status');
        status.hide();
        $('#fortnox-message').remove();
        console.log(orderId);
        $.ajax({
            url: 'wp-content/plugins/woocommerce-fortnox-integration/src/Fortnox/AJAX.php',
            data: {
                action: "fortnox_action",
                fortnox_action: "sync_order",
                order_id: orderId
            },
            type: "POST",
            dataType: "json"
            ,
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (response) {
//                $.LoadingOverlay("hide");
                show_loader("hide");
                //   console.log(response);

            }
        });
    });
    $(document).on("change","select#order-department_project-ongoing", function () {
        $('select#internal_project_status_user option:first').attr('selected', 'selected');
    });
    $(document).on("change","#todo-order-department_project-ongoing", function () {
        $('select#internal_project_status_user option:first').attr('selected', 'selected');
    });
    $(document).on("change",".filter_todo_tab", function () {
        clearTimeout(delayTimer);
        var todo_status = $("#order-by-todo-status").val();
        var number_of_posts = $("#number-of-todos").val();
        var from_date = $("#imm-sale-order-date_from").val();
        var to_date = $("#imm-sale-order-date_to").val();
        var mine_all = $("#todo-order-by-mine-or-all").val();
        var user_mottagare = $("#todo_assigned_user_mottagare").val();
        var department = $("#todo-order-department_project-ongoing").val();
        var role_status = $('#todo-today select#internal_project_status_user_todo option:selected').val();
        console.log(role_status);
        if (role_status != 'Alla') {
            var role_status = $("#todo-today select#internal_project_status_user_todo").val().split('#');
            var crntstatus = role_status[0];
            var roles = role_status[1];
        } else {
            var crntstatus = role_status;
            // var roles = role_status;
        }



        delayTimer = setTimeout(function () {
            filter_and_return_todos(todo_status, "todo-table", number_of_posts, from_date, to_date, mine_all, department, crntstatus, roles, user_mottagare);
        }, 500);
    });
    $(document).on('change',".filter_project_tab1", function (e) {
        e.preventDefault();
        clearTimeout(delayTimer);
        var dept = $('#imm-sale-search-project_all-table').attr('data-current_department');
        var dataAttributeTableName = $(this).attr('data-table_name');
        var current_department = $("#projects #order-department_project-ongoing").val();
        var project_wise = $("#projects #project_wise").val();
        var statusorder = $("#projects #order_statusid").val();
        var selectedOffice = $("#projects #order-by-office_project-ongoing").val();
        var mine_or_all = $("#projects #order-by-mine-or-all").val();
        var from_date = $("#projects .imm-sale-order-date_from").val();
        var to_date = $("#projects .imm-sale-order-date_to").val();
        var project_type = $("#projects #project_type").val();
//var selectedOffice = $("#projects #order-by-office_project-ongoing").val(); 	//
        var role_status = $('#projects select#internal_project_status_user').val();
        if (role_status != 'Alla') {
            4
            if ($('#projects select#internal_project_status_user').val()) {
                var dividerole = role_status.split('#');
                var internal_project_status = dividerole[0];
                var current_department = dividerole[1];
            }
        } else {
            if (current_department == 'alla') {
                current_department = '';
            }
            var internal_project_status = '';
        }



        current_status = '';
        roles = '';
        $(".imm-sale-search-project_ongoing").attr('data-current_department', current_department);
        var dataAttributeProjectStatus = $("#order-by-this-project-status_project-ongoing").val();
        var search_term = $('#projects #imm-sale-search-project_' + dataAttributeTableName).val();
        //  var search_order = $('#projects #imm-sale-search-order_' + dataAttributeTableName).val();
        var selectedCity = $("#projects #order-by-city_" + dataAttributeProjectStatus).val();
        var assign_project = $("#projects #assigned-technician-project").val();
        //var internal_project_status = $("#projects #internal_project_status_dropdown").val();
        var posts_per_page = $("#projects #number-of-posts_project-ongoing").val();
        //get_internal_project_status_dropdown(current_department);
        search_and_display_projects(search_term, dataAttributeTableName, current_department, dataAttributeProjectStatus, selectedCity, internal_project_status, selectedOffice, posts_per_page, mine_or_all, from_date, to_date, current_status, roles, project_type, statusorder, project_wise, assign_project);
    });
    $('.imm-sale-search-project').keyup(delay(function (e) {

        e.preventDefault();
        // $('.imm-sale-search-project').on('input', function (e) {
        //        
        //     clearTimeout(delayTimer);

        var dept = $('#imm-sale-search-project_all-table').attr('data-current_department');
        var dataAttributeTableName = $(this).attr('data-table_name');
        var current_department = $("#projects #order-department_project-ongoing").val();
        var project_wise = $("#projects #project_wise").val();
        var statusorder = $("#projects #order_statusid").val();
        var selectedOffice = $("#projects #order-by-office_project-ongoing").val();
        var mine_or_all = $("#projects #order-by-mine-or-all").val();
        var from_date = $("#projects .imm-sale-order-date_from").val();
        var to_date = $("#projects .imm-sale-order-date_to").val();
        var project_type = $("#projects #project_type").val();
        var role_status = $('#projects select#internal_project_status_user').val();
        if (role_status != 'Alla') {
            var dividerole = role_status.split('#');
            var internal_project_status = dividerole[0];
            var current_department = dividerole[1];
        } else {
            if (current_department == 'alla') {
                current_department = '';
            }
            var internal_project_status = '';
        }



        current_status = '';
        roles = '';
        $(".imm-sale-search-project_ongoing").attr('data-current_department', current_department);
        var dataAttributeProjectStatus = $("#order-by-this-project-status_project-ongoing").val();
        var search_term = $('#projects #imm-sale-search-project_' + dataAttributeTableName).val();
        var selectedCity = $("#projects #order-by-city_" + dataAttributeProjectStatus).val();
        var assign_project = $("#projects #assigned-technician-project").val();
        var posts_per_page = $("#projects #number-of-posts_project-ongoing").val();
        search_and_display_projects(search_term, dataAttributeTableName, current_department, dataAttributeProjectStatus, selectedCity, internal_project_status, selectedOffice, posts_per_page, mine_or_all, from_date, to_date, current_status, roles, project_type, statusorder, project_wise, assign_project);
    }, 500));
    $(document).on('click','.toggle-settings-modal', function (e) {
        e.preventDefault();
        var order_id = $(this).attr('href');
        //var order_id = $(this).attr('data-order-id');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'return_modal_content',
                order_id: order_id

            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (results) {
                show_loader("hide");
//                $.LoadingOverlay("hide");

                $("#settings-modal .setting-modal-body").html(results);
                $("#settings-modal").modal('show');
                $('.js-sortable-select').select2(
                        {
                            theme: "bootstrap",
                            width: '100%'
                        }
                );
            }
        });
    });
    $(document).on('click','.toggle-settings-project-modal', function (e) {
        e.preventDefault();
        var project_id = $(this).attr('href');
        //var project_id = $(this).attr('data-project-id');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'return_modal_project_content',
                project_id: project_id

            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (results) {
                show_loader("hide");
//                $.LoadingOverlay("hide");
                $(".setting-modal-project-body").html(results);
                $("#settings-modal-project").modal('show');
                $('.js-sortable-select').select2(
                        {
                            theme: "bootstrap",
                            width: '100%'
                        }
                );
            }
        });
    });
    $(document).on('click bind','.toggle-lead-modal', function (e) {
        e.preventDefault();
        var lead_id = $(this).attr('data-lead-id');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'return_lead_modal_content',
                lead_id: lead_id

            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (results) {
                show_loader("hide");
//                $.LoadingOverlay("hide");
                $(".lead-modal-body").html(results);
                $("#lead-modal").modal('show');
            }
        });
    });

    jQuery(document).on('click','a#removecomment', function () {
        var comment_id = jQuery(this).attr('data-comment-id');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'delete_comment_data',
                comment_id: comment_id

            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function () {
                location.reload();
            }
        });
    });

    jQuery(document).on('click','a#removecalender', function () {
        var calender_id = jQuery(this).attr('data-calender-id');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'delete_calender_data',
                calender_id: calender_id

            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function () {
                location.reload();
            }
        });
    });
    $(document).on('click bind','.toggle-calender-modal', function (e) {
        e.preventDefault();
        var calender_id = $(this).attr('data-calender-id');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'return_calender_modal_content',
                calender_id: calender_id

            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (results) {
//                alert(results);
                show_loader("hide");
//                $.LoadingOverlay("hide");
                $(".project-modal-body").html(results);
                $("#project-modal").modal('show');
            }
        });
    });
    $(document).on('click','.update_records', function (e) {
        e.preventDefault();
        var order_id = $(this).attr('data-order-id');
        var parent_orderid = $(this).attr('parent-order-id');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'updateinvoices',
                order_id: order_id,
                parent_orderid: parent_orderid

            },
            success: function (results) {

                if (results) {

                    $(this).html("<p class='accept'>Har skickats till Fortnox</p>");
//                    $.LoadingOverlay("hide");
                    show_loader("hide");
                } else {
                    alert("Något gick fel " + results);
                }

            }
        });
    });
    $(document).on('click','#send-to-fortnox', function (e) {
        e.preventDefault();
        var order_id = $(this).attr('data-order-id');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'sync_to_fortnox',
                order_id: order_id,
            },
            beforeSend: function (xhr) {
                var confirmation_of_sending;
                //
                confirmation_of_sending = confirm("Är du säker?");
                if (confirmation_of_sending == true) {
//                    $.LoadingOverlay("show");
                    show_loader("show");
                }
                /*else {
                 console.log(xhr);
                 xhr.abort();
                 }*/

            },
            success: function (results) {
                if (results == 'wrong') {
                    alert('Order ej synkad, försök gärna igen');
                    $(this).html("<p class='accept'>Har skickats till Fortnox</p>");
//                    $.LoadingOverlay("hide");
                    show_loader("hide");
                } else {
                    alert("Order synkad till Fortnox");
                    show_loader("hide");
//                    $.LoadingOverlay("hide");
                    // alert("Något gick fel " + results);

                }

            }
        });
    });
    $(document).on('click','.send-to-fortnox-prepayment1', function (e) {
        e.preventDefault();
        var order_id = $(this).attr('data-order-id');
        var parent_orderid = $(this).attr('parent-order-id');
        $.ajax({
            url: '/wp-content/plugins/imm-sale-system/ajax/synorders.php',
            type: 'POST',
            data: {
                action: 'sync_to_fortnox',
                order_id: order_id,
                parent_orderid: parent_orderid
            },
            beforeSend: function (xhr) {
                var confirmation_of_sending;
                confirmation_of_sending = confirm("Är du säker?");
                if (confirmation_of_sending == true) {
                    show_loader("show");
                }
            },
            success: function (results) {

                show_loader("hide");
                if (results != 'syn') {
                    alert('Order ej synkad, försök gärna igen');
                } else {
                    alert("Order synkad till Fortnox");
                }
            }

        });
    });
    $(document).on('click','.send-to-fortnox-prepayment', function (e) {
        e.preventDefault();
        var order_id = $(this).attr('data-order-id');
        var parent_orderid = $(this).attr('parent-order-id');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'sync_to_fortnox',
                order_id: order_id,
                parent_orderid: parent_orderid

            },
            beforeSend: function (xhr) {
                var confirmation_of_sending;
                //
                confirmation_of_sending = confirm("Är du säker?");
                if (confirmation_of_sending == true) {
//                    $.LoadingOverlay("show");
                    show_loader("show");
                }


            },
            success: function (results) {
                data = $.parseJSON(results);
                if (data.b == 'wrong') {
                    alert('Order ej synkad, försök gärna igen');
                } else {
                    alert("Order synkad till Fortnox");
                }
                show_loader("hide");
            }
        });
    });
    $(document).on('click','.load-more', function (e) {
        var _this = $(this);
        var type = _this.attr('data-type');
        var table_name = _this.attr('data-table');
        var page = _this.attr('data-page');
        var order_department = $(".imm-sale-search-project").attr('data-current_department');
        var project_status = _this.attr('data-project_status');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'return_more_objects',
                type: type,
                page: page,
                order_department: order_department,
                project_status: project_status

            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show"); 
            },
            success: function (results) {
                page++;
                _this.attr('data-page', page);
                $('#' + table_name).append(results);
                show_loader("hide");
//                $.LoadingOverlay("hide");

            }
        });
    });
    $(document).on('change','#web-orders-page', function (e) {
        var page = $(this).val();
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'paged_web_orders',
                page: page

            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (results) {
                $('#all-table-web-orders').html(results);
                show_loader("hide");
//                $.LoadingOverlay("hide");

            }
        });
    });
    $(document).on('click','.load-more-todos', function (e) {
        var _this = $(this);
        var table_name = _this.attr('data-table');
        var page = _this.attr('data-page');
        var user_role = _this.attr('data-user_role');
        var user_id = _this.attr('data-user_id');
        var type = _this.attr('data-type');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'return_more_todos',
                page: page,
                user_role: user_role,
                user_id: user_id,
                type: type

            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function (results) {
                page++;
                _this.attr('data-page', page);
                $('#' + table_name).append(results);
//                $.LoadingOverlay("hide");
                show_loader("hide");
            }
        });
    });
    $(document).on('click',".delete-lead", function (e) {
        e.preventDefault();
        var lead_id = $(this).attr('data-lead-id');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'delete_lead',
                lead_id: lead_id

            },
            beforeSend: function () {
                show_loader("show");
//                $.LoadingOverlay("show");
            },
            success: function () {
                location.reload();
            }
        });
    });
    $(document).on('click', "#delete-estimate",function (e) {
        e.preventDefault();
        var order_id = $(this).attr('data-order-id');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'delete_order',
                order_id: order_id

            },
            beforeSend: function () {
                return confirm("Är du säker?");
            },
            success: function () {
                location.reload();
            }
        });
    });
    $(document).on('click',"#delete-project-estimate", function (e) {
        e.preventDefault();
        var project_id = $(this).attr('data-project-id');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'delete_project_order',
                project_id: project_id

            },
            beforeSend: function () {
                return confirm("Är du säker?");
            },
            success: function () {
                location.reload();
            }
        });
    });
    $(document).on('click',"#send_invoice_to_customer", function (e) {
        e.preventDefault();
        var order_id = $(this).attr('data-order-id');
        var summary_url = $(this).attr('data-url');
        var print = $(this).attr('data-print');
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'send_invoice_to_customer',
                order_id: order_id,
                summary_url: summary_url,
                print: print

            },
            beforeSend: function (xhr) {
                var confirmation_of_sending;
                //
                confirmation_of_sending = confirm("Är du säker?");
                if (confirmation_of_sending == true) {
//                    $.LoadingOverlay("show");
                    show_loader("show");
                } else {
                    xhr.abort();
                }

            },
            success: function (results) {
                show_loader("hide");
//                $.LoadingOverlay("hide");
                alert(results);
            }
        });
    });
    function get_internal_project_status_dropdown(current_department) {

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'return_internal_project_status_dropdown',
                current_department: current_department
            },
            success: function (results) {

                var options = JSON.parse(results);
                var $el = $("#projects #internal_project_status_dropdown");
                $el.empty(); // remove old options
                $.each(options, function (key, value) {
                    if (value === "Alla") {
                        $el.append($("<option></option>")
                                .attr("value", "").text(value));
                    } else {
                        $el.append($("<option></option>")
                                .attr("value", value).text(value));
                    }

                });
            }
        });
    }

    function get_internal_project_status_dropdown_modal(current_department) {

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'return_internal_project_status_and_users_modal_dropdowns',
                current_department: current_department,
                all: false,
            },
            beforeSend: function () {
                show_loader("show");
//                $(".modal-body").LoadingOverlay("show");
            },
            success: function (results) {

                var options = JSON.parse(results);
                // console.log(options);

                var $el = $("#internal_project_status_dropdown_modal");
                $el.empty(); // remove old options
                $.each(options[0], function (key, value) {
                    if (value === "Alla") {
                        $el.append($("<option></option>")
                                .attr("value", "").text(value));
                    } else {
                        $el.append($("<option></option>")
                                .attr("value", value).text(value));
                    }

                });
                var $el_users = $(".modal #assigned-technician-select");
                $el_users.empty(); // remove old options

                $.each(options[1], function (key, value) {
                    //  console.log(key, value);
                    $el_users.append($("<option></option>")
                            .attr("value", value["user_id"]).text(value["user_display_name"]));
                });
//                $(".modal-body").LoadingOverlay("hide");
                show_loader("hide");
            }
        });
    }

//$(window).scroll(function() {    
//    var scroll = $(window).scrollTop();
//    if (scroll == 200 || scroll == 300) {
//        //clearHeader, not clearheader - caps H
//        $(".front-loader").addClass("darkHeader");
//    }else{
//         $(".front-loader").removeClass("darkHeader");
//    }
//});


    function modal_loader(display) {
        if (display == 'show') {
//            alert('yes1');
            $(".modal-loader").show();
        } else {
            $(".modal-loader").hide();
        }
        $(".modal-loader").html('<span>Laddar...</span><div class="modal_loading_overlay" style="background-color: rgba(255, 255, 255, 0.8);position: absolute;display: flex;flex-direction: column;align-items: center;justify-content: center;z-index: 9999;background-image: url(&quot;/wp-content/plugins/imm-sale-system/js/loading.gif&quot;);background-position: right;background-repeat: no-repeat;top: 0px;left: 0px;width: 100%;height: 100%;background-size: 50px;"></div>');
    }

    function show_loader(display) {
        if (display == 'show') {
            $(".front-loader").show();
        } else {
            $(".front-loader").hide();
        }
        $(".front-loader").html('<div class="loading_overlay" style="background-color: rgba(255, 255, 255, 0.8);/* position: absolute; */ display: block; /* flex-direction: column; *//* align-items: center; *//* justify-content: center; */z-index: 9999;background-image: url(&quot;/wp-content/plugins/imm-sale-system/js/loading.gif&quot;);background-position: center center;background-repeat: no-repeat;top: 0px;left: 0px;width: 100%;height: 100%;background-size: 100px;"></div><span>Laddar...</span>');
    }

    function search_and_display_projects(search_term, dataAttributeTableName, current_department, dataAttributeProjectStatus, selectedCity, internal_project_status, selectedOffice, posts_per_page, mine_or_all, from_date, to_date, current_status, roles, project_type, statusorder, project_wise, assign_project) {


        $.ajax({
//url: ajaxUrl,
            url: '/wp-content/plugins/imm-sale-system/sampleajax.php',
            type: 'POST',
            data: {
                action: 'search_and_display_projects',
                search_term: search_term,
                search_product: $('.search_product').val(),
                statusorder: statusorder,
                table_name: dataAttributeTableName,
                current_department: current_department,
                project_status: dataAttributeProjectStatus,
                billing_city: selectedCity,
                internal_project_status: internal_project_status,
                selected_office: selectedOffice,
                posts_per_page: posts_per_page,
                mine_or_all: mine_or_all,
                from_date: from_date,
                to_date: to_date,
                assign_project: assign_project,
                current_status: current_status,
                roles: roles,
                project_type: project_type,
                project_wise: project_wise

            },
            async: false,
            beforeSend: function () {
                // $.LoadingOverlay("show");
                show_loader("show");
            },
            success: function (result) { //$("#" + dataAttributeTableName).empty();
                //$("#" + dataAttributeTableName).append(result);
                //console.log(result);

                show_loader("hide");
                $("#" + dataAttributeTableName).empty();
                if (result == '1') {

                    $("#" + dataAttributeTableName).append('<tr><td>Inga resultat hittades</td></tr>');
                } else {

                    var data = $.parseJSON(result);
                    $.each($(data), function (i, ob) {
                        var project_id = ob["id"];
                        var prjnumber = ob["custom_project_number"];
                        var time = ob["time"];
                        var statuss = ob["status"];
                        var prjstatus = ob["project_status"];
                        var custname = ob["custname"];
                        var store = (ob["store"]) ? ob["store"] : "";
                        var salesman = ob["salesman"];
                        var total = ob["total"];
                        var internal = (ob["internal_status"] != 'Alla') ? ob["internal_status"] : "";
                        var orderacc = (ob["orderaccpet"]) ? ob["orderaccpet"] : "Väntar svar";
                        var prjtype = (ob["project_types"]) ? ob["project_types"] : "";
                        var main_product = (ob['main_product']) ? ob['main_product'] : '';
                        var current_user_role = ob["current_user_role"];
                        if (current_user_role == 'sale-sub-contractor') {
                            $("#" + dataAttributeTableName).append('<tr class="clickable"><td>' + ob['i'] + '</td><td class="custmnewtab" nowrap><a target="_new" href="/project?pid=' + project_id + '">' + prjnumber + '</a></td><td>' + time + '</td><td>' + statuss + '</td><td>' + prjstatus + '</td><td>' + store + '</td><td><a href="/project?pid=' + project_id + '">' + custname + '</td><td>' + salesman + '</td><td>' + internal + '</td><td>' + orderacc + '</td><td>' + prjtype + '</td></tr>');
                        } else {
                            $("#" + dataAttributeTableName).append('<tr class="clickable"><td>' + ob['i'] + '</td><td class="custmnewtab" nowrap><a target="_new" href="/project?pid=' + project_id + '">' + prjnumber + '</a></td><td>' + time + '</td><td>' + statuss + '</td><td>' + prjstatus + '</td><td>' + store + '</td><td>' + main_product + '</td><td><a href="/project?pid=' + project_id + '">' + custname + '</td><td>' + salesman + '</td><td>' + total + '</td><td>' + internal + '</td><td>' + orderacc + '</td><td>' + prjtype + '</td></tr>');
                        }
                    });
                }
            }
        });
    }

    function filter_and_return_todos(todo_status, table_name, number_of_posts, from_date, to_date, mine_all, department, crntstatus, roles, user_mottagare) {

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'filter_and_return_todos',
                number_of_posts: number_of_posts,
                todo_status: todo_status,
                from_date: from_date,
                to_date: to_date,
                mine_all: mine_all,
                department: department,
                crntstatus: crntstatus,
                user_mottagare: user_mottagare,
                roles: roles

            },
            beforeSend: function () {
//                $.LoadingOverlay("show");
//alert('yes');
                show_loader("show");
            },
            success: function (results) {
//                $.LoadingOverlay("hide");
                show_loader("hide");
                $("#" + table_name).html(results);
            }
        });
    }


    $('.sort_by_select').on('change', function () {


        if ($('#get_products_related_to_head').prop("checked")) {
            filter_and_return_products_related();
        } else {
            filter_and_return_products(); //round
        }
    })


    $('.order_product_grid').on('click', function () {
        $('#grid_or_list').val('1');
        $('.order_product_grid').css('color', '#ff5912');
        $('.order_product_list').css('color', '#453925');
        if ($('#get_products_related_to_head').prop("checked")) {
            filter_and_return_products_related();
        } else {
            filter_and_return_products(); //round
        }
    })

    $('.order_product_list').on('click', function () {
        $('#grid_or_list').val('0');
        $('.order_product_list').css('color', '#ff5912');
        $('.order_product_grid').css('color', '#453925');
        if ($('#get_products_related_to_head').prop("checked")) {
            filter_and_return_products_related();
        } else {
            filter_and_return_products(); //round
        }
    })

    if (document.getElementById('buttonnotshow')) {
        filter_and_return_products();

    }
    function filter_and_return_products() {
        var search_term = $('#imm-sale-search').val();
        if (search_term.length <= 2 && search_term.length != 0) {
            return false;
        }
        var catid = $('#prod_id').val();
        var buttonnotshow = $('#buttonnotshow').val();

        var grid_or_list = $('#grid_or_list').val();
        var sort_by_select = $('.sort_by_select option:selected').val();
        var step_no = $('#step_no').val();

        var brand_id = $('#brand_id').val();
        var number_of_posts = $("#number-of-products").val();
        $.ajax({
            url: '/wp-content/plugins/imm-sale-system/productSearch.php',
            type: 'POST',
            data: {
                search_term: search_term,
                catid: catid,
                number_of_posts: number_of_posts,
                step_no: step_no,
                sort_by_select: sort_by_select,
                brand_id: brand_id

            }, beforeSend: function () {
                jqueryshow_loader("show");
            },
            success: function (result) {
                var count = 0;
                $("#getProductList,#gridviewproducts").empty();
                if (result == '1') {

                    $("#getProductList").append('<tr><td>Inga resultat hittades</td></tr>');
                } else {



                    var data = $.parseJSON(result);
                    $.each($(data), function (i, ob) {
                        var productid = ob["id"];
                        var title = ob["title"];
                        var imageid = ob["image"];
                        var InMom = ob["InMom"];
                        var ExMom = ob["ExMom"];
                        var sale_price = ob["sale_price"];
                        var more_button = ob['more_button'];
                        var brand = '<td>' + ob['brand'] + '</td>';
                        var jsonObj = ob['more_button'];
                        var product_desc = ob['product_desc'];
                        var product_short_desc = ob['product_short_desc'];

                        var str = '';
                        var result1 = $.parseJSON(jsonObj);
                        $.each(result1, function (k, v) {
                            str += k + " = '" + v + "'";
                        });
                        if (ob["checksale"]) {
                            var checksk = '<td id="checksaleon">' + ob["checksale"] + '</td>';
                            var dataOrder = true;
                            var salepricevalue = ob["checksale"];
                            $('#checksaleon').show();

                        } else {
                            var checksk = '<td id="checksaleon"></td>';
                            var dataOrder = false;
                            $('#checksaleon').hide();
                        }
                        if (grid_or_list == 0) {
                            $('.hideclass').show();
                            if (buttonnotshow != '0') {
                                if (step_no === '0') {
                                    var headAdd = true;
                                } else {
                                    var headAdd = false;
                                }

                                var showbuton = '<td><button type="button" data-title="' + title + '" data-toggle="modal" data-target="#product-modal" data-order-price="' + dataOrder + '" class="btn btn-alpha btn-block top-buffer-half toggle-product-modal" ' + str + '>Mer info</button></td><td><button type="button" data-product-id="' + productid + '" class="btn btn-brand btn-block top-buffer-half add-to-invoice-quick " data-head="' + headAdd + '" id="">Lägg till</button></td>';
                            } else {
                                var sku = ob['sku'];
                                var sku = '<td>' + sku + '</td>';

                            }
                            $("#getProductList").append('<tr><td><img  src="' + imageid + '"  style="width: 40px;height: 40px;"></td>' + sku + '<td>' + title + '</td>' + brand + '<td>' + ExMom + '</td><td>' + InMom + '</td>' + checksk + showbuton + '</tr>');
                        } else {
                            $('.hideclass').hide();
                            if (step_no === '0') {
                                var headAdd = true;
                            } else {
                                var headAdd = false;
                            }
                            $("#gridviewproducts").append('<div class="col-md-6 col-sm-12" style="height:570px"><div class="panel panel-default"><div class="panel-body"><img class="img-responsive img-product" src="' + imageid + '" alt=""></div><div class="panel-footer"><p style="text-align: center;"><strong>' + title + '</strong></p><span><strong style="text-align: center;"><p class="" id="" style="padding-left: 5px;padding-right: 5px;">' + ExMom + ' exkl moms</p><p class="" id="" style="padding-left: 5px;padding-right: 5px;">' + InMom + ' inkl moms</p></strong></span><ul class="list-inline text-center"><li><button type="button" data-toggle="modal" data-target="#product-modal" class="btn btn-alpha btn-block top-buffer-half toggle-product-modal" id="" ' + str + '>Mer info</button></li><li><button type="button" data-product-id="' + productid + '"data-head="' + headAdd + '" class="btn btn-brand btn-block top-buffer-half add-to-invoice-quick " id="">Lägg till</button></li></ul></div></div></div>');
                        }
                    });
                }
                jqueryshow_loader("hide");
            }

        });
    }


    $('.editPrepaymentOrder').on('click', function () {
        var orderId = $(this).attr('data-orderId');
        $('#prepaymentOrderId').val(orderId)

    });
    function search_and_display_product_prepayment() {

        var search_term = $('#imm-sale-search-prepayment').val();
        clearTimeout(delayTimer);
        delayTimer = setTimeout(function () {

            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    action: 'search_and_display_product_prepayment',
                    search_term: search_term,
                },
                beforeSend: function () {

                    /*$("#product_display").*/
                    //   $.LoadingOverlay("show");
                    show_loader("show");
                },
                success: function (results) {
                    /* $("#product_display").*/
                    //  $.LoadingOverlay("hide");
                    show_loader("hide");
                    $("#product_display").html('<table class="table"><tbody>' + results + '</tbody></table>');
                }
            });
        }, 500);
    }

    $(document).on('click','a.laggtillPrepaymentProduct', function (e) {
        e.preventDefault();
        var pid = $(this).attr('data-pid');
        var quantityPrepayment = $(this).closest('tr').find('.quantityPrepayment').val();
        var orderid = $('#prepaymentOrderId').val();
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'addProductToPrepaymentOrder',
                pid: pid,
                quantityPrepayment: quantityPrepayment,
                orderid: orderid


            },
            beforeSend: function () {

                /*$("#product_display").*/
                //$.LoadingOverlay("show");
                show_loader("show");
            },
            success: function (results) {
                /* $("#product_display").*/
                //    $.LoadingOverlay("hide");
                //  console.log(results);
                show_loader("hide");
            }
        });
    });
    function filter_and_return_products_related() {

        var search_term = $('#imm-sale-search').val();
        if (search_term.length <= 2 && search_term.length != 0) {
            return false;
        }
        var head_products = [];
        var only_related = $("#get_products_related_to_head").is(':checked');
        var grid_or_list = $('#grid_or_list').val();
        var sort_by_select = $('.sort_by_select option:selected').val();
        if (only_related === true) {
            $('#selected-products_head li').each(function () {
                head_products.push($(this).attr('data-product_id'));
            });
        }

        var buttonnotshow = $("#buttonnotshow").val();

        var sort_by_select = $('.sort_by_select option:selected').val();
        var brand_id = $('#brand_id').val();
        var number_of_posts = $("#number-of-products").val();
//        var search_term = $('#imm-sale-search').val();
        var catid = $('#prod_id').val();
        var number_of_posts = $("#number-of-products").val();
        var step_no = $('#step_no').val();
        clearTimeout(delayTimer);
        delayTimer = setTimeout(function () {

            $.ajax({
                url: '/wp-content/plugins/imm-sale-system/productSearch.php',
                type: 'POST',
                data: {
                    // action: 'search_and_display_product_related',
                    search_term: search_term,
                    catid: catid,
                    head_products: head_products,
                    brand_id: brand_id,
                    number_of_posts: number_of_posts,
                    grid_or_list: grid_or_list,
                    sort_by_select: sort_by_select,
                    step_no: step_no,
                    only_related: only_related
                }, beforeSend: function () {
                    jqueryshow_loader("show");
                },
                success: function (result) {

                    $("#getProductList,#gridviewproducts").empty();
                    if (result == '1') {

                        $("#getProductList").append('<tr><td>Inga resultat hittades</td></tr>');
                    } else {



                        var data = $.parseJSON(result);
                        $.each($(data), function (i, ob) {
                            var productid = ob["id"];
                            var title = ob["title"];
                            var imageid = ob["image"];
                            var InMom = ob["InMom"];
                            var ExMom = ob["ExMom"];
                            var sale_price = ob["sale_price"];
                            var more_button = ob['more_button'];

                            var jsonObj = ob['more_button'];
                            var str = '';
                            var result1 = $.parseJSON(jsonObj);
                            $.each(result1, function (k, v) {
                                str += k + " = '" + v + "'";
                            });

                            if (ob["checksale"]) {
                                var checksk = '<td id="checksaleon">' + ob["checksale"] + '</td>';
                                var dataOrder = true;

                            } else {
                                var checksk = '<td id="checksaleon"></td>';
                                var dataOrder = false;
                            }
                            if (grid_or_list == 0) {
                                $('.hideclass').show();
                                if (buttonnotshow != '0') {
                                    if (step_no === '0') {

                                        var headAdd = true;
                                    } else {
                                        var headAdd = false;
                                    }


                                    var showbuton = '<td><button type="button" data-toggle="modal" data-title="' + title + '" data-target="#product-modal" data-order-price="' + dataOrder + '" class="btn btn-alpha btn-block top-buffer-half toggle-product-modal" ' + str + '>Mer info</button></td><td><button type="button" data-product-id="' + productid + '" class="btn btn-brand btn-block top-buffer-half add-to-invoice-quick " data-head="' + headAdd + '" id="">Lägg till</button></td>';
                                } else {
                                    var sku = ob['sku'];
                                    var sku = '<td>' + sku + '</td>';
                                }
                                $("#getProductList").append('<tr><td><img  src="' + imageid + '"  style="width: 40px;height: 40px;"></td>' + sku + '<td>' + title + '</td><td>' + ExMom + '</td><td>' + InMom + '</td>' + checksk + showbuton + '</tr>');
                            } else {
                                $('.hideclass').hide();
                                if (step_no === '0') {
                                    var headAdd = true;
                                } else {
                                    var headAdd = false;
                                }
                                $("#gridviewproducts").append('<div class="col-md-6 col-sm-12" style="height:570px"><div class="panel panel-default"><div class="panel-body"><img class="img-responsive img-product" src="' + imageid + '" alt=""></div><div class="panel-footer"><p style="text-align: center;"><strong>' + title + '</strong></p><span><strong style="text-align: center;"><p class="" id="" style="padding-left: 5px;padding-right: 5px;">' + ExMom + ' exkl moms</p><p class="" id="" style="padding-left: 5px;padding-right: 5px;">' + InMom + ' inkl moms</p></strong></span><ul class="list-inline text-center"><li><button type="button" data-toggle="modal" data-target="#product-modal" class="btn btn-alpha btn-block top-buffer-half toggle-product-modal" id="" ' + str + '>Mer info</button></li><li><button type="button" data-product-id="' + productid + '"data-head="' + headAdd + '" class="btn btn-brand btn-block top-buffer-half add-to-invoice-quick " id="">Lägg till</button></li></ul></div></div></div>');
                            }
                        });
                    }
                    jqueryshow_loader("hide");
                }
            });
        }, 500);
    }


});