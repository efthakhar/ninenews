<?php

return [
    [
		'label'       => 'Dashboard',
		'link'        => '/admin',
		'icon'        => 'ri-home-4-line',
		'permissions' => []
	],
	[
		'label'       => 'Tag',
		'link'        => '/admin/tags',
		'icon'        => 'ri-price-tag-3-line',
		'permissions' => [],
		'sublinks'    => [
			[
				'label'       => 'All Tag',
				'link'        => '/admin/tags',
				'icon'        => 'overview',
				'permissions' => [],
			],
			[
				'label'       => 'New Tag',
				'link'        => '/admin/tags/create',
				'icon'        => 'flash',
				'permissions' => [],
			],
		],
	],
	[
		'label'       => 'Media',
		'link'        => '/admin/media',
		'icon'        => 'ri-folder-2-line',
		'permissions' => []
	],

];
