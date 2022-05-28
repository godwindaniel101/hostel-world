<?php

namespace App\Repository;

use App\Models\Event;
use App\Utilities\Helpers;
use App\Traits\ResponseTrait;
use App\Repository\EventInterface;

class EventRepository implements EventInterface
{
    use ResponseTrait;

    protected $model;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function eventsFromDB($request)
    {
        $date =  $request->date;
        $term = $request->term;
        $event = $this->model->select();
        //check if date is in the payload params
        if (!isEmpty($date)) {
            $event = $event->whereDate('startDate', '=',  $date);
        }
        //check if term is in the payload params
        if (!isEmpty($term)) {
            $event = $event->where(function ($q) use ($term) {
                $q->where('city', 'like', '%' . $term . '%')
                    ->orWhere('country', 'like', '%' . $term . '%');
            });
        } // filter by term

        $events = $event->paginate(20);
        $this->log($request, 'Succesfully Called Events');
        return $this->response(true, $events, 'Events called successfully.', 200);
    }
    public function eventsFromJSON($request)
    {
        $events = get_storage_file("/json/data.json");
        $date =  $request->date;
        $term = $request->term;
        $page = $request->page ?? 1;

        $events = collect($events)->filter(function ($event) use ($date, $term) {

         //check if date of term is in the payload params
            if (!isEmpty($date) || !isEmpty($term)) {
                return $this->filterEvent($term, $event, $date);
            }
            return true;
        }); //filter collection

        $events = (new Helpers())->paginate(extractValues($events), $page); //paginate collection
        $this->log($request, 'Succesfully Called Events');
        return $this->response(true, $events, 'Events called successfully.', 200);
    }
    
    private function filterEvent($term, $event, $date)
    {

        //check if date and termis in the payload params
        if (!empty($term) && !empty($date)) {
            return ($event['startDate'] == $date) &&
                (isMatch($event['city'], $term) || isMatch($event['country'], $term));
        }

        //check if term is in the payload params
        return (isMatch($event['city'], $term) ||
            isMatch($event['country'], $term));
    }
}
