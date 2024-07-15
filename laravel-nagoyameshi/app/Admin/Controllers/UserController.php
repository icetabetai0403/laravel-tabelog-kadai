<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    protected $title = 'User';
    
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('email_verified_at', __('Email verified at'));
        $grid->column('postal_code', __('Postal code'));
        $grid->column('address', __('Address'));
        $grid->column('phone', __('Phone'));
        $grid->column('paid_membership_flag', __('Paid Membership'))
        ->display(function($value) {
            return $value == 1 ? '有料会員' : '無料会員';
        });
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();
        $grid->column('deleted_at', __('Deleted at'))->sortable();

        $grid->filter(function($filter) {
            $filter->like('name', 'ユーザー名');
            $filter->like('email', 'メールアドレス');
            $filter->like('postal_code', '郵便番号');
            $filter->like('address', '住所');
            $filter->like('phone', '電話番号');
            $filter->between('created_at', '登録日')->datetime();
            $filter->scope('trashed', 'Soft deleted data')->onlyTrashed();
            $filter->equal('paid_membership_flag', '会員種別')->select([
                0 => '無料会員',
                1 => '有料会員'
            ]);
        });

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('postal_code', __('Postal code'));
        $show->field('address', __('Address'));
        $show->field('phone', __('Phone'));
        $show->field('paid_membership_flag', __('Paid Membership'))
        ->as(function($value) {
            return $value == 1 ? '有料会員' : '無料会員';
        });
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        $form->text('postal_code', __('Postal code'));
        $form->textarea('address', __('Address'));
        $form->text('phone', __('Phone'));
        $form->datetime('deleted_at', __('Deleted at'))->default(NULL);
        $form->ignore(['paid_membership_flag']);

        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            } else {
                $form->password = $form->model()->password;
            }
        });

        return $form;
    }
}