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
use Exception;

class StudentController extends Controller
{

    public function index()
    {
        return view('RFIDs.Student.Index');
    }


    public function show(Student $student)
    {
            return view('RFIDs.Student.Show', compact('student'));
    }


    public function edit(Student $student)
    {
            return view('RFIDs.Student.Edit', compact('student'));
    }


    public function update(Request $request, $studentNo)
    {
        $student = Student::on('sqlsrv2')->where('StudentNo', $studentNo)->firstOrFail();

        $request->validate([
            'smartcardid' => [
                'required',
                Rule::unique('sqlsrv2.ES_Students', 'SmartCardID')->ignore($student->StudentNo, 'StudentNo'),
            ],
        ]);

        // $student->setConnection('sqlsrv2');

        $student->SmartCardID = $request->input('smartcardid');
        $student->save();

        return redirect()->route('students.show', $student->StudentNo)
                         ->with('success', 'SmartCard ID updated successfully.');
    }


    public function search(Request $request)
    {

        $search = $request->input('rfid');

        try {
                $query = Student::select('StudentNo', 'AppNo', 'TermID', 'LastName', 'FirstName', 'Middlename', 'Email', 'StudentPicture', 'SmartCardID', 'Fullname')
                ->limit(100)
                ->orderBy('LastName', 'desc');

                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('StudentNo', 'LIKE', '%' . $search . '%')
                        ->orWhere('FirstName', 'LIKE', '%' . $search . '%')
                        ->orWhere('Middlename', 'LIKE', '%' . $search . '%')
                        ->orWhere('LastName', 'LIKE', '%' . $search . '%');
                    });
                }

                $students = $query->get();

                foreach ($students as $student) {
                    if ($student->StudentPicture) {
                        $student->StudentPicture_base64 = 'data:image/png;base64,' . base64_encode($student->StudentPicture);
                    } else {
                        $student->StudentPicture_base64 = null;
                    }
                }

                return view('RFIDs.Student.search', compact('students', 'search'));

            } catch (Exception $e) {
                return redirect()->route('students.search')
                        ->with('notfound', 'Student not found!!');
            }
    }


    public function table()
    {
        $students = Student::select('StudentNo', 'AppNo', 'TermID', 'LastName', 'FirstName', 'Middlename', 'Email', 'StudentPicture', 'SmartCardID', 'Fullname')
        ->where('StudentNo', 'LIKE', '%%')
        ->orderBy('StudentNo', 'desc')
        // ->limit(200)
        ->get();

        foreach ($students as $student) {
            if ($student->StudentPicture) {
                $student->StudentPicture_base64 = 'data:image/png;base64,' . base64_encode($student->StudentPicture);
            } else {
                $student->StudentPicture_base64 = null;
            }
        }
        return view('RFIDs.Student.Table', compact('students'));
    }

}
