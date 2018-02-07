<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class StageController extends Controller {
  abstract public function confirm(int $tournamentId);
  abstract public function draw(Request $request, int $tournamentId);
  abstract public function game(Request $request, int $tournamentId);
  abstract public function results(int $tournamentId);
}
?>
