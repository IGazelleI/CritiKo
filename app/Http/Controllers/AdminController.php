<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Attribute;
use App\Models\QCategory;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //Show index page
    public function index()
    {
        return view('admin.index', [
            'users' => User::count(),
            'admins' => User::where('type', '=', 1)
                        -> get()
                        -> count(),
            'sasts' => User::where('type', '=', 2)
                        -> get()
                        -> count(),
            'deans' => User::join('faculties', 'users.id', 'faculties.user_id')
                        -> where('users.type', '=', 3)
                        -> where('faculties.isDean', '=', true)
                        -> get()
                        -> count(),
            'depts' => Department::count(),
            'faculty' => User::where('type', '=', 3)
                        -> get()
                        -> count(),
            'students' => User::where('type', '=', 4)
                        -> get()
                        -> count(),
        ]);
    }
    //Show manage user list
    public function manageUser($type)
    {
        switch($type)
        {
            case 0: $user = User::latest('id')
                            -> get();
                    $title = 'Users';
                    break;
            case 1: $user = User::select('users.id', 'users.name')
                            -> join('admins', 'users.id', 'admins.user_id')
                            -> where('users.type', '=', 1)
                            -> get();
                    $title = 'Admins';
                    break;
            case 2: $user = User::select('id', 'name')
                            -> where('users.type', '=', 2)
                            -> latest('id')
                            -> get();
                    $title = 'SAST Officers';
                    break;
            case 3: $user = User::select('users.id', 'users.name', 'departments.abbre as department')
                            -> join('faculties', 'users.id', 'faculties.user_id')
                            -> join('departments', 'faculties.department_id', 'departments.id')
                            -> where('users.type', '=', 3)
                            -> latest('users.id')
                            -> get();
                    $title = 'Faculties';
                    break;
            case 4: $user = User::select('users.id', 'users.name', 'courses.abbre as course')
                            -> join('students', 'users.id', 'students.user_id')
                            -> join('courses', 'students.course_id', 'courses.id')
                            -> where('users.type', '=', 4)
                            -> latest('users.id')
                            -> get();
                    $title = 'Students';
                    break;
            default: $user = Department::select('departments.id', 'departments.abbre as department')
                            -> get();
                     $deans = User::select('departments.id', 'faculties.name')
                            -> join('faculties', 'users.id', 'faculties.user_id')
                            -> join('departments', 'faculties.department_id', 'departments.id')
                            -> get();
                    $title = 'Deans';
        }
        
        return view('users.manage', [
            'title' => $title,
            'type' => $type,
            'user' => $user,
            'dean' => $deans
        ]);
    }
    //Add random users
    public function addRandom(Request $request, $type)
    {
        for($i = 0; $i < $request->count; $i++)
        {
            //create user
            $user = User::factory()->create([
                'type' => $type
            ]);

            if(!$user)
                return back()->with('message', 'Error in creating user.');
            //create faculty
            if($type == 3)
            {
                $fac = Faculty::factory()->create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'department_id' => random_int(1, Department::count())
                ]);

                if(!$fac)
                    return back()->with('message', 'Error in creating faculty.');
                //create attributes based on all category
                for($i = 1; $i <= QCategory::count(); $i++)
                {
                    if(!Attribute::create([
                        'faculty_id' => $fac->user_id,
                        'q_category_id' => $i,
                        'points' => 50
                    ]))
                        return back()->with('message', 'Error in creating attribute.');
                }
            }
            else if($type == 4) //create student
            {
                if(!Student::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'course_id' => random_int(1, Course::count())
                ]))
                    return back()->with('message', 'Error in creating student.');
            }
        }

        return back()->with('message', 'Added ' . $request->count . ' users.');
    }
    //assign dean form
    public function assignDean(Department $dept)
    {
        return view('admin.assignDean', [
            'dept' => $dept,
            'facs' => Faculty::select('id', 'name')
                    -> where('department_id', '=', $dept->id)
                    -> get()
        ]);
    }
    //update dean
    public function updateDean(Request $request)
    {
        $formFields = $request->validate([
            'department_id' => 'required',
            'user_id' => 'required'
        ]);
        //set all faculty from department  to isdean false
        if(!DB::table('faculties')
            ->where ('department_id','=', $formFields ['department_id'])
            ->update ([
                'isDean' => false
            ]))
            return redirect('/user/manage/5')->with('message', 'Error in updating dean.');

        if(!DB::table('faculties')
                ->where ('id','=', $formFields ['user_id'])
                ->update ([
                    'isDean' => true
                ]))
                return redirect('/user/manage/5')->with('message', 'Error in updating dean.');

        return redirect('/user/manage/5')->with('message', 'Dean updated.');
    }
}
