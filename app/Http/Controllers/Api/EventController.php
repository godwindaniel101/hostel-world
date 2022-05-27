<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Utilities\Helpers;
use Illuminate\Support\Carbon;
use App\Http\Requests\EventRequest;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Pagination\LengthAwarePaginator;

class EventController extends BaseController
{
    public function index(EventRequest $request)
    {
        $event = Event::query();
        $date =  $request->date;
        $term = $request->term;

        if (!isEmpty($date)) {
            $event = $event->whereDate('startDate', $date);
        } //search by date

        if (!isEmpty($term)) {
            $event = $event->where('city', 'like', '%' . $term . '%')
                ->orWhere('country', 'like', '%' . $term . '%');
        } // filter by term

        $event = $event->paginate(20);
        $this->log($request, 'Succesfully Called Events');
        return $this->sendResponse($event, 'Events called successfully.');
    }

    public function indexTwo(EventRequest $request)
    {
        $events = get_storage_file("/json/data.json");
        $date =  $request->date;
        $term = $request->term;
        $page = $request->page ?? 1;

        $events = collect($events)->filter(function ($event) use ($date, $term) {
            if (!isEmpty($date) || !isEmpty($term)) {
                return $this->filterEvent($term, $event, $date);
            }
            return true;
        });//filter collection

        $events = (new Helpers())->paginate(extractValues($events), $page); //paginate collection
        $this->log($request, 'Succesfully Called Events');
        return $this->sendResponse($events, 'Events called successfully.');
    }

    private function filterEvent($term, $event, $date)
    {
        if (!empty($term) && !empty($date)) {
            return ($event['startDate'] == $date) &&
                (isMatch($event['city'], $term) ||
                    isMatch($event['country'], $term));
        }
        return (isMatch($event['city'], $term) ||
            isMatch($event['country'], $term));
    }
}
