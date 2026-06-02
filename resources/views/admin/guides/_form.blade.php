@php
    $guide = $guide ?? null;
@endphp

<div class="row g-4">
    <div class="col-lg-4">
        <div class="admin-card text-center">
            <label class="form-label d-block text-start">Ảnh đại diện</label>
            <div class="guide-avatar-preview mx-auto mb-3" id="avatarPreview">
                @if ($guide?->avatarUrl())
                    <img src="{{ $guide->avatarUrl() }}" alt="{{ $guide->full_name }}">
                @else
                    <span class="guide-avatar-placeholder" id="avatarPlaceholder">
                        <i class="bi bi-person"></i>
                    </span>
                @endif
            </div>
            <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/webp"
                   class="form-control @error('avatar') is-invalid @enderror">
            @error('avatar')
                <div class="invalid-feedback d-block text-start">{{ $message }}</div>
            @enderror
            <p class="text-muted small mt-2 mb-0">JPG, PNG, WEBP — tối đa 2MB</p>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="admin-card">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="full_name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" name="full_name" id="full_name"
                           class="form-control @error('full_name') is-invalid @enderror"
                           value="{{ old('full_name', $guide?->full_name) }}" required>
                    @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $guide?->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label for="gender" class="form-label">Giới tính</label>
                    <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                        <option value="">— Chọn —</option>
                        <option value="male" @selected(old('gender', $guide?->gender) === 'male')>Nam</option>
                        <option value="female" @selected(old('gender', $guide?->gender) === 'female')>Nữ</option>
                        <option value="other" @selected(old('gender', $guide?->gender) === 'other')>Khác</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" id="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone', $guide?->phone) }}">
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="available" @selected(old('status', $guide?->status ?? 'available') === 'available')>Sẵn sàng</option>
                        <option value="busy" @selected(old('status', $guide?->status) === 'busy')>Bận</option>
                        <option value="inactive" @selected(old('status', $guide?->status) === 'inactive')>Ngừng hoạt động</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="address" class="form-label">Địa chỉ</label>
                    <input type="text" name="address" id="address"
                           class="form-control @error('address') is-invalid @enderror"
                           value="{{ old('address', $guide?->address) }}">
                </div>
                <div class="col-md-4">
                    <label for="experience_years" class="form-label">Số năm kinh nghiệm <span class="text-danger">*</span></label>
                    <input type="number" name="experience_years" id="experience_years" min="0" max="50"
                           class="form-control @error('experience_years') is-invalid @enderror"
                           value="{{ old('experience_years', $guide?->experience_years ?? 0) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="price_per_day" class="form-label">Giá / ngày (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" name="price_per_day" id="price_per_day" min="0" step="1000"
                           class="form-control @error('price_per_day') is-invalid @enderror"
                           value="{{ old('price_per_day', $guide?->price_per_day) }}" required>
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Giới thiệu</label>
                    <textarea name="description" id="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $guide?->description) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ngôn ngữ</label>
                    <div class="admin-checkbox-group">
                        @forelse ($languages as $language)
                            <label class="admin-check-item">
                                <input type="checkbox" name="language_ids[]" value="{{ $language->id }}"
                                    @checked(in_array($language->id, old('language_ids', $selectedLanguageIds ?? [])))>
                                <span>{{ $language->name }}</span>
                            </label>
                        @empty
                            <p class="text-muted small mb-0">Chưa có ngôn ngữ. <a href="{{ route('admin.languages.create') }}">Thêm ngôn ngữ</a></p>
                        @endforelse
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Địa điểm hoạt động</label>
                    <div class="admin-checkbox-group">
                        @forelse ($locations as $location)
                            <label class="admin-check-item">
                                <input type="checkbox" name="location_ids[]" value="{{ $location->id }}"
                                    @checked(in_array($location->id, old('location_ids', $selectedLocationIds ?? [])))>
                                <span>{{ $location->name }}</span>
                            </label>
                        @empty
                            <p class="text-muted small mb-0">Chưa có địa điểm. <a href="{{ route('admin.locations.create') }}">Thêm địa điểm</a></p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('avatar')?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const preview = document.getElementById('avatarPreview');
        const reader = new FileReader();
        reader.onload = function (ev) {
            preview.innerHTML = '<img src="' + ev.target.result + '" alt="preview">';
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush
