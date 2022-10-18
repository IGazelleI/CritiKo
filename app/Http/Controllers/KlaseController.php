<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Block;
use App\Models\Klase;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Subject;
use App\Models\Department;
use Illuminate\Http\Request;

class KlaseController extends Controller
{
    //Show manage page
    public function manage($block)
    {
        return view('block.klase.manage', [
            'blocks' => Block::select('blocks.id', 'courses.abbre as course', 'blocks.year_level', 'blocks.section')
                    -> join('courses', 'blocks.course_id', 'courses.id')
                    -> where('blocks.id', '=', $block)
                    -> get(),
            'klases' => Klase::select('klases.id', 'subjects.name as subject', 'faculties.name as instructor')
                    -> join('blocks', 'klases.block_id', 'blocks.id')
                    -> join('faculties','klases.user_id', 'faculties.user_id')
                    -> join('subjects', 'klases.subject_id', 'subjects.id')
                    -> where('klases.block_id', '=', $block)
                    -> latest('klases.id')
                    -> get()
        ]);
    }
    //Show add form
    public function add(Block $block)
    {
        //get department_id based on $block->course_id
        $department = Department::select('departments.id')
                                -> join('courses', 'departments.id', 'courses.department_id')
                                -> where('courses.id', '=', $block->course_id)
                                -> get();

        foreach($department as $dept)
            $department_id = $dept->id;

        return view('block.klase.add', [
            'blocks' => Block::select('blocks.id', 'courses.abbre as course', 'blocks.year_level', 'blocks.section')
                    -> join('courses', 'blocks.course_id', 'courses.id')
                    -> where('blocks.id', '=', $block->id)
                    -> get(),
            'subjects' => Subject::select('id', 'name')
                    -> where('course_id', '=', $block->course_id)
                    -> get(),
            'instructor' => Faculty::latest()
                    -> where('department_id', '=', $department_id)
                    -> get()
        ]);
    }
    //Store data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'block_id' => 'required',
            'subject_id' => 'required',
            'user_id' => 'required'
        ]);
        
        Klase::create($formFields);

        return redirect('/block/klase/manage/' . $request->block_id)->with('message', 'Class added.');
    }
    //Show edit form
    public function edit(Klase $klase)
    {
        //get department_id based on $klase->block_id
        $dets = Department::select('departments.id as dept', 'courses.id as course')
                                -> join('courses', 'departments.id', 'courses.department_id')
                                -> join('blocks', 'courses.id', 'blocks.course_id')
                                -> where('blocks.id', '=', $klase->block_id)
                                -> get();
       
        foreach($dets as $det)
        {
            $department_id = $det->dept;
            $course_id = $det->course;
        }

        return view('block.klase.edit', [
            'blocks' => Block::select('blocks.id', 'courses.abbre as course', 'blocks.year_level', 'blocks.section')
                    -> join('courses', 'blocks.course_id', 'courses.id')
                    -> where('blocks.id', '=', $klase->block_id)
                    -> get(),
            'subjects' => Subject::select('id', 'name')
                    -> where('course_id', '=', $course_id)
                    -> get(),
            'instructor' => Faculty::latest()
                    -> where('department_id', '=', $department_id)
                    -> get(),
            'klase' =>  $klase
        ]);
    }
    //Update data
    public function update(Request $request, Klase $klase)
    {
        $formFields = $request->validate([
            'block_id' => 'required',
            'subject_id' => 'required',
            'user_id' => 'required'
        ]);

        $klase->update($formFields);

        return redirect('/block/klase/manage/' . $request->block_id)->with('message', 'Class updated.');
    }
    //Delete data
    public function delete(Klase $klase)
    {
        $klase->delete();

        return back()->with('message', 'Class deleted.');
    }
}
