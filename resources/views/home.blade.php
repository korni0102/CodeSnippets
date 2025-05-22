@extends('core.index')

@section('content')
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
    <div class="row mt-5" id="home-code-holder">
        {!! $html !!}
    </div>

    @include('component.codeModal')

    <style>
        .link-hover:hover {
            background-color: #f1f1f1;
            transition: background-color 0.2s ease-in-out;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Prism.highlightAll();
        });


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
