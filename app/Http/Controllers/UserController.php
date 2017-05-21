<?php

namespace App\Http\Controllers;

use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showAccount()
    {
        $user = Auth::user();
        $today = new DateTime();
        $birthday = new DateTime($user->birthday);
        $age = $birthday->diff($today)->format('%y лет');
        $user->age = $age;
        return view('account', [
            'user' => $user,
        ]);
    }

    public function getStatistic()
    {
        $user = Auth::user();

        $dates = array();
        foreach ($user->games as $game) {
            if (!in_array($game->date, $dates)) {
                $dates[] = $game->date;
            }
        }

        $statistic = array();
        foreach ($dates as $date) {
            $s = new \stdClass();
            $s->date = $date;
            $s->min = $user->games()->where('date', $date)->min('result');
            $s->max = $user->games()->where('date', $date)->max('result');
            $s->avg = round($user->games()->where('date', $date)->avg('result'), 2);
            $statistic[] = $s;
        }

        return json_encode($statistic);
    }

    public function editAccount()
    {
        $user = Auth::user();
        return view('edit-account', [
            'user' => $user
        ]);
    }

    public function saveAccount(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->gender = $request->gender;
        $user->birthday = $request->birthday;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();

        return redirect('/account');
    }
}
