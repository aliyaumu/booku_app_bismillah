<?php

use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows anyone to access public landing page', function () {
    $response = $this->get(route('landing'));
    $response->assertStatus(200);
});

it('allows anyone to access public catalog', function () {
    $response = $this->get(route('books.catalog'));
    $response->assertStatus(200);
});

it('allows anyone to access public book details', function () {
    $category = Category::create([
        'name' => 'Fiction',
        'slug' => 'fiction',
        'color' => '#F59E0B',
    ]);
    
    $book = Book::create([
        'category_id' => $category->id,
        'title' => 'Test Book Title',
        'slug' => 'test-book-slug',
        'author' => 'Test Author',
        'total_stock' => 5,
        'available_stock' => 5,
    ]);

    $response = $this->get(route('books.show', $book->slug));
    $response->assertStatus(200);
});

it('allows authenticated members to access member dashboard', function () {
    $user = User::factory()->create(['role' => 'member']);
    
    $response = $this->actingAs($user)->get(route('member.dashboard'));
    $response->assertStatus(200);
});

it('allows authenticated members to access member catalog and details', function () {
    $user = User::factory()->create(['role' => 'member']);
    $category = Category::create([
        'name' => 'Fiction',
        'slug' => 'fiction-2',
        'color' => '#F59E0B',
    ]);
    
    $book = Book::create([
        'category_id' => $category->id,
        'title' => 'Test Book Title 2',
        'slug' => 'test-book-slug-member',
        'author' => 'Test Author 2',
        'total_stock' => 5,
        'available_stock' => 5,
    ]);

    $response = $this->actingAs($user)->get(route('member.books.index'));
    $response->assertStatus(200);

    $responseDetail = $this->actingAs($user)->get(route('member.books.show', $book->slug));
    $responseDetail->assertStatus(200);
});
