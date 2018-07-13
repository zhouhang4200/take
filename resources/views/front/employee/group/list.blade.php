<table class="layui-table" lay-size="sm">
    <thead>
    <tr>
        <th style="width:5%">序号</th>
        <th style="width:10%">岗位名称</th>
        <th style="width:10%">岗位员工</th>
        <th>拥有权限</th>
        <th style="width:15%">操作</th>
    </tr>
    </thead>
    <tbody>
        @forelse($userRoles as $userRole)
        <tr class="userRole-td">
            <td>{{ $userRole->id  }}</td>
            <td>{{ $userRole->alias  }}</td>
            <td>{{ hasEmployees($userRole) ?: '--' }}</td>
            <td>
                @forelse($userRole->permissions as $permission)
                    {{ $permission->alias }}&nbsp;&nbsp;
                @empty
                @endforelse
            </td>
            <td>
                <div style="text-align: center">
                <a href="{{ route('employee.group.edit', ['id' => $userRole->id]) }}" class="qs-btn qs-btn-normal qs-btn-mini">编辑</a>
                <button class="qs-btn qs-btn-normal qs-btn-mini" lay-id="{{ $userRole->id }}" lay-submit="" lay-filter='delete'>删除</button>
                </div>
            </td>
        </tr>
        @empty
            <tr class="userRole-td">
                <td colspan="6">暂无数据</td>
            </tr>
        @endforelse
    </tbody>
</table>