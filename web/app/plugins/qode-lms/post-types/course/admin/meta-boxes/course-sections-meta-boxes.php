<?php

/*
   Class: QodeMultipleImages
   A class that initializes Qode LMS Course Sections
*/
class QodeLMSCourseSectionsMetaBox implements iBridgeQodeRender {
    private $name;
    private $label;
    private $description;

    function __construct($name, $label="", $description="") {
        global $bridge_qode_framework;
        $this->name = $name;
        $this->label = $label;
        $this->description = $description;
		$bridge_qode_framework->qodeMetaBoxes->addOption($this->name,"");
    }

    public function render($factory) {

        global $post;
        $rows = empty($post->ID) ? array() : get_post_meta($post->ID, 'qode_course_curriculum', true);

        //Get list of lessons;
        $qode_lessons = array();
        $lessons = get_posts(
            array(
                'numberposts' => -1,
                'post_type' => 'lesson',
                'post_status' => 'publish',
            )
        );
        foreach ($lessons as $lesson) {
            $qode_lessons[$lesson->ID] = $lesson->post_title;
        }

        //Get list of quizzes;
        $qode_quizzes = array();
        $quizzes = get_posts(
            array(
                'numberposts' => -1,
                'post_type' => 'quiz',
                'post_status' => 'publish'
            )
        );
        foreach ($quizzes as $quiz) {
            $qode_quizzes[$quiz->ID] = $quiz->post_title;
        }

        ?>
        <input type="hidden" id="course_id" name="course_id" value="<?php echo esc_attr($post->ID); ?>">
        <div id="qodef-course-section-content" class="qodef-repeater-fields-holder qodef-enable-pc qodef-sortable-holder qodef-sortable-holder-courses clearfix">
            <?php if(is_array($rows) && count($rows)) :
            $i = 0;
            ?>
            <?php foreach($rows as $key=>$value) : ?>
            <div class="qodef-course-section qodef-repeater-fields-row qodef-sort-parent first-level" data-index="<?php echo esc_attr($i); ?>">
                <div class="qodef-repeater-fields-row-inner">
                    <div class="qodef-repeater-sort">
                        <i class="fa fa-sort"></i>
                    </div>
                    <div class="qodef-repeater-field-item">
                        <div class="qodef-page-form-section qodef-repeater-field qodef-no-description">
                            <div class="qodef-section-content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h4><?php esc_html_e('Section Name', 'qodef-lms'); ?></h4>
                                            <div class="form-group">
                                                <input type="text" class="form-control qodef-input qodef-form-element" placeholder="" value="<?php echo esc_attr($value['section_name']); ?>" name="qode_course_curriculum[<?php echo esc_attr($i); ?>][section_name]">
                                            </div>
                                            <h4><?php esc_html_e('Section Title', 'qodef-lms'); ?></h4>
                                            <div class="form-group">
                                                <input type="text" class="form-control qodef-input qodef-form-element" placeholder="" value="<?php echo esc_attr($value['section_title']); ?>" name="qode_course_curriculum[<?php echo esc_attr($i); ?>][section_title]">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <h4><?php esc_html_e('Section Description', 'qodef-lms'); ?></h4>
                                            <div class="form-group">
                                                <textarea type="text" rows="6" class="form-control qodef-input qodef-form-element" placeholder="" name="qode_course_curriculum[<?php echo esc_attr($i); ?>][section_description]"><?php echo esc_attr($value['section_description']); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="qodef-sortable-holder qodef-sortable-holder-courses" id="qodef-course-section-elements-<?php echo esc_attr($i); ?>">
                            <?php if(!empty($value['section_elements']) && is_array($value['section_elements']) && count($value['section_elements'])) : ?>
                                <?php $j = 0; ?>
                                <?php foreach($value['section_elements'] as $element) : ?>
                                    <?php if($element['type'] == 'lesson'): ?>
                                    <div class="qodef-course-element qodef-repeater-fields-row qodef-sort-child second-level" data-index="<?php echo esc_attr($j); ?>">
                                        <div class="qodef-repeater-fields-row-inner">
                                            <div class="qodef-repeater-sort">
                                                <i class="fa fa-sort"></i>
                                            </div>
                                            <div class="qodef-repeater-field-item">
                                                <div class="qodef-page-form-section qodef-repeater-field qodef-no-description">
                                                    <div class="qodef-section-content">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="qodef-inner-field-holder">
                                                                        <input type="hidden" value="lesson" name="qode_course_curriculum[<?php echo esc_attr($i); ?>][section_elements][<?php echo esc_attr($j); ?>][type]">
                                                                        <select class="qodef-select2 form-control qodef-form-element" name="qode_course_curriculum[<?php echo esc_attr($i); ?>][section_elements][<?php echo esc_attr($j); ?>][value]">
                                                                            <?php foreach($qode_lessons as $key=>$value) { if ($key == "-1") $key = ""; ?>
                                                                                <option <?php if ($element['value'] == $key) { echo "selected='selected'"; } ?>  value="<?php echo esc_attr($key); ?>"><?php echo esc_html($value); ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="qodef-repeater-remove">
                                                <a href="#" class="qodef-course-lesson-remove-item" data-toggle="tooltip" data-placement="left" title="<?php esc_html_e('Remove Section', 'qodef-lms'); ?>"><i class="fa fa-times"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php elseif($element['type'] == 'quiz'): ?>
                                    <div class="qodef-course-element qodef-repeater-fields-row qodef-sort-child second-level" data-index="<?php echo esc_attr($j); ?>">
                                        <div class="qodef-repeater-fields-row-inner">
                                            <div class="qodef-repeater-sort">
                                                <i class="fa fa-sort"></i>
                                            </div>
                                            <div class="qodef-repeater-field-item">
                                                <div class="qodef-page-form-section qodef-repeater-field qodef-no-description">
                                                    <div class="qodef-section-content">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="qodef-inner-field-holder">
                                                                        <input type="hidden" value="quiz" name="qode_course_curriculum[<?php echo esc_attr($i); ?>][section_elements][<?php echo esc_attr($j); ?>][type]">
                                                                        <select class="qodef-select2 form-control qodef-form-element" name="qode_course_curriculum[<?php echo esc_attr($i); ?>][section_elements][<?php echo esc_attr($j); ?>][value]">
                                                                            <?php foreach($qode_quizzes as $key=>$value) { if ($key == "-1") $key = ""; ?>
                                                                                <option <?php if ($element['value'] == $key) { echo "selected='selected'"; } ?>  value="<?php echo esc_attr($key); ?>"><?php echo esc_html($value); ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="qodef-repeater-remove">
                                                <a href="#" class="qodef-course-quiz-remove-item" data-toggle="tooltip" data-placement="left" title="<?php esc_html_e('Remove Section', 'qodef-lms'); ?>"><i class="fa fa-times"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php $j++; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="qodef-course-section-controls">
                            <div class="qodef-repeater-add">
                                <a id="qodef-course-lesson-add" href="#" class="btn btn-primary"><?php esc_html_e('Add New Lesson', 'qodef-lms'); ?></a>
                                <a id="qodef-course-quiz-add" href="#" class="btn btn-primary"><?php esc_html_e('Add New Quiz', 'qodef-lms'); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="qodef-repeater-remove">
                        <a href="#" class="qodef-course-section-remove-item" data-toggle="tooltip" data-placement="left" title="<?php esc_html_e('Remove Section', 'qodef-lms'); ?>"><i class="fa fa-times"></i></a>
                    </div>
                </div>
            </div>
            <?php
            $i++;
            endforeach;
                ?>
            <?php endif; ?>
        </div>

        <div class="qodef-course-section-controls">
            <div class="qodef-repeater-add">
                <a id="qodef-course-section-add" href="#" class="btn btn-primary"><?php esc_html_e('Add New Section', 'qodef-lms'); ?></a>
            </div>
        </div>

        <script type="text/html" id="tmpl-qodef-course-section-template">
            <div class="qodef-course-section qodef-repeater-fields-row qodef-sort-parent first-level" data-index="{{{ data.rowIndex }}}">
                <div class="qodef-repeater-fields-row-inner">
                    <div class="qodef-repeater-sort">
                        <i class="fa fa-sort"></i>
                    </div>
                    <div class="qodef-repeater-field-item">
                        <div class="qodef-page-form-section qodef-repeater-field qodef-no-description">
                            <div class="qodef-section-content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h4><?php esc_html_e('Section Name', 'qodef-lms'); ?></h4>
                                            <div class="form-group">
                                                <input type="text" class="form-control qodef-input qodef-form-element" placeholder="" name="qode_course_curriculum[{{{ data.rowIndex }}}][section_name]">
                                            </div>
                                            <h4><?php esc_html_e('Section Title', 'qodef-lms'); ?></h4>
                                            <div class="form-group">
                                                <input type="text" class="form-control qodef-input qodef-form-element" placeholder="" name="qode_course_curriculum[{{{ data.rowIndex }}}][section_title]">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <h4><?php esc_html_e('Section Description', 'qodef-lms'); ?></h4>
                                            <div class="form-group">
                                                <textarea type="text" rows="6" class="form-control qodef-input qodef-form-element" placeholder="" name="qode_course_curriculum[{{{ data.rowIndex }}}][section_description]"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="qodef-sortable-holder qodef-sortable-holder-courses" id="qodef-course-section-elements-{{{ data.rowIndex }}}">

                        </div>
                        <div class="qodef-course-section-controls">
                            <div class="qodef-repeater-add">
                                <a id="qodef-course-lesson-add" href="#" class="btn btn-primary"><?php esc_html_e('Add New Lesson', 'qodef-lms'); ?></a>
                                <a id="qodef-course-quiz-add" href="#" class="btn btn-primary"><?php esc_html_e('Add New Quiz', 'qodef-lms'); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="qodef-repeater-remove">
                        <a href="#" class="qodef-course-section-remove-item" data-toggle="tooltip" data-placement="left" title="<?php esc_html_e('Remove Section', 'qodef-lms'); ?>"><i class="fa fa-times"></i></a>
                    </div>
                </div>
            </div>
        </script>

        <script type="text/html" id="tmpl-qodef-section-lesson-template">
            <div class="qodef-course-element qodef-repeater-fields-row qodef-sort-child second-level" data-index="{{{ data.lessonIndex }}}">
                <div class="qodef-repeater-fields-row-inner">
                    <div class="qodef-repeater-sort">
                        <i class="fa fa-sort"></i>
                    </div>
                    <div class="qodef-repeater-field-item">
                        <div class="qodef-page-form-section qodef-repeater-field qodef-no-description">
                            <div class="qodef-section-content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="qodef-inner-field-holder">
                                                <input type="hidden" value="lesson" name="qode_course_curriculum[{{{ data.rowIndex }}}][section_elements][{{{ data.lessonIndex }}}][type]">
                                                <select class="qodef-select2 form-control qodef-form-element" name="qode_course_curriculum[{{{ data.rowIndex }}}][section_elements][{{{ data.lessonIndex }}}][value]">
                                                    <?php foreach($qode_lessons as $key=>$value) { if ($key == "-1") $key = ""; ?>
                                                        <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($value); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="qodef-repeater-remove">
                        <a href="#" class="qodef-course-lesson-remove-item" data-toggle="tooltip" data-placement="left" title="<?php esc_html_e('Remove Lesson', 'qodef-lms'); ?>"><i class="fa fa-times"></i></a>
                    </div>
                </div>
            </div>
        </script>

        <script type="text/html" id="tmpl-qodef-section-quiz-template">
            <div class="qodef-course-element qodef-repeater-fields-row qodef-sort-child second-level" data-index="{{{ data.quizIndex }}}">
                <div class="qodef-repeater-fields-row-inner">
                    <div class="qodef-repeater-sort">
                        <i class="fa fa-sort"></i>
                    </div>
                    <div class="qodef-repeater-field-item">
                        <div class="qodef-page-form-section qodef-repeater-field qodef-no-description">
                            <div class="qodef-section-content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="qodef-inner-field-holder">
                                                <input type="hidden" value="quiz" name="qode_course_curriculum[{{{ data.rowIndex }}}][section_elements][{{{ data.quizIndex }}}][type]">
                                                <select class="qodef-select2 form-control qodef-form-element" name="qode_course_curriculum[{{{ data.rowIndex }}}][section_elements][{{{ data.quizIndex }}}][value]">
                                                    <?php foreach($qode_quizzes as $key=>$value) { if ($key == "-1") $key = ""; ?>
                                                        <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($value); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="qodef-repeater-remove">
                        <a href="#" class="qodef-course-lesson-remove-item" data-toggle="tooltip" data-placement="left" title="<?php esc_html_e('Remove Quiz', 'qodef-lms'); ?>"><i class="fa fa-times"></i></a>
                    </div>
                </div>
            </div>
        </script>

        <?php
    }
}