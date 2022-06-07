<?php

namespace app\v1\model;

use think\Model;

class User extends Model
{
    protected $table = 'yf_user';
    protected $pk = 'uid';
    protected $user;
}
