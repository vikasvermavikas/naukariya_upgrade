<?php
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;


// ******************************* Jobseeker Breadcrumbs *******************************

Breadcrumbs::for('jobseeker_dasboard', function ($trail) {
$trail->push('Dashboard', route('AllDataForJobSeeker'));
});

Breadcrumbs::for('helpdesk', function ($trail) {
$trail->parent('jobseeker_dasboard');
$trail->push('Support', route('jobseeker_support_list'));
});

Breadcrumbs::for('applied_jobs', function ($trail) {
$trail->parent('jobseeker_dasboard');
$trail->push('Applied Jobs');
});

Breadcrumbs::for('company_followings', function ($trail) {
$trail->parent('jobseeker_dasboard');
$trail->push('Company Followings');
});

Breadcrumbs::for('saved_jobs', function ($trail) {
$trail->parent('jobseeker_dasboard');
$trail->push('Saved Jobs');
});

Breadcrumbs::for('jobseeker_myprofile', function ($trail) {
$trail->parent('jobseeker_dasboard');
$trail->push('My Profile');
});

Breadcrumbs::for('jobseeker_notifications', function ($trail) {
$trail->parent('jobseeker_dasboard');
$trail->push('Job Notifications');
});


// ******************************* Employer Breadcrumbs *******************************

Breadcrumbs::for('employer_dasboard', function ($trail) {
$trail->push('Dashboard', route('dashboardemployer'));
});

Breadcrumbs::for('manage_jobs', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Manage Jobs');
});

Breadcrumbs::for('job_description', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Manage Jobs', route('managejobs'));
$trail->push('Job Detail');
});

Breadcrumbs::for('ats', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('ATS', route('ats_listing'));
});

Breadcrumbs::for('get_resumes', function ($trail, $title) {
$trail->parent('ats');
$trail->push($title);
});

Breadcrumbs::for('job_ats', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Manage Jobs', route('managejobs'));
$trail->push('ATS');
});

Breadcrumbs::for('job_ats_trackers', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Manage Jobs', route('managejobs'));
$trail->push('Relevant Trackers');
});

Breadcrumbs::for('posted_jobs', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Posted Jobs');
});

Breadcrumbs::for('resume_view', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('View Resumes');
});

Breadcrumbs::for('scheduled_interviews', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Scheduled Interviews');
});

Breadcrumbs::for('client_list', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Client List');
});

Breadcrumbs::for('post_new_job', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Post New Job');
});

Breadcrumbs::for('questionnaires_list', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Questionaires List');
});

Breadcrumbs::for('add_question', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Questionaires List', route('questionnaires'));
$trail->push('Add Question');
});

Breadcrumbs::for('view_questions', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Questionaires List', route('questionnaires'));
$trail->push('Add Question', route('add_question'));
$trail->push('View Questions');
});

Breadcrumbs::for('subuser_list', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Sub Users List');
});

Breadcrumbs::for('manage_venues', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Manage Venues');
});

Breadcrumbs::for('view_tagged_candidates', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('View Tagged Candidates');
});

Breadcrumbs::for('search_resume', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Search Resumes');
});

Breadcrumbs::for('consolidate_data', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Consolidate Data');
});

Breadcrumbs::for('trackers_list', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Trackers List');
});

Breadcrumbs::for('follower_list', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Followers Details');
});

Breadcrumbs::for('employer_edit_profile', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Edit Profile');
});

Breadcrumbs::for('employer_my_profile', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('My Profile');
});

Breadcrumbs::for('organisation_details', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Organisation Details');
});

Breadcrumbs::for('employer_change_password', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Change Password');
});

Breadcrumbs::for('employer_notifications', function ($trail) {
$trail->parent('employer_dasboard');
$trail->push('Job Notifications');
});

// ******************************* Sub users List *******************************

Breadcrumbs::for('subuser_dasboard', function ($trail) {
$trail->push('Dashboard', route('subuser-dashboard'));
});

Breadcrumbs::for('subuser_trackers', function ($trail) {
$trail->parent('subuser_dasboard');
$trail->push('Trackers List');
});

Breadcrumbs::for('subuser_myprofile', function ($trail) {
$trail->parent('subuser_dasboard');
$trail->push('My Profile');
});

Breadcrumbs::for('subuser_add_tracker', function ($trail) {
$trail->parent('subuser_dasboard');
$trail->push('Trackers List', route('subuser-tracker-list'));
$trail->push('Add Tracker');
});

Breadcrumbs::for('subuser_edit_tracker', function ($trail) {
$trail->parent('subuser_dasboard');
$trail->push('Trackers List', route('subuser-tracker-list'));
$trail->push('Edit Tracker');
});

