@use(App\Models\Code)
@foreach($codes as $code)
    <div class="accordion mb-5" id="code{{ $code->id }}">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#{{ $code->id }}" aria-expanded="false"
                        aria-controls="{{ $code->id }}">
                    <div class="d-flex flex-column text-start w-100">
                        <span class="fw-semibold">{{ __('trans.code.used', ['id' => $code->id]) }}</span>
                        <span class="fst-italic text-muted">"{{ __('trans.code.name.' . $code->id) }}"</span>
                    </div>
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
