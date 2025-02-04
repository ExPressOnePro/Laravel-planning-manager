<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StandPublishersRequest;
use App\Http\Requests\StandPublishersUpdateRequest;
use App\Http\Requests\StandRequest;
use App\Models\StandPublishers;
use App\Models\StandTemplate;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;

class StandPublishersController extends Controller
{
    public function store(StandPublishersRequest $request): JsonResource
    {
        $standPublishers = StandPublishers::query()->create([
            'stand_template_id' => $request->standTemplateId,
            'time' => $request->time,
            'user_1' => $request->publisher,
            'user_2' => $request->partner,
            'date' => now(),
        ]);

        return new JsonResource($standPublishers);
    }

    public function update(StandPublishersUpdateRequest $request, int $id): JsonResource
    {
        $standPublishers = StandPublishers::query()->findOrFail($id);

        $update = [];

        if ($request->publisher) {
            $update['user_1'] = $request->publisher;
        }

        if ($request->partner) {
            $update['user_2'] = $request->partner;
        }

        if ($request->time) {
            $update['time'] = $request->time;
        }

        $standPublishers->update($update);

        return new JsonResource($standPublishers);
    }

    public function destroy(int $id): JsonResponse
    {
        StandPublishers::destroy($id);

        return Response::json(['message' => 'Stand record was deleted.']);
    }
}
