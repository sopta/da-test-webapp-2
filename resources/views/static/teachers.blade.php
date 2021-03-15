@extends('layouts.app')

@section('title', trans('pages.title.teachers') )

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h2>Návody pro pedagogy</h2>
                    <ul class="fa-ul">
                        <li><a href="https://google.com" target="_blank"><span class="fa-li" ><i class="fa fa-file-pdf"></i></span> Návod k použití systému pro pedagogy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
