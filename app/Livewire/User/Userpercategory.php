<?php

namespace App\Livewire\User;
use App\Models\Category;
use App\Models\User;
use App\Models\Report;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Userpercategory extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['sendnotifTambah' => 'notif'];

    public $paginate = 10;
    public $orderby = "when";
    public $asc = "DESC";
    public $checked = [];
    public $cari = "";
    public $mulai = "";
    public $akhir = "";
    public $selectPage= false;
    public $selectAll=false;
    public $selectedSubkategori = Null;
    public $subkategori = [];
    public $kategori = [];

    public function mulai(){
        $validatedData = $this->validate([
            'mulai' => 'nullable'
        ]);
    }


    public function akhir(){
        $validatedData = $this->validate([
            'akhir' => 'after_or_equal:mulai_',
        ], [
            'after_or_equal' => 'Tanggal Harus Sama Dengan Atau Lebih Dari Tanggal Awal',
            ]);
    }


    public function render()
    {
     
            return view('livewire.admin.dashboard',[
                "datas" => $this->datas,          
                "categories" => Category::get(),
            ]);
      
       
    }

    public function updatedKategori($kategori_id){
 
        $this->selectedSubkategori = Category::with('subcategories')->whereKey($kategori_id)->get();
        
    }

    public function updatedSelectPage($value){
        if ($value) {
            $this->checked = $this->datas->pluck('id')->toArray();
        } else {
            $this->checked = [];
        }
        
    }

    public function updatedChecked(){
        $this->selectPage =false;
    }

    
    public function isChecked($data_id)
    {
        return in_array($data_id, $this->checked);
    }

    public function selectAll(){
        $this->selectAll=true;
        $this->checked = $this->datasQuery->pluck('id')->toArray();
    }

    public function selectPart(){
        $this->selectAll=false;
        $this->checked = $this->datas->pluck('id')->toArray();
    }

    public function getDatasProperty(){
        return $this->datasQuery->paginate($this->paginate);
    }

    public function getDatasQueryProperty(){

        $category_user = Auth::user()->category;

            foreach($category_user as $datauser){
                $listdata[] =  $datauser->id;
              }
        
             return Report::whereHas('tescategory', function($list) use ($listdata){
                                  $list->whereIn('categories.id',$listdata);
                              })
                              ->when($this->mulai && $this->akhir, function($query){
                                  $query->whereBetween('when', [trim($this->mulai), trim($this->akhir)]);})
                              ->when($this->kategori, function($query){
                                      $query->whereHas('categories', function($categoryId){
                                      $categoryId->whereIn('category_id', $this->kategori);
                                  });
                              })
                              ->when($this->subkategori, function($query){
                                  $query->whereHas('subcategories', function($subcategoryId){
                                  $subcategoryId->whereIn('subcategory_id', $this->subkategori);
                              });
                              })->cari(trim($this->cari))
                              ->orderBy($this->orderby, $this->asc);
  
  
    }


    public function deleteDatas(){
        
        $reports = Report::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll=false;
        $this->selectPage=false;
        
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Data Berhasil Terhapus',
            'text' => '',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);
    }


    public function deleteSatuData($data_id){
        
        Report::where('id', $data_id)->delete();

        $this->checked = array_diff($this->checked, [$data_id]);
        
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => 'Data Berhasil Terhapus',
            'text' => '',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);
    }
}
