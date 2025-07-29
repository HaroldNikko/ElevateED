<?php

use App\Http\Controllers\districtsupervisor\DashboardController as DistrictDashboard;
use App\Http\Controllers\evaluator\EvaluatorDashboardController;
use App\Http\Controllers\teacher\TeacherDashboardController;
use App\Http\Controllers\admin\LocationController;
use App\Http\Controllers\ApplicantResultController;

Route::get('/results', [ApplicantResultController::class, 'showForm'])->name('results.form');
Route::post('/results', [ApplicantResultController::class, 'generatePDF'])->name('results.generate');


Route::get('/api/municipalities/{province_id}', [LocationController::class, 'getMunicipalities']);
Route::get('/api/barangays/{municipality_id}', [LocationController::class, 'getBarangays']);
Route::get('/municipalities/{province_id}', [ProfileController::class, 'getMunicipalities']);
Route::get('/barangays/{municipality_id}', [ProfileController::class, 'getBarangays']);





use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\SchoolDetailController;
use App\Http\Controllers\admin\TeacherRankController;
use App\Http\Controllers\admin\CriteriaController;
use App\Http\Controllers\admin\DistrictController;
use App\Http\Controllers\admin\DepedOrderController;
use App\Http\Controllers\Admin\DepEdHierarchyController;
use App\Http\Controllers\Admin\DistrictSupervisorController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\LoginController;
use App\Models\Login;
use App\Http\Controllers\DistrictSupervisor\SchoolController;
use App\Http\Controllers\DistrictSupervisor\fetchController;
use App\Http\Controllers\DistrictSupervisor\ReviewDocumentController;
use App\Http\Controllers\DistrictSupervisor\EvaluatorAssignmentController;
use App\Http\Controllers\admin\SchoolCountController;
use App\Http\Controllers\admin\TeacherImportController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\teacher\FetchPositionController;
use App\Http\Controllers\teacher\UploadDocumentController;
use App\Http\Controllers\teacher\DocumentEvaluationController;
use App\Http\Controllers\teacher\TotalPointController;
use App\Http\Controllers\teacher\NotificationController;
use App\Http\Controllers\teacher\InsertBasicInfoController;
use App\Http\Controllers\evaluator\DocumentReviewController;
use App\Http\Controllers\evaluator\TeacherController;

Route::post('/change-password', [AccountController::class, 'changePassword'])->name('change.password.submit');
Route::post('/check-current-password', [AccountController::class, 'checkCurrentPassword'])->name('check.current.password');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');


Route::post('/admin/school/{schoolID}/import', [TeacherImportController::class, 'import'])->name('import.teachers');
Route::get('/admin/school/{id}/import-csv', [SchoolCountController::class, 'showCsvImport'])->name('admin.csv.import');



Route::get('/consent', function () {
    return view('consent');
})->name('consent');

Route::post('/consent/accept', function (\Illuminate\Http\Request $request) {
    session(['consented' => true]);
    return redirect()->route('login');
})->name('consent.accept');

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});




// District Supervisor dashboard
Route::prefix('districtsupervisor')->name('districtsupervisor.')->group(function () {
    Route::get('/dashboard', [DistrictDashboard::class, 'index'])->name('dashboard');
});

// Evaluator dashboard
Route::prefix('evaluator')->name('evaluator.')->group(function () {
    Route::get('/dashboard', [EvaluatorDashboardController::class, 'index'])->name('dashboard');
});

// Teacher dashboard
Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
});


Route::get('/applicant', function () {
    return view('districtsupervisor.applicant');
})->name('applicant');
Route::get('/profile', function () {
    return view('districtsupervisor.profile');
})->name('profile');


// ✅ USE THIS INSTEAD:
Route::get('/position', [fetchController::class, 'showUploadModal'])->name('position');
use App\Http\Controllers\DistrictSupervisor\UploadPositionController;

Route::post('/upload-position', [UploadPositionController::class, 'store'])->name('upload.store');
Route::get('/position', [UploadPositionController::class, 'index'])->name('position');
Route::get('/result-application/{uploadID}', [UploadPositionController::class, 'viewApplicants'])->name('result.application');
Route::get('/applicant/{id}/details', [\App\Http\Controllers\DistrictSupervisor\ApplicantController::class, 'show']);
Route::get('/applicant/{uploadID}/leaderboards', [\App\Http\Controllers\DistrictSupervisor\ApplicantController::class, 'leaderboards']);
Route::post('/districtsupervisor/submit-results', [\App\Http\Controllers\DistrictSupervisor\ApplicantController::class, 'submitResults']);
Route::post('/districtsupervisor/update-status', [\App\Http\Controllers\DistrictSupervisor\ApplicantController::class, 'updateStatus']);


