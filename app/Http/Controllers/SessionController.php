<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class SessionController extends Controller
{
    function index() {
        return view ('sesi/index');

    }
    function viewlogin(){
        return view('sesi.index');
    }
    function login (Request $request)
    {

       session()->flash('email', $request->email);
        $request->validate ([

    'email'=>'required',
    'password'=>'required'
   ],[
    'email.required'=> 'Email wajib di isi',
    'password.required'=> 'password wajib di isi',

   ]);

   $infologin =[
    'email'=>$request->email,
    'password'=>$request->password
   ];


  if (Auth::attempt($infologin)) {

    // kalau otentikasi sukses
    return redirect('siswa')->with('sukses', Auth::user()->name.'Berhasil login');

   }else {
   return redirect('sesi')->withErrors('Username dan password yang di masukkan tidak valid');
   }

    }
    function logout()
    {
        Auth::logout();
        return redirect('sesi')->with('logout berhasil');
    }

    function register(){
        return view('sesi/register');
    }
    function create(Request $request)
    {

    Session()->flash('name', $request->name);
    session()->flash('email', $request->email);
    $request->validate([
        'name'=> 'required',
        'email'=> 'required|email|unique:users',
        'password'=> 'required|min:6'
    ],[
        'name.required'=> 'Nama wajib diisi',
        'email.required'=> 'Email wajib diisi',
        'email.email' =>'Email sudah pernah digunakan,silahkan pilih email yang lain',
        'password.redired'=> 'password wajib diisi',
        'password.min' => 'Minimum password yang diizinkan adalah 6 karakter'
    ]);

    $data =[
      'name'=> $request->name,
      'email' => $request->email,
      'password' =>  Hash::make($request->password)
    ];
    User::create($data);

    $infologin =[
    'email'=>$request->email,
    'password'=>$request->password
   ];


  if (Auth::attempt($infologin)) {

    // kalau otentikasi sukses
    return redirect('/login');

   }else {
   return redirect('sesi')->withErrors('Username dan password yang di masukkan tidak valid');
   }
    }

}
