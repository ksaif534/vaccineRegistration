<?php

namespace App\Services;

use App\Models\User;
use Hash;

class StoreUser
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(array $validated): bool
    {
        $newRegisteredUser = User::create([
            'vaccine_center_id' => $validated['vaccine_center'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone'],
            'nid' => $validated['nid'],
            'password' => Hash::make($validated['password']),
        ]);

        if (! empty($newRegisteredUser)) {
            return true;
        }

        return false;
    }
}
