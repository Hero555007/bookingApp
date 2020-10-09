/* ----------------------------------------------------------------------------
 * Easy!Appointments - Open Source Web Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) 2013 - 2018, Alex Tselegidis
 * @license     http://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        http://easyappointments.org
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

window.FrontendBook = window.FrontendBook || {};

/**
 * Frontend Book
 *
 * This module contains functions that implement the book appointment page functionality. Once the
 * initialize() method is called the page is fully functional and can serve the appointment booking
 * process.
 *
 * @module FrontendBook
 */
(function (exports) {

    'use strict';

    /**
     * Contains terms and conditions consent.
     *
     * @type {Object}
     */
    var termsAndConditionsConsent;

    /**
     * Contains privacy policy consent.
     *
     * @type {Object}
     */
    var privacyPolicyConsent;

    /**
     * Determines the functionality of the page.
     *
     * @type {Boolean}
     */
    exports.manageMode = false;

    /**
     * This method initializes the book appointment page.
     *
     * @param {Boolean} bindEventHandlers (OPTIONAL) Determines whether the default
     * event handlers will be bound to the dom elements.
     * @param {Boolean} manageMode (OPTIONAL) Determines whether the customer is going
     * to make  changes to an existing appointment rather than booking a new one.
     */
    exports.initialize = function (bindEventHandlers, manageMode) {
        bindEventHandlers = bindEventHandlers || true;
        manageMode = manageMode || false;

        if (window.console === undefined) {
            window.console = function () {
            }; // IE compatibility
        }
        
        if (GlobalVariables.displayCookieNotice) {
            cookieconsent.initialise({
                palette: {
                    popup: {
                        background: '#ffffffbd',
                        text: '#666666'
                    },
                    button: {
                        background: '#3DD481',
                        text: '#ffffff'
                    }
                },
                content: {
                    message: EALang.website_using_cookies_to_ensure_best_experience,
                    dismiss: 'OK'
                },
            });

            $('.cc-link').replaceWith(
                $('<a/>', {
                    'data-toggle': 'modal',
                    'data-target': '#cookie-notice-modal',
                    'href': '#',
                    'class': 'cc-link',
                    'text': $('.cc-link').text()
                })
            );
        }

        FrontendBook.manageMode = manageMode;

        // Initialize page's components (tooltips, datepickers etc).
        $('.book-step').qtip({
            position: {
                my: 'top center',
                at: 'bottom center'
            },
            style: {
                classes: 'qtip-green qtip-shadow custom-qtip'
            }
        });

        $('#select-date').datepicker({
            dateFormat: 'dd-mm-yy',
            firstDay: 0,
            minDate: 0,
            defaultDate: Date.today(),

            dayNames: [
                EALang.sunday, EALang.monday, EALang.tuesday, EALang.wednesday,
                EALang.thursday, EALang.friday, EALang.saturday],
            dayNamesShort: [EALang.sunday.substr(0, 3), EALang.monday.substr(0, 3),
                EALang.tuesday.substr(0, 3), EALang.wednesday.substr(0, 3),
                EALang.thursday.substr(0, 3), EALang.friday.substr(0, 3),
                EALang.saturday.substr(0, 3)],
            dayNamesMin: [EALang.sunday.substr(0, 2), EALang.monday.substr(0, 2),
                EALang.tuesday.substr(0, 2), EALang.wednesday.substr(0, 2),
                EALang.thursday.substr(0, 2), EALang.friday.substr(0, 2),
                EALang.saturday.substr(0, 2)],
            monthNames: [EALang.january, EALang.february, EALang.march, EALang.april,
                EALang.may, EALang.june, EALang.july, EALang.august, EALang.september,
                EALang.october, EALang.november, EALang.december],
            prevText: EALang.previous,
            nextText: EALang.next,
            currentText: EALang.now,
            closeText: EALang.close,

            onSelect: function (dateText, instance) {
                // if (($(this).datepicker('getDate').getTime() - new Date().getTime()) > 86400000)
                if ($(this).datepicker('getDate').getFullYear() == new Date().getFullYear() && $(this).datepicker('getDate').getDate() == new Date().getDate() && $(this).datepicker('getDate').getMonth() == new Date().getMonth())
                {
                }
                else{
                    FrontendBookApi.getAvailableHours($(this).datepicker('getDate').toString('yyyy-MM-dd'));
                    FrontendBook.updateConfirmFrame();    
                }
            },

            onChangeMonthYear: function (year, month, instance) {
                var currentDate = new Date(year, month - 1, 1);
                FrontendBookApi.getUnavailableDates($('#select-provider').val(), $('#select-service').val(),
                    currentDate.toString('yyyy-MM-dd'));
            }
        });

        // Bind the event handlers (might not be necessary every time we use this class).
        if (bindEventHandlers) {
            _bindEventHandlers();
        }

        // If the manage mode is true, the appointments data should be loaded by default.
        if (FrontendBook.manageMode) {
            _applyAppointmentData(GlobalVariables.appointmentData,
                GlobalVariables.providerData, GlobalVariables.customerData);
        } else {
            var $selectProvider = $('#select-provider');
            var $selectService = $('#select-service');

            // Check if a specific service was selected (via URL parameter).
            var selectedServiceId = GeneralFunctions.getUrlParameter(location.href, 'service');

            if (selectedServiceId && $selectService.find('option[value="' + selectedServiceId + '"]').length > 0) {
                $selectService.val(selectedServiceId);
            }

            $selectService.trigger('change'); // Load the available hours.

            // Check if a specific provider was selected. 
            var selectedProviderId = GeneralFunctions.getUrlParameter(location.href, 'provider');

            if (selectedProviderId && $selectProvider.find('option[value="' + selectedProviderId + '"]').length === 0) {
                // Select a service of this provider in order to make the provider available in the select box. 
                for (var index in GlobalVariables.availableProviders) {
                    var provider = GlobalVariables.availableProviders[index];

                    if (provider.id === selectedProviderId && provider.services.length > 0) {
                        $selectService
                            .val(provider.services[0])
                            .trigger('change');
                    }
                }
            }

            if (selectedProviderId && $selectProvider.find('option[value="' + selectedProviderId + '"]').length > 0) {
                $selectProvider
                    .val(selectedProviderId)
                    .trigger('change');
            }

        }
    };

    /**
     * This method binds the necessary event handlers for the book appointments page.
     */
    function _bindEventHandlers() {
        /**
         * Event: Selected Provider "Changed"
         *
         * Whenever the provider changes the available appointment date - time periods must be updated.
         */
        $('#select-provider').change(function () {
            FrontendBookApi.getUnavailableDates($(this).val(), $('#select-service').val(),
                $('#select-date').datepicker('getDate').toString('yyyy-MM-dd'));
            FrontendBook.updateConfirmFrame();
        });
        $('#button-next-3').on('click', function(){
            var sessionUser = $('#sessionUser').val();
            if(sessionUser == 1){
                $('#wizard-frame-2').css('display', 'none');
                $('#wizard-frame-3').css('display', 'none');
                $('#wizard-frame-4').css('display', 'none');
                $('#wizard-frame-5').css('display', 'block');
                $('#step-3').removeClass('active-step');
                $('#step-5').addClass('active-step');

            }else{
                 $('#wizard-frame-3').css('display', 'none');
                 $('#wizard-frame-4').css('display', 'block');
                  $('#step-4').addClass('active-step');
                 $('#step-3').removeClass('active-step');
                
            }
            var arrData=[];
            // loop over each table row (tr)
            var i = 0;
            $("#table-id tr").each(function(){
                var currentRow=$(this);
            
                var col1_value=currentRow.find("td:eq(1)").text();
                var col3_value=currentRow.find("td:eq(5)").text();
                var col2_value;
                if ($("#availabeArray_"+i+" select option:selected").text() == "")
                {
                    console.log("availablearray1");
                    col2_value=currentRow.find("td:eq(4)").text();
                }
                else {
                    console.log("availablearray2");
                    col2_value = $("#availabeArray_"+i+" select option:selected").text();
                }
                console.log("arrDataselect",$("#availabeArray_"+i+" select option:selected").text());

                var obj={};
                obj.col1=col1_value;
                obj.col2=col2_value;
                obj.col3=col3_value;

                arrData.push(obj);
                i++;
            });
                console.log("arrData",arrData);
            FrontendBook.updateConfirmFrameRepeat(arrData);
        });

        /**
         * Event: Selected Service "Changed"
         *
         * When the user clicks on a service, its available providers should
         * become visible.
         */
        $('#select-service').change(function () {
            var currServiceId = $('#select-service').val();
            $('#select-provider').empty();
            // $('#select-provider').append('<option value="'+currServiceId+'">Select Provider</option>');
            var i = 0;
            $.each(GlobalVariables.availableProviders, function (indexProvider, provider) {
                $.each(provider.services, function (indexService, serviceId) {
                    // If the current provider is able to provide the selected service,
                    // add him to the listbox.
                 i++;
                 var htm ='';
                 var htm = '<option value="'+provider.id+'">Select Provider</option>';
                 if(i == 1){
                    $('#select-provider').append(htm);
                 }
                    if (serviceId == currServiceId) {
                        var optionHtml = '<option value="' + provider.id + '">'
                            + provider.first_name + ' ' + provider.last_name
                            + '</option>';
                        $('#select-provider').append(optionHtml);
                    }
                });
            });

            // Add the "Any Provider" entry.
            if ($('#select-provider option').length >= 1) {
                $('#select-provider').append(new Option('- ' + EALang.any_provider + ' -', 'any-provider'));
            }

            FrontendBookApi.getUnavailableDates($('#select-provider').val(), $(this).val(),
                $('#select-date').datepicker('getDate').toString('yyyy-MM-dd'));
            FrontendBook.updateConfirmFrame();
            _updateServiceDescription($('#select-service').val(), $('#service-description'));
        });

        /**
         * Event: Next Step Button "Clicked"
         *
         * This handler is triggered every time the user pressed the "next" button on the book wizard.
         * Some special tasks might be performed, depending the current wizard step.
         */
        $('.button-next').click(function () {
            // If we are on the first step and there is not provider selected do not continue
            // with the next step.
            if ($(this).attr('data-step_index') === '1' && $('#select-provider').val() == null) {
                return;
            }

            // If we are on the 2nd tab then the user should have an appointment hour
            // selected.
            if ($(this).attr('data-step_index') === '2') {
                if ($('.selected-hour').length == 0) {
                    if ($('#select-hour-prompt').length == 0) {
                        $('#available-hours').append('<br><br>'
                            + '<span id="select-hour-prompt" class="text-danger">'
                            + EALang.appointment_hour_missing
                            + '</span>');
                    }
                    return;
                }
            }

            // If we are on the 3rd tab then we will need to validate the user's
            // input before proceeding to the next step.
            if ($(this).attr('data-step_index') === '4') {
                if (!_validateCustomerForm()) {
                    return; // Validation failed, do not continue.
                } else {
                    FrontendBook.updateConfirmFrame();

                    var $acceptToTermsAndConditions = $('#accept-to-terms-and-conditions');
                    if ($acceptToTermsAndConditions.length && $acceptToTermsAndConditions.prop('checked') === true) {
                        var newTermsAndConditionsConsent = {
                            first_name: $('#first-name').val(),
                            last_name: $('#last-name').val(),
                            email: $('#email').val(),
                            type: 'terms-and-conditions'
                        };

                        if (JSON.stringify(newTermsAndConditionsConsent) !== JSON.stringify(termsAndConditionsConsent)) {
                            termsAndConditionsConsent = newTermsAndConditionsConsent;
                            FrontendBookApi.saveConsent(termsAndConditionsConsent);
                        }
                    }

                    var $acceptToPrivacyPolicy = $('#accept-to-privacy-policy');
                    if ($acceptToPrivacyPolicy.length && $acceptToPrivacyPolicy.prop('checked') === true) {
                        var newPrivacyPolicyConsent = {
                            first_name: $('#first-name').val(),
                            last_name: $('#last-name').val(),
                            email: $('#email').val(),
                            type: 'privacy-policy'
                        };

                        if (JSON.stringify(newPrivacyPolicyConsent) !== JSON.stringify(privacyPolicyConsent)) {
                            privacyPolicyConsent = newPrivacyPolicyConsent;
                            FrontendBookApi.saveConsent(privacyPolicyConsent);
                        }
                    }
                }
            }

            // Display the next step tab (uses jquery animation effect).
            var nextTabIndex = parseInt($(this).attr('data-step_index')) + 1;

            $(this).parents().eq(1).hide('fade', function () {
                $('.active-step').removeClass('active-step');
                $('#step-' + nextTabIndex).addClass('active-step');
                $('#wizard-frame-' + nextTabIndex).show('fade');
            });
        });

        /**
         * Event: Back Step Button "Clicked"
         *
         * This handler is triggered every time the user pressed the "back" button on the
         * book wizard.
         */
        $('.button-back').click(function () {
            var prevTabIndex;
            if (parseInt($(this).attr('data-step_index')) == 4 && $('#test7').is(":checked") == false){
                prevTabIndex = parseInt($(this).attr('data-step_index')) - 2;
            }
            else{
                prevTabIndex = parseInt($(this).attr('data-step_index')) - 1;
            }

            $(this).parents().eq(1).hide('fade', function () {
                $('.active-step').removeClass('active-step');
                $('#step-' + prevTabIndex).addClass('active-step');
                $('#wizard-frame-' + prevTabIndex).show('fade');
            });
        });

        /**
         * Event: Available Hour "Click"
         *
         * Triggered whenever the user clicks on an available hour
         * for his appointment.
         */
        $('#available-hours').on('click', '.available-hour', function () {
            var availableHour = $('.available-hour').text();
            var availableHourLength = availableHour.length;
            var availableHourArray = [];
            while (availableHourLength != 0){
                availableHourArray.push(availableHour.substr(availableHourLength - 5, 5));
                availableHourLength = availableHourLength - 5;
            }
            console.log("availableHourArray", availableHourArray);
            //$('.selected-hour').removeClass('selected-hour');
            if($(this).hasClass('selected-hour')) {
                if ($('.selected-hour').text().length > 5){
                    $(this).removeClass('selected-hour');
                }
                else{
                    
                }
            }else{
                $(this).addClass('selected-hour');
            }
            var selectedHour = $('.selected-hour').text();
            var selectedHourLength = selectedHour.length;
            var selectedHourArray = [];
            while (selectedHourLength != 0){
                selectedHourArray.push(selectedHour.substr(selectedHourLength - 5, 5));
                selectedHourLength = selectedHourLength - 5;
            }
            if (selectedHourArray.length > 1)
            {
                // $('#test7').prop('checked', false);
                // $('#step-3').css('display','none');
                $('#repeat-button').css('display','none');
            }
            else{
                // $('#test7').prop('checked', false);
                // $('#step-3').css('display','none');
                $('#repeat-button').css('display','block');
            }
            FrontendBook.updateConfirmFrame();
        });
    //     $('#title').click(function() {
    // if($(this).hasClass('active')) {
    //     $(this).removeClass('active');
    // } else {
    //     $(this).addClass('active');
    // }

        if (FrontendBook.manageMode) {
            /**
             * Event: Cancel Appointment Button "Click"
             *
             * When the user clicks the "Cancel" button this form is going to be submitted. We need
             * the user to confirm this action because once the appointment is cancelled, it will be
             * delete from the database.
             *
             * @param {jQuery.Event} event
             */
            $('#cancel-appointment').click(function (event) {
                var buttons = [
                    {
                        text: 'OK',
                        click: function () {
                            if ($('#cancel-reason').val() === '') {
                                $('#cancel-reason').css('border', '2px solid red');
                                return;
                            }
                            $('#cancel-appointment-form textarea').val($('#cancel-reason').val());
                            $('#cancel-appointment-form').submit();
                        }
                    },
                    {
                        text: EALang.cancel,
                        click: function () {
                            $('#message_box').dialog('close');
                        }
                    }
                ];

                GeneralFunctions.displayMessageBox(EALang.cancel_appointment_title,
                    EALang.write_appointment_removal_reason, buttons);

                $('#message_box').append('<textarea id="cancel-reason" rows="3"></textarea>');
                $('#cancel-reason').css('width', '100%');
                return false;
            });

            $('#delete-personal-information').on('click', function () {
                var buttons = [
                    {
                        text: EALang.delete,
                        click: function () {
                            FrontendBookApi.deletePersonalInformation(GlobalVariables.customerToken);
                        }
                    },
                    {
                        text: EALang.cancel,
                        click: function () {
                            $('#message_box').dialog('close');
                        }
                    }
                ];

                GeneralFunctions.displayMessageBox(EALang.delete_personal_information,
                    EALang.delete_personal_information_prompt, buttons);
            });
        }

        /**
         * Event: Book Appointment Form "Submit"
         *
         * Before the form is submitted to the server we need to make sure that
         * in the meantime the selected appointment date/time wasn't reserved by
         * another customer or event.
         *
         * @param {jQuery.Event} event
         */
        $('#book-appointment-submit').click(function (event) {
            FrontendBookApi.registerAppointment();
        });

        /**
         * Event: Refresh captcha image.
         *
         * @param {jQuery.Event} event
         */
        $('.captcha-title small').click(function (event) {
            $('.captcha-image').attr('src', GlobalVariables.baseUrl + '/index.php/captcha?' + Date.now());
        });


        $('#select-date').on('mousedown', '.ui-datepicker-calendar td', function (event) {
            setTimeout(function () {
                FrontendBookApi.applyPreviousUnavailableDates(); // New jQuery UI version will replace the td elements.
            }, 300); // There is no draw event unfortunately.
        })
    }

    /**
     * This function validates the customer's data input. The user cannot continue
     * without passing all the validation checks.
     *
     * @return {Boolean} Returns the validation result.
     */
    function _validateCustomerForm() {
        $('#wizard-frame-3 .has-error').removeClass('has-error');
        $('#wizard-frame-3 label.text-danger').removeClass('text-danger');

        try {
            // Validate required fields.
            var missingRequiredField = false;
            $('.required').each(function () {
                if ($(this).val() == '') {
                    $(this).parents('.form-group').addClass('has-error');
                    missingRequiredField = true;
                }
            });
            if (missingRequiredField) {
                throw EALang.fields_are_required;
            }

            var $acceptToTermsAndConditions = $('#accept-to-terms-and-conditions');
            if ($acceptToTermsAndConditions.length && !$acceptToTermsAndConditions.prop('checked')) {
                $acceptToTermsAndConditions.parents('label').addClass('text-danger');
                throw EALang.fields_are_required;
            }

            var $acceptToPrivacyPolicy = $('#accept-to-privacy-policy');
            if ($acceptToPrivacyPolicy.length && !$acceptToPrivacyPolicy.prop('checked')) {
                $acceptToPrivacyPolicy.parents('label').addClass('text-danger');
                throw EALang.fields_are_required;
            }


            // Validate email address.
            if (!GeneralFunctions.validateEmail($('#email').val())) {
                $('#email').parents('.form-group').addClass('has-error');
                throw EALang.invalid_email;
            }

            return true;
        } catch (exc) {
            $('#form-message').text(exc);
            return false;
        }
    }

    /**
     * Every time this function is executed, it updates the confirmation page with the latest
     * customer settings and input for the appointment booking.
     */
    exports.updateConfirmFrame = function () {
        console.log("updateconfirmframe", $('.selected-hour').text());
        if ($('.selected-hour').text() === '') {
            return;
        }

        // Appointment Details
        var selectedDate = $('#select-date').datepicker('getDate');

        if (selectedDate !== null) {
            selectedDate = GeneralFunctions.formatDate(selectedDate, GlobalVariables.dateFormat);
        }

        var selServiceId = $('#select-service').val();
        var servicePrice;
        var serviceCurrency;
        

        $.each(GlobalVariables.availableServices, function (index, service) {
            if (service.id == selServiceId) {
                servicePrice = '<br>' + service.price;
                serviceCurrency = service.currency;
                return false; // break loop
            }
        });
        var queryArr = [];
         var queryAr = [];
         var totlacost = 0;
         var individualcoststr = " = ";
         $(".selected-hour").each(function(el) {
            var val = $(this).text();
            var price = $(this).attr('data');
            queryArr.push(val); 
            queryAr.push(price);
        }); 
        if (queryAr.length == 1)
        {
            individualcoststr = "";
            queryAr.forEach(item => {
                totlacost = totlacost + parseInt(item);
            });    
        }
        else{
            queryAr.forEach(item => {
                totlacost = totlacost + parseInt(item);
                individualcoststr = individualcoststr + "$" + item + " + ";
            });    
        }
        
        individualcoststr = individualcoststr.substr(0, individualcoststr.length - 3);

        var html =
            '<div class="confirm-one"><div class="img-confirm"></div><h4>APPOINTMENT CONFIRMATION!</h4>' +
            '<p>'
            + '<strong class="text-primary"><strong class="text-primary">Please confirm your appointment with '
            + $('#select-provider option:selected').text() + '</strong></p></div><p>'
           
            + "on " + selectedDate + ' for ' + queryArr +'<br>'
            + "Total cost is $" + totlacost.toString() + individualcoststr  +
            '</p><hr>';

        $('#appointment-details').html(html);

        // Customer Details
        var firstName = GeneralFunctions.escapeHtml($('#first-name').val());
        var lastName = GeneralFunctions.escapeHtml($('#last-name').val());
        var phoneNumber = GeneralFunctions.escapeHtml($('#phone-number').val());
        var email = GeneralFunctions.escapeHtml($('#email').val());
        var address = GeneralFunctions.escapeHtml($('#address').val());
        var city = GeneralFunctions.escapeHtml($('#city').val());
        var zipCode = GeneralFunctions.escapeHtml($('#zip-code').val());

        html =
            '<h4>' + firstName + ' ' + lastName + '</h4>' +
            '<p>' +
            EALang.phone + ': ' + phoneNumber +
            ', ' +
            EALang.email + ': ' + email +
            ', ' +
            EALang.address + ': ' + address +
            ', ' +
            EALang.city + ': ' + city +
            ', ' +
            EALang.zip_code + ': ' + zipCode +
            '</p><div class="form-group"><label for="comment">Additional Information</label><textarea class="form-control" rows="5" id="notes" name="comments" placeholder="  Write here..." required></textarea></div>';

        $('#customer-details').html(html);

        // Update appointment form data for submission to server when the user confirms
        // the appointment.
        var postDatas = [];
        var looplen = $('.selected-hour').text().length;
        while(looplen != 0)
        {
            var postData = {};
            postData.customer = {
                last_name: $('#last-name').val(),
                first_name: $('#first-name').val(),
                email: $('#email').val(),
                phone_number: $('#phone-number').val(),
                address: $('#address').val(),
                city: $('#city').val(),
                zip_code: $('#zip-code').val()
            };
    
            console.log("selectText", $('.selected-hour').text());
            var selectHour = "";
            selectHour = $('.selected-hour').text().substr((looplen - 5),5)
            console.log("selectHour", selectHour);
            postData.appointment = {
                start_datetime: $('#select-date').datepicker('getDate').toString('yyyy-MM-dd')
                + ' ' + Date.parse(selectHour).toString('HH:mm') + ':00',
                end_datetime: _calcEndDatetime(selectHour),
                notes: $('#notes').val(),
                is_unavailable: false,
                id_users_provider: $('#select-provider').val(),
                id_services: $('#select-service').val()
            };
    
            postData.manage_mode = FrontendBook.manageMode;
    
            if (FrontendBook.manageMode) {
                postData.appointment.id = GlobalVariables.appointmentData.id;
                postData.customer.id = GlobalVariables.customerData.id;
            }
            postDatas.push(postData);
            looplen = looplen - 5;
            console.log("postdata", postData);
        }
        console.log("postdatas", postDatas);
        $('input[name="csrfToken"]').val(GlobalVariables.csrfToken);
        console.log("jsonpostdata",JSON.stringify(postDatas));
        $('input[name="post_data"]').val(JSON.stringify(postDatas));
    };
    exports.updateConfirmFrameCreateuser = function (userData) {
        console.log("userData", userData);
        var serviceU;
        var providerU;
        $.each(GlobalVariables.availableServices, function (index, service) {
            if (service.id = userData[0]['appointment']['id_services'])
            {
                console.log("service", service);
                serviceU = service;
            }
        });
        $.each(GlobalVariables.availableProviders, function (indexProvider, provider) {
            console.log("provider", indexProvider, provider);
            if (provider.id == userData[0]['appointment']['id_users_provider']) {
                providerU = provider;
            }
        });
        var dateText = "";
        var priceText = "";
        userData.map(item =>{
            dateText = dateText + "on ";
            dateText = dateText + item['appointment']['start_datetime'].toString().substr(0,10) + ' for ' + item['appointment']['start_datetime'].toString().substr(11,8);
            dateText = dateText + ", ";
        });
        if (userData.length == 1)
        {
            priceText = "Total cost is $";
            priceText = priceText + parseInt(serviceU.price) * userData.length.toString();
        }
        else{
            priceText = "Total cost is $";
            priceText = priceText + parseInt(serviceU.price) * userData.length.toString();
            priceText = priceText + " = " + serviceU.price + " * " + userData.length.toString();    
        }
        var html =
        '<div class="confirm-one"><div class="img-confirm"></div><h4>APPOINTMENT CONFIRMATION!</h4>' +
        '<p>'
        + '<strong class="text-primary"><strong class="text-primary">Please confirm your appointment with '
        + providerU.first_name + ' ' + providerU.last_name + '</strong></p></div><p>'
        + dateText +'<br>'
        + priceText +
        '</p><hr>';

        $('#appointment-details').html(html);

        html =
            '<h4>' + userData[0]['customer']['first_name'] + ' ' + userData[0]['customer']['last_name'] + '</h4>' +
            '<p>' +
            EALang.phone + ': ' + userData[0]['customer']['phone_number'] +
            ', ' +
            EALang.email + ': ' + userData[0]['customer']['email'] +
            ', ' +
            EALang.address + ': ' + userData[0]['customer']['address'] +
            ', ' +
            EALang.city + ': ' + userData[0]['customer']['city'] +
            ', ' +
            EALang.zip_code + ': ' + userData[0]['customer']['zip_code'] +
            '</p><div class="form-group"><label for="comment">Additional Information</label><textarea class="form-control" rows="5" id="notes" name="comments" placeholder="  Write here..." required></textarea></div>';

        $('#customer-details').html(html);
        console.log("postdatainput",$('input[name="post_data"]').val())
    };
    exports.updateConfirmFrameRepeat = function (repeatData) {
        console.log("updateConfirmFrameRepeat");
        if (repeatData.length === 0) {
            return;
        }

        // Appointment Details
        // var selectedDate = $('#select-date').datepicker('getDate');

        // if (selectedDate !== null) {
        //     selectedDate = GeneralFunctions.formatDate(selectedDate, GlobalVariables.dateFormat);
        // }

        var selServiceId = $('#select-service').val();
        var servicePrice;
        var serviceCurrency;
        

        $.each(GlobalVariables.availableServices, function (index, service) {
            if (service.id == selServiceId) {
                servicePrice = '<br>' + service.price;
                serviceCurrency = service.currency;
                return false; // break loop
            }
        });
        var queryArr = [];
         var queryAr = [];
         var totlacost = 0;
         var individualcoststr = " = ";
         repeatData.map(item=>{
             if (item['col3'] != '' && item['col3'] != 'not available')
             {
                queryArr.push(item['col1'] + " at " + item['col2'])
             }
         });
            $(".selected-hour").each(function(el) {
                var price = $(this).attr('data');
                queryAr.push(price);
            }); 
        totlacost = parseInt(queryAr[0]) * queryArr.length;
        if (queryArr.length == 1)
        {
            individualcoststr = "";
        }
        else{
            individualcoststr += parseInt(queryAr[0]) + " * " + queryArr.length;
        }

        var html =
            '<div class="confirm-one"><div class="img-confirm"></div><h4>APPOINTMENT CONFIRMATION!</h4>' +
            '<p>'
            + '<strong class="text-primary"><strong class="text-primary">Please confirm your appointment with '
            + $('#select-provider option:selected').text() + '</strong></p></div><p>'
           
            + queryArr +'<br>'
            + "Total cost is $" + totlacost.toString() + individualcoststr  +
            '</p><hr>';

        $('#appointment-details').html(html);

        // Customer Details
        var firstName = GeneralFunctions.escapeHtml($('#first-name').val());
        var lastName = GeneralFunctions.escapeHtml($('#last-name').val());
        var phoneNumber = GeneralFunctions.escapeHtml($('#phone-number').val());
        var email = GeneralFunctions.escapeHtml($('#email').val());
        var address = GeneralFunctions.escapeHtml($('#address').val());
        var city = GeneralFunctions.escapeHtml($('#city').val());
        var zipCode = GeneralFunctions.escapeHtml($('#zip-code').val());

        html =
            '<h4>' + firstName + ' ' + lastName + '</h4>' +
            '<p>' +
            EALang.phone + ': ' + phoneNumber +
            ', ' +
            EALang.email + ': ' + email +
            ', ' +
            EALang.address + ': ' + address +
            ', ' +
            EALang.city + ': ' + city +
            ', ' +
            EALang.zip_code + ': ' + zipCode +
            '</p><div class="form-group"><label for="comment">Additional Information</label><textarea class="form-control" rows="5" id="notes" name="comments" placeholder="  Write here..." required></textarea></div>';

        $('#customer-details').html(html);

        // Update appointment form data for submission to server when the user confirms
        // the appointment.
        var postDatas = [];
        var looplen = queryArr.length;
        console.log("looplen", looplen);
        while(looplen != 0)
        {
            var postData = {};
            postData.customer = {
                last_name: $('#last-name').val(),
                first_name: $('#first-name').val(),
                email: $('#email').val(),
                phone_number: $('#phone-number').val(),
                address: $('#address').val(),
                city: $('#city').val(),
                zip_code: $('#zip-code').val()
            };
    
            console.log("selectText1", $('.selected-hour').text(), queryArr);
            var selectHour = "";
            selectHour = queryArr[queryArr.length - looplen].substr(9,5);
            console.log("selectHour", selectHour,$('#select-date').datepicker('getDate').toString('yyyy') + " " + queryArr[queryArr.length - looplen].substr(0,5) + " " + _calcEndDatetime(selectHour).substr(11.19));
            postData.appointment = {
                start_datetime: $('#select-date').datepicker('getDate').toString('yyyy')
                + "-" + queryArr[queryArr.length - looplen].substr(0,6) + queryArr[queryArr.length - looplen].substr(9,5) + ':00',
                end_datetime:$('#select-date').datepicker('getDate').toString('yyyy') + "-" + queryArr[queryArr.length - looplen].substr(0,5) +" " + _calcEndDatetime(selectHour).substr(11,19),
                notes: $('#notes').val(),
                is_unavailable: false,
                id_users_provider: $('#select-provider').val(),
                id_services: $('#select-service').val()
            };
    
            postData.manage_mode = FrontendBook.manageMode;
    
            if (FrontendBook.manageMode) {
                postData.appointment.id = GlobalVariables.appointmentData.id;
                postData.customer.id = GlobalVariables.customerData.id;
            }
            postDatas.push(postData);
            looplen = looplen - 1;
            console.log("postdata", postData);
        }
        console.log("postdatas", postDatas);
        $('input[name="csrfToken"]').val(GlobalVariables.csrfToken);
        $('input[name="post_data"]').val(JSON.stringify(postDatas));
    };
    /**
     * This method calculates the end datetime of the current appointment.
     * End datetime is depending on the service and start datetime fields.
     *
     * @return {String} Returns the end datetime in string format.
     */
    function _calcEndDatetime(selectHour) {
        // Find selected service duration.
        var selServiceDuration = undefined;

        $.each(GlobalVariables.availableServices, function (index, service) {
            if (service.id == $('#select-service').val()) {
                selServiceDuration = service.duration;
                return false; // Stop searching ...
            }
        });

        // Add the duration to the start datetime.
        var startDatetime = $('#select-date').datepicker('getDate').toString('dd-MM-yyyy')
            + ' ' + Date.parse(selectHour).toString('HH:mm');
        startDatetime = Date.parseExact(startDatetime, 'dd-MM-yyyy HH:mm');
        var endDatetime = undefined;

        if (selServiceDuration !== undefined && startDatetime !== null) {
            endDatetime = startDatetime.add({'minutes': parseInt(selServiceDuration)});
        } else {
            endDatetime = new Date();
        }

        return endDatetime.toString('yyyy-MM-dd HH:mm:ss');
    }

    /**
     * This method applies the appointment's data to the wizard so
     * that the user can start making changes on an existing record.
     *
     * @param {Object} appointment Selected appointment's data.
     * @param {Object} provider Selected provider's data.
     * @param {Object} customer Selected customer's data.
     *
     * @return {Boolean} Returns the operation result.
     */
    function _applyAppointmentData(appointment, provider, customer) {
        try {
            // Select Service & Provider
            $('#select-service').val(appointment.id_services).trigger('change');
            $('#select-provider').val(appointment.id_users_provider);

            // Set Appointment Date
            $('#select-date').datepicker('setDate',
                Date.parseExact(appointment.start_datetime, 'yyyy-MM-dd HH:mm:ss'));
            FrontendBookApi.getAvailableHours($('#select-date').val());

            // Apply Customer's Data
            $('#last-name').val(customer.last_name);
            $('#first-name').val(customer.first_name);
            $('#email').val(customer.email);
            $('#phone-number').val(customer.phone_number);
            $('#address').val(customer.address);
            $('#city').val(customer.city);
            $('#zip-code').val(customer.zip_code);
            var appointmentNotes = (appointment.notes !== null)
                ? appointment.notes : '';
            $('#notes').val(appointmentNotes);

            FrontendBook.updateConfirmFrame();

            return true;
        } catch (exc) {
            return false;
        }
    }

    /**
     * This method updates a div's html content with a brief description of the
     * user selected service (only if available in db). This is useful for the
     * customers upon selecting the correct service.
     *
     * @param {Number} serviceId The selected service record id.
     * @param {Object} $div The destination div jquery object (e.g. provide $('#div-id')
     * object as value).
     */
    function _updateServiceDescription(serviceId, $div) {
        var html = '';

        $.each(GlobalVariables.availableServices, function (index, service) {
            if (service.id == serviceId) { // Just found the service.
                html = '<strong>' + service.name + ' </strong>';

                if (service.description != '' && service.description != null) {
                    html += '<br>' + service.description + '<br>';
                }

                if (service.duration != '' && service.duration != null) {
                    html += '[' + EALang.duration + ' ' + service.duration + ' ' + EALang.minutes + ']';
                }

                if (service.price != '' && service.price != null) {
                    html += '[' + EALang.price + ' ' + service.price + ' ' + service.currency + ']';
                }

                html += '<br>';

                return false;
            }
        });

        $div.html(html);

        if (html != '') {
            $div.show();
        } else {
            $div.hide();
        }
    }

})(window.FrontendBook);
