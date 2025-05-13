<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQr extends Controller
{
    public function qrGen()
    {
        return QrCode::generate('umay');
    }
}
