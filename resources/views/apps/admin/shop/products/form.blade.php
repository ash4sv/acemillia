@php
    $route = 'admin.shop.products.';
@endphp

<form action="{{ isset($product) ? route( $route . 'update', $product->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    @if(isset($product))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="" class="form-control" value="{{ old('name', $product->name ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="categories" class="form-label">Category</label>
        <select name="categories" id="category-select" class="form-select select2">
            <option value="">Select value</option>
            @php
                $selectedCategories = old('categories', $product?->categories?->pluck('id')->toArray() ?? []);
            @endphp
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Container where the Sub Category select will be appended -->
    <div id="sub-category-container">
        @if(isset($product) && $product->sub_category_id)
            <div class="mb-3">
                <label for="sub_category" class="form-label">Sub Category</label>
                <select name="sub_category" id="sub_category" class="form-select">
                    <option value="">Select Sub Category</option>
                    {{-- You may optionally load the saved sub category here if you prefer not to wait for AJAX --}}
                </select>
            </div>
        @endif
    </div>

    <div class="mb-3">
        <label for="tags" class="form-label">Tags</label>
        <select name="tags[]" id="" class="form-select select2" multiple>
            <option value="">Select value</option>
            @php
                $selectedTags = old('tags', $product?->tags?->pluck('id')->toArray() ?? []);
                if (!isset($product)) {
                    $selectedTags = old('tags', []);
                }
            @endphp
            @foreach($tags as $key => $tag)
                <option
                    {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}
                    value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="nav-align-top mb-3">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <button type="button"
                        class="nav-link active" role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#product-description-tab"
                        aria-controls="product-description-tab"
                        aria-selected="true">Product Description</button>
            </li>
            <li class="nav-item">
                <button type="button"
                        class="nav-link" role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#description-tab"
                        aria-controls="description-tab"
                        aria-selected="false">Description</button>
            </li>
            <li class="nav-item">
                <button type="button"
                        class="nav-link" role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#information-tab"
                        aria-controls="information-tab"
                        aria-selected="false">Delivery & Return Information</button>
            </li>
        </ul>
        <div class="tab-content px-0 pt-2 pb-0">
            <div class="tab-pane fade show active" id="product-description-tab" role="tabpanel">
                <label for="product_description" class="form-label">Product Description</label>
                <textarea name="product_description" id="" class="form-control text-editor">{!! old('product_description', $product->product_description ?? '') !!}</textarea>
            </div>
            <div class="tab-pane fade" id="description-tab" role="tabpanel">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="" class="form-control text-editor">{!! old('', $product->description ?? '') !!}</textarea>
            </div>
            <div class="tab-pane fade" id="information-tab" role="tabpanel">
                <label for="information" class="form-label">Information</label>
                <textarea name="information" id="" class="form-control text-editor">{!! old('', $product->information ?? '') !!}</textarea>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="" class="form-label">Main Image</label>
        <input type="file" name="main_image" id="" class="form-control" accept="image/*" value="{{ old('main_image', $product->image ?? '') }}">

        @isset($product->image)
            <div class="existing-images mt-3">
                <p class="mb-2"><small>Main Image:</small></p>
                <div class="d-flex flex-wrap">
                    <div class="image-preview position-relative me-2 mb-2">
                        <img src="{{ asset($product->image) }}" alt="Merchandise Image" class="img-thumbnail" width="100">
                        <button type="button" class="btn btn-sm btn-icon btn-danger position-absolute top-0 end-0 remove-image">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endisset
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Images</label>
        <input type="file" name="image[]" id="" class="form-control" multiple accept="image/*" value="{{--{{ old('image', $product->image ?? '') }}--}}">

        @if(isset($product) && $product->images->isNotEmpty())
            <div class="existing-images mt-3">
                <p class="mb-2"><small>Uploaded Images:</small></p>
                <div class="d-flex flex-wrap">
                    @foreach($product->images as $image)
                        <div class="image-preview position-relative me-2 mb-2">
                            <img src="{{ asset($image->image_path) }}" alt="Merchandise Image" class="img-thumbnail" width="100">
                            <button type="button" class="btn btn-sm btn-icon btn-danger position-absolute top-0 end-0 remove-image" data-image-id="{{ $image->id }}">
                                <i class="ti ti-trash"></i>
                            </button>
                            <input type="hidden" name="existing_image_ids[]" value="{{ $image->id }}">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-6">
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" name="price" id="" class="form-control" value="{{ old('price', isset($product) ? $product->getOriginal('price') : '') }}">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="sku" class="form-label">SKU</label>
                <input type="text" name="sku" id="" class="form-control" value="{{ old('sku', $product->sku ?? '') }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="mb-3">
                <label for="weight" class="form-label">Weight</label>
                <input type="text" name="weight" id="" class="form-control" value="{{ old('weight', $product->weight ?? '') }}">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="text" name="stock" id="" class="form-control" value="{{ old('weight', $product->stock ?? '') }}">
            </div>
        </div>
    </div>

    {{--<div class="mb-3">
        <label for="" class="form-label">Stock status</label>

    </div>--}}

    <div id="options-container">
        @if(isset($product) && $product->options->isNotEmpty())
            @foreach($product->options as $optionIndex => $option)
                <div class="option-group">
                    <div class="mb-3 d-flex align-items-center">
                        <div class="py-2 me-2 bg-primary text-white text-center rounded-2 flex-grow-1">New Option {{ $optionIndex + 1 }}</div>
                        <button type="button" class="btn btn-icon btn-danger remove-option"><i class="ti ti-trash"></i></button>
                    </div>
                    <div class="input-group mb-3">
                        <input type="hidden" name="options[{{ $optionIndex }}][id]" value="{{ $option->id }}">
                        <input type="text" name="options[{{ $optionIndex }}][name]" class="form-control" value="{{ $option->name }}" placeholder="e.g., Size, Color">
                        <input type="file" name="options[{{ $optionIndex }}][image_path]" class="form-control" accept="image/*" value="{{ $option->image_path }}">
                        @isset($option->image_path)
                            <a href="" class="btn btn-label-primary btn-icon"><i class="ti ti-picture-in-picture-off"></i></a>
                        @endisset
                    </div>
                    <hr>
                    <div class="values-container">
                        @foreach($option->values as $valueIndex => $value)
                            <div class="input-group mb-3">
                                <input type="hidden" name="options[{{ $optionIndex }}][values][{{ $valueIndex }}][id]" value="{{ $value->id }}">
                                <input type="text" name="options[{{ $optionIndex }}][values][{{ $valueIndex }}][value]" class="form-control" value="{{ $value->value }}" placeholder="Value">
                                <input type="number" name="options[{{ $optionIndex }}][values][{{ $valueIndex }}][additional_price]" class="form-control" value="{{ $value->additional_price }}" placeholder="Additional Price" step="0.01">
                                <input type="number" name="options[{{ $optionIndex }}][values][{{ $valueIndex }}][stock]" id="" class="form-control" value="{{ $value->stock }}" placeholder="Stock" step="0.01">
                                <input type="file" name="options[{{ $optionIndex }}][values][{{ $valueIndex }}][image_path]" class="form-control" accept="image/*" value="{{ $value->image_path }}">
                                @isset($value->image_path)
                                    <a href="" class="btn btn-label-primary btn-icon"><i class="ti ti-picture-in-picture-off"></i></a>
                                @endisset
                                <button type="button" class="btn btn-icon btn-label-danger remove-value" data-option-index="{{ $optionIndex }}"><i class="ti ti-trash"></i></button>
                            </div>
                        @endforeach
                        <div class="input-group mb-3">
                            <input type="text" name="options[{{ isset($product) ? $optionIndex : 0 }}][values][{{ isset($option) ? $option->values->count() : 0 }}][value]" class="form-control" value="" placeholder="Value">
                            <input type="number" name="options[{{ isset($product) ? $optionIndex : 0 }}][values][{{ isset($option) ? $option->values->count() : 0 }}][additional_price]" class="form-control" value="" placeholder="Additional Price" step="0.01">
                            <input type="number" name="options[{{ isset($product) ? $optionIndex : 0 }}][values][{{ isset($option) ? $option->values->count() : 0 }}][stock]" id="" class="form-control" value="" placeholder="Stock" step="0.01">
                            <input type="file" name="options[{{ isset($product) ? $optionIndex : 0 }}][values][{{ isset($option) ? $option->values->count() : 0 }}][image_path]" class="form-control" accept="image/*">
                            <button type="button" class="btn btn-icon btn-label-primary add-value" data-option-index="{{ isset($product) ? $optionIndex : 0 }}"><i class="ti ti-plus"></i></button>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <div class="option-group">
            <div class="mb-3 d-flex align-items-center">
                <div class="py-2 me-2 bg-primary text-white text-center rounded-2 flex-grow-1">New Option</div>
                <button type="button" id="add-option" class="btn btn-primary btn-icon"><i class="ti ti-plus"></i></button>
            </div>
            <div class="input-group mb-3">
                <input type="text" name="options[{{ isset($product) ? $product->options->count() : 0 }}][name]" class="form-control" value="" placeholder="e.g., Size, Color">
                <input type="file" name="options[{{ isset($product) ? $product->options->count() : 0 }}][image_path]" class="form-control" accept="image/*">
            </div>
            <hr>
            <div class="values-container">
                <div class="input-group mb-3">
                    <input type="text" name="options[{{ isset($product) ? $product->options->count() : 0 }}][values][0][value]" class="form-control" value="" placeholder="Value">
                    <input type="number" name="options[{{ isset($product) ? $product->options->count() : 0 }}][values][0][additional_price]" class="form-control" value="" placeholder="Additional Price" step="0.01">
                    <input type="number" name="options[{{ isset($product) ? $product->options->count() : 0 }}][values][0][stock]" id="" class="form-control" value="" placeholder="Stock" step="0.01">
                    <input type="file" name="options[{{ isset($product) ? $product->options->count() : 0 }}][values][0][image_path]" class="form-control" accept="image/*">
                    <button type="button" class="btn btn-icon btn-label-primary add-value" data-option-index="{{ isset($product) ? $product->options->count() : 0 }}"><i class="ti ti-plus"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        {!! \App\Services\Publish::publishBtn($product->status ?? 'Draft') !!}
    </div>

    <div class="mb-0">
        <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update' : 'Create' }} Product</button>
        <button type="reset" class="btn btn-label-secondary">Cancel</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Pre-selected sub category (if editing an existing product)
        var preSelectedSubCategory = '{{ old("sub_category", isset($product) ? $product->sub_categories->pluck("id")->first() : "") }}';

        // Function to load subcategories via AJAX for a given categoryId
        function loadSubCategories(categoryId) {
            // Build the URL using a placeholder replacement
            var url = "{{ route('admin.shop.categories.subcategories', ['category' => ':id']) }}";
            url = url.replace(':id', categoryId);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    if(data.length > 0) {
                        var html  = '<div class="mb-3">';
                        html += '<label for="sub_category" class="form-label">Sub Category</label>';
                        html += '<select name="sub_category" id="sub_category" class="form-select select2">';
                        html += '<option value="">Select Sub Category</option>';
                        $.each(data, function(index, subcategory) {
                            html += '<option value="'+ subcategory.id +'">'+ subcategory.name +'</option>';
                        });
                        html += '</select></div>';

                        $('#sub-category-container').html(html);

                        // Pre-select the value if editing an existing product
                        if(preSelectedSubCategory) {
                            $('#sub_category').val(preSelectedSubCategory);
                        }

                        // Destroy any existing select2 instance (if needed)
                        if ($('#sub_category').data('select2')) {
                            $('#sub_category').select2('destroy');
                        }

                        // Reinitialize select2 for the new element, specifying dropdownParent if necessary
                        $('#sub_category').select2({
                            dropdownParent: $('#sub-category-container')
                        });
                    } else {
                        $('#sub-category-container').html('');
                    }
                },
                error: function() {
                    console.error('Failed to fetch subcategories.');
                }
            });
        }

        // Listen for changes on the category select field
        $('#category-select').on('change', function() {
            var categoryId = $(this).val();
            if(categoryId) {
                loadSubCategories(categoryId);
            } else {
                $('#sub-category-container').html('');
            }
        });

        // On page load, if a category is already selected (edit mode), load its subcategories
        if($('#category-select').val()){
            loadSubCategories($('#category-select').val());
        }

        /**
         * Show a confirmation dialog using SweetAlert2 and remove the provided element if confirmed.
         *
         * @param {jQuery} $element - The jQuery element to remove.
         * @param {string} confirmText - The message shown in the confirmation dialog.
         * @param {string} successText - The message shown after removal.
         */
        function confirmAndRemove($element, confirmText, successText) {
            Swal.fire({
                title: 'Are you sure?',
                text: confirmText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $element.remove();
                    Swal.fire('Removed!', successText, 'success');
                }
            });
        }

        // Remove an existing product image with confirmation
        $(document).on('click', '.remove-image', function() {
            const $imagePreview = $(this).closest('.image-preview');
            confirmAndRemove($imagePreview, "Do you really want to remove this image?", "The image has been removed.");
        });

        // Remove an option block with confirmation
        $(document).on('click', '.remove-option', function() {
            const $optionGroup = $(this).closest('.option-group');
            confirmAndRemove($optionGroup, "Do you really want to remove this option?", "The option has been removed.");
        });

        // Remove a value within an option with confirmation
        $(document).on('click', '.remove-value', function() {
            const $inputGroup = $(this).closest('.input-group');
            confirmAndRemove($inputGroup, "Do you really want to remove this value?", "The value has been removed.");
        });

        // Variables for dynamic option/value indexing
        var optionIndex = 1;
        var valueIndex = 0;

        // Add a new option
        $(document).on('click', '#add-option', function() {
            const optionHtml = `
            <div class="option-group">
                <div class="mb-3 d-flex align-items-center">
                    <div class="py-2 me-2 bg-primary text-white text-center rounded-2 flex-grow-1">
                        New Option ${optionIndex + 1}
                    </div>
                    <button type="button" class="btn btn-icon btn-danger remove-option">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="options[${optionIndex}][name]" class="form-control" placeholder="e.g., Size, Color">
                    <input type="file" name="options[${optionIndex}][image_path]" class="form-control" accept="image/*">
                </div>
                <hr>
                <div class="values-container">
                    <div class="input-group mb-3">
                        <input type="text" name="options[${optionIndex}][values][${valueIndex}][value]" class="form-control" placeholder="Value">
                        <input type="number" name="options[${optionIndex}][values][${valueIndex}][additional_price]" class="form-control" placeholder="Additional Price" step="0.01">
                        <input type="number" name="options[${optionIndex}][values][${valueIndex}][stock]" id="" class="form-control" value="" placeholder="Stock" step="0.01">
                        <input type="file" name="options[${optionIndex}][values][${valueIndex}][image_path]" class="form-control" accept="image/*">
                        <button type="button" class="btn btn-icon btn-label-primary add-value" data-option-index="${optionIndex}">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
            $('#options-container').append(optionHtml);
            optionIndex++;
        });

        // Add a new value within an option
        $(document).on('click', '.add-value', function() {
            const optionIndex = $(this).data('option-index');
            const valuesContainer = $(this).closest('.values-container');
            let currentValueIndex = valuesContainer.children('.input-group').length;
            const valueHtml = `
            <div class="input-group mb-3">
                <input type="text" name="options[${optionIndex}][values][${currentValueIndex}][value]" class="form-control" placeholder="Value">
                <input type="number" name="options[${optionIndex}][values][${currentValueIndex}][additional_price]" class="form-control" placeholder="Additional Price" step="0.01">
                <input type="number" name="options[${optionIndex}][values][${currentValueIndex}][stock]" id="" class="form-control" value="" placeholder="Stock" step="0.01">
                <input type="file" name="options[${optionIndex}][values][${currentValueIndex}][image_path]" class="form-control" accept="image/*">
                <button type="button" class="btn btn-icon btn-label-danger remove-value" data-option-index="${optionIndex}">
                    <i class="ti ti-trash"></i>
                </button>
            </div>
        `;
            valuesContainer.append(valueHtml);
        });
    });
</script>
