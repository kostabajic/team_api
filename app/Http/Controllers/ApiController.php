<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    protected function userNotFound()
    {
        return response()->json([
            'error' => [
                'message' => 'User not found',
            ],
        ], 404);
    }

    protected function teamNotFound()
    {
        return response()->json([
            'error' => [
                'message' => 'Team not found',
            ],
        ], 404);
    }
}
