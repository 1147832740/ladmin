<!DOCTYPE html>
<html lang="en" class="no-js">

    <head>

        <meta charset="utf-8">
        <title>管理后台 - 登录</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- CSS -->
        <link rel='stylesheet' href="{{asset('/admin_static/login/css/css.css')}}">
        <link rel="stylesheet" href="{{asset('/admin_static/login/css/reset.css')}}">
        <link rel="stylesheet" href="{{asset('/admin_static/login/css/supersized.css')}}">
        <link rel="stylesheet" href="{{asset('/admin_static/login/css/style.css')}}">
        
        <link rel="stylesheet" type="text/css" href="{{asset('/admin_static/lib/Hui-iconfont/1.0.8/iconfont.css')}}" />

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <style>
            form>span{
                display: inline-block;
                background: rgba(45,45,45,.5);
                border-radius: 10px;
                margin-top: 10px;
                padding: 5px 15px;
                float: left;
                color: #FFF;
                font-size: 15px;
                font-family: '微软雅黑';
            }
        </style>
    </head>

    <body>

        <div class="page-container">
            <h1>Login</h1>
            <form action="{{ adm_url('login') }}" method="post">
                <input type="text" name="username" id='username' class="username" placeholder="Username" value="{{ old('username') }}"><br />
                <input type="password" name="password" class="password" placeholder="Password" value="">
                @if (!empty($errors->all()))<span><i class="Hui-iconfont" style="color:red;font-weight: bolder;">&#xe6a6;</i> 用户名或密码错误</span>@endif
                {{ csrf_field() }}
                <button type="submit">登录</button>
                <div class="error" ><span style="float: left;">+</span><font style="line-height: 40px; font-size:15px; font-family: '微软雅黑'">用户名不能为空</font></div>
            </form>
            <div class="connect">
                <p>其他登录方式：</p>
                <p>
                    <a class="facebook" href="" title="facebook"></a>
                    <a class="twitter" href="" title="twitter"></a>
                </p>
            </div>
        </div>
        <div align="center">Make in SJD</div>

        <!-- Javascript -->
        <script src="{{asset('/admin_static/login/js/jquery-1.8.2.min.js')}}"></script>
        <script src="{{asset('/admin_static/login/js/supersized.3.2.7.min.js')}}"></script>
        <script src="{{asset('/admin_static/login/js/supersized-init.js')}}"></script>
        <script src="{{asset('/admin_static/login/js/scripts.js')}}"></script>

    </body>

</html>
<script>
window.onload=function(){
    document.getElementById('username').focus();
}
</script>

