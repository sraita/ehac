<?php

function sinasegment($str)
{
    $seg = new SaeSegment();
    $ret = $seg->segment($str, 1);
    echo count($ret);
    if ($ret === false){
        return;
    }
    $category = "";
    $keyword = "";
    foreach ($ret as $key => $value) {  
    switch(count($ret))
    {
		case 5:
        if ($value["word_tag"]==95){
             $last =  $value["word"];
             $num = $value["index"]-1;
            if($value["index"] ==2&&$value["index"]!=$num){
                $a =  $value["word"];
            }
            if($value["index"] ==3&&$value["index"]!=$num){
                $b =  $value["word"];
            }
           $category  =$a.$b.$last;
          }
         break; 
         case 3:
         if ($value["word_tag"]==95){
             $last =  $value["word"];
             $num = $value["index"]-1;
            if($value["index"] ==1&&$value["index"]!=$num){
                $a =  $value["word"];
            }
           $category  =$a.$b.$last;
          }
         break; 
         case 2:
         if ($value["word_tag"]==95){
           $category  = $value["word"];
          }
         break; 
         }
        
        if ($value["word_tag"] == 172){
            $keyword = $value["word"];
        }
        if ($value["word_tag"] == 170){
            $keyword = $value["word"];
        }
        
    }
    if (!empty($category) && !empty($keyword)){
        return array('category'=>$category,'keyword'=>$keyword); 
    }else{
        return;
    }
}
?>