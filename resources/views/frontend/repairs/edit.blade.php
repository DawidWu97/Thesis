@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.edit') }} {{ trans('cruds.repair.title_singular') }} - {{$repair->car->plates}}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("frontend.repairs.update", [$repair->id]) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="description">{{ trans('cruds.repair.fields.description') }}</label>
                                <textarea class="form-control ckeditor" name="description" id="description">{!! old('description', $repair->description) !!}</textarea>
                                @if($errors->has('description'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('description') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.repair.fields.description_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="calculated_finish">{{ trans('cruds.repair.fields.calculated_finish') }}</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input class="form-check-input ml-2" type="radio" name="radio" id="automatic" value="auto" checked>
                                        <label class="form-check-label ml-4" for="automatic">
                                            Automatycznie
                                        </label>
                                    </div>
                                    <div class="col-5">
                                        <input class="form-check-input" type="radio" name="radio" id="manual" value="manual">
                                        <input disabled class="form-control datetime" type="text" name="calculated_finish" id="calculated_finish" value="{{ old('calculated_finish', $repair->calculated_finish) }}">
                                        @if($errors->has('calculated_finish'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('calculated_finish') }}
                                            </div>
                                        @endif
                                        <span class="help-block">{{ trans('cruds.repair.fields.calculated_finish_helper') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="tasks_header"><a class="hover_task">Zadania</a><div class="d-flex justify-content-end"><i class="fas fa-fw fa-bars"></i></div></div>
                                <br>
                                <div class="card tasks_body">
                                    <div class="card-body">
                                        <table class="table" id="tasks_table">
                                            <thead>
                                            <tr>
                                                <th>Nazwa</th>
                                                <th>Długość trwania</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($tasks as $task)
                                            <tr>
                                                <td>
                                                    <input type="text" name="task{{$task->id}}" class="form-control" value="{{$task->name}}"/>
                                                </td>
                                                <td>
                                                    <input type="number" name="duration{{$task->id}}" class="form-control" value="{{$task->duration}}" />
                                                </td>
                                                <td>
                                                    <a style="color:white;" class="btn btn-xs btn-danger" id="task_delete{{$task->id}}">{{ trans('global.delete') }}</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr id="task0">
                                                <td>
                                                    <input type="text" name="task_name[]" class="form-control" placeholder="Nazwa nowego zadania"/>
                                                </td>
                                                <td colspan="2">
                                                    <input type="number" name="task_duration[]" class="form-control" value="0" />
                                                </td>
                                            </tr>
                                            <tr id="task1"></tr>
                                            </tbody>
                                        </table>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <button id="add_task" class="btn btn-default pull-left">Dodaj zadanie</button>
                                                <button id='delete_task' class="pull-right btn btn-danger">Usuń nowe zadanie</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div>Nadchodzące naprawy<div class="d-flex justify-content-end"><i class="fas fa-fw fa-bars"></i></div></div>

                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                                @if($repair->suspend == false)
                                <button class="btn btn-warning" id="suspend" style="color:white;">
                                    {{ trans('global.stop') }}
                                </button>
                                @else
                                <button class="btn btn-primary" id="suspend" style="color:white;">
                                    {{ trans('global.run') }}
                                </button>
                                @endif
                                @if($repair->finished_at == null)
                                <a class="btn btn-danger" id="fin" style="color:white;">
                                    {{ trans('global.finish') }}
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#manual').click(function() {
            if($('#calculated_finish').prop('disabled', true))
            {
                $('#calculated_finish').prop('disabled', false);
            }
        });

        $('#automatic').click(function() {
            if($('#automatic').is(':checked'))
            {
                $('#calculated_finish').prop('disabled', true);
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $(".tasks_header").mouseover(function(){
                $(".tasks_header").css("color","cornflowerblue");
                $(".hover_task").css("background-color","cornflowerblue");
                $(".hover_task").css("color","white");
                $(".hover_task").css("padding","5px");
                $(".hover_task").css("border-radius","5px");
            });
            $(".tasks_header").mouseleave(function(){
                $(".tasks_header").css("color","inherit");
                $(".hover_task").css("background-color","inherit");
                $(".hover_task").css("color","black");
            });
        });
    </script>
    <script>
        @foreach($tasks as $task)
        $(document).ready(function () {
            $('#task_delete{{$task->id}}').on('click', function () {

                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                    }
                })

                $.ajax({
                    type:'PATCH',
                    data: {"id": {{$task->id}} },
                    url: '{{ route('frontend.repairs.task') }}',
                    beforeSend: function() {
                        return confirm('{{ trans('global.areYouSure') }}');
                    }
                })
                    .done(function (response)
                    {
                        window.location.reload();
                    });
            });
        });
        @endforeach
    </script>
<script>

    $('.tasks_body').hide();

    $(document).ready(function() {
        $(".tasks_header").click(function () {
            if ($(".tasks_body").is(":hidden")) {
                $('.tasks_body').show();
            } else {
                $('.tasks_body').hide();
            }
        });
    });

    $(document).ready(function(){
        let row_number = 1;
        $("#add_task").click(function(e){
            e.preventDefault();
            let new_row_number = row_number - 1;
            $('#task' + row_number).html($('#task' + new_row_number).html()).find('td:first-child');
            $('#tasks_table').append('<tr id="task' + (row_number + 1) + '"></tr>');
            row_number++;
        });

        $("#delete_task").click(function(e){
            e.preventDefault();
            if(row_number > 1){
                $("#task" + (row_number - 1)).html('');
                row_number--;
            }
        });
    });
</script>
    <script>
        $(document).ready(function () {
            $('#suspend').on('click', function () {

                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                    }
                })

                $.ajax({
                    type:'PATCH',
                    data: {"id": {{$repair->id}} },
                    url: '{{ route('frontend.repairs.suspend') }}',
                    beforeSend: function() {
                        return confirm('{{ trans('global.areYouSure') }}');
                    }
                })
                    .done(function (response)
                    {
                        window.location.reload();
                    });
            });
        });

    </script>

    <script>
        $(document).ready(function () {
            $('#fin').on('click', function () {

                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                    }
                })

                $.ajax({
                    type:'POST',
                    data: {"id": {{$repair->id}}, },
                    url: '{{ route('frontend.repairs.fin') }}',
                    beforeSend: function() {
                        return confirm('{{ trans('global.areYouSure') }}');
                    }
                })
                    .done(function (response)
                    {
                        window.location.assign('{{ route('frontend.home') }}');
                    });
            });
        });

    </script>

    <script>
        $(document).ready(function () {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                    return {
                        upload: function() {
                            return loader.file
                                .then(function (file) {
                                    return new Promise(function(resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST', '/app/repairs/ckmedia', true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                                        xhr.addEventListener('error', function() { reject(genericErrorText) });
                                        xhr.addEventListener('abort', function() { reject() });
                                        xhr.addEventListener('load', function() {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                            }

                                            $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                            resolve({ default: response.url });
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function(e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id', '{{ $repair->id ?? 0 }}');
                                        xhr.send(data);
                                    });
                                })
                        }
                    };
                }
            }

            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        extraPlugins: [SimpleUploadAdapter]
                    }
                );
            }
        });
    </script>

@endsection
