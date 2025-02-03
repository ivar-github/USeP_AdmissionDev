<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\ScheduleApplicants;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;
use Illuminate\Validation\Rule;
use Exception;

class ScheduleApplicantController extends Controller
{
    public function index()
    {
        $query = ScheduleApplicants::select('appNo', 'testScheduleCode', 'testCenterID', 'testDateID', 'testTimeID', 'testSessionID', 'testRoomID', 'termID')
                ->limit(100)
                ->orderBy('appNo', 'desc');
        return view('Schedules.Applicants.Index', compact('applicants'));
        // return view('Schedules.Applicants.Search', compact('applicants', 'search'));
    }


    public function create()
    {
       // return view('Employees.Create');
    }


    public function show(Employee $employee)
    {
        return view('Employees.Show', compact('employee'));
    }


    public function edit(Employee $employee)
    {
        return view('Employees.Edit', compact('employee'));
    }


    // public function update(Request $request, Employee $employee)
    // {
    //     $request->validate([
    //         'smartcardid' => 'required|unique:HR_Employees,SmartCardID,' . $employee->EmployeeID . ',EmployeeID',
    //     ]);

    //     $employee->update([
    //         'SmartCardID' => $request->smartcardid,
    //     ]);

    //     return redirect()->route('employees.show', $employee->EmployeeID)
    //                      ->with('success', 'SmartCard ID is Updated Successfully.');
    // }

    public function update(Request $request, $employeeID)
    {
        $employee = Employee::on('sqlsrv2')->where('EmployeeID', $employeeID)->firstOrFail();

        $request->validate([
            'smartcardid' => [
                'required',
                Rule::unique('sqlsrv2.HR_Employees', 'SmartCardID')->ignore($employee->EmployeeID, 'EmployeeID'),
            ],
        ]);

        // $employee->setConnection('sqlsrv2');

        $employee->SmartCardID = $request->input('smartcardid');
        $employee->save();

        return redirect()->route('employees.show', $employee->EmployeeID)
                         ->with('success', 'SmartCard ID is Updated Successfully.');
    }


    public function search(Request $request)
    {

        $search = $request->input('rfid');

        try {
                $query = ScheduleApplicants::select('appNo', 'testScheduleCode', 'testCenterID', 'testDateID', 'testTimeID', 'testSessionID', 'testRoomID', 'termID')
                ->limit(100)
                ->orderBy('appNo', 'desc');

                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('appNo', 'LIKE', '%' . $search . '%')
                        ->orWhere('testCenterID', 'LIKE', '%' . $search . '%');
                    });
                }

                $applicants = $query->get();

                foreach ($applicants as $applicant) {
                    // if ($employee->Photo) {
                    //     $employee->Photo_base64 = 'data:image/png;base64,' . base64_encode($employee->Photo);
                    // } else {
                    //     $employee->Photo_base64 = null;
                    // }
                    $applicant->Photo_base64 = null;
                }

                return view('Schedules.Applicants.Search', compact('applicants', 'search'));

            } catch (Exception $e) {
                return redirect()->route('Schedules.Applicants.Search')
                        ->with('notfound', 'Applicant not found!!');
            }
    }

    public function table(Request $request)
    {
        $employees = Employee::select('EmployeeID', 'Prefix', 'LastName', 'FirstName', 'MiddleName', 'Email', 'Photo', 'SmartCardID')
            // ->where('StudentNo', 'LIKE', '%%')
            // ->orderBy('EmployeeID', 'desc');
            ->where('EmployeeID', 'LIKE', '%202%')
            ->orderBy('EmployeeID', 'desc')
            // ->limit(200)
            ->get();

        if ($request->has('search')) {
            $search = $request->input('search');
            $employees->where(function($q) use ($search) {
                $q->where('EmployeeID', 'like', "%$search%")
                  ->orWhere('LastName', 'like', "%$search%")
                  ->orWhere('FirstName', 'like', "%$search%")
                  ->orWhere('Email', 'like', "%$search%");
            });
        }

        // $employees = $query->limit(200)->get();

        foreach ($employees as $employee) {
            if ($employee->Photo) {
                $employee->Photo_base64 = 'data:image/png;base64,' . base64_encode($employee->Photo);
            } else {
                $employee->Photo_base64 = null;
            }
        }

        return view('Employees.Table', compact('employees'));
    }
}