Route::get('/district-supervisor/evaluators', [EvaluatorAssignmentController::class, 'showEvaluatorForm'])->name('evaluator');
// Route to fetch school name and teacher rank by track code
Route::get('/district-supervisor/fetch-school-teacher', [EvaluatorAssignmentController::class, 'fetchSchoolAndTeacherRank'])->name('fetch.school.teacher');




// 👇 Route for redirection to the detailed review_documents page
Route::get('/districtsupervisor/review_documents/{uploadID}/{criteriaID}/{teacherID}', 
    [ReviewDocumentController::class, 'showUploadForm']
)->name('district.review_documents');





Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('admin')->group(function () {
    Route::get('/criteria', function () {
        return view('admin.criteria');
    })->name('admin.criteria');

    Route::get('/system_log', function () {
        return view('admin.system_log');
    })->name('admin.system_log');

    // // ✅ Use controller to pass $districts
    // Route::get('/manageaccount', [DistrictController::class, 'index'])->name('admin.manageaccount');
    // Route::get('/district/{id}/supervisors', [DistrictController::class, 'viewSupervisors'])->name('district.supervisors');
    // Route::get('/import_csv', function () {
    //     return view('admin.import_csv');
    // })->name('admin.import_csv');
});

// // Store district route (keep outside if it's global)
// Route::post('/district/store', [DistrictController::class, 'store'])->name('district.store');
// Route::post('/district/import-supervisors', [DistrictCSVController::class, 'importSupervisors'])->name('district.supervisors.import');



Route::get('/applicant', [SchoolController::class, 'showApplicantPage'])->name('applicant');



Route::get('/admin/system_log', [App\Http\Controllers\admin\SystemLogController::class, 'index'])->name('admin.system_log');

Route::post('/schools/store', [SchoolDetailController::class, 'store'])->name('schools.store');


// System Setup (Districts)
Route::post('/admin/systemsetup/store', [DistrictController::class, 'store'])->name('admin.systemsetup.store');
Route::post('/admin/systemsetup/update', [DistrictController::class, 'update'])->name('admin.systemsetup.update');
Route::post('/admin/systemsetup/delete', [DistrictController::class, 'delete'])->name('admin.systemsetup.delete');

// District Schools
Route::get('/admin/school/district/{districtID}', [TeacherRankController::class, 'showByDistrict'])->name('admin.school.byDistrict');

// System Setup Page (District + Rank)
Route::get('/admin/systemsetup', [TeacherRankController::class, 'index'])->name('admin.systemsetup');

// Teacher Rank CRUD
Route::post('/teacher-rank/store', [TeacherRankController::class, 'store'])->name('teacher.rank.store');
Route::post('/update-rank', [TeacherRankController::class, 'updateRank'])->name('rank.update');
Route::post('/delete-rank', [TeacherRankController::class, 'deleteRank'])->name('rank.delete');

// School (used inside systemsetup)
Route::post('/update-school', [TeacherRankController::class, 'updateSchool'])->name('school.update');
Route::post('/delete-school', [TeacherRankController::class, 'deleteSchool'])->name('school.delete');



Route::get('/admin/criteria', [CriteriaController::class, 'index'])->name('admin.criteria');
Route::post('/criteria/store', [CriteriaController::class, 'store'])->name('criteria.store');
Route::post('/criteria/update', [CriteriaController::class, 'update'])->name('criteria.update');
Route::post('/criteria/delete', [CriteriaController::class, 'delete'])->name('criteria.delete');




Route::post('/admin/school/store', [SchoolDetailController::class, 'store'])->name('school.store');
Route::post('/admin/school/update', [SchoolDetailController::class, 'update'])->name('school.update');
Route::post('/admin/school/delete', [SchoolDetailController::class, 'delete'])->name('school.delete');


use App\Http\Controllers\Admin\DesignationController;

Route::get('/admin/designation', [DesignationController::class, 'index'])->name('admin.designation.index');
Route::post('/admin/designation/store', [DesignationController::class, 'store'])->name('admin.designation.store');




