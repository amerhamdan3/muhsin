<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyOptionRequest;
use App\Http\Requests\StoreOptionRequest;
use App\Http\Requests\UpdateOptionRequest;
use App\Models\Blog;
use App\Models\ContentPage;
use App\Models\Option;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class OptionsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('option_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $options = Option::with(['pages', 'blogs'])->get();

        return view('admin.options.index', compact('options'));
    }

    public function create()
    {
        abort_if(Gate::denies('option_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pages = ContentPage::all()->pluck('title', 'id');

        $blogs = Blog::all()->pluck('title', 'id');

        return view('admin.options.create', compact('pages', 'blogs'));
    }

    public function store(StoreOptionRequest $request)
    {
        $option = Option::create($request->all());
        $option->pages()->sync($request->input('pages', []));
        $option->blogs()->sync($request->input('blogs', []));
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $option->id]);
        }

        return redirect()->route('admin.options.index');
    }

    public function edit(Option $option)
    {
        abort_if(Gate::denies('option_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pages = ContentPage::all()->pluck('title', 'id');

        $blogs = Blog::all()->pluck('title', 'id');

        $option->load('pages', 'blogs');

        return view('admin.options.edit', compact('pages', 'blogs', 'option'));
    }

    public function update(UpdateOptionRequest $request, Option $option)
    {
        $option->update($request->all());
        $option->pages()->sync($request->input('pages', []));
        $option->blogs()->sync($request->input('blogs', []));

        return redirect()->route('admin.options.index');
    }

    public function show(Option $option)
    {
        abort_if(Gate::denies('option_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $option->load('pages', 'blogs');

        return view('admin.options.show', compact('option'));
    }

    public function destroy(Option $option)
    {
        abort_if(Gate::denies('option_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $option->delete();

        return back();
    }

    public function massDestroy(MassDestroyOptionRequest $request)
    {
        Option::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('option_create') && Gate::denies('option_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Option();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
