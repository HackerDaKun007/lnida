//shared.js  大坤构造库
(function ($) {

    $.Public = {};
    $.Public.url = '/admin/';
    $.Public.url = '';
    $.Public.api = '/api/';
    $.Public.form = $('form').attr('action');
    $.Public.values = '';  //提交事件后返回值

    //控制只能数字以及只能数字两位小数点，input输入获取信息：onkeyup=,obj=this,如：$.Public.onkeyup(this)
    $.Public.onkeyup=function(obj)
    {
        obj.value = obj.value.replace(/[^\d.]/g,""); //清除"数字"和"."以外的字符
        obj.value = obj.value.replace(/^\./g,""); //验证第一个字符是数字
        obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个, 清除多余的
        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
        obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'); //只能输入两个小数
    }

    //判断变量是否存在，存在就返回当前值
    $.Public.variable = function(val){
        if(val != null && val != ''){
            return val;
        }
        return '';
    }
    //判断图片是否存在，存在就返回当前值，不存在就返回一直白底图
    $.Public.valImg = function(val){
        if(val != null && val != ''){
            return val;
        }
        return '/static/home/img/back.png';
    }
    
    //光标移开自动补全两位小数，input光标移开：onblur=,obj=this,如：$.Public.onblur(this)
    $.Public.money=function(obj)
    {
        var value = obj.value;
        if(value){
            value = parseFloat(value);
            var f = Math.round(value*100)/100;
            var s = f.toString();
            var rs = s.indexOf('.');
            if (rs < 0) {
                rs = s.length;
                s += '.';
            }
            while (s.length <= rs + 2) {
                s += '0';
            }
            obj.value = s;
        }else{
            obj.value = '00.00';
        }
    }

    //时间戳计算
    $.Public.datetime = function(timestamp){
        var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        var Y = date.getFullYear() + '-';
        var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        var D = date.getDate() + ' ';
        var h = date.getHours() + ':';
        var m = date.getMinutes() + ':';
        var s = date.getSeconds();
        return Y+M+D+h+m+s;
    }

    //复制
    $.Public.fz = function(input){
        input = input?input:document.getElementById("public-fuzhi");
        input.select(); // 选中文本
        document.execCommand("copy"); // 执行浏览器复制命令
        layer.msg('复制成功',{icon:1,time:1000});
    }
    
    //鼠标移入显示信息
    $.Public.tooltip = function(){
        var x = 10;
        var y = 20;
        var newtitle = '';
        $('.tooltip').mouseover(function (e) {
            newtitle = this.title;
            this.title = '';
            $('body').append('<div id="tooltip">' + newtitle + '</div>');
            var bo = $('body').width()-40;
            var ce = e.pageX + x ;
            if (ce > bo){
                ce = bo;
            }
            $('#tooltip').css({
                'left': (ce + 'px'),
                'top': (e.pageY + y + 'px'),
            }).show();
        }).mouseout(function () {
            this.title = newtitle;
            $('#tooltip').remove();
        }).mousemove(function (e) {
            var bo = $('body').width() - 40;
            var ce = e.pageX + x;
            if (ce > bo) {
                ce = bo;
            }
            $('#tooltip').css({
                'left': (ce + 'px'),
                'top': (e.pageY + y + 'px')
            }).show();
        });
    }

    //验证码
    $.Public.yzmImg = function(val,url){
        $(val).attr('src', url+'?id=' + Math.random());
    }


    $.Public.jsonYz = function(str){
        try {
            if (typeof JSON.parse(str) == "object") {
                return true;
            }
        } catch(e) {
        }
        return false;

    }

    //验证url是否正常，intr是否开启按钮禁用，url地址，data执行的方法，id按钮的位置，title按钮的名称
    $.Public.yzUlr = function(val){
        var index_load = layer.load(2);
        if(val.type == null && val.type == ''){
            val.type = 'GET';
        }
        if(val.arr == null && val.arr == ''){
            val.arr = '';
        }
        jQuery.support.cors = true;
        $.ajax({
            type: val.type,
            url: val.url,
            data:val.arr,
            timeout: 100000,
            success: function(msg){
                layer.close(index_load);
                var msgr = '';
                if ($.Public.json(msg) == true) {
                    msgr = JSON.parse(msg);
                }
                if(msgr.code == 404){  //没权限
                    layer.msg(msgr.msg,{icon:2,time:1500});
                    return false;
                }else if(msgr.code == 500){ //没登录
                    layer.msg('请先登录！',{icon:2,time:1500},function(){
                        window.location.href = msgr.url;
                    });
                    return false;
                }else if(msgr.code == 502){ //完全没有权限
                    layer.msg(msgr.msg,{icon:2,time:1500},function() {
                        window.location.href = msgr.url;
                    })
                    return false;
                }else{if($.Public.json(msg) == true){
                        //正常即可执行当前方法
                        val.data(msgr);
                    }else{
                        val.data();
                    }

                }

            },
            error: function(msg){
                layer.close(index_load);
                if(val.error != null && val.error != ''){
                    val.error()
                }
                layer.msg('当前服务器异常，请联系技术员！',{icon:2,time:1500});
            },
            complete : function(XMLHttpRequest,status){ //请求完成后最终执行参数
                layer.close(index_load);
                if(val.error != null && val.error != ''){
                    val.error()
                }

                if(status=='timeout'){//超时,status还有success,error等值的情况
                    data = 500;
                    ajaxTimeoutTest.abort();
                    layer.msg('服务器请求超时，请稍后再操作！',{icon:2,time:15000});
                }
            }
        })
    }

    //判断是否为json数据
    $.Public.json = function(msg){
        if (typeof msg == 'string') {
            try {
                var msg=JSON.parse(msg);
                if(typeof msg == 'object' && msg ){
                    return true;
                }else{
                    return false;
                }

            } catch(e) {
                return false;
            }
        }
    }


    //post/get验证处理
    $.Public.deal = function(load){
        //验证地址是否正常
        jQuery.support.cors = true;
        var index_load = layer.load(2);
        $.ajax({
            type: load.type,
            url: load.url,
            data:load.data,
            timeout: 100000,
            success: function(msg){
                var msgData = '';
                layer.close(index_load);
                if ($.Public.json(msg) == true) {
                    msgData = JSON.parse(msg);
                }
                if(msgData.code == 404){  //没权限
                    layer.msg(msgData.msg,{icon:2,time:1500});
                    return false;
                }else if(msgData.code == 500){ //没登录
                    layer.msg(msgData.msg,{icon:2,time:1500},function(){
                        window.location.href = msgData.url;
                    });
                    return false;
                }else if(msgData.code == 502) { //完全没有权限
                    layer.msg(msgData.msg, {icon: 2, time: 1500}, function () {
                        window.location.href = msgData.url;
                    })
                    return false;
                }else if(msgData.code == 1){
                    layer.msg(msgData.msg,{icon:1,time:500},function () {
                        if ($.Public.json(msg) == true) {
                            load.load(msgData)
                        }else{
                            load.load()
                        }
                    });
                }else if(msgData.code == 0){
                    layer.msg(msgData.msg,{icon:2,time:1500});
                }
            },
            error: function(msg){
                layer.close(index_load);
                if(load.error != null && load.error != ''){
                    load.error()
                }
                layer.msg('当前服务器异常，请联系技术员！',{icon:2,time:1000});
            },
            complete : function(XMLHttpRequest,status){ //请求完成后最终执行参数
                layer.close(index_load);
                if(load.error != null && load.error != ''){
                    load.error()
                }

                if(status=='timeout'){//超时,status还有success,error等值的情况
                    data = 500;
                    ajaxTimeoutTest.abort();
                    layer.msg('服务器请求超时，请稍后再操作！',{icon:2,time:1000});
                }
            }
        })
    }

    //自定ajax提交
    $.Public.ajax = function(val){
        jQuery.support.cors = true;
        var index_load = layer.load(2);
        $.ajax({
            type: val.type,
            url: val.url,
            data:val.data,
            timeout: 100000,
            success: function(msg){
                layer.close(index_load);
                val.load(msg);
            },
            error: function(msg){
                layer.close(index_load);
                if(val.error != null && val.error != ''){
                    val.error()
                }
                layer.msg('当前服务器异常，请联系技术员！',{icon:2,time:1000});
            },
            complete : function(XMLHttpRequest,status){ //请求完成后最终执行参数
                layer.close(index_load);
                if(val.error != null && val.error != ''){
                    val.error()
                }

                if(status=='timeout'){//超时,status还有success,error等值的情况
                    data = 500;
                    ajaxTimeoutTest.abort();
                    layer.msg('服务器请求超时，请稍后再操作！',{icon:2,time:1000});
                }
            }
        })
    };
    //验证是否登陆
    $.Public.sign = function(val){
        // var val_url = '/adminapi/logo/landing.html';
        var val_url = '';
        if( val_url != '' ){
            $.post('/adminapi/logo/landing.html',function(res){
                if(res.code == 500 && res.data == 'error'){
                    layer.msg(res.msg, {icon: 2,btn:["确定"],time:1500,shade :0.3}, function(){
                        top.location.href=res.url;
                    });
                    return false;
                }else{
                    val.data();
                }
            });
        }else{
            val.data();
        }
    }

    //获取for所有数据
    $.Public.form = function(val){
        var params = $(val).serializeArray();
        // params = decodeURIComponent(params, true);
        return params;
    };

    //提示内容被改动了
    $.Public.tips = function (Boolean){
        // $(document).on('input textarea select propertychange', function() {//监听文本框
        //     // $('input').each(function(){
        //     // });
        //     console.log($(this).val());
        // });
        // $('input').live('input propertychange', function()
        // {
        //     console.log($(this).val()+'a');
        //     //获取input 元素,并实时监听用户输入
        //     //逻辑
        // })
        if(Boolean == true){
            console.info(1);
            $(document).on("change","input,textarea,select",function(val){
                window.onbeforeunload = function(event) {
                    return "您编辑的信息尚未保存，您确定要离开吗？"//这里内容不会显示在提示框，为了增加语义化。
                };
            });
        }else{
            window.onbeforeunload = '';
        }

    }

})(jQuery);