<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Grade;

class GradesController extends Controller {
    public function index() {
        $grades = Grade::all()->groupBy('term');
        
        $termData = [];
        $totalCreditHours = 0;
        $totalGradePoints = 0;
        
        foreach ($grades as $term => $termGrades) {
            $totalCH = $termGrades->sum('credit_hours');
            $totalGP = $termGrades->sum(fn($g) => $g->credit_hours * $g->grade_point);
            $gpa = $totalCH > 0 ? round($totalGP / $totalCH, 2) : 0;
            
            $termData[$term] = ['grades' => $termGrades, 'totalCH' => $totalCH, 'gpa' => $gpa];
            $totalCreditHours += $totalCH;
            $totalGradePoints += $totalGP;
        }
        
        $cgpa = $totalCreditHours > 0 ? round($totalGradePoints / $totalCreditHours, 2) : 0;
        
        return view('grades.index', compact('termData', 'totalCreditHours', 'cgpa'));
    }

    public function create() {
        return view('grades.create');
    }

    public function store(Request $request) {
        $request->validate([
            'course_name' => 'required',
            'course_code' => 'required',
            'credit_hours' => 'required|integer',
            'letter_grade' => 'required',
            'grade_point' => 'required|numeric',
            'term' => 'required',
        ]);

        Grade::create($request->all());
        return redirect()->route('grades.index');
    }

    public function edit(Grade $grade) {
        return view('grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade) {
        $request->validate([
            'course_name' => 'required',
            'course_code' => 'required',
            'credit_hours' => 'required|integer',
            'letter_grade' => 'required',
            'grade_point' => 'required|numeric',
            'term' => 'required',
        ]);

        $grade->update($request->all());
        return redirect()->route('grades.index');
    }

    public function destroy(Grade $grade) {
        $grade->delete();
        return redirect()->route('grades.index');
    }
}
