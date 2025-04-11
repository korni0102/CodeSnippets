@use(App\Models\RowCategory)
@use(App\Models\Snippet)
@use(App\Models\CodeCategory)

<nav class="navbar my-5 bg-light">
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
                }
            });
        });

        function renderSnippets(data) {
            const snippetsSection = document.getElementById('content-holder');
            const sidebarSection = document.getElementById('side-bar');
            let categories = [];

            // Clean existing content
            snippetsSection.innerHTML = '';
            sidebarSection.innerHTML = `
            <p><a class="link-secondary" onclick="window.scrollTo({ top: 0, behavior: 'smooth' }); return false;">${"{{ __('trans.Scroll to the top') }}"}</a></p>`;

            // Loop through and render snippets
            Object.values(data).forEach(category => {
                const {category_id, category_name, snippets} = category;
                categories.push(category_name);

                // Add category and snippets
                snippetsSection.innerHTML += `
                <h3 id="${category_name}">${category_name}</h3>
                ${snippets.map(snippet => `
                    <div class="d-flex justify-content-between">
                        <p class="w-75">${snippet.description}</p>
                        <p class="w-25 text-end">${snippet.crispdm}</p>
                    </div>
                    ${renderCodeHolderSnippet(snippet)}
                `).join('')}
            `;
            });

            // Render sidebar
            categories.forEach(category => {
                sidebarSection.innerHTML += `
                <p><a href="#${category}" class="link-secondary" onclick="changeLinkColor($(this))">${category}</a></p>
            `;
            });
        }

        function renderCodeHolderSnippet(snippet) {
            return `<div class="code-holder mb-4 bg-secondary-subtle">
                        <div class="code-holder__code">
                            ${snippet.row}
                            </div>
                            <a class="code-holder__copy" onclick="copyToClipboard('${snippet.row}', $(this))">
                            <i class="bi bi-clipboard"></i>
                        </a>
                    </div>`
        }
    });

</script>
