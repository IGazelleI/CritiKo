<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //Main page
    public function main()
    {
        return view('course.main', [
            'course' => Course::select('courses.id', 'courses.abbre', 'courses.name', 'departments.abbre as department')
                    -> join('departments', 'courses.department_id', 'departments.id')
                    -> latest('id')
                    -> get()
        ]);
    }
    //Show manage course page
    public function manage($department)
    {
        $departments = Department::latest('id')
                        -> where('id', '=', $department)
                        -> get();

        foreach($departments as $deptInfo)
            $dept = $deptInfo;

        return view('course.manage',
        [
            'course' => Course::latest('id')
                    -> where('department_id', '=', $department)
                    -> get(),
            'dept' => $dept
        ]);
    }
    //Show create form
    public function create($department)
    {
        return view('course.create',
        [
            'department' => Department::latest('id')->get(),
            'department_id' => $department
        ]);
    }
    //Store data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'department_id' => ['required'],
            'name' => ['required'],
            'abbre' => ['required']
        ]);
        
        Course::create($formFields);

        return redirect('/course/manage/' . $request->department_id)->with('message', 'Course added.');
    }
    //Show edit Form
    public function edit(Course $course)
    {
        return view('course.edit', [
            'course' => $course,
            'department' => Department::latest('id')->get()
        ]);
    }
    //Update Data
    public function update(Request $request, Course $course)
    {
        $formFields = $request->validate([
            'department_id' => 'required',
            'name' => 'required',
            'abbre' => 'required'
        ]);
        
        $course->update($formFields);

        return redirect('/course/manage/' . $request->department_id)->with('message', 'Course updated.');
    }
    //Delete data
    public function delete(Course $course)
    {
        $course->delete();

        return back()->with('message', 'Course deleted.');
    }
}