Route::get('/admin/school', [SchoolCountController::class, 'index'])->name('admin.school');
Route::get('/admin/school/{id}', [SchoolCountController::class, 'show'])->name('admin.school.show');
Route::get('/admin/school/no-teacher/{id}', [SchoolCountController::class, 'noTeacher'])->name('admin.school.no_teacher');
Route::get('/admin/select-region', [SchoolCountController::class, 'selectRegion'])->name('admin.select.region');
Route::get('/admin/region/{id}/divisions-csv', [SchoolCountController::class, 'selectDivision'])->name('admin.region.divisions.csv');
Route::get('/admin/province/{id}/municipalities-csv', [SchoolCountController::class, 'selectMunicipalities'])->name('admin.province.municipalities-csv');
Route::get('/admin/schools/municipality/{municipality_id}/district/{district_id}', [SchoolCountController::class, 'filteredSchools'])->name('admin.schools.filtered');

Route::post('/admin/teachers/ajax-import/{schoolID}', [TeacherImportController::class, 'ajaxImport'])
    ->name('ajax.import.teachers');
Route::post('/check-emails', [TeacherImportController::class, 'checkEmails'])->name('check.emails');


Route::get('/admin/depedorder', [DepedOrderController::class, 'index'])->name('admin.depedorder');
Route::post('/admin/depedorder/store', [DepedOrderController::class, 'store'])->name('admin.depedorder.store');
Route::post('/admin/depedorder/update', [DepedOrderController::class, 'update'])->name('admin.depedorder.update');
Route::post('/admin/depedorder/delete', [DepedOrderController::class, 'delete'])->name('admin.depedorder.delete');
// routes/web.php
Route::get('/admin/depedorder/show20/{id}', [DepedOrderController::class, 'show20'])->name('admin.depedorder.show20');
Route::get('/admin/depedorder/show19/{id}', [DepedOrderController::class, 'show19'])->name('admin.depedorder.show19');
Route::get('/admin/criteria/{id}/levels', [DepedOrderController::class, 'showLevels'])->name('admin.criteria.levels');


Route::prefix('admin')->group(function () {
    Route::get('/deped-hierarchy', [DepEdHierarchyController::class, 'index'])->name('admin.deped.hierarchy');
    Route::get('/region/{id}/provinces', [DepEdHierarchyController::class, 'showProvinces'])->name('admin.region.provinces');

    Route::post('/region/store', [DepEdHierarchyController::class, 'store'])->name('admin.region.store');
    Route::post('/region/{id}/edit', [DepEdHierarchyController::class, 'edit'])->name('admin.region.edit');
    Route::post('/region/{id}/update', [DepEdHierarchyController::class, 'update'])->name('admin.region.update');
    Route::post('/region/{id}/delete', [DepEdHierarchyController::class, 'destroy'])->name('admin.region.destroy');

    Route::post('/province/store', [DepEdHierarchyController::class, 'storeProvince'])->name('admin.province.store');
    Route::put('/province/update/{id}', [DepEdHierarchyController::class, 'updateProvince'])->name('admin.province.update');
    Route::delete('/province/delete/{id}', [DepEdHierarchyController::class, 'destroyProvince'])->name('admin.province.destroy');

    Route::get('/province/{province_id}/districts', [DepEdHierarchyController::class, 'showDistricts'])->name('admin.province.districts');
    Route::post('/district/store', [DepEdHierarchyController::class, 'storeDistrict'])->name('admin.district.store');
    Route::put('/district/update/{id}', [DepEdHierarchyController::class, 'updateDistrict'])->name('admin.district.update');
    Route::delete('/district/delete/{id}', [DepEdHierarchyController::class, 'destroyDistrict'])->name('admin.district.destroy');

    Route::get('/admin/district/{district_id}/municipalities', [DepEdHierarchyController::class, 'showMunicipalities'])->name('admin.district.municipalities');
    Route::post('/admin/municipality/store', [DepEdHierarchyController::class, 'storeMunicipality'])->name('admin.municipality.store');
    Route::put('/admin/municipality/update/{id}', [DepEdHierarchyController::class, 'updateMunicipality'])->name('admin.municipality.update');
    Route::delete('/admin/municipality/delete/{id}', [DepEdHierarchyController::class, 'destroyMunicipality'])->name('admin.municipality.destroy');
    Route::get('/fetch-provinces/{region_id}', [DepEdHierarchyController::class, 'fetchProvinces']);
    Route::get('/fetch-districts/{province_id}', [DepEdHierarchyController::class, 'fetchDistricts']);
    Route::get('/fetch-municipalities/{province_id}', [DepEdHierarchyController::class, 'fetchMunicipalities']);

});

