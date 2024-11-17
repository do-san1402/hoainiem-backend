<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ApiUserController extends Controller
{
    public function get($userId)
    {
        $user = User::with('reporter')->find($userId);

        if ($user) {
            $profileImageUrl = $user->profile_image ? asset('storage/' . $user->profile_image) : null;

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $user->id,
                    'full_name' => $user->full_name,
                    'email' => $user->email,
                    'contact_no' => optional($user->reporter)->mobile,
                    'sex' => optional($user->reporter)->sex,
                    'birth_date' => optional($user->reporter)->birth_date,
                    'address_one' => optional($user->reporter)->address_one,
                    'profile_image' => $profileImageUrl
                ]
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }
    }

    public function update(Request $request, $userId)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_no' => 'required|min:10',  
            'sex' => 'required|in:male,female,other',
            'birth_date' => 'required|date',
            'address_one' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::with('reporter')->find($userId);

        if ($user) {
            try {
                if (isset($validatedData['full_name'])) {
                    $user->full_name = $validatedData['full_name'];
                }
                if (isset($validatedData['email'])) {
                    $user->email = $validatedData['email'];
                }
                $user->save();

                if ($user->reporter) {
                    $user->reporter->update([
                        'mobile' => $validatedData['contact_no'] ?? $user->reporter->mobile,
                        'sex' => $validatedData['sex'] ?? $user->reporter->sex,
                        'birth_date' => $validatedData['birth_date'] ?? $user->reporter->birth_date,
                        'address_one' => $validatedData['address_one'] ?? $user->reporter->address_one,
                    ]);
                }

                if ($request->hasFile('profile_image')) {
                    $imagePath = $request->file('profile_image')->store('profile_images', 'public');
                    $user->profile_image = $imagePath;
                    $user->save();
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'User profile updated successfully.',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to update user profile.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.',
            ], 404);
        }
    }

}
