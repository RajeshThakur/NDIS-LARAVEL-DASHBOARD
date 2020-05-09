window.ndis = window.ndis || {};

var dateEl;

//DM Dropdown
(function($) {
    $.fn.dmDrop = function(options) {
        var defaults = {
            selectedIndex: 0,
            defaultText: "- Please Select -",
            placeholderClass: "placehold",
            defaultValue: null
        };
        var settings = $.extend({}, defaults, options);

        if (this.length > 1) {
            this.each(function() {
                $(this).dmDrop(options);
            });
            return this;
        }

        var triggerOpen = function(ev) {
            ev.preventDefault();
            ev.stopPropagation();
            $(this).toggleClass("active");
        };

        var selectOption = function(ev) {
            ev.preventDefault();
            ev.stopPropagation();
            var opt = $(this);

            var dropEl = opt.parent().parent();

            opt.siblings().removeClass("selected");
            opt.addClass("selected");
            dropEl.find(".placehold").html(opt.html());
            settings.defaultValue = opt.find("a").attr("data-val");
            settings.selectedIndex = opt.index;
            jQuery("#" + opt.parent().attr("data-target")).val(
                settings.defaultValue
            );
            dropEl.toggleClass("active");
        };

        // public methods
        this.initialize = function() {
            jQuery(this).on("click", triggerOpen);
            jQuery(this)
                .find("li")
                .on("click", selectOption);
            return this;
        };

        this.getIndex = function() {
            return settings.selectedIndex;
        };

        this.getValue = function() {
            return settings.defaultValue;
        };

        return this.initialize();
    };
})(jQuery);

function clearDatePicker() {
    // console.log("clearDatePicker called");
    $(".datefield").datetimepicker("destroy");
    $(".datetime").datetimepicker("destroy");
    $(".timepicker").datetimepicker("destroy");
}

function addLocationListner() {
    if (typeof google === "undefined") return;

    var locationInputs = document.getElementsByClassName("location");
    for (var i = 0; i < locationInputs.length; i++) {
        var autoCompletePlaces = new google.maps.places.Autocomplete(
            locationInputs[i]
        );
        // Set initial restrict to the greater list of countries.
        autoCompletePlaces.setComponentRestrictions({ country: ["au"] });
        google.maps.event.addListener(
            autoCompletePlaces,
            "place_changed",
            function() {
                // console.log(this);
                var place = autoCompletePlaces.getPlace();
                if (!place.geometry) {
                    jQuery("input#lng").val("");
                    jQuery("input#lat").val("");
                    window.alert(
                        "No details available for input: '" + place.name + "'"
                    );
                    return;
                }
                var address = "";
                if (place.address_components) {
                    address = [
                        (place.address_components[0] &&
                            place.address_components[0].short_name) ||
                            "",
                        (place.address_components[1] &&
                            place.address_components[1].short_name) ||
                            "",
                        (place.address_components[2] &&
                            place.address_components[2].short_name) ||
                            ""
                    ].join(" ");
                }

                if (place.geometry && place.geometry.location) {
                    jQuery("input#lng").val(place.geometry.location.lng());
                    jQuery("input#lat").val(place.geometry.location.lat());
                }
            }
        );
    }
}


//------------------------------------------------------------------------------------------
// NDIS Functions
//------------------------------------------------------------------------------------------

ndis.error = msg => {
    var html = '<div class="alert bg-danger alert-danger alert-dismissible">';
    html +=
        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
    html += '<p><i class="icon fa fa-ban"></i> ' + msg + "</p>";
    html += "</div>";
    return html;
};
ndis.message = msg => {
    var html = '<div class="alert bg-info alert-info alert-dismissible">';
    html +=
        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
    html += '<p><i class="icon fa fa-info"></i> ' + msg + "</p>";
    html += "</div>";
    return html;
};
ndis.success = msg => {
    var html = '<div class="alert bg-success alert-success alert-dismissible">';
    html +=
        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
    html += '<p><i class="icon fa fa-check"></i> ' + msg + "</p>";
    html += "</div>";
    return html;
};

ndis.iniHideError = () => {
    //Autohide after 2 seconds
    // $("#display-msg").delay(2000).fadeOut('slow');
};

