 <!-- Modal -->
 <div class="modal fade" id="languageBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="languageBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">

             <div class="modal-header">
                 <h5 class="modal-title" id="languageBackdropLabel">{{ translate('Add New Language') }}</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form action="{{ route('languages.store') }}" method="POST" enctype="multipart/form-data">
                 @csrf
                 <div class="modal-body">
                     <input type="hidden" name="language_id" id="language_id">
                     <div class="form-inner mb-35">
                         <label>{{ translate('Name') }} *</label>
                         <input type="text" name="name" id="language_name" value="{{ old('name') }}"
                             class="username-input" placeholder="{{ translate('Enter Name') }}" required>
                         @error('name')
                             <div class="error text-danger">{{ $message }}</div>
                         @enderror
                     </div>
                     <div class="form-inner mb-25">
                         <label>{{ translate('Code') }} *</label>
                         @php
                             $languagesArray = \App\Models\Language::pluck('code')->toarray();
                         @endphp
                         <select id="language_code" class="form-control js-example-basic-single mb-2 mb-md-0"
                             name="code">
                             @foreach (\File::files(public_path('assets/img/flags')) as $path)
                                 @if (!in_array(pathinfo($path)['filename'], $languagesArray))
                                     <option value="{{ pathinfo($path)['filename'] }}">
                                         {{ strtoupper(pathinfo($path)['filename']) }}</option>
                                 @endif
                             @endforeach
                         </select>
                         @error('image')
                             <div class="error text-danger">{{ $message }}</div>
                         @enderror
                     </div>
                 </div>
                 <div class="modal-footer border-white">
                     <button type="button" class="eg-btn btn--red py-1 px-3 rounded"
                         data-bs-dismiss="modal">{{ translate('Close') }}</button>
                     <button type="submit"
                         class="eg-btn btn--primary py-1 px-3 rounded">{{ translate('Save') }}</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
