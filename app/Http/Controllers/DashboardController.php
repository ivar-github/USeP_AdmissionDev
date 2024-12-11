<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function getData()
    {
        // Fetch data for students with and without RFID
        // $data = [
        //     // 'withRfid' => User::whereNotNull('id')->count(),
        //     // 'withoutRfid' => User::whereNull('id')->count(),
        //     'withRfid' => Student::whereNotNull('Gender')->count(),
        //     'withoutRfid' => Student::whereNull('Gender')->count(),
        // ];

        $results = DB::connection('sqlsrv2')
        ->table('ES_Students')
        ->select(
            'TermID',
            DB::raw("SUM(CASE WHEN Gender = 'F' AND SmartCardID != '' THEN 1 ELSE 0 END) as StudentFemale"),
            DB::raw("SUM(CASE WHEN Gender = 'M' AND SmartCardID != '' THEN 1 ELSE 0 END) as StudentMale"),
            DB::raw("SUM(CASE WHEN SmartCardID = '' THEN 1 ELSE 0 END) as StudentsWoutSmartCard")
        )
        ->groupBy('TermID')
        ->orderBy('TermID', 'desc')
        ->take(10)
        ->get();

        $data = [];
        foreach ($results as $item) {
            $data[] = [
                'TermID' => $item->TermID,
                'StudentFemale' => $item->StudentFemale,
                'StudentMale' => $item->StudentMale,
                'StudentsWoutSmartCard' => $item->StudentsWoutSmartCard,
            ];
        }
        return response()->json($data);
    }


    public function getStudentGender()
    {
        $data = [
            'StudentFemaleCurrent' => Student::where('TermID', 0)
                ->where('Gender', 'F')
                ->count(),
            'StudentMaleCurrent' => Student::where('TermID', 0)
                ->where('Gender', 'M')
                ->count(),
        ];

        return response()->json($data);
    }

    public function getEmployeeGender()
    {
        $data = [
            'EmployeeFemaleCurrent' => Employee::where('Gender', 'F')
                ->count(),
            'EmployeeMaleCurrent' => Employee::where('Gender', 'M')
                ->count(),
        ];

        return response()->json($data);
    }
}




?>
