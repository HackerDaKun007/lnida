
layui.use(['form', 'layedit', 'laydate','element'], function () {
    var form = layui.form
        , layer = layui.layer
        , layedit = layui.layedit
        , element = layui.element
        , laydate = layui.laydate;
    $.Public.tooltip();
    var defaultUrl = '/index/home';  //默认URL地址

    //顶部导航栏目
    $('.layadmin-flexible').on('mouseleave',function(){
        $(this).removeClass('layui-this');
    });

    //栏目缩进
    var log_side =  $('.layui-logo,.layui-side');
    var left = $('.layui-header .layui-layout-left');
    let right = $('.layui-header .layui-layout-right');
    var layui_body = $('.layui-body');
    $('.left-menu').on('click',function(){
        let $this = $(this);
        let action = $this.attr('action');
        let width = $(window).width();
        //pc端
        if(width > 768){
            if(action == 'left'){
                log_side.stop().animate({left:'-200px'},300);
                layui_body.stop().animate({left:'0px'},300);
                left.stop().animate({left:'0px'},300,'',function(){
                    $this.attr('action','right');
                    let i = $this.find('i');
                    i.removeClass('layui-icon-shrink-right');
                    i.addClass('layui-icon-spread-left');
                    i.parent('a').attr('title','右伸缩菜单');
                });
            }else{
                log_side.stop().animate({left:'0px'},300);
                layui_body.stop().animate({left:'200px'},300);
                left.stop().animate({left:'200px'},300,'',function(){
                    $this.attr('action','left');
                    let i = $this.find('i');
                    i.addClass('layui-icon-shrink-right');
                    i.removeClass('layui-icon-spread-left');
                    i.parent('a').attr('title','左伸缩菜单');
                });
            }
        }else{
            //手机端
            if(action == 'left'){
                log_side.stop().animate({left:'-200px'},300);
                layui_body.stop().animate({left:'0px'},300);
                right.stop().animate({left:'220px'},300,'',function(){
                    right.css({left:'unset'});
                    right.css({'min-width':'unset'});
                });
                left.stop().animate({left:'0px'},300,'',function(){
                    $this.attr('action','right');
                    let i = $this.find('i');
                    i.removeClass('layui-icon-shrink-right');
                    i.addClass('layui-icon-spread-left');
                    i.parent('a').attr('title','右伸缩菜单');
                    left.css({'min-width':'unset'});
                });
            }else{
                log_side.stop().animate({left:'0px'},300);
                layui_body.stop().animate({left:'200px'},300);
                right.css({'min-width':'240px'});
                right.stop().animate({left:'420px'},300);
                left.stop().animate({left:'200px','min-width':'200px'},300,'',function(){
                    $this.attr('action','left');
                    let i = $this.find('i');
                    i.addClass('layui-icon-shrink-right');
                    i.removeClass('layui-icon-spread-left');
                    i.parent('a').attr('title','左伸缩菜单');
                });
            }
        }
        return false;
    });

    //监听窗口大小
    $(window).resize(function(){
        ressizeWdith();
    });
    function ressizeWdith()
    {
        let width = $(window).width();
        let left_menu = $('.left-menu');

        if(width < 768){
            log_side.stop().animate({left:'-200px'},300);
            layui_body.stop().animate({left:'0px'},300);
            left.stop().animate({left:'0px'},300,'',function(){
                left_menu.attr('action','right');
                let i = left_menu.find('i');
                i.removeClass('layui-icon-shrink-right');
                i.addClass('layui-icon-spread-left');
                i.parent('a').attr('title','右伸缩菜单');
            });
        }else{
            log_side.stop().animate({left:'0px'},300);
            layui_body.stop().animate({left:'200px'},300);
            right.css({left:'unset','min-width':'unset'});
            left.css({'min-width':'unset'});
            left.stop().animate({left:'200px'},300,'',function(){
                left_menu.attr('action','left');
                let i = left_menu.find('i');
                i.addClass('layui-icon-shrink-right');
                i.removeClass('layui-icon-spread-left');
                i.parent('a').attr('title','左伸缩菜单');
            });
        }
    }
    ressizeWdith();

    $('.index-column-url').on('click',function(){
        let $this = $(this);
        let url = $this.attr('url');
        if(url != null && url != ''){
            bodyUrl(url);
        }
        return false;
    });



    /*
    * 请求页面替换
    * @parat string 传入相关的url地址
    * */
    function bodyUrl(url)
    {
        let shortURL = top.location.href.substring(0,top.location.href.indexOf('#'));
        history.replaceState(null,null,shortURL+'#'+url);
        $.Public.ajax({
            url:$.Public.url+url.substr(1,url.length),
            type:'POST',
            data:'',
            load:function(msg){
                if ($.Public.json(msg) == true) {
                    let msgData = JSON.parse(msg);
                    if(msgData.code == 404){  //没权限
                        layer.msg(msgData.msg,{icon:2,time:1500});
                    }else if(msgData.code == 500){ //没登录
                        layer.msg('请先登录！',{icon:2,time:1500},function(){
                            window.location.href = msgData.url;
                        });
                    }else if(msgData.code == 502) { //完全没有权限
                        layer.msg(msgData.msg, {icon: 2, time: 1500}, function () {
                            window.history.go(-1);
                        });
                    }
                }else{
                    layui_body.html(msg);
                    form.render();

                }
            }
        });
    }
    //defaultUrl
    $('.refresh').on('click',function(){
        locationHref();
    });
    //获取当前URL地址并修改
    function locationHref()
    {
        let locationHref = window.location.href.split('#');
        if(locationHref.length > 1){
            bodyUrl(locationHref[1]);
        }else{
            bodyUrl(defaultUrl);
        }
    }
    locationHref();

    //当前栏目选择事件
    var columnHref = window.location.href.split('#');
    var columnData = defaultUrl;
    $('.index-column-url').each(function(){
        if(columnHref.length > 1){
            columnData = columnHref[1];
        }
        let $this = $(this);
        let url = $this.attr('url');
        if(url != ''){
            if($this.attr('url') == columnData){
                $this.addClass('layui-this');
                //判断父级
                let parent = $this.parent('dd');
                if(parent.length > 0){
                    parent.addClass('layui-nav-itemed');
                    parent.parent('dl').parent('li').addClass('layui-nav-itemed');
                }else{
                    $this.parent('dl').parent('li').addClass('layui-nav-itemed');
                }
                return false;
            }
        }

    });
})


