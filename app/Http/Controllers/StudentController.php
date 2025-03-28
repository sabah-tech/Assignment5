<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    // Display a list of students
    public function index()
    {
        $students = Student::all(); // Later: add filtering logic
        return view('students.index', compact('students'));
    }

    // Show the form to create a new student
    public function create()
    {
        return view('create');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $minAge = $request->input('min_age');
        $maxAge = $request->input('max_age');

        $students = Student::query();
            if (!empty($query)) {
            $students->where('name', 'LIKE', "%{$query}%");
        }
            if (!empty($minAge)) {
            $students->where('age', '>=', $minAge);
        }
        if (!empty($maxAge)) {
            $students->where('age', '<=', $maxAge);
        }
            $students = $students->get();
            if ($request->ajax()) {
            return view('students.student_table', compact('students'))->render();
        }
            return view('students.index', compact('students'));
    }


    // Store a newly created student
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age'  => 'required|integer|min:1|max:100',
        ]);

        Student::create([
            'name' => $request->name,
            'age'  => $request->age,
        ]);

        return redirect()->route('index')->with('success', 'Student added successfully!');
    }

    public function show($id) {}
    public function edit($id) {}
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}
//sabah ajlouni #20230130