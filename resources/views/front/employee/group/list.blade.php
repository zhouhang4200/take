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
    @foreach($userRoles as $userRole)
        <tr class="userRole-td">
            <td>1</td>
            <td>1</td>
            <td>1</td>
            <td>
            1
            </td>
            <td>
                <div style="text-align: center">
                <a href="" class="qs-btn qs-btn-normal qs-btn-mini">编辑</a>
                <button class="qs-btn qs-btn-normal qs-btn-mini" lay-id="" lay-submit="" lay-filter='delete'>删除</button>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>