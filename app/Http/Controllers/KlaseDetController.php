<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Klase;
use App\Models\Student;
use App\Models\KlaseDet;
use Illuminate\Http\Request;

class KlaseDetController extends Controller
{
    //Show manage page
    public function manage($klase)
    {
        return view('block.klase.detail.manage', [
            'klases' => Klase::select('klases.id', 'subjects.name')
                    -> join('subjects', 'klases.subject_id', 'subjects.id')
                    -> where('klases.id', '=', $klase)
                    -> get(),
            'klase_dets' => KlaseDet::select('klase_dets.id', 'students.name as student')
                    -> join('klases', 'klase_dets.klase_id', 'klases.id')
                    -> join('students', 'klase_dets.user_id', 'students.user_id')
                    -> where('klase_dets.klase_id', '=', $klase)
                    -> get()
        ]);
    }
    //Show add student form
    public function add($klase)
    {
        return view('block.klase.detail.add', [
            'klases' => Klase::select('klases.id', 'subjects.name as subject')
                    -> join('subjects', 'klases.subject_id', 'subjects.id')
                    -> where('klases.id', '=', $klase)
                    -> get(),
            'students' => Student::select('students.user_id as id', 'students.name')
                    -> join('courses', 'students.course_id', 'courses.id')
                    -> join('blocks', 'courses.id', 'blocks.course_id')
                    -> join('klases', 'blocks.id', 'klases.block_id')
                    -> where('klases.id', '=', $klase)
                    -> get()
        ]);
    }
    //Store student data to klase
    public function store(Request $request, KlaseDet $klaseDet)
    {
        $formFields = $request->validate([
            'klase_id' => 'required',
            'user_id' =>  'required'
        ]);
        
        $klaseDet::create($formFields);

        return redirect('/block/klase/detail/manage/' . $request->klase_id)->with('message', 'Student added to class.');
    }
    //Delete student data from klase
    public function delete(KlaseDet $klaseDet)
    {
        $klaseDet->delete();

        return back()->with('message', 'Student has been removed from the subject.');
    }
}
