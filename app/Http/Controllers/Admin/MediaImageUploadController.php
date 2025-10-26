<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MediaImageUpload\BulkDestroyMediaImageUpload;
use App\Http\Requests\Admin\MediaImageUpload\DestroyMediaImageUpload;
use App\Http\Requests\Admin\MediaImageUpload\IndexMediaImageUpload;
use App\Http\Requests\Admin\MediaImageUpload\StoreMediaImageUpload;
use App\Http\Requests\Admin\MediaImageUpload\UpdateMediaImageUpload;
use App\Models\MediaImageUpload;
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

class MediaImageUploadController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexMediaImageUpload $request
     * @return array|Factory|View
     */
    public function index(IndexMediaImageUpload $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(MediaImageUpload::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'id_model', 'name'],

            // set columns to searchIn
            ['id', 'id_model', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.media-image-upload.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.media-image-upload.create');

        return view('admin.media-image-upload.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMediaImageUpload $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreMediaImageUpload $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the MediaImageUpload
        $mediaImageUpload = MediaImageUpload::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/media-image-uploads'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/media-image-uploads');
    }

    /**
     * Display the specified resource.
     *
     * @param MediaImageUpload $mediaImageUpload
     * @throws AuthorizationException
     * @return void
     */
    public function show(MediaImageUpload $mediaImageUpload)
    {
        $this->authorize('admin.media-image-upload.show', $mediaImageUpload);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param MediaImageUpload $mediaImageUpload
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(MediaImageUpload $mediaImageUpload)
    {
        $this->authorize('admin.media-image-upload.edit', $mediaImageUpload);


        return view('admin.media-image-upload.edit', [
            'mediaImageUpload' => $mediaImageUpload,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMediaImageUpload $request
     * @param MediaImageUpload $mediaImageUpload
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateMediaImageUpload $request, MediaImageUpload $mediaImageUpload)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values MediaImageUpload
        $mediaImageUpload->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/media-image-uploads'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/media-image-uploads');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyMediaImageUpload $request
     * @param MediaImageUpload $mediaImageUpload
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyMediaImageUpload $request, MediaImageUpload $mediaImageUpload)
    {
        $mediaImageUpload->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyMediaImageUpload $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyMediaImageUpload $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    MediaImageUpload::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
