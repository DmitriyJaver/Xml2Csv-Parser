<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        <!-- Styles -->

    </head>
    <body>

        <div class="container margin-top">
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            {{__('Parse XML from ') . $url}}
                        </div>
                        <div class="card-body">
                            <form action="/get-xml" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="urlInput" class="form-control-file">{{__('Link')}}</label>
                                    <input type="text" class="form-control-file" id="urlInput" name="source_url" value="{{$url}}">
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

    <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
