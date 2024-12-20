<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Services\StoreUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Log;

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

    public function handleGoogleFormWebhook(Request $request)
    {
        Log::info('Raw webhook payload:', [
            'all' => $request->all(),
            'name' => $request->name,
            'email' => $request->email,
            'nid' => $request->nid,
            'vaccine_center' => $request->vaccine_center,
        ]);

        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required',
                'nid' => 'required',
                'vaccine_center' => 'required',
                'phone' => '',
            ]);

            Log::info('Validation passed:', $validated);

            $newUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nid' => $request->nid,
                'vaccine_center_id' => $request->vaccine_center,
            ]);

            Log::info('New user created:', $newUser->toArray());

            if (! empty($newUser) && ! is_null($newUser)) {
                return response()->json([
                    'validatedData' => $newUser,
                    'msg' => 'success',
                    'received' => $request->all(),
                ], 200);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation errors:', $e->errors());

            return response()->json([
                'msg' => 'error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Validation errors:', ['error' => $e->getMessage()]);

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage(),
            ], 500);
        }
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
