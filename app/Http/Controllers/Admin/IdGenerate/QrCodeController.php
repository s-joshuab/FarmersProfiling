<?php

namespace App\Http\Controllers\Admin\IdGenerate;

use App\Http\Controllers\Controller;
use App\Models\FarmersProfile;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function generate(FarmersProfile $id){
        $farmers = FarmersProfile::findOrFail($id);


        return view('admin.qrcode.index', compact('farmers'));
    }
}
