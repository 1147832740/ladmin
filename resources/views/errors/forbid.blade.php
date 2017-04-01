@extends('admin.main')

@section('meta')
@parent
<meta name="_token" content="{{ csrf_token() }}"/>
@endsection

@section('title')
@parent
@endsection

@section('header')
@parent
@endsection

@section('menu')
@parent
@show

@section('content')
<section class="Hui-article-box">
    <nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><span class="c-666">空白页</span></nav>
    <div class="Hui-article">
        <article class="cl pd-20">
            <section class="page-404 minWP text-c">
                <p class="error-title"><i class="Hui-iconfont va-m" style="font-size:80px">&#xe656;</i><span class="va-m"> Forbid</span></p>
                <p class="error-description">您没有权限~</p>
                <p class="error-info">您可以：<a href="javascript:;" onclick="history.go(-1)" class="c-primary">&lt; 返回上一页</a><span class="ml-20">|</span><a href="/" class="c-primary ml-20">去首页 &gt;</a></p>
            </section>
        </article>
    </div>
</section>
@endsection

@section('footer')
@parent
@endsection

@section('javascript')
<!--请在下方写此页面业务相关的脚本-->

<!--/请在上方写此页面业务相关的脚本-->
@endsection