@extends('backend.layouts.master')
              @section('content')
              <div class="row mb-35">
                    <div class="page-title d-flex justify-content-between align-items-center">
                        <h4>{{$page_title ?? ''}}</h4>
                        <div class="language-changer">
                            <span>{{translate('Language Translation')}}: </span>
                            @foreach (\App\Models\Language::all() as $key => $language)
                                @if($lang == $language->code)
                                <img src="{{ asset('assets/img/flags/'.$language->code.'.png') }}" class="mr-3" height="16">
                                @else
                                <a href="{{route('category.edit',['id'=>$categorySingle->id, 'lang'=>$language->code] )}}"><img src="{{ asset('assets/img/flags/'.$language->code.'.png') }}" class="mr-3" height="16"></a>
                                @endif
                            @endforeach
                        </div>
                        <a href="{{route('category.list')}}" class="eg-btn btn--primary back-btn"> <img src="{{asset('backend/images/icons/back.svg')}}" alt="{{ translate('Go Back') }}"> {{ translate('Go Back') }}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                    <div class="eg-card product-card">
                        
                    <form action="{{route('category.update', $categorySingle->id)}}" method="POST" enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        <input type="hidden" name="lang" value="{{ $lang }}">
                        @csrf
                                <div class="form-inner mb-35 row">
                                    <label class="col-md-3 col-form-label">{{ translate('Name') }} <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" value="{{old('name',$categorySingle->getTranslation('name', $lang))}}" name="name" class="username-input" placeholder="{{ translate('Enter Name') }}">
                                        @error('name')
                                            <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-inner mb-25 row">
                                    <label class="col-md-3 col-form-label">{{ translate('Image') }}*</label>
                                    <div class="col-md-9">   
                                        <input type="file" name="image" class="password" accept="image/*">
                                        @error('image')
                                            <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                        <img src="{{asset('uploads/category/'.$categorySingle->image)}}" alt="{{$categorySingle->name}}" id="previewImage" width="100">
                                    </div>
                                </div>
                                    
                                
                            
                            <div class="button-group mt-15 text-center  ">
                                <input type="submit" class="eg-btn btn--green back-btn me-3" value="{{ translate('Update') }}">
                            </div>
                       
                        
                    </form>
                    </div>
                    </div>
                </div>
           @endsection