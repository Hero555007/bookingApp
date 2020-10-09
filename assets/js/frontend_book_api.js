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

window.FrontendBookApi = window.FrontendBookApi || {};

/**
 * Frontend Book API
 *
 * This module serves as the API consumer for the booking wizard of the app.
 *
 * @module FrontendBookApi
 */
(function (exports) {

    'use strict';

    var unavailableDatesBackup;
    var selectedDateStringBackup;
    var processingUnavailabilities = false;

    /**
     * Get Available Hours
     *
     * This function makes an AJAX call and returns the available hours for the selected service,
     * provider and date.
     *
     * @param {String} selDate The selected date of which the available hours we need to receive.
     */
    exports.getAvailableHours = function (selDate) {
        $('#available-hours').empty();

        // Find the selected service duration (it is going to be send within the "postData" object).
        var selServiceDuration = 55; // Default value of duration (in minutes).
        $.each(GlobalVariables.availableServices, function (index, service) {
            if (service.id == $('#select-service').val()) {
                selServiceDuration = service.duration;
            }
        });

        // If the manage mode is true then the appointment's start date should return as available too.
        var appointmentId = FrontendBook.manageMode ? GlobalVariables.appointmentData.id : undefined;

        // Make ajax post request and get the available hours.
        var postUrl = GlobalVariables.baseUrl + '/index.php/appointments/ajax_get_available_hours';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
            service_id: $('#select-service').val(),
            provider_id: $('#select-provider').val(),
            selected_date: selDate,
            service_duration: selServiceDuration,
            manage_mode: FrontendBook.manageMode,
            appointment_id: appointmentId
        };
        console.log("responseforstart", postData);

        $.post(postUrl, postData, function (response) {
            console.log("responseforstart", response);
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
        var selServiceId = $('#select-service').val();
        var servicePrice;
        var serviceCurrency;

        $.each(GlobalVariables.availableServices, function (index, service) {
            if (service.id == selServiceId) {
                servicePrice = '<br>' + service.price;
                  servicePrice = + service.price;
                serviceCurrency = service.currency;
                return false; // break loop
            }
        });
            // The response contains the available hours for the selected provider and
            // service. Fill the available hours div with response data.
            if (response.length > 0) {
                $('#availablehourdiv').css('display','block');
                $('#availablehourdiv').html('<div style="margin-left:auto; margin-right:auto;display:table;">Multiple time slots can be selected</div>');
                var currColumn = 1;
                $('#available-hours').html('<div id="availablehours'+currColumn+'" style="width:170px; float:left;margin-left:auto; margin-right:auto;"></div>');

                var timeFormat = GlobalVariables.timeFormat === 'regular' ? 'h:mm tt' : 'HH:mm';

                 $.each(response, function (index, availableHour) {
                     console.log("responseindex_availablehour", response, index, availableHour);
                    if ((currColumn * 10) < (index + 1)) {
                        currColumn++;
                        if (currColumn < 3)
                        {
                            $('#available-hours').append('<div id="availablehours'+currColumn+'" style="width:170px; float:left;margin-left:auto; margin-right:auto;"></div>');
                        }
                    }
                    if (currColumn < 3)
                    {
                        console.log("availablehour", availableHour);
                        availableHour = JSON.stringify(availableHour).substring(7,12);
                        console.log("availablehour", availableHour);
                        $('#available-hours #availablehours'+currColumn).append(
                            '<div class="date-sec"><span class="available-hour" data="'+ servicePrice +'">' + Date.parse(availableHour).toString(timeFormat) + '</span><p>' + servicePrice + ' ' + serviceCurrency+'</p></div><br/>');
                    }
                });

                if (FrontendBook.manageMode) {
                    // Set the appointment's start time as the default selection.
                    $('.available-hour').removeClass('selected-hour');
                    $('.available-hour').filter(function () {
                        return $(this).text() === Date.parseExact(
                            GlobalVariables.appointmentData.start_datetime,
                            'yyyy-MM-dd HH:mm:ss').toString(timeFormat);
                    }).addClass('selected-hour');
                } else {
                    // Set the first available hour as the default selection.
                    // $('.available-hour:eq(0)').addClass('selected-hour');
                }
                $('#repeat-button').css('display','block');
                FrontendBook.updateConfirmFrame();

            } else {
                $('#availablehourdiv').css('display','none');
                $('#available-hours').text(EALang.no_available_hours);
                $('#available-hours').append('<br>or if you have an urgent issue please do not hesitate to ring or txt me on <a style="font-weight:bold; color:red; display:contents; font-style:italic;" href="tel:0276551300">027-655-1300</a>.')
                $('#repeat-button').css('display','none');
            }
        }, 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Register an appointment to the database.
     *
     * This method will make an ajax call to the appointments controller that will register
     * the appointment to the database.
     */
    exports.registerAppointment = function () {
        var $captchaText = $('.captcha-text');
        var flag = true;
        var appointid = 0;
        var count = 0;

        if ($captchaText.length > 0) {
            $captchaText.closest('.form-group').removeClass('has-error');
            if ($captchaText.val() === '') {
                $captchaText.closest('.form-group').addClass('has-error');
                return;
            }
        }

        var postUrl = GlobalVariables.baseUrl + '/index.php/appointments/ajax_register_appointment';
        if ($captchaText.length > 0) {
            postData.captcha = $captchaText.val();
        }
        var formDatas = jQuery.parseJSON($('input[name="post_data"]').val());
        var formDatass = [];
        var bufnotes = "";
        console.log("formDatas", formDatas);
        var bufcustomer = {};
        formDatas.forEach(formData => {
            if (formData['customer']['email'] != ""){
                bufcustomer = formData['customer'];
            }
            console.log("formnotes", formData['appointment']['notes']);
            if (formData['appointment']['notes'] != "") {
                bufnotes = formData['appointment']['notes'];
            }
        })
        console.log("customer", bufcustomer);
        console.log("notes", bufnotes);

        formDatas.forEach(formData => {
            console.log("bufcustomer", formData['customer']['email']);
            if (formData['customer']['email'] == ""){
                formData['customer'] = bufcustomer;
            }
            if (formData['appointment']['notes'] == ""){
                formData['appointment']['notes'] = bufnotes;
            }
            formDatass.push(formData);
        })
        console.log("formDatas1", formDatass);

        var bar = new ldBar(".myBar", {
            "stroke": '#f00',
            "stroke-width": 10,
            "preset": "circle",
            "value": 1
        });
        var progressStep = 100 / (formDatas.length);
        progressStep = Math.floor(progressStep);
        console.log("progressstep", progressStep);
        if (formDatas.length == 1)
        {
            formDatas.forEach(formData => {
                var postData = {
                    csrfToken: GlobalVariables.csrfToken,
                    post_data: formData,
                    // flag : true,
                    // flagdata : "",
                };
        
                if (GlobalVariables.manageMode) {
                    postData.exclude_appointment_id = GlobalVariables.appointmentData.id;
                }
        
                var $layer = $('<div/>');
        
                $.ajax({
                    url: postUrl,
                    method: 'post',
                    data: postData,
                    dataType: 'json',
                    beforeSend: function (jqxhr, settings) {
                        $layer
                            .appendTo('body')
                            .css({
                                background: 'white',
                                position: 'fixed',
                                top: '0',
                                left: '0',
                                height: '100vh',
                                width: '100vw',
                                opacity: '0.5'
                            });
                    }
                })
                    .done(function (response) {
                        count = count + 1;
                        bar.set(progressStep * count, true);
                        if (!GeneralFunctions.handleAjaxExceptions(response)) {
                            $('.captcha-title small').trigger('click');
                            flag = false;
                            return false;
                        }
        
                        if (response.captcha_verification === false) {
                            $('#captcha-hint')
                                .text(EALang.captcha_is_wrong)
                                .fadeTo(400, 1);
        
                            setTimeout(function () {
                                $('#captcha-hint').fadeTo(400, 0);
                            }, 3000);
        
                            $('.captcha-title small').trigger('click');
        
                            $captchaText.closest('.form-group').addClass('has-error');
                            flag = false;
                            return false;
                        }
                        appointid = response.appointment_id;
                        console.log("responseid", response, response.appointment_id, typeof(response.appointment_id));
                        if (flag == true && count == formDatas.length)
                        {
                            bar.set(100, true);
                            console.log("targetUrl", GlobalVariables.baseUrl + '/index.php/appointments/book_success/' + appointid.toString());
                            window.location.href = GlobalVariables.baseUrl + '/index.php/appointments/book_success/' + appointid.toString();    
                        }
                    })
                    .fail(function (jqxhr, textStatus, errorThrown) {
                        flag = false;
                        $('.captcha-title small').trigger('click');
                        GeneralFunctions.ajaxFailureHandler(jqxhr, textStatus, errorThrown);
                    })
                    .always(function () {
                        $layer.remove();
                    });
            });
        }
        else{
            var flagCount = 1;
            var flagData = "";
            formDatas.forEach(formData => {
                var postData = {
                    csrfToken: GlobalVariables.csrfToken,
                    post_data: formData,
                    // flag: false,
                    // flagdata:"",
                };
        
                if (GlobalVariables.manageMode) {
                    postData.exclude_appointment_id = GlobalVariables.appointmentData.id;
                }
        
                var $layer = $('<div/>');
        
                $.ajax({
                    url: postUrl,
                    method: 'post',
                    data: postData,
                    dataType: 'json',
                    beforeSend: function (jqxhr, settings) {
                        $layer
                            .appendTo('body')
                            .css({
                                background: 'white',
                                position: 'fixed',
                                top: '0',
                                left: '0',
                                height: '100vh',
                                width: '100vw',
                                opacity: '0.5'
                            });
                    }
                })
                    .done(function (response) {
                        count = count + 1;
                        bar.set(progressStep * count, true);
                        if (!GeneralFunctions.handleAjaxExceptions(response)) {
                            $('.captcha-title small').trigger('click');
                            flag = false;
                            return false;
                        }
        
                        if (response.captcha_verification === false) {
                            $('#captcha-hint')
                                .text(EALang.captcha_is_wrong)
                                .fadeTo(400, 1);
        
                            setTimeout(function () {
                                $('#captcha-hint').fadeTo(400, 0);
                            }, 3000);
        
                            $('.captcha-title small').trigger('click');
        
                            $captchaText.closest('.form-group').addClass('has-error');
                            flag = false;
                            return false;
                        }
                        appointid = response.appointment_id;
                        console.log("responseid", response, response.appointment_id, typeof(response.appointment_id));
                        if (flag == true && count == formDatas.length)
                        {
                            bar.set(100, true);
                            console.log("targetUrl", GlobalVariables.baseUrl + '/index.php/appointments/book_success/' + appointid.toString());
                            window.location.href = GlobalVariables.baseUrl + '/index.php/appointments/book_success/' + appointid.toString();    
                        }
                    })
                    .fail(function (jqxhr, textStatus, errorThrown) {
                        flag = false;
                        $('.captcha-title small').trigger('click');
                        GeneralFunctions.ajaxFailureHandler(jqxhr, textStatus, errorThrown);
                    })
                    .always(function () {
                        $layer.remove();
                    });
            });
        }

        console.log("aa", count, "bb", formDatas.length);
    };

    /**
     * Get the unavailable dates of a provider.
     *
     * This method will fetch the unavailable dates of the selected provider and service and then it will
     * select the first available date (if any). It uses the "FrontendBookApi.getAvailableHours" method to
     * fetch the appointment* hours of the selected date.
     *
     * @param {Number} providerId The selected provider ID.
     * @param {Number} serviceId The selected service ID.
     * @param {String} selectedDateString Y-m-d value of the selected date.
     */
    exports.getUnavailableDates = function (providerId, serviceId, selectedDateString) {
        if (processingUnavailabilities) {
            return;
        }

        var appointmentId = FrontendBook.manageMode ? GlobalVariables.appointmentData.id : undefined;

        var url = GlobalVariables.baseUrl + '/index.php/appointments/ajax_get_unavailable_dates';
        var data = {
            provider_id: providerId,
            service_id: serviceId,
            selected_date: encodeURIComponent(selectedDateString),
            csrfToken: GlobalVariables.csrfToken,
            manage_mode: FrontendBook.manageMode,
            appointment_id: appointmentId
        };

        $.ajax({
            url: url,
            type: 'GET',
            data: data,
            dataType: 'json'
        })
            .done(function (response) {
                unavailableDatesBackup = response;
                selectedDateStringBackup = selectedDateString;
                _applyUnavailableDates(response, selectedDateString, true);
            })
            .fail(GeneralFunctions.ajaxFailureHandler);
    };

    exports.applyPreviousUnavailableDates = function () {
        _applyUnavailableDates(unavailableDatesBackup, selectedDateStringBackup);
    };

    function _applyUnavailableDates(unavailableDates, selectedDateString, setDate) {
        setDate = setDate || false;

        processingUnavailabilities = true;

        // Select first enabled date.
        var selectedDate = Date.parse(selectedDateString);
        var numberOfDays = new Date(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 0).getDate();

        if (setDate && !GlobalVariables.manageMode) {
            for (var i = 1; i <= numberOfDays; i++) {
                var currentDate = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), i);
                if (unavailableDates.indexOf(currentDate.toString('yyyy-MM-dd')) === -1) {
                    $('#select-date').datepicker('setDate', currentDate);
                    FrontendBookApi.getAvailableHours(currentDate.toString('yyyy-MM-dd'));
                    break;
                }
            }
        }

        // $('#repeat-button').css('display','block');
        // If all the days are unavailable then hide the appointments hours.
        if (unavailableDates.length === numberOfDays) {
            $('#availablehourdiv').css('display','none');
            $('#available-hours').text(EALang.no_available_hours);
            $('#available-hours').append('<br>or if you have an urgent issue please do not hesitate to ring or txt me on <a style="font-weight:bold; color:red; display:contents; font-style:italic;" href="tel:0276551300">027-655-1300</a>.')
            $('#repeat-button').css('display','none');
        }

        // Grey out unavailable dates.
        $('#select-date .ui-datepicker-calendar td:not(.ui-datepicker-other-month)').each(function (index, td) {
            selectedDate.set({day: index + 1});
            if ($.inArray(selectedDate.toString('yyyy-MM-dd'), unavailableDates) != -1) {
                $(td).addClass('ui-datepicker-unselectable ui-state-disabled');
            }
        });

        processingUnavailabilities = false;
    }

    /**
     * Save the user's consent.
     *
     * @param {Object} consent Contains user's consents.
     */
    exports.saveConsent = function (consent) {
        var url = GlobalVariables.baseUrl + '/index.php/consents/ajax_save_consent';
        var data = {
            csrfToken: GlobalVariables.csrfToken,
            consent: consent
        };

        $.post(url, data, function (response) {
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }
        }, 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Delete personal information.
     *
     * @param {Number} customerToken Customer unique token.
     */
    exports.deletePersonalInformation = function (customerToken) {
        var url = GlobalVariables.baseUrl + '/index.php/privacy/ajax_delete_personal_information';
        var data = {
            csrfToken: GlobalVariables.csrfToken,
            customer_token: customerToken
        };

        $.post(url, data, function (response) {
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }

            location.href = GlobalVariables.baseUrl;
        }, 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

})(window.FrontendBookApi);



