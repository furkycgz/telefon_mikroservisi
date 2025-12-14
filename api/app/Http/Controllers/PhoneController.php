<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PhoneValidator;

class PhoneController extends Controller
{
    public function validateNumber(Request $request)
    {
        $data = $request->validate([
            'number' => ['required', 'string']
        ]);

        $result = PhoneValidator::validate($data['number']);

        if (!$result['formatValid']) {
            return response()->json([
                'message' => 'Hatalı format. number 6 basamaklı sayısal olmalı.',
                'detail' => $result
            ], 400);
        }

        // İstenen örnek JSON formatına yakın dönüş
        return response()->json([
            'number' => $result['number'],
            'rules' => $result['rules'],
            'isValid' => $result['isValid'],
        ]);
    }

    public function count()
    {
        return response()->json([
            'count' => PhoneValidator::countValid()
        ]);
    }
}
