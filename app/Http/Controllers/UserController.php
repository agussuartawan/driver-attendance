<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getEmployee(Request $request)
    {
        $employees = User::with(['roles:id,name'])->role('driver');

        if ($request->search) {
            $employees->where('name', 'like', '%' . $request->search . '%');
        }

        $employees = $employees->orderBy('created_at', 'desc')->paginate(10)->through(function ($employee) {
            $employee->role = $employee->roles->first()->name . ' (' . ($employee->vehicle ?? 'Tidak ada info kendaraan') . ')';
            return $employee;
        });

        return view('dashboard.employee.index', compact('employees'));
    }

    public function employeeForm(User $employee)
    {
        if ($employee->id && $employee->roles->first()->name != 'driver') {
            abort(404);
        }

        return view('dashboard.employee.form', [
            'employee' => $employee->id ? $employee : null,
        ]);
    }

    public function storeEmployee(EmployeeFormRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make('password');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        $user = User::create($data);
        $user->assignRole('driver');
        return redirect()->route('employee')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function updateEmployee(EmployeeFormRequest $request, User $employee)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($employee->image) {
                Storage::delete($employee->image);
            }
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        $employee->update($data);
        return redirect()->route('employee')->with('success', 'Karyawan berhasil diubah');
    }
}
