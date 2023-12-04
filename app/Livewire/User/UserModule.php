<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\User;

class UserModule extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $model = User::class;
    public $fillable;
    public $module = 'user';
    public $view_title;
    
    public $perPage = 5, $search = '';
    
    public $action = '', $id, $obj;

    public $total_pages;

    public $current_page;

    
    

    public function mount()
    {
        $this->fillable = (new $this->model)->getFillable();
        $this->obj = array_fill_keys($this->fillable, '');
        $this->view_title = ucfirst($this->module);

        
    }

    public function render()
    {
        
        $objs = $this->model::where('status', '!=', 'T')
                            ->where(function($query){
                                $query->where('name', 'like', '%'.$this->search.'%')
                                ->orWhere('email', 'like', '%'.$this->search.'%');
                            })
                            ->orderBy('id', 'desc')
                            ->paginate($this->perPage, pageName: "page");

        return view("livewire.{$this->module}.{$this->module}-module",

            [
                'objs' => $objs
            ]);
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    
    public function updatedPerPage()
    {   
        $this->resetPage();
       
    }   
    

    public function openModal($action, $id = null)
    {
        $this->action = $action;

        if($id != null && $id != ''){
            $this->id = $id;
            $this->obj = $this->model::find($id)->only($this->fillable);
            $this->obj['password'] = '';
        }else{
            $this->id = null;
            $this->obj = array_fill_keys($this->fillable, '');
        }
        
        $this->resetValidation();
        
        $this->dispatch('showModal');
    }

    public function create(){
     
        $this->validate([
            'obj.name' => 'required',
            'obj.email' => 'required|email|unique:users,email',
            'obj.password' => 'required|min:6',
        ]);
        

        $this->obj['password'] = bcrypt($this->obj['password']);
        //only not null and empty
        $data = array_filter($this->obj, function($value) { return $value !== ''; });
        $data['status'] = 'A';

        $this->model::create($data);

        $this->dispatch('closeModal');

    }

    public function update(){
         
            $this->validate([
                'obj.name' => 'required',
                'obj.email' => 'required|email|unique:users,email,'.$this->id,
                'obj.password' => 'nullable|min:6',
            ]);
            
            if($this->obj['password'] != ''){
                $this->obj['password'] = bcrypt($this->obj['password']);
            }else{
                unset($this->obj['password']);
            }
    
            $this->model::find($this->id)->update($this->obj);
    
            $this->dispatch('closeModal');

            $this->dispatch('showSuccess');
    
    }

    public function changeStatus($id, $status){

        $this->dispatch('changeStatus', ['id' => $id, 'status' => $status]);
    }

    public function changeStatusConfirm($data){

        $this->model::find($data['id'])->update(['status' => $data['status']]);

        $this->dispatch('showSuccess');
        

    }
    
}
