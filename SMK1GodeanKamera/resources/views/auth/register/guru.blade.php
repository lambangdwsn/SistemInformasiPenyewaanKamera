@extends('layouts.Main')
@section('title','Register Guru')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register Guru') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{url(route('register.as',['role' => 'guru']))}}">
                        @csrf
                        <input id="role" type="hidden" name="role" value="Guru">
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
                            <label for="NIP" class="col-md-4 col-form-label text-md-end">{{ __('NIP') }}</label>
                            <div class="col-md-6">
                                <input id="NIP" type="text" class="form-control @error('NIP') is-invalid @enderror" onkeypress="return isNumberKey(event)" name="NIP" value="{{ old('NIP') }}" autocomplete="NIP" maxlength="18">
                                @error('NIP')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="bidang_keahlian" class="col-md-4 col-form-label text-md-end">{{ __('Bidang Keahlian') }}</label>
                            <div class="col-md-6">
                                <input id="bidang_keahlian" type="text" class="form-control @error('bidang_keahlian') is-invalid @enderror" name="bidang_keahlian" value="{{ old('bidang_keahlian') }}" autocomplete="bidang_keahlian" maxlength="20">
                                @error('bidang_keahlian')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="jabatan" class="col-md-4 col-form-label text-md-end">{{ __('Jabatan') }}</label>
                            <div class="col-md-6">
                                <input id="jabatan" type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" value="{{ old('jabatan') }}" autocomplete="jabatan" maxlength="20">
                                @error('jabatan')
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
