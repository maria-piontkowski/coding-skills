<?php

namespace App\Factories;

class SchedulingFactory
{
    public static function make($count = 1): array
    {
        $factory = [];
        
        for($i = 1; $i <= $count; $i++) {
            $factory[] = [
                'apartment_id' => fake()->randomNumber(),
                'person_id' => fake()->randomNumber(),
                'date' => fake()->dateTime()
            ];
        }
        
        return $factory;
    }
    
    public static function makeDuplicated($count = 1): array
    {
        $factory = [];
        
        $apartmentId = fake()->randomNumber();
        $date = fake()->dateTime();
        
        for($i = 1; $i <= $count; $i++) {
            $factory[] = [
                'apartment_id' => $apartmentId,
                'person_id' => fake()->randomNumber(),
                'date' => $date
            ];
        }
        
        return $factory;
    }
    
}
