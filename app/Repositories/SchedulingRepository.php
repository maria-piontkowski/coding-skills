<?php

namespace App\Repositories;

use App\Models\Scheduling;

class SchedulingRepository
{
    /**
     * @var array<Scheduling>
     * @throws \Exception
     */
    private array $items = [];
    
    public function createMany($values) : void {
        
        foreach ($values as $value) {
            $this->create($value);
        }
    }
    
    public function create($data) : Scheduling {
    
        $apartmentId = $data['apartment_id'];
        $personId = $data['person_id'];
        $date = $data['date'];
    
        if(!$this->isDateAvailable($date, $apartmentId))
            throw new \Exception("Já existe uma visita agendada para o apartamento {$apartmentId} em {$date->format('d/m/Y H:i')}");
        
        $scheduling = new Scheduling($apartmentId, $personId, $date);
    
        $this->add($scheduling);
        
        return $scheduling;
    }
    
    private function isDateAvailable(\DateTime $date, $apartmentId) : bool {
        
        $isDateAvailable = array_filter(
            $this->items,
            fn ($item) => $item->getDate() == $date && $apartmentId == $item->getApartmentId()
        );
        
        return count($isDateAvailable) == 0;
    }
    
    public function getByCode($code) : Scheduling {
        
        if(!isset($this->items[$code]))
            throw new \Exception("Agendamento {$code} não existe");
        
        return $this->items[$code];
    }
    
    public function cancel($code) : void {
        if($this->getByCode($code)->isFinished())
            throw new \Exception("Erro ao cancelar {$code}: Agendamento está finalizado.");
        
        $this->getByCode($code)->setIsCancelled(true);
    }
    
    public function finish($code) : void {
        if($this->getByCode($code)->isCancelled())
            throw new \Exception("Erro ao finalizar {$code}: Agendamento está cancelado.");
        
        $this->getByCode($code)->setIsFinished(true);
    }
    
    public function add(Scheduling $scheduling) : void {
        $this->items[$scheduling->getCode()] = $scheduling;
    }
    
    public function remove($code) : void {
        unset( $this->items[$code]);
    }
    
    public function get() : array {
        return $this->items;
    }
    
    public function getRandCode() : string {
        if(!count($this->items))
            throw new \Exception("Nenhuma visita agendada");
            
        return array_rand($this->items);
    }
    
}
