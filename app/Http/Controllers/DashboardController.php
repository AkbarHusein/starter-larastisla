<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::where('role', 'user')->count();
        $admins = User::where('role', 'admin')->count();

        $data = [
            "title" => "App Name | Dashboard",
            "page" => "dashboard",
            "subPage" => "",
        ];

        $role = \Auth::user()->role;

        switch ($role) {
            case "admin":
                return view("admin.dashboard", compact('users', 'admins'), $data);
            default:
                return view("user.dashboard", compact('users', 'admins'), $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