// TeacherRankController version - change URI
Route::get('/admin/region/{id}/divisions', [TeacherRankController::class, 'showDivision'])->name('admin.show_division');
Route::get('/admin/province/{province_id}/municipalities', [TeacherRankController::class, 'showMunDistrict'])->name('admin.showMunDistrict');
Route::get('/admin/systemsetup/addschool', [TeacherRankController::class, 'addSchool'])->name('admin.addschool');
Route::get('/admin/barangays/{municipality}', [TeacherRankController::class, 'getBarangays']);
Route::get('/api/get-municipality-id', function (Request $request) {
    $municipality = \App\Models\Municipality::where('municipality_name', $request->name)->first();
    return response()->json(['id' => $municipality?->municipality_id]);
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::post('/save-school', [TeacherRankController::class, 'saveSchool'])->name('save.school');
    Route::get('/get-school/{id}', [TeacherRankController::class, 'getSchool'])->name('school.get');
    Route::post('/update-school/{id}', [TeacherRankController::class, 'updateSchool'])->name('school.update');
    Route::delete('/delete-school/{id}', [TeacherRankController::class, 'deleteSchool'])->name('school.delete');
});


Route::get('/admin/user-management', [UserManagementController::class, 'index'])->name('admin.user.management');
Route::post('/admin/users/store', [UserManagementController::class, 'store'])->name('admin.users.store');
Route::post('/admin/users/assign-designation', [UserManagementController::class, 'assignDesignation'])->name('admin.users.assignDesignation');
// routes/web.php
Route::post('/admin/users/updatePassword', [UserManagementController::class, 'updatePassword'])->name('admin.users.updatePassword');
Route::delete('/admin/users/delete/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.delete');
// In routes/web.php

// Route to show the change password form for a specific user
Route::get('/admin/users/change-password/{userId}', [UserManagementController::class, 'showChangePasswordForm'])
    ->name('admin.users.showChangePasswordForm');



















// teacher

Route::get('/profile_teacher', [ProfileController::class, 'show'])->name('profile_teacher');
Route::get('/bet', function () {
    return view('teacher.bet');
})->name('teacher.bet');


Route::get('/teacher/applicant', [FetchPositionController::class, 'paginate'])->name('teacher.applicant');
Route::get('/positions', [FetchPositionController::class, 'paginate'])->name('positions.paginate');

// routes/web.php
Route::get('/upload-document/{uploadID}/{criteriaID?}', [UploadDocumentController::class, 'showUploadForm'])->name('upload.document');
Route::get('/teacher/qualification-level/{criteriaID}/{level}', [UploadDocumentController::class, 'getQualificationLevel']);
Route::post('/document-evaluation/store', [DocumentEvaluationController::class, 'store'])->name('document-evaluation.store');
Route::post('/save-basic-details', [UploadDocumentController::class, 'saveBasicDetails'])->name('save.basic.details');
Route::post('/delete-draft', [UploadDocumentController::class, 'deleteDraft'])->name('delete.draft');
Route::post('/store-draft', [UploadDocumentController::class, 'storeDraft'])->name('store.draft');
Route::post('/submit-application', [InsertBasicInfoController::class, 'submitApplication'])->name('submit.application');


Route::post('/totalpoints/store', [TotalPointController::class, 'store'])->name('totalpoints.store');
Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
// web.php



Route::get('/evaluator/rev_doc', [DocumentReviewController::class, 'showEvaluatorDetails'])->name('evaluator.rev_doc');
// In routes/web.php

Route::get('/evaluator/teacher_info/{uploadID}', [TeacherController::class, 'showTeacherInfo'])->name('evaluator.teacher_info');
Route::post('/evaluator/update-status', [App\Http\Controllers\Evaluator\TeacherController::class, 'updateStatus'])->name('evaluator.updateStatus');
Route::get('/evaluator/final-review/{teacherID}/{uploadID}', 
    [TeacherController::class, 'showApplicantDocuments']
)->name('evaluator.final_review_doc');
Route::post('/evaluator/document/update-status', [TeacherController::class, 'updateDocumentStatus'])
    ->name('evaluator.document.updateStatus');
