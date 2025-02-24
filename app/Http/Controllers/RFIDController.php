<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Term;
use Illuminate\Support\Facades\DB;


class RFIDController extends Controller
{
    public function getData()
    {
        try {

            $results = DB::connection('sqlsrv2')
            ->table('ES_Students as students')
            ->select(
                'students.TermID',
                'terms.AcademicYear',
                'terms.SchoolTerm',
                DB::raw("SUM(CASE WHEN students.Gender = 'F' AND students.SmartCardID != '' THEN 1 ELSE 0 END) as StudentFemale"),
                DB::raw("SUM(CASE WHEN students.Gender = 'M' AND students.SmartCardID != '' THEN 1 ELSE 0 END) as StudentMale"),
                DB::raw("SUM(CASE WHEN students.SmartCardID = '' THEN 1 ELSE 0 END) as StudentsWoutSmartCard")
            )
            ->join('ES_AYTerm as terms', 'terms.TermID', '=', 'students.TermID')
            ->groupBy('students.TermID', 'terms.AcademicYear', 'terms.SchoolTerm')
            ->orderBy('students.TermID', 'desc')
            ->take(10)
            ->get();

            $data = [];
            foreach ($results as $item) {
                $data[] = [
                    'TermID' => $item->TermID,
                    'AYear' => $item->AcademicYear,
                    'STerm' => substr($item->SchoolTerm, 0, 3),
                    'StudentFemale' => $item->StudentFemale,
                    'StudentMale' => $item->StudentMale,
                    'StudentsWoutSmartCard' => $item->StudentsWoutSmartCard,
                ];
            }

            return response()->json($data);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function getStudentGender()
    {
        try {
           
            $term = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
                ->where('IsCurrentTerm', 1)
                ->orderBy('TermID', 'desc')
                ->first();

            if (!$term) {
                return response()->json([
                    'error' => 'No current term found'
                ], 404);
            }

            $data = [
                'StudentFemaleCurrent' => Student::where('TermID', $term->TermID)
                    ->where('Gender', 'F')
                    ->count(),
                'StudentMaleCurrent' => Student::where('TermID', $term->TermID)
                    ->where('Gender', 'M')
                    ->count(),
                'CurrentTerm' => $term->AcademicYear . ' - ' . substr($term->SchoolTerm, 0, 3),
            ];

            return response()->json($data);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function getEmployeeGender()
    {
        try {
           
            $data = [
                'EmployeeFemaleCurrent' => Employee::where('Gender', 'F')
                    ->count(),
                'EmployeeMaleCurrent' => Employee::where('Gender', 'M')
                    ->count(),
            ];

            return response()->json($data);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}




?>
