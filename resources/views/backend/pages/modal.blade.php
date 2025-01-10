<!-- Modal -->
<div class="modal fade" id="createPage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createPageLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="pagesCreateForm" action="{{route('page.store')}}"  method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createPageLabel">{{translate('Create New Page')}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('Page Name')}} *</label>
                                        <input type="text" class="username-input" placeholder="{{translate('Enter Page Name')}}" name="page_name" id="page_name">
                                        @error('page_name')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer border-white">
                                    <button type="button" class="eg-btn btn--red py-1 px-3 rounded" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="eg-btn btn--primary py-1 px-3 rounded">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>