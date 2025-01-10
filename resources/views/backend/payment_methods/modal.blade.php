 <!-- Modal -->
 <div class="modal fade" id="paymentMethodsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="paymentMethodsModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">

             <div class="modal-header">
                 <h5 class="modal-title" id="paymentMethodsModalLabel">{{ translate('Edit Payment Method') }}</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>

             <form action="{{ route('payment.methods.update') }}" method="POST" enctype="multipart/form-data">
                 @csrf
                 <input type="hidden" name="method_id" id="method_id">
                 <div class="modal-body">
                     <div class="form-inner mb-35">
                         <label>{{ translate('Method') }}*</label>
                         <input type="text" id="method_name" class="username-input"
                             placeholder="{{ translate('Enter Method') }}" readonly>
                         @error('name')
                             <div class="error text-danger">{{ $message }}</div>
                         @enderror
                     </div>
                     <div class="form-inner mb-25">
                         <label>{{ translate('Logo') }}*</label>
                         <input type="file" name="logo" class="username-input" accept="image/*">
                         @error('image')
                             <div class="error text-danger">{{ $message }}</div>
                         @enderror
                         <img id="payment_method_logo" src="" alt="Payment Method Logo" height="40">
                     </div>
                     <div class="d-flex mb-25" id="method_mode_div">
                         <label>{{ translate('Change Mode') }}:</label>
                         <div class="form-check form-switch ms-2 me-2">
                             <input class="form-check-input method_mode" type="checkbox" id="method_mode"
                                 name="mode">
                         </div>
                         <button id="method_mode_btn" class="eg-btn orange-light--btn">Sandbox</button>
                     </div>
                     <div class="form-inner mb-35" id="method_key_div">
                         <label>{{ translate('Key') }}*</label>
                         <input type="text" id="method_key" name="method_key" class="username-input"
                             placeholder="{{ translate('Enter Key') }}" required>
                         @error('method_key')
                             <div class="error text-danger">{{ $message }}</div>
                         @enderror
                     </div>
                     <div class="form-inner mb-35" id="method_secret_div">
                         <label>{{ translate('Secret') }}*</label>
                         <input type="text" id="method_secret" name="method_secret" class="username-input"
                             placeholder="{{ translate('Enter Secret') }}" required>
                         @error('method_secret')
                             <div class="error text-danger">{{ $message }}</div>
                         @enderror
                     </div>
                     <div class="form-inner mb-35 conversion-rate" id="method_conversion_rate_div">
                         <label>{{ translate('Conversion Rate') }}* ({{ $default_currency->name }})</label>
                         <input type="hidden" id="conversion_currency_id" name="conversion_currency_id" value="1">
                         <div class="input-group mb-3">
                             <div class="input-group-prepend">
                                 <span class="input-group-text" id="conversion_currency_label">$1 = </span>
                             </div>
                             <input type="text" class="form-control" id="conversion_currency_rate"
                                 name="conversion_currency_rate" placeholder="0.00"
                                 aria-label="Amount (to the nearest dollar)" required>
                             <div class="input-group-append">
                                 <span class="input-group-text">{{ $default_currency->code }}</span>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer border-white">
                     <button type="button" class="eg-btn btn--red py-1 px-3 rounded"
                         data-bs-dismiss="modal">{{ translate('Close') }}</button>
                     <button type="submit"
                         class="eg-btn btn--primary py-1 px-3 rounded">{{ translate('Update') }}</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
