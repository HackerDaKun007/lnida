layui.use(['form', 'table','upload'], function () {
    var form = layui.form,
        upload = layui.upload,
        table = layui.table;

    var adminUrl = $.Public.url + 'filetxt/';
    var tableIns = table.render({
        elem: '#content'
        ,where:{api:200}
        , url: adminUrl + 'index'
        , cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
        , cols: [[
            {field: 'filetxt_id', width: 80, title: 'ID', sort: true}
            , {field: 'username', width: '', title: '栏目名称'}
            , {field: 'back', width: 210, title: '备注'}
            , {field: 'create_time', width: 200, title: '添加时间'}
            , {fixed: 'right', title: '操作', toolbar: '#barDemo', width: 270}
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
            '    <label class="layui-form-label">栏目名称</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="username" value="'+$.Public.values(data['username'])+'" placeholder="请输入栏目名称" autocomplete="off" class="layui-input">\n' +
            '    </div></div>\n' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">备注信息</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="back" value="'+$.Public.values(data['back'])+'" placeholder="请输入备注信息" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '</div>' +
            '<input name="filetxt_id" type="hidden" class="filetxt_id" value="'+$.Public.values(data['filetxt_id'])+'" /> ' +
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
                        , title: '修改栏目名称'
                        , area: ['350px', '260px']
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
                    data:{filetxt_id:data.filetxt_id,del:200},
                    load:function(msg){
                        tableIns.reload(); //重新载录数据
                    }
                })
            })
        }else if(obj.event == 'level'){
            //{username:data.username,api:'level'}
            let dataName = adminUrl+'addFiled';
            $.Public.yzUlr({
                type:'post',
                url:dataName,
                arr:'',
                data:function(msg){
                    let dataFile = '<div class="padding-10">' +
                        '<div class="">' +
                        '   <input type="file" name="file" id="test20"><button type="button" class="layui-btn layui-btn-xs " id="dataFile">上传文件</button>' +
                        '</div>' +
                        '   <div class="public-content-table">\n' +
                        '        <table class="layui-hide" id="dataFile" lay-filter="dataFile"></table>\n' +
                        '    </div>' +
                        '</div>';
                    layer.open({
                        type: 1
                        , title: data.username+' 文件列表'
                        , area: ['650px', '650px']
                        , closeBtn: 1
                        , shade: 0.3
                        , id: 'LA_layer'
                        , moveType: 1
                        , content:dataFile
                        ,success:function(){
                            var tableIns = table.render({
                                elem: '#dataFile'
                                ,where:{username:data.username,api:'level'}
                                , url: dataName
                                , cols: [[
                                    {field: 'key', width: 80, title: '排序', sort: true}
                                    , {field: 'data', width: '', title: '文件名称'}
                                    , {field: 'back', width: 210, title: '备注'}
                                    , {field: 'create_time', width: 200, title: '添加时间'}
                                    , {fixed: 'right', title: '操作', toolbar: '#barDemo', width: 270}
                                ]]
                                , limit: 10
                                , page: true
                            });
                        }
                    })
                    form.render();
                }
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
                    , title: '添加栏目名称'
                    , area: ['350px', '260px']
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


