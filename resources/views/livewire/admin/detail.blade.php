<div>
    @section('css')
        <script src={{ asset('ckeditor/ckeditor.js') }}></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endsection
    <div>
        <div class="container">
    
    <h3><strong>Detail Data</strong></h3>
        @php
            $ikutan = [];
            foreach ($pengikutTerpilih as $orangikut) {
                $ikutan[] = $orangikut->id;
            }
        @endphp

        @if ($deleted_at != null)
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data ini telah dihapus !!! <i class="bi bi-emoji-frown"></i>
            </div>
        
            @elseif (Auth::user()->id == $user_id || in_array(Auth::user()->id, $ikutan) || (Auth::user()->can(['Akses Admin', 'Akses Super Admin']) && $deleted_at == null))
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="edit_toggle" wire:model.live = 'edit_toggle'>
                    <label class="form-check-label" for="edit_toggle"><b>Edit</b></label>
                </div>
            @endif
 
            
            
              @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  Edit Data Gagal !!! <i class="bi bi-emoji-frown"></i>
                  <ul>
                      @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
              @endif
            
            
            {{-- Penyusun --}}
            <div class="form-group mt-3" wire:ignore>
                <label for="user_id"><strong>Nama Penyusun</strong></label>
                <select name="user_id" id="user_id" class="form-control input-rounded select2">
                   <option disabled selected>Isikan Nama Pembuat</option>
                   @foreach ($users as $pengguna )
                      <option value="{{ $pengguna->id }}" {{ $pengguna->id == $user_id ? "selected" : "" }}               
                        >{{ $pengguna->name }}</option>
                   @endforeach
                   
                   </select>                   
                @error('user_id')
                   <div class="text-danger mt-2 d-block">{{ $message }}</div>
                @enderror   
                                               
              </div>

              <div class="form-group mt-3" wire:ignore>
                <label for="kategori"><strong>Pengikut</strong></label>
                <select name="pengikut" id="pengikut" class="form-control input-rounded select2" multiple>
                     <option disabled>Pengikut</option>
                   @foreach ($users as $pengikut )
                      <option value="{{ $pengikut->id }}"
                        @foreach ($pengikutTerpilih as $follow)
                            {{ $pengikut->id == $follow->id ? "selected" : "" }}
                        @endforeach  
                        >{{ $pengikut->name }}</option>
                   @endforeach
                   </select>                   
                   @error('pengikut') <span class="error" style="color: red">{{ $message }}</span> @enderror
              </div>
            
              <div class="form-group mt-3" wire:ignore>
                <label for="kategori"><strong>Pokja</strong></label>
                <select name="kategori" id="kategori" class="form-control input-rounded select2" multiple>
                     <option disabled>Pilih Pokja</option>
                   @foreach ($categories as $category )
                      <option value="{{ $category->id }}"
                        @foreach ($kategoriTerpilih as $kateg)
                            {{ $category->id == $kateg->id ? "selected" : "" }}
                        @endforeach  
                        >{{ $category->nama }}</option>
                   @endforeach
                   </select>                   
                   @error('kategori') <span class="error" style="color: red">{{ $message }}</span> @enderror
              </div>

              <div class="form-group mt-3" wire:ignore>
                <label for="iku"><strong>IKU</strong></label>
                <select name="iku" id="iku" class="form-control input-rounded select2" multiple>
                     <option disabled>Pilih IKU</option>
                   @foreach ($indicators as $indicator )
                      <option value="{{ $indicator->id }}"
                        @foreach ($ikuTerpilih as $ik)
                            {{ $indicator->id == $ik->id ? "selected" : "" }}
                        @endforeach  
                        >{{ $indicator->nama }}</option>
                   @endforeach
                   </select>                   
                   @error('iku') <span class="error" style="color: red">{{ $message }}</span> @enderror
              </div>
         
             
            <div class="form-group mt-3">
                <label for="no_st"><strong>Nomor Surat Tugas</strong></label>
                <input type="text" name="no_st" wire:model.live = "no_st" id="no_st" class="form-control input-rounded"
                    placeholder="Masukan Nomor Surat Tugas" value="{{ old('no_st') }}" maxlength="250"  {{ $edit_toggle != true ? "disabled" : "" }}>                  
                @error('no_st')
                <div class="text-danger mt-2 d-block">{{ $message }}</div> 
                @enderror                                  
            </div>
   
            <div class="mt-3">
                <label for="what"><strong>What</strong></label>
                    <textarea wire:model.live="what"
                        class="form-control"
                        name="what"
                        id="what"   {{ $edit_toggle != true ? "disabled" : "" }}>{{Request::old('what')}}</textarea>
                        @error('what')
                        <div class="text-danger mt-2 d-block">{{ $message }}</div>
                     @enderror                        
                </div>
     
    
            <div class="form-group mt-3">
                    <label for="where"><strong>Where</strong></label>
                    <input type="text" name="where" wire:model.live = "where" id="where"
                    class="form-control input-rounded" placeholder="Masukan Nomor Surat Tugas"
                    value="{{ old('where') }}" maxlength="250"  {{ $edit_toggle != true ? "disabled" : "" }}>                  
                    @error('where')
                    <div class="text-danger mt-2 d-block">{{ $message }}</div> 
                    @enderror                                  
            </div>

        
    
            <div class="row mt-3">
                <div class="form-group col-md-6">
                    <label for="when"><strong>When</strong></label>
                    <input type="date" name="when" id="when" wire:model.live="when" class="form-control input-rounded"
                    placeholder="Masukan Tanggal Mulai" value="{{ old('when') }}"
                    {{ $edit_toggle != true ? "disabled" : "" }} maxlength="250" >                  
                    @error('when')
                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                    @enderror                                  
                </div>
    
                <div class="form-group col-md-6">
                    <label for="tanggal_selesai"><strong>Tanggal Selesai (Isi When Terlebih Dahulu)</strong></label>
                    <input type="date" name="tanggal_selesai" wire:model.live="tanggal_selesai"
                    id="tanggal_selesai" class="form-control input-rounded" placeholder="Masukan Tanggal Selesai"
                    value="{{ old('tanggal_selesai') }}"  {{ $edit_toggle != true ? "disabled" : "" }}>                  
                    @error('tanggal_selesai')
                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                    @enderror                                  
                </div>
            </div>
    
            <div class="mt-3">
                <label for="why"><strong>Why</strong></label>
                    <textarea wire:model.live="why"
                        class="form-control"
                        name="why"
                        id="why"  {{ $edit_toggle != true ? "disabled" : "" }}>{{Request::old('why')}}</textarea>
                        @error('why')
                        <div class="text-danger mt-2 d-block">{{ $message }}</div>
                     @enderror                        
                </div>
           
        
             <div class="form-group mt-3">
                    <label for="penyelenggara"><strong>Penyelenggara</strong></label>
                    <input type="text" name="penyelenggara" id="penyelenggara" wire:model.live="penyelenggara"
                    class="form-control input-rounded" placeholder="Masukan Penyelenggara"
                    value="{{ old('penyelenggara') }}"  {{ $edit_toggle != true ? "disabled" : "" }}>                  
                    @error('penyelenggara')
                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                    @enderror                                  
            </div>
            
            <div class="mt-3">
                <label for="who"><strong>Who</strong></label>
                   <textarea wire:model.live="who"
                       class="form-control"
                       name="who"
                       id="who"  {{ $edit_toggle != true ? "disabled" : "" }}>{{Request::old('who')}}</textarea>
                       
                       <div id="countwho">
                    </div>      
                    @error('who')
                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                    @enderror                                  
                </div>
                
            <div class="form-group mt-3">
                    <label for="total_peserta"><strong>Total Peserta</strong></label>
                    <input type="number" name="total_peserta" id="total_peserta" wire:model.live="total_peserta"
                    class="form-control input-rounded" placeholder="Masukan Total Peserta"
                    value="{{ old('total_peserta') }}" step="0.01"  {{ $edit_toggle != true ? "disabled" : "" }}>                  
                    @error('total_peserta')
                    <div class="text-danger mt-2 d-block">{{ $message }}</div>
                    @enderror                                  
                </div>
            
                <div class="form-group mt-3">
                    <strong>Persentase Jumlah Wanita</strong> <br>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"  {{ $edit_toggle != true ? "readonly" : "" }} name="gender_wanita" wire:model.live="gender_wanita" id="inlineRadio0" value="0" {{{$gender_wanita == 0 ? "checked" : ""}}}>
                        <label class="form-check-label" for="inlineRadio0">0%</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"  {{ $edit_toggle != true ? "readonly" : "" }} name="gender_wanita" wire:model.live="gender_wanita" id="inlineRadio1" value="10" {{{$gender_wanita == 10 ? "checked" : ""}}}>
                        <label class="form-check-label" for="inlineRadio1">10%</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"  {{ $edit_toggle != true ? "readonly" : "" }} name="gender_wanita" wire:model.live="gender_wanita" id="inlineRadio2" value="20" {{{$gender_wanita == 20 ? "checked" : "" }}}>
                        <label class="form-check-label" for="inlineRadio2">20%</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"  {{ $edit_toggle != true ? "readonly" : "" }} name="gender_wanita" wire:model.live="gender_wanita" id="inlineRadio3" value="30" {{{$gender_wanita == 30 ? "checked" : ""}}}>
                        <label class="form-check-label" for="inlineRadio3">30%</label>
                    </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"  {{ $edit_toggle != true ? "readonly" : "" }} name="gender_wanita" wire:model.live="gender_wanita" id="inlineRadio4" value="40" {{{$gender_wanita == 40 ? "checked" : ""}}}>
                        <label class="form-check-label" for="inlineRadio4">40%</label>
                    </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"  {{ $edit_toggle != true ? "readonly" : "" }} name="gender_wanita" wire:model.live="gender_wanita" id="inlineRadio5" value="50" {{{$gender_wanita == 50 ? "checked" : ""}}}>
                        <label class="form-check-label" for="inlineRadio5">50%</label>
                    </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"  {{ $edit_toggle != true ? "readonly" : "" }} name="gender_wanita" wire:model.live="gender_wanita" id="inlineRadio6" value="60" {{{$gender_wanita == 60 ? "checked" : ""}}}>
                        <label class="form-check-label" for="inlineRadio6">60%</label>
                    </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"  {{ $edit_toggle != true ? "readonly" : "" }} name="gender_wanita" wire:model.live="gender_wanita" id="inlineRadio7" value="70"{{{$gender_wanita == 70 ? "checked" : ""}}}>
                        <label class="form-check-label" for="inlineRadio7">70%</label>
                    </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio"  {{ $edit_toggle != true ? "readonly" : "" }} name="gender_wanita" wire:model.live="gender_wanita" id="inlineRadio8" value="80" {{{$gender_wanita == 80 ? "checked" : ""}}}>
                        <label class="form-check-label" for="inlineRadio8">80%</label>
                    </div>
                     <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" {{ $edit_toggle != true ? "readonly" : "" }} name="gender_wanita" wire:model.live="gender_wanita" id="inlineRadio9" value="90" {{{$gender_wanita == 90 ? "checked" : ""}}}>
                        <label class="form-check-label" for="inlineRadio9">90%</label>
                    </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" {{ $edit_toggle != true ? "readonly" : "" }} name="gender_wanita" wire:model.live="gender_wanita" id="inlineRadio10" value="100" {{{$gender_wanita == 100 ? "checked" : ""}}}>
                        <label class="form-check-label" for="inlineRadio10">100%</label>
                    </div>
                </div>
          
                <div wire:ignore class="mt-3">
                    <label for="how"><strong>How</strong></label>
                        <textarea wire:model.live="how"
                            class="form-control"
                            name="how"
                            id="how">{{Request::old('how')}}</textarea>
                    </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                    
                        @if ($dokumentasi1_upload)
                        Dokumentasi 1 : <br>
                            <a href="{{ route('view_dok1', $dokumentasi1_upload) }}" target="_blank" rel="noopener noreferrer"><img src="{{ asset('dokumentasi/'.$dokumentasi1_upload) }}" width="50%"></a>
                         @endif
                    </div>
    
                    <div class="col-md-4">
                        @if ($dokumentasi2_upload)
                        Dokumentasi 2 : <br>
                        <a href="{{ route('view_dok2', $dokumentasi2_upload) }}" target="_blank" rel="noopener noreferrer"><img src="{{ asset('dokumentasi/'.$dokumentasi2_upload) }}" width="50%"></a>
                        @endif
                    </div>
    
                    <div class="col-md-4">
                        @if ($dokumentasi3_upload)
                        Dokumentasi 3 : <br>
                        <a href="{{ route('view_dok3', $dokumentasi3_upload) }}" target="_blank" rel="noopener noreferrer"><img src="{{ asset('dokumentasi/'.$dokumentasi3_upload) }}" width="50%"></a>
                        @endif
                    </div>
                   
                 </div>
                 <div class="row mt-3">
                    @if ($lainnya_upload || $st_upload)
                    <div class="row mt-3">
                        @if ($lainnya_upload)
                        <div class="col-md-4">
                            <a href="{{ route('view_lainnya', $lainnya_upload ) }}" class="btn btn-primary" target="_blank">Dokumentasi Lainnya</a>     
                        </div>
                        @endif

                        @if ($st_upload)
                        <div class="col-md-4">
                            <a href="{{ route('view_st', $st_upload ) }}" class="btn btn-info" target="_blank">Surat Tugas</a>     
                        </div>
                        @endif
                    </div>
                    @endif
                 </div>
                <div class="row mt-3">
                   <div class="col-md-4">
                   
                    @if ($dokumentasi1)
                    Dokumentasi 1 : <br>
                    <img src="{{ $dokumentasi1->temporaryUrl() }}" width="50%">
                    @endif
                   </div>
   
                   <div class="col-md-4">
                       @if ($dokumentasi2)
                       Dokumentasi 2 : <br>
                           <img src="{{ $dokumentasi2->temporaryUrl() }}" width="50%">
                       @endif
                   </div>
   
                   <div class="col-md-4">
                       @if ($dokumentasi3)
                       Dokumentasi 3 : <br>
                           <img src="{{ $dokumentasi3->temporaryUrl() }}" width="50%">
                       @endif
                   </div>
                  
                </div>
                {{-- <div class="row mt-3">
                    <div class="col-md-4">
                        @if ($st_upload)
                        ST : <br>
                        <a href="{{ route('view_st', $st_upload) }}" class="btn btn-info" target="_blank" rel="noopener noreferrer">Surat Tugas</a>
                        @endif
                    </div>
    
                    <div class="col-md-4">
                        @if ($lainnya_upload)
                        Dokumentasi Lainnya : <br>
                        <a href="{{ route('view_lainnya', $lainnya_upload) }}" class="btn btn-info" target="_blank" rel="noopener noreferrer">Dokumentasi Lainnya</a>
                        @endif
                    </div>
                 </div> --}}
                
                <div class="form-group mt-3" style="display : {{ $edit_toggle != true ? "none" : "" }} ">
                    <div class="row">
                    <div class="col-md-6 mt-4">
                    <label for="dokumentasi1"><strong>Dokumentasi 1</strong></label>
                    <input type="file" class="form-control input-rounded" wire:model.live="dokumentasi1" name="dokumentasi1" value="{{ old('documentation1') }}">
                    <div wire:loading wire:target="dokumentasi1">Upload Gambar</div>
                    <small>Ukuran Gambar Maksimal 1024 KB / 1 MB</small><br>
                    @error('dokumentasi1') <span class="error" style="color: red">{{ $message }}</span> @enderror
                    </div>
        
                    <div class="col-md-6 mt-4">
                    <label for="dokumentasi2"><strong>Dokumentasi 2</strong> (Jika Ada)</label>
                    <img width="50%" class="mb-2 img-preview2">
                    <input type="file" class="form-control input-rounded" wire:model.live="dokumentasi2" name="dokumentasi2" value="{{ old('documentation2') }}">
                    <small>Ukuran Gambar Maksimal 1024 KB / 1 MB</small> 
                    </div>
        
                    <div class="col-md-6 mt-4">
                    <label for="dokumentasi3"><strong>Dokumentasi 3</strong> (Jika Ada)</label>
                    <img width="50%" class="mb-2 img-preview3">
                    <input type="file" class="form-control input-rounded" wire:model.live="dokumentasi3" name="dokumentasi3" value="{{ old('documentation3') }}">
                    <small>Ukuran Gambar Maksimal 1024 KB / 1 MB</small> 
                    </div>
        
                    <div class="col-md-6 mt-4">
                    <label for="lainnya"><strong>Dokumentasi Lainnya</strong> (Jika Ada)</label>
                    <img width="50%" class="mb-2 img-previewlainnya">
                    <input type="file" class="form-control input-rounded" wire:model.live="lainnya" name="lainnya" value="{{ old('lainnya') }}" id="lainnya">
                    <small>Ukuran File Maksimal 10240 KB / 10 MB, Dapat Di Isi File Dokumen atau Gambar</small>
                    </div>
        
                    <div class="col-md-6 mt-4">
                    <label for="st"><strong>Masukan Surat Tugas</strong> (Jika Ada)</label>
                    <input type="file" class="form-control input-rounded" wire:model.live="st" name="st" value="{{ old('st') }}">
                    <small>Ukuran File Maksimal 3072 KB / 3 MB, Dianjurkan Dalam Bentuk PDF</small>
                    </div>
                    </div>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Edit Data Gagal !!! <i class="bi bi-emoji-frown"></i>
                    <ul>
                        @foreach ($errors->all() as $error)
                             <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            
            @if ($deleted_at == null)
                <div class="row">
                    <div class="text-center mt-5 mb-3" >
                        <button class="btn btn-primary mr" wire:click=submit type="submit" wire:loading.attr="disabled" style="display: {{ $edit_toggle != true ? "none" : "" }}">Edit</button>
                    
                    @if (!$edit_toggle)
                    <a href="{{ url('/') }}" wire:loading.attr="disabled" class="btn btn-warning ml-5 mr-1" >Kembali Ke Dashboard</a>
                    @endif
                        <a href="{{ url('pdf/'.$slug) }}" wire:loading.attr="disabled" class="btn btn-info ml-5" target="_blank">Cetak PDF</a>
                        
                        <div wire:loading>
                        Data Sedang Di Proses .....
                    </div>

                    <a href="{{ url('/reportdashboard') }}" wire:loading.attr="disabled" class="btn btn-dark ml-3" >Kembali Ke Rekap Laporan</a>
                    @can('Akses Admin')
                    <a href="{{ url('/admin') }}" wire:loading.attr="disabled" class="btn btn-success ml-5" >Dashboard Admin</a>
                    @endcan
                    
                    </div>
                </div>
            @else
                @can('Akses Admin')
                    <div class="row">
                        <div class="text-center mt-5 mb-3">
                            <a href="{{ url('/recycle') }}" class="btn btn-primary" >Kembali Ke Recycle</a>
                        </div>
                    </div>
                @endcan
            @endif
        
        
        </div>
    </div>    
