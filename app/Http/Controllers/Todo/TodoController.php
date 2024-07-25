<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $max_data = 5;

        if (request('search')){
            $data = Todo::where('task', 'like', '%'.request('search'). '%')->orderBy('task', 'asc')->paginate($max_data)->withQueryString();
        }
        else{
            $data = Todo::orderBy('task', 'asc')->paginate($max_data);        
        }
        return view('todo.app', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|min:3|max:25'
        ],
        [
            'task.required' => 'Silahkan isi task terlebih dahulu',
            'task.min' => 'Task harus memiliki minimal 3 karakter',
            'task.max' => 'Task harus memiliki maksimal 25 karakter'
        ]);

        // Menyiapkan data yang akan disimpan ke database
        $data = [
            'task' => $request->input('task')
        ];

        // Menyimpan data ke database dengan model Todo
        Todo::create($data);

        // Redirect ke halaman todo dengan pesan sukses
        return redirect()->route('todo')->with('success', 'Task berhasil ditambahkan');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'task' => 'required|min:3|max:25'
        ],
        [
            'task.required' => 'Silahkan isi task terlebih dahulu',
            'task.min' => 'Task harus memiliki minimal 3 karakter',
            'task.max' => 'Task harus memiliki maksimal 25 karakter'
        ]);

        // Menyiapkan data yang akan diupdate
        $data = [
            'task' => $request->input('task'),
            'is_done' => $request->input('is_done')
        ];

        // Melakukan update data ke database
        Todo::where('id', $id)->update($data);

        // Redirect ke halaman todo dengan pesan sukses
        return redirect()->route('todo')->with('success', 'Task berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // Menghapus data dari database
        Todo::destroy($id);
        // Redirect ke halaman todo dengan pesan sukses
        return redirect()->route('todo')->with('success', 'Task berhasil dihapus');
    }
}
