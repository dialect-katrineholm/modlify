namespace App\Policies;

use App\{{$modelName}};
use Illuminate\Auth\Access\HandlesAuthorization;

class {{$modelName}}Policy {

	function index(User $user){
		return true;
	}

	function create(User $user){
		return true;
	}

	function show(User $user, {{$modelName}} {{$argumentName}}){
		return true;
	}

	function edit(User $user, {{$modelName}} {{$argumentName}}){
		return true;
	}

	function store(User $user){
		return true;
	}

	function update(User $user, {{$modelName}} {{$argumentName}}){
		return true;
	}

	function destroy(User $user, {{$modelName}} {{$argumentName}}){
		return true;
	}

}
