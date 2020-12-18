<?php

do_action('tutor_course/single/before/material_includes');

$materials = tutor_course_material_includes();

if ( empty($materials)){
	return;
}

if (is_array($materials) && count($materials)){
	?>

	<div class="etlms-course-specifications etlms-course-materials">
        <h3><?php esc_html_e($settings['section_title_text'], 'tutor-elementor-addons'); ?></h3>
		<ul class="etlms-course-specification-items etlms-course-materials">
			<?php
			foreach ($materials as $material) {
				echo "<li>";
				Elementor\Icons_Manager::render_icon( $settings['course_materials_list_icon'], [ 'aria-hidden' => 'true' ] );
				echo "<span>{$material}</span></li>";
			}
			?>
		</ul>
	</div>

<?php } ?>

<?php do_action('tutor_course/single/after/material_includes'); ?>

