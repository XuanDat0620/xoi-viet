{{-- Partial dùng chung cho form Thêm mới và Sửa sản phẩm --}}

@if($product && $product->thumbnail)
    <img src="{{ asset('storage/'.$product->thumbnail) }}" width="100" class="rounded mb-3">
@endif

<div class="mb-3">
    <label class="form-label">Danh mục <span class="text-danger">*</span></label>
    <select name="category_id" class="form-select" required>
        <option value="">-- Chọn danh mục --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Mô tả ngắn</label>
    <input type="text" name="short_description" class="form-control" value="{{ old('short_description', $product->short_description ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Mô tả chi tiết</label>
    <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Giá bán (đ) <span class="text-danger">*</span></label>
        <input type="number" name="price" class="form-control" value="{{ old('price', $product->price ?? '') }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Giá gốc (đ)</label>
        <input type="number" name="original_price" class="form-control" value="{{ old('original_price', $product->original_price ?? '') }}">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Tồn kho <span class="text-danger">*</span></label>
        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock ?? 100) }}" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Đơn vị tính <span class="text-danger">*</span></label>
    <input type="text" name="unit" class="form-control" value="{{ old('unit', $product->unit ?? 'phần') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Ảnh đại diện</label>
    <input type="file" name="thumbnail" class="form-control" accept="image/*">
</div>

<div class="form-check mb-2">
    <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured"
        {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="isFeatured">Hiển thị ở mục "Sản phẩm nổi bật"</label>
</div>

<div class="form-check mb-4">
    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive"
        {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="isActive">Đang mở bán</label>
</div>
