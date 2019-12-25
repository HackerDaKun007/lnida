layui.use(['form', 'layedit', 'laydate'], function () {
    var form = layui.form
        , layer = layui.layer
        , layedit = layui.layedit
        , laydate = layui.laydate;

    // 自定义验证规则
    form.verify({
        username: function (value) {
            if (value == '') {
                return '用户名称不能为空';
            }
        },
        password: function (value) {
            if (value == '') {
                return '密码不能为空';
            }
        },
        yzm: function (value) {
            if (value.length != 4) {
                return '请输入四位数验证码';
            }
        },
    });

    var username = 'login';
    var yzmUrl = $.Public.url+username+'/yzm.html?id=';
    var yzmImg = $('.login-yzm');
    //切换验证码
    yzmImg.click(function(){
        $(this).attr('src', yzmUrl+ (Math.random()*100));
    });
    //监听提交
    form.on('submit(submit)', function (data) {
        $.Public.ajax({
            type:'POST',
            url:data.form.action,
            data:data.field,
            load:function(msg){
                console.info(msg);
                yzmImg.attr('src', yzmUrl+ (Math.random()*100));
            }
        });
        return false;
    });

});