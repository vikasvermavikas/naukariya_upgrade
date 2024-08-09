<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontJobseekerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\FrontuserloginController;
use App\Http\Controllers\UserprofileController;
use App\Http\Controllers\JobmanagerController;
use App\Http\Controllers\FrontAllUserController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\JobseekerController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\ApplyJobController;
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\StageRegistration;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ClientNameController;
use App\Http\Controllers\ConsolidateDataController;
use App\Http\Controllers\SubuserController;
use App\Http\Controllers\EmpTrackerDetailsController;
use App\Http\Controllers\JobsectorController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\FunctionalroleController;
use App\Http\Controllers\EmpcompaniesdetailsController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\ViewProfileTrackController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\viewresumeController;
use App\Http\Controllers\SaveCommentController;
use App\Http\Controllers\QuestionnarieListController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\VenuesController;
use App\Http\Controllers\WebsiteInfoController;
use App\Http\Controllers\ProfileCompleteController;
use App\Http\Controllers\SubUserDashboardController;
use App\Http\Controllers\TrackerController;
use App\Http\Controllers\ReferenceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['guest:jobseeker', 'guest:employer', 'guest:subuser'])->group(function () {

    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::get('/blog', function () {
        return view('blog');
    })->name('blog');

    Route::get('/single-blog', function () {
        return view('single-blog');
    })->name('single-blog');

    Route::get('/elements', function () {
        return view('elements');
    })->name('elements');

    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');

    Route::get('/register', function () {
        return view('register');
    })->name('register');

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::get('/', [JobmanagerController::class, 'getJobsByCategory'])->name('home');


    Route::get('employer-signup', [FrontAllUserController::class, 'employerRegister'])->name('employer-register');
    Route::post('employerregister', [FrontAllUserController::class, 'store'])->name('employerregister');
    Route::post('/add-contactus-detail', [ContactUsController::class, 'store'])->name('contactus');

    //login employers
    Route::get('employerlogin', [FrontuserloginController::class, 'loadLoginPage'])->name('loadLoginPage');
    Route::get('get-categories-jobs', [JobmanagerController::class, 'get_categories_jobs'])->name('getCategoriesJobs');

    
    Route::get('/subuser-login', [SubuserController::class, 'login'])->name('subuser-signin');
    Route::post('/subuser/subuser-login', [SubuserController::class, 'loginSubuser'])->name('subuser-login');
});
Route::get('/get-keywords', [JobseekerController::class, 'getKeywords'])->name('getskillsoptions');


Route::get('/get/sociallinks', [WebsiteInfoController::class, 'getPortalSocialLinks'])->name('sociallinks');

Route::post('/add-newsletter', [NewsletterController::class, 'store'])->name('addNewsletter');
Route::get('/unsubscribe-newsletter', [NewsletterController::class, 'unsubscribe'])->name('unsubscribe');
Route::post('/unfollow-newsletter', [NewsletterController::class, 'destroy'])->name('unfollowNewsletter');
// jobseeker login
Route::post('jobseekerregister', [FrontJobseekerController::class, 'store'])->name('jobseekerregister');
Route::get('/job_details/{id}', [JobmanagerController::class, 'showSingleJob'])->name('job_details');

Route::get('job-listing', [JobmanagerController::class, 'joblisting'])->name('loadJoblistPage');
Route::get('job-listing-default', [JobmanagerController::class, 'get_default_joblisting'])->name('get_default_joblisting');
Route::get('job_listing-data', [JobmanagerController::class, 'browsejob'])->name('job_listing');
Route::post('jobseekerlogin', [FrontuserloginController::class, 'login'])->name('jobseekerlogin');
Route::post('/jobseeker-logout', [UserprofileController::class, 'logout'])->name('jobseekerlogout');
// Social Login
Route::get('/auth/redirect/{provider}/{userType}', [JobseekerController::class, 'redirect'])->name('sociallogin');
Route::get('/callback/{provider}', [JobseekerController::class, 'callback'])->name('socialcallback');
Route::get('/get-industry', [IndustryController::class, 'index'])->name('getIndustries');
Route::get('/get-skill', [JobmanagerController::class, 'getSkill'])->name('getSkill');

Route::get('/get-locations/{search?}', [JobseekerController::class, 'getLocations'])->name('get-locations');

