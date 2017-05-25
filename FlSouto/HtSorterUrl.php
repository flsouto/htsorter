<?php
namespace FlSouto;

class HtSorterUrl{

    protected $sorter;
    protected $baseurl;

    function __construct(HtSorter $sorter){
        $this->sorter = $sorter;
        $this->baseurl = '?';
    }

    function base($baseurl){
        if(!strstr($baseurl,'?')){
            $baseurl .= '?';
        }
        $this->baseurl = $baseurl;
        return $this;
    }

    function build($column, $order){
        return $this->baseurl . '&' . $this->sorter->name() . '=' . $column . ' ' . $order;
    }

    function toggle($column, $fallback='asc'){
        $command = $this->sorter->command();
        if($command['column']==$column){
            $command['order'] = $command['order']=='asc' ? 'desc' : 'asc';
        } else {
            $command['column'] = $column;
            $command['order'] = $fallback;
        }
        return $this->build($command['column'],$command['order']);
    }

    function asc($column){
        return $this->build($column,'asc');
    }

    function desc($column){
        return $this->build($column,'desc');
    }

}