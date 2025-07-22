<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\App\Livewire\Page\PostIndex;
use Modules\Blog\App\Livewire\Admin\PostEdit;
use Modules\Blog\App\Livewire\Admin\PostForm;
use Modules\Blog\App\Livewire\Admin\PostList;

// Rotas do módulo Blog

// Página pública
Route::get('/posts', PostIndex::class)
    ->name('posts');

// Painel admin (autenticado e verificado)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('posts/posts-list', PostList::class)
        ->name('posts-list');

    Route::get('posts/post-novo', PostForm::class)
        ->name('post-novo');

    Route::get('posts/post-edit/{{posts}}/editar', PostEdit::class)
        ->name('post-edit');
});