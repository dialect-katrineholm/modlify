namespace Tests\Feature;;

use Tests\TestCase;
use \App\{{$modelName}};
class {{$modelName}}Test extends TestCase
{

	/** {{'@'.'test'}} */
	public function it_can_list_{{$tableName}}(){
		{{$variableName}} = factory({{$modelName}}::class)->create();
		$this->get("/{{$resourceName}}")->assertSee("".{{$variableName}}->{{$checkColumn}});
	}

    /** {{'@'.'test'}} */
	public function it_can_show_{{$tableName}}(){
        {{$variableName}} = factory({{$modelName}}::class)->create();
		$this->get("/{{$resourceName}}/{{$variableName}}->id")->assertSee("".{{$variableName}}->{{$checkColumn}});
	}

    /** {{'@'.'test'}} */
	public function it_can_create_{{$tableName}}(){
		$this->get("/{{$resourceName}}/create")->assertStatus(200);
	}

    /** {{'@'.'test'}} */
	public function it_can_store_{{$tableName}}(){
        $data = factory({{$modelName}}::class)->make()->toArray();
@if($hasPassword)
        $password = [
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
        $this->post("/{{$resourceName}}", $password + $data)->assertRedirect();;
@else
        $this->post("/{{$resourceName}}", $data)->assertRedirect();;
@endif
		$this->assertDatabaseHas("{{$tableName}}", $data);
	}

    /** {{'@'.'test'}} */
	public function it_can_edit_{{$tableName}}(){
        {{$variableName}} = factory({{$modelName}}::class)->create();
		$this->get("/{{$resourceName}}/{{$variableName}}->id/edit")->assertStatus(200);
	}

    /** {{'@'.'test'}} */
	public function it_can_update_{{$tableName}}(){
		{{$variableName}}Old = factory({{$modelName}}::class)->create();
        {{$variableName}}New = factory({{$modelName}}::class)->make()->toArray();
@if($hasPassword)
        unset({{$variableName}}New['password']);
@endif
        $this->put("/{{$resourceName}}/".{{$variableName}}Old->id, {{$variableName}}New)->assertRedirect();

        $this->assertDatabaseHas("{{$tableName}}", {{$variableName}}New);
        $this->assertDatabaseMissing("{{$tableName}}", {{$variableName}}Old->toArray());
	}

    /** {{'@'.'test'}} */
	public function it_can_destroy_{{$tableName}}(){
		{{$variableName}} = factory({{$modelName}}::class)->create();
		$this->delete("/{{$resourceName}}/{{$variableName}}->id")->assertRedirect();
		$this->assertDatabaseMissing("{{$tableName}}", {{$variableName}}->toArray());
	}

}
