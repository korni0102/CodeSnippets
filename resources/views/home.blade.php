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

                <h3 id="{{$categoryId}}">{{ __(RowCategory::TRANS_STRING . $categoryId) }}</h3>

                @foreach($categorySnippets as $snippet)
                    @include('component.codeHolder')
                @endforeach
            @endforeach
            @include('component.codeModal')
        </div>
        <div class="side-bar col-3 position-sticky bg-light" id="side-bar">
            <p><a class="link-secondary" onclick="window.scrollTo({ top: 0, behavior: 'smooth' }); return false;">Scroll
                    to the top </a></p>
            @foreach($categories as $categoryId)
                <p><a href="#{{$categoryId}}" class="link-secondary"
                      onclick="changeLinkColor($(this))">{{ __(RowCategory::TRANS_STRING . $categoryId) }}</a></p>
            @endforeach
        </div>
    </div>
    <script>
        function fetchCode(snippetId) {
            $('#showCode .modal-body').html(`
<div class="d-flex justify-content-center">
  <div class="spinner-border" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>`);
            axios.get('{{ route('ajax.fetch.code') }}', {
                params: {
                    snippetId: snippetId
                }
            })
            .then(response => {
                //document.getElementById('items-container').innerHTML = ;
                $('#showCode .modal-body').html(response.data.html);
            })
            .catch(error => {
                console.error("There was an error fetching the items:", error);
            });
        }
    </script>
@endsection
