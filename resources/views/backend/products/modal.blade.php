 <!-- Modal -->
                    <div class="modal fade" id="staticBackdropReview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropReviewLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropReviewLabel">{{ translate('Reply Message') }}*</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{route('products.review.reply')}}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" id="product_id">
                            <input type="hidden" name="review_id" id="review_id">
                            <div class="modal-body">
                                    <div class="form-inner mb-35">
                                        <textarea type="text" name="reply_message" rows="5" id="reply_message" class="username-input" placeholder="{{ translate('Reply Message') }}" required></textarea>
                                    </div>
                            </div>
                            <div class="modal-footer border-white">
                                <button type="button" class="eg-btn btn--red py-1 px-3 rounded" data-bs-dismiss="modal">{{ translate('Close') }}</button>
                                <button type="submit" class="eg-btn btn--primary py-1 px-3 rounded">{{ translate('Submit') }}</button>
                            </div>
                            </form>
                            </div>
                        </div>
                    </div>