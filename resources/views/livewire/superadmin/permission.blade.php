<div>
    <div>
        <div class="container">
            <h2 class="mb-3 text-lg font-large leading-6 text-gray-900">Data Kategori</h2>
    
            <div class="row mb-2">
                {{-- Kolom Cari --}}
                <div class="col-md-3 col-sm-3 d-flex">
                      <input class="form-control form-control-sm" type="text" placeholder="Cari Data..." wire:model.live.debounce.300ms="cari"> 
                </div>

                   {{-- Pagination --}}
            <div class="col-md-2 col-sm-2 d-flex">
                <select wire:model.live="paginate" name="paginate" id="paginate" class="form-control form-control-sm rounded-md shadow-sm">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div class="col-md-3 col-sm-3 d-flex">
                <select wire:model.live="orderby" name="orderby" id="orderby" class="form-control form-control-sm rounded-md shadow-sm">
                    <option selected value="id">Urutan Default</option>
                    <option value="name">Nama</option>
 
                </select>
                <select wire:model.live="asc" name="asc" id="asc" class="form-control form-control-sm rounded-md shadow-sm">
                  <option value="ASC">Terkecil</option>
                  <option value="DESC">Terbesar</option>
                </select>
            </div>

            <div class="col-md-3 col-sm-3 d-flex">
                <div class="d-grid btn-group" role="group">
                  @if ($checked)
                  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Aksi ({{count($checked)}})
                  </button>
                  <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#" onclick="confirm('Yakin Ingin Menghapus {{ count($checked) }} Data ?')||event.stopImmediatePropagation()" wire:click="deleteDatas()">Delete ({{ count($checked) }})</a></li>           
                  </ul>
                  @endif
                </div>
              </div>
          
            </div>

            
            @if ($selectPage)
                <div class="col-md-10 my-3">
                @if ($selectAll)
                Anda Telah Memilih <strong>Seluruh Data ({{ $permissions->total() }} Data)</strong>
                <a href="#" role="button" class="badge bg-success" wire:click="selectPart" style="text-decoration: none">Pilih Yang Ditampilkan Saja</a>
                @else
                Anda Telah Memilih <strong>{{ count($checked) }} Data</strong>, Apakah Anda Ingin Memilih Seluruh Data <strong>({{ $permissions->total() }} Data)</strong> ?
                <a href="#" role="button" class="badge bg-primary" wire:click="selectAll" style="text-decoration: none">Pilih Semua</a>
                @endif
                </div>         
            @endif
            
            <div class="table-responsive-lg">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th><input type="checkbox" wire:model.live="selectPage"></th>
                          <th class="text-center col-1">No</th>
                          <th class="text-center col-4" >permission</th>
                          <th class="text-center col-3">Aksi</th>  
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($permissions as $permission) 
                            <tr class="@if ($this->isChecked($permission->id)) table-primary @endif"> 
                                <td><input type="checkbox" value="{{ $permission->id }}" wire:model.live="checked">
                                    @if ($editedpermissionIndex == $permission->id)
                                    @endif</td>
                                <td class="text-center col-1">{{ $loop->iteration }}</td>
                                <td class="text-center col-5">
                                    @if ($editedpermissionIndex !== $permission->id)
                                    
                                    {{ $permission->name }}
                                    
                                    @else
                                    <input  type="text" wire:model.live ="setpermissions.{{$permission->id}}.name" class="form-control
                                        {{$errors->first('name') ? "is-invalid" : "" }}" id="name">                                
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    @endif
                                   
                                    
                                    
                                </td>
                                
                                <td class="text-center col-3">
                                    @if (!$checked)
                                        @if ($editedpermissionIndex !== $permission->id)
                                            <a class="btn btn-outline-warning" wire:click.prevent="editpermission({{ $permission->id }})">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-outline-warning" wire:click.prevent="savepermission({{ $permission->id }})">
                                                <i class="bi bi-sd-card-fill"></i>
                                            </button>
                                        @endif
                                    {{-- <a class="btn btn-outline-warning" href=""><i class="bi bi-pencil-fill"></i></i></a> --}}
                                    @endif
                                    @if (!$checked)
                                    <a class="btn btn-outline-danger"
                                    onclick="confirm('Apakah Yakin Ingin Menghapus Data Survei Judul {{ $permission->name }} ?')||event.stopImmediatePropagation()"
                                    wire:click="deleteSatuData({{$permission->id}})" ><i class="bi bi-trash-fill"></i></a>    
                                    @endif
                      
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                </table>
            </div>
        </div>

        




    </div>
    
</div>
