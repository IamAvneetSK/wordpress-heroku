(function($) {
    'use strict';

    $(document).ready(qodeOnDocumentReady);
    $(window).on('load', qodeOnWindowLoad);
    $(window).resize(qodeOnWindowResize);
    $(window).scroll(qodeOnWindowScroll);

    /*
     All functions to be called on $(document).ready() should be in this function
     */
    function qodeOnDocumentReady() {
        courseSection.rowRepeater.init();
        courseSection.lessonRepeater.init();
        courseSection.quizRepeater.init();
        qodefInitSortable();
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


    var courseSection = function() {
        var $courseSections = $('#qodef-course-section-content'),
            numberOfRows = $courseSections.find('.qodef-course-section').length;

        var rowRepeater = function() {
            var sectionTemplate = wp.template('qodef-course-section-template');
            var $addButton = $('#qodef-course-section-add');

            var addNewPeriod = function() {
                $addButton.on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    $(document).trigger('qode_course_section/before_add_section');

                    var $row = $(sectionTemplate({
                        rowIndex: getLastRowIndex() + 1 || 0
                    }));

                    $courseSections.append($row);
                    numberOfRows += 1;

                    fieldsHelper.sortableHelper.initSortableField($row);

                    $(document).trigger('qode_course_section/after_add_section');
                });
            };

            var removePeriod = function() {
                $courseSections.on('click', '.qodef-course-section-remove-item', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if(!window.confirm('Are you sure you want to remove this section?')) {
                        return;
                    }

                    var $rowParent = $(this).parents('.qodef-course-section');
                    $rowParent.remove();

                    decrementNumberOfRows();

                    $(document).trigger('qode_course_section/after_delete_section');
                });
            };

            var getLastRowIndex = function() {
                var $lastRow = $courseSections.find('.qodef-course-section').last();

                if(typeof $lastRow === 'undefined') {
                    return false;
                }

                return $lastRow.data('index');
            };

            var decrementNumberOfRows = function() {
                if(numberOfRows <= 0) {
                    return;
                }

                numberOfRows -= 1;
            };

            var getNumberOfRows = function() {
                return numberOfRows;
            };

            return {
                init: function() {
                    addNewPeriod();
                    removePeriod();
                },
                numberOfRows: getNumberOfRows,
                getLastRowIndex: getLastRowIndex
            }
        }();

        var lessonRepeater = function() {
            var lessonTemplate = wp.template('qodef-section-lesson-template');

            var addNewLesson = function() {
                $courseSections.on('click', '#qodef-course-lesson-add', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var $clickedButton = $(this);
                    var $parentRow = $clickedButton.parents('.qodef-course-section').first();
                    var parentIndex = $parentRow.data('index');

                    var $lessonContent = $clickedButton.parents('.qodef-course-section-controls').prev();

                    var lastLessonIndex = $parentRow.find('.qodef-course-element').last().data('index');
                    lastLessonIndex = typeof lastLessonIndex !== 'undefined' ? lastLessonIndex : -1;

                    var $lessonRow = $(lessonTemplate({
                        rowIndex: parentIndex,
                        lessonIndex: lastLessonIndex + 1
                    }));

                    $lessonContent.append($lessonRow);
                    fieldsHelper.select2Helper.initSelect2Field($lessonRow);
                });
            };

            var removeLesson = function() {
                $courseSections.on('click', '.qodef-course-lesson-remove-item', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if(!confirm('Are you sure you want to remove this lesson?')) {
                        return;
                    }

                    var $removeButton = $(this);
                    var $parent = $removeButton.parents('.qodef-course-element');

                    $parent.remove();
                });
            };

            return {
                init: function() {
                    addNewLesson();
                    removeLesson();
                }
            }
        }();

        var quizRepeater = function() {
            var quizTemplate = wp.template('qodef-section-quiz-template');

            var addNewQuiz = function() {
                $courseSections.on('click', '#qodef-course-quiz-add', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var $clickedButton = $(this);
                    var $parentRow = $clickedButton.parents('.qodef-course-section').first();
                    var parentIndex = $parentRow.data('index');

                    var $quizContent = $clickedButton.parents('.qodef-course-section-controls').prev();

                    var lastQuizIndex = $parentRow.find('.qodef-course-element').last().data('index');
                    lastQuizIndex = typeof lastQuizIndex !== 'undefined' ? lastQuizIndex : -1;

                    var $quizRow = $(quizTemplate({
                        rowIndex: parentIndex,
                        quizIndex: lastQuizIndex + 1
                    }));

                    $quizContent.append($quizRow);
                    fieldsHelper.select2Helper.initSelect2Field($quizRow);
                });
            };

            var removeQuiz = function() {
                $courseSections.on('click', '.qodef-course-quiz-remove-item', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if(!confirm('Are you sure you want to remove this quiz?')) {
                        return;
                    }

                    var $removeButton = $(this);
                    var $parent = $removeButton.parents('.qodef-course-element');

                    $parent.remove();
                });
            };

            return {
                init: function() {
                    addNewQuiz();
                    removeQuiz();
                }
            }
        }();

        return {
            rowRepeater: rowRepeater,
            lessonRepeater: lessonRepeater,
            quizRepeater: quizRepeater,
            $courseSections: $courseSections
        }
    }();

    var fieldsHelper = function() {
        var select2Helper = function() {
            return {
                initSelect2Field: function($content) {
                    var $selectFields = $content.find('.qodef-select2');

                    if($selectFields.length) {
                        $selectFields.each(function() {
                            $(this).select2({
                                allowClear: true
                            });
                        });
                    }
                }
            };
        }();

        var sortableHelper = function() {
            return {
                initSortableField: function($content) {
                    var $sortableFields = $content.find('.qodef-sortable-holder');

                    if($sortableFields.length) {
                        $sortableFields.each(function () {
                            var sortingHolder = $(this);
                            var enableParentChild = sortingHolder.hasClass('qodef-enable-pc');
                            sortingHolder.sortable({
                                handle: '.qodef-repeater-sort',
                                cursor: 'move',
                                placeholder: "placeholder",
                                start: function(event, ui) {
                                    ui.placeholder.height(ui.item.height());
                                    if(enableParentChild) {
                                        if (ui.helper.hasClass('second-level')) {
                                            ui.placeholder.removeClass('placeholder');
                                            ui.placeholder.addClass('placeholder-sub');
                                        }
                                        else {
                                            ui.placeholder.removeClass('placeholder-sub');
                                            ui.placeholder.addClass('placeholder');
                                        }
                                    }
                                },
                                sort: function(event, ui) {
                                    if(enableParentChild) {
                                        var pos;
                                        if (ui.helper.hasClass('second-level')) {
                                            pos = ui.position.left + 50;
                                        }
                                        else {
                                            pos = ui.position.left;
                                        }
                                        if (pos >= 75 && !ui.helper.hasClass('second-level') && !ui.helper.hasClass('qodef-sort-parent')) {
                                            ui.placeholder.removeClass('placeholder');
                                            ui.placeholder.addClass('placeholder-sub');
                                            ui.helper.addClass('second-level');
                                        }
                                        else if (pos < 30 && ui.helper.hasClass('second-level') && !ui.helper.hasClass('qodef-sort-child')) {
                                            ui.placeholder.removeClass('placeholder-sub');
                                            ui.placeholder.addClass('placeholder');
                                            ui.helper.removeClass('second-level');
                                        }
                                    }
                                }
                            });
                        });
                    }
                }
            };
        }();

        return {
            select2Helper: select2Helper,
            sortableHelper: sortableHelper
        }
    }();

    function qodefInitSortable() {
        var sortingHolder = $('.qodef-sortable-holder-courses');
        var enableParentChild = sortingHolder.hasClass('qodef-enable-pc');
        sortingHolder.sortable({
            handle: '.qodef-repeater-sort',
            cursor: 'move',
            placeholder: "placeholder",
            start: function(event, ui) {
                ui.placeholder.height(ui.item.height());
                if(enableParentChild) {
                    if (ui.helper.hasClass('second-level')) {
                        ui.placeholder.removeClass('placeholder');
                        ui.placeholder.addClass('placeholder-sub');
                    }
                    else {
                        ui.placeholder.removeClass('placeholder-sub');
                        ui.placeholder.addClass('placeholder');
                    }
                }
            },
            sort: function(event, ui) {
                if(enableParentChild) {
                    var pos;
                    if (ui.helper.hasClass('second-level')) {
                        pos = ui.position.left + 50;
                    }
                    else {
                        pos = ui.position.left;
                    }
                    if (pos >= 75 && !ui.helper.hasClass('second-level') && !ui.helper.hasClass('qodef-sort-parent')) {
                        ui.placeholder.removeClass('placeholder');
                        ui.placeholder.addClass('placeholder-sub');
                        ui.helper.addClass('second-level');
                    }
                    else if (pos < 30 && ui.helper.hasClass('second-level') && !ui.helper.hasClass('qodef-sort-child')) {
                        ui.placeholder.removeClass('placeholder-sub');
                        ui.placeholder.addClass('placeholder');
                        ui.helper.removeClass('second-level');
                    }
                }
            }
        });
    }

})(jQuery);