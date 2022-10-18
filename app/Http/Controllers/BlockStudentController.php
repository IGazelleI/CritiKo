<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Klase;
use App\Models\Student;
use App\Models\BlockStudent;
use App\Models\KlaseDet;
use Illuminate\Http\Request;
use League\CommonMark\Parser\Block\BlockStart;

class BlockStudentController extends Controller
{
    //Show manage page
    public function manage($block)
    {
        return view('block.student.manage', [
            'blocks' => Block::select('blocks.id', 'courses.abbre as course', 'blocks.year_level', 'blocks.section')
                    -> join('courses', 'blocks.course_id', 'courses.id')
                    -> where('blocks.id', '=', $block)
                    -> get(),
            'blockStuds' => BlockStudent::select('block_students.id', 'students.name as student')
                    -> join('students',  'block_students.user_id', 'students.user_id')
                    -> join('blocks', 'block_students.block_id', 'blocks.id')
                    -> where('block_students.block_id', '=', $block)
                    -> get()
        ]);
    }
    //Show add student form
    public function add($block)
    {
        return view('block.student.add', [
            'blocks' => Block::select('blocks.id', 'courses.abbre as course', 'blocks.year_level', 'blocks.section')
                    -> join('courses', 'blocks.course_id', 'courses.id')
                    -> where('blocks.id', '=', $block)
                    -> get(),
            'students' => Block::select('students.user_id as id', 'students.name')
                    -> join('students', 'blocks.course_id', 'students.course_id')
                    -> where('blocks.id', '=', $block)
                    -> get()
        ]);
    }
    //Store block student data
    public function store(Request $request, BlockStudent $blockStud)
    {
        $formFields = $request->validate([
            'block_id' => 'required',
            'user_id' => 'required'
        ]);

        $blockStud::create($formFields);

        return redirect('/block/student/manage/' . $request->block_id)->with('message', 'Student added to block.');
    }
    //Delete block student data
    public function delete(BlockStudent $blockStud)
    {
        $blockStud->delete();

        return back()->with('message', 'Student was removed from current block.');
    }
    //Add current students in block to subjects of the course
    public function addToSubject($block, KlaseDet $klaseDet)
    {
        //select all students from the block
        $blockStuds = BlockStudent::select('students.user_id as student')
                    -> join('students',  'block_students.user_id', 'students.user_id')
                    -> join('blocks', 'block_students.block_id', 'blocks.id')
                    -> where('block_students.block_id', '=', $block)
                    -> get();

        //select all subjects from the course
        $klases = Klase::select('klases.id')
                    -> join('blocks', 'klases.block_id', 'blocks.id')
                    -> join('faculties','klases.user_id', 'faculties.user_id')
                    -> join('subjects', 'klases.subject_id', 'subjects.id')
                    -> where('klases.block_id', '=', $block)
                    -> get();

        foreach($blockStuds as $blockStud)
        {
            foreach($klases as $klase)
            {
                $info['klase_id'] = $klase->id;
                $info['user_id'] = $blockStud->student;

                KlaseDet::create($info);
            }
        }
        
        return back()->with('message', 'All students are now in all subjects.');
    }
}
