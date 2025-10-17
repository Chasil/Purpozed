(function ($) {
    $(function () {

        $('.add-expertise:not(.add-button)').on('click', function () {
            $('.expertise-input').toggleClass('show-input', 1500);
            $('.add-expertise').toggleClass('turn-to-minus', 1500);
        });

        $('.modal-task-topic').on('click', function (e) {
            e.preventDefault();
            $('.task-topic').toggleClass('is-visible');
        });

        $('.modal-expertises').on('click', function (e) {
            e.preventDefault();
            $('.expertises').toggleClass('is-visible');
        });

        $('.modal-close').on('click', function (e) {
            e.preventDefault();
            $(this).closest('.modal.is-visible').toggleClass('is-visible');
        });

        $('.modal-edit-button').on('click', function (e) {
            e.preventDefault();
            $('.edit').toggleClass('is-visible');
        });

        $('.modal-delete-button').on('click', function (e) {
            e.preventDefault();
            $('.delete').toggleClass('is-visible');
        });

        $('.modal-edit-button, .modal-delete-button').on('click', function () {
            var itemId = $(this).data('id');
            var itemValue = $(this).closest('.row').find('.name').text();
            var itemTask = $(this).data('task');

            $('.save-edit, .delete-edit').attr('data-id', itemId);
            $('.save-edit, .delete-edit').attr('data-task', itemTask);
            $('input[name="item-name"]').attr('data-name', itemValue);
            $('input[name="item-name"]').val(itemValue);
        });

        $('.save-task').on('click', function () {

            var skills_checked = $('.skill-checkbox:checked').length;

            if (skills_checked < 1) {
                $('.checkboxes .error-box').show();
                event.preventDefault();
            }

            var aoe_checked = $('.aoe_radio:checked').length;

            if (aoe_checked < 1) {
                $('.aoe .error-box').show();
                event.preventDefault();
            }

            if ($('.name').val().length < 1) {
                $('.name-box .error-box').show();
                event.preventDefault();
            }
        });

        $('.search-type').on('change', function () {
            $(this).closest('form').submit();
        });

        $('.save-edit, .delete-edit').on('click', function () {

            var itemTable = $(this).data('table');
            var itemId = $(this).data('id');
            var itemTask = $(this).data('task');
            var itemName = $(this).parent().find('input[name="item-name"]').val();

            $.ajax({
                type: 'post',
                url: ajax_object.ajax_url,
                dataType: 'json',
                data: {
                    action: 'saveItemEdit',
                    itemTable: itemTable,
                    itemId: itemId,
                    itemName: itemName,
                    itemTask: itemTask
                },
                success: function (response) {
                    $('.edit, .delete').hide();
                    if (response) {
                        $('.success').toggleClass('is-visible');
                        $('.modal-close').on('click', function () {
                            window.location.reload(true);
                        });
                    } else {
                        $('.fail').toggleClass('is-visible');
                        $('.modal-close').on('click', function () {
                            window.location.reload(true);
                        });
                    }

                }
            })
        });

        /*
         * UPLOAD IKONY W GOALS
         */

        if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
            $('.set_custom_images').on('click', function (e) {
                e.preventDefault();
                var button = $(this)
                var id = button.prev();
                wp.media.editor.send.attachment = function (props, attachment) {
                    id.val(attachment.id);
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: ajax_object.ajax_url,
                        data: {
                            action: 'loadImage',
                            image_id: attachment.id
                        },
                        success: function (response) {
                            button.closest('.row.expertises').find('.uploaded-image').remove();
                            button.closest('.row.expertises').append('<div class="uploaded-image"><img src="' + response.image_url + '"></div>')
                        }
                    });
                };
                wp.media.editor.open(button);
                return false;
            });
        }

        /*
         * UPLOAD IKONY W OPPORTUNITY
         */

        if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
            $('.set_custom_opportunity_image').on('click', function (e) {
                e.preventDefault();
                var button = $(this);
                var id = button.prev();
                wp.media.editor.send.attachment = function (props, attachment) {
                    id.val(attachment.id);
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: ajax_object.ajax_url,
                        data: {
                            action: 'loadImage',
                            image_id: attachment.id
                        },
                        success: function (response) {
                            button.closest('.section.preview').find('.uploaded-image').remove();
                            button.closest('.section.preview .upload-image').prepend('<div class="uploaded-image"><img src="' + response.image_url + '"></div>');
                        }
                    });
                };
                wp.media.editor.open(button);
                return false;
            });
        }

        $('.filters-item.clear').on('click', function () {
            $('.single-option input[type="checkbox"]').prop('checked', false);
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
         * UPLOAD IKONY
         */

        // $('#file-input').on('change', function () { //on file input change
        //     if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        //     {
        //         $('#thumb-output').html(''); //clear html of output element
        //         var data = $(this)[0].files; //this file data
        //
        //         $.each(data, function (index, file) { //loop though each file
        //             if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) { //check supported file type
        //                 var fRead = new FileReader(); //new filereader
        //                 fRead.onload = (function (file) { //trigger function on successful read
        //                     return function (e) {
        //                         var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element
        //                         $('#thumb-output').append(img); //append image to output element
        //                     };
        //                 })(file);
        //                 fRead.readAsDataURL(file); //URL representing the file's data.
        //             }
        //         });
        //
        //     } else {
        //         alert("Your browser doesn't support File API!"); //if File API is absent
        //     }
        // });

        var count = 0;
        $('.add_social_media').on('click', function () {
            $('.add_rounded_button.add_social_media').before(
                '<div class="register-item">' +
                '<label class="text">' +
                '<span>URL</span>' +
                '<div class="input_and_button">' +
                '<input type="text" name="links[' + count + '][url]" value="">' +
                '<div class="remove_social_media_button delete_social_media_link"><span>-</span></div>' +
                '</div>' +
                '</label>' +
                '<label class="text">' +
                '<span>SOCIAL NETWORK</span>' +
                '<div class="input_and_button">' +
                '<input type="text" name="links[' + count + '][name]" value="">' +
                '<div class="remove_social_media_button delete_social_media_link"><span>-</span></div>' +
                '</div>' +
                '</label>' +
                '</div>'
            );
            count++;
        });

        $(document).on('click', '.delete_social_media_link', function () {
            $(this).closest('.register-item').remove();
        });

        /*
         * ADMIN PANEL OPPORTUNITY
         */

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

            $('.prev-benefits').text($('textarea[name="topic_benefits"]').val());
            $('.prev-description').text($('textarea[name="topic_details"]').val());

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
                    $('.prev-duration').text('Stunden: ' + hours_duration);
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
                    $('.prev-duration').text('Tagen: ' + days_duration + ' Stunden: ' + hours_duration);
                    $('.hidden-data').append(skills_hidden);
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
         * CALL VALIDATE STEPS
         */

        $('.next.call-topic').on('click', function () {

            clearErrors();
            var step = $(this);
            var status = [];

            $('input').each(function () {
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
            ;

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
                if (maxChars(data, 600) != true) {
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

        $('.search-mentoring').on('change', function () {

            var frequency = $('select[name="frequency"]').val();
            var duration = $('select[name="duration"]').val();
            var time_frame = $('select[name="time_frame"]').val();

            var hours = frequency * duration * time_frame;
            $('#curr_hours').text(hours);

            return;
        });

        $('.search-engagement').on('change', function () {

            var frequency = $('select[name="frequency"]').val();
            var duration = $('select[name="duration"]').val();
            var time_frame = $('select[name="time_frame"]').val();
            var training_duration = $('select[name="training_duration"]').val();

            var hours = frequency * duration * time_frame + parseInt(training_duration);

            var hoursPlural = ' Stunde';
            if (hours > 1) {
                hoursPlural = ' Stunden'
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

        function title(data) {
            if (data.match(/^[ąćęłńóśźżĄĆĘŁŃÓŚŻŹÄäÖöÜüA-Za-z\s]+$/) && data.length > 2 && data.length < 20) {
                return true;
            }
        }

        function forname(data) {
            if (data.match(/^[ąćęłńóśźżĄĆĘŁŃÓŚŻŹÄäÖöÜüA-Za-z\s]+$/) && data.length > 2 && data.length < 50) {
                return true;
            }
        }

        function surname(data) {
            if (data.match(/^[ąćęłńóśźżĄĆĘŁŃÓŚŻŹÄäÖöÜüA-Za-z\s]+$/) && data.length > 2 && data.length < 50) {
                return true;
            }
        }

        function phone(data) {
            if (data.length === 0) {
                return true;
            } else {
                if (data.match(/^(?:[+\d].*\d|\d)$/) && data.length > 7 && data.length < 21) {
                    return true;
                }
            }
        }

        function opportunity_phone(data) {
            if (data.match(/^(?:[+\d].*\d|\d)$/) && data.length > 7 && data.length < 21) {
                return true;
            }
        }

        function companyId(data) {
            if (data.match(/^[0-9    ]+$/)) {
                return true;
            }
        }

        function lettersAndNumbers(data) {
            if (data.match(/^[ąćęłńóśźżĄĆĘŁŃÓŚŻŹÄäÖöÜüA-Za-z0-9\s]+$/) && data.length > 2 && data.length < 50) {
                return true;
            }
        }

        function email(data) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(data).toLowerCase());
        }

        function password(data) {
            if (data.length > 7 && data.length < 19) {
                return true;
            }
        }

        function passwordsMatch(password, password_repeat) {
            if (password == password_repeat) {
                return true;
            }
        }

        function skills(data) {
            if (data.length > 7 && data.length < 19) {
                return true;
            }
        }

        function loadStep(item) {
            item.closest('.section').hide();
            item.closest('.section').next().show();

            var prev = item.closest('.register').find('.row.steps .step-point.active');
            item.closest('.register').find('.row.steps .step-point.active').next().next().addClass('active');
            prev.removeClass('active');
        }

        function inputColorError(item) {
            item.css('border-color', 'red');
        }

        function clearErrors() {
            $('input').each(function () {
                $(this).css('border-color', '#adb5bd');
            });
            $('.error-box').hide();
        }

        function showError(item) {
            item.next().show();
        }

        function maxChars(item, max) {

            var chars = item.length;
            if (chars > max) {
                return false;
            } else {
                return true;
            }
        }

        function cannotBeEmpty(item) {
            if (item === "") {
                return false
            } else {
                return true;
            }
        }

        function validURL(item) {
            var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
                '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
                '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
            return !!pattern.test(item);
        }

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
        });

        $("#datepicker").datepicker({
            minDate: "+1"
        });

        /*
         * ACTIVE OPPORTUNITY
         */

        $('.modal-close').on('click', function (e) {
            e.preventDefault();
            $(this).closest('.modal.is-visible').toggleClass('is-visible');
        });

        $('.modal-activate-button').on('click', function () {
            $('.activate-ask').toggleClass('is-visible');
        });

        $('.activate-confirm').on('click', function () {
            var opportunity_id = $(this).data('id');

            console.log(opportunity_id);

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'activateOpportunity',
                    opportunity_id: opportunity_id,
                },
                success: function (response) {
                    if (response.status == true) {
                        window.location.href = '/wp-admin/admin.php?page=opportunities';
                    }

                }
            });
        });

        /*
         * USUNIĘCIE OPPORTUNITY - POJEDYNCZE
         */

        $('.modal-delete-button').on('click', function () {
            $('.delete-ask').toggleClass('is-visible');
        });

        $('.delete-confirm').on('click', function () {
            var opportunity_id = $(this).data('id');

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: ajax_object.ajax_url,
                data: {
                    action: 'deleteOpportunityAdmin',
                    opportunity_id: opportunity_id,
                },
                success: function (response) {
                    if (response.status == true) {
                        window.location = '/wp-admin/admin.php?page=opportunities';
                    }
                }
            });
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

                var frequency = $('select[name="frequency"]').val();
                var duration = $('select[name="duration"]').val();
                var time_frame = $('select[name="time_frame"]').val();
                var training_duration = 0;

                var hours = frequency * duration * time_frame + parseInt(training_duration);
                $('#curr_hours').text(hours);
            }
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

    }); //end of jQuery
}(jQuery));