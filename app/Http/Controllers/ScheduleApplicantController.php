<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Term;
use App\Models\ScheduleApplicants;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;
use Illuminate\Validation\Rule;
use Exception;

class ScheduleApplicantController extends Controller
{
    public function index()
    {

        $terms = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
            //->where('IsForAdmission', 1)
            ->limit(100)
            ->orderBy('TermID', 'desc')->get();

        return view('Schedules.Applicants.Index', compact('terms'));
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
        $terms = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
            //->where('IsForAdmission', 1)
            ->limit(10)
            ->orderBy('TermID', 'desc')->get();

        $search = $request->input('applicant');
        $termId = $request->input('termID');

        try {
            $query = ScheduleApplicants::from('CUSTOM_AdmissionApplicantTestSchedule as sa')
                ->select(
                    'sa.appNo',
                    'sa.testScheduleCode',
                    'sa.testCenterID',
                    'sa.testDateID',
                    'sa.testTimeID',
                    'sa.testSessionID',
                    'sa.testRoomID',
                    'sa.termID',
                    'reg.AppNo',
                    'reg.LastName',
                    'reg.FirstName',
                    'reg.MiddleName'
                )
                ->leftJoin('ES_Admission as reg', 'reg.AppNO', '=', 'sa.appNo')
                ->limit(100)
                ->orderBy('sa.appNo', 'desc');

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('sa.appNo', 'LIKE', '%' . $search . '%')
                    ->orWhere('sa.testCenterID', 'LIKE', '%' . $search . '%')
                    ->orWhere('reg.LastName', 'LIKE', '%' . $search . '%')
                    ->orWhere('reg.FirstName', 'LIKE', '%' . $search . '%')
                    ->orWhere('reg.MiddleName', 'LIKE', '%' . $search . '%');
                });
            }

            if ($termId) {
                $query->where('sa.termID', '=', $termId);
            }

            $applicants = $query->get();

            return view('Schedules.Applicants.Search', compact('applicants', 'search', 'terms'));

        } catch (Exception $e) {
            return redirect()->route('Schedules.Applicants.Search')
                ->with('notfound', 'Applicant not found!!');
        }
    }




}