ndis.displayMsg = (type = "message", msg) => {
    if (jQuery("#display-msg").length) {
        switch (type) {
            case "error":
                jQuery("#display-msg").html(ndis.error(msg));
                break;
            case "success":
                jQuery("#display-msg").html(ndis.success(msg));
                break;
            default:
                jQuery("#display-msg").html(ndis.message(msg));
                break;
        }
        jQuery("#display-msg").show();

        $("html, body").animate(
            { scrollTop: $("#display-msg").offset().top - 120 },
            400
        );

        ndis.iniHideError();
    } else {
        alert(msg);
    }
};

ndis.onPopupOpen = modal => {
    document.querySelector("body").classList.add(modal.id);
};
ndis.onPopupClose = modal => {
    document.querySelector("body").classList.remove(modal.id);
};

ndis.popup = (
    modalId,
    onModalOpen = ndis.onPopupOpen,
    onModalClose = ndis.onPopupClose
) => {
    MicroModal.show(modalId, {
        debugMode: true,
        disableScroll: true,
        onShow: onModalOpen,
        onClose: onModalClose,
        closeTrigger: "data-custom-close",
        awaitCloseAnimation: true
    });
};

ndis.closePopup = modalId => {
    if (jQuery("#" + modalId).length) MicroModal.close(modalId);
};

ndis.redirect = url => {
    window.location.replace(url);
};

ndis.isVoidEl = el => {
    var tags = [
            "area",
            "base",
            "br",
            "col",
            "command",
            "embed",
            "hr",
            "img",
            "input",
            "select",
            "keygen",
            "link",
            "meta",
            "param",
            "source",
            "track",
            "wbr"
        ],
        i = 0,
        l,
        name;
    if (el instanceof jQuery) {
        el = el[0];
    }
    name = el.nodeName.toLowerCase();
    for (i = 0, l = tags.length; i < l; i += 1) {
        if (tags[i] === name) {
            return true;
        }
    }
    return false;
};

/**
 * Adds loader to the element
 * @argument el jQuery object of element
 */
ndis.addLoader = el => {
    return;
    if (ndis.isVoidEl(el)) el = el.parent();

    // console.log("el", el);

    if (el.find(".loader").length < 1)
        el.append(
            '<i class="fa inputicon fa-circle-o-notch loader" aria-hidden="true"></i>'
        );
};

ndis.removeLoader = el => {
    return;
    if (ndis.isVoidEl(el)) el = el.parent();

    el.find(".loader").remove();
};

ndis.bigLoader = (text = "Loading..") => {
    if (jQuery("#ndisloader-container").length < 1) {
        jQuery("body").append(
            '<div class="ndisloader-container" id="ndisloader-container"><div class="lds-facebook"><div></div><div></div><div></div></div></div>'
        );
    }
};

ndis.removeBigLoader = () => {
    if (jQuery("#ndisloader-container").length > 0)
        setTimeout(() => {
            jQuery("#ndisloader-container").remove();
        }, 500);
};

ndis.addButtonLoader = el => {
    ndis.addLoader(el);
    jQuery(el).attr("disabled", "disabled");
};
ndis.removeButtonLoader = el => {
    ndis.removeLoader(el);
    jQuery(el).removeAttr("disabled");
};

ndis.defaultAjaxSuccess = data => {
    console.log("ajaxRes", data);
};

//Default AJAX Loader
$(document).ajaxStart(function() {
    ndis.bigLoader();
});
$(document).ajaxComplete(function() {
    ndis.removeBigLoader();
});
$(document).ajaxError(function() {
    ndis.removeBigLoader();
});

ndis.defaultAjaxFailure = (jqXHR, textStatus) => {
    ndis.removeBigLoader();
    var msg = "";
    if (jqXHR.responseJSON !== undefined) {
        msg += jqXHR.responseJSON.message;
        if (jqXHR.responseJSON.errors !== undefined) {
            if (typeof jqXHR.responseJSON.errors === "object") {
                Object.keys(jqXHR.responseJSON.errors).map(function(
                    key,
                    index
                ) {
                    msg +=
                        "<br/> <i class='fa fa-long-arrow-right' aria-hidden='true'></i> " +
                        jqXHR.responseJSON.errors[key][0];
                });
            }
            if (typeof jqXHR.responseJSON.errors === "array") {
                jqXHR.responseJSON.errors.map(function(err, index) {
                    msg +=
                        "<br/> <i class='fa fa-long-arrow-right' aria-hidden='true'></i> " +
                        jqXHR.responseJSON.errors[key][0];
                });
            }
        }
    }
    ndis.displayMsg("error", msg);
};

