<?php


namespace App\Http\Controllers\Admin;

use App\Models\ArticleCategory;
use Icetea\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\ArticleRequest as StoreRequest;
use App\Http\Requests\Admin\ArticleRequest as UpdateRequest;

class ArticleController extends PanelController
{


    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->xPanel->setModel('App\Models\Article');
        $this->xPanel->with(['user']);
        $this->xPanel->setRoute(admin_uri('articles'));
        $this->xPanel->setEntityNameStrings(trans('admin::messages.ad'), trans('admin::messages.ads'));
        //$this->xPanel->denyAccess(['create']);
        if (!request()->input('order')) {
            if (config('settings.single.articles_review_activation')) {
                $this->xPanel->orderBy('published', 'ASC');
            }
            $this->xPanel->orderBy('created_at', 'DESC');
        }

        $this->xPanel->addButtonFromModelFunction('top', 'bulk_delete_btn', 'bulkDeleteBtn', 'end');

        // Hard Filters
        if (request()->filled('active')) {
            if (request()->get('active') == 0) {

                $this->xPanel->addClause('where', 'published', '=', 0);
            }
            if (request()->get('active') == 1) {
                $this->xPanel->addClause('where', 'published', '=', 1);
            }
        }

        // Filters
        // -----------------------
        $this->xPanel->addFilter([
            'name' => 'id',
            'type' => 'text',
            'label' => 'ID',
        ],
            false,
            function ($value) {
                $this->xPanel->addClause('where', 'id', '=', $value);
            });
        // -----------------------
        $this->xPanel->addFilter([
            'name' => 'from_to',
            'type' => 'date_range',
            'label' => trans('admin::messages.Date range'),
        ],
            false,
            function ($value) {
                $dates = json_decode($value);
                $this->xPanel->addClause('where', 'created_at', '>=', $dates->from);
                $this->xPanel->addClause('where', 'created_at', '<=', $dates->to);
            });
        // -----------------------
        $this->xPanel->addFilter([
            'name' => 'title',
            'type' => 'text',
            'label' => trans('admin::messages.Title'),
        ],
            false,
            function ($value) {
                $this->xPanel->addClause('where', 'title', 'LIKE', "%$value%");
            });
        // -----------------------

        // -----------------------
        $this->xPanel->addFilter([
            'name' => 'status',
            'type' => 'dropdown',
            'label' => 'Trạng thái',
        ], [
            1 => 'Không hoạt động',
            2 => 'Hoạt động',
        ], function ($value) {
            if ($value == 0) {
                $this->xPanel->addClause('where', 'published', '=', 0);
            }
            if ($value == 1) {
                $this->xPanel->addClause('where', 'published', '=', 1);
            }
        });
     // -----------------------
        $this->xPanel->addFilter([
            'name' => 'featured',
            'type' => 'dropdown',
            'label' => "Nổi bật",
        ], [
            1 => "Bình thường",
            2 => "Nổi bật",
        ], function ($value) {
            if ($value == 0) {
                $this->xPanel->addClause('where', 'featured', '=', 0);
            }
            if ($value == 1) {
                $this->xPanel->addClause('where', 'featured', '=', 1);
            }
        });


        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */
        // COLUMNS
        $this->xPanel->addColumn([
            'name' => 'id',
            'label' => '',
            'type' => 'checkbox',
            'orderable' => false,
        ]);
        $this->xPanel->addColumn([
            'name' => 'created_at',
            'label' => 'Ngày tạo',
            'type' => 'datetime',
        ]);

        $this->xPanel->addColumn([
            'name' => 'title',
            'label' => 'Tiêu đề',
            'type' => 'model_function',
            'function_name' => 'getTitleHtml',
        ]);
        $this->xPanel->addColumn([
            'name' => 'visits',
            'label' => 'LX',
            'type' => 'text',
        ]);

        /*$this->xPanel->addColumn([
            'name'          => 'logo', // Put unused field column
            'label'         => trans("admin::messages.Logo"),
            'type'          => 'model_function',
            'function_name' => 'getLogoHtml',
        ]);*/

        /*$this->xPanel->addColumn([
            'name'          => 'country_code',
            'label'         => trans("admin::messages.Country"),
            'type'          => 'model_function',
            'function_name' => 'getCountryHtml',
        ]);*/


            $this->xPanel->addColumn([
                'name' => 'published',
                'label' => 'Đã duyệt',
                'type' => "model_function",
                'function_name' => 'getReviewedHtml',
            ]);


        // FIELDS
        $this->xPanel->addField([
            'label' => 'Danh mục',
            'name' => 'category_id',
            'type' => 'select2_from_array',
            'options' => $this->categories(),
            'allows_null' => false,
        ]);

        $this->xPanel->addField([
            'name' => 'logo',
            'label' => 'Thumbnail (jpg, jpeg, png, gif)',
            'type' => 'image',
            'upload' => true,
            'disk' => 'public',
        ]);

        $this->xPanel->addField([
            'name' => 'title',
            'label' => 'Tiêu đề',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Tiêu đề',
            ],
        ]);
        $this->xPanel->addField([
            'name' => 'description',
            'label' => 'Nội dung',
            'type' => (config('settings.single.simditor_wysiwyg'))
                ? 'ckeditor'
                : ((!config('settings.single.simditor_wysiwyg') && config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : 'textarea'),
            'attributes' => [
                'placeholder' => 'Nội dung',
                'id' => 'description',
                'rows' => 10,
            ],
        ]);


        $this->xPanel->addField([
            'name' => 'tags',
            'label' => 'Từ khóa',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Từ khóa',
            ],
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        $this->xPanel->addField([
            'name' => 'published',
            'label' => 'Xuất bản?',
            'type' => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
                'style' => 'margin-top: 20px;',
            ],
        ]);
        $this->xPanel->addField([
            'name' => 'featured',
            'label' => 'Nổi bật ?',
            'type' => 'checkbox',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
                'style' => 'margin-top: 20px;',
            ],
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

    public function categories()
    {
        $entries = ArticleCategory::trans()->where('parent_id', 0)->orderBy('lft')->get();
        if ($entries->count() <= 0) {
            return [];
        }

        $tab = [];
        foreach ($entries as $entry) {
            $tab[$entry->tid] = $entry->name;

            $subEntries = ArticleCategory::trans()->where('parent_id', $entry->id)->orderBy('lft')->get();
            if (!empty($subEntries)) {
                foreach ($subEntries as $subEntrie) {
                    $tab[$subEntrie->tid] = "---| " . $subEntrie->name;
                }
            }
        }

        return $tab;
    }

}
