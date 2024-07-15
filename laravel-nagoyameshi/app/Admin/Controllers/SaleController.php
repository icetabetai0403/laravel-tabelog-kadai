<?php

namespace App\Admin\Controllers;

use App\Models\Sale;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SaleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Sale';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Sale());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('user.name', __('User Name'));
        $grid->column('amount', __('Amount'))->totalRow();
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        $grid->filter(function($filter) {
            $filter->disableIdFilter();
            $filter->equal('user.name', 'User Name');
            $filter->between('created_at', '登録日')->datetime();
        });

        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });

        return $grid;
    }
}