ndis.ajax = (
    postURL,
    method = "POST",
    formData,
    onSuccess = ndis.defaultAjaxSuccess,
    onFailure = ndis.defaultAjaxFailure
) => {
    var request = jQuery.ajax({
        url: postURL,
        type: method,
        data: formData,
        dataType: "json",
        async: false,
        headers: {
            "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr("content")
        }
    });
    request.done(onSuccess);
    request.fail(onFailure);
    request.always(ndis.defaultAlways);
    return request;
};

ndis.calSetDateAttr = () => {
    $(".datefield,.datetime,.timepicker").each(function(index) {
        $(this).attr("data-date", $(this).val());
    });
};

ndis.calDefaultDate = () => {
    $(".datefield,.datetime,.timepicker").each(function(index) {
        $(this).val($(this).attr("data-date"));
    });
};

ndis.initializeCal = () => {
    moment.updateLocale("en", {
        week: { dow: 1 } // Monday is the first day of the week
    });

    ndis.calSetDateAttr();

    clearDatePicker();

    $(".datefield").datetimepicker({
        format: "DD-MM-YYYY",
        locale: "en",
        // minDate:new Date(),
        disabledDates: calDisabledDates,
        daysOfWeekDisabled: calDaysOfWeekDisabled
    });

    $(".datetime").datetimepicker({
        format: "YYYY-MM-DD HH:mm:ss",
        locale: "en",
        disabledDates: calDisabledDates,
        daysOfWeekDisabled: calDaysOfWeekDisabled,
        // minDate:new Date(),
        sideBySide: true
    });

    $(".timepicker").datetimepicker({
        format: "LT",
        stepping: 15
    });

    ndis.calDefaultDate();
};

ndis.defaultAlways = () => {
    // console.log("defaultAlways called!");

    $(".select2").select2({
        closeOnSelect: false
    });

    //Initialize the Calendar
    ndis.initializeCal();

    // Date range picker
    // $('.daterange').daterangepicker()

    // Date range picker with time picker
    $(".datetimerange").daterangepicker({
        timePicker: true,
        timePickerIncrement: 15,
        locale: {
            format: "MM/DD/YYYY hh:mm A"
        }
    });

    $(".timerange")
        .daterangepicker({
            timePicker: true,
            timePickerIncrement: 15,
            timePicker24Hour: true,
            timePickerSeconds: false,
            locale: {
                format: "HH:mm"
            }
        })
        .on("show.daterangepicker", function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        });

    //Initialize the Toaster
    $(".toast").toast({
        animation: true,
        autohide: false,
        delay: 500
    });

    addLocationListner();

    // $("form.validated").validate();

    $("form.validated").validate({
        onclick: function(i, e) {
            $(i)
                .siblings("span")
                .removeClass("error");
            $(i).removeClass("error");
        },
        errorPlacement: function(error, element) {
            if (element[0].localName == "select") {
                error.appendTo(element.parent());
                element.siblings("span").addClass("error");
            } else {
                error.insertAfter(element);
            }
        }
    });

    
    //reset the lng,lat value

    $( ".location" ).keyup(function() {
        $(this).siblings( "input#lng,input#lat" ).val('');
    });
    

    ndis.iniHideError();
};

ndis.getToast = (toastId, title, desc, ico = null, time = null) => {
    var template = ndis.template("toast");
    var html = template({
        id: toastId,
        title: title,
        content: desc,
        time: time,
        icon: ico
    });
    return html;
};

ndis.showToast = (
    title,
    desc,
    time = null,
    ico = '<i class="fa fa-flag-o" aria-hidden="true"></i>'
) => {
    var toastId = "toast_" + $(".toast").length;
    var toast = ndis.getToast(toastId, title, desc, ico, time);
    jQuery("#toast-container").append(toast);

    $("#" + toastId).toast({
        animation: true,
        autohide: false,
        delay: 500
    });
    $("#" + toastId).toast("show");
};

ndis.isEmpty = str => {
    return str != "" && str != "0" ? false : true;
};

ndis.isValidDate = strDate => {
    var date = moment(strDate);
    return date.isValid();
};

// End of NDIS Functions
//------------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------------
// Misc Function on page load

$.validator.methods.email = function(value, element) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return this.optional(element) || re.test(value);
};

var session_checker = function() {
    ndis.ajax(
        "/session/check",
        "GET",
        {},
        function(data) {
            if (!data.status) {
                ndis.displayMsg("error", data.message);
                setTimeout(function() {
                    ndis.redirect(data.redirect);
                }, 1500);
            }
        },
        function(jqXHR, textStatus) {}
    );
};

