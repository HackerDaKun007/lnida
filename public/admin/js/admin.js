layui.use(['form', 'table','upload'], function () {
    var form = layui.form,
        upload = layui.upload,
        table = layui.table;

    var adminUrl = $.Public.url + 'admin/';
    var tableIns = table.render({
        elem: '#content'
        ,where:{api:200}
        , url: adminUrl + 'index'
        , cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
        , cols: [[
            {field: 'admin_id', width: 80, title: 'ID', sort: true}
            , {field: 'username', width: '', title: '管理员账号'}
            , {field: 'contact', width: 160, title: '联系人'}
            , {field: 'img', width: 100, title: '头像', templet: '#images'}
            // ,{field:'user', width:140, title: '权限名称',templet: '#start'}
            // ,{field:'start', width:140, title: '权限验证' ,hide:true}
            // ,{field:'listed_id', hide:true, title: '权限ID'}
            , {field: 'disable', width: 140, title: '是否启用', templet: '#start', unresize: true}
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
        return '<form class="layui-form layui-form-pane padding-10" action="'+url+'">' +
            '<div class="admin-img">' +
            '<div class="admin-img-bor">' +
            '<img src="'+img+'" /> ' +
            '</div>' +
            '</div>' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">管理员账号</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="username" value="'+$.Public.values(data['username'])+'" placeholder="请输入管理员账号" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '</div>' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">密码</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="password" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '</div>' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">确定密码</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="password" name="repassword" placeholder="请输入确定密码" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '</div>' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">联系人</label>\n' +
            '    <div class="layui-input-block">\n' +
            '      <input type="text" name="contact" value="'+$.Public.values(data['contact'])+'" placeholder="请输入联系人" autocomplete="off" class="layui-input">\n' +
            '    </div>\n' +
            '</div>' +
            '<div class="layui-form-item">\n' +
            '    <label class="layui-form-label">是否启用</label>\n' +
            '    <div class="layui-input-block public-border-e6">\n' +
            '<input type="radio" name="disable" value="1" title="启用" '+$.Public.checked(1,$.Public.values(data['disable']))+'  checked>\n' +
            ' <input type="radio" name="disable" value="2" title="禁用" '+$.Public.checked(2,$.Public.values(data['disable']))+' >' +
            '    </div>\n' +
            '</div>' +
            '<input name="img" type="hidden" class="img" /> ' +
            '<input name="admin_id" type="hidden" class="admin_id" value="'+$.Public.values(data['admin_id'])+'" /> ' +
            '<div class="layui-form-item public-button-center">' +
            '   <button class="layui-btn " type="button"  lay-submit="" lay-filter="submit">提交</button>' +
            '</div>' +
            '</form>';
    }

    table.on('tool(content)',function(obj) {
        var data = obj.data;
        if(obj.event == 'img') { //读取图片
            $.Public.popImg($(this));
        }else if(obj.event == 'edit'){
            let dataName = adminUrl+'edit';
            $.Public.yzUlr({
                type:'get',
                url:dataName,
                arr:'',
                data:function(msg){
                    layer.open({
                        zIndex: 1001
                        , type: 1
                        , title: '修改管理员'
                        , area: ['350px', '480px']
                        , closeBtn: 1
                        , shade: 0.3
                        , id: 'LA_layer'
                        , moveType: 1
                        , content:_html(dataName,data)
                    })
                    form.render();
                    upLoad();
                }
            })
        }else if(obj.event == 'del'){
            let dataName = adminUrl+'del';
            layer.confirm('确定要删除么？',{icon:3},function(){
                $.Public.deal({
                    type:'post',
                    url:dataName,
                    data:{admin_id:data.admin_id},
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
                    , title: '添加管理员'
                    , area: ['350px', '480px']
                    , closeBtn: 1
                    , shade: 0.3
                    , id: 'LA_layer'
                    , moveType: 1
                    , content:_html(dataName)
                })
                form.render();
                upLoad();
            }
        })
    });

    function upLoad()
    {
        //上传头像
        var uploadImg = '';
        var uploadInst = upload.render({
            elem: '.admin-img-bor'
            ,data:{api:200}
            ,url: adminUrl+'index'
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    uploadImg = result;
                });
            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 0){
                    layer.msg(res.msg,{time:1000,icon:5});
                }else{
                    //上传成功
                    layer.msg('上传成功',{time:1000,icon:1});
                    $('.img').val(res.data);
                    $('.admin-img-bor img').attr('src',uploadImg);
                }
                uploadImg = '';
            }
        });
    }


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


