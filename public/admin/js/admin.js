layui.use(['form', 'table'], function () {
    var form = layui.form,
        table = layui.table;
    var adminUrl = $.Public.url + 'admin/';
    var tableIns = table.render({
        elem: '#content'
        , url: adminUrl + 'index'
        , cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
        , cols: [[
            {field: 'id', width: 80, title: 'ID', sort: true}
            , {field: 'username', width: '', title: '管理员账号'}
            , {field: 'contact', width: 200, title: '联系人'}
            // ,{field:'user', width:140, title: '权限名称',templet: '#start'}
            // ,{field:'start', width:140, title: '权限验证' ,hide:true}
            // ,{field:'listed_id', hide:true, title: '权限ID'}
            , {field: 'disable', width: 140, title: '是否启用', templet: '#disable', unresize: true}
            , {field: 'create_time', width: 200, title: '添加时间'}
            , {fixed: 'right', title: '操作', toolbar: '#barDemo', width: 180}
        ]]
        , limit: 10
        , page: true
    });

    function _html(url){
        return '<form class="layui-form layui-form-pane padding-10" action="'+url+'">' +
            '<div class="admin-img">' +
            '<div class="admin-img-bor">' +
            '<img src="'+$.Public.html+'/public/portrait-1.png" /> ' +
            '</div>' +
            '</div>' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">管理员账号</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="" placeholder="请输入" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '</div>' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">密码</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="password" name="" placeholder="请输入密码" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '</div>' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">确定密码</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="password" name="" placeholder="请输入密码" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '</div>' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">联系人</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="" placeholder="请输入联系人" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '</div>' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">是否启用</label>\n' +
            '    <div class="layui-input-block public-border-e6">\n' +
            '<input type="radio" name="sex" value="1" title="启用" checked>\n' +
            ' <input type="radio" name="sex" value="2" title="禁用" >' +
            '    </div>\n' +
            '</div>' +
            '</form>';
    }

    //点击添加事件
    $('.admin-add').bind('click',function(){
        $.Public.yzUlr({
            type:'get',
            url:adminUrl+'add',
            arr:'',
            data:function(msg){
                layer.open({
                    zIndex: 1001
                    , type: 1
                    , title: '添加管理员'
                    , area: ['350px', '550px']
                    , closeBtn: 1
                    , shade: 0.4
                    , id: 'LA_layer'
                    , moveType: 1
                    , content:_html(adminUrl+'add')
                })
                form.render();
            }
        })
    });

})


