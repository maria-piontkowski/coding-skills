<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scheduling
{
    use HasFactory;
    
    private string $code;
    
    private int $apartmentId;
    
    private int $personId;
    
    private bool $isCancelled = false;
    
    private bool $isFinished = false;
    
    private \DateTime $date;
    
    /**
     * Scheduling constructor.
     * @param int $apartmentId
     * @param int $personId
     * @param \DateTime $date
     */
    public function __construct(int $apartmentId, int $personId, \DateTime $date)
    {
        $this->apartmentId = $apartmentId;
        $this->personId = $personId;
        $this->date = $date;
        
        $this->setCode();
    }
    
    public function getCode(): string
    {
        return $this->code;
    }
    
    private function setCode() : void {
        $this->code = $this->apartmentId . $this->date->format('YmdHis');
    }
    
    public function getApartmentId(): int
    {
        return $this->apartmentId;
    }
    
    public function getPersonId(): int
    {
        return $this->personId;
    }
    
    public function getDate(): \DateTime
    {
        return $this->date;
    }
    
    public function isCancelled(): bool
    {
        return $this->isCancelled;
    }
    
    public function setIsCancelled(bool $isCancelled): void
    {
        $this->isCancelled = $isCancelled;
    }
    
    public function isFinished(): bool
    {
        return $this->isFinished;
    }
    
    public function setIsFinished(bool $isFinished): void
    {
        $this->isFinished = $isFinished;
    }
    
    public function toString() {
        return "Código: {$this->getCode()} | Apartmento: {$this->getApartmentId()} | Pessoa : {$this->getPersonId()} | " .
                "Data: {$this->getDate()->format('d/m/Y H:i')} | Cancelado : {$this->isCancelled()} | Finalizado: {$this->isFinished()}";
    }
    
}
