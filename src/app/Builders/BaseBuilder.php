<?php

namespace TodoApp\app\Builders;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseBuilder
{
    /** @var Builder */
    protected $model;
    protected $page = 1;


    public function get(){
        return $this->model->paginate(25, ['*'], 'page', $this->page);
    }

    public function select($select=['*']){
        $this->model->select($select);
        return $this;
    }

    public function page($page=null){
        if (!is_null($page)){
            $this->page = null;
        }

        return $this;
    }

    public function order($orderBy='id', $orderType='desc'){
        $this->model->orderBy($orderBy ?? 'id', $orderType ?? 'desc');
        return $this;
    }

    public static function make(){
        return new static();
    }
}
