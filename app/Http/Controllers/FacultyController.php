<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Question;
use App\Models\Attribute;
use App\Models\Enrollment;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Charts\AttributeChart;
use App\Models\BlockStudent;
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
                $lowAtt = $att->catID;
        }
        $chart->labels($labels);
        $chart->dataset('Attributes', 'radar', $points);
        $chart->options([
            'pointBorderColor' => 'Blue',
            'scales' => [
                'r' => [
                    'suggestedMin' => 1,
                    'suggestedMax' => 100
            ]]
        ]);
        //recommendations
        $recommendation = Question::select('keyword')
                            -> where('q_category_id', '=', $lowAtt)
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
        //get current department
        $depts = Faculty::select('department_id')
                        -> where('user_id', '=', auth()->user()->id)
                        -> get();
        foreach($depts as $dept)
            $deptID = $dept->department_id;

        return view('faculty.evaluate', [
            'facs' => Faculty::select('user_id as id', 'name')
                            -> where('department_id', '=', $deptID)
                            -> whereNot('user_id', '=', auth()->user()->id)
                            -> get(),
            'question' => Question::select('questions.id', 'q_types.name as type', 'q_categories.name as cat', 'questions.sentence', 'questions.keyword', 'q_categories.id as catID')
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
    //Decision for enrollments
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
            if($enroll->year_level == 1) //first year
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
