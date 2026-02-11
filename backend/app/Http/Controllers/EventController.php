<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\ListEventsRequest;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Resources\Event\EventResource;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\JsonApi\AnonymousResourceCollection;

class EventController extends Controller
{
    public function __construct(private EventService $eventService) {}

    public function index(ListEventsRequest $request): JsonResponse {
        $events = $this->eventService->list(
            $request->user(),
            $request->validated()['from'],
            $request->validated()['to']
        );

        return response()->json([
            'message' => 'Successfully fetched the list of events',
            'events' => EventResource::collection($events)
        ]);
    }

    public function store(StoreEventRequest $request): JsonResponse {
        $user = $request->user();

        $event = $this->eventService->create($request->validated(), $user);

        return response()->json([
            'message' => 'Successfully created an event',
            'event' => new EventResource($event),
        ]);
    }

     public function show(Request $request, int $id): JsonResponse {

        $event = $this->eventService->show($request->user(), $id);

        return response()->json([
            'message' => 'Successfully fetched single event',
            'event' => new EventResource($event),
        ]);
    }

    public function update(UpdateEventRequest $request, int $id): JsonResponse
    {
        $event = $this->eventService->update(
            $id,
            $request->validated(),
            $request->user()
        );

        return response()->json([
            'message' => 'Successfully updated the event',
            'event' => new EventResource($event)
        ]);
    }

    public function destroy(Request $request, $id): JsonResponse {
        $this->eventService->delete($id, $request->user());

        return response()->json([
            'message' => 'Successfully deleted the event'
        ]);
    }

    public function complete(Request $request, $id): JsonResponse
    {
        $event = $this->eventService->complete($id, $request->user());

        return response()->json([
            'message' => 'Successfully completed the event',
            'event' => new EventResource($event)
        ]);
    }
}
