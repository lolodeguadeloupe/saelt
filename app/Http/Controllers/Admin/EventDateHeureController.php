<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventDateHeure\BulkDestroyEventDateHeure;
use App\Http\Requests\Admin\EventDateHeure\DestroyEventDateHeure;
use App\Http\Requests\Admin\EventDateHeure\IndexEventDateHeure;
use App\Http\Requests\Admin\EventDateHeure\StoreEventDateHeure;
use App\Http\Requests\Admin\EventDateHeure\UpdateEventDateHeure;
use App\Models\EventDateHeure;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EventDateHeureController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexEventDateHeure $request
     * @return array|Factory|View
     */
    public function index(IndexEventDateHeure $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(EventDateHeure::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'description', 'date', 'time_start', 'time_end', 'model_event', 'status','ui_event','color'],

            // set columns to searchIn
            ['id', 'description', 'model_event']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.event-date-heure.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.event-date-heure.create');

        return view('admin.event-date-heure.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEventDateHeure $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreEventDateHeure $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the EventDateHeure
        $eventDateHeure = EventDateHeure::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/event-date-heures'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/event-date-heures');
    }

    /**
     * Display the specified resource.
     *
     * @param EventDateHeure $eventDateHeure
     * @throws AuthorizationException
     * @return void
     */
    public function show(EventDateHeure $eventDateHeure)
    {
        $this->authorize('admin.event-date-heure.show', $eventDateHeure);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EventDateHeure $eventDateHeure
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(EventDateHeure $eventDateHeure)
    {
        $this->authorize('admin.event-date-heure.edit', $eventDateHeure);


        return view('admin.event-date-heure.edit', [
            'eventDateHeure' => $eventDateHeure,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEventDateHeure $request
     * @param EventDateHeure $eventDateHeure
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateEventDateHeure $request, EventDateHeure $eventDateHeure)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values EventDateHeure
        $eventDateHeure->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/event-date-heures'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/event-date-heures');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyEventDateHeure $request
     * @param EventDateHeure $eventDateHeure
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyEventDateHeure $request, EventDateHeure $eventDateHeure)
    {
        $eventDateHeure->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyEventDateHeure $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyEventDateHeure $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    EventDateHeure::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
