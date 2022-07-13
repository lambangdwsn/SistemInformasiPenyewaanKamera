@extends('layouts.Main')
@section('title','register')

@section('content')
<div class="container">
<h1 class="text-center">{{__('Siapa Kamu di SMK Negeri 1 Godean?')}}</h1>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4 py-2">
            <div class="card h-100">
                <div class="card-body text-center">
                    <p><i class="fa-solid fa-graduation-cap fa-2xl" ></i></p>
                    <h4 class="card-title">Siswa</h4>
                    <p class="card-text">Siswa di SMK Negeri 1 Godean kelas <br>
                        X, XI, dan XII</p>
                    <a href="{{url(route('register.as',['role' => 'siswa']))}}" class="btn btn-primary btn-md"><i class="fa-solid fa-address-card"></i> Register</a>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-4 py-2">
            <div class="card h-100">
                <div class="card-body text-center">
                    <p><i class="fa-solid fa-graduation-cap fa-2xl" ></i></p>
                    <h4 class="card-title">Alumni</h4>
                    <p class="card-text">Alumni di SMK Negeri 1 Godean</p>
                    <a href="{{url(route('register.as',['role' => 'alumni']))}}" class="btn btn-primary btn-md"><i class="fa-solid fa-address-card"></i> Register</a>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-4 py-2">
            <div class="card h-100">
                <div class="card-body text-center">
                    <p><i class="fa-solid fa-person-chalkboard fa-2xl" ></i></p>
                    <h4 class="card-title">Guru</h4>
                    <p class="card-text">Guru atau Pengajar di SMK Negeri 1 Godean</p>
                    <a href="{{url(route('register.as',['role' => 'guru']))}}" class="btn btn-primary btn-md"><i class="fa-solid fa-address-card"></i> Register</a>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-4 py-2">
            <div class="card h-100">
                <div class="card-body text-center">
                    <p><i class="fa-solid fa-universal-access fa-2xl" ></i></p>
                    <h4 class="card-title">Umum</h4>
                    <p class="card-text">Pihak di luar SMK Negeri 1 Godean</p>
                    <a href="{{url(route('register.as',['role' => 'umum']))}}" class="btn btn-primary btn-md"><i class="fa-solid fa-address-card"></i> Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
