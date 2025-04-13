@use(App\Models\RowCategory)
@use(App\Models\Snippet)
@use(App\Models\CodeCategory)

<nav class="navbar my-5 py-4 px-4 shadow rounded" style="background-color: #C8BEB7;">
    <div class="container-fluid pe-0 me-0">
        <span class="navbar-brand mb-0 h1">{{ __("trans.Filters") }}</span>

        <div class="row col-12">
            <div class="col-3 d-flex align-items-center">
                <select id="snippetCategory" name="snippetCategories[]" class="form-select"
                        aria-label="Snippet category" multiple="multiple">
                    @foreach(RowCategory::getAllCategoriesForSelect() as $categoryId => $categoryName)
                        <option value="{{ $categoryId }}"> {{ __(RowCategory::TRANS_STRING . $categoryId) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3 d-flex align-items-center">
                <select id="crispdm" name="crispdm[]" class="form-select" aria-label="Crispdm" multiple="multiple">
                    @foreach(Snippet::getAllCrispdm() as $crispdmId => $crispdmName)
                        <option value="{{ $crispdmId }}"> {{ __("trans." . $crispdmName) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3 d-flex align-items-center">
                <select id="codeCategory" name="codeCategories[]" class="form-select" aria-label="Code category"
                        multiple="multiple">
                    @foreach(CodeCategory::getTypes() as $typeId => $typeName)
                        <option value="{{ $typeId }}"> {{ __("trans." . $typeName) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="search" placeholder="">
                    <label for="search">{{ __("trans.Search in desc and code") }}</label>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    const isHomeBlade = true;

    $(document).ready(function () {
        $('#snippetCategory').select2({
            placeholder: '{{ __("trans.Select snippet categories") }}',
            allowClear: true
        });

        $('#crispdm').select2({
            placeholder:' {{ __("trans.Select crispdm") }}',
            allowClear: true
        });

        $('#codeCategory').select2({
            placeholder: '{{ __("trans.Select code categories") }}',
            allowClear: true
        });

        $('#snippetCategory, #crispdm, #codeCategory, #search').on('change', function () {
            $.ajax({
                url: "{{ route('ajax.list.filter') }}",
                method: "GET",
                data: {
                    snippetCategories: $('#snippetCategory').val(),
                    crispdm: $('#crispdm').val(),
                    codeCategories: $('#codeCategory').val(),
                    search: $('#search').val()
                },
                success: function (data) {
                    renderSnippets(data);
                    Prism.highlightAll();
                }
            });
        });

        function renderSnippets(data) {
            const snippetsSection = document.getElementById('content-holder');
            const sidebarSection = document.getElementById('side-bar');
            let categories = [];

            snippetsSection.innerHTML = '';
            sidebarSection.innerHTML = `
        <p><a class="link-secondary" onclick="window.scrollTo({ top: 0, behavior: 'smooth' }); return false;">{{ __('trans.Scroll to the top') }}</a></p>
    `;

            Object.values(data).forEach(category => {
                const {category_id, category_name, snippets} = category;
                categories.push(category_name);

                snippetsSection.innerHTML += `<h3 id="${category_name}">${category_name}</h3>`;
                snippets.forEach(snippet => {
                    snippetsSection.innerHTML += renderCodeHolderSnippet(snippet);
                });
            });

            categories.forEach(category => {
                sidebarSection.innerHTML += `
            <p><a href="#${category}" class="link-secondary" onclick="changeLinkColor($(this))">${category}</a></p>
        `;
            });
        }


        function renderCodeHolderSnippet(snippet) {
            return `
            <div class="d-flex justify-content-between align-items-start mb-3">
                <p class="w-85 mb-0">${snippet.description}</p>
                <span class="badge bg-primary w-15 text-end">
                    ${snippet.crispdm}
                </span>
            </div>

            <div class="code-holder mb-4 position-relative">
                <div class="bg-dark text-light rounded snippet-holder">
                    <pre class="bg-dark language-python"><code class="language-python"> ${escapeHtml(snippet.row)}</code></pre>
                </div>
                <button class="btn btn-sm btn-outline-light position-absolute bottom-0 end-0 m-2 copy-btn mb-4"
                        data-snippet="${snippet.row}"
                        onclick="copyToClipboard($(this).data('snippet'), $(this))"
                        title="{{ __("trans.Copy to clipboard") }}">
                    <i class="bi bi-clipboard"></i>
                </button>

                <button class="btn btn-sm btn-outline-light position-absolute bottom-0 m-2 copy-btn mb-4"
                        data-bs-toggle="modal" data-bs-target="#showCode"
                        onclick="fetchCode('${snippet.id}')"
                        title="{{ __("trans.Show code") }}"
                        style="right: 45px"
                        >
                    <i class="bi bi-eye"></i>
                </button>
            </div>`;
        }

        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;");
        }
    });
</script>

