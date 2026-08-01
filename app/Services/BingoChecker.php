<?php

namespace App\Services;

class BingoChecker
{

    public static function check($card, $drawnNumbers, $pattern)
    {

        $drawnNumbers = array_map('intval',$drawnNumbers);


        // convert FREE
        foreach($card as $r=>$row){

            foreach($row as $c=>$value){

                if($value === "FREE"){
                    $card[$r][$c] = 0;
                }

            }

        }



        switch($pattern){


            case 'horizontal':

                foreach($card as $row){

                    $count=0;

                    foreach($row as $num){

                        if($num==0 || in_array((int)$num,$drawnNumbers)){
                            $count++;
                        }

                    }


                    if($count==5){
                        return true;
                    }

                }

            break;



            case 'vertical':

                for($c=0;$c<5;$c++){

                    $count=0;

                    for($r=0;$r<5;$r++){

                        $num=$card[$r][$c];


                        if($num==0 || in_array((int)$num,$drawnNumbers)){
                            $count++;
                        }

                    }


                    if($count==5){
                        return true;
                    }

                }

            break;



            case 'diagonal':


                $count=0;


                for($i=0;$i<5;$i++){

                    $num=$card[$i][$i];


                    if($num==0 || in_array((int)$num,$drawnNumbers)){
                        $count++;
                    }

                }


                if($count==5){
                    return true;
                }



                $count=0;


                for($i=0;$i<5;$i++){

                    $num=$card[$i][4-$i];


                    if($num==0 || in_array((int)$num,$drawnNumbers)){
                        $count++;
                    }

                }


                if($count==5){
                    return true;
                }

            break;



            case 'four_corners':

                $corners=[

                    $card[0][0],
                    $card[0][4],
                    $card[4][0],
                    $card[4][4]

                ];


                foreach($corners as $num){

                    if(!in_array((int)$num,$drawnNumbers)){
                        return false;
                    }

                }


                return true;



            case 'full_house':

                foreach($card as $row){

                    foreach($row as $num){

                        if(
                            $num!=0 &&
                            !in_array((int)$num,$drawnNumbers)
                        ){

                            return false;

                        }

                    }

                }


                return true;

        }


        return false;

    }

}