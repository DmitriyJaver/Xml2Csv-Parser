@extends('layout.app')

@section('content')
    <div class="container margin-top">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        {{__('Download CSV:')}}
                    </div>
                    <div class="card-body">
                        <a class="btn btn-primary" href="{{ asset($fileName) }}" role="button">Download</a>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('welcome') }}" class="btn btn-secondary btn-sm active" role="button" aria-pressed="true">{{__('Go back')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
