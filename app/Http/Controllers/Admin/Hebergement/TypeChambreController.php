<?php

namespace App\Http\Controllers\Admin\Hebergement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hebergement\TypeChambre\BulkDestroyTypeChambre;
use App\Http\Requests\Admin\Hebergement\TypeChambre\DestroyTypeChambre;
use App\Http\Requests\Admin\Hebergement\TypeChambre\IndexTypeChambre;
use App\Http\Requests\Admin\Hebergement\TypeChambre\StoreTypeChambre;
use App\Http\Requests\Admin\Hebergement\TypeChambre\UpdateTypeChambre;
use App\Models\Hebergement\TypeChambre;
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

class TypeChambreController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @param IndexTypeChambre $request
     * @return array|Factory|View
     */
    public function index(IndexTypeChambre $request) {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(TypeChambre::class)
                ->modifyQuery(function($query) use ($request) {
                    $query->with(['hebergement'])->where(['type_chambre.hebergement_id' => $request->heb]);
                })
                ->processRequestAndGet(
                // pass the request with params
                $request,
                // set columns to query
                ['id', 'name', 'status', 'image', 'capacite', 'description', 'nombre_chambre', 'hebergement_id','formule','cout_supplementaire'],
                // set columns to searchIn
                ['id', 'name', 'description', 'capacite',  'nombre_chambre', 'cout_supplementaire']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        if (!(isset($request->heb) && \App\Models\Hebergement\Hebergement::find($request->heb))) {
            return redirect('admin/hebergements');
        }

        return view('admin.hebergement.type-chambre.index', [
            'hebergement' => \App\Models\Hebergement\Hebergement::find($request->heb),
            'data' => $data,
            'type_chambres' => json_encode(\App\Models\Hebergement\TypeChambre::where(['hebergement_id' => $request->id])->get())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create() {
        $this->authorize('admin.type-chambre.create');

        if (!$this->request->ajax()) {
            abort(404);
        }

        return [
            
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTypeChambre $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTypeChambre $request) {
        // Sanitize input

        $sanitized = $request->getSanitized();

        $sanitizedImage = $request->getMediaImage();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        // Store the TypeChambre
        $typeChambre = TypeChambre::create($sanitized);

        foreach ($sanitizedImage['image'] as $value) {
            $input['id_model'] = $typeChambre->id . '_type_chambre';
            $input['name'] = $value;
            \App\Models\MediaImageUpload::create($input);
        }

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $typeChambre->id . '_type_chambre';
            EventDateHeure::create($value);
        }

        $typeChambre['image'] = \App\Models\MediaImageUpload::where(['id_model' => $typeChambre->id . '_type_chambre'])->get();
        $typeChambre['calendar'] = EventDateHeure::where(['model_event' => $typeChambre->id . '_type_chambre'])->get();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/type-chambres'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'typeChambre' => $typeChambre
            ];
        }

        return redirect('admin/type-chambres');
    }

    /**
     * Display the specified resource.
     *
     * @param TypeChambre $typeChambre
     * @throws AuthorizationException
     * @return void
     */
    public function show(TypeChambre $typeChambre) {
        $this->authorize('admin.type-chambre.show', $typeChambre);

        // TODO your code goes here
        if (!$this->request->ajax()) {
            abort(404);
        }

        $typeChambre['image'] = \App\Models\MediaImageUpload::where(['id_model' => $typeChambre->id . '_type_chambre'])->get();
        $typeChambre['calendar'] = EventDateHeure::where(['model_event' => $typeChambre->id . '_type_chambre'])->get();
        return [
            'typeChambre' => $typeChambre,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TypeChambre $typeChambre
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(TypeChambre $typeChambre) {
        $this->authorize('admin.type-chambre.edit', $typeChambre);

        if (!$this->request->ajax()) {
            abort(404);
        }

        $typeChambre['image'] = \App\Models\MediaImageUpload::where(['id_model' => $typeChambre->id . '_type_chambre'])->get();
        $typeChambre['calendar'] = EventDateHeure::where(['model_event' => $typeChambre->id . '_type_chambre'])->get();

        return [
            'typeChambre' => $typeChambre,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTypeChambre $request
     * @param TypeChambre $typeChambre
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTypeChambre $request, TypeChambre $typeChambre) {

        // Sanitize input
        $sanitized = $request->getSanitized();

        $sanitizedImage = $request->getMediaImage();

        $sanitizedCalendar = $request->getCalendar()['calendar'];

        // Update changed values TypeChambre
        $typeChambre->update($sanitized);

        foreach ($sanitizedImage['image'] as $value) {
            $input['id_model'] = $typeChambre->id . '_type_chambre';
            $input['name'] = $value;
            \App\Models\MediaImageUpload::create($input);
        }

        foreach ($sanitizedCalendar as $value) {
            $value['model_event'] = $typeChambre->id . '_type_chambre';
            EventDateHeure::create($value);
        }

        $typeChambre['image'] = \App\Models\MediaImageUpload::where(['id_model' => $typeChambre->id . '_type_chambre'])->get();
        $typeChambre['calendar'] = EventDateHeure::where(['model_event' => $typeChambre->id . '_type_chambre'])->get();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/type-chambres'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                'typeChambre' => $typeChambre
            ];
        }

        return redirect('admin/type-chambres');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTypeChambre $request
     * @param TypeChambre $typeChambre
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTypeChambre $request, TypeChambre $typeChambre) {
        $typeChambre->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTypeChambre $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTypeChambre $request): Response {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                    ->chunk(1000)
                    ->each(static function ($bulkChunk) {
                        TypeChambre::whereIn('id', $bulkChunk)->delete();

                        // TODO your code goes here
                    });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function calendar($typeChambre) {
        $typeChambre = TypeChambre::find($typeChambre);

        return [
            'typeChambre' => $typeChambre,
            'calendar' => $typeChambre ? EventDateHeure::where(['model_event' => $typeChambre->id . '_type_chambre'])->get() : []
        ];
    }

}
