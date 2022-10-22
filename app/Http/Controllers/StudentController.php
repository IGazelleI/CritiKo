<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Block;
use App\Models\Klase;
use App\Models\Course;
use App\Models\Period;
use App\Models\EvalDet;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Question;
use App\Models\Attribute;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    //Home page
    public function index()
    {
        //get current semester
        $semester = Period::select('description')
                        -> latest('id')
                        -> limit(1)
                        -> get();

        if($semester->isEmpty())
        {
            $sem = 'Enrollment period is empty.';
            $enrollStatus = $sem;
        }
        else
        {
            foreach($semester as $sems)
                $sem = $sems->description;

            //get enrollment status
            $enrollment = Enrollment::select('status')
                                -> where('user_id', '=', auth()->user()->id)
                                -> get();

            if($enrollment->isEmpty())
                $enrollStatus = 'Currently not enrolled.';
            else
            {
                foreach($enrollment as $enroll)
                    $enrollStatus = $enroll->status;
            }
        }

        return view('student.index', [
            'semester' => $sem,
            'enrollStatus' => $enrollStatus,
            'klases' => Klase::select('subjects.code as subject', 'faculties.user_id as insID', 'faculties.name as instructor')
                                -> join('faculties', 'klases.user_id', 'faculties.user_id')
                                -> join('klase_dets', 'klases.id', 'klase_dets.klase_id')
                                -> join('subjects', 'klases.subject_id', 'subjects.id')
                                -> groupBy('subjects.code', 'faculties.user_id', 'faculties.name')
                                -> get(),
            'status' => Evaluation::select('evaluatee')
                                -> where('evaluator', '=', auth()->user()->id)
                                -> groupBy('evaluatee')
                                -> get()

        ]);
    }
    //Show evaluate faculty
    public function evaluate()
    {
        //get latest period details
        $period = [];
        $periods = Period::latest('id')
                        -> limit(1)
                        -> get();

        if($periods->isEmpty())
        {
            $period['empty'] = true;
        }
        else
        {
            foreach($periods as $dets)
                $period = $dets;
        }
        //get block from user_id
        $blocks = Block::select('blocks.id')
                    -> join('block_students', 'blocks.id', 'block_students.block_id')
                    -> where('block_students.user_id', '=', auth()->user()->id)
                    -> get();

        if($blocks->isEmpty())
        {
            $instructor = Block::select('faculties.user_id as id', 'subjects.name as subject', 'faculties.name')
                            -> join('klases', 'blocks.id', 'klases.block_id')
                            -> join('subjects', 'klases.subject_id', 'subjects.id')
                            -> join('faculties', 'klases.user_id', 'faculties.user_id')
                            -> where('blocks.id', '=', 0)
                            -> get();
        }
        else
        {
            foreach($blocks as $block)
                $block_id = $block->id;

            $instructor = Block::select('faculties.user_id as id', 'subjects.name as subject', 'faculties.name')
                            -> join('klases', 'blocks.id', 'klases.block_id')
                            -> join('subjects', 'klases.subject_id', 'subjects.id')
                            -> join('faculties', 'klases.user_id', 'faculties.user_id')
                            -> where('blocks.id', '=', $block_id)
                            -> get();
        }

        return view('student.evaluate', [
            'period' => $period,
            'instructor' => $instructor,
            'question' => Question::select('questions.id', 'q_types.name as type', 'q_categories.name as cat', 'questions.sentence', 'questions.keyword', 'q_categories.id as catID')
                                -> join('q_types', 'questions.q_type_id', 'q_types.id')
                                -> join('q_categories', 'questions.q_category_id', 'q_categories.id')
                                -> orderBy('questions.q_category_id')
                                -> where('questions.type',  '=', 4)
                                -> get()
        ]);
    }
    //Store evaluation data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'user_id' => 'required'
        ]);
        
        $eval = Evaluation::create([
            'evaluator' => auth()->user()->id,
            'evaluatee' => $formFields['user_id']
        ]);

        //update faculty points
        $prevCat = 0;
        $catPts = 0;
        $catCount = 0;

        //insert the eval dets
        for($i = 1; $i <= $request->totalQuestion; $i++)
        {
            //insert to evaluation details table
            EvalDet::create([
                'question_id' => $request['qID' . $i],
                'answer' => $request['qAns' . $i],
                'evaluation_id' => $eval->id
            ]);
            
            if($prevCat != $request['qCatID' . $i] && $prevCat != 0)
            {
                $details = [
                    'faculty_id' => $formFields['user_id'],
                    'q_category_id' => $prevCat,
                    'points' => ($catPts / ($catCount * 5)) * 100
                ];

                $e = DB::table('attributes')
                    -> where('faculty_id', '=', $details['faculty_id'])
                    -> where('q_category_id', '=', $details['q_category_id'])
                    -> update(['points' => $details['points']]);

                $catcount = 0;
                $catPts = 0;
            }

            if($prevCat == $request['qCatID' . $i])
            {
                $catPts += $request['qAns' . $i];

                $catCount++;
            }

            $prevCat = $request['qCatID' . $i];
        }

        return redirect('/student')->with('message', 'Evaluation submitted.');
    }
    //Enrollment methods
    //Show enrollment form
    public function enrollForm()
    {
        //get current semester
        $semester = Period::select('id')
                        -> latest('id')
                        -> limit(1)
                        -> get();

        foreach($semester as $sems)
            $semID = $sems->id;

        //get previous year level
        $years = Student::select('year_level')
                        -> where('user_id', '=', auth()->user()->id)
                        -> get();

        if($years->isEmpty())
            $year = 1;
        else
        {
            foreach($years as $y)
                $year = $y->year_level;
        }

        return view('student.enrollment', [
            'semID' => $semID,
            'prevYear' => $year,
            'courses' => Course::select('id', 'name')
                    -> get()
        ]);
    }
    //Submit enrollment
    public function enroll(Request $request)
    {
        $formFields = $request->validate([
            'period_id' => 'required',
            'course_id' => 'required',
            'year_level' => 'required'
        ]);

        $formFields['user_id'] = auth()->user()->id;
        $formFields['status'] = 'Pending';

        if(Enrollment::create($formFields))
            return redirect('/student')->with('message', 'Enrollment submitted.');
        else
            return redirect('/student')->with('message', 'Error in submitting enrollment.');
    }
}
