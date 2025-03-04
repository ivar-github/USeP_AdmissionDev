<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;
use Illuminate\Validation\Rule;
use App\Models\Term;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Exception;
use Throwable;
use Jenssegers\Agent\Agent;

class RFIDEmployeeController extends Controller
{


    public function index()
    {
        try {
            
            $terms = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
            ->limit(10)
            ->orderBy('TermID', 'desc')
            ->get();

            return view('RFIDs.Employee.Index', compact('terms'));

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function create()
    {
       // 
    }


    public function show(Employee $employeesRFID)
    {
       //
    }


    public function edit(string $id): JsonResponse
    {
        try {
            
            $employee = Employee::select('EmployeeID',
                    'Prefix',
                    'LastName',
                    'FirstName',
                    'MiddleName',
                    'Email',
                    'Photo',
                    'SmartCardID'
                )
                ->where('EmployeeID', $id)
                ->first(); 

            if (!$employee) {
                return response()->json([
                    'error' => 'Employee not found'
                ], 404);
            }
            $employee->Photo = $employee->Photo ? base64_encode($employee->Photo) : null;

            return response()->json($employee);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request)
    {
        try {

            $employeeID = $request->input('employeeID');

            if ($employeeID == 0) {
                return response()->json([
                    'error' => 'Please select an employee',
                    'message' => 'Please select an employee before proceeding.',
                ], 400);
            }

            $employee = Employee::where('EmployeeID', $employeeID)->firstOrFail();

            $request->validate([
                'rfid' => [
                    'required',
                    Rule::unique('sqlsrv2.HR_Employees', 'SmartCardID')
                    ->ignore($employee->EmployeeID, 'EmployeeID'),
                ],
            ]);

            $employee->SmartCardID = $request->input('rfid');
            $employee->save();

            $status = 0;
            $desc = 'No changes were made';
            if ($employee->wasChanged()) {
                $status = 1;
                $desc = 'RFID Update Successful';
            }

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();
            
            ActionLogs::create([
                'type' => 'Update',
                'module' => 'RFID - Employee',
                'affectedID' => $employee->EmployeeID,
                'affectedItem' => $employee->LastName.', '.$employee->FirstName,
                'description' => $desc,
                'status' => $status,
                'userID' => Auth::user()->id,
                'userEmail' => Auth::user()->email,
                'hostName' => gethostname(),
                'platform' => $agentInfo,
            ]);

            return response()->json([
                'message' => $desc,
                'status' => 'success',
            ], 200);


        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
                'status' => 'error',
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Employee not found',
                'message' => 'The requested employee does not exist.',
            ], 404);
        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function search(Request $request)
    {

        // try {

        //     $terms = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
        //         ->limit(10)
        //         ->orderBy('TermID', 'desc')
        //         ->get();

        //     $search = $request->input('employee');

        //     $query = Employee::select('EmployeeID', 
        //         'Prefix', 
        //         'LastName', 
        //         'FirstName', 
        //         'MiddleName', 
        //         'Email', 
        //         'Photo', 
        //         'SmartCardID')
        //         ->limit(10)
        //         ->orderBy('EmployeeID', 'desc');

        //     if ($search) {
        //         $query->where(function($q) use ($search) {
        //             $q->where('EmployeeID', 'LIKE', '%' . $search . '%')
        //             ->orWhere('FirstName', 'LIKE', '%' . $search . '%')
        //             ->orWhere('MiddleName', 'LIKE', '%' . $search . '%')
        //             ->orWhere('LastName', 'LIKE', '%' . $search . '%');
        //         });
        //     }

        //     $employees = $query->get();

        //     foreach ($employees as $employee) {
        //         if ($employee->Photo) {
        //             $employee->Photo_base64 = 'data:image/png;base64,' . base64_encode($employee->Photo);
        //         } else {
        //             $employee->Photo_base64 = null;
        //         }
        //     }

        //     // return view('RFIDs.Employee.Search', compact('employees', 'search', 'terms'));
        //     return response()->json([
        //         'employees' => $employees,
        //         'terms' => $terms
        //     ]);

        // // } catch (Throwable $e) {
        // //     return redirect()->route('employeesRFIDs.search')
        // //         ->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        // } catch (Throwable $e) {
        //     return response()->json([
        //         'error' => 'An unexpected error occurred',
        //         'message' => $e->getMessage(),
        //     ], 500);
        // }
    }



    public function getData(Request $request)
    {

        try {

            $search = $request->input('employee');

            $query = Employee::select('EmployeeID', 
                'Prefix', 
                'LastName', 
                'FirstName', 
                'MiddleName', 
                'Email', 
                // 'Photo', 
                'SmartCardID')
                ->limit(10)
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
            
            return response()->json([
                'employees' => $employees
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function table(Request $request)
    {
        try {

            $employees = Employee::select('EmployeeID', 
                'Prefix', 
                'LastName', 
                'FirstName', 
                'MiddleName', 
                'Email', 
                'Photo', 
                'SmartCardID')
                ->where('EmployeeID', 'LIKE', '%202%')
                ->orderBy('EmployeeID', 'desc')
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

            foreach ($employees as $employee) {
                if ($employee->Photo) {
                    $employee->Photo_base64 = 'data:image/png;base64,' . base64_encode($employee->Photo);
                } else {
                    $employee->Photo_base64 = null;
                }
            }

            return view('RFIDs.Employee.Table', compact('employees'));

        } catch (Throwable $e) {
            return redirect()->route('employeesRFIDs.search')
                ->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

}
