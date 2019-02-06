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
     * Tests that redirect to lists page works.
     *
     * @return void
     */
    public function testMainPage()
    {
        $response = $this->get('/');
        $response->assertRedirect('/lists');
        $response->assertStatus(301);
    }

    /**
     * Tests that all tasks are on the url lists.
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
     * Test that you can edit a task.
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
        $response = $this->post('/lists', ['title' => 'newTitle', 'body' => 'newBody']);
        $this->assertDatabaseHas('tasks', ['title' => 'newTitle', 'body' => 'newBody']);
        $response->assertStatus(200);
        $response->assertJson([
            'success' => 'Data is successfully added'
        ]);
    }

    /**
     * Tests that you can show a task.
     *
     * @return void
     */
    public function testShow()
    {
        foreach ($this->tasks as $task) {
            $response = $this->get('/lists/' . $task->id);
            $response->assertStatus(200);
            $response->assertOk();
            $response->assertJson([
                'status' => 'success',
                'id' => $task->id,
                'title' => $task->title,
                'body' => $task->body,
            ]);
        }
    }

    /**
     * Tests that you can update a task.
     *
     * @return void
     */
    public function testUpdate()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        foreach ($this->tasks as $task) {
            $response = $this->put('/lists/' . $task->id, ['title' => 'newTitle', 'body' => 'newBody']);
            $response->assertStatus(200);
            $response->assertOk();
            $response->assertJson([
                'success' => 'Data is successfully updated'
            ]);

            $this->assertDatabaseHas('tasks', ['title' => 'newTitle', 'body' => 'newBody']);
        }
    }

    /**
     * Tests that you can update a task.
     *
     * @return void
     */
    public function testDestroy()
    {
        foreach ($this->tasks as $task) {
            $response = $this->delete('/lists/' . $task->id);
            $response->assertStatus(200);
            $response->assertOk();
            $response->assertJson([
                'success' => 'Data is successfully deleted'
            ]);
        }

        $this->assertDatabaseMissing('tasks', ['title' => 'newTitle', 'body' => 'newBody']);
    }

}
