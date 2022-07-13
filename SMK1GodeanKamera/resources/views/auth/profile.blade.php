@extends('layouts.Main')
@section('title','Profile')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{route('profile.update', ['uuid' => $user->id])}}">
                        @csrf
                        <input id="id" type="hidden" name="id" value="{{ $user->id }}">
                        <input id="role" type="hidden" name="role" value="{{$user->role}}">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nama') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label  class="col-md-4 col-form-label text-md-end">{{ __('Jenis Kelamin') }}</label>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="kelamin" value="laki-laki" @if(old('kelamin', $user->jenis_kelamin) == 'laki-laki') checked @endif required="required">{{__('Laki-laki')}}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="kelamin" value="perempuan" @if(old('kelamin', $user->jenis_kelamin) == 'perempuan') checked @endif>{{__('Perempuan')}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="alamat" class="col-md-4 col-form-label text-md-end">{{ __('Alamat') }}</label>

                            <div class="col-md-6">
                                <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" cols="30" rows="3" placeholder="Alamat Lengkap" required="required">{{ old('alamat', $user->alamat) }}</textarea>
                                @error('alamat')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if($user->role == 'Siswa')
                        <div class="row mb-3">
                            <label for="NIS" class="col-md-4 col-form-label text-md-end">{{ __('NIS') }}</label>

                            <div class="col-md-6">
                                <input id="NIS" type="text" class="form-control @error('NIS') is-invalid @enderror" onkeypress="return isNumberKey(event)" name="NIS" value="{{ old('NIS', $user->NIS)}}" required autocomplete="NIS" maxlength="5">
                                @error('NIS')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if($user->role == 'Alumni' || $user->role == 'Umum')
                        <div class="row mb-3">
                            <label for="NIK" class="col-md-4 col-form-label text-md-end">{{ __('NIK (opsional)') }}</label>

                            <div class="col-md-6">
                                <input id="NIK" type="text" class="form-control @error('NIK') is-invalid @enderror" onkeypress="return isNumberKey(event)" name="NIK" value="{{ old('NIK', $user->NIK) }}" autocomplete="NIK" maxlength="16">
                                @error('NIK')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if($user->role == 'Siswa' || $user->role == 'Alumni')
                        <div class="row mb-3">
                            <label for="program" class="col-md-4 col-form-label text-md-end">{{ __('Program Keahlian') }}</label>

                            <div class="col-md-6">
                            <select name="program" id="program" class="form-control">
                                @foreach($program as $option)
                                <option value="{{$option->id}}" {{ (old("program", $user->id_program_keahlian) == $option->id ? "selected":"") }}>{{$option->nama_program}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        @endif

                        @if($user->role == 'Alumni')
                        <div class="row mb-3">
                            <label for="tahun_lulus" class="col-md-4 col-form-label text-md-end">{{ __('Tahun Lulus') }}</label>

                            <div class="col-md-6">
                                <input id="tahun_lulus" type="text" class="form-control @error('tahun_lulus') is-invalid @enderror" onkeypress="return isNumberKey(event)" name="tahun_lulus" value="{{ old('tahun_lulus', $user->tahun_lulus) }}" required autocomplete="tahun_lulus" maxlength="4">

                                @error('tahun_lulus')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if($user->role == 'Siswa')
                        <div class="row mb-3">
                            <label for="Kelas" class="col-md-4 col-form-label text-md-end">{{ __('Kelas') }}</label>

                            <div class="col-md-6">
                            <select name="Kelas" id="Kelas" class="form-control">
                                <option value="X"  {{ (old("Kelas", $user->Kelas) == "X" ? "selected":"") }}>X</option>
                                <option value="XI" {{ (old("Kelas", $user->Kelas) == "XI" ? "selected":"") }}>XI</option>
                                <option value="XII" {{ (old("Kelas", $user->Kelas) == "XII" ? "selected":"") }}>XII</option>
                            </select>
                            </div>
                        </div>
                        @endif

                        @if($user->role == 'Guru')
                        <div class="row mb-3">
                            <label for="NIP" class="col-md-4 col-form-label text-md-end">{{ __('NIP') }}</label>

                            <div class="col-md-6">
                                <input id="NIP" type="text" class="form-control @error('NIP') is-invalid @enderror" onkeypress="return isNumberKey(event)" name="NIP" value="{{ old('NIP', $user->NIP) }}" autocomplete="NIP" maxlength="16">
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
                                <input id="bidang_keahlian" type="text" class="form-control @error('bidang_keahlian') is-invalid @enderror" name="bidang_keahlian" value="{{ old('bidang_keahlian', $user->bidang_keahlian) }}" autocomplete="bidang_keahlian" maxlength="20">
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
                                <input id="jabatan" type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}" autocomplete="jabatan" maxlength="20">
                                @error('jabatan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <div class="row mb-3">
                            <label for="no_tlp" class="col-md-4 col-form-label text-md-end">{{ __('Nomer telephone (WhatApps)') }}</label>

                            <div class="col-md-6">
                                <input id="no_tlp" type="tel" class="form-control @error('no_tlp') is-invalid @enderror" name="no_tlp" value="{{ old('no_tlp', $user->no_tlp) }}" pattern="(08[0-9]{10}|[+][0-9]{13})" required autocomplete="no_tlp" maxlength="14">

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
                                    {{ __('Simpan') }}
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
