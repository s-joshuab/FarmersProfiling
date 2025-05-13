<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FarmersProfile;


class QRCodeController extends Controller
{
    public function showProfile($id)
    {
        // Retrieve the FarmersProfile associated with the QR code ID
        $farmersprofile = FarmersProfile::find($id);

        if (!$farmersprofile) {
            // Handle the case where the FarmersProfile is not found
            abort(404);
        }

        // Pass the data to the view
        return view('admin.farmers.view', compact('farmersprofile'));
    }
}
