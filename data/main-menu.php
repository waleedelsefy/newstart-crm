<?php

use Illuminate\Support\Facades\Route;

return [
    [
        'title' => __('Dashboard'),
        'icon' => 'feather icon-home',
        'route' => route('dashboard.index'),
        'active' => Route::is('dashboard.index') ? 'active' : '',
        'permission' => 'view-dashboard'
    ],
    [
        'title' => __('Leads'),
        'icon' => 'feather icon-users',
        'route' => route('leads.index'),
        'active' => Route::is('leads.*') ? 'active' : '',
        'permission' => 'view-any-lead',
    ],
    [
        'title' => __('Interests'),
        'icon' => 'feather icon-heart',
        'route' => route('interests.index'),
        'active' => Route::is('interests.*') ? 'active' : '',
        'permission' => 'view-any-interest',
    ],
    [
        'title' => __('Sources'),
        'icon' => 'feather icon-search',
        'route' => route('sources.index'),
        'active' => Route::is('sources.*') ? 'active' : '',
        'permission' => 'view-any-source',
    ],
    [
        'title' => __('Developers'),
        'icon' => 'feather icon-users',
        'route' => route('developers.index'),
        'active' => Route::is('developers.*') ? 'active' : '',
        'permission' => 'view-any-developer',
    ],
    [
        'title' => __('Projects'),
        'icon' => 'feather icon-map',
        'route' => route('projects.index'),
        'active' => Route::is('projects.*') ? 'active' : '',
        'permission' => 'view-any-project',
    ],
    [
        'title' => __('Teams'),
        'icon' => 'feather icon-layers',
        'route' => route('teams.index'),
        'active' => Route::is('teams.*') ? 'active' : '',
        'permission' => 'view-any-team',
    ],
    [
        'title' => __('Events'),
        'icon' => 'feather icon-activity',
        'route' => route('events.index'),
        'active' => Route::is('events.*') ? 'active' : '',
        'permission' => 'view-any-event',
    ],
    [
        'title' => __('Branches'),
        'icon' => 'feather icon-database',
        'route' => route('branches.index'),
        'active' => Route::is('branches.*') ? 'active' : '',
        'permission' => 'view-any-branch',
    ],
    [
        'title' => __('Users'),
        'icon' => 'feather icon-user',
        'route' => route('users.index'),
        'active' => Route::is('users.*') ? 'active' : '',
        'permission' => 'view-any-user',
    ],
    [
        'title' => __('Roles'),
        'icon' => 'feather icon-lock',
        'route' => route('roles.index'),
        'active' => Route::is('roles.*') ? 'active' : '',
        'permission' => 'view-any-role',
    ],
    [
        'title' => __('Permissions'),
        'icon' => 'feather icon-shield',
        'route' => route('permissions.index'),
        'active' => Route::is('permissions.*') ? 'active' : '',
        'permission' => 'view-any-permission',
    ],
    [
        'title' => __('Reports'),
        'icon' => 'feather icon-bar-chart-2',
        'route' => route('reports.index'),
        'active' => Route::is('reports.*') ? 'active' : '',
        'permission' => 'view-reports',
    ],
    [
        'title' => __('Calendar'),
        'icon' => 'feather icon-calendar',
        'route' => route('calendar.index'),
        'active' => Route::is('calendar.*') ? 'active' : '',
        'permission' => 'view-calendar',
    ],
    [
        'title' => __('Notifications'),
        'icon' => 'feather icon-bell',
        'route' => null,
        'active' => null,
        'permissions' => ['view-notifications', 'send-notifications'],
        'sub_items' => [
            [
                'title' => __('View All'),
                'icon' => 'feather icon-circle',
                'route' => route('notifications.index'),
                'active' => Route::is('notifications.index') ? 'active' : '',
                'permission' => 'view-notifications',
            ],
            [
                'title' => __('Send'),
                'icon' => 'feather icon-circle',
                'route' => route('notifications.send'),
                'active' => Route::is('notifications.send') ? 'active' : '',
                'permission' => 'send-notifications',
            ],
        ]
    ],
    [
        'title' => __('Settings'),
        'icon' => 'feather icon-settings',
        'route' => null,
        'active' => null,
        'permissions' => ['view-general-settings', 'view-security-settings'],
        'sub_items' => [
            [
                'title' => __('General'),
                'icon' => 'feather icon-circle',
                'route' => route('settings.general'),
                'active' => Route::is('settings.general') ? 'active' : '',
                'permission' => 'view-general-settings',
            ],
            [
                'title' => __('Security'),
                'icon' => 'feather icon-circle',
                'route' => route('settings.security'),
                'active' => Route::is('settings.security') ? 'active' : '',
                'permission' => 'view-security-settings',
            ],
        ]
    ],
];