var interval = 1000 * 60 * 0.1;
// setInterval(session_checker, interval);

// Google Maps Places API
if (typeof google !== "undefined")
    google.maps.event.addDomListener(window, "load", addLocationListner);

//------------------------------------------------------------------------------------------
// On Doument ready

$(document).ready(function() {
    window._token = $('meta[name="csrf-token"]').attr("content");

    if (typeof ClassicEditor !== "undefined")
        ClassicEditor.create(document.querySelector(".ckeditor"));

    ndis.defaultAlways();

    $(".select-all").click(function() {
        let $select2 = $(this)
            .parent()
            .siblings(".select2");
        $select2.find("option").prop("selected", "selected");
        $select2.trigger("change");
    });
    $(".deselect-all").click(function() {
        let $select2 = $(this)
            .parent()
            .siblings(".select2");
        $select2.find("option").prop("selected", "");
        $select2.trigger("change");
    });

    $(".treeview").each(function() {
        var shouldExpand = false;
        $(this)
            .find("li")
            .each(function() {
                if ($(this).hasClass("active")) {
                    shouldExpand = true;
                }
            });
        if (shouldExpand) {
            $(this).addClass("active");
        }
    });

    // Custom file Input Selection Handle
    // get the name of uploaded file
    $("input.filecontrol").change(function() {
        var value = $(this).val();
        $(this)
            .parent()
            .find(".filupp-file-name")
            .text(value);
    });

    ndis.template = _.memoize(function(id) {
        var compiled,
            /*
             * Underscore's default ERB-style templates are incompatible with PHP
             * when asp_tags is enabled, so WordPress uses Mustache-inspired templating syntax.
             *
             * @see trac ticket #22344.
             */
            options = {
                evaluate: /<#([\s\S]+?)#>/g,
                // interpolate: /\{\{\{\{([\s\S]+?)\}\}\}\}/g,
                // escape:      /\{\{\{([^\}]+?)\}\}(?!\}\})/g,
                variable: "data"
            };

        return function(data) {
            compiled =
                compiled || _.template(jQuery("#tmpl-" + id).html(), options);
            return compiled(data);
        };
    });

    // jQuery("#add_more_regrp").trigger('click');

    // ---------------------- Initalize Custom Select -------------------------

    // create new variable for each menu
    // var dd1 = new DropDown($('.dm-drop'));

    jQuery(".dm-drop").dmDrop();

    $(document).click(function() {
        // close menu on document click
        $(".dm-drop").removeClass("active");
    });

    // Trigget Click in the Input Field if any Icon attached with Input field is clicked
    jQuery(".input-group i.inputicon").on("click", function(ev) {
        jQuery(this)
            .parent()
            .find("input", "select")
            .trigger("click");
        jQuery(this)
            .parent()
            .find("input")
            .focus();
    });

    // // Trigget Click in the Input Field if any Icon attached with Input field is clicked
    // jQuery('body').on('click', function(ev){
    //   console.log(typeof ev.target.classList)
    //   // if( ( ev.target.classList.indexOf("datefield") == -1 ) && (ev.target.classList.indexOf("datetime") != -1) && (ev.target.classList.indexOf("timepicker") != -1) )
    //     // $('.datefield,.datetime,.timepicker').datetimepicker('hide');
    // });

    jQuery("body").on(
        "focus",
        ".datefield, .datetime, .timepicker",
        function() {
            $(this).datetimepicker("show");
        }
    );

    jQuery("body").on("blur", ".datefield, .datetime, .timepicker", function() {
        $(this).datetimepicker("hide");
    });

    jQuery.validator.addMethod(
        "dateFormat",
        function(value, element) {
            var check = false;
            var re = /^\d{1,2}\-\d{1,2}\-\d{4}$/;
            if (re.test(value)) {
                var adata = value.split("-");
                var dd = parseInt(adata[0], 10);
                var mm = parseInt(adata[1], 10);
                var yyyy = parseInt(adata[2], 10);
                var xdata = new Date(yyyy, mm - 1, dd);
                if (
                    xdata.getFullYear() === yyyy &&
                    xdata.getMonth() === mm - 1 &&
                    xdata.getDate() === dd
                ) {
                    check = true;
                } else {
                    check = false;
                }
            } else {
                check = false;
            }
            return this.optional(element) || check;
        },
        "Wrong date format"
    );
}); //End of document ready
