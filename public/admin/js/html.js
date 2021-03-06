layui.use(['form', 'table'], function () {
    var form = layui.form,
        table = layui.table;

    var adminUrl = $.Public.url + 'html/';
    var tableIns = table.render({
        elem: '#content'
        ,where:{api:200}
        , url: adminUrl + 'index'
        , cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
        , cols: [[
            {field: 'html_id', width: 80, title: 'ID', sort: true}
            , {field: 'username', width: '', title: '网页名称'}
            , {field: 'user', width: 120, title: '分组名称' }
            , {field: 'back', width: 230, title: '备注信息' }
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
        let img = $.Public.html+'/public/portrait-1.png';
        if($.Public.values(data['img'])){
            img = data['img'];
        }
        let option = '';
        if(Group != null && Group != ''){
            // Group = JSON.parse(Group);
            for(i of Group){
                let selected = '';
                if(i.group_id == data.group_id){
                    selected = 'selected';
                }
                option += '<option '+selected+'  value="'+i.group_id+'" >'+i.username+'</option>';
            }
        }
        return '<form class="layui-form layui-form-pane padding-10" action="'+url+'">' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">网站名称</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="username" value="'+$.Public.values(data['username'])+'" placeholder="请输入网站名称" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '</div>' +
            '<div class="layui-form-item">\n' +
            '    <div class="layui-inline">\n' +
            '      <label class="layui-form-label">备注信息</label>\n' +
            '      <div class="layui-input-inline">\n' +
            '        <input type="text" name="back" value="'+$.Public.values(data['back'])+'" placeholder="请输入备注信息" autocomplete="off" class="layui-input">\n' +
            '      </div>\n' +
            '    </div>\n' +
            '<div class="layui-inline">\n' +
            '    <label class="layui-form-label">选择分组</label>\n' +
            '    <div class="layui-input-block ">\n' +
            ' <select name="group_id" lay-search="">\n' +
            '  <option value="">直接或搜索选择分组信息</option>'+option +
            ' </select>' +
            '    </div>\n' +
            '</div>' +
            '</div>' +
            '<div class="layui-form-item layui-form-text">\n' +
            '    <label class="layui-form-label">文本域</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <textarea placeholder="请输入内容" name="count" class="layui-textarea public-height-300 html-textarea"></textarea>\n' +
            '    </div>\n' +
            '  </div>' +
            '<input name="html_id" type="hidden" class="html_id" value="'+$.Public.values(data['html_id'])+'" /> ' +
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
                        type: 1
                        , title: '修改页面'
                        , area: ['680px', '660px']
                        , closeBtn: 1
                        , shade: 0.3
                        , id: 'LA_layer'
                        , moveType: 1
                        , content:_html(dataName,data)
                        ,success: function(layero, index){
                            $.Public.ajax({
                                type:'post'
                                ,url:adminUrl+'index'
                                ,data:{id:data.html_id}
                                ,load:function(res){
                                    if(res != '' && res != null){
                                        let rse = JSON.parse(res);
                                        $('.html-textarea').val(rse.data);
                                    }
                                }
                            });
                        }
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
                    data:{html_id:data.html_id},
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
                    type: 1
                    , title: '添加页面'
                    , area: ['680px', '660px']
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


