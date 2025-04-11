@extends('core.index')
@section('content')
@use(App\Models\Code)

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

    @if(count($codes) == 0)
        <h1 class="text-center my-3">
            {{ __("trans.You don't have any code yet") }}
        </h1>
        <a class="d-flex justify-content-center w-100 text-center link-success link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
           href="{{ route('user.code.create.show') }}">
            {{ __("trans.Click here to create a new code") }}
        </a>
    @endif

    @foreach($codes as $code)
        <div class="accordion mb-5" id="code{{ $code->id }}">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse"
                            data-bs-target="#{{ $code->id }}" aria-expanded="false"
                            aria-controls="{{ $code->id }}">
                        <span class="d-flex w-100">
                            <span class="w-25">
                                {{ __(Code::TRANS_STRING_NAME . $code->id) }}
                                <span
                                    class="badge ms-2 rounded-pill @if($code->approved) text-bg-success @else text-bg-danger @endif">@if($code->approved)
                                        {{ __('trans.Approved') }}
                                    @else
                                        {{ __('trans.Not approved yet') }}
                                    @endif
                                </span>
                            </span>
                            <span class="text-start w-75">
                                {{ __(Code::TRANS_STRING_DESCRIPTION . $code->id) }}
                            </span>
                        </span>
                    </button>
                </h2>
                <div id="{{ $code->id }}" class="accordion-collapse collapse"
                     data-bs-parent="#code{{ $code->id }}">
                    <div class="accordion-body">
                        <div class="d-inline-flex py-3">
                            <a class="btn btn-success me-2" href="{{ route('user.code.edit', $code) }}"
                               title="{{ __("trans.Edit") }}">
                                <i class="bi bi-pen"></i>
                            </a>
                            <a class="btn btn-warning me-2" href="{{ route('user.code.archive', $code) }}"
                               onclick="return confirm('Are you sure you want to archive this item?');"
                               title="{{ __("trans.Archive") }}">
                                <i class="bi bi-archive"></i>
                            </a>
                            <a class="btn btn-danger me-2" href="{{ route('user.code.delete', $code) }}"
                               onclick="return confirm('Are you sure you want to delete this item?');"
                               title="{{ __("trans.Delete") }}">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                        @foreach($code->snippets as $snippet)
                            @include('component.codeHolder')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
