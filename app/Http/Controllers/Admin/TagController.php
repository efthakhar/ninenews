<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TagController extends Controller {

	public function index(Request $request) {
		
		$this->authorize('view-tags');
		return view('admin.tag.index');
	}

	public function show($id) {
		$this->authorize('view-tags');
		return view('admin.tag.single', [
			'tag' => Tag::find($id),
		]);
	}

	public function create() {

		$this->authorize('create-tags');

		return view('admin.tag.create');
	}

	public function store(Request $request) {

		$this->authorize('create-tags');

		$slug = $request->slug ? strtolower(str_replace(' ', '-', $request->slug)) : strtolower(str_replace(' ', '-', $request->name));

		$request->merge(['slug' => $slug]);

		$validatedData = $request->validate([
			'name'                 => 'required|unique:tags|max:30',
			'slug'                 => 'unique:tags|max:30',
			'description'          => 'string|nullable',
			'meta_tag_description' => 'string|nullable',
			'meta_tag_keywords'    => 'string|nullable',
		]);

		$validatedData['created_by'] = auth()->id();

		Tag::create($validatedData);

		return redirect()->route('admin.tag.index');
	}

	public function edit($id) {

		$this->authorize('update-tags');

		return view('admin.tag.edit', [
			'tag' => Tag::find($id),
		]);
	}

	public function update(Request $request, $id) {

        $this->authorize('view-tags');

		$slug = $request->slug ? strtolower(str_replace(' ', '-', $request->slug)) : strtolower(str_replace(' ', '-', $request->name));

		$request->merge(['slug' => $slug]);

		$validatedData = $request->validate([
			'name'                 => ['required', Rule::unique('tags')->ignore($id), 'max:30'],
			'slug'                 => [Rule::unique('tags')->ignore($id), 'max:30'],
			'description'          => 'string|nullable',
			'meta_tag_description' => 'string|nullable',
			'meta_tag_keywords'    => 'string|nullable',
		]);

		$validatedData['updated_by'] = auth()->id();

		Tag::where('id', $id)->update($validatedData);

		return redirect()->route('admin.tag.edit', $id)->with('tagUpdateSuccess', 'Tag Updated Successfully');
	}

	public function delete($id) {

		$id  = explode(',',$id);
		$this->authorize('delete-tags');

		Tag::whereIn('id', $id)->delete();

		return redirect()->back();
	}
}
