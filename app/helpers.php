<?php

use App\Models\School;
use App\Models\StudentClassDetail;
use App\Models\Students;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Month;

function generateRandomString($length)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function sendResponse($success, $message, $data = null)
{
    return response()->json([
        'success' => $success,
        'message' => $message,
        'data' => $data,
    ]);
}
