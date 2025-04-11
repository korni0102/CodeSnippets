@extends('core.index')
@section('content')
    <div class="d-flex justify-content-center align-items-center flex-column mt-5">
        @if($errors->first('error'))
            <div class="alert alert-danger" role="alert">
                {{ $errors->first('error') }}
            </div>

            <script>
                setTimeout(function () {
                    $('.alert').hide();
                }, 3000);
            </script>
        @endif
        <h1>{{ __("trans.Login") }}</h1>
        <div class="col-md-6">
            <form action="{{ route('login.post') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="inputEmail" class="form-label">{{__('trans.Email Address')}}</label>
                    <input name="email" type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" autocomplete="current-email">
                </div>
                <div class="mb-3">
                    <label for="inputPassword" class="form-label">{{__('trans.Password')}}</label>
                    <input name="password" type="password" id="inputPassword" class="form-control" aria-describedby="passwordHelpBlock" autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary">{{__('trans.Login')}}</button>
            </form>
        </div>
    </div>

@endsection
