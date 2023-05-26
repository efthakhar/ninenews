<?php

return [
    [
		'label'       => 'Dashboard',
		'link'        => '/admin',
		'icon'        => 'earth',
		'permissions' => []
	],
	[
		'label'       => 'Tag',
		'link'        => '/admin/tags',
		'icon'        => 'tag',
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

];
