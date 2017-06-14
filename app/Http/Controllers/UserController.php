<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

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
        $user = Auth::user();
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->gender = $request->gender;
        $user->birthday = $request->birthday;
        $user->phone = $request->phone;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            $avatarLink = 'avatar_' . $user->id . '.' . $request->file('avatar')->getClientOriginalExtension();
            // $path = $request->file('avatar')->storeAs('public', $avatarLink);
            // $url = Storage::url($avatarLink);
            // $user->avatar = $url;
            $path = $request->file('avatar')->move(public_path('img/avatars'), $avatarLink);
            $user->avatar = $avatarLink;
        }

        if ($request->new_password) {
            if (Hash::check($request->old_password, $user->getAuthPassword())) {
                if ($request->new_password == $request->password_confirm) {
                    $user->password = bcrypt($request->new_password);
                }
            }
        }

        $user->save();

        return redirect('/account');
    }

    public function getContact($id) {
      $admin = User::find($id);
      return json_encode($admin);
    }

    public function getPlayers() {
      $players = User::all();
      return view('players', ['players' => $players]);
    }

    public function saveTempImage(Request $request)
    {
//        echo 'hello';
        $tempName = 'tempAvatar.' . $request->file('tempImg')->getClientOriginalExtension();;
        $request->file('tempImg')->storeAs('public', $tempName);
        return Storage::url($tempName);
    }
}
