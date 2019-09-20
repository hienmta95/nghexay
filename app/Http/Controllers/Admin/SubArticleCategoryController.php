<?php


namespace App\Http\Controllers\Admin;

use Icetea\Admin\app\Http\Controllers\PanelController;
use App\Models\ArticleCategory;
use App\Http\Requests\Admin\ArticleCategoryRequest as StoreRequest;
use App\Http\Requests\Admin\ArticleCategoryRequest as UpdateRequest;

class SubArticleCategoryController extends PanelController
{
	public $parentId = null;

	public function setup()
	{
		// Get the Parent ID
		$this->parentId = request()->segment(3);

		// Get Parent ArticleCategory name
		$parent = ArticleCategory::findTransOrFail($this->parentId);

		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\ArticleCategory');
		$this->xPanel->setRoute(admin_uri('article_article_categories/' . $this->parentId . '/subarticle_categories'));
		$this->xPanel->setEntityNameStrings(
			trans('admin::messages.sub_article_category') . ' &rarr; ' . '<strong>' . $parent->name . '</strong>',
			trans('admin::messages.sub_article_categories') . ' &rarr; ' . '<strong>' . $parent->name . '</strong>'
		);
		$this->xPanel->enableReorder('name', 1);
		$this->xPanel->enableDetailsRow();
		if (!request()->input('order')) {
			$this->xPanel->orderBy('lft', 'ASC');
		}

		$this->xPanel->enableParentEntity();
		$this->xPanel->setParentKeyField('parent_id');
		$this->xPanel->addClause('where', 'parent_id', '=', $this->parentId);
		$this->xPanel->setParentRoute(admin_uri('article_categories'));
		$this->xPanel->setParentEntityNameStrings('parent ' . trans('admin::messages.article_category'), 'parent ' . trans('admin::messages.article_categories'));
		$this->xPanel->allowAccess(['reorder', 'details_row', 'parent']);

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
			'name'  => 'name',
			'label' => trans("admin::messages.Name"),
		]);
		$this->xPanel->addColumn([
			'name'          => 'active',
			'label'         => trans("admin::messages.Active"),
			'type'          => 'model_function',
			'function_name' => 'getActiveHtml',
			'on_display'    => 'checkbox',
		]);


		// FIELDS
		$this->xPanel->addField([
			'name'  => 'parent_id',
			'type'  => 'hidden',
			'value' => $this->parentId,
		], 'create');
		$this->xPanel->addField([
			'name'              => 'name',
			'label'             => trans("admin::messages.Name"),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => trans("admin::messages.Name"),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'slug',
			'label'             => trans("admin::messages.Slug"),
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
			'name'       => 'description',
			'label'      => trans("admin::messages.Description"),
			'type'       => 'textarea',
			'attributes' => [
				'placeholder' => trans("admin::messages.Description"),
			],
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
