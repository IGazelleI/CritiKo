<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Period;
use App\Models\EvalDet;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Question;
use App\Models\Attribute;
use App\Models\Enrollment;
use App\Models\Evaluation;
use App\Models\BlockStudent;
use Illuminate\Http\Request;
use App\Charts\AttributeChart;
use Illuminate\Support\Facades\DB;

class FacultyController extends Controller
{
    //Home page
    public function index()
    {
        $lowAtt = 100;
        $attribute = Attribute::select('q_categories.name', 'attributes.points', 'attributes.q_category_id as catID')
                            -> join('q_categories', 'attributes.q_category_id', 'q_categories.id')
                            -> where('attributes.faculty_id', '=', auth()->user()->id)
                            -> get();
        //display attribute chart            
        $chart = new AttributeChart();

        $labels = [];
        $points = [];
        $count = 0;

        foreach($attribute as $att)
        {
            //chart process
            $labels[$count] = $att->name; 
            $points[$count] = $att->points;
            $count++;
            //recommendation process
            if($att->points < $lowAtt)
            {
                $lowAtt = $att->points;
                $lowAttCat =  $att->catID;
            }
        }
        $chart->labels($labels);
        $chart->dataset('Latest', 'radar', $points);
        $chart->options([
            'pointBorderColor' => 'Blue',
            'scales' => [
                'r' => [
                    'min' => 1,
                    'max' => 100,
		    'ticks' => [
			    'stepSize' => 20,
			    'display' => false
			            ]
		              ]
            ],
            'responsive' => true
        ]);
        //recommendations
        $recommendation = Question::select('keyword')
                            -> where('q_category_id', '=', $lowAttCat)
                            -> get();

        //get current department
        $depts = Faculty::select('department_id')
                        -> where('user_id', '=', auth()->user()->id)
                        -> get();
        foreach($depts as $dept)
            $deptID = $dept->department_id;

        return view('faculty.index', [
            'attribute' => $attribute,
            'recommend' => $recommendation,
            'comments' => EvalDet::select('eval_dets.answer')
                                -> join('questions', 'eval_dets.question_id', 'questions.id')
                                -> join('q_types', 'questions.q_type_id', 'q_types.id')
                                -> join('evaluations', 'eval_dets.evaluation_id', 'evaluations.id')
                                -> where('questions.q_type_id', '=', 2)
                                -> where('evaluations.evaluatee', '=', auth()->user()->id)
                                -> latest('eval_dets.id')
                                -> get(),
            'facs' => Faculty::select('user_id', 'name')
                            -> where('department_id', '=', $deptID)
                            -> whereNot('user_id', '=', auth()->user()->id)
                            -> get(),
            'status' => Evaluation::select('evaluatee')
                            -> where('evaluator', '=', auth()->user()->id)
                            -> groupBy('evaluatee')
                            -> get(),
            'chart' => $chart,
        ]);
    }
    //Show evaluate form
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
        //get current department
        $depts = Faculty::select('department_id')
                        -> where('user_id', '=', auth()->user()->id)
                        -> get();
        foreach($depts as $dept)
            $deptID = $dept->department_id;

