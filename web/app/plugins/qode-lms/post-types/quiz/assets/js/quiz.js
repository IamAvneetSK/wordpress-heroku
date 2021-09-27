(function($) {
    'use strict';

    var quiz = {};
    qode.modules.quiz = quiz;

    quiz.qodeStartQuiz = qodeStartQuiz;
    quiz.qodeFinishQuiz = qodeFinishQuiz;

    quiz.qodeOnDocumentReady = qodeOnDocumentReady;

    $(document).ready(qodeOnDocumentReady);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function qodeOnDocumentReady() {
        qodeStartQuiz();
        qodeFinishQuiz();
    }

    function qodeStartQuiz(){
        var popupContent = $('.qode-quiz-single-holder'),
            preloader = $('.qode-course-item-preloader');
        
        $('.qode-lms-start-quiz-form').on('submit',function(e) {
            e.preventDefault();
            preloader.removeClass('qode-hide');
            var form = $(this);
            var formData = form.serialize();
            var ajaxData = {
                action: 'qode_lms_start_quiz',
                post: formData
            };

            $.ajax({
                type: 'POST',
                data: ajaxData,
                url: QodeAdminAjax.ajaxurl,
                success: function (data) {
                    var response = JSON.parse(data);
                    if(response.status == 'success'){
                        var questionId = response.data.question_id;
                        var quizId = response.data.quiz_id;
                        var courseId = response.data.course_id;
                        var retake = response.data.retake;
                        qodeLoadQuizQuestion(questionId, quizId, courseId, retake, popupContent);
                        qode.modules.question.qodeQuestionSave();
                    } else {
                        alert("An error occurred");
                        preloader.addClass('qode-hide');
                    }
                }
            });
        });
    }

    function qodeLoadQuizQuestion(questionId ,quizId, courseId, retake, container){
        var preloader = $('.qode-course-item-preloader');
        var ajaxData = {
            action: 'qode_lms_load_first_question',
            question_id : questionId,
            quiz_id : quizId,
            course_id : courseId,
            retake : retake
        };
        
        $.ajax({
            type: 'POST',
            data: ajaxData,
            url: QodeAdminAjax.ajaxurl,
            success: function (data) {
                var response = JSON.parse(data);
                if(response.status == 'success'){
                    container.html(response.data.html);
                    qode.modules.question.qodeQuestionHint();
                    qode.modules.question.qodeQuestionCheck();
                    qode.modules.question.qodeQuestionChange();
                    qode.modules.question.qodeQuestionAnswerChange();
                    qodeFinishQuiz();

                    var answersHolder = $('.qode-question-answer-wrapper');
                    var result = response.data.result;
                    var originalResult = response.data.original_result;
                    var answerChecked = response.data.answer_checked;
                    qode.modules.question.qodeValidateAnswer(answersHolder, result, originalResult, answerChecked);

                    var timerHolder = $('#qode-quiz-timer');
                    var duration = timerHolder.data('duration');
                    var timeRemaining = $('input[name=qode_lms_time_remaining]');
                    timerHolder.vTimer('start', {duration: duration})
                        .on('update', function (e, remaining) {
                            // total seconds
                            var seconds = remaining;
                            // calculate seconds
                            var s = seconds % 60;
                            // add leading zero to seconds if needed
                            s = s < 10 ? "0" + s : s;
                            // calculate minutes
                            var m = Math.floor(seconds / 60) % 60;
                            // add leading zero to minutes if needed
                            m = m < 10 ? "0" + m : m;
                            // calculate hours
                            var h = Math.floor(seconds / 60 / 60);
                            h = h < 10 ? "0" + h : h;
                            var time = h + ":" + m + ":" + s;
                            timerHolder.text(time);
                            timeRemaining.val(remaining);
                        })
                        .on('complete', function () {
                            $('.qode-lms-finish-quiz-form').submit();
                        });
                    preloader.addClass('qode-hide');
                } else {
                    alert("An error occurred");
                    preloader.addClass('qode-hide');
                }
            }
        });
    }

    function qodeFinishQuiz(){
        var popupContent = $('.qode-quiz-single-holder'),
            preloader = $('.qode-course-item-preloader');
        
        $('.qode-lms-finish-quiz-form').on('submit',function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            var timeRemaining = $('input[name=qode_lms_time_remaining]');
            formData += '&qode_lms_time_remaining=' + timeRemaining.val();
            var ajaxData = {
                action: 'qode_lms_finish_quiz',
                post: formData
            };

            $.ajax({
                type: 'POST',
                data: ajaxData,
                url: QodeAdminAjax.ajaxurl,
                success: function (data) {
                    var response = JSON.parse(data);
                    if(response.status == 'success'){
                        popupContent.replaceWith(response.data.html);
                        qodeStartQuiz();
                        preloader.addClass('qode-hide');
                    } else {
                        alert("An error occurred");
                        preloader.addClass('qode-hide');
                    }
                }
            });
        });
    }

})(jQuery);