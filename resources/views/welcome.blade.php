@extends('layout.app')

@section('content')
    <div class="container margin-top">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        {{__('Parse XML to CSV from: ') . $url}}
                        @include('errors.error')
                    </div>
                    <div class="card-body">
                        <form action="/get-csv" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="urlInput" class="form-control-file">{{__('Link:')}}</label>
                                <input type="text" class="form-control-file" id="urlInput" name="source_url"
                                       value="{{$url}}">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{__('parse xml')}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()

