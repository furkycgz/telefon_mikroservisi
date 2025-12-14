<?php

namespace App\Services;

class PhoneValidator
{
    public static function validate(string $number): array
    {
        // Format kontrolü (6 basamak + numeric)
        if (!preg_match('/^\d{6}$/', $number)) {
            return [
                'number' => $number,
                'rules' => [
                    'hasNonZeroDigit' => false,
                    'sumFirstEqualsLast' => false,
                    'sumOddEqualsEven' => false,
                ],
                'isValid' => false,
                'formatValid' => false,
            ];
        }

        $a = array_map('intval', str_split($number)); // a1..a6
        $hasNonZero = false;
        for ($i = 0; $i < 6; $i++) {
            if ($a[$i] !== 0) { $hasNonZero = true; break; }
        }

        $sumFirst = $a[0] + $a[1] + $a[2];
        $sumLast  = $a[3] + $a[4] + $a[5];
        $sumFirstEqualsLast = ($sumFirst === $sumLast);

        $sumOdd  = $a[0] + $a[2] + $a[4]; // 1,3,5
        $sumEven = $a[1] + $a[3] + $a[5]; // 2,4,6
        $sumOddEqualsEven = ($sumOdd === $sumEven);

        $isValid = $hasNonZero && $sumFirstEqualsLast && $sumOddEqualsEven;

        return [
            'number' => $number,
            'rules' => [
                'hasNonZeroDigit' => $hasNonZero,
                'sumFirstEqualsLast' => $sumFirstEqualsLast,
                'sumOddEqualsEven' => $sumOddEqualsEven,
            ],
            'isValid' => $isValid,
            'formatValid' => true,
        ];
    }

    // GET /api/phone/count için hızlı algoritma (1e6 brute force değil)
    public static function countValid(): int
    {
        $count = 0;

        // a1..a4 seç, a5 ve a6'yı denklemlerden çöz
        for ($a1 = 0; $a1 <= 9; $a1++) {
            for ($a2 = 0; $a2 <= 9; $a2++) {
                for ($a3 = 0; $a3 <= 9; $a3++) {
                    for ($a4 = 0; $a4 <= 9; $a4++) {

                        // Eq1: a1+a2+a3 = a4+a5+a6  =>  a5+a6 = (a1+a2+a3) - a4
                        $sum56 = ($a1 + $a2 + $a3) - $a4;

                        // Eq2: a1+a3+a5 = a2+a4+a6 => a5-a6 = -(a1 - a2 + a3 - a4)
                        $diff56 = -($a1 - $a2 + $a3 - $a4);

                        // a5 = (sum+diff)/2, a6 = (sum-diff)/2
                        $x = $sum56 + $diff56;
                        $y = $sum56 - $diff56;

                        if (($x % 2) !== 0 || ($y % 2) !== 0) continue;

                        $a5 = intdiv($x, 2);
                        $a6 = intdiv($y, 2);

                        if ($a5 < 0 || $a5 > 9 || $a6 < 0 || $a6 > 9) continue;

                        $count++;
                    }
                }
            }
        }

        // "000000" yasak (en az bir non-zero şartı)
        return $count - 1;
    }
}
