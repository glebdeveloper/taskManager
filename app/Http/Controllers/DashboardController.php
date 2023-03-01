<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Subordination;
use App\Models\Task;
use App\Models\User;
class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $subordinates = $user->subordinates()->with('subordinate')->get();
        return view('dashboard', compact('subordinates'));
    }
}