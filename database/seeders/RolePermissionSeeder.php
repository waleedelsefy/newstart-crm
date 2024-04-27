<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Throwable;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::beginTransaction();

        try {
            $permissionsModules = [
                'dashboard' => [
                    'view-dashboard' => [
                        'en' => 'View Dashboard',
                        'ar' => 'رؤية لوحة التحكم',
                    ],
                    'employees-dashboard' => [
                        'en' => 'Dashboard Employees Section',
                        'ar' => 'قسم الموظفين في لوحة التحكم',
                    ],
                    'leads-dashboard' => [
                        'en' => 'Dashboard Leads Section',
                        'ar' => 'قسم العملاء في لوحة التحكم',
                    ],
                    'events-dashboard' => [
                        'en' => 'Dashboard Events Section',
                        'ar' => 'قسم الأحداث في لوحة التحكم',
                    ],
                    'system-dashboard' => [
                        'en' => 'Dashboard System Section',
                        'ar' => 'قسم النظام الداخلي في لوحة التحكم',
                    ],

                    // Employees Dashboard

                    'view-employees-count-dashboard' => [
                        'en' => 'View count of employees sales',
                        'ar' => 'عرض عدد الموظفين في لوحة التحكم',
                    ],
                    'view-owners-count-dashboard' => [
                        'en' => 'View count of owners in dashboard',
                        'ar' => 'عرض عدد الملاك في لوحة التحكم',
                    ],
                    'view-admins-count-dashboard' => [
                        'en' => 'View count of admins in dashboard',
                        'ar' => 'عرض عدد المديرين في لوحة التحكم',
                    ],
                    'view-marketing-count-dashboard' => [
                        'en' => 'View count of marketing in dashboard',
                        'ar' => 'عرض عدد المسوقين في لوحة التحكم',
                    ],
                    'view-sales-managers-count-dashboard' => [
                        'en' => 'View count of sales manager in dashboard',
                        'ar' => 'عرض عدد مديرين المبيعات في لوحة التحكم',
                    ],
                    'view-team-leaders-count-dashboard' => [
                        'en' => 'View count of team leaders sales in dashboard',
                        'ar' => 'عرض عدد القادة في لوحة التحكم',
                    ],
                    'view-sales-count-dashboard' => [
                        'en' => 'View count of sales in dashboard',
                        'ar' => 'عرض عدد موظفين المبيعات في لوحة التحكم',
                    ],
                    'view-senior-sales-count-dashboard' => [
                        'en' => 'View count of senior sales in dashboard',
                        'ar' => 'عرض عدد موظفين المبيعات المحترفين في لوحة التحكم',
                    ],
                    'view-junior-sales-count-dashboard' => [
                        'en' => 'View count of junior sales in dashboard',
                        'ar' => 'عرض عدد موظفين المبيعات المبتدئين في لوحة التحكم',
                    ],

                    // Leads Dashboard

                    'view-leads-count-dashboard' => [
                        'en' => 'View count of leads in dashboard',
                        'ar' => 'عرض عدد العملاء في لوحة التحكم',
                    ],
                    'view-leads-you-created-count-dashboard' => [
                        'en' => 'View count of leads that created by you in dashboard',
                        'ar' => 'عرض عدد العملاء الذين انشئتهم في لوحة التحكم',
                    ],
                    'view-leads-assigned-by-you-count-dashboard' => [
                        'en' => 'View count of leads that assigned by you in dashboard',
                        'ar' => 'عرض عدد العملاء المعينين عن طريقي في لوحة التحكم',
                    ],
                    'view-teams-count-dashboard' => [
                        'en' => 'View count of teams in dashboard',
                        'ar' => 'عرض عدد الفرق في لوحة التحكم',
                    ],
                    'view-teams-i-lead-count-dashboard' => [
                        'en' => 'View count of teams that i lead in it in dashboard',
                        'ar' => 'عرض عدد الفرق التي انا قائد فيها في لوحة التحكم',
                    ],
                    'view-teams-i-member-count-dashboard' => [
                        'en' => 'View count of teams that i member in it in dashboard',
                        'ar' => 'عرض عدد الفرق التي انا عضو فيها في لوحة التحكم',
                    ],

                    // Events Dashboard

                    'view-event-today-count-dashboard' => [
                        'en' => 'View today event count in dashboard',
                        'ar' => 'عرض عدد الحدث today في لوحة التحكم',
                    ],
                    'view-event-upcoming-count-dashboard' => [
                        'en' => 'View upcoming event count in dashboard',
                        'ar' => 'عرض عدد الحدث upcoming في لوحة التحكم',
                    ],
                    'view-event-delay-count-dashboard' => [
                        'en' => 'View delay event count in dashboard',
                        'ar' => 'عرض عدد الحدث delay في لوحة التحكم',
                    ],

                    // System Dashboard

                    'view-branches-count-dashboard' => [
                        'en' => 'View branches count in dashboard',
                        'ar' => 'عرض عدد الفروع في لوحة التحكم',
                    ],
                    'view-projects-count-dashboard' => [
                        'en' => 'View projects count in dashboard',
                        'ar' => 'عرض عدد المشاريع في لوحة التحكم',
                    ],
                    'view-developers-count-dashboard' => [
                        'en' => 'View developers count in dashboard',
                        'ar' => 'عرض عدد المطورين في لوحة التحكم',
                    ],
                    'view-interests-count-dashboard' => [
                        'en' => 'View interests count in dashboard',
                        'ar' => 'عرض عدد الاهتمامات في لوحة التحكم',
                    ],
                    'view-sources-count-dashboard' => [
                        'en' => 'View sources count in dashboard',
                        'ar' => 'عرض عدد المصادر في لوحة التحكم',
                    ],
                    'view-events-count-dashboard' => [
                        'en' => 'View events count in dashboard',
                        'ar' => 'عرض عدد الاحداث في لوحة التحكم',
                    ],

                ],
                'leads' => [
                    'view-any-lead' => [
                        'en' => 'View any lead',
                        'ar' => 'رؤية كل العملاء',
                    ],
                    'view-lead' => [
                        'en' => 'View lead',
                        'ar' => 'رؤية تفاصيل العميل ',
                    ],
                    'create-lead' => [
                        'en' => 'Create Lead',
                        'ar' => 'إنشاء عميل',
                    ],
                    'update-lead' => [
                        'en' => 'Update Lead',
                        'ar' => 'تعديل عميل',
                    ],
                    'delete-lead' => [
                        'en' => 'Delete Lead',
                        'ar' => 'حذف عميل',
                    ],
                    'import-lead-excel' => [
                        'en' => 'Import leads from Excel sheet',
                        'ar' => 'استيراد عملاء من ملف اكسيل',
                    ],
                    'export-lead-excel' => [
                        'en' => 'Export leads to Excel sheet',
                        'ar' => 'تصدير عملاء لملف اكسيل',
                    ],
                ],
                'view lead fields' => [
                    'view-lead-select' => [
                        'en' => 'View lead select',
                        'ar' => 'رؤية عمود اختيار اكثر من عميل',
                    ],
                    'view-lead-name' => [
                        'en' => 'View lead name',
                        'ar' => 'رؤية اسم العميل',
                    ],
                    'view-lead-notes' => [
                        'en' => 'View lead notes',
                        'ar' => 'رؤية ملاحظات العميل',
                    ],
                    'view-lead-interests' => [
                        'en' => 'View lead interests',
                        'ar' => 'رؤية اهتمامات العميل',
                    ],
                    'view-lead-sources' => [
                        'en' => 'View lead sources',
                        'ar' => 'رؤية مصادر العميل',
                    ],
                    'view-lead-assigned-by' => [
                        'en' => 'View lead assigned by who',
                        'ar' => 'رؤية من قام بتعيين العميل',
                    ],
                    'view-lead-assigned-to' => [
                        'en' => 'View lead name assigned to who',
                        'ar' => 'رؤية لمن تم تعيين العميل',
                    ],
                    'view-lead-event' => [
                        'en' => 'View lead event',
                        'ar' => 'رؤية الحدث الحالي للعميل',
                    ],
                    'view-lead-duplicates' => [
                        'en' => 'View lead duplicates',
                        'ar' => 'رؤية تكرارات العميل',
                    ],
                    'view-lead-created-by' => [
                        'en' => 'View lead created by who',
                        'ar' => 'رؤية من انشئ العميل',
                    ],
                    'view-lead-created-at' => [
                        'en' => 'View lead created at',
                        'ar' => 'رؤية متى تم انشاء العميل',
                    ],
                    'view-lead-history-list' => [
                        'en' => 'View lead history list',
                        'ar' => 'رؤية قائمة سجل العميل',
                    ],
                    'view-lead-history-all' => [
                        'en' => 'View all lead history',
                        'ar' => 'رؤية جميع سجلات العميل',
                    ],
                ],
                'update lead fields' => [
                    'update-lead-name' => [
                        'en' => 'Update lead name',
                        'ar' => 'تحديث اسم العميل',
                    ],
                    'update-lead-notes' => [
                        'en' => 'Update lead notes',
                        'ar' => 'تحديث ملاحظات العميل',
                    ],
                    'update-lead-interests' => [
                        'en' => 'Update lead interests',
                        'ar' => 'تحديث اهتمامات العميل',
                    ],
                    'update-lead-sources' => [
                        'en' => 'Update lead sources',
                        'ar' => 'تحديث مصادر العميل',
                    ],
                    'update-lead-branch' => [
                        'en' => 'Update lead branch',
                        'ar' => 'تحديث الفرع التابع له العميل',
                    ],
                ],
                'leads operations' => [
                    'view-lead-from-all-branches' => [
                        'en' => 'View leads from all branches',
                        'ar' => 'رؤية عملاء كل الفروع',
                    ],
                    'view-unassigned-lead' => [
                        'en' => 'View unassigned lead',
                        'ar' => 'رؤية العملاء غير المعينين لي',
                    ],
                    'view-unassigned-lead-duplicates' => [
                        'en' => 'View unassigned lead duplicates',
                        'ar' => 'رؤية تكرارت العملاء غير المعينين لي',
                    ],
                    'view-lead-not-createdby-me' => [
                        'en' => 'View leads that not created by me',
                        'ar' => 'رؤية العملاء الغير منشئين عن طريقي',
                    ],
                    'assign-lead-to-employee' => [
                        'en' => 'Assign lead to employee',
                        'ar' => 'تعيين عميل الى موظف',
                    ],
                    'available-for-assign-leads-to-him' => [
                        'en' => 'Available for assign a leads to him',
                        'ar' => 'متاح لتعيين عملاء له',
                    ],
                    'change-lead-event' => [
                        'en' => 'Change lead event',
                        'ar' => 'تغيير الحدث على عميل',
                    ],
                    'change-unassigned-lead-event' => [
                        'en' => 'Change unassigned lead event',
                        'ar' => 'تغيير الحدث على عميل غير معين لي',
                    ],
                    'view-lead-multi-options' => [
                        'en' => 'View lead multi options',
                        'ar' => 'رؤية زر العمليات المجمعة'
                    ],
                ],
                'lead filters' => [
                    'lead-search-filter' => [
                        'en' => 'Search',
                        'ar' => 'البحث',
                    ],
                    'lead-branch-filter' => [
                        'en' => 'Filter by branch',
                        'ar' => 'التصفية حسب الفرع',
                    ],
                    'lead-event-filter' => [
                        'en' => 'Filter by event',
                        'ar' => 'التصفية حسب الحدث',
                    ],
                    'lead-reminder-filter' => [
                        'en' => 'Filter by reminder',
                        'ar' => 'التصفية حسب التذكير',
                    ],
                    'lead-assign-to-filter' => [
                        'en' => 'Filter by assign to',
                        'ar' => 'التصفية حسب معين الى',
                    ],
                    'lead-assign-to-user-filter' => [
                        'en' => 'Filter by assign to user',
                        'ar' => 'التصفية حسب معين الى مستخدم',
                    ],
                    'lead-assign-to-team-filter' => [
                        'en' => 'Filter by assign to team',
                        'ar' => 'التصفية حسب معين الى فريق',
                    ],
                    'lead-assign-by-user-filter' => [
                        'en' => 'Filter by assign by',
                        'ar' => 'التصفية حسب معين عن طريق مستخدم',
                    ],
                    'lead-source-filter' => [
                        'en' => 'Filter by source',
                        'ar' => 'التصفية حسب المصدر',
                    ],
                    'lead-interest-filter' => [
                        'en' => 'Filter by interest',
                        'ar' => 'التصفية حسب الاهتمام',
                    ],
                    'lead-project-filter' => [
                        'en' => 'Filter by project',
                        'ar' => 'التصفية حسب المشروع',
                    ],
                    'lead-created-by-filter' => [
                        'en' => 'Filter by created by',
                        'ar' => 'التصفية حسب منشئ عن طريق',
                    ],
                    'lead-created-at-filter' => [
                        'en' => 'Filter by created at',
                        'ar' => 'التصفية حسب تاريخ الانشاء',
                    ],
                    'lead-not-assigned-filter' => [
                        'en' => 'Filter by not assigned',
                        'ar' => 'التصفية حسب الغير معين',
                    ]
                ],
                'team leads' => [
                    'view-team-member-lead' => [
                        'en' => 'View team member lead',
                        'ar' => 'رؤية العملاء المعينة لعضو في فريقي',
                    ],
                    'view-team-member-lead-duplicates' => [
                        'en' => 'View team member lead duplicates',
                        'ar' => 'رؤية تكرارات العملاء المعينة لعضو في فريقي',
                    ],
                    'change-team-member-lead-event' => [
                        'en' => 'Change Team lead event',
                        'ar' => 'تغيير الحدث على عميل معين لعضو في فريقي',
                    ],
                ],
                'lead phones' => [
                    'view-lead-phones' => [
                        'en' => 'View lead phones',
                        'ar' => 'رؤية ارقام العميل',
                    ],
                    'create-lead-phones' => [
                        'en' => 'Create lead phones',
                        'ar' => 'اضافة ارقام للعميل',
                    ],
                    'update-lead-phones' => [
                        'en' => 'Update lead phones',
                        'ar' => 'تحديث ارقام العميل',
                    ],
                    'delete-lead-phones' => [
                        'en' => 'Delete lead phones',
                        'ar' => 'حذف ارقام العميل',
                    ],
                ],
                'lead projects' => [
                    'view-lead-projects' => [
                        'en' => 'View lead projects',
                        'ar' => 'رؤية مشاريع العميل',
                    ],
                    'create-lead-projects' => [
                        'en' => 'Create lead projects',
                        'ar' => 'اضافة مشاريع للعميل',
                    ],
                    'delete-lead-projects' => [
                        'en' => 'Delete lead projects',
                        'ar' => 'حذف مشاريع العميل',
                    ],
                ],
                'interests' => [
                    'view-any-interest' => [
                        'en' => 'View any Interest',
                        'ar' => 'رؤية كل الاهتمامات',
                    ],
                    'view-interest' => [
                        'en' => 'View Interest',
                        'ar' => 'رؤية اهتمام',
                    ],
                    'create-interest' => [
                        'en' => 'Create Interest',
                        'ar' => 'إنشاء اهتمام',
                    ],
                    'update-interest' => [
                        'en' => 'Update Interest',
                        'ar' => 'تعديل اهتمام',
                    ],
                    'delete-interest' => [
                        'en' => 'Delete Interest',
                        'ar' => 'حذف اهتمام',
                    ],
                ],
                'sources' => [
                    'view-any-source' => [
                        'en' => 'View any Source',
                        'ar' => 'رؤية كل المصادر',
                    ],
                    'view-source' => [
                        'en' => 'View Source',
                        'ar' => 'رؤية مصدر',
                    ],
                    'create-source' => [
                        'en' => 'Create Source',
                        'ar' => 'إنشاء مصدر',
                    ],
                    'update-source' => [
                        'en' => 'Update Source',
                        'ar' => 'تعديل مصدر',
                    ],
                    'delete-source' => [
                        'en' => 'Delete Source',
                        'ar' => 'حذف مصدر',
                    ],

                ],
                'developers' => [
                    'view-any-developer' => [
                        'en' => 'View any Developer',
                        'ar' => 'رؤية كل المطورين',
                    ],
                    'view-developer' => [
                        'en' => 'View Developer',
                        'ar' => 'رؤية مطور',
                    ],
                    'create-developer' => [
                        'en' => 'Create Developer',
                        'ar' => 'إنشاء مطور',
                    ],
                    'update-developer' => [
                        'en' => 'Update Developer',
                        'ar' => 'تعديل مطور',
                    ],
                    'delete-developer' => [
                        'en' => 'Delete Developer',
                        'ar' => 'حذف مطور',
                    ],

                ],
                'projects' => [
                    'view-any-project' => [
                        'en' => 'View any Project',
                        'ar' => 'رؤية كل المشاريع',
                    ],
                    'view-project' => [
                        'en' => 'View Project',
                        'ar' => 'رؤية مشروع',
                    ],
                    'create-project' => [
                        'en' => 'Create Project',
                        'ar' => 'إنشاء مشروع',
                    ],
                    'update-project' => [
                        'en' => 'Update Project',
                        'ar' => 'تعديل مشروع',
                    ],
                    'delete-project' => [
                        'en' => 'Delete Project',
                        'ar' => 'حذف مشروع',
                    ],

                ],
                'teams' => [
                    'view-any-team' => [
                        'en' => 'View any Team',
                        'ar' => 'رؤية كل الفرق',
                    ],
                    'view-team' => [
                        'en' => 'View Team',
                        'ar' => 'رؤية فريق',
                    ],
                    'view-team-not-createdby-me' => [
                        'en' => 'View Team not created by me',
                        'ar' => 'رؤية فريق لم انشئه',
                    ],
                    'view-team-not-leadby-me' => [
                        'en' => 'View Team not lead by me',
                        'ar' => 'رؤية فريق لست قائد فيه',
                    ],
                    'view-team-not-member-in' => [
                        'en' => 'View Team not member in it',
                        'ar' => 'رؤية فريق لست عضو فيه',
                    ],
                    'create-team' => [
                        'en' => 'Create Team',
                        'ar' => 'إنشاء فريق',
                    ],
                    'update-team' => [
                        'en' => 'Update Team',
                        'ar' => 'تعديل فريق',
                    ],
                    'delete-team' => [
                        'en' => 'Delete Team',
                        'ar' => 'حذف فريق',
                    ],

                ],
                'events' => [
                    'view-any-event' => [
                        'en' => 'View any Event',
                        'ar' => 'رؤية كل الاحداث',
                    ],
                    'view-event' => [
                        'en' => 'View Event',
                        'ar' => 'رؤية حدث',
                    ],
                    'create-event' => [
                        'en' => 'Create Event',
                        'ar' => 'إنشاء حدث',
                    ],
                    'update-event' => [
                        'en' => 'Update Event',
                        'ar' => 'تعديل حدث',
                    ],
                    'delete-event' => [
                        'en' => 'Delete Event',
                        'ar' => 'حذف حدث',
                    ],

                ],
                'branches' => [
                    'view-any-branch' => [
                        'en' => 'View any Branch',
                        'ar' => 'رؤية كل الفروع',
                    ],
                    'view-branch' => [
                        'en' => 'View Branch',
                        'ar' => 'رؤية فرع',
                    ],
                    'create-branch' => [
                        'en' => 'Create Branch',
                        'ar' => 'إنشاء فرع',
                    ],
                    'update-branch' => [
                        'en' => 'Update Branch',
                        'ar' => 'تعديل فرع',
                    ],
                    'delete-branch' => [
                        'en' => 'Delete Branch',
                        'ar' => 'حذف فرع',
                    ],

                ],
                'users' => [
                    'view-any-user' => [
                        'en' => 'View any User',
                        'ar' => 'رؤية كل المستخدمين',
                    ],
                    'view-user' => [
                        'en' => 'View User',
                        'ar' => 'رؤية مستخدم',
                    ],
                    'view-user-from-all-branches' => [
                        'en' => 'View users from all branches',
                        'ar' => 'رؤية مستخدمين كل الفروع',
                    ],
                    'view-user-not-createdby-me' => [
                        'en' => 'View users that not created by me',
                        'ar' => 'رؤية المستخدمين الغير منشئين عن طريقي',
                    ],
                    'create-user' => [
                        'en' => 'Create User',
                        'ar' => 'إنشاء مستخدم',
                    ],
                    'update-user' => [
                        'en' => 'Update User',
                        'ar' => 'تعديل مستخدم',
                    ],
                    'update-user-permissions' => [
                        'en' => 'Update User Permissions',
                        'ar' => 'تعديل صلاحية المستخدم',
                    ],
                    'update-user-role' => [
                        'en' => 'Update User Role',
                        'ar' => 'تعديل دور المستخدم',
                    ],
                    'update-user-branch' => [
                        'en' => 'Update User Branch',
                        'ar' => 'تعديل فرع المستخدم',
                    ],
                    'update-user-abilities' => [
                        'en' => 'Update User Abilities',
                        'ar' => 'تعديل قدرات المستخدم',
                    ],
                    'delete-user' => [
                        'en' => 'Delete User',
                        'ar' => 'حذف مستخدم',
                    ],
                    'available-for-join-to-team' => [
                        'en' => 'Available for join to a team',
                        'ar' => 'متاح لإضافته لفريق',
                    ],
                    'change-current-branch' => [
                        'en' => 'Change his current branch',
                        'ar' => 'تغيير الفرع الحالي',
                    ],
                ],
                'roles' => [
                    'view-any-role' => [
                        'en' => 'View any Role',
                        'ar' => 'رؤية كل الادوار',
                    ],
                    'view-role' => [
                        'en' => 'View Role',
                        'ar' => 'رؤية دور',
                    ],
                    'create-role' => [
                        'en' => 'Create Role',
                        'ar' => 'إنشاء دور',
                    ],
                    'update-role' => [
                        'en' => 'Update Role',
                        'ar' => 'تعديل دور',
                    ],
                    'delete-role' => [
                        'en' => 'Delete Role',
                        'ar' => 'حذف دور',
                    ],

                ],
                'permissions' => [
                    'view-any-permission' => [
                        'en' => 'View any Permission',
                        'ar' => 'رؤية كل الصلاحيات',
                    ],
                    'view-permission' => [
                        'en' => 'View Permission',
                        'ar' => 'رؤية صلاحية',
                    ],
                    'create-permission' => [
                        'en' => 'Create Permission',
                        'ar' => 'إنشاء صلاحية',
                    ],
                    'update-permission' => [
                        'en' => 'Update Permission',
                        'ar' => 'تعديل صلاحية',
                    ],
                    'delete-permission' => [
                        'en' => 'Delete Permission',
                        'ar' => 'حذف صلاحية',
                    ],

                ],
                'calendar' => [
                    'view-calendar' => [
                        'en' => 'View Calendar',
                        'ar' => 'مشاهدة التذكيرات'
                    ]
                ],
                'reports' => [
                    'view-reports' => [
                        'en' => 'View the reports',
                        'ar' => 'عرض التقارير',
                    ],
                    'view-sales-reports' => [
                        'en' => 'View sales reports',
                        'ar' => 'مشاهدة تقارير المبيعات',
                    ],
                    'view-marketing-reports' => [
                        'en' => 'View marketing reports',
                        'ar' => 'مشاهدة تقارير التسويق',
                    ],
                    'view-assign-reports' => [
                        'en' => 'View assign reports',
                        'ar' => 'مشاهدة تقارير التعيين',
                    ],
                    'view-created-reports' => [
                        'en' => 'View created reports',
                        'ar' => 'مشاهدة تقارير الاضافة',
                    ],
                    'view-my-reports-reports' => [
                        'en' => 'View my reports charts',
                        'ar' => 'مشاهدة تقاريري البيانية',
                    ],
                    'view-sources-reports' => [
                        'en' => 'View sources reports',
                        'ar' => 'مشاهدة تقارير المصادر'
                    ],
                    'view-projects-reports' => [
                        'en' => 'View projects reports',
                        'ar' => 'مشاهدة تقارير المشاريع'
                    ],
                    'view-interests-reports' => [
                        'en' => 'View interests reports',
                        'ar' => 'مشاهدة تقارير الاهتمامات'
                    ],
                ],
                'notifications' => [
                    'view-notifications' => [
                        'en' => 'View All Notifications',
                        'ar' => 'رؤية جميع الاشعارات',
                    ],
                    'send-notifications' => [
                        'en' => 'Send Notifications',
                        'ar' => 'ارسال اشعارات',
                    ],
                ],
                'settings' => [
                    'view-general-settings' => [
                        'en' => 'View general settings',
                        'ar' => 'رؤية الاعدادات العامة'
                    ],
                    'view-security-settings' => [
                        'en' => 'View security settings',
                        'ar' => 'رؤية اعدادات الحماية'
                    ],
                    'use-floating-box' => [
                        'en' => 'Use floating box',
                        'ar' => 'استخدام الادوات السريعة'
                    ],
                ]
            ];

            $roles = [
                'admin' => [
                    'en' => 'Admin',
                    'ar' => 'مدير',
                ],
                'marketing' => [
                    'en' => 'Marketing',
                    'ar' => 'موظف تسويق',
                ],
                'marketing-manager' => [
                    'en' => 'Marketing Manager',
                    'ar' => 'مدير تسويق',
                ],
                'marketing-team-leader' => [
                    'en' => 'Marketing Team Leader',
                    'ar' => 'قائد فريق تسويق',
                ],
                'sales-manager' => [
                    'en' => 'Sales Manager',
                    'ar' => 'مدير مبيعات',
                ],
                'sales-team-leader' => [
                    'en' => 'Team Leader',
                    'ar' => 'قائد فريق مبيعات',
                ],
                'junior-sales' => [
                    'en' => 'Junior Sales',
                    'ar' => 'موظف مبيعات مبتدأ',
                ],
                'senior-sales' => [
                    'en' => 'Senior Sales',
                    'ar' => 'موظف مبيعات محترف',
                ],
            ];

            foreach ($permissionsModules as $module => $permissions) {
                foreach ($permissions as $key => $value) {
                    Permission::create([
                        'module' => $module,
                        'name' => $key,
                        'display_name' => $value,
                    ]);
                }
            }

            foreach ($roles as $key => $value) {
                $role = Role::create([
                    'name' => $key,
                    'display_name' => $value,
                ]);

                if ($key == 'admin')
                    $role->permissions()->attach(Permission::get()->pluck('id')->toArray());
                else
                    $role->permissions()->attach(Permission::limit(10)->get()->pluck('id')->toArray());
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }
    }
}