// Jobseekers routes.
Route::post('/apply-job/{id}', [ApplyJobController::class, 'store'])->name('applyjob');
Route::post('/saved-job/{id}', [SavedJobController::class, 'store'])->name('savejob');
Route::post('/follow/{companyid}/{jobid}', [SavedJobController::class, 'follow'])->name('followjob');


Route::middleware('jobseeker')->group(function () {
    Route::get('dashboard/jobseeker', [DashboardController::class, 'countAllDataForJobSeeker'])->name('AllDataForJobSeeker');
    Route::get('/get-stage-registration', [StageRegistration::class, 'getStage'])->name('getStage');
    Route::get('/jobseeker-apply-job', [ApplyJobController::class, 'applyJobList'])->name('applyJobList');

    Route::prefix('jobseeker')->group(function () {
        Route::get('/profile/percentage', [ProfileCompleteController::class, 'ProfilePercentage']);
        Route::get('/supportlist', [SupportController::class, 'index'])->name('jobseeker_support_list');
        Route::post('/add-support', [SupportController::class, 'store_jobseeker'])->name('store_jobseeker_support');
        Route::get('/my-profile', [UserprofileController::class, 'jobseeker_profile'])->name('jobseekerProfile');
        Route::get('/get-user-skill', [UserprofileController::class, 'getUserSkill']);


        Route::controller(SavedJobController::class)->group(function () {
            Route::get('/follow-list', 'follow_list')->name('follow_list');
            Route::get('/get-saved-job', 'index')->name('get-saved-job');
            Route::get('/unfollow-companies/{id}/{id2}', 'unfollow_companies')->name('unfollow_companies');
        });

        Route::controller(StageRegistration::class)->group(function () {
            Route::get('/profile-stage', 'getPersnol')->name('profile-stages');
            Route::post('/persnol-save', 'addPersnol');
            Route::get('/skip-stage/{stage}', 'skipStage');
            Route::post('/add-education-detail', 'addEducationDetail');
            Route::post('/add-professional-detail-stage', 'addProfessionalDetail');
            Route::post('/add-skill-detail', 'addSkillDetail');
            Route::post('/add-certification-detail-stage', 'addCertificationDetail');
            Route::get('/get-certification-detail', 'getCertificationDetail');
            Route::get('/get-education-detail', 'getEducationDetail');
        });
    });
});

// Routes for authenticating only.

// Employer Routes.

