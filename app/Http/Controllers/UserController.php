<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\User;

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
        $tournaments = array();
        foreach ($user->games as $game) {
          // echo $game->date;
            if (!in_array($game->tournament_id, $tournaments)) {
                $dates[] = $game->date;
                $tournaments[] = $game->tournament_id;
            }
        }

        $statistic = array();
        foreach ($dates as $index => $date) {
            $s = new \stdClass();
            $s->date = $date;
            $s->min = $user->games()->where('tournament_id', $tournaments[$index])->min('result');
            $s->max = $user->games()->where('tournament_id', $tournaments[$index])->max('result');
            $s->avg = round($user->games()->where('tournament_id', $tournaments[$index])->avg('result'), 2);
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
            // $path = $request->file('avatar')->storeAs('avatars', $avatarLink);
            $path = $request->file('avatar')->move(public_path('img/avatars'), $avatarLink);
            // $url = Storage::url($avatarLink);
            $user->avatar = $avatarLink;
        }

        if ($request->new_password) {
            if (Hash::check($request->old_password, $user->getAuthPassword())) {
                if ($request->new_password == $request->password_confirm) {
                    $user->password = bcrypt($request->new_password);
                    echo "password changed!";
                }
            }
        }

        $user->save();

        return redirect('/account');
    }

    public function getPlayers() {
      $players = User::all();
      $aPlayers = array();

      foreach ($players as $player) {
        $resultsSum = 0;
        foreach ($player->results()->where('part', 'q')->get() as $result) {
          $tResult = $result;
          $tId = $result->tournament_id;

          $fResult = $player->results()->where('tournament_id', $tId)->where('part', 'rr')->first();
          if ($fResult != null) {
              $result = $fResult;
          }

          $resultsSum += $result->sum;
        }

        $player->resultsSum = $resultsSum;
        $aPlayers[] = $player;
      }

      usort($aPlayers, function ($pA, $pB) {
          return ($pA->resultsSum < $pB->resultsSum);
      });

      return view('players', ['players' => $aPlayers]);
    }

    public function getApplicationPlayers($tournamentId, $squadId) {
      $players = User::orderBy('surname', 'ASC')->get();
      return view('partial.players-apply', ['players' => $players,
                                            'tournamentId' => $tournamentId,
                                            'squadId' => $squadId]);
    }

    public function saveTempImage(Request $request)
    {
        $tempName = 'tempAvatar.' . $request->file('tempImg')->getClientOriginalExtension();;
        $request->file('tempImg')->storeAs('public', $tempName);
        return Storage::url($tempName);
    }
}
