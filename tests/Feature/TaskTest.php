<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function test_homepage(): void
    {
        $response = $this->get('/');


        $response->assertStatus(200);
    }
//    public function test_database_is_empty(): void
//    {
//
//    }
    public function test_creating_task(): void
    {
        $task = Task::create([
            'description'=>'first task'
        ]);
        $task = Task::create([
            'description'=>'second task'
        ]);
        $this->assertDatabaseHas('tasks',[
            'description'=>'first task'
        ]);
        $this->assertDatabaseHas('tasks',[
            'description'=>'second task'
        ]);

    }
    public function test_updating_task(): void
    {
        Task::create([
            'description'=>'first task'
        ]);
        $task = Task::first();
        $task->update([
            'description'=>'updated description'
        ]);
        $this->assertDatabaseHas('tasks',[
            'description'=>'updated description'
        ]);

    }
    public function test_deleting_task(): void
    {
        Task::create([
            'description'=>'first task'
        ]);
        $task = Task::first();
        $this->assertDatabaseCount('tasks',1);
        $task->delete();
        $task = Task::first();
        $this->assertDatabaseCount('tasks',0);

    }
}
