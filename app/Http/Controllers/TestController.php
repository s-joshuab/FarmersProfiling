<?php

namespace App\Http\Controllers;

use App\Models\Barangays;
use App\Models\Municipalities;
use App\Models\Provinces;
use App\Models\Test;
use Illuminate\Http\Request;
use Faker\Provider\sv_SE\Municipality;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TestController extends Controller
{
    public function qrGen()
    {
        return QrCode::generate('Joshua Pogi');
    }

}
