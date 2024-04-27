<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Leads\LeadController;
use App\Http\Controllers\Leads\LeadPhoneNumberController;
use App\Http\Controllers\Leads\LeadProjectController;
use App\Http\Controllers\Leads\MultiOperationsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\TeamController;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(['middleware' => ['auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {


    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::put('/change-branch', [DashboardController::class, 'changeBranch'])->name('dashboard.change-branch');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/send', [NotificationController::class, 'send'])->name('notifications.send');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::get('/notifications/markAllAsRead', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');


    Route::group(['prefix' => 'leads/multi-operations', 'as' => 'leads.multi-operations.'], function () {
        Route::get('assign-to', [MultiOperationsController::class, 'assignToView'])->name('assign-to');
        Route::post('assign-to', [MultiOperationsController::class, 'assignTo']);

        Route::get('add-event', [MultiOperationsController::class, 'addEventView'])->name('add-event');
        Route::post('add-event', [MultiOperationsController::class, 'addEvent']);

        Route::get('add-sources', [MultiOperationsController::class, 'addSourcesView'])->name('add-sources');
        Route::post('add-sources', [MultiOperationsController::class, 'addSources']);

        Route::get('add-interests', [MultiOperationsController::class, 'addInterestsView'])->name('add-interests');
        Route::post('add-interests', [MultiOperationsController::class, 'addInterests']);

        Route::delete('destroy', [MultiOperationsController::class, 'destroy'])->name('destroy');
    });


    Route::post('leads/{lead}/assing', [LeadController::class, 'assignToModal'])->name('leads.assign');
    Route::patch('leads/{lead}/assing', [LeadController::class, 'assignTo']);

    Route::get('leads/{lead}/event', [LeadController::class, 'editEvent'])->name('leads.event');
    Route::post('leads/{lead}/event', [LeadController::class, 'updateEvent']);

    Route::get('leads/{lead}/duplicates', [LeadController::class, 'duplicates'])->name('leads.duplicates');

    Route::post('leads/import', [LeadController::class, 'import'])->name('leads.import');
    Route::post('leads/export', [LeadController::class, 'export'])->name('leads.export');
    Route::get('leads/export', [LeadController::class, 'exportDownload'])->name('leads.export.download');

    Route::resource('leads', LeadController::class);
    Route::resource('leads.phones', LeadPhoneNumberController::class);
    Route::resource('leads.projects', LeadProjectController::class);

    Route::resource('interests', InterestController::class);
    Route::resource('sources', SourceController::class);
    Route::resource('developers', DeveloperController::class);
    Route::resource('projects', ProjectController::class);

    Route::get('teams/{team}/members', [TeamController::class, 'members'])->name('teams.members');
    Route::put('teams/{team}/members', [TeamController::class, 'updateMembers'])->name('teams.update-members');
    Route::resource('teams', TeamController::class);

    Route::resource('events', EventController::class);

    Route::post('ajaxProjectsByDeveloper', [ProjectController::class, 'ajaxProjectsByDeveloper'])->name('ajaxProjectsByDeveloper');

    Route::resource('branches', BranchController::class);

    Route::group(['prefix' => 'users', 'as' => 'users.', 'controller' => UserController::class], function () {
        Route::put('/{user}/update-password', 'updatePassword')->name('update-password');
        Route::put('/{user}/update-photo', 'updatePhoto')->name('update-photo');

        Route::get('/{user}/before-deleting', 'beforeDeletingView')->name('before-deleting');
        Route::delete('/{user}/before-deleting', 'beforeDeleting');
    });
    Route::resource('users', UserController::class);

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);


    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales.index');
    Route::get('reports/marketing', [ReportController::class, 'marketing'])->name('reports.marketing.index');
    Route::get('reports/assign', [ReportController::class, 'assign'])->name('reports.assign.index');
    Route::get('reports/created', [ReportController::class, 'created'])->name('reports.created.index');
    Route::get('reports/my-reports', [ReportController::class, 'myReports'])->name('reports.my-reports.index');
    Route::get('reports/sources', [ReportController::class, 'sources'])->name('reports.sources.index');
    Route::get('reports/projects', [ReportController::class, 'projects'])->name('reports.projects.index');
    Route::get('reports/interests', [ReportController::class, 'interests'])->name('reports.interests.index');

    Route::get('comparison/{type}', [ComparisonController::class, 'index'])->name('comparison.index');

    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');

    Route::group([
        'prefix' => 'settings',
        'as' => 'settings.',
        'controller' => SettingsController::class,
        'middleware' => ['password.confirm']
    ], function () {
        Route::get('security', 'security')->name('security');
        Route::get('general', 'general')->name('general');
        Route::put('update-profile-photo', 'updateProfilePhoto')->name('user-profile-photo.update');
    });
});

require_once __DIR__ . '/fortify.php';
