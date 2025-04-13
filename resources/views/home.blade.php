@extends('core.index')

@section('content')
    @use(App\Models\RowCategory)
    @php($isHomeBlade = true)

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

    <h6 class="text-center">
        {{ __("trans.home.welcome") }}
    </h6>

    @include('component.filterBar')

    @php($categories = [])
    <div class="row mt-5">
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
    </div>

    @include('component.codeModal')

    <style>
        .link-hover:hover {
            background-color: #f1f1f1;
            transition: background-color 0.2s ease-in-out;
        }
    </style>

    <script>
        function fetchCode(snippetId) {
            $('#showCode .modal-body').html(`
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);

            axios.get('{{ route('ajax.fetch.code') }}', {
                params: {
                    snippetId: snippetId
                }
            })
                .then(response => {
                    $('#showCode .modal-body').html(response.data.html);
                    Prism.highlightAll();
                })
                .catch(error => {
                    console.error("There was an error fetching the items:", error);
                });
        }
    </script>
@endsection
