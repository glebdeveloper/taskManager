<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Subordination;
use Illuminate\Support\Facades\DB;
class SubordinateController extends Controller
{
    private function isSubordinateOfBoss($id) {
        $subordinateCount = DB::table('subordinations')
        ->where('subordinate_id', $id)
        ->where('boss_id', auth()->id())
        ->count();
        return $subordinateCount > 0;
    }
    public function editor(Request $request){
        $validatedData = $request->validate(['id' => 'required|int']);
        if(!self::isSubordinateOfBoss($validatedData['id']))
            return redirect()->route('dashboard')->with('subordinate_edit_success', 'Пользователь №'.$validatedData['id'].' не найден');
        $edit_user = User::find($validatedData['id']);
        return view('user_editor', compact('edit_user'));
    }
    public function edit(Request $request){
        try
        {
        $validatedData = $request->validate([
            'id' => 'required|int',
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);
        if(!self::isSubordinateOfBoss($validatedData['id']))
            return redirect()->route('dashboard')->with('subordinate_edit_success', 'Пользователь №'.$validatedData['id'].' не найден');
        $u = User::find($validatedData['id']);
        $u->update($validatedData);
        return redirect()->route('dashboard')->with('subordinate_edit_success', 'Ползьзователь №'.$validatedData['id'].' обновлён успешно');
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function remove(Request $request){
        $validatedData = $request->validate(['id' => 'required|int']);
        if(!self::isSubordinateOfBoss($validatedData['id']))
            return redirect()->route('dashboard')->with('subordinate_edit_success', 'Пользователь №'.$validatedData['id'].' не найден');
        $id = $validatedData['id'];
        $subordinations = Subordination::where('subordinate_id', $id)->get();
        foreach ($subordinations as $subordination) {
            $subordination->delete();
        }
        $user = User::find($id);
        $user->delete();
        return redirect()->route('dashboard')->with('subordinate_edit_success', 'Пользователь №'.$validatedData['id'].' успешно удалён');
    }
    
    public function store(Request $request)
    {
        
    try
    {
    $validatedData = $request->validate([
        'last_name' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'name' => 'required|string|max:255|unique:users',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);
    $subordinate = new User;
    $subordinate->last_name = $validatedData['last_name'];
    $subordinate->first_name = $validatedData['first_name'];
    $subordinate->middle_name = $validatedData['middle_name'];
    $subordinate->name = $validatedData['name'];
    $subordinate->email = $validatedData['email'];
    $subordinate->password = Hash::make($validatedData['password']);
    $subordinate->role_id = 2;
    $subordinate->save();
    $subordination = Subordination::updateOrCreate(
        ['subordinate_id' => $subordinate->id],
        ['boss_id' => auth()->user()->id]
    );
    return back()->with('success_created', "Your request was processed successfully.\nID: ".$subordinate->id."\nEmail: ".$validatedData['email']."\nPassword: ".$validatedData['password']);
    }
    
    catch (\Exception $e) {
        return back()->with('error_created', 'There was an error processing your request: '.$e->getMessage());
    }
    
    
    }
}
