@extends('core.index')
@section('content')
    @use(App\Models\Code)

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

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>

            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($archive as $code)
            <tr>
                <td>{{ __($code->name) }}</td>

                <td width="15%">
                    <a class="btn btn-success me-2 btn-sm" href="{{ route('user.code.archive.restore', $code->id) }}"
                       onclick="return confirm('Are you sure you want to restore this item?');"
                       title="{{ __("trans.Restore") }}">
                        <i class="bi bi-bootstrap-reboot"></i>
                    </a>
                    <a class="btn btn-danger me-2 btn-sm" href="{{ route('user.code.delete', $code->id) }}"
                       onclick="return confirm('Are you sure you want to delete this item?');"
                       title="{{ __("trans.Delete") }}">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection
