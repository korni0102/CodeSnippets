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
            {{ __("trans.No codes need approval") }}
        </h1>
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
                        <div class="d-flex">
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
                            <div class="d-flex justify-content-end py-3 w-100">
                                <form action="{{ route('admin.approve', $code) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success me-2" title="{{ __("trans.Approve") }}"
                                            onclick="return confirm('Are you sure you want to approve this item?');">
                                        <i class="bi bi-check2-circle"></i>
                                    </button>
                                </form>
                            </div>
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
