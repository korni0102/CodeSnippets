@extends('core.index')
@section('content')

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function () {
                $('.alert').hide();
            }, 3000);
        </script>
    @endif

    <form action="{{ route('user.codeCategory.create') }}" method="post">
        @csrf
        <div class="form-group row">
            <div class="col-6">
                <label for="categoryEn" class="col-form-label">
                    {{ __("trans.Row category in English:") }}
                </label>
                <div class="row d-flex justify-content-start align-items-center">
                    <div class="col-10">
                        <input type="text" class="form-control col-sm-10" name="en" id="category-en" required>
                    </div>
                    <div class="col-1">
                        <a class="btn btn-info" style="font-size: 13px" href="#"
                           onclick="getTranslation($(this))" data-local="en" role="button" data-target-id="category-sk">
                            <i class="bi bi-translate"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <label for="categoryEn" class="col-form-label">
                    {{ __("trans.Row category in Slovak:") }}
                </label>
                <div class="row d-flex justify-content-start align-items-center">
                    <div class="col-10">
                        <input type="text" class="form-control col-sm-10" name="sk" id="category-sk" required>
                    </div>
                    <div class="col-1">
                        <a class="btn btn-info" style="font-size: 13px" href="#"
                           onclick="getTranslation($(this))" data-local="sk" role="button" data-target-id="category-en">
                            <i class="bi bi-translate"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row col-12 my-4">
            <button type="submit" class="btn btn-success">{{ __("trans.Save") }}</button>
        </div>
    </form>

    <script src="{{ asset('js/translatorForCreateAndEdit.js') }}"></script>
@endsection
