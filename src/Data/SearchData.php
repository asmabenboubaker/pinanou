<?php
namespace App\Data;
class SearchData{




    /**
     * @var string 
     */
    public $q='';
    public $categories =[];
    /**
     * @var null|integer
     */
    public $max;
    /**
     * @var null|integer
     */
    public $min;
    /**
     * @var boolean
     */
    public $promo=false;
}