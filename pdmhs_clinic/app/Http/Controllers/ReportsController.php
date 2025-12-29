<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalVisit;
use App\Models\Student;
use App\Models\Diagnosis;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        // Default date range (last 30 days)
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $gradeLevel = $request->get('grade_level', 'all');

        // Build query with date filters
        $query = MedicalVisit::whereBetween(DB::raw('DATE(visit_datetime)'), [$startDate, $endDate]);
        
        if ($gradeLevel !== 'all') {
            $query->whereHas('student', function($q) use ($gradeLevel) {
                $q->where('grade_level', $gradeLevel);
            });
        }

        // Get statistics
        $totalVisits = $query->count();
        
        $chronicStudents = Student::whereHas('medicalVisits', function($q) use ($startDate, $endDate) {
            $q->whereBetween(DB::raw('DATE(visit_datetime)'), [$startDate, $endDate]);
        }, '>=', 3)->count();

        $emergencyCases = $query->where('visit_type', 'Emergency')->count();
        
        $hospitalReferrals = $query->where('status', 'Referred')->count();

        // Cases by illness (top 10) - using chief_complaint as proxy for diagnosis
        $casesByIllness = $query->whereNotNull('chief_complaint')
            ->where('chief_complaint', '!=', '')
            ->get()
            ->pluck('chief_complaint')
            ->countBy()
            ->sortDesc()
            ->take(10);

        // Cases by grade level
        $casesByGrade = $query->with('student')
            ->get()
            ->filter(function($visit) {
                return $visit->student && $visit->student->grade_level;
            })
            ->groupBy('student.grade_level')
            ->map(function($visits) {
                return $visits->count();
            })
            ->sortKeys();

        return view('reports.index', compact(
            'totalVisits',
            'chronicStudents', 
            'emergencyCases',
            'hospitalReferrals',
            'casesByIllness',
            'casesByGrade',
            'startDate',
            'endDate',
            'gradeLevel'
        ));
    }

    public function exportPdf(Request $request)
    {
        // Implementation for PDF export
        return response()->json(['message' => 'PDF export functionality coming soon']);
    }

    public function exportExcel(Request $request)
    {
        // Implementation for Excel export
        return response()->json(['message' => 'Excel export functionality coming soon']);
    }
}