## Coding Skills

Creates a pretty basic scheduling system that only stores the data in execution time, without saving in any database.
This application uses [Laravel](https://laravel.com), but it could be developed without any framework due its simplicity.

___
  
#### Features

- Create a schedule
- Remove a schedule
- Cancel a schedule
- Finish a schedule
- Prints the result.

___
 
#### Fields

The fields of a Scheduling:

- `code` - Unique auto generated field
- `apartmentId` - Reference to the apartment to be visited
- `personId` - Reference to the person to be visiting
- `date` - Reference to the date of the visit
- `isCancelled` - Indicates whether the schedule was cancelled
- `isFinished` - Indicates whether the schedule was finished
 
___

### Architecture

1. `App\Models\Scheduling` is the class/model with all schedule fields and methods.
2. `App\Factories\SchedulingFactory` generates fake/random records.
3. `App\Repositories\SchedulingRepository` provides CRUD operations.  

____

### Getting Start

1. Configure your environment according to [Laravel Documentation](https://laravel.com/docs/11.x/configuration) if necessary.
2. Run `php artisan app:run-script` to generate, cancel and finish some schedules.

____

### Tests

1. This application uses [Pest](https://pestphp.com/) testing framework.
2. Run `php artisan test` if you want to execute the unit tests.
