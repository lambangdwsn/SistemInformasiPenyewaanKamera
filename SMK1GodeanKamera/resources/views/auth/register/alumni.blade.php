@extends('layouts.Main')
@section('title','Register Alumni')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register Alumni') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{url(route('register.as',['role' => 'alumni']))}}">
                        @csrf
                        <input id="role" type="hidden" name="role" value="Alumni">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nama') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="input-group col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <div class="input-group-append">
                                <span id="showPassword" class="btn input-group-text form-control" onClick="eye('password','showPassword')"><i class="fa-solid fa-eye-slash"></i></span>
                                </div>
                                
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="input-group col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <div class="input-group-append">
                                <span id="showPasswordConfirm" class="btn input-group-text form-control" onClick="eye('password-confirm','showPasswordConfirm')"><i class="fa-solid fa-eye-slash"></i></span>
                                </div>
                            </div>
                        </div>

                        <script>
                            function eye(w,x) {
                            var y = document.getElementById(w);
                            var z = document.getElementById(x);
                            if (y.type === "password") {
                                z.innerHTML  = '<i class="fa-solid fa-eye"></i>';
                                y.type = "text";
                            } else {
                                z.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
                                y.type = "password";
                            }
                            }
                        </script>

                        <div class="row mb-3">
                            <label  class="col-md-4 col-form-label text-md-end">{{ __('Jenis Kelamin') }}</label>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="kelamin" value="laki-laki" @if(old('kelamin') == 'laki-laki') checked @endif required="required">{{__('Laki-laki')}}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="kelamin" value="perempuan" @if(old('kelamin') == 'perempuan') checked @endif>{{__('Perempuan')}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="alamat" class="col-md-4 col-form-label text-md-end">{{ __('Alamat') }}</label>

                            <div class="col-md-6">
                                <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" cols="30" rows="3" placeholder="Alamat Lengkap" required="required">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="NIK" class="col-md-4 col-form-label text-md-end">{{ __('NIK (opsional)') }}</label>

                            <div class="col-md-6">
                                <input id="NIK" type="text" class="form-control @error('NIK') is-invalid @enderror" onkeypress="return isNumberKey(event)" name="NIK" value="{{ old('NIK') }}" autocomplete="NIK" maxlength="16">
                                @error('NIK')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="program" class="col-md-4 col-form-label text-md-end">{{ __('Program Keahlian') }}</label>

                            <div class="col-md-6">
                            <select name="program" id="program" class="form-control">
                                @foreach($program as $option)
                                <option value="{{$option->id}}" {{ (old("program") == $option->id ? "selected":"") }}>{{$option->nama_program}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tahun_lulus" class="col-md-4 col-form-label text-md-end">{{ __('Tahun Lulus') }}</label>

                            <div class="col-md-6">
                                <input id="tahun_lulus" type="text" class="form-control @error('tahun_lulus') is-invalid @enderror" onkeypress="return isNumberKey(event)" name="tahun_lulus" value="{{ old('tahun_lulus') }}" required autocomplete="tahun_lulus" maxlength="4">

                                @error('tahun_lulus')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="no_tlp" class="col-md-4 col-form-label text-md-end">{{ __('Nomer telephone (WhatApps)') }}</label>

                            <div class="col-md-6">
                            <input id="no_tlp" type="tel" class="form-control @error('no_tlp') is-invalid @enderror" name="no_tlp" value="{{ old('no_tlp') }}" pattern="(08[0-9]{10}|[+][0-9]{13})" required autocomplete="no_tlp" maxlength="14">

                                @error('no_tlp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <script>
                            function isNumberKey(evt){
                                var charCode = (evt.which) ? evt.which : evt.keyCode;
                                if (charCode != 46 && charCode > 31 
                                && (charCode < 48 || charCode > 57))
                                return false;
                                return true;
                            }  
                        </script>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
