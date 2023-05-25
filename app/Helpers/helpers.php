<?php

function get_sidebar_navlinks() {
	return require base_path() . '/database/data/navigations.php';
}

function get_svgicon($icon_name) {
	echo file_get_contents(base_path() . "/resources/assets/svg-icons/{$icon_name}.svg");
}