        return view('faculty.evaluate', [
            'period' => $period,
            'facs' => Faculty::select('user_id as id', 'name')
                            -> where('department_id', '=', $deptID)
                            -> whereNot('user_id', '=', auth()->user()->id)
                            -> get(),
            'status' => Evaluation::select('evaluatee')
                            -> where('evaluator', '=', auth()->user()->id)
                            -> groupBy('evaluatee')
                            -> get(),
            'question' => Question::select('questions.id', 'q_types.id as typeID', 'q_types.name as type', 'q_categories.name as cat', 'questions.sentence', 'questions.keyword', 'q_categories.id as catID')
                            -> join('q_types', 'questions.q_type_id', 'q_types.id')
                            -> join('q_categories', 'questions.q_category_id', 'q_categories.id')
                            -> orderBy('questions.q_category_id')
                            -> where('questions.type',  '=', 3)
                            -> get()
        ]);
    }
    //Dean methods
    //Show current enrollments
    public function enrollments()
    {
        return view('dean.enrollments', [
            'enrollment' => Enrollment::select('enrollments.id', 'students.name as student', 'courses.name as course', 'enrollments.year_level')
                                    -> join('students', 'enrollments.user_id', 'students.user_id')
                                    -> join('courses', 'enrollments.course_id', 'courses.id')
                                    -> where('enrollments.status', '=', 'Pending')
                                    -> get()
        ]);
    }
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'user_id' => 'required'
        ], [
            'user_id.required' => 'Faculty field is required.'
        ]);
        
        $eval = Evaluation::create([
            'evaluator' => auth()->user()->id,
            'evaluatee' => $formFields['user_id']
        ]);

        if(!$eval)
            return back()->with('message', 'Error in creating evaluation.');

        //update faculty points
        $prevCat = 0;
        $catPts = 0;
        $catCount = 0;

        //insert the eval dets
        for($i = 1; $i <= $request->totalQuestion; $i++)
        {
            //insert to evaluation details table
            if(!EvalDet::create([
                'question_id' => $request['qID' . $i],
                'answer' => $request['qAns' . $i],
                'evaluation_id' => $eval->id
            ]))
                return back()->with('message', 'Error in creating evalation detail.');
            //update attribute of evaluatee based on points
            if($prevCat != $request['qCatID' . $i] && $prevCat != 0)
            {
                //get points of the current category of the faculty
                $points = Attribute::select('points')
                                -> where('q_category_id', '=', $prevCat)
                                -> where('faculty_id', '=', $eval->evaluatee)
                                -> get();

                foreach($points as $point)
                    $pts = $point->points;

                $pts = ($pts + (($catPts / ($catCount * 5)) * 100)) / 2;

                $details = [
                    'faculty_id' => $formFields['user_id'],
                    'q_category_id' => $prevCat,
                    'points' => $pts
                ];

                if(!DB::table('attributes')
                    -> where('faculty_id', '=', $details['faculty_id'])
                    -> where('q_category_id', '=', $details['q_category_id'])
                    -> update(['points' => $details['points']]))
                    return back()->with('message', 'Error in updating attribute');

                $catcount = 0;
                $catPts = 0;
            }
            //get points from evaluation
            if($prevCat == $request['qCatID' . $i])
            {
                $catPts += (int) $request['qAns' . $i];

                $catCount++;
            }

            $prevCat = $request['qCatID' . $i];
        }

        return redirect('/faculty')->with('message', 'Evaluation submitted.');
    }
    //Decision for enrollments (dean only)
    public function enrollmentAction(Request $request, Enrollment $enroll)
    {
        $status = ($request->decision)? 'Approved' : 'Denied';

        if(!DB::table('enrollments')
            ->where('id', '=', $enroll->id)
            ->update(['status' => $status, 'updated_at' => NOW()]))
            return back()->with('message', 'Error in updating enrollment.');
        //Adds to block if approved
        if($request->decision)
        {
            $studSec = Student::select('section')
                            -> where('user_id', '=', $enroll->user_id)
                            -> get();

            if($enroll->year_level == 1 || $studSec[0]->section == NULL) //first year or transferee dretso 2nd year or so
            {
                //auto-assign to section
                //get current blocks
                $blocks = Block::select('id')
                                -> where('period_id', '=', $enroll->period_id)
                                -> where('course_id', '=', $enroll->course_id)
                                -> where('year_level', '=', $enroll->year_level)
                                -> latest('id')
                                -> limit(1)
                                -> get();
                //create new blocks starting from section 1
                if($blocks->isEmpty())
                {
                    $block = Block::create([
                        'course_id' => $enroll->course_id,
                        'year_level' => $enroll->year_level,
                        'section' => 1,
                        'period_id' => $enroll->period_id
                    ]);

                    if(!$block)
                        return back()->with('message', 'Error in creating block.');

                    //Add student to block
                    if(!BlockStudent::create([
                        'block_id' => $block->id,
                        'user_id' => $enroll->user_id
                    ]))
                        return back()->with('message', 'Error in adding student to new section after creating block.');
                }
                else
                {
                    foreach($blocks as $block)
                        $blockID = $block->id;

                    //Add student to block
                    if(!BlockStudent::create([
                        'block_id' => $blockID,
                        'user_id' => $enroll->user_id
                    ]))
                        return back()->with('message', 'Error in adding student to latest block.');
                    
                    $maxStudentPerBlock = 5;
                    //Count students from block
                    $studs = BlockStudent::select('id')
                                        -> where('block_id', '=', $blockID)
                                        -> get();
                    $studNum = $studs->count();

                    if($studNum == $maxStudentPerBlock)
                    {
                        //get latest section
                        $secs = Block::select('section')
                                    -> where('id', '=', $blockID)
                                    -> get();

                        if(!$secs)
                            return back()->with('message', 'Error in getting latest section.');
                        //increment latest section
                        foreach($secs as $sec)
                            $newSection = $sec->section + 1;

                        $block = Block::create([
                            'course_id' => $enroll->course_id,
                            'year_level' => $enroll->year_level,
                            'section' => $newSection,
                            'period_id' => $enroll->period_id
                        ]);
    
                        if(!$block)
                            return back()->with('message', 'Error in creating new block after max reached.');
                    }
                }
            }
            else
            {
                //assign to old section
                //get old section
                $sections = Student::select('section')
                                -> where('user_id', '=', $enroll->user_id)
                                -> limit(1)
                                -> get();

                foreach($sections as $sec)
                    $section = $sec->section;

                //check if there already is block with this section and year
                $blocks =  Block::select('id')
                                -> where('section', '=', $section)
                                -> where('period_id', '=', $enroll->period_id)
                                -> get();
                //create block if there isn't
                if($blocks->isEmpty())
                {
                    $block = Block::create([
                        'course_id' => $enroll->course_id,
                        'year_level' => $enroll->year_level,
                        'section' => $section,
                        'period_id' => $enroll->period_id
                    ]);

                    if(!$block)
                        return back()->with('message', 'Error in creating block.');

                    //Add student to block
                    if(!BlockStudent::create([
                        'block_id' => $block->id,
                        'user_id' => $enroll->user_id
                    ]))
                        return back()->with('message', 'Error in adding student to old section after creating block.');
                }
                else
                {
                    foreach($blocks as $block)
                        $blockID = $block->id;

                    if(!BlockStudent::create([
                        'block_id' => $blockID,
                        'user_id' => $enroll->user_id
                    ]))
                        return back()->with('message', 'Error in adding student to old section.');
                }
            }

            return back()->with('message', 'Enrollment ' . $status . '.');
        }

        return back()->with('message', 'Enrollment ' . $status . '.');
    }
}
