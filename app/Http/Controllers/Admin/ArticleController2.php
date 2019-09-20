<?php


namespace App\Http\Controllers\Admin;

use Icetea\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\ArticleRequest as StoreRequest;
use App\Http\Requests\Admin\ArticleRequest as UpdateRequest;

class ArticleController2 extends PanelController
{
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\Article');
		$this->xPanel->setRoute(admin_uri('articles'));
		$this->xPanel->setEntityNameStrings(trans('admin::messages.article'), trans('admin::messages.articles'));
		$this->xPanel->enableReorder('name', 1);
		$this->xPanel->enableDetailsRow();
		$this->xPanel->allowAccess(['reorder', 'details_row']);
		if (!request()->input('order')) {
			$this->xPanel->orderBy('lft', 'ASC');
		}
		
		$this->xPanel->addButtonFromModelFunction('top', 'bulk_delete_btn', 'bulkDeleteBtn', 'end');
		
		/*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/
		// COLUMNS
		$this->xPanel->addColumn([
			'name'  => 'id',
			'label' => '',
			'type'  => 'checkbox',
			'orderable' => false,
		]);
		$this->xPanel->addColumn([
			'name'          => 'name',
			'label'         => trans("admin::messages.Name"),
			'type'          => 'model_function',
			'function_name' => 'getNameHtml',
		]);
		$this->xPanel->addColumn([
			'name'  => 'title',
			'label' => trans("admin::messages.Title"),
		]);
		$this->xPanel->addColumn([
			'name'          => 'active',
			'label'         => trans("admin::messages.Active"),
			'type'          => "model_function",
			'function_name' => 'getActiveHtml',
			'on_display'    => 'checkbox',
		]);
		
		// FIELDS
		$this->xPanel->addField([
			'name'       => 'name',
			'label'      => trans("admin::messages.Name"),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => trans("admin::messages.Name"),
			],
		]);
		$this->xPanel->addField([
			'name'              => 'slug',
			'label'             => trans('admin::messages.Slug'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => trans('admin::messages.Will be automatically generated from your name, if left empty.'),
			],
			'hint'              => trans('admin::messages.Will be automatically generated from your name, if left empty.'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'external_link',
			'label'             => trans("admin::messages.External Link"),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => "http://",
			],
			'hint'              => trans('admin::messages.Redirect this article to the URL above.') . ' ' . trans('admin::messages.NOTE: Leave this field empty if you don\'t want redirect this article.'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'       => 'title',
			'label'      => trans("admin::messages.Title"),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => trans("admin::messages.Title"),
			],
		]);
		$this->xPanel->addField([
			'name'       => 'content',
			'label'      => trans("admin::messages.Content"),
			'type'       => (config('settings.single.simditor_wysiwyg'))
				? 'simditor'
				: ((!config('settings.single.simditor_wysiwyg') && config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : 'textarea'),
			'attributes' => [
				'placeholder' => trans("admin::messages.Content"),
				'id'          => 'articleContent',
				'rows'        => 20,
			],
		]);
		$this->xPanel->addField([
			'name'  => 'type',
			'label' => trans('admin::messages.Type'),
			'type'  => 'enum',
		]);
		$this->xPanel->addField([
			'name'   => 'picture',
			'label'  => trans('admin::messages.Picture'),
			'type'   => 'image',
			'upload' => true,
			'disk'   => 'public',
		]);
		$this->xPanel->addField([
			'name'                => 'name_color',
			'label'               => trans('admin::messages.Article Name Color'),
			'type'                => 'color_picker',
			'colorpicker_options' => [
				'customClass' => 'custom-class',
			],
			'wrapperAttributes'   => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'                => 'title_color',
			'label'               => trans('admin::messages.Article Title Color'),
			'type'                => 'color_picker',
			'colorpicker_options' => [
				'customClass' => 'custom-class',
			],
			'wrapperAttributes'   => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'  => 'featured',
			'label' => 'Nổi bật',
			'type'  => 'checkbox',
		]);

		$this->xPanel->addField([
			'name'  => 'active',
			'label' => trans("admin::messages.Active"),
			'type'  => 'checkbox',
		]);
	}
	
	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}
	
	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
}
