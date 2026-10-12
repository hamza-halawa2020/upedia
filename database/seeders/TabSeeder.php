<?php

namespace Database\Seeders;

use RuntimeException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TabSeeder extends Seeder
{
    public function run(): void
    {
        $SETTING_URL = Config::get('app.SETTINGS_URL', 'https://upedia-setting.thetailors.tech/');
        $ACADEMY_URL = Config::get('app.ACADEMY_URL', 'https://upedia-academy.thetailors.tech/');
        $HR_URL = Config::get('app.HR_URL', 'https://upedia-hr.thetailors.tech/');
        $FINANCE_URL = Config::get('app.FINANCE_URL', 'https://upedia-finance.thetailors.tech/');
        $CRM_URL = Config::get('app.CRM_URL', 'https://upedia-crm.thetailors.tech/');
        $Retention_URL = Config::get('app.Retention_URL', 'https://upedia-retention.thetailors.tech/');
        $IT_URL = Config::get('app.IT_URL', 'https://upedia-it.thetailors.tech/');
        $MARKETING_URL = Config::get('app.MARKETING_URL', 'https://upedia-marketing.thetailors.tech/');
        $EXAM_URL = Config::get('app.EXAM_URL', 'https://upedia-exam2.thetailors.tech/');

        // $SETTING_URL    = 'http://setting.upedia.test/';
        // $ACADEMY_URL    = 'http://academic.upedia.test/';
        // $HR_URL         = 'http://hr.upedia.test/';
        // $FINANCE_URL    = 'http://finance.upedia.test/';
        // $CRM_URL        = 'http://crm.upedia.test/';
        // $Retention_URL  = 'http://retention.upedia.test/';
        // $IT_URL         = 'http://it.upedia.test/';
        // $MARKETING_URL  = 'http://marketing.upedia.test/';
        // $EXAM_URL       = 'http://exam.upedia.test/';

        $tabs = [
            [1, 'Dashboard', $HR_URL, 'mdi:home-outline', null, null, 0, '["settings","academy","hr","finance","crm","retention","it","marketing"]'],
            [2, 'Schedule', null, 'mdi:calendar-clock', null, null, 2, '["retention"]'],
            [3, 'Company Structure', null, 'mdi:book-open-page-variant', null, null, 3, '["hr"]'],
            [4, 'Configurations', null, 'mdi:cog-outline', null, null, 36, '["settings","academy","hr","finance","crm","retention","it","marketing"]'],
            [5, 'Demo', null, 'mdi:play-circle-outline', null, null, 3, '["retention"]'],
            // [6, 'Schedule Products', NULL, 'mdi:package-variant-closed', NULL, NULL, 3, '["retention"]'],
            [7, 'Activities', $Retention_URL.'products/all', 'mdi:view-list', 28, 'retention_products_index', 1, '["retention"]'],
            [11, 'Demo', $Retention_URL.'products/all?type=demo', 'mdi:tag-outline', 5, 'retention_products_index', 5, '["retention"]'],
            [15, 'Academic', null, 'mdi:package-variant-closed', null, null, 1, '["academy"]'],
            [16, 'Testers', $HR_URL.'staffs?job_title_id=5', 'mdi:school-outline', 15, 'hr_staffs_index', 8, '["hr"]'],
            [17, 'Teachers', $HR_URL.'staffs?job_title_id=4', 'mdi:account-check-outline', 15, 'hr_staffs_index', 7, '["hr"]'],
            [18, 'Teams', $HR_URL.'teams', 'mdi:account-group-outline', 15, 'hr_view_teams', 10, '["hr"]'],
            [19, 'Students', $Retention_URL.'students', 'mdi:school-outline', 192, 'retention_students_index', 11, '["retention"]'],
            [20, 'Urgent', $Retention_URL.'urgents', 'mdi:alert-circle-outline', null, 'retention_urgents_index', 15, '["retention"]'],
            [21, 'Demo Schedule', $Retention_URL.'schedule-demo', 'mdi:calendar-check-outline', 5, 'retention_schedule_product', 1, '["retention"]'],
            // [22, 'Scheduled Demos', $Retention_URL.'show-demo', 'mdi:eye-outline', 5, 'retention_schedule_product_show', 2, '["retention"]'],
            [23, 'Schedule Calendar', $Retention_URL.'calendar', 'mdi:calendar-month', 2, 'retention_calendar_index', 1, '["retention"]'],
            [24, 'Schedule', $Retention_URL.'schedule', 'mdi:calendar-plus', 2, 'retention_schedule_index', 2, '["retention"]'],
            [25, 'live-sessions', $Retention_URL.'live-sessions', 'mdi:video-outline', 2, 'retention_live_sessions_index', 3, '["retention"]'],
            [26, 'academy live-sessions', $ACADEMY_URL.'live-sessions', 'mdi:video-outline', 2, 'academy_live_sessions_index', 4, '["academy"]'],
            [27, 'Courses', $Retention_URL.'courses', 'mdi:book-education-outline', 2, 'retention_courses_index', 5, '["retention"]'],
            [28, 'Sessions', null, 'mdi:package-variant-closed', null, null, 4, '["academy","retention"]'],
            [29, 'Sessions', $Retention_URL.'sessions', 'mdi:play-circle', 28, 'retention_sessions_index', 1, '["retention"]'],
            [30, 'Recorded Sessions', $ACADEMY_URL.'recorded-sessions', 'mdi:account-group-outline', 28, 'academy_recorded_sessions_index', 2, '["academy"]'],
            [31, 'Sales invoices', $FINANCE_URL.'student_invoices', 'mdi:receipt-text-outline', 229, 'finance_student_invoices_index', 2, '["finance"]'],
            [32, 'Payroll Invoices', $FINANCE_URL.'payroll_report', 'mdi:currency-usd', null, null, 15, '["finance"]'],
            // [33, 'Expenses', $FINANCE_URL.'expenses', 'mdi:cash-minus', 158, 'finance_expenses_index', 16, '["finance"]'],
            // [34, 'Incomes', $FINANCE_URL.'incomes', 'mdi:cash-plus', null, 'finance_incomes_index', 17, '["finance"]'],
            [35, 'Profit & Loss', $FINANCE_URL.'profit_loss', 'mdi:chart-line', null, 'finance_profit_loss_index', 18, '["finance"]'],
            [36, 'Promo Codes', $FINANCE_URL.'promocodes', 'mdi:ticket-percent-outline', null, 'finance_promocodes_index', 19, '["finance"]'],
            [37, 'Employees', $HR_URL.'staffs', 'mdi:account-group-outline', 3, 'hr_staffs_index', 1, '["hr"]'],
            [38, 'Departments', $HR_URL.'departments', 'mdi:office-building-outline', 3, 'hr_departments_index', 2, '["hr"]'],
            [39, 'Job Titles', $HR_URL.'job_titles', 'mdi:briefcase-outline', 3, 'hr_job_titles_index', 3, '["hr"]'],
            [41, 'Attendance', $HR_URL.'attendences', 'mdi:calendar-check', 129, 'hr_attendences_index', 20, '["hr"]'],
            [43, 'Leave Types', $HR_URL.'leave_types', 'mdi:calendar-blank-outline', 4, 'hr_leave_types_index', 22, '["hr"]'],
            // [44, 'Leave Requests', $HR_URL.'leave_requests', 'mdi:calendar-question', NULL, 'hr_leave_requests_index', 23, '["hr"]'],
            [45, 'Hr Letter', $HR_URL.'hr_letter', 'mdi:email-outline', 91, 'hr_request_letter_index', 24, '["hr"]'],
            [46, 'Requests', $HR_URL.'requests', 'mdi:file-document-outline', 91, 'hr_request_letter_index', 17, '["hr"]'],
            [48, 'Roles', $SETTING_URL.'roles', 'mdi:shield-account', 4, 'general_roles_index', 27, '["settings"]'],
            [49, 'Tasks', $HR_URL.'tasks', 'mdi:checkbox-marked-outline', null, 'hr_task_index', 33, '["hr"]'],
            [50, 'Shared Files', $HR_URL.'share-center-all', 'mdi:share-variant', 131, 'hr_share_center_index', 14, '["hr"]'],
            [51, 'Shared Folders', $HR_URL.'share-center-folders', 'mdi:folder-multiple-outline', 131, 'hr_share_center_folder_index', 1, '["hr"]'],
            [52, 'Create Shared File', $HR_URL.'share-center', 'mdi:share-variant', 131, 'hr_share_center_index', 2, '["hr"]'],
            [53, 'Staff Time Slots', $HR_URL.'slot_emp', 'mdi:account-clock-outline', 4, 'hr_slots_index', 3, '["hr"]'],
            [54, 'Categories', $Retention_URL.'categories', 'mdi:shape-outline', 4, 'retention_categories_index', 4, '["retention"]'],
            [55, 'Track Types', $Retention_URL.'track-types', 'mdi:road-variant', 4, 'retention_track_types_index', 5, '["retention"]'],
            [56, 'Tracks', $Retention_URL.'tracks', 'mdi:map-marker-path', 4, 'retention_tracks_index', 6, '["retention"]'],
            [57, 'Plan Types', $Retention_URL.'pricing_plan_types', 'mdi:cash-100', 4, 'retention_pricing_plan_types_index', 7, '["retention"]'],
            [58, 'Discount Plans', $Retention_URL.'discount_plans', 'mdi:percent-outline', 4, 'retention_discount_plans_index', 8, '["retention"]'],
            [59, 'Activities Categories', $Retention_URL.'product_types', 'mdi:package-variant', 4, 'retention_product_types_index', 9, '["retention"]'],
            // [61, 'Email Settings', $CRM_URL.'email-settings', 'mdi:email-cog-outline', 4, 'crm_email-settings_index', 11, '["crm"]'],
            [62, 'Social Settings', $CRM_URL.'settings/index', 'mdi:email-cog-outline', 4, 'crm_media-settings_index', 12, '["crm"]'],
            [63, 'Referral Settings', $CRM_URL.'referralsettings', 'mdi:email-cog-outline', 4, 'crm_referral-settings_index', 13, '["crm"]'],
            [64, 'Referral Activity', $CRM_URL.'referralactivities', 'mdi:account-star-outline', 4, 'crm_referral-view', 14, '["crm"]'],
            [65, 'Loss Reasons', $CRM_URL.'reasons', 'mdi:close-circle-outline', 4, 'crm_reasons-view', 15, '["crm"]'],
            [66, 'Lead Actions', $CRM_URL.'leadactions', 'mdi:play-circle', 4, 'crm_leadactions-view', 16, '["crm"]'],
            [67, 'Lead Pipeline', $CRM_URL.'workflow', 'mdi:play-circle', 4, 'crm_workflow-view', 17, '["crm"]'],
            [68, 'Reminder Settings', $CRM_URL.'leads-reminder-settings', 'mdi:bell-outline', 4, 'crm_reminder-settings', 18, '["crm"]'],
            [69, 'Leads', $CRM_URL.'leads', 'mdi:account-search-outline', null, 'crm_leads-view', 30, '["crm"]'],
            [70, 'Messages', $CRM_URL.'messangers/index', 'mdi:chat-outline', null, 'crm_messanger-view', 31, '["crm"]'],
            [71, 'Instagram', $CRM_URL.'instagram/index', 'mdi:instagram', null, 'crm_instagram-view', 32, '["crm"]'],
            [72, 'Academy Schedule View', $ACADEMY_URL.'view-schedule', 'mdi:calendar-plus', 2, 'academy_viewSchedule', 6, '["academy"]'],
            [73, 'Retention Schedule View', $Retention_URL.'view-schedule', 'mdi:calendar-plus', 2, 'retention_viewSchedule', 7, '["retention"]'],
            [75, 'Staff Dashboard', $ACADEMY_URL.'teacher-dashboard', 'mdi:calendar-plus', null, 'academy_teacher_dashboard_index', 1, '["academy"]'],
            [76, 'Students', $ACADEMY_URL.'students', 'mdi:calendar-plus', null, 'academy_teacher_students_index', 6, '["academy"]'],
            [77, 'Calendar', $ACADEMY_URL.'calendar', 'mdi:calendar-plus', null, 'academy_teacher_calendar_index', 3, '["academy"]'],
            [78, 'Sessions', $ACADEMY_URL.'demo', 'mdi:calendar-plus', null, 'academy_tester_course_index_demo', 4, '["academy"]'],
            [79, 'Courses', $ACADEMY_URL.'courses', 'mdi:calendar-plus', null, 'academy_teacher_course_index', 5, '["academy"]'],
            [80, 'Leave Requests', $ACADEMY_URL.'leave_requests', 'mdi:calendar-plus', null, 'academy_teacher_leave_request_index', 6, '["academy"]'],
            [81, 'Performance Analytics', $ACADEMY_URL.'feedback', 'mdi:calendar-plus', null, 'academy_teacher_feedback_index', 7, '["academy"]'],
            [82, 'Demo Feedback', $ACADEMY_URL.'feedback_demo', 'mdi:calendar-plus', null, 'academy_tester_feedback_index_demo', 8, '["academy"]'],
            [84, 'Exams', $EXAM_URL.'exams', 'mdi:calendar-plus', 206, 'exam_exam_index', 16, '["academy"]'],
            [85, 'Quizzes', $EXAM_URL.'quizzes', 'mdi:calendar-plus', 206, 'exam_quiz_index', 17, '["academy"]'],
            [86, 'Question Bank', $EXAM_URL.'questions', 'mdi:calendar-plus', 206, 'exam_question_index', 16, '["academy"]'],
            // [87, 'Assignments', $EXAM_URL.'assignments', 'mdi:calendar-plus', 206, 'exam_assignment_index', 18, '["academy"]'],
            [88, 'Student Feedback', $ACADEMY_URL.'teacher_feedback', 'mdi:calendar-plus', 207, 'academy_teacher_student_feedback_index', 14, '["academy"]'],
            [89, 'Student Feedback', $ACADEMY_URL.'get-feedback', 'mdi:calendar-plus', 207, 'academy_getFeedback', 14, '["academy"]'],
            [90, 'Priority Requests', $HR_URL.'requests?department_id=&type_id=&priority=high', 'mdi:file-document-outline', 91, 'hr_request_letter_index', 0, '["hr"]'],
            [91, 'Employee Requests', null, 'mdi:file-document-outline', null, null, 34, '["academy","hr","finance","crm","retention","it","marketing"]'],
            [92, 'Student Requests', $ACADEMY_URL.'student-requests', 'mdi:file-document-outline', 91, '', 0, '["academy","retention"]'],
            [96, 'Today\'s Sessions', $ACADEMY_URL.'sessions?filter=today', 'mdi:play-circle', 28, 'academy_sessions_index', 0, '["academy"]'],
            [97, 'Upcoming Sessions', $ACADEMY_URL.'sessions?filter=upcoming', 'mdi:play-circle', 28, 'academy_sessions_index', 0, '["academy"]'],
            [98, 'Past Sessions', $ACADEMY_URL.'sessions?filter=previous', 'mdi:play-circle', 28, 'academy_sessions_index', 0, '["academy"]'],
            [99, 'Retention View Schedule Demo', $Retention_URL.'view-schedule-demo', 'mdi:calendar-plus', 5, 'retention_viewScheduleDemo', 7, '["retention"]'],
            [100, 'Teams', $Retention_URL.'team-leaders', 'mdi:account-group-outline', 192, 'retention_teams_show', 1, '["retention"]'],
            // [101, 'Admin Users', $Retention_URL.'admins', 'mdi:account-group-outline', NULL, 'retention_admins_show', 1, '["retention"]'],
            [102, 'Demo Calendar', $Retention_URL.'calendar-demo', 'mdi:calendar-month', 5, 'retention_calendar_index', 1, '["retention"]'],
            [105, 'Recruitment', $HR_URL.'recuirements', 'mdi:folder-multiple-outline', 193, 'hr_recuirements_index', 25, '["hr"]'],
            [107, 'Inventory Items', $HR_URL.'items', 'mdi:folder-multiple-outline', 4, 'hr_items_index', 25, '["hr"]'],
            [108, 'Onboarding', $HR_URL.'onboarding', 'mdi:folder-multiple-outline', 186, 'hr_task_onboarding', 26, '["hr"]'],
            [109, 'Penalty & Bonus Rules', $HR_URL.'rules', 'mdi:alpha-r-box-outline', 132, 'hr_rules_index', 0, '["hr"]'],
            [110, 'Payroll Run', $HR_URL.'payroll/run', 'mdi:alpha-p-box-outline', 132, 'hr_payroll_run_index', 0, '["hr"]'],
            [111, 'Payroll Staff', $HR_URL.'payroll/staff', 'mdi:alpha-p-circle', 132, 'hr_pay_roll_saff_index', 0, '["hr"]'],
            [112, 'Offboarding', $HR_URL.'off-boarding', 'mdi:folder-multiple-outline', 186, 'hr_off_boarding', 27, '["hr"]'],
            [113, 'Certifications Requests', $Retention_URL.'request-hard-copy', 'mdi:file-document-outline', 91, 'retention_request_hard_copy', 17, '["retention"]'],
            [114, 'Holidays', $HR_URL.'holidays', 'mdi:folder-multiple-outline', 91, 'hr_holidays_index', 26, '["hr"]'],
            [115, 'My Leave', $HR_URL.'leaves', 'mdi:folder-multiple-outline', 129, null, 26, '["hr"]'],
            [116, 'Demo Sessions', $ACADEMY_URL.'demo-courses', 'mdi:autorenew', 5, 'academy_demo_courses', 5, '["academy"]'],
            // [117, 'extra sessions', $Retention_URL.'products/all?type=extra+sessions', 'mdi:tag-outline', 6, 'retention_products_index', 2, '["retention"]'],
            // [118, 'all booked English club', $Retention_URL.'products/all?type=english+club', 'mdi:tag-outline', 6, 'retention_booked_english_club', 2, '["retention"]'],
            // [119, 'Gift Call', $Retention_URL.'products/all?type=gift+call', 'mdi:tag-outline', 6, 'retention_products_index', 2, '["retention"]'],
            [120, 'Currencies', $FINANCE_URL.'currency', 'mdi:folder-multiple-outline', 4, 'finance_currency_rate_index', 26, '["finance"]'],
            [121, 'Activity Catalog', $Retention_URL.'products', 'mdi:package-variant', 4, 'retention_products_index', 9, '["retention"]'],
            // [122, 'It Cost Center', null, 'mdi:cellphone-link', null, null, 0, '["it"]'],
            [123, 'Assets', $IT_URL.'asset', 'mdi:folder-network-outline', null, 'it_assets_index', 0, '["it"]'],
            [124, 'Asset Statistics', $IT_URL.'asset-dashboard ', 'mdi:application-cog-outline', 187, 'it_assets_index', 0, '["it"]'],
            [125, 'Purchase orders', $FINANCE_URL.'purchase', 'mdi:bookmark-outline', 230, 'it_purchase_index', 1, '["finance"]'],
            // [126, 'Expenses', $IT_URL.'expenses', 'mdi:currency-usd', 122, 'it_expenses_index', 6, '["it"]'],
            [127, 'General Settings', $HR_URL.'hrsettings', 'mdi:alert-octagram-outline', 4, 'hr_configuration_index', 0, '["hr"]'],
            [128, 'Approvals', $HR_URL.'regularizations_permissions', 'mdi:check-bookmark', 129, 'hr_regularizations_permissions_index', 0, '["hr"]'],
            [129, 'Attendance', null, 'mdi:package-variant', null, null, 15, '["hr"]'],
            [130, 'Student Prepaids', $FINANCE_URL.'student-prepaids', 'mdi:receipt-text-outline', 4, 'finance_student_prepaid_index', 14, '["finance"]'],
            [131, 'Shared Center', null, 'mdi:share-variant', null, null, 35, '["academy","hr","finance","crm","retention","it","marketing"]'],
            [132, 'Payroll Management', null, 'mdi:currency-usd', null, null, 4, '["hr","finance"]'],
            [134, 'Top Purchased Courses', $FINANCE_URL.'courses/high-purchased', 'mdi:receipt-text-outline', 4, 'finance_high_purshased_index', 4, '["finance"]'],
            [135, 'Plans', null, 'mdi:home-city-outline', null, 'marketing_plans_index', 0, '["marketing"]'],
            [136, 'Marketing Calendar', $MARKETING_URL.'calendar', 'mdi:calendar-month', 135, 'marketing_plans_index', 0, '["marketing"]'],
            [137, 'Marketing Plans', $MARKETING_URL.'get-months', 'mdi:filter', 135, 'marketing_plans_index', 0, '["marketing"]'],
            [138, 'Plans', $MARKETING_URL.'plans', 'mdi:octagram-edit-outline', 135, 'marketing_plans_index', 0, '["marketing"]'],
            [139, 'Create Plan', $MARKETING_URL.'plans/create', 'mdi:currency-usd', 135, 'marketing_plans_create', 0, '["marketing"]'],
            [140, 'Ticket Statistics', $IT_URL.'statistics', 'mdi:file-document-outline', 187, 'it_dashboard_index', 0, '["it"]'],
            [141, 'Database', null, 'mdi:database-check-outline', null, 'marketing_scripts_index', 3, '["marketing"]'],
            [142, 'Script Library', $MARKETING_URL.'scripts', 'mdi:filter', 141, 'marketing_scripts_index', 0, '["marketing"]'],
            [143, 'Create Script', $MARKETING_URL.'scripts/create', 'mdi:loupe', 141, 'marketing_scripts_create', 0, '["marketing"]'],
            // [144, 'Expense Types', $FINANCE_URL.'expenses_head', 'mdi:cash-minus', 4, 'finance_expenses_head_index', 16, '["finance"]'],
            [145, 'Complaints', null, 'mdi:check-circle-outline', null, 'marketing_complains_index', 4, '["marketing"]'],
            [146, 'Complaints', $MARKETING_URL.'complains', 'mdi:filter', 145, 'marketing_complains_index', 0, '["marketing"]'],
            [147, 'Create Complaint', $MARKETING_URL.'complains/create', 'mdi:card-plus-outline', 145, 'marketing_complains_create', 0, '["marketing"]'],
            [148, 'Hr Urgent', $HR_URL.'requests?department_id=&type_id=&priority=high', 'mdi:bell-alert', null, 'hr_request_letter_index', 10, '["hr"]'],
            [149, 'Retention Feedback', $Retention_URL.'retentions_feedbacks', 'mdi:robot-love-outline', 207, 'retention_all_retention_feedback', 4, '["retention"]'],
            [150, 'Quick Links', $MARKETING_URL.'quick-links', null, null, 'marketing_quickLinks_index', 0, '["marketing"]'],
            [151, 'Requisitions', $HR_URL.'requests', 'mdi:chart-donut-variant', null, 'hr_request_letter_index', 8, '["hr"]'],
            [152, 'Login Audit', $HR_URL.'users/audit', 'mdi:security', 129, 'hr_auth_events_audit', 0, '["hr"]'],
            [154, 'Activities Configurations', $IT_URL.'products/', null, 4, 'it_products_index', 0, '["it"]'],
            [155, 'Vendors', $IT_URL.'vendors/', null, 4, 'it_vendors_index', 0, '["it"]'],
            [156, 'Shift Assignments', $HR_URL.'shift-emps', 'mdi:school-outline', 4, 'hr_shift_emps_index', 8, '["hr"]'],
            [157, 'Sales orders', $FINANCE_URL.'get-purchases', 'mdi:school-outline', 229, 'it_purchase_index', 1, '["finance"]'],
            // [158, 'Expenses', null, null, null, 'it_expenses_index', 0, '["it","finance"]'],
            // [159, 'IT Expenses', $IT_URL.'expenses', 'mdi:cash-minus', 158, 'it_expenses_index', 16, '["it","finance"]'],
            [160, 'Teacher Absence', $Retention_URL.'teacher-absence-reports', 'mdi:eye-outline', 4, 'retention_teacher_absence_report_index', 2, '["retention"]'],
            [161, 'Announcements', $HR_URL.'announcements', 'mdi:account-group-outline', null, 'hr_announcements_index', 10, '["hr"]'],
            [162, 'Knowledge Base', $IT_URL.'solutions', null, 169, null, 0, '["it"]'],
            [163, 'Tickets', null, null, null, 'it_tickets_index', 0, '["it"]'],
            [164, 'Ticket Settings', $IT_URL.'ticket-categories', null, 163, 'it_ticket_category_index', 3, '["it"]'],
            [166, 'Tickets Creation', $IT_URL.'tickets', null, 163, 'it_tickets_index', 1, '["it"]'],
            [167, 'Supervisor Slots', $HR_URL.'supervisor-session-slots', 'mdi:account-check-outline', null, 'hr_supervisor_session_slots_index', 4, '["hr"]'],
            [168, 'Leave Balance Rules', $HR_URL.'leave-balance-configurations', 'mdi:account-group-outline', 4, 'hr_leave_balance_configurations_index', 10, '["hr"]'],
            [169, 'IT Solutions', null, 'mdi:cog-outline', null, null, 30, '["it"]'],
            [170, 'Manage Knowledge Base', $IT_URL.'it-solutions', null, 169, 'it_solutions_index', 0, '["it"]'],
            [171, 'Roles Departments', $SETTING_URL.'departments', 'mdi:office-building-outline', 4, 'general_departments_index', 2, '["settings"]'],
            [172, 'Sidebar Tabs', $SETTING_URL.'tabs', 'mdi:office-building-outline', null, 'general_tabs_index', 2, '["settings"]'],
            [173, 'Notification Settings', $IT_URL.'firebase-configs', 'mdi:office-building-outline', 4, 'general_tabs_index', 2, '["it"]'],
            [174, 'Cost Centers', $FINANCE_URL.'cost_centers', 'mdi:office-building-outline', 4, 'finance_cost_centers_index', 2, '["finance"]'],
            [175, 'Chart of Accounts', $FINANCE_URL.'chart_of_accounts', 'mdi:office-building-outline', 4, 'finance_chart_of_accounts_index', 2, '["finance"]'],
            [176, 'Treasury', $FINANCE_URL.'treasuries', 'mdi:office-building-outline', 4, 'finance_treasuries_index', 2, '["finance"]'],
            [177, 'Admin Performance', $Retention_URL.'admin-performance', 'mdi:office-building-outline', 4, 'retention_admin_performance_index', 2, '["retention"]'],
            [178, 'HR Analytics', $HR_URL.'reports', 'mdi:office-building-outline', 187, 'hr_reports_index', 2, '["hr"]'],
            [179, 'Marketing Analytics', $MARKETING_URL.'reports', 'mdi:office-building-outline', null, 'marketing_reports_index', 2, '["marketing"]'],
            [180, 'CRM Analytics', $CRM_URL.'reports', 'mdi:office-building-outline', null, 'crm_reports_index', 2, '["crm"]'],
            [181, 'Retention Analytics', $Retention_URL.'reports', 'mdi:office-building-outline', 187, 'retention_reports_index', 2, '["retention"]'],
            [182, 'IT Analytics', $IT_URL.'reports', 'mdi:office-building-outline', 187, 'it_reports_index', 2, '["it"]'],
            [183, 'Complaint Analytics', $Retention_URL.'schedule-complaint-reports', 'mdi:office-building-outline', 187, 'retention_schedule_complaint_reports_index', 2, '["retention"]'],
            [184, 'Journal Entries', $FINANCE_URL.'journal_entries', 'mdi:office-building-outline', 4, 'finance_journal_entries_index', 2, '["finance"]'],
            [185, 'Academic Analytics', $ACADEMY_URL.'reports', 'mdi:office-building-outline', null, 'academy_reports_index', 2, '["academy"]'],
            [186, 'Employee Lifecycle', null, 'mdi:book-open-page-variant', null, null, 3, '["hr"]'],
            [187, 'Statistics', null, 'mdi:book-open-page-variant', null, null, 3, '["hr","it","retention"]'],
//            [189, 'Experience Letters', $HR_URL.'experience_letter', 'mdi:office-building-outline', 91, 'hr_experience_letter_index', 2, '["hr"]'],
//            [190, 'Ticket Items', $IT_URL.'ticket-items', 'mdi:office-building-outline', 163, 'it_ticket_item_index', 2, '["it"]'],
            [189, 'Experience Letters', $HR_URL.'experience_letter', 'mdi:office-building-outline', 4, 'hr_experience_letter_index', 2, '["hr"]'],
//            [190, 'Ticket Items', $IT_URL.'ticket-items', 'mdi:office-building-outline', 163, 'it_ticket_item_index', 2, '["it"]'],
            [191, 'My Assigned Applicant', $HR_URL.'applicants/my-assigned', 'mdi:office-building-outline', 193, 'hr_request_assigned_applicants', 2, '["hr"]'],
            [192, 'User Management', null, 'mdi:cog-outline', null, null, 30, '["retention","hr"]'],
            [193, 'Hiring', null, 'mdi:cog-outline', null, null, 30, '["hr"]'],
            [194, 'Hiring requests', $HR_URL.'requests?type=Recruitment', 'mdi:office-building-outline', 193, 'hr_request_letter_index', 2, '["hr"]'],
            [195, 'All Applicant', $HR_URL.'applicants', 'mdi:office-building-outline', 193, 'hr_request_all_applicants', 2, '["hr"]'],
            [196, 'Freeze Requests', $Retention_URL.'admin-student-requests', 'mdi:office-building-outline', null, 'retention_student_requests_index', 2, '["retention"]'],
            // [197, 'Student Requests Configurations', $ACADEMY_URL.'students-requests/configurations', 'mdi:office-building-outline', 91, 'retention_student_requests_index', 2, '["retention" , "academy"]'],
            [198, 'Filterd Tables', $HR_URL.'filtered-tables', 'mdi:office-building-outline', 4, null, 2, '["hr"]'],
            [199, 'Ongoing Assessments', $EXAM_URL.'ongoing-assessments', 'mdi:clipboard-check-outline', 206, 'exam_ongoing_assessments_index', 1, '["academy"]'],
            [200, 'Conversation Final Project', $EXAM_URL.'manual-final-grades/conversation_project', 'mdi:account-voice', 206, 'exam_manual_final_grades_conversation_project', 2, '["academy"]'],
            [201, 'Jolly Dictation Exam', $EXAM_URL.'manual-final-grades/jolly_dictation', 'mdi:book-edit-outline', 206, 'exam_manual_final_grades_jolly_dictation', 3, '["academy"]'],
            [202, 'Feedback Reviews', $HR_URL.'feedback-reviews', 'mdi:book-edit-outline', null, 'hr_feedback-reviews', 3, '["hr" , "retention" , "academy"]'],
            [203, 'Escalation Requests', $Retention_URL.'escalation-requests', 'mdi:book-edit-outline', 91,  'retention_escalation_request_index',  3, '["hr" , "retention" , "academy"]'],
            [204, 'Teams Performance', $Retention_URL.'teams-performance', 'mdi:book-edit-outline', null,  'retention_teams_performance_index',  4, '["retention"]'],
            [205, 'ATC Dashboard', $CRM_URL.'atc', 'mdi:book-edit-outline', null,  'crm_atc_index',  4, '["crm"]'],
            [206, 'Assessment hup', null, 'mdi:book-edit-outline', null,  null,  4, '["academy"]'],
            [207, 'Feedbacks', null, 'mdi:book-edit-outline', null,  null,  4, '["academy"]'],
            [208, 'Staff Target Configurations', $Retention_URL.'staff-target-configurations', 'mdi:book-edit-outline', 4,  'retention_staff_target_configurations_index',  4, '["retention"]'],
            [209, ' Leads Distribution Configurations', $CRM_URL.'lead-distribution/config', 'mdi:book-edit-outline', null,  'crm_lead_distribution_configurations_index',  4, '["CRM"]'],
            [210, 'Influencers', $FINANCE_URL.'influencers', 'mdi:book-edit-outline', null,  'finance_influencers_index',  4, '["finance"]'],
            [211, 'Lead-distribution queue', $CRM_URL.'lead-distribution/queue', 'mdi:book-edit-outline', null,  'crm_lead_distribution_queue_index',  4, '["CRM"]'],
            [212, 'Exam Submission review', $EXAM_URL.'exam-submissions', 'mdi:book-edit-outline', 206, 'exam_submissions_index', 5, '["academy"]'],
            [213, 'Sliders', $Retention_URL.'sliders', 'mdi:book-edit-outline', null,  'retention_sliders_index',  4, '["retention"]'],
            [214, 'Slider Description', $Retention_URL.'slider-descriptions', 'mdi:book-edit-outline', null,  'retention_slider_descriptions_index',  4, '["retention"]'],
            [215, 'Contacts', $HR_URL.'contacts', 'mdi:account-group-outline', null, 'hr_contacts_index', 1, '["hr"]'],
            [216, 'Certificate Payment Configurations', $Retention_URL.'certificate-payment-configurations', 'mdi:account-group-outline', null, 'retention_certificate_payment_configurations_index', 1, '["retention"]'],
            // [217, 'Trial Balance', $FINANCE_URL.'trial-balance', 'mdi:account-group-outline', null, 'finance_trial_balance_index', 1, '["finance"]'],
            [218, 'Cost Center Results', $FINANCE_URL.'cost-center-results', 'mdi:account-group-outline', null, 'finance_cost_center_result_index', 1, '["finance"]'],
            [219, 'Income Statement', $FINANCE_URL.'income-statement', 'mdi:account-group-outline', null, 'finance_income_statement_index', 1, '["finance"]'],
            [220, 'Refund Requests', $FINANCE_URL.'refund-requests', 'mdi:cash-refund', null, 'finance_refund_index', 14, '["finance"]'],
            [221, 'Payments', $FINANCE_URL.'payments', 'mdi:cash-refund', null, 'finance_payments_index', 15, '["finance"]'],
            [222, 'Ledger', $FINANCE_URL.'ledgers', 'mdi:cash-refund', null, 'finance_ledger_index', 5, '["finance"]'],
            [223, 'Financial Reports', $FINANCE_URL.'financial-reports', 'mdi:cash-refund', null, 'finance_financial_report_index', 5, '["finance"]'],
            [224, 'Purchase Invoices', $FINANCE_URL.'purchase-invoices', 'mdi:cash-refund', 230, 'finance_purchase_invoices', 2, '["finance"]'],
            [225, 'All Invoices', $FINANCE_URL.'invoices', 'mdi:cash-refund', null, 'finance_purchase_invoices', 5, '["finance"]'],
            [226, 'Financial Indicators', $FINANCE_URL.'financial-indicators', 'mdi:cash-refund', null, 'finance_financial_report_index', 5, '["finance"]'],
            [227, 'Student Balances', $FINANCE_URL.'student-balances', 'mdi:cash-refund', null, 'finance_student_balances_index', 5, '["finance"]'],
            [228, 'Packages', $Retention_URL.'packages', 'mdi:package-variant-closed', null, 'retention_packages_index', 5, '["retention"]'],
            [229, 'Sales', null, 'mdi:cash-register', null, null, 14, '["finance"]'],
            [230, 'Purchases', null, 'mdi:cart-outline', null, null, 15, '["finance"]'],
            [231, 'Retention Leads', $CRM_URL.'leads?retention=1', 'mdi:account-search-outline', null, 'crm_leads-view', 30, '["crm"]'],



        ];

        $now = now();

        foreach ($tabs as $tabData) {
            DB::table('tabs')->updateOrInsert(
                ['id' => $tabData[0]],
                [
                    'label' => $tabData[1],
                    'url' => $tabData[2],
                    'icon' => $tabData[3],
                    'parent_id' => null,
                    'permission_required' => $tabData[5],
                    'order' => $tabData[6],
                    'systems' => json_encode(json_decode($tabData[7], true), JSON_UNESCAPED_UNICODE),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        foreach ($tabs as $tabData) {
            DB::table('tabs')
                ->where('id', $tabData[0])
                ->update([
                    'parent_id' => $this->parentId($tabData[4]),
                    'updated_at' => $now,
                ]);
        }

    }

    private function parentId(?int $parentId): ?int
    {
        if ($parentId === null) {
            return null;
        }

        $resolvedParentId = DB::table('tabs')->where('id', $parentId)->value('id');

        if ($resolvedParentId === null) {
            throw new RuntimeException("Parent tab {$parentId} was not found.");
        }

        return $resolvedParentId;
    }
}
