<?php

class Model_Util_Date
{
    public function checkDate($date)
    {
        if(empty($date))
            return false;

        try{
            $value = new DateTime($date);

            $result = true;
        }
        catch(Exception $e){
            $result = false;
        }

        return $result;
    }

    public function getFirstMonthDate()
    {
        $date = new DateTime();
        $date->setDate(Date("Y"), Date("m"), 1);

        return ($date->format('Y-m-d'));

    }

    public function getLastMonthDate()
    {
        $date = new DateTime();
        $date->setDate(Date("Y"), Date("m"), 1)
             ->add(new DateInterval("P1M"))
             ->sub(new DateInterval("P1D"));

        return ($date->format('Y-m-d'));
    }

}