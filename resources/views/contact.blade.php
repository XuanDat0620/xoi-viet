@extends('layouts.app')

@section('title', 'Liên hệ - Xôi Việt')
@section('meta_description', 'Thông tin liên hệ, địa chỉ cửa hàng Xôi Việt và form gửi lời nhắn tới đội ngũ chăm sóc khách hàng.')

@section('content')
<div class="container mt-4 mb-5">
    <h1 class="fw-bold h3 mb-4">Liên hệ với chúng tôi</h1>

    <div class="row g-4">
        {{-- ===== THÔNG TIN CỬA HÀNG + BẢN ĐỒ ===== --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius: 16px;">
                <h6 class="fw-bold mb-3">Thông tin cửa hàng</h6>
                <p><i class="bi bi-geo-alt-fill text-warning me-2"></i> 123 Đường Ẩm Thực, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh</p>
                <p><i class="bi bi-telephone-fill text-warning me-2"></i> Hotline: 1900 6868</p>
                <p><i class="bi bi-envelope-fill text-warning me-2"></i> Email: cskh@xoiviet.vn</p>
                <p><i class="bi bi-clock-fill text-warning me-2"></i> Giờ mở cửa: 6:00 - 21:00 (Tất cả các ngày trong tuần)</p>
            </div>

            {{-- Bản đồ đường đi (Google Maps nhúng) --}}
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
                <iframe
                    src="https://www.google.com/maps?q=Quan%201%2C%20TP.%20Ho%20Chi%20Minh&output=embed"
                    width="100%" height="300" style="border:0;" allowfullscreen loading="lazy">
                </iframe>
            </div>
        </div>

        {{-- ===== FORM GỬI LỜI NHẮN ===== --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
                <h6 class="fw-bold mb-3">Gửi lời nhắn cho chúng tôi</h6>
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề</label>
                        <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội dung <span class="text-danger">*</span></label>
                        <textarea name="message" rows="4" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-warning fw-semibold text-white w-100">Gửi lời nhắn</button>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== GIỚI THIỆU THÊM ===== --}}
    <div class="card border-0 shadow-sm p-4 mt-4" style="border-radius: 16px;">
        <h6 class="fw-bold mb-2">Về Xôi Việt</h6>
        <p class="text-muted mb-0">
            Xôi Việt ra đời với mong muốn gìn giữ và lan toả hương vị xôi truyền thống Việt Nam - từ xôi xéo, xôi gấc,
            xôi lạc, xôi ngô cho đến xôi mặn thập cẩm. Mỗi phần xôi được nấu thủ công mỗi sáng từ gạo nếp chọn lọc,
            đảm bảo an toàn vệ sinh thực phẩm và giao đến tay khách hàng khi còn nóng hổi.
        </p>
    </div>
</div>
@endsection
