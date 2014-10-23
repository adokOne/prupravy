<?php
class geometry {

    public static function render($geometry, $type)
    {
        if ($type == 'polygon')
            $geometry = explode(',', substr($geometry, 9, -2));
        elseif ($type == 'linestring')
            $geometry = explode(',', substr($geometry, 11, -1));
        elseif ($type == 'multilinestring')
            $geometry = explode(',', substr($geometry, 17, -2));
            
        foreach ($geometry as $k => $c)
            $geometry[$k] = explode(' ', $c);
            
        return $geometry;
    }

}