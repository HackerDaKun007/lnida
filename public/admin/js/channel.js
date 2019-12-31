layui.use(['form', 'table','upload'], function () {
    var form = layui.form,
        upload = layui.upload,
        table = layui.table;

    var adminUrl = $.Public.url + 'channel/';
    var tableIns = table.render({
        elem: '#content'
        ,where:{api:200}
        , url: adminUrl + 'index'
        , cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
        , cols: [[
            {field: 'channel_id', width: 80, title: 'ID', sort: true}
            , {field: 'username', width: '', title: '渠道分组名称'}
            , {field: 'back', width: 210, title: '备注'}
            ,{field:'display', width:140, title: '是否启用',templet: '#start'}
            // ,{field:'start', width:140, title: '权限验证' ,hide:true}
            // ,{field:'listed_id', hide:true, title: '权限ID'}
            , {field: 'create_time', width: 200, title: '添加时间'}
            , {fixed: 'right', title: '操作', toolbar: '#barDemo', width: 180}
        ]]
        , limit: 10
        , page: true
    });

    //搜索
    form.on('submit(search)',function(data){
        var field = data.field;
        field.api = 200;
        tableIns.reload({
            where:field,
            page: {
                curr: 1 //重新从第 1 页开始
            }
        });
        return false;
    });

    function _html(url,data=''){
        return '<form class="layui-form layui-form-pane padding-10" action="'+url+'">' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">渠道组名称</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="username" value="'+$.Public.values(data['username'])+'" placeholder="请输入渠道组名称" autocomplete="off" class="layui-input">\n' +
            '    </div></div>\n' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">备注信息</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="back" value="'+$.Public.values(data['back'])+'" placeholder="请输入备注信息" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '</div>' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">是否启用</label>\n' +
            '    <div class="layui-input-block public-border-e6">\n' +
            '<input type="radio" name="disable" value="1" title="启用" '+$.Public.checked(1,$.Public.values(data['disable']))+'  checked>\n' +
            ' <input type="radio" name="disable" value="2" title="禁用" '+$.Public.checked(2,$.Public.values(data['disable']))+' >' +
            '    </div>\n' +
            '</div>' +
            '<input name="channel_id" type="hidden" class="group_id" value="'+$.Public.values(data['channel_id'])+'" /> ' +
            '<div class="layui-form-item public-button-center">' +
            '   <button class="layui-btn " type="button"  lay-submit="" lay-filter="submit">提交</button>' +
            '</div>' +
            '</form>';
    }

    table.on('tool(content)',function(obj) {
        var data = obj.data;
        if(obj.event == 'edit'){
            let dataName = adminUrl+'edit';
            $.Public.yzUlr({
                type:'get',
                url:dataName,
                arr:'',
                data:function(msg){
                    layer.open({
                        zIndex: 1001
                        , type: 1
                        , title: '修改渠道组名称'
                        , area: ['350px', '350px']
                        , closeBtn: 1
                        , shade: 0.3
                        , id: 'LA_layer'
                        , moveType: 1
                        , content:_html(dataName,data)
                    })
                    form.render();
                }
            })
        }else if(obj.event == 'del'){
            let dataName = adminUrl+'del';
            layer.confirm('确定要删除么？',{icon:3},function(){
                $.Public.deal({
                    type:'post',
                    url:dataName,
                    data:{channel_id:data.channel_id},
                    load:function(msg){
                        tableIns.reload(); //重新载录数据
                    }
                })
            })

        }
        return false;
    })

    //点击添加事件
    $('.admin-add').bind('click',function(){
        let dataName = adminUrl+'add';
        $.Public.yzUlr({
            type:'get',
            url:dataName,
            arr:'',
            data:function(msg){
                layer.open({
                    zIndex: 1001
                    , type: 1
                    , title: '添加渠道组名称'
                    , area: ['350px', '350px']
                    , closeBtn: 1
                    , shade: 0.3
                    , id: 'LA_layer'
                    , moveType: 1
                    , content:_html(dataName)
                })
                form.render();
            }
        })
    });

    form.on('submit(submit)',function(data){
        $.Public.deal({
            url:data.form.action,
            type: 'POST',
            data:data.field,
            load:function(res){
                layer.closeAll();
                tableIns.reload(); //重新载录数据
            }
        });
        return false;
    });

})


