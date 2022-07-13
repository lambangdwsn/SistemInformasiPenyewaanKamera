@extends('layouts.Main')
@section('title','Berita Show')

@section('content')
<div class="container">
    <div class="py-3 px-2 card" style="border: solid; border-width: thin;">
        <div class="card-body">
            <h1 class="text-center card-title">{{$berita->judul}}</h1>
            
            <div class="d-flex justify-content-center">
            <img src="../storage/images/{{$berita->image}}" class="img-fluid p-2" width="500" alt="Gambar Berita">
            </div>

            <p class="my-3 mx-5" style="1.5rem">
            {!!str_ireplace(array("\r","\n",'\r','\n'),'<br>', $berita->isi)!!}
            </p>
        </div>
    </div>

</div>
@endsection
