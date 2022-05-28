<?php

namespace App\Http\Controllers\Api;

use App\Repository\EventInterface;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Api\BaseController;

class EventController extends BaseController
{
    public function __construct(EventInterface $eventInterface)
    {
        $this->event = $eventInterface;
    }
    /**
     * @OA\Get(
     * path="/api/events",
     * security={{ "token": {} }},
     * summary="Get Events from DB",
     * description="Get seeded events from database (with valid dates)",
     * operationId="EventFromDB",
     * tags={"Events"},
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
     *              @OA\Property(
     *                  property="current_page", 
     *                  type="integer", 
     *                  example="1"
     *                  ),
     *              @OA\Property(
     *                  property="data", 
     *                  type="array", 
     *                      @OA\Items( ref="#/components/schemas/Event"),)
     *                  ),
     *              @OA\Property(
     *                  property="next_page_url", 
     *                   type="string",  
     *                   format="email", 
     *                   description="User unique email address", 
     *                   example="user@gmail.com"
     *                   ),
     *              @OA\Property(
     *                   property="path", 
     *                   type="string", 
     *                   description="next page url", 
     *                   example="http://localhost:8001/api/events"
     *                   ),
     *              @OA\Property(
     *                   property="per_page", 
     *                   type="string", 
     *                   description="number of result per page", 
     *                   example="20"
     *                   ),
     *              @OA\Property(
     *                   property="prev_page_url", 
     *                   type="string", 
     *                   description="previous page url",  
     *                   example="null"
     *                   ),
     *              @OA\Property(
     *                   property="to", type="string", 
     *                   description="item count", 
     *                   example="null"
     *                   ),
     *              @OA\Property(
     *                   property="total", 
     *                   type="string", 
     *                   description="total record count",  
     *                   example="null"
     *                   ),
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

    public function eventsFromDB(EventRequest $request)
    {
        $res= $this->event->eventsFromDB($request);
        return $this->formatResponse($res);
    }
    /**
     * @OA\Get(
     * path="/api/events_json",
     * security={{ "token": {} }},
     * summary="Get Events From JSON",
     * description="Get Events from JSON file with intended data intact",
     * operationId="EventFromJSON",
     * tags={"Events"},
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
     *              @OA\Property(
     *                  property="current_page", 
     *                  type="integer", 
     *                  example="1"
     *                  ),
     *              @OA\Property(
     *                  property="data", 
     *                  type="array", 
     *                      @OA\Items( ref="#/components/schemas/Event"),)
     *                  ),
     *              @OA\Property(
     *                  property="next_page_url", 
     *                   type="string",  
     *                   format="email", 
     *                   description="User unique email address", 
     *                   example="user@gmail.com"
     *                   ),
     *              @OA\Property(
     *                   property="path", 
     *                   type="string", 
     *                   description="next page url", 
     *                   example="http://localhost:8001/api/events"
     *                   ),
     *              @OA\Property(
     *                   property="per_page", 
     *                   type="string", 
     *                   description="number of result per page", 
     *                   example="20"
     *                   ),
     *              @OA\Property(
     *                   property="prev_page_url", 
     *                   type="string", 
     *                   description="previous page url",  
     *                   example="null"
     *                   ),
     *              @OA\Property(
     *                   property="to", type="string", 
     *                   description="item count", 
     *                   example="null"
     *                   ),
     *              @OA\Property(
     *                   property="total", 
     *                   type="string", 
     *                   description="total record count",  
     *                   example="null"
     *                   ),
     *              ),
     *         @OA\Property(
     *              property="message", 
     *              type="string", 
     *              example="User logged out successfully."
     *              ),
     *        )
     *     ),
     *     ),
     */
    public function eventsFromJSON(EventRequest $request)
    {
        $res = $this->event->eventsFromJSON($request);
        return $this->formatResponse($res);
    }
}
