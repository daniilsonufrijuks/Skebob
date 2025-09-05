<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RouletteController extends Controller
{
    public function spin()
    {
        $segments = [
            'Prize 1',
            'Prize 2',
            'Prize 3',
            'Try Again',
            'Lose',
            'Prize 4'
        ];

        $result = $segments[array_rand($segments)];

        return response()->json(['result' => $result]);
    }
}
