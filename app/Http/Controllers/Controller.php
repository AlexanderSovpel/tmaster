<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function addSquadForm(Request $request)
    {
        return view('partial.squad-form', ['index' => $request->index]);
    }

    public function saveTempImage(Request $request)
    {
//        echo 'hello';
        $tempName = 'tempAvatar.' . $request->file('tempImg')->getClientOriginalExtension();;
        $request->file('tempImg')->storeAs('public', $tempName);
        return Storage::url($tempName);
    }
}
