<html>

<head>
    <title>Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    @php
        dump(session()->all());
    @endphp
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

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

    <div id="authorization_page_content">
        <form method="post" action="{{ route('authorization.update') }}">
            <button type="submit">Update</button>
            <div class="table">
                <table id="authorization_table" class="table table-hover table-bordered table-striped display dataTable"
                    width="100%">
                    <thead>
                        <tr>
                            <th class="text-center">STT</th>
                            <th class="text-center">Quyền</th>
                            <th class="text-center">Miêu tả</th>
                            @foreach ($roles as $role)
                                <th class="text-center">{{ $role->display_name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration + ($permissions->currentPage() - 1) * $permissions->perPage() }}
                                </td>
                                <td class="text-center">{{ $permission->display_name }}</td>
                                <td class="text-center">{{ $permission->description }}</td>
                                @foreach ($roles as $role)
                                    <td class="text-center">
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
    </div>
    </div>
</body>

</html>
