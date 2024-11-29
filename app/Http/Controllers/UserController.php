<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Services\StoreUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vaccineCenters = DB::table('vaccine_centers')->select('name', 'id')->get();

        return view('users.create', compact('vaccineCenters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, StoreUser $storeUserService)
    {
        $validated = $request->validated();

        $response = $storeUserService->store($validated);

        if ($response) {
            return back()->with(['msg' => 'User Registered Successfully. You will soon be notified about vaccine date schedule.']);
        }

        return back()->with(['msg' => 'Sorry, Could not register user']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
