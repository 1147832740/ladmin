<?php

/* -----------------------   公共函数文件   ------------------------*/

function adm_url($uri='',$parameter=array())
{
    return url('/admin/'.$uri,$parameter);
}