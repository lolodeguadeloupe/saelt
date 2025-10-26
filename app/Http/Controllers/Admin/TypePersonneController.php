<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TypePersonne\AutocompletionTypePersonne;
use App\Http\Requests\Admin\TypePersonne\BulkDestroyTypePersonne;
use App\Http\Requests\Admin\TypePersonne\DestroyTypePersonne;
use App\Http\Requests\Admin\TypePersonne\IndexTypePersonne;
use App\Http\Requests\Admin\TypePersonne\StoreTypePersonne;
use App\Http\Requests\Admin\TypePersonne\UpdateTypePersonne;
use App\Models\Excursion\Excursion;
use App\Models\Hebergement\Hebergement;
use App\Models\TransfertVoyage\TypeTransfertVoyage;
use App\Models\TypePersonne;
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

class TypePersonneController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTypePersonne $request
     * @return array|Factory|View
     */
    public function indexPro(IndexTypePersonne $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TypePersonne::class)
            ->modifyQuery(function ($query) use ($request) {
                if (isset($request->heb)) {
                    $query->where(['model' => Hebergement::class, 'model_id' => $request->heb]);
                } else if (isset($request->excursion)) {
                    $query->where(['model' => Excursion::class, 'model_id' => $request->excursion]);
                } else if (isset($request->transfert)) {
                    $query->where(['model' => TypeTransfertVoyage::class, 'model_id' => $request->transfert]);
                }
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'type', 'age', 'description', 'reference_prix'],
                // set columns to searchIn
                ['id', 'type', 'age', 'description']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        if (isset($request->heb)) {
            $model = Hebergement::find($request->heb);
            if ($model == null) {
                abort(404);
            }
            return view('admin.hebergement.type-personne.index', [
                'data' => $data,
                'hebergement' => $model,
            ]);
        } else if (isset($request->excursion)) {
            $model = Excursion::find($request->excursion);
            if ($model == null) {
                abort(404);
            }
            return view('admin.excursion.type-personne.index', [
                'data' => $data,
                'excursion' => $model,
            ]);
        } else if (isset($request->transfert)) {
            $model = TypeTransfertVoyage::find($request->transfert);
            if ($model == null) {
                abort(404);
            }
            return view('admin.transfert-voyage.type-personne.index', [
                'data' => $data,
                'typeTransfertVoyage' => $model,
            ]);
        } else {
            abort(404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexTypePersonne $request
     * @return array|Factory|View
     */
    public function index(IndexTypePersonne $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TypePersonne::class)
            ->modifyQuery(function ($query) use ($request) {
                $query->whereNull('model')
                    ->whereNull('model_id');
            })
            ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'type', 'age', 'description'],
                // set columns to searchIn
                ['id', 'type', 'age', 'description']
            );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.type-personne.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.type-personne.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTypePersonne $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTypePersonne $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        // Sanitize input
        $sanitized = $request->getSanitized();
        $model = null;
        if (isset($request->heb)) {
            $model = Hebergement::find($request->heb);
        } else if ($request->excursion) {
            $model = Excursion::find($request->excursion);
        } else if ($request->transfert) {
            $model = TypeTransfertVoyage::find($request->transfert);
        }
        if ($model == null) {
            TypePersonne::create($sanitized);
            $personnes = TypePersonne::whereNull('model_id')
                ->whereNull('model')
                ->get();
        } else {
            $model->personne()->create($sanitized);
            $personnes = $model->personne()->get();
        }

        return [
            'typePersonne' => $personnes
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param TypePersonne $typePersonne
     * @throws AuthorizationException
     * @return void
     */
    public function show(TypePersonne $typePersonne)
    {
        $this->authorize('admin.type-personne.show', $typePersonne);

        // TODO your code goes here

        if (!$this->request->ajax()) {
            abort(404);
        }

        return ['typePersonne' => $typePersonne];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TypePersonne $typePersonne
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TypePersonne $typePersonne)
    {
        $this->authorize('admin.type-personne.edit', $typePersonne);

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'typePersonne' => $typePersonne,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTypePersonne $request
     * @param TypePersonne $typePersonne
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTypePersonne $request, TypePersonne $typePersonne)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values TypePersonne
        $typePersonne->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/type-personnes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/type-personnes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTypePersonne $request
     * @param TypePersonne $typePersonne
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTypePersonne $request, TypePersonne $typePersonne)
    {
        if (TypePersonne::where(['original_id' => $typePersonne->id])->count() > 0) {
            if ($request->ajax()) {
                return response(['message' => trans('brackets/admin-ui::admin.operation.not_allowed')]);
            }
            return redirect()->back();
        }

        $typePersonne->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTypePersonne $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTypePersonne $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    TypePersonne::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function autocompletion(AutocompletionTypePersonne $resquest)
    {
        $sanitized = $resquest->getSanitized();
        $search = TypePersonne::where(function ($query) use ($sanitized) {
            $query->where('type', 'like', '%' . $sanitized['search'] . '%');
        })
            ->whereNull('model')
            ->whereNull('model_id')
            ->whereNull('original_id')
            ->limit(20)
            ->get();

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            'search' => $search,
        ];
    }
}
