
layui.use(['form', 'layedit', 'laydate'], function () {
    var form = layui.form
        , layer = layui.layer
        , layedit = layui.layedit
        , laydate = layui.laydate;
    $.Public.tooltip();

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
    //
    /*
    * 请求页面替换
    * @parat string 传入相关的url地址
    * */
    function bodyUrl(url)
    {
        let shortURL = top.location.href.substring(0,top.location.href.indexOf('#'));
        history.replaceState(null,null,shortURL+'#/'+url);
        $.Public.ajax({
            url:$.Public.url+url,
            type:'POST',
            data:'',
            load:function(msg){
                console.info(msg);
                layui_body.html(msg);
            }
        });
    }

})