Route::group(['middleware' => 'employer'], function () {
    // Route::get('employer/dashboard', [DashboardController::class, 'dashboardloadPage'])->route('dashboardLoadPage');
    Route::get('get-subuser-activity', [DashboardController::class, 'CountSubuserActivity']);
    Route::get('dashboard/employer', [DashboardController::class, 'countAllDataForJobEmployer'])->name('dashboardemployer');

    Route::prefix('employer')->group(function () {
        Route::get('/get-cities/data/{id}', [CitiesController::class, 'getCityByState'])->name('get_cities_by_state');
        Route::get('/followdetails', [SavedJobController::class, 'follower_list'])->name('employer_followers');

        Route::get('/getjobsector', [JobsectorController::class, 'index'])->name('get_job_sector');



        // Venue Controller.
        Route::controller(VenuesController::class)->prefix('venue')->group(function () {
            Route::get('/', 'index')->name('venue_list');
            Route::post('/add-venue', 'store')->name('add_venue');
            Route::get('/get-venuedata/{id}', 'getsinglevenue');
            Route::post('/update-venue/{id}', 'update');
            Route::get('/deactive-venues/{id}', 'deactive');
            Route::get('/venues/{id}', 'destroy');
            Route::get('/active-venues/{id}', 'VenuesController@active');
        });

        // Question controller.
        Route::controller(QuestionnarieListController::class)->prefix('questionnaires')->group(function () {
            Route::get('/list/{questionnarie_id?}', 'getquestionnarie_question_emp')->name('questionnaires');
            Route::post('/questionnarie-name_emp', 'questionnarie_name_emp');
            Route::get('/question-emp/{id}', 'destroy_emp');
            Route::get('/add_question', 'add_question')->name('add_question');
            Route::post('/add-questionnarie_emp/{name}/{question_id}', 'add_question_to_questionnarie_emp');
            Route::post('/add-new-questionnarie_emp/{name}', 'add_new_questionnarie_name_emp');
        });

        Route::controller(QuestionController::class)->prefix('question')->group(function () {
            Route::get('/question-emp', 'index_emp')->name('question_index_emp');

            Route::post('/add-question-mcq-emp', 'store_mcq_emp')->name('store_mcq_emp');
            Route::post('/add-question-yesno-emp', 'store_yesno_emp')->name('store_yesno_emp');
            Route::post('/add-question-descriptive-emp', 'store_descriptive_emp')->name('store_descriptive_emp');
        });


        // Resume filter controller.
        Route::controller(viewresumeController::class)->prefix('tags')->group(function () {
            Route::post('/add-new-tag', 'add_new_tag')->name('add_new_tag');
            Route::get('/get-tag', 'gettag')->name('get_all_tags');
            Route::post('/add-resume-tag', 'add_resume_tag');
            Route::get('/export-resumes/{ids}', 'exportResumes');
            Route::post('/send/bulk/mail', 'ResumeViewSendMail');
            Route::get('/jobseeker/skill/info/{jsid}', 'getSkillInfo')->name('get_skill_info');
            Route::get('/gettagresume', 'tagresume')->name('get_tagged_resumes');
        });
        Route::controller(SaveCommentController::class)->prefix('comment')->group(function () {
            Route::post('/save/comment/user', 'store');
            Route::post('/resume-comments', 'get_resume_comments');
        });

        // Get qualifications by group.
        Route::get('/qualification/name/group', [QualificationController::class, 'getQualificationByGroup'])->name('get_degrees_by_group');

        // Functional roles.
        Route::get('/get-functional-role', [FunctionalroleController::class, 'index'])->name('get_functional_role');

        // Get companies list.
        Route::get('/master/companies/list', [EmpcompaniesdetailsController::class, 'allCompaniesList'])->name('get_master_companies');

        // For change password.
        Route::get('/changepassword', [FrontAllUserController::class, 'employer_change_password'])->name('employer_change_password');
        Route::post('/update-password-employer', [FrontAllUserController::class, 'update_password'])->name('employer_update_password');

        // For update profile information.
        Route::get('edit-profile', [DashboardController::class, 'employer_profile'])->name('employer_edit_profile');
        Route::get('search-resume', [DashboardController::class, 'search_resume'])->name('employer_search_resume');
        Route::get('view-employer-profile', [DashboardController::class, 'employer_profile_view'])->name('employer_view_profile');
        Route::get('view-employer-organisation', [DashboardController::class, 'employer_organisation'])->name('employer_organisation');

        // For resume filer.
        Route::get('/resume/filter', [ViewProfileTrackController::class, 'getResumeFilterDemo'])->name('resume_filter');

        Route::controller(SearchController::class)->group(function () {
            Route::post('/add/save/search', 'AddSearchUrl');
        });

        Route::controller(UserprofileController::class)->group(function () {
            Route::post('/add-personal-detail-employer', 'update_employer_personaldetail')->name('update_employer_personaldetail');
            Route::post('/add-company-detail-employer', 'update_employer_companydetail')->name('update_employer_companydetail');
        });

        Route::controller(JobmanagerController::class)->group(function () {
            Route::get('/managejobs', 'sessionuser')->name('managejobs');
            Route::get('/jobDescription/{id}', 'job_description')->name('viewjobs');
            Route::get('/ats/{id}', 'jobapplication')->name('job_ats');
            Route::get('/posted-jobs', 'posted_jobs')->name('postedjobs');
            Route::get('/deactive-jobme/{id}', 'deactiveme')->name('deactive_posted-job');
            Route::get('/active-jobme/{id}', 'activeme')->name('active_posted-job');
            Route::get('/editpostjoby/{id}', 'edit')->name('edit_posted_job');
            Route::post('/update-jobs-front/{id}', 'update_front')->name('update_posted_job');
            Route::get('/post-new-job', 'add_job')->name('new_job_form');
            Route::post('/add-job-front', 'store_front')->name('store_new_job');
            Route::get('/scheduled-interview', 'getScheduledInterviewLists')->name('interview_list');
        });

        Route::controller(SupportController::class)->prefix('support')->group(function () {
            Route::post('/add-support', 'store_employer')->name('employer_add_support');
            Route::get('/', 'index')->name('employer_support_list');
        });

        // Route for tracker list block.
        Route::controller(EmpTrackerDetailsController::class)->prefix('tracker')->group(function () {
            Route::get('tracker-list', 'index')->name('tracker-list');
            Route::get('/unique-source/tracker', 'getUniqueSourceEmployer')->name('get_tracker_source');
            Route::get('/export/tracker/{trackerid?}', 'exportTrackerDataEmployer')->name('exportTracker');
        });


        // Route for sub users block.
        Route::prefix('subuser')->group(function () {
            Route::get('/', [SubuserController::class, 'index'])->name('get_subusers');
            Route::post('/add-subuser', [SubuserController::class, 'store'])->name('add_subuser');
            Route::post('/update-subuser', [SubuserController::class, 'update'])->name('update_subuser');
            Route::get('/active-subuser/{id}', [SubuserController::class, 'active'])->name('activate_subuser');
            Route::get('/deactive-subuser/{id}', [SubuserController::class, 'deactive'])->name('deactivate_subuser');
            Route::get('/get-single-subuserdata/{id}', [SubuserController::class, 'getsinglesubuser'])->name('get_single_subuserdata');
        });

        // Route for client block.
        Route::get('/client', [ClientNameController::class, 'index'])->name('get_clients');
        Route::post('/add-client', [ClientNameController::class, 'store'])->name('add_client');
        Route::get('/get-clientdata/{id}', [ClientNameController::class, 'getsingleclient'])->name('get_single_client');
        Route::post('/update-client', [ClientNameController::class, 'update'])->name('update_client');
        Route::get('/active-client/{id}', [ClientNameController::class, 'active'])->name('activate_client');
        Route::get('/deactive-client/{id}', [ClientNameController::class, 'deactive'])->name('deactivate_client');

        // Route for cosolidate data.
        Route::prefix('consolidate')->group(function () {
            Route::get('/bulk-data1', [ConsolidateDataController::class, 'index'])->name('get_consolidate_data');
            Route::get('/getUniqueSource1', [ConsolidateDataController::class, 'getUniqueSource'])->name('get_unique_source');
            Route::get('/export-data', [ConsolidateDataController::class, 'exportBulkData'])->name('export_consolidate_data');
        });

        // Routes for application block.
        Route::prefix('application')->group(function () {
            Route::get('/rejected/{id}', [JobmanagerController::class, 'reject'])->name('application_reject');
            Route::get('/shortlisted/{id}', [JobmanagerController::class, 'shortlist'])->name('application_shortlist');
            Route::get('/interview-scheduled', [JobmanagerController::class, 'interview_scheduled'])->name('application_interview_scheduled');
            Route::get('/offer/{id}', [JobmanagerController::class, 'offer'])->name('application_offer');
            Route::get('/hire/{id}', [JobmanagerController::class, 'hire'])->name('application_hire');
            Route::get('/save/{id}', [JobmanagerController::class, 'save'])->name('application_save');
        });
    });
});

