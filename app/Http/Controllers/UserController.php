<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Attribute;
use App\Models\QCategory;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Show home page
    public function home()
    {
        return view('index');
    }
    //Show register form
    public function register()
    {
        return view('users.register', [
            'departments' => Department::select('id', 'name')
                        -> get(),
            'courses' => Course::select('id', 'name')
                    -> get()
        ]);
    }
    //Store user
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'type' => 'required',
            'name' => ['required', 'min:3'],
            'email' => ['required', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6']
        ]);
        //hash password
        $formFields['password'] = bcrypt($formFields['password']);

        User::create($formFields);

        $users = User::select('id')
                    -> where('email', '=', $formFields['email'])
                    -> get();
        //Creates accounts by roles
        foreach($users as $user)
        {
            switch($formFields['type'])
            {
                case 1: Admin::create([
                            'user_id' => $user->id,
                            'name' => $formFields['name'],
                        ]);
                        break;
                case 3: $this->facultyPreset([
                            'user_id' => $user->id,
                            'name' => $formFields['name'],
                            'department_id' => $request['department_id']
                        ]);
                        
                        break;
                case 4: Student::create([
                            'user_id' => $user->id,
                            'name' => $formFields['name'],
                            'course_id' => $request['course_id']
                        ]);
                        break;
            }
        }

        return redirect('/admin')->with('message', 'User registered.');
    }
    //Show login form
    public function login()
    {
        return view('users.login');
    }
    //Authenticate user
    public function auth(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields))
        {
            $request->session()->regenerate();

            return redirect('/' . auth()->user()->type)->with('message', 'You are now logged in.');
        }
        else
            return back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
    }
    //Logout user
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'You have been logged out.');
    }
    //user-defined methods
    //set faculty account
    function facultyPreset(Array $attr)
    {
        $faculty = Faculty::create([
            'user_id' => $attr['user_id'],
            'name' => $attr['name'],
            'department_id' => $attr['department_id']
        ]);
        //default points
        $default = 50;
        //get all the categories
        $qCats = QCategory::select('id')
                        -> latest('id')
                        -> get();
        //create attributes based on all category
        foreach($qCats as $cat)
        {
            Attribute::create([
                'faculty_id' => $faculty->user_id,
                'q_category_id' => $cat->id,
                'points' => $default
            ]);
        }
    }
}
