@use(App\Models\Snippet)
@isset($snippet)
    <div class="d-flex justify-content-between align-items-start mb-3">
        <p class="w-85 mb-0">{{ __($snippet->description) }}</p>
        <span class="badge bg-primary w-15 text-end">
            {{ __("trans." . Snippet::getCrispdm($snippet->crispdm)) }}
        </span>

    </div>

    <div class="code-holder mb-4 position-relative">
        <div class="bg-dark text-light rounded snippet-holder">
            <pre class="bg-dark"><code class="language-python">{{ $snippet->row }}</code></pre>
        </div>
        <button class="btn btn-sm btn-outline-light position-absolute bottom-0 end-0 m-2 copy-btn mb-4"
                data-snippet="{{ $snippet->row }}"
                onclick="copyToClipboard($(this).data('snippet'), $(this))"
                title="{{ __("trans.Copy to clipboard")}}"

        >
            <i class="bi bi-clipboard"></i>
        </button>

        @isset($isHomeBlade)
            <button class="btn btn-sm btn-outline-light position-absolute bottom-0 m-2 copy-btn mb-4"
                    data-bs-toggle="modal" data-bs-target="#showCode"
                    onclick="fetchCode('{{ $snippet->id }}')"
                    title="{{ __("trans.Show code") }}"
                    style="right: 45px"
            >
                <i class="bi bi-eye"></i>
            </button>
        @endisset
    </div>
@endisset
