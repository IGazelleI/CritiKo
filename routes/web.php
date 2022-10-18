<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SASTController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\KlaseController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\KlaseDetController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\BlockStudentController;
use App\Http\Controllers\FacultyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Home page
Route::get('/', [UserController::class, 'home']);

//User routes
//Show register form
Route::get('/register', [UserController::class, 'register'])->middleware('guest');
//Store user data
Route::post('/users', [UserController::class, 'store'])->middleware('guest');
//Show login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
//Authenticate user
Route::post('/users/auth', [UserController::class, 'auth'])->middleware('guest');
//Logout user
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');


//Admin Routes
Route::middleware(['auth', 'user-access:admin'])->group(function ()
{
    //Department Routes
    Route::get('/admin', [AdminController::class, 'index']);
    //Show manage department page
    Route::get('/department/manage', [DepartmentController::class, 'manage']);
    //Show Create Department Form
    Route::get('/department/create', [DepartmentController::class, 'create']);
    //Store Departmment Data
    Route::post('/department', [DepartmentController::class, 'store']);
    //Show Edit Department Form
    Route::get('/department/{department}/edit', [DepartmentController::class, 'edit']);
    //Update Department Data
    Route::put('department/{department}', [DepartmentController::class, 'update']);
    //Delete Department 
    Route::delete('/department/{department}', [DepartmentController::class, 'delete']);

    //Course Routes
    //Course main page
    Route::get('/course', [CourseController::class, 'main']);
    //Show manage course page
    Route::get('/course/manage/{department}', [CourseController::class, 'manage']);
    //Show create course form
    Route::get('/course/create/{department}', [CourseController::class, 'create']);
    //Store course data
    Route::post('/course', [CourseController::class, 'store']);
    //Show Edit Course form
    Route::get('/course/{course}/edit', [CourseController::class, 'edit']);
    //Update Course Data
    Route::put('/course/{course}', [CourseController::class, 'update']);
    //Delete Course
    Route::delete('/course/{course}', [CourseController::class, 'delete']);

    //Subject Routes
    //Subject main page
    Route::get('/subject', [SubjectController::class, 'main']);
    //Show manage subject page
    Route::get('/subject/manage/{course}', [SubjectController::class, 'manage']);
    //Show create subject form
    Route::get('/subject/create/{course}', [SubjectController::class,'create']);
    //Store subject data
    Route::post('/subject', [SubjectController::class, 'store']);
    //Show edit subject form
    Route::get('/subject/{subject}/edit', [SubjectController::class, 'edit']);
    //Update subject data
    Route::put('/subject/{subject}', [SubjectController::class, 'update']);
    //Dete Subject
    Route::delete('/subject/{subject}', [SubjectController::class, 'delete']);

    //Block Routes
    //Block main page
    Route::get('/block', [BlockController::class, 'main']);
    //Show manage block page
    Route::get('/block/manage/{subject}', [BlockController::class, 'manage']);
    //Show create block form
    Route::get('/block/create/{subject}', [BlockController::class, 'create']);
    //Store block data
    Route::post('/block', [BlockController::class, 'store']);
    //Show edit block form
    Route::get('/block/{block}/edit', [BlockController::class, 'edit']);
    //Update block data
    Route::put('/block/{block}', [BlockController::class, 'update']);
    //Delete Block
    Route::delete('/block/{block}', [BlockController::class, 'delete']);

    //Block Students Routes
    //Show manage block students page
    Route::get('/block/student/manage/{block}', [BlockStudentController::class, 'manage']);
    //Show add student to block form
    Route::get('/block/student/add/{block}', [BlockStudentController::class, 'add']);
    //Store student to block
    Route::post('/block/student', [BlockStudentController::class, 'store']);
    //Delete student to block
    Route::delete('/block/student/{blockStud}', [BlockStudentController::class, 'delete']);
    //Add all students in block to subjects of the course
    Route::get('/block/student/addToSubjects/{block}', [BlockStudentController::class, 'addToSubject']);


    //Block Klase Routes
    //Show manage klase page
    Route::get('/block/klase/manage/{block}', [KlaseController::class, 'manage']);
    //Show add subject to block form
    Route::get('/block/klase/add/{block}', [KlaseController::class, 'add']);
    //Store klase data
    Route::post('/block/klase', [KlaseController::class, 'store']);
    //Show edit klase form
    Route::get('/block/klase/{klase}/edit', [KlaseController::class, 'edit']);
    //Update klase data
    Route::put('/block/klase/{klase}', [KlaseController::class, 'update']);
    //Delete klase detail
    Route::delete('/block/klase/{klase}', [KlaseController::class, 'delete']);

    //Block Klase Student Routes
    //Show  manage klase student page
    Route::get('/block/klase/detail/manage/{klase}', [KlaseDetController::class, 'manage']);
    //Show add student to klase form
    Route::get('/block/klase/detail/add/{klase}', [KlaseDetController::class,  'add']);
    //Store student data to class
    Route::post('/block/klase/detail', [KlaseDetController::class, 'store']);
    //Delete student from class
    Route::delete('block/klase/detail/{klaseDet}', [KlaseDetController::class, 'delete']);
});
//SAST routes
Route::middleware(['auth', 'user-access:sast'])->group(function ()
{
    Route::get('/sast', [SASTController::class, 'index']);
    //Question Routes
    //Category
    //Show question categories
    Route::get('/q/c', [QuestionController::class, 'manageCat']);
    //Show create category form
    Route::get('/q/c/create', [QuestionController::class, 'createCat']);
    //Store category data
    Route::post('/q/c', [QuestionController::class, 'storeCat']);
    //Show edit category form
    Route::get('/q/c/{cat}/edit', [QuestionController::class, 'editCat']);
    //Update category data
    Route::put('/q/c/{cat}', [QuestionController::class, 'updateCat']);
    //Delete category data
    Route::delete('/q/c/{cat}', [QuestionController::class, 'deleteCat']);
    //Question
    //Show question main page
    Route::get('/question', [QuestionController::class, 'main']);
    //Show question main page by category
    Route::get('/question/manage/{cat}', [QuestionController::class, 'mByCat']);
    //Show create question form
    Route::get('/question/create', [QuestionController::class, 'create']);
    //Store question data
    Route::post('/question', [QuestionController::class, 'store']);
    //Show edit question form
    Route::get('/question/{question}/edit', [QuestionController::class, 'edit']);
    //Update question data
    Route::put('/question', [QuestionController::class, 'update']);
    //Delete question data
    Route::delete('/question/{question}', [QuestionController::class, 'delete']);
    //Preview question
    Route::get('/question/preview', [QuestionController::class, 'preview']);
});
//Faculty Routes
Route::middleware(['auth', 'user-access:faculty'])->group(function()
{
    //faculty main page
    Route::get('/faculty', [FacultyController::class, 'index']);
    //Display evaluate faculty form
    Route::get('/faculty/evaluate', [FacultyController::class, 'evaluate']);
});

//Student Routes
Route::middleware(['auth', 'user-access:student'])->group(function()
{
    //student main page
    Route::get('/student', [StudentController::class, 'index']);
    //Display evaluate faculty form
    Route::get('/student/evaluate', [StudentController::class, 'evaluate']);
    //Store evaluation data
    Route::post('/student', [StudentController::class, 'store']);
});