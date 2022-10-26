<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Block;
use App\Models\Course;
use App\Models\Period;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\Department;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    //Main page
    public function main()
    {
        return view('block.main', [
            'blocks' => Block::select('blocks.id', 'blocks.year_level', 'blocks.section', 'courses.abbre as course', 'periods.description as semester')
                    -> join('courses', 'blocks.course_id', 'courses.id')
                    -> join('periods', 'blocks.period_id', 'periods.id')
                    -> latest('blocks.id')
                    -> get()
        ]);
    }
    //Show manage page
    public function manage(Course $course)
    {
        return view('block.manage', [
            'course' => $course,
            'blocks' => Block::select('blocks.id', 'blocks.year_level', 'blocks.section', 'periods.description as semester')
                    -> join('periods', 'blocks.period_id', 'periods.id')
                    -> where('blocks.course_id', '=', $course->id)
                    -> get()
        ]);
    }
    //Show create form
    public function create($course)
    {
        //get department_id from course_id
        $department = Course::select('department_id')
                            -> where('id', '=', $course)
                            -> get();

        if($department->isEmpty())
        {
            $courses = Course::latest('id')
                        -> get();

            $adviser = Faculty::latest()
                        -> get();
        }
        else
        {
            foreach($department as $dept)
                $department_id = $dept->department_id;

            $courses = Course::latest('id')
                        -> where('department_id', '=', $department_id)
                        -> get();

            $adviser = Faculty::latest()
                        -> where('department_id', '=', $department_id)
                        -> get();
        }

        return view('block.create', [
            'course_id' => $course,
            'courses' => $courses,
            'adviser' => $adviser
        ]);
    }
    //Store data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'course_id'  => 'required',
            'year_level' => 'required',
            'section' => ['required', 'numeric']
        ]);

        //get current semester
        $semester = Period::select('id')
                        -> latest('id')
                        -> limit(1)
                        -> get();
        foreach($semester as $sems)
            $formFields['period_id']= $sems->id;

        Block::create($formFields);

        return redirect('/block/manage/' . $request->course_id)->with('message', 'Block added.');
    }
    //Show edit form
    public function edit(Block $block)
    {
        //get department_id based on block->course_id
        $departments = Department::select('departments.id')
                                -> join('courses', 'departments.id', 'courses.department_id')
                                -> where('courses.id', '=', $block->course_id)
                                -> get();
        foreach($departments as $department)
            $department_id = $department->id;

        return view('block.edit', [
            'courses' => Course::latest()
                        -> where('department_id', '=', $department_id)
                        -> get(),
            'adviser' => Faculty::select('id', 'name')
                        ->where('department_id', '=', $department_id)
                        ->get(),
            'block' => $block
        ]);
    }
    //Update data
    public function update(Request $request, Block $block)
    {
        $formFields = $request->validate([
            'course_id' => 'required',
            'year_level' => 'required',
            'section' => 'required'
        ]);

        $block->update($formFields);

        return redirect('/block/manage/' . $request->course_id)->with('message', 'Block updated.');
    }
    //Delete data
    public function delete(Block $block)
    {
        $block->delete();

        return back()->with('message', 'Block deleted.');
    }
}