// Sub user routes.

Route::middleware('subuser')->group(function () {

    Route::prefix('subuser')->group(function () {
        Route::get('dashboard', [SubUserDashboardController::class, 'dashboard'])->name('subuser-dashboard');
        Route::post('logout', [SubUserDashboardController::class, 'logout'])->name('subuser-logout');

        Route::controller(SubuserController::class)->group(function () {
            Route::get('/profile', 'getSubuserData')->name('subuser-profile');
            Route::post('/update/subuser/profileimage', 'updateSubUserProfileImage');
            Route::post('/update/subuser/profile', 'updateHimself')->name('update-subuser');
            Route::post('/update/password/subuser', 'updatePassword')->name('update-subuser-password');

        });

        Route::controller(TrackerController::class)->prefix('trackers')->group(function () {
            Route::get('/', 'index')->name('subuser-tracker-list');
            Route::get('/add-tracker', 'addTracker')->name('add_tracker');
            Route::post('/add-tracker', 'store')->name('submit_tracker');
            Route::get('tracker-details/{id}','edit')->name('edit_tracker');
            Route::post('update-tracker','update')->name('update_tracker');
            Route::post('update-tracker/resume','uploadResume')->name('upload_tracker_resume');
            Route::get('/export/tracker/{trackerids?}', 'exportTrackerDataEmployer')->name('export_subuser_tracker');
        });

        Route::get('/reference-list', [ReferenceController::class, 'index']);
        Route::post('/add-reference', [ReferenceController::class, 'store']);

        Route::get('/get-cities/data/{id}', [CitiesController::class, 'getCityByState']);

    });
});
