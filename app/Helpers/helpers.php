<?php
$GLOBALS['page_options'] = ['10' => 10, '1' => 1, '5' => 5];
function get_sidebar_navlinks() {
	return require base_path() . '/database/data/navigations.php';
}

function get_svgicon($icon_name) {
	echo file_get_contents(base_path() . "/resources/assets/svg-icons/{$icon_name}.svg");
}


function cross_svg(){
	echo '<svg xmlns="http://www.w3.org/2000/svg" height="0.75em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
	</svg>';
}



function generate_select_input($name, $id, $selected_value, $options, $css_classes = '') {
	?>
		<select class="<?php echo $css_classes; ?>"	id="<?php echo $id; ?>"	name="<?php echo $name; ?>">
			<?php
				foreach ($options as $option) {
					?>
					<option value="<?php echo $option['value']; ?>" <?php  echo $selected_value == $option['value'] ? 'selected' : ''; ?>
					>  <?php echo $option['label']; ?>
					</option>
					<?php
				}
			?>
		</select>
	<?php
}


function generate_perpage_options($name, $id, $selected_value, $css_classes = '') {

	$options = [
		['label'=>'5','value'=>'5'],
		['label'=>'10','value'=>'10'],
		['label'=>'20','value'=>'20'],
		['label'=>'30','value'=>'30'],
		['label'=>'40','value'=>'40'],
		['label'=>'50','value'=>'50'],
		['label'=>'60','value'=>'60'],
	];
	$selected_value = empty($selected_value) ? 10 : $selected_value;
	generate_select_input($name, $id, $selected_value, $options, $css_classes);
}

function generate_language_options($name, $id, $selected_value, $blank_option, $css_classes = '') {

	$options = (true == $blank_option) ?  [ ['label' => 'All', 'value' => ''] ] : [];
	$options = array_merge($options, config('app.locales_label_value_pairs'));
	$selected_value = empty($selected_value) ? '' : $selected_value;
	generate_select_input($name, $id, $selected_value, $options, $css_classes);
}

function generate_posttype_options($name, $id, $selected_value, $blank_option, $css_classes = '') {

	$options = (true == $blank_option) ?  [ ['label' => 'All', 'value' => ''] ] : [];
	$options = array_merge($options, [
		['label'=>'article','value'=>'article'],
		['label'=>'video','value'=>'video'],
		['label'=>'gallery','value'=>'gallery'],
		['label'=>'audio','value'=>'audio'],
	]);
	$selected_value = empty($selected_value) ? '' : $selected_value;
	generate_select_input($name, $id, $selected_value, $options, $css_classes);
}

