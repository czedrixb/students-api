<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        if ($students->count() > 0) {
            return response()->json([
                'status' => 200,
                'students' => $students,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Records Found',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if ($student) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Student Created Successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong',
                ], 500);
            }
        }
    }

    public function show(string $id)
    {
        try {
            $student = Student::findOrFail($id);

            return response()->json([
                'status' => 200,
                'student' => $student,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Student Found!',
            ], 404);
        }
    }

    public function edit(string $id)
    {
        try {
            $student = Student::findOrFail($id);

            if ($student) {
                return response()->json([
                    'status' => 200,
                    'student' => $student,
                ], 200);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Student Found!',
            ], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            try {
                $student = Student::findOrFail($id);

                $student->update([
                    'name' => $request->name,
                    'course' => $request->course,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Student Updated Successfully',
                ], 200);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Such Student Found!',
                ], 404);
            }
        }
    }

    public function destroy(string $id)
    {
        try {
            $student = Student::findOrFail($id);

            $student->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Student Deleted Successfully',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Student Found!',
            ], 404);
        }
    }
}
