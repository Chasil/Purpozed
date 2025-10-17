(function ($) {

    $(function () {

        /*
         * SAVE ORGANIZATION SETTINGS
         */

        $('.save-organization-settings').on('click', function () {

            clearErrors();
            var step = $(this);
            var status = [];
            var checked = 0;

            $('input, textarea').each(function () {
                var validation = $(this).data('validation');
                var data = $(this).val();


                if (validation == 'organization_name') {
                    if (organizationName(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'street') {
                    if (organizationName(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'zip') {
                    if (cannotBeEmpty(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'city') {
                    if (lettersAndNumbers(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'website') {
                    if (validURL(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'about') {
                    if (cannotBeEmpty(data) != true || maxChars(data, 500) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'password') {
                    if (data.length > 0) {
                        if (password(data) != true) {
                            inputColorError($(this));
                            showError($(this));
                            status.push(false);
                        }
                    }
                }

                if (validation == 'passwords_match') {
                    var password_a = ($('input[name="password"]')).val();
                    var password_repeat = ($('input[name="repeat_password"]')).val();
                    if (passwordsMatch(password_a, password_repeat) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
            });

            $('.some-goals').each(function () {
                if ($(this).is(':checked')) {
                    checked += 1;
                }
            });

            if (checked < 1) {
                $('.goal-error').show();
                status.push(false);
            }

            if ($('.main-goal:checked').length < 1) {
                $('.main-goal-error').show();
                status.push(false);
            }

            if (status.includes(false)) {
                return;
            } else {
                $('.form-save-organization-settings').submit();
            }
        });

        /*
       *
       * REGISTER - VOLUNTEER
       *
       */


        $('.next.info').on('click', function () {

            clearErrors();
            var step = $(this);

            var status = [];
            $('input').each(function () {
                var validation = $(this).data('validation');
                var data = $(this).val();


                if (validation == 'title') {
                    if (title(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'forename') {
                    if (forname(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'surname') {
                    if (surname(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'phone') {
                    if (phone(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'company_id') {
                    if (companyId(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'email') {
                    if (email(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'password') {
                    if (password(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'passwords_match') {
                    var password_a = ($('input[name="password"]')).val();
                    var password_repeat = ($('input[name="repeat_password"]')).val();
                    if (passwordsMatch(password_a, password_repeat) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

            });

            if (status.includes(false)) {
                return;
            } else {
                loadStep(step);
            }
        });

        $('.next.goals').on('click', function () {

            clearErrors();
            var step = $(this);
            var status = false;
            var checked = 0;

            $('input[type="checkbox"]').each(function () {
                if ($(this).is(':checked')) {
                    checked += 1;
                }
            });
            if (checked < 3) {
                $(this).closest('.section').find('.error-box').show();
                status = false;
            } else {
                status = true;
            }

            if (status == false) {
                return;
            } else {
                loadStep(step);
            }
        });

        $('form.register').on('submit', function () {

            clearErrors();
            var step = $('.section.skills .next.skills');
            var status = [];
            var checked = $('.skills-checkboxes:checked').length;

            if (checked < 3) {
                $(this).find('.section.skills .error-box').show();
                status.push(false);
            }

            if ($('#terms-id:checked').length < 1) {
                $('#terms-id').parent().find('.error-box').show();
                status.push(false);
            }

            if (status.includes(false)) {
                return false;
            } else {
                loadStep(step);
            }
        });


        /*
         * REGISTER COMPANY
         */

        $('.next.organization').on('click', function () {

            clearErrors();
            var step = $(this);
            var status = [];

            $('input, textarea').each(function () {
                var validation = $(this).data('validation');
                var data = $(this).val();


                if (validation == 'organization_name') {
                    if (organizationName(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'street') {
                    if (organizationName(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'zip') {
                    if (cannotBeEmpty(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'city') {
                    if (lettersAndNumbers(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'website') {
                    if (validURL(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'about') {
                    if (cannotBeEmpty(data) != true || maxChars(data, 500) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
            });

            if (status.includes(false)) {
                return;
            } else {
                loadStep(step);
            }
        });

        var checkedGoal = $('.edit-profie.organization-profile .some-goals:checked');
        if (checkedGoal) {
            checkedGoal.closest('.goal-row').find('input[name="main_goal"]').removeAttr('disabled');
        }

        $('.some-goals').on('click', function () {
            var id = $(this).data('id');
            var currChexbox = $(this);

            if (currChexbox.is(':checked')) {
                currChexbox.closest('.goal-row').find('input[name="main_goal"]').removeAttr('disabled');
            } else {
                currChexbox.closest('.goal-row').find('input[name="main_goal"]').attr('disabled', 'disabled');
            }
            var currRadio = currChexbox.closest('.goal-row').find('input[name="main_goal"]:checked').val();

            if (id = currRadio) {
                currChexbox.closest('.goal-row').find('input[name="main_goal"]').prop('checked', false);
            }
        });

        $('.next.organization-goals, .edit-profie.organization-profile.validate-it button[type="submit"]').on('click', function () {

            clearErrors();
            var step = $(this);
            var status = [];

            if ($('.main-goal:checked').length < 1) {
                $('.main-goal-error').show();
                status.push(false);
            }

            if ($('.some-goals:checked').length < 1) {
                $('.goal-error').show();
                status.push(false);
            }

            if (status.includes(false)) {
                return false;
            } else {
                loadStep(step);
            }
        });

        $('form.register-organization').on('submit', function () {

            clearErrors();
            var step = $(this);
            var status = [];

            $('input, textarea').each(function () {
                var validation = $(this).data('validation');
                var data = $(this).val();


                if (validation == 'forename') {
                    if (forname(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'surname') {
                    if (surname(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'title') {
                    if (title(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'phone') {
                    if (phone(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'email') {
                    if (email(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'password') {
                    if (password(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'passwords_match') {
                    var password_a = ($('input[name="password"]')).val();
                    var password_repeat = ($('input[name="repeat_password"]')).val();
                    if (passwordsMatch(password_a, password_repeat) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
            });

            if ($('#terms-id:checked').length < 1) {
                $('#terms-id').parent().find('.error-box').show();
                status.push(false);
            }

            if (status.includes(false)) {
                return false;
            } else {
                loadStep(step);
            }
        });


        /*
       *
       * GO NEXT SECTION
       *
       */


        $('.step-button.prev').on('click', function () {
            $(this).closest('.section').hide();
            $(this).closest('.section').prev().show();
            $('.hidden-data').empty();

            var prev = $(this).closest('.register').find('.row.steps .step-point.active');
            $(this).closest('.register').find('.row.steps .step-point.active').prev().prev().addClass('active');
            prev.removeClass('active');
            window.scrollTo(0, 0);
        });

        $("#datepicker").datepicker({
            minDate: "+1"
        });

    });
}(jQuery));