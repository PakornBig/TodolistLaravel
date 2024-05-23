<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Task;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function Index(){
        $tasks = Task::paginate(10);
        // dd($tasks);
        return view('index',compact('tasks'));
    }
    public function Store(Request $request){
        try{
            $taskQuery=Task::create([
                'TASK'=>$request->txtTask,
                'CREATED_AT'=>Carbon::now(),
            ]);
            if ($taskQuery) {
                $alertData = [
                    'title' => 'บันทึกสำเร็จ',
                    'message' => 'ทำการบันทึกข้อมูลสำเร็จแล้ว',
                    'icon' => 'success',
                ];
            }
        }catch (\Throwable $th) {

            Log::error('[TaskController/Store] Error occurred: ' . $th->getMessage());
            
            $alertData = [
                'title' => 'เกิดข้อผิดพลาดในการบันทึก',
                'message' => 'ไม่สามารถบันทึกข้อมูลได้ กรุณาตรวจสอบข้อผิดพลาด',
                'icon' => 'error',
            ];
        }
        session()->flash('alert', $alertData);
        return redirect()->route('index');
    }
    public function Edit($id)
    {
        $task = Task::where('ID', $id)->first();
        $data = [
            'task' => $task,
        ];
        
        return response()->json($data);
    }

    public function Update(Request $request)
    {
        try{

            $taskQuery = Task::where('ID', $request->hdfEditId)->first();
            
            $taskQuery->TASK = $request->txtEditTask;
            $taskQuery->UPDATED_AT = Carbon::now();
            $rs_save = $taskQuery->save();

            if ($rs_save) {
                $alertData = [
                    'title' => 'บันทึกสำเร็จ',
                    'message' => 'ทำการแก้ไขข้อมูลสำเร็จแล้ว',
                    'icon' => 'success',
                ];
            }
        }catch (\Throwable $th) {

            Log::error('[TaskController/Update] Error occurred: ' . $th->getMessage());
        
            $alertData = [
                'title' => 'เกิดข้อผิดพลาดในการบันทึก',
                'message' => 'ไม่สามารถบันทึกข้อมูลได้ กรุณาตรวจสอบข้อผิดพลาด',
                'icon' => 'error',
            ];
        }

        session()->flash('alert', $alertData);
        return redirect()->route('index');
    }
    public function Delete($id){
        try{
            $taskQuery=Task::where('ID',$id)->delete();
            if ($taskQuery) {
                $alertData = [
                    'title' => 'ลบสำเร็จ',
                    'message' => 'ทำการลบข้อมูลสำเร็จแล้ว',
                    'icon' => 'success',
                ];
            }
        }catch (\Throwable $th) {

            DB::rollback();
            Log::error('[TaskController/Delete] Error occurred: ' . $th->getMessage());
            
            $alertData = [
                'title' => 'เกิดข้อผิดพลาดในการลบ',
                'message' => 'ไม่สามารถลบข้อมูลได้ กรุณาตรวจสอบข้อผิดพลาด',
                'icon' => 'error',
            ];
        }
        Task::where('ID',$id)->delete();

        session()->flash('alert', $alertData);
        return redirect()->route('index');
    }
}
