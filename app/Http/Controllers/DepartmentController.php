<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

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
}
