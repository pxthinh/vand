<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlgorithmController extends Controller
{
    public function Algorithm(){
        $arrays=['A', 'B', 'C', 'D', 'E', 'F', 'G','H'];
        $a=[];
        $b=[];
        $c=[];
        $list=['a', 'b', 'c'];
        foreach($arrays as $array){
            $arr=$list[rand(0,2)];
            if($arr=='a'){
                array_push($a,$array);
            }
            if($arr=='b'){
                array_push($b,$array);
            }
            if($arr=='c'){
                array_push($c,$array);
            }
        }
        $countA=count($a);
        $countB=count($b);
        $countC=count($c);
        if( $countA==$countB || $countA == $countC || $countC == $countB){
          if(abs( $countA-$countB) ==1||abs( $countA-$countC)==1 || abs($countB-$countB) == 1){
            return $countA." ".$countB." ".$countC.' OK'.' divided equally';
          }
        }
        return $countA." ".$countB." ".$countC.' NG:'.' divided unequally';
    }
}
