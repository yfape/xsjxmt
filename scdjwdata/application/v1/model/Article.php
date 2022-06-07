<?php

namespace app\v1\model;

use think\Model;

class Article extends Model
{
    protected $table = 'yf_article';
    protected $pk = 'aid';
    protected $artcle;
}
