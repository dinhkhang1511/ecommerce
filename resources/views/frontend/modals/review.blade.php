<div class="modal fade" id="reviews" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $product->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('review', ['product' => $product->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @if ($errors->first())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first() }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="modal-body">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <div class="page mb-3">
                        <div class="page__demo">
                            <div class="page__group">
                                <span class="page__hint">Reviews</span>
                                <div class="rating">
                                    <input type="radio" name="rating" value="1"
                                        class="rating__control screen-reader" id="rc1" checked>
                                    <input type="radio" name="rating" value="2"
                                        class="rating__control screen-reader" id="rc2">
                                    <input type="radio" name="rating" value="3"
                                        class="rating__control screen-reader" id="rc3">
                                    <input type="radio" name="rating" value="4"
                                        class="rating__control screen-reader" id="rc4">
                                    <input type="radio" name="rating" value="5"
                                        class="rating__control screen-reader" id="rc5">
                                    <label for="rc1" class="rating__item">
                                        <svg class="rating__star">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                        <span class="screen-reader">1</span>
                                    </label>
                                    <label for="rc2" class="rating__item">
                                        <svg class="rating__star">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                        <span class="screen-reader">2</span>
                                    </label>
                                    <label for="rc3" class="rating__item">
                                        <svg class="rating__star">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                        <span class="screen-reader">3</span>
                                    </label>
                                    <label for="rc4" class="rating__item">
                                        <svg class="rating__star">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                        <span class="screen-reader">4</span>
                                    </label>
                                    <label for="rc5" class="rating__item">
                                        <svg class="rating__star">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                        <span class="screen-reader">5</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('rating') 
                            <div class="error text-center">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <textarea class="form-control" rows="3" id="review"
                        placeholder="Share your feedback, reviews about this product" name="body"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="custom-file custom-file-review">
                        <input type="file" class="custom-file-input" accept="image/*" id="imgInp" name="images[]" multiple>
                        <label class="custom-file-label">Choose Images</label>
                    </div>
                    <button type="submit" class="btn btn-success" id="reviewBtn" disabled>Save</button>
                </div>
            </form>
        </div>
    </div>
</div>