<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Subject;
use App\Models\Department;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    //Main page
    public function main()
    {
        return view('subject.main', [
            'subject' => Subject::select('subjects.id', 'subjects.code', 'subjects.name', 'courses.abbre as course')
                    -> join('courses', 'subjects.course_id', 'courses.id')
                    -> latest('subjects.id')
                    -> get()
        ]);
    }
    //Show manage page
    public function manage($course)
    {
        $courses = Course::latest()
                        -> where('id', '=', $course)
                        -> get();

        foreach($courses as $courseInfo)
            $c = $courseInfo;

        return view('subject.manage', [
            'subject' => Subject::latest('id')
                    -> where('course_id', '=', $course)
                    -> get(),
            'course' => $c,
        ]);
    }
    //Show create form
    public function create($course)
    {
        $department = Course::select('department_id')
                    ->where('id', '=', $course)
                    ->get();

        if($department->isEmpty())
        {
            $courses = Course::latest('id')
                        -> get();
        }
        else
        {
            foreach($department as $dept)
            $department_id = $dept->department_id;

            $courses = Course::latest('id')
                        -> where('department_id', '=', $department_id)
                        -> get();
        }

        return view('subject.create', [
            'course' => $courses,
            'course_id' => $course
        ]);
    }
    //Store data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'course_id' => 'required',
            'code' => 'required',
            'name' => 'required'
        ]);

        Subject::create($formFields);

        return redirect('/subject/manage/' . $request->course_id)->with('message', 'Subject added.');
    }
    //Show edit form
    public function edit(Subject $subject)
    {
        $department = Course::select('department_id')
                    ->where('id', '=', $subject->course_id)
                    ->get();
                    
        foreach($department as $dept)
            $department_id = $dept->department_id;
        
        return view('subject.edit', [
            'course' => Course::latest('id')
                    -> where('department_id', '=', $department_id)
                    -> get(),
            'subj' => $subject
        ]);
    }
    //Update Data
    public function update(Request $request, Subject $subject)
    {
        $formFields = $request->validate([
            'course_id' => 'required',
            'code' => 'required',
            'name' => 'required'
        ]);

        $subject->update($formFields);

        return redirect('/subject/manage/' . $request->course_id)->with('message', 'Subject updated.');
    }
    //Delete data
    public function delete(Subject $subject)
    {
        $subject->delete();

        return back()->with('message', 'Subject deleted.');
    }
}
