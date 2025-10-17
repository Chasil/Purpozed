(function ($) {
    $(function () {

        $('.post-items .post-item .next').on('click', function () {
            $(this).closest('.post-item').hide();
            $(this).closest('.post-item').next().show();
        });

        $('.post-items .post-item .back').on('click', function () {
            $(this).closest('.post-item').hide();
            $(this).closest('.post-item').prev().show();
        });

        $('.next.topic').on('click', function () {
            clearErrors();
        });

        $('.select-menu').on('change', function () {
            var option = $(this).val();
            window.location = option;
        });

        /*
         * PROJECT - PREVIEW
         */

        $('.project.contact').on('click', function () {

            var topic = $('input[name="topic"]:checked').data('topic');

            $('.prev-header').text(topic);

            $('.prev-benefits').text($('textarea[name="details"]').val());

            // Load topic skills and duration
            var topic_id = $('input[name="topic"]:checked').val();

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'getTopicDetails',
                    topic_id: topic_id
                },
                success: function (response) {
                    var days_duration, hours_duration;
                    var skills = '';
                    var skills_hidden = '';
                    $.each(response.topicData, function (key, values) {
                        days_duration = values.days_duration;
                        hours_duration = values.hours_duration;
                        $.each(values.skills, function (key, skill) {
                            skills += '<div class="single-skill">' + skill.skill_name + '</div>';
                            skills_hidden += '<input type="hidden" name="skills[]" value="' + skill.skill_id + '"></div>';
                        });
                    });

                    $('.prev-skills').html(skills);
                    $('.prev-duration').text(objectL10n.hours + hours_duration);
                    $('.prev-description').text($('#brief-description').text());
                    $('.prev-benefits').text($('textarea[name="benefits"]').val());
                    $('.prev-details').text($('textarea[name="details"]').val());
                    $('.hidden-data').append(skills_hidden);
                }
            });
        });

        /*
         * CALL - PREVIEW
         */

        $('.call.contact').on('click', function () {
            var topic = $('input[name="topic"]:checked').data('topic');
            var focus = '';
            $('input[name="focus[]"]:checked').each(function () {
                focus += $(this).data('focus') + ' + ';
            });

            focus = focus.slice(0, -3);

            $('.prev-header').text(focus + ': ' + topic);
            $('.prev-focus').text(focus);

            $('.prev-goal').text($('textarea[name="goal"]').val());

            // Load topic skills and duration
            var topic_id = $('input[name="topic"]:checked').val();

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'getTopicDetails',
                    topic_id: topic_id
                },
                success: function (response) {
                    var days_duration, hours_duration;
                    var skills = '';
                    var skills_hidden = '';
                    $.each(response.topicData, function (key, values) {
                        days_duration = values.days_duration;
                        hours_duration = values.hours_duration;
                        $.each(values.skills, function (key, skill) {
                            skills += '<div class="single-skill">' + skill.skill_name + '</div>';
                            skills_hidden += '<input type="hidden" name="skills[]" value="' + skill.skill_id + '"></div>';
                        });
                    });

                    $('.prev-skills').html(skills);
                    $('.hidden-data').append(skills_hidden);
                    $('.prev-description').text($('#brief-description').text());
                }
            });
        });

        /*
         * CALL - LOAD TOPICS
         */
        $('.expertises .single-expertise.call').on('click', function () {

            $('.expertises .single-expertise').removeClass('active');
            $(this).addClass('active');

            var aoe_id = $(this).data('aoe');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'loadTopics',
                    aoe_id: aoe_id
                },
                success: function (response) {
                    var table = '';
                    $.each(response.topics, function (key, values) {
                        table += '<div class="single-topic" data-topic="' + values.call_id + '">'
                            + '<input type="radio" id="topic_' + values.call_id + '" name="topic" value="' + values.call_id + '" data-topic="' + values.call_name + '">'
                            + '<label for="topic_' + values.call_id + '">' + values.call_name + ' </label>'
                            + '</div>';
                    });
                    $('.topics').html(table);
                }
            });
        });

        /*
         * CALL/PROJECT - LOAD TOPIC DESCRIPTION
         */
        $(document).on('click', '.topics input[name="topic"]', function () {

            var topic_id = $(this).val();

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'loadTopicDescription',
                    topic_id: topic_id
                },
                success: function (response) {
                    $('#brief-description').text(response[0].call_description);
                }
            });
        });

        /*
         * PROJECT - LOAD TOPICS
         */
        $('.expertises .single-expertise.project').on('click', function () {

            $('.expertises .single-expertise').removeClass('active');
            $(this).addClass('active');

            var aoe_id = $(this).data('aoe');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'loadProjectTasks',
                    aoe_id: aoe_id
                },
                success: function (response) {
                    var table = '';
                    $.each(response.topics, function (key, values) {
                        console.log(values);
                        table += '<div class="single-topic" data-topic="' + values.task_id + '">'
                            + '<input type="radio" id="topic_' + values.task_id + '" name="topic" value="' + values.task_id + '" data-topic="' + values.task_name + '">'
                            + '<label for="topic_' + values.task_id + '">' + values.task_name + ' </label>'
                            + '</div>';
                    });
                    $('.topics').html(table);
                }
            });
        });

        /*
         * VALIDATE VOLUNTEER SETTINGS
         */

        $('#save-settings').on('click', function (e) {

            e.preventDefault();

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

                if (validation == 'url') {
                    if (validURL(data) != true) {
                        inputColorError($(this));
                        showError2($(this));
                        status.push(false);
                    }
                }

                if (validation == 'password') {
                    if (password2(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

                if (validation == 'passwords_match') {
                    var password_a = ($('input[name="password"]')).val();
                    var password_repeat = ($('input[name="repeat_password"]')).val();
                    if (passwordsMatch2(password_a, password_repeat) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

            });


            var checkedSkills = $('.skills-checkboxes:checked').length;

            if (checkedSkills < 3) {
                $('.error-box.extra.skills').show();
                status.push(false);
            }

            var checkedGoals = $('.skills-checkboxes:checked').length;

            if (checkedGoals < 3) {
                $('.error-box.extra.goals').show();
                status.push(false);
            }

            if (status.includes(false)) {
                return;
            } else {
                $('#volunteers-settings-form').submit();
            }

        });

        /*
         * CALL VALIDATE STEPS
         */

        $('input[name="topic"]').change(function () {
            $('input[name="topic_typed"]').val('');
        });

        $('input[name="topic_typed"]').change(function () {
            $('input[name="topic"]').prop("checked", false)
        });

        $('.next.call-topic').on('click', function () {

            clearErrors();
            var step = $(this);
            var status = [];

            $('input[name="topic_typed"]').each(function () {
                var validation = $(this).data('validation');
                var data = $(this).val();

                if (validation == 'topic_typed') {
                    if (maxChars(data, 30) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }

            });

            var topics_checked = $('input[name="topic"]:checked').length;

            if (topics_checked < 1) {
                var extra = $('input[name="topic_typed"]').val();
                if (extra.length > 1) {
                    status.push(true);
                } else {
                    $('.aoe-items .error-box').show();
                    status.push(false);
                }
            } else {
                status.push(true);
            }

            if (status.includes(false)) {
                return;
            } else {
                loadStep(step);
            }
        });

        $('.next.call-goal').on('click', function () {

            clearErrors();
            var step = $(this);
            var status = [];

            var focus_checked = $('input[name="focus[]"]:checked').length;

            if (focus_checked < 1) {
                $('.focus-items .error-box').show();
                status.push(false);
            } else {
                status.push(true);
            }

            var main_goal = $('textarea[name="goal"]').val().length;

            if (main_goal < 1) {
                $('.opportunity-textarea .error-box').show();
                status.push(false);
            } else {
                status.push(true);
            }

            if (maxChars($('textarea[name="goal"]').val(), 600) != true) {
                inputColorError($(this));
                $('.textarea-items > .error-box').show();
                status.push(false);
            }

            if (status.includes(false)) {
                return;
            } else {
                loadStep(step);
            }
        });

        $('.next.project-task').on('click', function () {

            clearErrors();
            var step = $(this);
            var status = [];

            $('textarea').each(function () {
                var validation = $(this).data('validation');
                var data = $(this).val();

                if (validation == 'benefits') {
                    if (maxChars(data, 600) != true || cannotBeEmpty(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
            });

            var aoe_checked = $('input[name="topic"]:checked').length;

            if (aoe_checked < 1) {
                $('.aoe-items .error-box').show();
                status.push(false);
            } else {
                status.push(true);
            }

            if (status.includes(false)) {
                return;
            } else {
                loadStep(step);
            }
        });


        $('.next.call.contact, .next.project.contact').on('click', function () {

            clearErrors();
            var step = $(this);
            var status = [];

            $('input').each(function () {
                var validation = $(this).data('validation');
                var data = $(this).val();

                if (validation == 'contact_name') {
                    if (forname(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
                if (validation == 'contact_surname') {
                    if (surname(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
                if (validation == 'contact_email') {
                    if (email(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
                if (validation == 'contact_phone') {
                    if (opportunity_phone(data) != true) {
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

        /*
         * AOE VALIDATE STEPS
         */

        $('.next.mentoring-aoe').on('click', function () {

            clearErrors();
            var step = $(this);
            var status = [];

            var validation = $('textarea[name="expectations"]').data('validation');
            var data = $('textarea[name="expectations"]').val();

            if (validation == 'expectations') {
                if (maxChars(data, 600) != true || cannotBeEmpty(data) != true) {
                    inputColorError($('textarea[name="expectations"]'));
                    showError($('textarea[name="expectations"]'));
                    status.push(false);
                }
            }

            var aoe_checked = $('input[name="mentor_area"]:checked').length;

            if (aoe_checked < 1) {
                $('.aoe-items .error-box').show();
                status.push(false);
            } else {
                status.push(true);
            }

            if (status.includes(false)) {
                return;
            } else {
                loadStep(step);
            }
        });

        $('.next.engagement-time').on('click', function () {

            clearErrors();
            var step = $(this);
            loadStep(step);

        });

        var frequency = $('select[name="frequency"]').val();
        var duration = $('select[name="duration"]').val();
        var time_frame = $('select[name="time_frame"]').val();
        var training_duration = $('select[name="training_duration"]').val();

        if (training_duration == undefined) {
            training_duration = 0;
        }

        var hours = frequency * duration * time_frame + parseInt(training_duration);
        $('#curr_hours').text(hours);

        $('.search-mentoring').on('change', function () {

            var frequency = $('select[name="frequency"]').val();
            var duration = $('select[name="duration"]').val();
            var time_frame = $('select[name="time_frame"]').val();

            var hours = frequency * duration * time_frame;
            $('#curr_hours').text(hours);
        });

        $('.search-engagement').on('change', function () {

            var frequency = $('select[name="frequency"]').val();
            var duration = $('select[name="duration"]').val();
            var time_frame = $('select[name="time_frame"]').val();
            var training_duration = $('select[name="training_duration"]').val();

            var hours = frequency * duration * time_frame + parseInt(training_duration);
            var hoursPlural = objectL10n.hour;
            if (hours > 1) {
                hoursPlural = objectL10n.hours;
            }
            $('#curr_hours').text(hours + hoursPlural);
            $('#curr_hours').next().text('');
        });

        $('.next.mentoring-time').on('click', function () {

            clearErrors();
            var step = $(this);
            loadStep(step);

        });

        $('.mentoring.contact').on('click', function () {

            clearErrors();
            var step = $(this);
            var status = [];

            $('input').each(function () {
                var validation = $(this).data('validation');
                var data = $(this).val();

                if (validation == 'contact_name') {
                    if (forname(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
                if (validation == 'contact_surname') {
                    if (surname(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
                if (validation == 'contact_email') {
                    if (email(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
                if (validation == 'contact_phone') {
                    if (opportunity_phone(data) != true) {
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

                var aoe = $('input[name="mentor_area"]:checked').data('aoe');
                $('.prev-header span').html(aoe);
                $('.prev-skills .single-skill').text(aoe);
                $('.prev-expectations').text($('textarea[name="expectations"]').val());
                $('.prev-at-least span').html($('#curr_hours').text() + objectL10n.hours);
                $('.prev-frequency span').html($('select[name="frequency"] option:selected').text());
                $('.prev-duration span').html($('select[name="duration"] option:selected').text());
                $('.prev-time-frame span').html($('select[name="time_frame"] option:selected').text());
            }
        });

        /*
         * ENGAGEMENT
         */

        $('.next.engagement-task').on('click', function () {

            clearErrors();
            var step = $(this);
            var status = [];

            $(this).closest('.section').find('input, textarea').each(function () {
                var validation = $(this).data('validation');
                var data = $(this).val();

                if (validation == 'title') {
                    if (maxChars(data, 100) != true || cannotBeEmpty(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
                if (validation == 'why') {
                    if (maxChars(data, 600) != true || cannotBeEmpty(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
                if (validation == 'task') {
                    if (maxChars(data, 600) != true || cannotBeEmpty(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
                if (validation == 'requirements') {
                    if (maxChars(data, 200) != true || cannotBeEmpty(data) != true) {
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

        $('.engagement.contact').on('click', function () {

            clearErrors();
            var step = $(this);
            var status = [];

            $('input').each(function () {
                var validation = $(this).data('validation');
                var data = $(this).val();

                if (validation == 'contact_name') {
                    if (forname(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
                if (validation == 'contact_surname') {
                    if (surname(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
                if (validation == 'contact_email') {
                    if (email(data) != true) {
                        inputColorError($(this));
                        showError($(this));
                        status.push(false);
                    }
                }
                if (validation == 'contact_phone') {
                    if (opportunity_phone(data) != true) {
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

                $('.prev-header').text($('input[name="title"]').val());
                $('.prev-why').text($('textarea[name="why"]').val());
                $('.prev-task').text($('textarea[name="task"]').val());
                $('.prev-at-least span').text($('#curr_hours').text());
                $('.prev-requirements').text($('textarea[name="requirements"]').val());
                $('.prev-frequency span').html($('select[name="frequency"] option:selected').text());
                $('.prev-duration span').html($('select[name="duration"] option:selected').text());
                $('.prev-time-frame span').html($('select[name="time_frame"] option:selected').text());
                $('.prev-duration-of-training span').html($('select[name="training_duration"] option:selected').text());
                $('.prev-volunteers').html($('input[name="volunteers_needed"]').val());
            }
        });

        /*
         * UPLOAD IKONY
         */

        $('#file-input').on('change', function () { //on file input change
            if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
            {
                $('#thumb-output').html(''); //clear html of output element
                var data = $(this)[0].files; //this file data

                $.each(data, function (index, file) { //loop though each file
                    if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) { //check supported file type
                        var fRead = new FileReader(); //new filereader
                        fRead.onload = (function (file) { //trigger function on successful read
                            return function (e) {
                                var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element
                                $('#thumb-output').append(img); //append image to output element
                            };
                        })(file);
                        fRead.readAsDataURL(file); //URL representing the file's data.
                    }
                });

            } else {
                alert("Your browser doesn't support File API!"); //if File API is absent
            }
        });


        $('.filters-item.clear').on('click', function () {
            $('.single-option input[type="checkbox"]').prop('checked', false);
            $('#distance .single-option').remove();
            $('.filter_counter').empty();
            $('#filtering_form').submit();
        });

        $('.search-item').on('click', function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                $('.search-item').removeClass('active');
                $(this).addClass('active');
            }
        });

        $('body').on('click', function (event) {
            if ($(event.target).closest('.search-item').length == 0) {
                $(".search-item").removeClass('active');
            }
        });

        $('.show-more').on('click', function () {
            $('.opportunity-box').removeClass('hidden');
            $('.show-more').hide();
        });

        /*
         * MENU
         */

        $('.select-option').on('click', function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                $('.select-option').removeClass('active');
                $(this).addClass('active');
            }
        });

        $('body').on('click', function (event) {
            if ($(event.target).closest('.select-option').length == 0) {
                $(".select-option").removeClass('active');
            }
        });

        /*
         * przełączanie opcji w settings
         */
        $('#profile_info').on('click', function () {
            $('.section').addClass('hidden');
            $('#profile_info_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });
        $('#goals_and_skills').on('click', function () {
            $('.section').addClass('hidden');
            $('#goals_and_skills_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });
        $('#experience').on('click', function () {
            $('.section').addClass('hidden');
            $('#experience_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });
        $('#account').on('click', function () {
            $('.section').addClass('hidden');
            $('#account_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });

        /*
         * przełączanie opcji w organization dashboard
         */
        $('#open').on('click', function () {
            $('.section').addClass('hidden');
            $('#open_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });
        $('#prepared').on('click', function () {
            $('.section').addClass('hidden');
            $('#prepared_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });
        $('#in_progress').on('click', function () {
            $('.section').addClass('hidden');
            $('#in_progress_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });
        $('#completed').on('click', function () {
            $('.section').addClass('hidden');
            $('#completed_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });
        $('#active').on('click', function () {
            $('.section').addClass('hidden');
            $('#active_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });
        $('#inactive').on('click', function () {
            $('.section').addClass('hidden');
            $('#inactive_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });

        /*
         * przełączanie opcji w manage opportunity
         */
        $('#profile_info').on('click', function () {
            $('.section').addClass('hidden');
            $('#profile_info_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });
        $('#pending_applications').on('click', function () {
            $('.section').addClass('hidden');
            $('#pending_applications_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });
        $('#pending_requests').on('click', function () {
            $('.section').addClass('hidden');
            $('#pending_requests_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });
        $('#fitting_volunteers').on('click', function () {
            $('.section').addClass('hidden');
            $('#fitting_volunteers_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });
        $('#engaged_volunteers').on('click', function () {
            $('.section').addClass('hidden');
            $('#engaged_volunteers_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });
        $('#completed').on('click', function () {
            $('.section').addClass('hidden');
            $('#completed_section').removeClass('hidden');
            $('.menu-items .item').removeClass('active');
            $(this).addClass('active');
        });


        $('.modal-close').on('click', function (e) {
            e.preventDefault();
            $(this).closest('.modal.is-visible').toggleClass('is-visible');
        });

        /*
         * ZAPISANIE SIĘ DO OPPORTUNITY
         */

        $('.modal-apply-button').on('click', function () {
            $('.apply-ask').toggleClass('is-visible');

        });

        $('.apply-confirm').on('click', function () {
            var opportunity_id = $(this).data('id');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'applyToOpportunity',
                    opportunity_id: opportunity_id
                },
                success: function (response) {
                    if (response.status == true) {
                        $('.apply-ask').toggleClass('is-visible');
                        $('.apply').toggleClass('is-visible');
                    }
                }
            });
        });

        /*
         * PRZYJĘCIE ZAPROSZENIA PRZEZ VOLUNTEER
         */

        $('.modal-take-over-button').on('click', function () {
            $('.take-over-ask').toggleClass('is-visible');

        });

        $('.take-over-confirm').on('click', function () {
            var opportunity_id = $(this).data('id');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'signVolunteerToOpportunity',
                    opportunity_id: opportunity_id
                },
                success: function (response) {
                    if (response.status == true) {
                        $('.take-over-ask').toggleClass('is-visible');
                        $('.take-over').toggleClass('is-visible');
                    }
                }
            });
        });

        /*
         * USUNIĘCIE OPPORTUNITY Z LISTY - WIDOK KONKRETNEGO OPPORTUNITY
         */

        $('.modal-remove-button').on('click', function () {
            $('.remove-ask').toggleClass('is-visible');

        });

        $('.remove-confirm').on('click', function () {
            var opportunity_id = $(this).data('id');
            var reject = $(this).data('reject');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'removeFromTheList',
                    opportunity_id: opportunity_id,
                    reject: reject
                },
                success: function (response) {
                    if (response.status == true) {
                        $('.remove-ask').toggleClass('is-visible');
                        $('.remove').toggleClass('is-visible');
                    }
                }
            });
        });

        /*
         * USUNIĘCIE OPPORTUNITY Z LISTY - WIDOK KONKRETNEGO OPPORTUNITY
         */

        $('.modal-retract-application-button').on('click', function () {
            $('.retract-application-ask').toggleClass('is-visible');

        });

        $('.retract-application-confirm').on('click', function () {
            var opportunity_id = $(this).data('id');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'removeApplication',
                    opportunity_id: opportunity_id,
                },
                success: function (response) {
                    if (response.status == true) {
                        $('.retract-application-ask').toggleClass('is-visible');
                        $('.retract-application').toggleClass('is-visible');
                    }
                }
            });
        });

        /*
         * ENGAGEMENT - ZAWIESZENIE / WSTRZYMANIE OPPORTUNITY
         */

        $('.modal-close-button-single').on('click', function () {
            $('.close-ask-single').toggleClass('is-visible');

        });

        $('.close-confirm-single').on('click', function () {
            var opportunity_id = $(this).data('id');
            var status = $(this).data('status');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'closeEngagement',
                    opportunity_id: opportunity_id,
                    status: status
                },
                success: function (response) {
                    if (response.status == true) {
                        window.location.reload(true);
                    }
                }
            });
        });

        /*
         * ZAPROSZENIE UŻYTKOWNIKA DO ZADANIA PRZEZ ORGANIZACJĘ
         */
        $('.modal-volunteer-invitation-button').on('click', function () {
            $(this).closest('.single-volunteer').find('.volunteer-invitation-ask').toggleClass('is-visible');
        });

        $('.modal-close').on('click', function () {
            $(this).closest('.modal').removeClass('is-visible');
        });

        $('.volunteer-invitation-confirm').on('click', function () {
            var opportunity_id = $(this).data('id');
            var user_id = $(this).data('user');
            var currentButton = $(this);

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'requestVolunteerToOpportunity',
                    opportunity_id: opportunity_id,
                    user_id: user_id
                },
                success: function (response) {
                    if (response.status == true) {
                        currentButton.closest('.single-volunteer').find('.volunteer-invitation-ask').hide();
                        currentButton.closest('.single-volunteer').find('.volunteer-invitation').toggleClass('is-visible');
                    }
                }
            });
        });

        /*
         * WYCOFANIE ZAPROSZENIA UŻYTKOWNIKA DO ZADANIA PRZEZ ORGANIZACJĘ
         */
        $('.modal-retract-volunteer-button').on('click', function () {
            $(this).closest('.single-volunteer').find('.retract-volunteer-ask').toggleClass('is-visible');
        });

        $('.modal-close').on('click', function () {
            $(this).closest('.modal').removeClass('is-visible');
        });

        $('.retract-volunteer-confirm').on('click', function () {
            var opportunity_id = $(this).data('id');
            var user_id = $(this).data('user');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'retractVolunteer',
                    opportunity_id: opportunity_id,
                    user_id: user_id
                },
                success: function (response) {
                    if (response.status == true) {
                        $('.retract-volunteer-ask').hide();
                        $('.retract-volunteer').toggleClass('is-visible');
                    }
                }
            });
        });

        /*
         * ZATWIERDZENIE VOLUNTEER DO OPPORTUNITY
         */

        $('.modal-select-button').on('click', function () {
            $(this).closest('.single-volunteer').find('.select-ask').toggleClass('is-visible');

        });

        $('.select-confirm').on('click', function () {
            var opportunity_id = $(this).data('id');
            var user_id = $(this).data('user');
            var accept = $(this).data('accept');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'signVolunteerToOpportunity',
                    opportunity_id: opportunity_id,
                    user_id: user_id,
                    accept: accept
                },
                success: function (response) {
                    if (response.status == true) {
                        $('.select-ask').toggleClass('is-visible');
                        $('.select-opportunity').toggleClass('is-visible');
                    }
                }
            });
        });

        /*
         * ODRZUCENIE APLIKUJĄCEGO VOLUNTEER
         */

        $('.modal-reject-button').on('click', function () {
            $(this).closest('.edit').find('.reject-volunteer-ask').toggleClass('is-visible');
        });

        $('.reject-volunteer-confirm').on('click', function () {
            var opportunity_id = $(this).data('id');
            var user_id = $(this).data('user');

            var currentButton = $(this);

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'rejectVolunteer',
                    opportunity_id: opportunity_id,
                    user_id: user_id,
                },
                success: function (response) {
                    if (response.status == true) {
                        currentButton.closest('.edit').find('.reject-volunteer-ask').toggleClass('is-visible');
                        currentButton.closest('.edit').find('.reject-volunteer').toggleClass('is-visible');
                    }
                }
            });
        });

        $('.modal-bookmark-button').on('click', function () {
            $('.bookmark').toggleClass('is-visible');
        });

        $('.save-bookmark').on('click', function () {

            var opportunity_id = $(this).data('id');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'addBookmarkedOpportunity',
                    opportunity_id: opportunity_id
                },
                success: function (response) {
                    if (response.status == true) {
                        $('.bookmark').toggleClass('is-visible');
                        $('.bookmark-added').toggleClass('is-visible');
                    }
                }
            });
        });

        $('.modal-complete-button').on('click', function () {
            $(this).closest('.opportunity-box').find('.complete-ask').addClass('is-visible');
        });

        $('.modal-complete-opportunity-button').on('click', function () {
            $('.complete-opportunity-ask').addClass('is-visible');
        });

        $('.modal-cancel-opportunity-button').on('click', function () {
            $('.cancel-opportunity-ask').addClass('is-visible');
        });

        $('.modal-close').on('click', function () {
            $(this).closest('.modal').removeClass('is-visible');
        });

        $('.save-bookmark').on('click', function () {

            var opportunity_id = $(this).data('id');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'addBookmarkedOpportunity',
                    opportunity_id: opportunity_id
                },
                success: function (response) {
                    if (response.status == true) {
                        $('.bookmark').toggleClass('is-visible');
                        $('.bookmark-added').toggleClass('is-visible');
                    }
                }
            });
        });

        /*
         * EVALUACJA
         */

        $('.modal-evaluate-button').on('click', function (e) {

            $('.evaluation-error').hide();
            $('.error-box.extra').hide();

            var is_checked_exists = $('input[name="confirm_canelation"]').length;

            if (is_checked_exists > 0) {
                var is_checked = $('input[name="confirm_canelation"]').is(':checked');
                if (is_checked == false) {
                    $('input[name="confirm_canelation"]').parent().next().show();
                    e.preventDefault();
                    return;
                }
            }

            var helping_hours_exists = $('input[name="helping_hours"]').length;

            if (helping_hours_exists > 0) {
                var helping_hours = $('input[name="helping_hours"]').val();
                if (helping_hours < 1) {
                    $('input[name="helping_hours"]').parent().next().show();
                    e.preventDefault();
                    return;
                }
            }

            var is_text_filled = $('.evaluation-textarea').val();
            if (is_text_filled.length == 0) {
                $('.evaluation-error').show();
                e.preventDefault();
                return;
            } else {
                $('.evaluate-ask').toggleClass('is-visible');
            }
        });

        $('.evaluate-confirm').on('click', function () {
            var opportunity_id = $(this).data('id');
            var text = $('.evaluation-textarea:not([readonly])').val();
            var hours = 0;
            if ($('input[name="helping_hours"]:not([readonly])') !== 'undefined') {
                hours = $('input[name="helping_hours"]:not([readonly])').val();
            }
            var type_of = $(this).data('type');
            var userId = $(this).data('user');

            var collaboration = $('input[name="collaboration_disagree"]').is(':checked');
            var hours_disagree = $('input[name="hours_disagree"]').is(':checked');

            var is_collaborated = $('input[name="collaboration_disagree"]').length;

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'evaluateOpportunityVolunteer',
                    opportunity_id: opportunity_id,
                    text: text,
                    hours: hours,
                    type: type_of,
                    user_id: userId,
                    collaboration: collaboration,
                    hours_disagree: hours_disagree
                },
                success: function (response) {
                    if (response.status == true) {

                        window.scrollTo(0, 0);

                        if (is_collaborated > 0 || hours_disagree > 0) {
                            if ($('input[name="collaboration_disagree"]').is(':checked') || $('input[name="hours_disagree"]').is(':checked')) {
                                $('.modal.evaluate').find('.show_complain').removeClass('hidden');
                            }
                        }

                        $('.evaluate-ask').toggleClass('is-visible');
                        $('.evaluate').toggleClass('is-visible');
                    }
                }
            });
        });

        /*
         * CANCEL PREMATURELY VOLUNTEER
         */

        $('.modal-cancel-prematurely-button').on('click', function (e) {
            var opportunity_id = $(this).data('id');
            var canceled_by = $(this).data('type');
            var text = $('.evaluation-textarea').val();
            var userId = $(this).data('user');
            var alreadyCanceled = $(this).data('cancel');
            var complain = $('input[name="complain_cancelation"]').is(':checked');
            var collaboration = $('input[name="collaboration_disagree"]').is(':checked');
            var opportunityName = $('.medium-header.prev-header').text();

            $('.evaluation-error').hide();
            $('.error-box.extra').hide();

            var is_checked_exists = $('input[name="confirm_canelation"]').length;

            if (is_checked_exists > 0) {
                var is_checked = $('input[name="confirm_canelation"]').is(':checked');
                if (is_checked == false) {
                    $('input[name="confirm_canelation"]').parent().next().show();
                    e.preventDefault();
                    return;
                }
            }

            var is_text_filled = $('.evaluation-textarea').val();
            if (is_text_filled.length == 0) {
                $('.evaluation-error').show();
                e.preventDefault();
                return;
            }

            var is_collaborated = $('input[name="complain_cancelation"]').length;
            var collaboration_disagree = $('input[name="collaboration_disagree"]').length;

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'evaluateOpportunityVolunteer',
                    opportunity_id: opportunity_id,
                    text: text,
                    cancel: true,
                    canceled_by: canceled_by,
                    user_id: userId,
                    already_canceled: alreadyCanceled,
                    complain: complain,
                    collaboration: collaboration,
                    opportunityName: opportunityName
                },
                success: function (response) {
                    if (response.status == true) {

                        window.scrollTo(0, 0);

                        console.log(collaboration_disagree);

                        if (is_collaborated > 0 || collaboration_disagree > 0) {
                            // if ($('input[name="complain_cancelation"]').is(':checked')) {
                            $('.modal.cancel-prematurely').find('.show_complain').removeClass('hidden');
                            // }
                        }

                        if ($('input[name="complain_cancelation"]').is(':checked')) {
                            $('.show_complain').removeClass('hidden');
                        }
                        $('.cancel-prematurely').toggleClass('is-visible');
                    }
                }
            });
        });

        /*
         * REMIND ORGANIZATION ABOUT EVALUATION
         */

        $('.modal-send-reminder-button').on('click', function () {
            var opportunity_id = $(this).data('id');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'remindOrganizationAboutEvaluation',
                    opportunity_id: opportunity_id,
                },
                success: function (response) {
                    if (response.status == true) {
                        $('.send-reminder').toggleClass('is-visible');
                    }
                }
            });
        });

        /*
         * USUNIĘCIE KONTA UŻYTKOWNIKA
         */

        $('.delete-account-button').on('click', function () {
            $(this).closest('.register-item').find('.delete-account-ask').toggleClass('is-visible');
        });

        $('.delete-account-confirm').on('click', function () {
            var user_id = $(this).data('user');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'deleteUserAccount',
                    user_id: user_id,
                },
                success: function (response) {
                    if (response.status == true) {
                        window.location = '/';
                    }
                }
            });
        });

        /*
         * USUNIĘCIE OPPORTUNITY - DASHBOARD - ORGANIZATION
         */

        $('.modal-delete-opportunity-button').on('click', function () {
            $(this).closest('.column').find('.delete-opportunity-ask').toggleClass('is-visible');
        });

        $('.delete-opportunity-confirm').on('click', function () {
            var opportunity_id = $(this).data('id');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'deleteOpportunity',
                    opportunity_id: opportunity_id,
                },
                success: function (response) {
                    if (response.status == true) {
                        $('.delete-opportunity-ask').toggleClass('is-visible');
                        $('.delete-opportunity').toggleClass('is-visible');
                    }
                }
            });
        });

        /*
         * USUNIĘCIE OPPORTUNITY - ORGANIZACJA - POJEDYNCZE
         */

        $('.modal-delete-opportunity-single-button').on('click', function () {
            $('.delete-opportunity-single-ask').toggleClass('is-visible');
        });

        $('.delete-opportunity-single-confirm').on('click', function () {
            var opportunity_id = $(this).data('id');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'deleteOpportunity',
                    opportunity_id: opportunity_id,
                },
                success: function (response) {
                    if (response.status == true) {
                        $('.delete-opportunity-single-ask').toggleClass('is-visible');
                        $('.delete-opportunity-single').toggleClass('is-visible');
                    }
                }
            });
        });

        /*
         * WYCOFANIE OPPORTUNITY - DASHBOARD
         */

        $('.modal-retract-button').on('click', function () {
            $(this).closest('.details-box').find('.retract-ask').toggleClass('is-visible');
        });

        $('.retract-confirm').on('click', function () {
            var opportunity_id = $(this).data('id');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'retractOpportunity',
                    opportunity_id: opportunity_id,
                },
                success: function (response) {
                    if (response.status == true) {
                        $('#' + opportunity_id).find('.retract-ask').toggleClass('is-visible');
                        $('#' + opportunity_id).find('.retract').toggleClass('is-visible');
                    }
                }
            });
        });

        /*
         * WYCOFANIE OPPORTUNITY - SINGLE OPPORTUNITY
         */

        $('.modal-retract-button-single').on('click', function () {
            $('.retract-ask-single').toggleClass('is-visible');
        });

        $('.retract-confirm-single').on('click', function () {
            var opportunity_id = $(this).data('id');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'retractOpportunity',
                    opportunity_id: opportunity_id,
                },
                success: function (response) {
                    if (response.status == true) {
                        $('.retract-ask-single').toggleClass('is-visible');
                        $('.retract-single').toggleClass('is-visible');
                    }
                }
            });
        });

        $('.reload-page').on('click', function () {
            window.location.reload(true);
        });

        $('.comment-on-cancelation').on('click', function (e) {
            $('.error-box.extra').hide();
            var is_checked = $('input[name="agree_it"]').is(':checked');
            if (is_checked == false) {
                $('.error-box.extra').show();
                e.preventDefault();
            }
        });


        $('.go-dashboard').on('click', function () {
            window.location = '/';
        });

        $('.add_experience').on('click', function () {
            $('#experience_section .add_experience').before('' +
                '<div class="register-item about textarea-items">\n' +
                '                        <label class="text"><textarea name="experiences[]" data-validation="about"></textarea>\n' +
                '                            <div class="error-box"><?php _e(\'About must have max 500 characters and can not be empty\', \'purpozed\'); ?></div>\n' +
                '                            <div class="small-text"><?php _e(\'Max. 500 characters\', \'purpozed\'); ?></div>\n' +
                '                        </label>\n' +
                '                        <div class="add_rounded_button remove delete_experience"><span>-</span></div>\n' +
                '                    </div>')
        });

        $(document).on('click', '.delete_experience', function () {
            $(this).closest('.textarea-items').remove();
        });

        $('.add_social_media').on('click', function () {
            var count = $('.social_media .register-item').last().find('.input_and_button input').data('link');
            if (count === 'undefined') {
                count = 0;
            } else {
                count += 1;
            }
            $('.add_rounded_button.add_social_media').before(
                '<div class="register-item">' +
                '<label class="text">' +
                '<span>' + objectL10n.url + '</span>' +
                '<div class="input_and_button">' +
                '<input placeholder="Full link including https://" type="text" name="links[' + count + '][url]" value="" data-link="' + count + '">' +
                '<div class="remove_social_media_button delete_social_media_link"></div>' +
                '</div>' +
                '</label>' +
                '<label class="text">' +
                '<span>' + objectL10n.social_network + '</span>' +
                '<div class="input_and_button">' +
                '<input type="text" name="links[' + count + '][name]" value="" data-link="' + count + '">' +
                '</div>' +
                '</label>' +
                '</div>'
            );
            count++;
        });

        $(document).on('click', '.delete_social_media_link', function () {
            $(this).closest('.register-item').remove();
        });

        $('.modal-email-button-2').on('click', function () {
            $(this).closest('.buttons').find('.email').addClass('is-visible');
        });

        $('.modal-email-button').on('click', function () {
            $('.email').addClass('is-visible');
        });

        $('.modal-email-button-3').on('click', function () {
            $('.email').addClass('is-visible');
        });

        $('.modal-email-button-4').on('click', function () {
            $('.email-4').addClass('is-visible');
        });

        $('.modal-email-button-5').on('click', function () {
            $('.email-5').addClass('is-visible');
        });


        $('.organization-dashboard .modal-close').on('click', function () {
            $(this).closest('.is-visible').removeClass('is-visible');
        });

        $('.find-opportunity .more-button').on('click', function () {
            $('.single-opportunity.hidden').removeClass('hidden');
        });

        var form = $('#post-opportunity');

        if (form.length > 0) {
            $(window).bind("pageshow", function () {
                var form = $('#post-opportunity')[0];
                form.reset();
            });
        }

        $('#request').on('click', function () {
            var status = $(this).is(':checked');
            if (status == true) {
                $('.dot').show();

                var frequency = $('select[name="frequency"]').val();
                var duration = $('select[name="duration"]').val();
                var time_frame = $('select[name="time_frame"]').val();
                var training_duration = $('select[name="training_duration"]').val();

                if (training_duration == undefined) {
                    training_duration = 0;
                }

                var hours = frequency * duration * time_frame + parseInt(training_duration);
                $('#curr_hours').text(hours);

            } else {
                $('.dot').hide();

                $('select[name="training_duration"]').val($('select[name="training_duration"] option:first').val());

                var frequency = $('select[name="frequency"]').val();
                var duration = $('select[name="duration"]').val();
                var time_frame = $('select[name="time_frame"]').val();
                var training_duration = 0;

                var hours = frequency * duration * time_frame + parseInt(training_duration);
                $('#curr_hours').text(hours);
            }
        });

        $('.show-more-skills').on('click', function () {
            $(this).closest('.single-skills').find('.tooltip-skills').toggleClass('show-tooltip');
        });

        $('.show-more-evaluation-button').on('click', function () {
            $(this).next().toggleClass('show-more-evaluation-content');
        });

        $('.charNum').keyup(function () {
            var max = $(this).data('max');
            var len = $(this).val().length;
            if (len >= max) {
                var char = max - len;
                $(this).closest('.textarea-items').find('.counter').text(char + '/' + max);
            } else {
                var char = max - len;
                $(this).closest('.textarea-items').find('.counter').text(char + '/' + max);
            }
        });

        $('.more-info-header').on('click', function () {
            $(this).next().toggleClass('hideItem');
            $(this).find('span img').toggleClass('rotate180');
            $('.find-opportunity .filters-controlls.current-amount').toggleClass('margin-top-100');
        });

        $('input[name="filter-type"]').on('click', function () {
            $('#filter-types').submit();
        });

        $('#only_my_activities').change(function () {
            let on = $('label[for="only_my_activities"]').hasClass('checked');
            if (on) {
                $(this).parent().addClass('add-switcher-smooth-right');
            } else {
                $(this).parent().addClass('add-switcher-smooth-left');
            }

            if ($('#only_my_activities').is(':checked')) {
                $('#my_activities').submit();
            } else {
                window.location.replace("/find-opportunity/");
            }
        });

        $('.button-on.settings').change(function () {
            let on = $(this).find('label').hasClass('checked');

            if (on) {
                $(this).toggleClass('add-switcher-smooth-left-button');
            } else {
                $(this).toggleClass('add-switcher-smooth-right-button');
            }
        });

        $('#post-opportunity').keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $(document).on('click', '#distance', function () {

            let optionsAvaible = $('#distance .single-option');

            if (optionsAvaible.length === 0) {

                $("#overlay").fadeIn(300);

                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: ajax_object.ajax_url,
                    data: {
                        action: 'getDistances'
                    },
                    success: function (response) {

                        let html = '';

                        $("#overlay").fadeOut(300);

                        console.log(1234);
                        console.log(response.distancesItems.distancesList);

                        $.each(response.distancesItems.distancesList, function (key, distance) {

                            console.log(distance);

                            html += '<div class="single-option">\n' +
                                '<input type="radio" name="distance[]" value="' + distance + '" class="distance_radio" id="distance_' + distance + '">\n' +
                                '<label for="distance_' + distance + '" class="radio">' + distance + ' km</label>\n' +
                                '</div>';
                        });

                        $('#distance .options-select').append(html);
                    }
                });
            }
        });

        $('input[name^="goals"]').on('change', function () {

            let countedGoals = $('input[name^="goals"]:checked').length;
            if (countedGoals > 0) {
                $(this).closest('.goals').find('.filter_counter').text('(' + countedGoals + ')');
            } else {
                $(this).closest('.goals').find('.filter_counter').empty();
            }
        });

        $('input[name^="skills"]').on('change', function () {

            let countedSkills = $('input[name^="skills"]:checked').length;
            if (countedSkills > 0) {
                $(this).closest('.skills').find('.filter_counter').text('(' + countedSkills + ')');
            } else {
                $(this).closest('.skills').find('.filter_counter').empty();
            }
        });

        $('input[name^="durations"]').on('change', function () {

            let countedDurations = $('input[name^="durations"]:checked').length;
            if (countedDurations > 0) {
                $(this).closest('.duration').find('.filter_counter').text('(' + countedDurations + ')');
            } else {
                $(this).closest('.duration').find('.filter_counter').empty();
            }
        });

        $(document).on('change', 'input[name^="distance"]', function () {

            let countedDistances = $('input[name^="distance"]:checked').val();

            if (countedDistances > 0) {
                $(this).closest('.distance').find('.filter_counter').text('(' + countedDistances + ' km)');
            } else {
                $(this).closest('.distance').find('.filter_counter').empty();
            }
        });

    });

    /*
     * STICKY MENU
     */

    $(window).load(function () {

        var sections = $('.section');
        var nav = $('.sticky-menu');
        var nav_height = nav.outerHeight();

        $(window).on('scroll', function () {
            var cur_pos = $(this).scrollTop();

            nav.find('a').parent().removeClass('active');
            sections.removeClass('active');

            sections.each(function () {
                var top = $(this).offset().top - nav_height,
                    bottom = top + $(this).outerHeight();

                if (cur_pos >= top && cur_pos <= bottom) {

                    $(this).addClass('active');
                    nav.find('a[href="#' + $(this).attr('id') + '"]').parent().addClass('active');
                }
            });
        });

        nav.find('a').on('click', function () {
            var $el = $(this)
                , id = $el.attr('href');

            $('html, body').animate({
                scrollTop: $(id).offset().top - nav_height
            }, 500);

            return false;
        });
    });

    /*
     * END STICKY MENU
     */


}(jQuery));