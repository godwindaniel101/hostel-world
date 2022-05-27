<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Utilities\Helpers;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Api\BaseController;

class EventController extends BaseController
{
    /**
     * @OA\Get(
     * path="/api/events",
     * security={{ "token": {} }},
     * summary="Get Events",
     * description="Note : thiis endpoint has the date changed. to allow for testing of date",
     * operationId="getEvents",
     * tags={"events"},
     * @OA\Parameter(
     *         name="term",
     *         in="query",
     *         description="Search by city and country",
     *      ),
     * @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Filter by exact date",
     *      ),
     * @OA\Response(
     *    response=200,
     *    description="Get array of events",
     *    @OA\JsonContent(
     *         @OA\Property(
     *              property="success", 
     *               type="boolean" , 
     *               default="true"
     *              ),
     *         @OA\Property(
     *              property="data", 
     *              type="object", 
     *              @OA\Property(property="current_page", type="integer", example="1"),
     *              @OA\Property(
     *                          property="data", 
     *                          type="array", 
     *                              @OA\Items( ref="#/components/schemas/Event"),)
     *                          ),
     *              @OA\Property(property="next_page_url", type="string",  format="email", description="User unique email address", example="user@gmail.com"),
     *              @OA\Property(property="path", type="string", description="next page url", example="http://localhost:8001/api/events"),
     *              @OA\Property(property="per_page", type="string", description="number of result per page", example="20"),
     *              @OA\Property(property="prev_page_url", type="string", description="previous page url",  example="null"),
     *              @OA\Property(property="to", type="string", description="item count",  example="null"),
     *              @OA\Property(property="total", type="string", description="total record count",  example="null"),
     *              ),
     *         @OA\Property(
     *              property="message", 
     *              type="string", 
     *              example="User logged out successfully."
     *              ),
     *        )
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Unathenticated logout attempt",
     *    @OA\JsonContent(
     *         @OA\Property(
     *              property="success", 
     *              type="boolean" , 
     *              default="false"
     *              ),
     *         @OA\Property(
     *              property="data", 
     *              type="object", 
     *              default="null"
     *              ),
     *         @OA\Property(
     *              property="message", 
     *              type="string", 
     *              example="Unauthenticated."
     *              ),
     *        )
     *     )
     * 
     * )
     */

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
    /**
     * @OA\Get(
     * path="/api/events_v2",
     * security={{ "token": {} }},
     * summary="Get Events V2",
     * description="Note : thiis endpoint has the date changed. to allow for testing of date",
     * operationId="getEventsV2",
     * tags={"events"},
     * @OA\Parameter(
     *         name="term",
     *         in="query",
     *         description="Search by city and country",
     *      ),
     * @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Filter by exact date",
     *      ),
     * @OA\Response(
     *    response=200,
     *    description="Get array of events",
     *    @OA\JsonContent(
     *         @OA\Property(
     *              property="success", 
     *               type="boolean" , 
     *               default="true"
     *              ),
     *         @OA\Property(
     *              property="data", 
     *              type="object", 
     *              @OA\Property(property="current_page", type="integer", example="1"),
     *              @OA\Property(
     *                          property="data", 
     *                          type="array", 
     *                              @OA\Items( ref="#/components/schemas/Event"),)
     *                          ),
     *              @OA\Property(property="next_page_url", type="string",  format="email", description="User unique email address", example="user@gmail.com"),
     *              @OA\Property(property="path", type="string", description="next page url", example="http://localhost:8001/api/events"),
     *              @OA\Property(property="per_page", type="string", description="number of result per page", example="20"),
     *              @OA\Property(property="prev_page_url", type="string", description="previous page url",  example="null"),
     *              @OA\Property(property="to", type="string", description="item count",  example="null"),
     *              @OA\Property(property="total", type="string", description="total record count",  example="null"),
     *              ),
     *         @OA\Property(
     *              property="message", 
     *              type="string", 
     *              example="User logged out successfully."
     *              ),
     *        )
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Unathenticated logout attempt",
     *    @OA\JsonContent(
     *         @OA\Property(
     *              property="success", 
     *              type="boolean" , 
     *              default="false"
     *              ),
     *         @OA\Property(
     *              property="data", 
     *              type="object", 
     *              default="null"
     *              ),
     *         @OA\Property(
     *              property="message", 
     *              type="string", 
     *              example="Unauthenticated."
     *              ),
     *        )
     *     )
     * 
     * )
     */
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
        }); //filter collection

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
