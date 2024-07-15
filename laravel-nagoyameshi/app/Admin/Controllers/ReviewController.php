<?php

namespace App\Admin\Controllers;

use App\Models\Review;
use App\Models\Store;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ReviewController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Review';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Review());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('title', __('Title'));
        $grid->column('content', __('Content'));
        $grid->column('score', __('Score'))->sortable();
        $grid->column('store.name', __('Store Name'));
        $grid->column('user.name', __('User Name'));
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        $grid->filter(function($filter) {
            $filter->like('score', '評価')->select([
                1 => '1',
                2 => '2',
                3 => '3',
                4 => '4',
                5 => '5'
            ]);
            $filter->like('title', 'タイトル');
            $filter->like('content', '内容');
            $filter->in('store_id', '店舗名')->multipleSelect(Store::all()->pluck('name', 'id'));
            $filter->like('user_id', 'ユーザー名');
            $filter->between('created_at', '登録日')->datetime();
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Review::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('content', __('Content'));
        $show->field('score', __('Score'));
        $show->field('store.name', __('Store Name'));
        $show->field('user.name', __('User Name'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Review());

        $form->text('title', __('Title'));
        $form->textarea('content', __('Content'));
        $form->number('score', __('Score'));
        $form->select('store_id', __('Store Name'))->options(Store::all()->pluck('name', 'id'));
        $form->select('user_id', __('User Name'))->options(User::all()->pluck('name', 'id'));

        return $form;
    }
}