</div>

    @push('script')
        <script>
            
    //CKE Editor
    CKEDITOR.editorConfig = function( config ) {
        config.toolbarGroups = [
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
            { name: 'forms', groups: [ 'forms' ] },
            '/',
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph', 'mathjax' ] },
            { name: 'links', groups: [ 'links' ] },
            { name: 'insert', groups: [ 'insert' ] },
            '/',
            { name: 'styles', groups: [ 'styles' ] },
            { name: 'colors', groups: [ 'colors' ] },
            { name: 'tools', groups: [ 'tools' ] },
            { name: 'others', groups: [ 'others' ] },
            { name: 'about', groups: [ 'about' ] }
        ];
    
        config.removeButtons = 'Flash';
    };
  
            try {
            const editor = CKEDITOR.replace(document.querySelector('#how'));
            editor.on('change', function(event){
                this.set('how', event.editor.getData());
            });
                } catch (error) {
                    console.error(error);
                }
        </script>
    @endpush
    
    @push('select2')
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
       
       $(document).ready(function() {
        $('#pengikut').select2();
                $('#pengikut').on('change', function (e) {
                    var data = $('#pengikut').select2("val");
                @this.set('pengikut', data);
                });
    });
    
    $(document).ready(function() {
        $('#kategori').select2();
                $('#kategori').on('change', function (e) {
                    var data = $('#kategori').select2("val");
                @this.set('kategori', data);
                });
    });

    $(document).ready(function() {
        $('#iku').select2();
                $('#iku').on('change', function (e) {
                    var data = $('#iku').select2("val");
                @this.set('iku', data);
                });
    });
    
   
    $(document).ready(function() {
        $('#user_id').select2();
                $('#user_id').on('change', function (e) {
                    var data = $('#user_id').select2("val");
                @this.set('user_id', data);
                });
    });
    </script>
    
    @endpush
    

