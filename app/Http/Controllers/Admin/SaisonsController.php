<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Saison\BulkDestroySaison;
use App\Http\Requests\Admin\Saison\DestroySaison;
use App\Http\Requests\Admin\Saison\IndexSaison;
use App\Http\Requests\Admin\Saison\StoreSaison;
use App\Http\Requests\Admin\Saison\UpdateSaison;
use App\Http\Requests\Admin\Saison\AutocompletionSaison;
use App\Models\Excursion\Excursion;
use App\Models\Hebergement\Hebergement;
use App\Models\LocationVehicule\VehiculeLocation;
use App\Models\Saison;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SaisonsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSaison $request
     * @return array|Factory|View
     */
    public function index(IndexSaison $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Saison::class)
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'debut', 'debut_format', 'fin', 'fin_format', 'titre'],
                // set columns to searchIn
                ['id', 'debut', 'fin', 'titre'],
                function ($query) use ($request) {
                    if (isset($request->heb)) {
                        $query->where(['model' => Hebergement::class, 'model_id' => $request->heb]);
                    } else if (isset($request->excursion)) {
                        $query->where(['model' => Excursion::class, 'model_id' => $request->excursion]);
                    } else if ($request->location) {
                        $query->where(['model' => VehiculeLocation::class, 'model_id' => $request->location]);
                    }
                }
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }


        if (!isset($request->heb) && !isset($request->excursion) && !isset($request->location)) {
            return redirect('/admin');
        }

        if (isset($request->heb)) {
            if (Hebergement::find($request->heb)) {
                return view('admin.hebergement.saison.index', [
                    'data' => $data,
                    'hebergement' => Hebergement::find($request->heb),
                ]);
            }
            return redirect('/admin/hebergements');
        } else if (isset($request->excursion)) {
            if (Excursion::find($request->excursion)) {
                return view('admin.excursion.saison.index', [
                    'data' => $data,
                    'excursion' => Excursion::find($request->excursion),
                ]);
            }
            return redirect('/admin/excursions');
        } else if (isset($request->location)) {
            if (VehiculeLocation::find($request->location)) {
                return view('admin.location-vehicule.saison.index', [
                    'data' => $data,
                    'vehiculeLocation' => VehiculeLocation::find($request->location),
                ]);
            }
            return redirect('/admin/vehicule-locations');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.saison.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSaison $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSaison $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $model = null;
        $saison = null;
        if (isset($request->heb)) {
            $model = Hebergement::find($request->heb);
        } else if (isset($request->excursion)) {
            $model = Excursion::find($request->excursion);
        } else if (isset($request->location)) {
            $model = VehiculeLocation::find($request->location);
        }

        /** */
        if ($model == null) {
            abort(404);
        } else {
            $saison = $model->saison()->create($sanitized);
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/saisons'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'saison' => $saison,
            ];
        }

        return redirect('admin/saisons');
    }

    /**
     * Display the specified resource.
     *
     * @param Saison $saison
     * @throws AuthorizationException
     * @return void
     */
    public function show(Saison $saison)
    {
        $this->authorize('admin.saison.show', $saison);

        // TODO your code goes here
        if (!$this->request->ajax()) {
            abort(404);
        }
        return ['saison' => $saison];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Saison $saison
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Saison $saison)
    {
        $this->authorize('admin.saison.edit', $saison);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'saison' => $saison
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSaison $request
     * @param Saison $saison
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSaison $request, Saison $saison)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Saison
        $saison->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/saisons'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'saison' => $saison,
            ];
        }

        return redirect('admin/saisons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySaison $request
     * @param Saison $saison
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySaison $request, Saison $saison)
    {
        $saison->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySaison $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySaison $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Saison::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function autocompletion(AutocompletionSaison $request)
    {
        $sanitized = $request->getSanitized();
        $search = Saison::where(function ($query) use ($sanitized) {
            $query->where('titre', 'like', '%' . $sanitized['search'] . '%');
        });
        $model = null;
        if (isset($request->heb)) {
            $model = Hebergement::find($request->heb);
        } else if (isset($request->excursion)) {
            $model = Excursion::find($request->excursion);
        } else if ($request->location) {
            $model = VehiculeLocation::find($request->location);
        }

        if (!$this->request->ajax() && $model == null) {
            abort(404);
        } else {
            $search = $search->where(['model' => get_class($model), 'model_id' => $model->id])->get();
        }

        return [
            'search' => $search,
        ];
    }
}
