<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Factories\TaskFactory;
use App\Http\Controllers\TaskController;

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
        $this->assertDatabaseCount('tasks',0);

    }
    public function test_task_factory()
    {
        Task::factory(20)->create();
        $this->assertDatabaseCount('tasks',20);
    }

    public function test_post_method_store()
    {
        $response = $this->post('/tasks',['description'=>'desc-1']);
        $response->assertStatus(201);
        $this->assertDatabaseCount('tasks',1);
    }
    public function test_store_method()
    {
        $response = $this->post('/tasks',['description'=>'desc-1']);
        $response->assertStatus(201);
        $this->assertDatabaseCount('tasks',1);
    }

    public function test_destroy_method()
    {
        $task = Task::create([
            'description'=>'desc-1'
        ]);
        $this->assertDatabaseCount('tasks',1);
        $this->assertDatabaseHas('tasks',['description'=>'desc-1']);

        $response = $this->delete('/tasks/'.$task->id);

        $this->assertDatabaseCount('tasks',0);
        $response->assertStatus(204);

    }
    public function test_update_method()
    {
        $task = Task::create([
            'description' => 'Des-1'
        ]);
        $this->assertDatabaseHas('tasks',['description'=>'Des-1']);
        $this->assertDatabaseCount('tasks',1);

        $this->put('/tasks/'.$task->id,['description'=>'New Des-1']);
        $this->assertDatabaseHas('tasks',['description'=>'New Des-1']);
        $this->assertDatabaseCount('tasks',1);

    }
}
