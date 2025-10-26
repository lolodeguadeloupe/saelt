<?php

namespace App\Http\Controllers\Admin\Excursion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Excursion\ItineraireExcursion\BulkDestroyItineraireExcursion;
use App\Http\Requests\Admin\Excursion\ItineraireExcursion\DestroyItineraireExcursion;
use App\Http\Requests\Admin\Excursion\ItineraireExcursion\IndexItineraireExcursion;
use App\Http\Requests\Admin\Excursion\ItineraireExcursion\StoreItineraireExcursion;
use App\Http\Requests\Admin\Excursion\ItineraireExcursion\UpdateItineraireExcursion;
use App\Models\Excursion\Excursion;
use App\Models\Excursion\ItineraireExcursion;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ItineraireExcursionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexItineraireExcursion $request
     * @return array|Factory|View
     */
    public function index(IndexItineraireExcursion $request, Excursion $excursion)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ItineraireExcursion::class)
            ->modifyQuery(function ($query) use ($request, $excursion) {
                $query->where(['excursion_id' => $excursion->id]);
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,

                // set columns to query
                ['id', 'rang', 'excursion_id', 'titre', 'image', 'description'],

                // set columns to searchIn
                ['id', 'rang', 'titre', 'image', 'description']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.excursion.itineraire-excursion.index', [
            'data' => $data,
            'excursion' => $excursion
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create(Request $request, Excursion $excursion)
    {
        $this->authorize('admin.itineraire-excursion.create');
        if (!$request->ajax()) {
            abort(404);
        }
        $itineraireExcursion_ = ItineraireExcursion::where(['excursion_id' => $excursion->id])->get();
        $rang = collect($itineraireExcursion_)->map(function ($data) {
            return intval($data->rang);
        });
        return [
            'rang' => count($rang) > 0 ? collect($rang)->max() + 1 : 1
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreItineraireExcursion $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreItineraireExcursion $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $itineraireExcursion_ = ItineraireExcursion::where(['excursion_id' => $request->excursion_id])->get();
        $rang = collect($itineraireExcursion_)->map(function ($data) {
            return intval($data->rang);
        });

        if (count($rang) > 0 && isset($request->rang) && intval($request->rang) < collect($rang)->max()) {
            collect($itineraireExcursion_)->map(function ($data) use ($request) {
                if (intval($data->rang) >= intval($request->rang)) {
                    $input = collect($data)->put('rang', intval($data->rang) + 1);
                    ItineraireExcursion::find($data->id)->update($input->toArray());
                }
            });
        }

        if (!isset($request->rang) || $request->rang == null) {
            $sanitized['rang'] = count($rang) > 0 ? collect($rang)->max() + 1 : 1;
        }

        // Store the ItineraireExcursion
        $itineraireExcursion = ItineraireExcursion::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/itineraire-excursions'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/itineraire-excursions');
    }

    /**
     * Display the specified resource.
     *
     * @param ItineraireExcursion $itineraireExcursion
     * @throws AuthorizationException
     * @return void
     */
    public function show(ItineraireExcursion $itineraireExcursion)
    {
        $this->authorize('admin.excursion.itineraire-excursion.show', $itineraireExcursion);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ItineraireExcursion $itineraireExcursion
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ItineraireExcursion $itineraireExcursion)
    {
        $this->authorize('admin.itineraire-excursion.edit', $itineraireExcursion);


        return [
            'itineraireExcursion' => $itineraireExcursion,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateItineraireExcursion $request
     * @param ItineraireExcursion $itineraireExcursion
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateItineraireExcursion $request, ItineraireExcursion $itineraireExcursion)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $itineraireExcursion_ = ItineraireExcursion::where(['excursion_id' => $itineraireExcursion->excursion_id])->get();
        $rang = collect($itineraireExcursion_)->map(function ($data) {
            return intval($data->rang);
        });

        if (count($rang) > 0 && isset($sanitized['rang']) && $itineraireExcursion->rang != $sanitized['rang']) {
            collect($itineraireExcursion_)->map(function ($data) use ($request) {
                if (intval($data->rang) > intval($request->rang)) {
                    $input = collect($data)->put('rang', intval($data->rang) + 1);
                    ItineraireExcursion::find($data->id)->update($input->toArray());
                }
            });
        }

        // Update changed values ItineraireExcursion
        $itineraireExcursion->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/itineraire-excursions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/itineraire-excursions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyItineraireExcursion $request
     * @param ItineraireExcursion $itineraireExcursion
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyItineraireExcursion $request, ItineraireExcursion $itineraireExcursion)
    {
        $itineraireExcursion_ = ItineraireExcursion::where(['excursion_id' => $itineraireExcursion->excursion_id])->get();
        collect($itineraireExcursion_)->map(function ($data) use ($itineraireExcursion) {
            if (intval($data->rang) > intval($itineraireExcursion->rang)) {
                $input = collect($data)->put('rang', intval($data->rang) - 1);
                ItineraireExcursion::find($data->id)->update($input->toArray());
            }
        });
        $itineraireExcursion->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyItineraireExcursion $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyItineraireExcursion $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    ItineraireExcursion::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
