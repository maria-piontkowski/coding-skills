<?php

namespace App\Console\Commands;

use App\Factories\SchedulingFactory;
use App\Models\Scheduling;
use App\Repositories\SchedulingRepository;
use Illuminate\Console\Command;

class RunScript extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-script';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $repository = new SchedulingRepository();
    
        $this->createSchedule($repository);
        $this->cancelSchedule($repository);
        $this->finishSchedule($repository);
        $this->listSchedule($repository);
    }
    
    private function createSchedule(SchedulingRepository $repository) : void {
        
        $fakeScheduling = SchedulingFactory::make(3);
    
        foreach ($fakeScheduling as $fake) {
            try {
                $scheduling = $repository->create($fake);
            
                $this->info("Visita código {$scheduling->getCode()} agendada com sucesso: Apartamento {$scheduling->getApartmentId()} em {$scheduling->getDate()->format('d/m/Y H:i')}");
            
            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
            }
        }
    }
    
    private function cancelSchedule(SchedulingRepository $repository) : void {
    
        try {
            $randCode = $repository->getRandCode();
            $repository->cancel($randCode);
    
            $this->info("Visita código {$randCode} cancelada com sucesso");
        
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
       
    }
    
    private function finishSchedule(SchedulingRepository $repository) : void {
        try {
            $randCode = $repository->getRandCode();
            $repository->finish($randCode);
            
            $this->info("Visita código {$randCode} finalizada com sucesso");
            
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
    
    private function listSchedule(SchedulingRepository $repository) : void {
    
        try {
            $list = array_map(fn ($item) => $item->toString(), $repository->get());
    
            $this->info("\nListagem das visitas agendadas: \n" . implode("\n", $list));
        
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
       
    }
}
