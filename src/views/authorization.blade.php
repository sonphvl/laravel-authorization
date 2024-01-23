<html>

<head>
    <title>Welcome</title>
</head>

<body>
    <div id="authorization_page_content">
        <div class="table">
            <table id="authorization_table" class="table table-hover table-bordered table-striped display dataTable"
                width="100%">
                <thead>
                    <tr>
                        <th class="not-export-col text-center font-weight-bold">STT</th>
                        <th class="text-center font-weight-bold">ID</th>
                        <th class="text-center font-weight-bold">Quyền</th>
                        <th class="text-center font-weight-bold">Miêu tả</th>
                        @foreach ($roles as $role)
                            <th class="text-center font-weight-bold" data-duty="">{{ $role->display_name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td class="not-export-col text-center font-weight-bold">{{ $loop->iteration }}</td>
                            <td class="not-export-col text-center font-weight-bold">{{ $permission->id }}</td>
                            <td class="not-export-col text-center font-weight-bold">{{ $permission->display_name }}</td>
                            <td class="not-export-col text-center font-weight-bold">{{ $permission->description }}</td>
                            @foreach ($roles as $role)
                                <td class="text-center font-weight-bold" data-duty="">
                                    {{ $role->hasPermission($permission) ? 'true' : 'false' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
