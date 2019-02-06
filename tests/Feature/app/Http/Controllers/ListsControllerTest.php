<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Http\Middleware\VerifyCsrfToken;
use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListsControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @var
     */
    private $tasks;
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->tasks = factory(Task::class, 10)->create();
    }


    /**
     * Tests that all users are on the url tasks.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/lists');
        $response->assertStatus(200);
        $response->assertViewIs('lists.index');
        $response->assertViewHas('tasks');
        foreach ($this->tasks as $task) {
            $this->assertDatabaseHas('tasks', $task->toArray());
        }
    }


    /**
     * Test that you can edit a user.
     *
     * @return void
     */
    public function testEdit()
    {
        foreach ($this->tasks as $task) {
            $response = $this->get('/lists/' . $task->id . '/edit');
            $response->assertStatus(200);
            $response->assertOk();
            $response->assertJson([
                'status' => 'success',
                'title' => $task->title,
                'body' => $task->body
            ]);
        }
    }

    /**
     * Tests that you can add a new task.
     *
     * @return void
     */
    public function testStore()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $response = $this->post('/tasks', ['newTaskName' => 'newNameName']);
        $response->assertRedirect('/tasks');
        $response->assertSessionHas(['success_created']);
        $this->assertDatabaseHas('tasks', ['name' => 'newNameName']);
    }
}
