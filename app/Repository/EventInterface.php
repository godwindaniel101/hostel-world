<?php
namespace App\Repository;

use App\Http\Requests\EventRequest;

interface EventInterface 
{
    public function eventsFromDB(EventRequest $request);
    public function eventsFromJSON(EventRequest $request);
}