<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'regex:/^0[0-9]{9,10}$/'
            ],
            'date_of_birth' => [
                'required',
                'date',
                'before:today'
            ],
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại phải bắt đầu bằng 0 và gồm 10 hoặc 11 chữ số.',

            'date_of_birth.required' => 'Vui lòng nhập ngày sinh.',
            'date_of_birth.date' => 'Ngày sinh không hợp lệ.',
            'date_of_birth.before' => 'Ngày sinh phải trước ngày hôm nay.',
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->date_of_birth = $request->date_of_birth;
        $user->save();

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
}