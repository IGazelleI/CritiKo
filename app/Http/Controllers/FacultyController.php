<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Question;
use App\Models\Attribute;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Charts\AttributeChart;

class FacultyController extends Controller
{
    //Home page
    public function index()
    {
        $attribute = Attribute::select('q_categories.name', 'attributes.points')
                            -> join('q_categories', 'attributes.q_category_id', 'q_categories.id')
                            -> where('attributes.faculty_id', '=', auth()->user()->id)
                            -> get();
        $chart = new AttributeChart();

        $labels = [];
        $points = [];
        $count = 0;
        foreach($attribute as $att)
        {
            $labels[$count] = $att->name; 
            $points[$count] = $att->points;
            $count++;
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

        //get current department
        $depts = Faculty::select('department_id')
                        -> where('user_id', '=', auth()->user()->id)
                        -> get();
        foreach($depts as $dept)
            $deptID = $dept->department_id;

        return view('faculty.index', [
            'attribute' => $attribute,
            'facs' => Faculty::select('user_id', 'name')
                            -> where('department_id', '=', $deptID)
                            -> whereNot('user_id', '=', auth()->user()->id)
                            -> get(),
            'status' => Evaluation::select('evaluatee')
                            -> where('evaluator', '=', auth()->user()->id)
                            -> groupBy('evaluatee')
                            -> get(),
            'chart' => $chart
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
}
