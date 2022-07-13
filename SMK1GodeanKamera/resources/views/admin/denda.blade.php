@extends('layouts.AdminMain')
@section('title','Denda')

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
            <h3 class="text-light"><i class="fa-regular fa-credit-card mr-2"></i>Denda Keterlambatan</h3>
          </div>
          <div class="card-body">
          <form method="POST" action="{{url(route('admin.denda'))}}">
              @csrf
                        
                        <div class="row mb-3">
                            <label for="denda_siswa" class="col-md-4 col-form-label text-md-end">{{ __('Denda Siswa') }}</label>
                            
                            <div class="col-md-6">
                                <input type="number" class="form-control @error('denda_siswa') is-invalid @enderror" name="denda_siswa" value="{{ old('denda_siswa', $denda->denda_siswa) }}" autocomplete="denda_siswa" placeholder="0" autofocus>
                                    
                                    @error('denda_siswa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        <div class="row mb-3">
                            <label for="denda_alumni" class="col-md-4 col-form-label text-md-end">{{ __('Denda Alumni') }}</label>
                            
                            <div class="col-md-6">
                                <input type="number" class="form-control @error('denda_alumni') is-invalid @enderror" name="denda_alumni" value="{{ old('denda_alumni', $denda->denda_alumni) }}" autocomplete="denda_alumni" placeholder="0" autofocus>
                                    
                                    @error('denda_alumni')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        <div class="row mb-3">
                            <label for="denda_guru" class="col-md-4 col-form-label text-md-end">{{ __('Denda Guru') }}</label>
                            
                            <div class="col-md-6">
                                <input type="number" class="form-control @error('denda_guru') is-invalid @enderror" name="denda_guru" value="{{ old('denda_guru', $denda->denda_guru) }}" autocomplete="denda_guru" placeholder="0" autofocus>
                                    
                                    @error('denda_guru')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        <div class="row mb-3">
                            <label for="denda_umum" class="col-md-4 col-form-label text-md-end">{{ __('Denda Umum') }}</label>
                            
                            <div class="col-md-6">
                                <input type="number" class="form-control @error('denda_umum') is-invalid @enderror" name="denda_umum" value="{{ old('denda_umum', $denda->denda_umum) }}" autocomplete="denda_umum" placeholder="0" autofocus>
                                    
                                    @error('denda_umum')
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
