<?php
namespace App\Filters;
use App\User;
use Illuminate\Http\Request;
 


class ThreadFilters extends Filters
{
	
	protected $filters = ['by', 'popular', 'unanswered'];




	protected function by($username){
		if ($username = $this->request->by) {

            $user = User::where('name', $username)->firstOrFail();

            return $this->builder->where('user_id', $user->id);
        }


	}


	protected function popular()
	{
		$this->builder->getQuery()->orders = [];
		return $this->builder->orderBy('reply_count', 'desc');

		// or use Macro on bootable function
		// return $this->builder->reorder('reply_count', 'desc');

	}
	protected function unanswered()
	{
		$this->builder->getQuery()->orders = [];
		return $this->builder->where('reply_count', 0);

		// or use Macro on bootable function
		// return $this->builder->reorder('reply_count', 0);

	}


}