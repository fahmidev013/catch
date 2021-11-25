<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {

        $file = "https://s3-ap-southeast-2.amazonaws.com/catch-code-challenge/challenge-1-in.jsonl";

        $fileData=fopen($file,'r');
        while (($line = fgetcsv($fileData)) !== FALSE) {
            //$line is an array of the csv elements
            $s[] = $line;
          }
        fclose($fileData);
        echo "<pre>";
        var_dump($s);
        return view('welcome');
    }


    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        //fungsi eloquent untuk menambah data
        User::create($request->all());

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('users.index')
            ->with('success', 'User Berhasil Ditambahkan');
    }

    public function show($id)
    {
        //menampilkan detail data dengan menemukan/berdasarkan id user
        $user = User::find($id);
        return view('users.detail', compact('user'));
    }

    public function edit($id)
    {
        //menampilkan detail data dengan menemukan/berdasarkan id user untuk diedit
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        //melakukan validasi data
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        //fungsi eloquent untuk mengupdate data inputan kita
        User::find($id)->update($request->all());

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('users.index')
            ->with('success', 'User Berhasil Diupdate');
    }

    public function destroy($id)
    {
        //fungsi eloquent untuk menghapus data
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User Berhasil Dihapus');
    }
}
