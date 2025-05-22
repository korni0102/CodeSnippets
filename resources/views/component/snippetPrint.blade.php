@use(App\Models\RowCategory)
@php($categories = [])
<div class="col-7 mx-auto" id="content-holder">
    @foreach($snippets as $categoryId => $categorySnippets)
        @php($categories[] = $categoryId)

        <h3 id="{{ $categoryId }}">{{ __(RowCategory::TRANS_STRING . $categoryId) }}</h3>

        @foreach($categorySnippets as $snippet)
            @include('component.codeHolder')
        @endforeach
    @endforeach
</div>

<div class="side-bar col-3 position-sticky top-0 p-4 rounded shadow-sm bg-white ms-auto" style="height: 100vh; overflow-y: auto; background-color: #E6DCCD;" id="side-bar">
    <p class="fw-bold border-bottom pb-2 mb-3 text-dark">
        <a class="text-decoration-none text-primary" onclick="window.scrollTo({ top: 0, behavior: 'smooth' }); return false;">
            {{ __('trans.Scroll to the top') }}
        </a>
    </p>
    @foreach($categories as $categoryId)
        <p class="mb-2">
            <a href="#{{ $categoryId }}" class="text-dark text-decoration-none d-block px-2 py-1 rounded link-hover"
               onclick="changeLinkColor($(this))">
                {{ __(RowCategory::TRANS_STRING . $categoryId) }}
            </a>
        </p>
    @endforeach
</div>
