<?php

return [
    [
		'label'       => 'Dashboard',
		'link'        => '/admin',
		'icon'        => 'home',
		'permissions' => []
	],
	[
		'label'       => 'Tag',
		'link'        => '/tags',
		'icon'        => 'flash',
		'permissions' => [],
		'sublinks'    => [
			[
				'label'       => 'All Tag',
				'link'        => 'tags',
				'icon'        => 'overview',
				'permissions' => [],
			],
			[
				'label'       => 'New Tag',
				'link'        => 'tags/add',
				'icon'        => 'flash',
				'permissions' => [],
			],
		],
	],

];
