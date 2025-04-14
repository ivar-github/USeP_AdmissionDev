<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Student;
use App\Models\StudentModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Term;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\ActionLogs;
use Exception;
use Throwable;
use Jenssegers\Agent\Agent;

class RFIDStudentController extends Controller
{

    public function index()
    {
        
        try {
            
            $terms = Term::select('TermID', 'AcademicYear', 'SchoolTerm')
            ->limit(10)
            ->orderBy('TermID', 'desc')
            ->get();

            return view('RFIDs.Student.Index', compact('terms'));

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function show(Student $student)
    {
        //
    }


    public function edit(string $id): JsonResponse
    {
        
        try {
        
            $student = Student::select('StudentNo', 
                    // 'AppNo', 
                    'TermID', 
                    'LastName', 
                    'FirstName', 
                    'Middlename', 
                    'Email', 
                    'StudentPicture', 
                    'SmartCardID', 
                    'Fullname'
                )
                ->where('StudentNo', $id)
                ->first(); 

            if (!$student) {
                return response()->json([
                    'error' => 'Student not found'
                ], 404);
            }
            $student->StudentPicture = $student->StudentPicture ? base64_encode($student->StudentPicture) : null;

            return response()->json($student);

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

            $studentID = $request->input('studentID');

            if ($studentID == 0) {
                return response()->json([
                    'error' => 'Please select a student',
                    'message' => 'Please select a student before proceeding.',
                ], 400);
            }

            $student = Student::where('StudentNo', $studentID)->firstOrFail();

            $request->validate([
                'rfid' => [
                    'required',
                    Rule::unique('sqlsrv2.ES_Students', 'SmartCardID')
                    ->ignore($student->StudentNo, 'StudentNo'),
                ],
            ]);

            $student->SmartCardID = $request->input('rfid');
            $student->save();

            $status = 0;
            $desc = 'No changes were made';
            if ($student->wasChanged()) {
                $status = 1;
                $desc = 'RFID Update Successful';
            }

            $agent = new Agent();
            $agentInfo = $agent->platform().', '. $agent->browser().', '. $agent->device();

            ActionLogs::create([
                'type' => 'Update',
                'module' => 'RFID - Student',
                'affectedID' => $student->StudentNo,
                'affectedItem' => $student->LastName.', '.$student->FirstName,
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
                'error' => 'Student not found',
                'message' => 'The requested Student does not exist.',
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
        //     $search = $request->input('rfid');
            
        //     $query = Student::select('StudentNo', 
        //         'AppNo', 
        //         'TermID', 
        //         'LastName', 
        //         'FirstName', 
        //         'Middlename', 
        //         'Email', 
        //         'StudentPicture', 
        //         'SmartCardID', 
        //         'Fullname'
        //     )
        //     ->limit(100)
        //     ->orderBy('LastName', 'desc');

        //     if ($search) {
        //         $query->where(function($q) use ($search) {
        //             $q->where('StudentNo', 'LIKE', '%' . $search . '%')
        //             ->orWhere('FirstName', 'LIKE', '%' . $search . '%')
        //             ->orWhere('Middlename', 'LIKE', '%' . $search . '%')
        //             ->orWhere('LastName', 'LIKE', '%' . $search . '%');
        //         });
        //     }

        //     $students = $query->get();

        //     foreach ($students as $student) {
        //         if ($student->StudentPicture) {
        //             $student->StudentPicture_base64 = 'data:image/png;base64,' . base64_encode($student->StudentPicture);
        //         } else {
        //             $student->StudentPicture_base64 = null;
        //         }
        //     }

        //     return view('RFIDs.Student.search', compact('students', 'search'));

        // } catch (Exception $e) {
        //     return redirect()->route('students.search')
        //             ->with('notfound', 'Student not found!!');
        // }
    }

    public function getData(Request $request)
    {

        try {

            $search = $request->input('student');
                
            $query = Student::select('StudentNo', 
            'AppNo', 
            'TermID', 
            'LastName', 
            'FirstName', 
            'Middlename', 
            'Email', 
            // 'StudentPicture', 
            'SmartCardID', 
            'Fullname')
            ->limit(10)
            ->orderBy('StudentNo', 'desc');

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('StudentNo', 'LIKE', '%' . $search . '%')
                    ->orWhere('FirstName', 'LIKE', '%' . $search . '%')
                    ->orWhere('Middlename', 'LIKE', '%' . $search . '%')
                    ->orWhere('LastName', 'LIKE', '%' . $search . '%');
                });
            }

            $students = $query->get();

            return response()->json([
                'students' => $students
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'An unexpected error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function table()
    {
        // try {

        //     $students = Student::select('StudentNo', 
        //         'AppNo', 
        //         'TermID', 
        //         'LastName', 
        //         'FirstName', 
        //         'Middlename', 
        //         'Email', 
        //         'StudentPicture', 
        //         'SmartCardID', 
        //         'Fullname')
        //     ->where('StudentNo', 'LIKE', '%%')
        //     ->orderBy('StudentNo', 'desc')
        //     ->get();

        //     foreach ($students as $student) {
        //         if ($student->StudentPicture) {
        //             $student->StudentPicture_base64 = 'data:image/png;base64,' . base64_encode($student->StudentPicture);
        //         } else {
        //             $student->StudentPicture_base64 = null;
        //         }
        //     }
        //     return view('RFIDs.Student.Table', compact('students'));

        // } catch (Throwable $e) {
        //     return redirect()->route('employeesRFIDs.search')
        //         ->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        // }
    }

}
