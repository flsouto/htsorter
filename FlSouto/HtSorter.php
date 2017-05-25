<?php
namespace FlSouto;

class HtSorter{

    protected $name = '';
    protected $context = [];
    protected $data = [];
    protected $sorters = [];
    protected $baseurl = '';
    protected $fallback = '';
    protected $url = null;

    function __construct($name, $fallback=''){
        $this->name = $name;
        $this->fallback = $fallback;
        $this->sorters['*'] = function($a,$b,$order){
            return $order == 'asc' ? $a > $b : $b < $a;
        };

    }

    function name(){
        return $this->name;
    }

    function url(){
        if(is_null($this->url)){
            $this->url = new HtSorterUrl($this);
        }
        return $this->url;
    }

    function fallback($fallback){
        $this->fallback = $fallback;
        return $this;
    }

    function context(array $context){
        $this->context = $context;
        return $this;
    }

    function data(array& $data){
        $this->data =& $data;
        return $this;
    }

    function custom($column, $sorter){
        $this->sorters[$column] = $sorter;
        return $this;
    }

    protected function sort($column, $order){
        $sorter = isset($this->sorters[$column]) ? $this->sorters[$column] : $this->sorters['*'];
        uasort($this->data,function($ra, $rb) use ($sorter, $column, $order){
            $a = null;
            $b = null;
            if(isset($ra[$column])){
                $a = $ra[$column];
            }
            if(isset($rb[$column])){
                $b = $rb[$column];
            }
            return $sorter($a,$b,$order);
        });
    }

    function command(){
        $value = $this->fallback;
        if(!empty($this->context[$this->name])){
            $value = $this->context[$this->name];
        }
        if($value){
            $parts = explode(' ', $value);
            $column = $parts[0];
            $order = isset($parts[1]) ? $parts[1] : 'asc';
            if(!in_array($order,['asc','desc'])){
                $order = 'asc';
            }
            return [
                'column' => $column,
                'order' => $order
            ];
        }
        return false;
    }

    function process(){
        if($command = $this->command()){
            $this->sort($command['column'], $command['order']);
        }
        return $this;
    }

}