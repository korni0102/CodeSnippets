@use(App\Models\Snippet)
@isset($snippet)
    <div class="d-flex justify-content-between align-items-start mb-3">
        <p class="w-75 mb-0">{{ __(Snippet::TRANS_STRING_DESCRIPTION . $snippet->id) }}</p>
        <span class="badge bg-primary w-25 text-end">
            {{ Snippet::getCrispdm($snippet->crispdm) }}
        </span>
    </div>

    <div class="code-holder mb-4 position-relative">
        <pre class="bg-dark text-light p-3 rounded"><code class="language-python">
            {{ $snippet->row }}
        </code></pre>
        <button class="btn btn-sm btn-outline-light position-absolute top-0 end-0 m-2 copy-btn"
                data-snippet="{{ $snippet->row }}"
                onclick="copyToClipboard($(this).data('snippet'), $(this))"
                title="{{ __("trans.Copy to clipboard")}}">
            <i class="bi bi-clipboard"></i>
        </button>

        @isset($isHomeBlade)
            <button class="btn btn-sm btn-outline-light position-absolute bottom-0 end-0 m-2 copy-btn"
                    data-bs-toggle="modal" data-bs-target="#showCode"
                    onclick="fetchCode('{{ $snippet->id }}')"
                    title="{{ __("trans.Show code") }}">
                <i class="bi bi-eye"></i>
            </button>
        @endisset
    </div>
@endisset
