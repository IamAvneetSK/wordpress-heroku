(function($) {
    'use strict';

    var question = {};
    qode.modules.question = question;

    question.qodeQuestionHint = qodeQuestionHint;
    question.qodeQuestionCheck = qodeQuestionCheck;
    question.qodeQuestionChange = qodeQuestionChange;
    question.qodeQuestionAnswerChange = qodeQuestionAnswerChange;
    question.qodeValidateAnswer = qodeValidateAnswer;
    question.qodeQuestionSave = qodeQuestionSave;

    question.qodeOnDocumentReady = qodeOnDocumentReady;
    question.qodeOnWindowLoad = qodeOnWindowLoad;
    question.qodeOnWindowResize = qodeOnWindowResize;
    question.qodeOnWindowScroll = qodeOnWindowScroll;

    $(document).ready(qodeOnDocumentReady);
    $(window).on('load', qodeOnWindowLoad);
    $(window).resize(qodeOnWindowResize);
    $(window).scroll(qodeOnWindowScroll);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function qodeOnDocumentReady() {
        qodeQuestionHint();
        qodeQuestionCheck();
        qodeQuestionChange();
        qodeQuestionAnswerChange();
    }

    /*
     All functions to be called on $(window).load() should be in this function
     */
    function qodeOnWindowLoad() {

    }

    /*
     All functions to be called on $(window).resize() should be in this function
     */
    function qodeOnWindowResize() {

    }

    /*
     All functions to be called on $(window).scroll() should be in this function
     */
    function qodeOnWindowScroll() {

    }

    function qodeQuestionAnswerChange() {
        var answersHolder = $('.qode-question-answers');
        var radios = answersHolder.find('input[type=radio]');
        var checkboxes = answersHolder.find('input[type=checkbox]');
        var textbox = answersHolder.find('input[type=text]');
        var checkForm = $('.qode-lms-question-actions-check-form');
        var nextForm = $('.qode-lms-question-next-form');
        var prevForm = $('.qode-lms-question-prev-form');
        var finishForm = $('.qode-lms-finish-quiz-form');

        radios.change(function() {
            checkForm.find('input[name=qode_lms_question_answer]').val(this.value);
            nextForm.find('input[name=qode_lms_question_answer]').val(this.value);
            prevForm.find('input[name=qode_lms_question_answer]').val(this.value);
            finishForm.find('input[name=qode_lms_question_answer]').val(this.value);
        });

        checkboxes.on('change', function() {
            var values = $('input[type=checkbox]:checked').map(function() {
                return this.value;
            }).get().join(',');
            checkForm.find('input[name=qode_lms_question_answer]').val(values);
            nextForm.find('input[name=qode_lms_question_answer]').val(values);
            prevForm.find('input[name=qode_lms_question_answer]').val(values);
            finishForm.find('input[name=qode_lms_question_answer]').val(values);
        }).change();

        textbox.on("change paste keyup", function() {
            checkForm.find('input[name=qode_lms_question_answer]').val($(this).val());
            nextForm.find('input[name=qode_lms_question_answer]').val($(this).val());
            prevForm.find('input[name=qode_lms_question_answer]').val($(this).val());
            finishForm.find('input[name=qode_lms_question_answer]').val($(this).val());
        });
    }

    function qodeUpdateQuestionPosition(questionPosition) {
        var positionHolder = $('.qode-question-number-completed');
        positionHolder.text(questionPosition);
    }

    function qodeUpdateQuestionId(questionId) {
        var finishForm = $('.qode-lms-finish-quiz-form');
        finishForm.find('input[name=qode_lms_question_id]').val(questionId);
    }

    function qodeValidateAnswer(answersHolder, result, originalResult, answerChecked) {
        var radios = answersHolder.find('input[type=radio]');
        var checkboxes = answersHolder.find('input[type=checkbox]');
        var textbox = answersHolder.find('input[type=text]');

        if(answerChecked == 'yes') {
            answersHolder.find('input').prop("disabled", true);
            if (radios.length) {
                $.each(result, function (key, val) {
                    var input = answersHolder.find('input[type=radio][value=' + key + ']');
                    if (val == true) {
                        input.parent().addClass('qode-true');
                    } else {
                        input.parent().addClass('qode-false');
                    }
                });
                $.each(originalResult, function (key, val) {
                    var input = answersHolder.find('input[type=radio][value=' + key + ']');
                    if (val == true) {
                        input.parent().addClass('qode-base-true');
                    }
                });
            }

            if (checkboxes.length) {
                $.each(result, function (key, val) {
                    var input = answersHolder.find('input[type=checkbox][value=' + key + ']');
                    if (val == true) {
                        input.parent().addClass('qode-true');
                    } else {
                        input.parent().addClass('qode-false');
                    }
                });
                $.each(originalResult, function (key, val) {
                    var input = answersHolder.find('input[type=checkbox][value=' + key + ']');
                    if (val == true) {
                        input.parent().addClass('qode-base-true');
                    }
                });
            }

            if (textbox.length) {
                if (result) {
                    textbox.parent().addClass('qode-true');
                } else {
                    textbox.parent().addClass('qode-false');
                    textbox.parent().append('<p class="qode-base-answer">' + originalResult + '</p>');
                }
            }
        }
    }

    function qodeQuestionHint() {
        var answersHolder = $('.qode-question-answer-wrapper');
        $('.qode-lms-question-actions-hint-form').on('submit',function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            var timeRemaining = $('input[name=qode_lms_time_remaining]');
            formData += '&qode_lms_time_remaining=' + timeRemaining.val();
            var ajaxData = {
                action: 'qode_lms_check_question_hint',
                post: formData
            };
            form.find('input').prop("disabled", true);
            $.ajax({
                type: 'POST',
                data: ajaxData,
                url: QodeAdminAjax.ajaxurl,
                success: function (data) {
                    var response = JSON.parse(data);
                    if(response.status == 'success'){
                        answersHolder.append(response.data.html);
                    }
                }
            });
        });
    }

    function qodeQuestionCheck() {
        var answersHolder = $('.qode-question-answer-wrapper');
        $('.qode-lms-question-actions-check-form').on('submit',function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            var timeRemaining = $('input[name=qode_lms_time_remaining]');
            formData += '&qode_lms_time_remaining=' + timeRemaining.val();
            var ajaxData = {
                action: 'qode_lms_check_question_answer',
                post: formData
            };
            form.find('input').prop("disabled", true);
            $.ajax({
                type: 'POST',
                data: ajaxData,
                url: QodeAdminAjax.ajaxurl,
                success: function (data) {
                    var response = JSON.parse(data);
                    if(response.status == 'success'){
                        var result = response.data.result;
                        var originalResult = response.data.original_result;
                        var answerChecked = response.data.answer_checked;
                        qodeValidateAnswer(answersHolder, result, originalResult, answerChecked);
                    }
                }
            });
        });
    }

    function qodeQuestionChange() {
        var questionHolder = $('.qode-quiz-question-wrapper');
        $('.qode-lms-question-prev-form, .qode-lms-question-next-form').on('submit',function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            var timeRemaining = $('input[name=qode_lms_time_remaining]');
            var retakeId = $('input[name=qode_lms_retake_id]');
            formData += '&qode_lms_time_remaining=' + timeRemaining.val();
            formData += '&qode_lms_retake_id=' + retakeId.val();
            var ajaxData = {
                action: 'qode_lms_change_question',
                post: formData
            };

            $.ajax({
                type: 'POST',
                data: ajaxData,
                url: QodeAdminAjax.ajaxurl,
                success: function (data) {
                    var response = JSON.parse(data);
                    if(response.status == 'success'){
                        questionHolder.html(response.data.html);
                        var answersHolder = $('.qode-question-answer-wrapper');
                        var result = response.data.result;
                        var originalResult = response.data.original_result;
                        var answerChecked = response.data.answer_checked;
                        qodeQuestionHint();
                        qodeQuestionCheck();
                        qodeQuestionChange();
                        qodeQuestionAnswerChange();
                        qodeUpdateQuestionPosition(response.data.question_position);
                        qodeUpdateQuestionId(response.data.question_id);
                        qodeValidateAnswer(answersHolder, result, originalResult, answerChecked);
                        qode.modules.quiz.qodeFinishQuiz();
                    }
                }
            });
        });
    }

    function qodeQuestionSave() {
        $(window).unload(function() {
            var form = $('.qode-lms-question-next-form');
            if(!form.length) {
                form = $('qode-lms-question-prev-form');
            }
            var formData = form.serialize();
            var timeRemaining = $('input[name=qode_lms_time_remaining]');
            var retakeId = $('input[name=qode_lms_retake_id]');
            formData += '&qode_lms_time_remaining=' + timeRemaining.val();
            formData += '&qode_lms_retake_id=' + retakeId.val();
            console.log(formData);
            var ajaxData = {
                action: 'qode_lms_save_question',
                post: formData
            };

            $.ajax({
                type: 'POST',
                data: ajaxData,
                async: false,
                url: QodeAdminAjax.ajaxurl
            });
        });
    }

})(jQuery);