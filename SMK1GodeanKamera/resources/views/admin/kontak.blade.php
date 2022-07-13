@extends('layouts.AdminMain')
@section('title','Kontak')

@section('container')
  <div class="container">
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="row my-5">
      <div class="col-lg-12 d-flex justify-content-center">
        <div class="card shadow" style="width: 50rem;">
          <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #3b3663;">
            <h3 class="text-light"><i class="fa-solid fa-address-book mr-2"></i>Kontak</h3>
          </div>
          <div class="card-body">
          <form method="POST" action="{{url(route('admin.kontak'))}}">
              @csrf
                        <div class="row mb-3">
                            <label for="alamat" class="col-md-4 col-form-label text-md-end">{{ __('Alamat') }}</label>

                            <div class="col-md-6">
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" cols="30" rows="3" placeholder="Alamat Lengkap" required="required">{{ old('alamat', $kontak->alamat) }}</textarea>
                                @error('alamat')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="wa_link" class="col-md-4 col-form-label text-md-end">{{ __('WhatApps Link') }}</label>
                            
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('wa_link') is-invalid @enderror" name="wa_link" value="{{ old('wa_link', $kontak->wa_link) }}" autocomplete="wa_link" placeholder="https://wa.me/6281234567890" autofocus>
                                    
                                    @error('wa_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        
                        
                            
                            <div class="row mb-3">
                                        <label for="jam_buka" class="col-md-4 col-form-label text-md-end">{{ __('Jam buka') }}</label>
                                        <div class="col-md-6">
                                            <textarea  name="jam_buka" class="form-control @error('jam_buka') is-invalid @enderror" cols="30" rows="3" placeholder="Jam Buka" >{{ old('jam_buka', $kontak->jam_buka) }}</textarea>                                            
                                        </div>
                            </div>

                            <div class="row mb-3">
                                        <label for="keterangan" class="col-md-4 col-form-label text-md-end">{{ __('Keterangan') }}</label>
            
                                        <div class="col-md-6">
                                            <textarea  name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" cols="30" rows="3" placeholder="Keterangan" >{{ old('keterangan', $kontak->keterangan) }}</textarea>
                                        </div>
                                </div>

                            <div class="row mb-3">
                                <label for="no_tlp" class="col-md-4 col-form-label text-md-end">{{ __('Nomer telephone (WhatApps)') }}</label>
                                <div class="col-md-6">
                                    <input type="tel" class="form-control @error('no_tlp') is-invalid @enderror" name="no_tlp" value="{{ old('no_tlp', $kontak->no_tlp) }}" pattern="[+][0-9]{14})" autocomplete="no_tlp" maxlength="14">
                                    
                                    @error('no_tlp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                </div>
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
