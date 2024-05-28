<?php

use Illuminate\Support\Str;
use App\Models\Scheduling;
use App\Factories\SchedulingFactory;
use App\Repositories\SchedulingRepository;

it('creates apartment visit', function () {
    $factory = SchedulingFactory::make(5);
    $repository = new SchedulingRepository();
    
    foreach ($factory as $scheduling) {
        expect($repository->create($scheduling))->toBeInstanceOf(Scheduling::class);
    }
    
    expect($repository->get())->toBeArray();
    expect(count($repository->get()))->toBeGreaterThan(0);
});


it('creates multiple visit', function () {
    $factory = SchedulingFactory::make(5);
    $repository = new SchedulingRepository();
    $repository->createMany($factory);
    
    expect($repository->get())->toBeArray();
    expect(count($repository->get()))->toBeGreaterThan(0);
});


it('creates duplicated apartment visit', function () {
    $factory = SchedulingFactory::makeDuplicated(2);
    $repository = new SchedulingRepository();
    
    foreach ($factory as $scheduling) {
        $repository->create($scheduling);
    }
})->throws(Exception::class);


it('cancels unexisting scheduling', function () {
    $repository = new SchedulingRepository();
    $repository->cancel(Str::random(5));
})->throws(Exception::class);


it('cancels finished scheduling', function () {
    $repository = new SchedulingRepository();
    $factory = SchedulingFactory::make(1)[0];
    
    $scheduling = $repository->create($factory);
    $scheduling->setIsFinished(true);
    
    $repository->cancel($scheduling->getCode());
})->throws(Exception::class);


it('finishes nonexistent scheduling', function () {
    $repository = new SchedulingRepository();
    $repository->finish(Str::random(5));
})->throws(Exception::class);


it('finishes cancelled scheduling', function () {
    $repository = new SchedulingRepository();
    $factory = SchedulingFactory::make(1)[0];
    
    $scheduling = $repository->create($factory);
    $scheduling->setIsCancelled(true);
    
    $repository->finish($scheduling->getCode());
})->throws(Exception::class);
