@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.option.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.options.update", [$option->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.option.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $option->title) }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.option.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="value">{{ trans('cruds.option.fields.value') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('value') ? 'is-invalid' : '' }}" name="value" id="value">{!! old('value', $option->value) !!}</textarea>
                @if($errors->has('value'))
                    <div class="invalid-feedback">
                        {{ $errors->first('value') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.option.fields.value_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pages">{{ trans('cruds.option.fields.page') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('pages') ? 'is-invalid' : '' }}" name="pages[]" id="pages" multiple>
                    @foreach($pages as $id => $page)
                        <option value="{{ $id }}" {{ (in_array($id, old('pages', [])) || $option->pages->contains($id)) ? 'selected' : '' }}>{{ $page }}</option>
                    @endforeach
                </select>
                @if($errors->has('pages'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pages') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.option.fields.page_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="blogs">{{ trans('cruds.option.fields.blog') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('blogs') ? 'is-invalid' : '' }}" name="blogs[]" id="blogs" multiple>
                    @foreach($blogs as $id => $blog)
                        <option value="{{ $id }}" {{ (in_array($id, old('blogs', [])) || $option->blogs->contains($id)) ? 'selected' : '' }}>{{ $blog }}</option>
                    @endforeach
                </select>
                @if($errors->has('blogs'))
                    <div class="invalid-feedback">
                        {{ $errors->first('blogs') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.option.fields.blog_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="belongto">{{ trans('cruds.option.fields.belongto') }}</label>
                <input class="form-control {{ $errors->has('belongto') ? 'is-invalid' : '' }}" type="text" name="belongto" id="belongto" value="{{ old('belongto', $option->belongto) }}">
                @if($errors->has('belongto'))
                    <div class="invalid-feedback">
                        {{ $errors->first('belongto') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.option.fields.belongto_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
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
                xhr.open('POST', '{{ route('admin.options.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $option->id ?? 0 }}');
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