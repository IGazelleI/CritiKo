<?php

namespace App\Http\Controllers;

use App\Models\QType;
use App\Models\Question;
use App\Models\QCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    //Show manage category page
    public function manageCat()
    {
        return view('question.category.manage', [
            'cats' => QCategory::latest('id')
                    -> get()
        ]);
    }
    //Show create category form
    public function createCat()
    {
        return view('question.category.create');
    }
    //Store category data
    public function storeCat(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required'
        ]);

        QCategory::create($formFields);

        return redirect('/q/c')->with('message', 'Question category added.');
    }
    //Show edit category form
    public function editCat(QCategory $cat)
    {
        return view('question.category.edit', [
            'cat' => $cat
        ]);
    }
    //Update category data
    public function updateCat(Request $request, QCategory $cat)
    {
        $formFields = $request->validate([
            'name' => 'required'
        ]);

        $cat->update($formFields);

        return redirect('/q/c')->with('message', 'Question category updated.');
    }
    //Delete category data
    public function deleteCat(QCategory $cat)
    {
        $cat->delete();

        return redirect('/q/c')->with('message', 'Question category deleted.');
    }
    //Show main page
    public function main()
    {
        return view('question.main', [
            'question' => Question::select('questions.id', 'q_types.name as type', 'q_categories.name as category', 'questions.sentence', 'questions.keyword', 'questions.type as answerer')
                    -> join('q_types', 'questions.q_type_id', 'q_types.id')
                    -> join('q_categories', 'questions.q_category_id', 'q_categories.id')
                    -> latest('id')
                    -> get()
        ]);
    }
    //Show manage page by category
    public function myCat(QCategory $cat)
    {
        return view('question.manage', [
            'category' => $cat->name,
            'question' => Question::select('questions.id', 'q_types.name as type', 'questions.sentence', 'questions.keyword', 'questions.type as answerer')
                    -> join('q_types', 'questions.q_type_id', 'q_types.id')
                    -> join('q_categories', 'questions.q_category_id', 'q_categories.id')
                    -> where('questions.q_category_id', '=', $cat->id)
                    -> latest('id')
                    -> get()
        ]);
    }
    //Show create form
    public function create()
    {
        return view('question.create', [
            'types' => QType::latest('id')
                    -> get(),
            'category' => QCategory::latest('id')
                    -> get()
        ]);
    }
    //Store data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'q_type_id' => 'required',
            'q_category_id' => 'required',
            'sentence' => 'required',
            'keyword' => 'required',
            'type' => 'required'
        ]);

        Question::create($formFields);

        return redirect('/question')->with('message', 'Question added.');
    }
    //Show edit form
    public function edit(Question $question)
    {
        return view('question.edit', [
            'q' => $question,
            'types' => QType::latest('id')
                    -> get(),
            'category' => QCategory::latest('id')
                    -> get()
        ]);
    }
    //Update data
    public function update(Request $request, Question $question)
    {
        $formFields = $request->validate([
            'id' => 'required',
            'q_type_id' => 'required',
            'q_category_id' => 'required',
            'sentence' => 'required',
            'keyword' => 'required',
            'type' => 'required'
        ]);

        DB::table('questions')
                ->where ('id','=', $formFields ['id'])
                ->update ([
                    'id' => $formFields ['id'],
                    'q_type_id' => $formFields['q_type_id'],
                    'q_category_id' => $formFields['q_category_id'],
                    'sentence' => $formFields['sentence'],
                    'keyword' => $formFields['keyword'],
                    'type' => $formFields['type'],
                    'updated_at' => NOW()
                ]);
        //$question->update($formFields);
        return redirect('/question')->with('message', 'Question updated.');
    }
    //Delete data
    public function delete(Question $question)
    {
        $question->delete();

        return redirect('/question')->with('message', 'Question deleted.');
    }
    //Preview question
    public function preview()
    {
        return view('question.preview', [
            'question' => Question::select('questions.id', 'q_types.name as type', 'q_categories.name as cat', 'questions.sentence', 'questions.keyword', 'questions.type as answerer')
                                -> join('q_types', 'questions.q_type_id', 'q_types.id')
                                -> join('q_categories', 'questions.q_category_id', 'q_categories.id')
                                -> orderBy('questions.q_category_id')
                                -> get()
        ]);
    }
}
