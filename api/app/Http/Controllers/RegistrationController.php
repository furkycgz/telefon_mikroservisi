<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        // Temel doğrulama
        $data = $request->validate([
            'name'  => ['required','string','max:255'],
            'email' => ['required','email','max:255'],
            'phone' => ['required','digits:6'], // sadece 6 rakam
        ]);

        $phone = $data['phone'];
        $digits = array_map('intval', str_split($phone)); // [a1..a6]

        // KURAL 1: En az bir tane 0’dan farklı rakam
        $nonZeroExists = false;
        foreach ($digits as $d) {
            if ($d !== 0) { $nonZeroExists = true; break; }
        }
        if (!$nonZeroExists) {
            return response()->json([
                'status'  => 'rejected',
                'message' => 'Telefon numarası tamamen 0 olamaz.'
            ], 422);
        }

        // KURAL 2: İlk 3 toplam = son 3 toplam
        $sumFirst3 = $digits[0] + $digits[1] + $digits[2];
        $sumLast3  = $digits[3] + $digits[4] + $digits[5];
        if ($sumFirst3 !== $sumLast3) {
            return response()->json([
                'status'  => 'rejected',
                'message' => 'Telefon numarası geçersiz: ilk 3 basamak toplamı son 3 basamak toplamına eşit olmalı.'
            ], 422);
        }

        // KURAL 3: Tek sıradakiler = çift sıradakiler (1,3,5) = (2,4,6)
        $sumOdd  = $digits[0] + $digits[2] + $digits[4];
        $sumEven = $digits[1] + $digits[3] + $digits[5];
        if ($sumOdd !== $sumEven) {
            return response()->json([
                'status'  => 'rejected',
                'message' => 'Telefon numarası geçersiz: tek sıradaki basamakların toplamı çift sıradakilere eşit olmalı.'
            ], 422);
        }

        // Aynı kişi kaydını engelle (email+phone aynıysa)
        $exists = Registration::where('email', $data['email'])
            ->where('phone', $data['phone'])
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => 'rejected',
                'message' => 'Bu e-posta ve telefon ile daha önce kayıt oluşturulmuş.'
            ], 409);
        }

        Registration::create($data);

        return response()->json([
            'status'  => 'accepted',
            'message' => 'Kayıt başarılı.'
        ], 201);
    }
}
