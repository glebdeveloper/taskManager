<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    public function editor(Request $request){
        $validatedData = $request->validate(['id' => 'required|int']);
        $task = auth()->user()->createdTasks->where("id", $validatedData['id'])->first();
        return view('task_editor', compact('task'));
    }
    public function edit(Request $request){
        try
        {
        $validatedData = $request->validate([
            'id' => 'required|int',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'must_ended_at' => 'nullable|date',
            'priority_id' => 'required|integer',
            'status_id' => 'required|integer'
        ]);
        
        $task = auth()->user()->createdTasks->where("id", $validatedData['id'])->first();
        $task->update($validatedData);
        return redirect()->route('dashboard')->with('task_edit_success', 'Задача №'.$validatedData['id'].' обновлена успешно');
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function remove(Request $request){
        $validatedData = $request->validate(['id' => 'required|int']);
        $task = auth()->user()->createdTasks->where("id", $validatedData['id'])->first();
        $task->delete();
        return redirect()->route('dashboard')->with('task_edit_success', 'Задача №'.$validatedData['id'].' успешно удалена');
    }
    
    public function createTask(Request $request){
        try
        {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'prio' => 'required|integer',
            'description' => 'required|string',
            'status' => 'required|integer',
            'endDate' => 'required|date_format:Y-m-d\TH:i'
        ]);
        $task = new Task();
        $task->title = $validatedData['title'];
        $task->description = $validatedData['description'];
        $task->must_ended_at = $validatedData['endDate'];
        $task->priority_id = $validatedData['prio'];
        $task->status_id = $validatedData['status'];
        $task->creator_id = auth()->user()->id;
        $task->responsible_id = auth()->user()->id;
        $task->mode_id = 2;
        $task->save();
        return back()->with('success_added_myself', "Задача ".$task->title." для себя создана успешно");
        }
        
        catch (\Exception $e) {
            return back()->with('error_added_myself', 'Ошибка создания задачи: '.$e->getMessage());
        }
    }
    
    public function createSubordinateTask(Request $request){
        try
        {
        $validatedData = $request->validate([
            'subordinate_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'prio' => 'required|integer',
            'description' => 'required|string',
            'status' => 'required|integer',
            'endDate' => 'required|date_format:Y-m-d\TH:i'
        ]);
        $task = new Task();
        $task->title = $validatedData['title'];
        $task->description = $validatedData['description'];
        $task->must_ended_at = $validatedData['endDate'];
        $task->priority_id = $validatedData['prio'];
        $task->status_id = $validatedData['status'];
        $task->creator_id = auth()->user()->id;
        $task->responsible_id = $validatedData['subordinate_id'];
        $task->mode_id = 1;
        $task->save();
        return back()->with('success_added', "Задача ".$task->title." для подчинённого успешно создана");
        }
        catch (\Exception $e) {
            return back()->with('error_added', 'Ошибка создания задачи: '.$e->getMessage());
        }
    }
}
