 <!-- Modal -->
 <div class="modal fade" id="testMail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="testMailLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">

             <div class="modal-header">
                 <h5 class="modal-title" id="testMailLabel">{{ translate('Test Your Email') }}</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form action="{{ route('backend.testmail') }}" method="POST">
                 @csrf
                 <div class="modal-body">
                     <div class="form-inner mb-35">
                         <label>{{ translate('Email') }} <span class="text-danger">*</span></label>
                         <input type="email" name="email" value="{{ old('email') }}" class="username-input"
                             placeholder="{{ translate('Enter Email') }}" required>
                         @error('email')
                             <div class="error text-danger">{{ $message }}</div>
                         @enderror
                     </div>
                     <div class="form-inner mb-25">
                         <label>{{ translate('Message') }}</label>
                         <textarea name="message">{{ old('message') }}</textarea>
                         @error('message')
                             <div class="error text-danger">{{ $message }}</div>
                         @enderror
                     </div>
                 </div>
                 <div class="modal-footer border-white">
                     <button type="button" class="eg-btn btn--red py-1 px-3 rounded"
                         data-bs-dismiss="modal">{{ translate('Close') }}</button>
                     <button type="submit"
                         class="eg-btn btn--primary py-1 px-3 rounded">{{ translate('Send') }}</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
