<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Exception;
use Throwable;

class EmployeeController extends Controller
{



    public function index()
    {
        return view('RFIDs.Employee.Index');
    }


    public function create()
    {
       // return view('RFIDs.Employees.Create');
    }


    public function show(Employee $employee)
    {
        return view('RFIDs.Employee.Show', compact('employee'));
    }


    public function edit(Employee $employee)
    {
        return view('RFIDs.Employee.Edit', compact('employee'));
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

        $status = 0;
        $desc = 'No changes were made';
        if ($employee->wasChanged()) {
            $status = 1;
            $desc = 'RFID Update Successful';
        }

        ActionLogs::create([
            'type' => 'Update',
            'userID' => Auth::user()->id,
            'userEmail' => Auth::user()->email,
            'module' => 'RFID - Employee',
            'affectedID' => $employee->EmployeeID,
            'affectedItem' => $employee->LastName.', '.$employee->FirstName,
            'description' => $desc,
            'status' => $status,
        ]);

        return redirect()->route('employees.show', $employee->EmployeeID)
                         ->with('success', $desc);
    }


    public function search(Request $request)
    {

        $search = $request->input('rfid');

        try {
                $query = Employee::select('EmployeeID', 'Prefix', 'LastName', 'FirstName', 'MiddleName', 'Email', 'Photo', 'SmartCardID')
                ->limit(100)
                ->orderBy('EmployeeID', 'desc');

                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('EmployeeID', 'LIKE', '%' . $search . '%')
                        ->orWhere('FirstName', 'LIKE', '%' . $search . '%')
                        ->orWhere('MiddleName', 'LIKE', '%' . $search . '%')
                        ->orWhere('LastName', 'LIKE', '%' . $search . '%');
                    });
                }

                $employees = $query->get();

                foreach ($employees as $employee) {
                    if ($employee->Photo) {
                        $employee->Photo_base64 = 'data:image/png;base64,' . base64_encode($employee->Photo);
                    } else {
                        $employee->Photo_base64 = null;
                    }
                }

                return view('RFIDs.Employee.Search', compact('employees', 'search'));

            } catch (Exception $e) {
                return redirect()->route('employees.search')
                        ->with('notfound', 'Employee not found!!');
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

        return view('RFIDs.Employee.Table', compact('employees'));
    }

}
