<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Rule;

class DepartmentController extends Controller
{
    //Manage
    public function  manage()
    {
        return view('department.manage',
        [
            'department' => Department::get(),        
        ]);
    }
    //Show create form
    public function create()
    {
        return view('department.create');
    }
    //Store data
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'abbre' =>'required'
        ]);

        Department::create($formFields);

        return back()->with('message', 'Department added.');
    }
    //Edit data
    public function edit(Department $department)
    {
        return view('department.edit', [
            'dept' => $department
        ]);
    }
    //Update data
    public function update(Request $request, Department $department)
    {
        $formFields = $request->validate([
            'name' => 'required',
            'abbre' =>'required'
        ]);
        $department->update($formFields);

        return back()->with('message', 'Department updated.');
    }
    //Delete data
    public function delete(Department $department)
    {
        $department->delete();

        return back()->with('message', 'Department deleted.');
    }
    //Period methods
    //Show manage period page
    public function managePeriod()
    {
        return view('period.manage', [
            'periods' => Period::latest('id')
                                -> get()
        ]);
    }
    //Show add period form
    public function addPeriod()
    {
        return view('period.create');
    }
    //Store period data
    public function storePeriod(Request $request)
    {
        $formFields = $request->validate([
            'description' => 'required'
        ]);

        if(isset($request->begin) && isset($request->end))
        {
            $request->validate([
                'end' => 'after:begin'
            ],[
                'end.after' => 'The end date of the evaluation cannot be the date before it starts.'
            ]);
            
            $formFields['begin'] = $request->begin;
            $formFields['end'] = $request->end;
        }

        if(Period::create($formFields))
            return back()->with('message', 'Period added.');
        else
            return back()->with('message', 'Error in adding period.');
    }
    //Show edit perion form
    public function editPeriod(Period $period)
    {
        return view('period.edit', [
            'period' => $period
        ]);
    }
    //Update period data
    public function updatePeriod(Request $request, Period $period)
    {
        $formFields = $request->validate([
            'description' => 'required'
        ]);

        if(isset($request->begin) && isset($request->end))
        {
            $request->validate([
                'end' => 'after:begin'
            ],[
                'end.after' => 'The end date of the evaluation cannot be the date before it starts.'
            ]);

            $formFields['begin'] = $request->begin;
            $formFields['end'] = $request->end;
        }

        if($period->update($formFields))
            return back()->with('message', 'Period updated.');
        else
            return back()->with('message', 'Error in updating period.');
    }
}
