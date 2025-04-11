@use(App\Models\Code)
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
                    @foreach($code->snippets as $snippet)
                        @include('component.codeHolder')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endforeach
