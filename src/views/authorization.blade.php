<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="post">
        @csrf
        <div class="text-right m-1">
            <button type="submit" class="">Update</button>
        </div>

        <table class="table-auto">
            <thead>
                <tr>
                    <th class="">STT</th>
                    <th class="">Quyền</th>
                    <th class="">Miêu tả</th>
                    @foreach ($roles as $role)
                        <th class="">{{ $role->display_name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    <tr>
                        <td class="">
                            {{ $loop->iteration + ($permissions->currentPage() - 1) * $permissions->perPage() }}
                        </td>
                        <td class="">{{ $permission->display_name }}</td>
                        <td class="">{!! nl2br($permission->description) !!}</td>
                        @foreach ($roles as $role)
                            <td class="">
                                <input type="hidden" name="{{ "$role->id[$permission->id]" }}"
                                    value="{{ $role->hasPermission($permission) ? 1 : 0 }}">
                                <input type="checkbox"
                                    onclick="this.previousElementSibling.value=1-this.previousElementSibling.value"
                                    {{ $role->hasPermission($permission) ? 'checked' : '' }}>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    {{ $permissions->links() }}
</body>

</html>
