# ADMIN MODERN THEME - Panduan Penggunaan

## 🎨 Tema Modern Minimalis

Semua halaman admin sekarang menggunakan tema modern minimalis yang konsisten dengan halaman visitor (home, create booking, payments).

## 🎯 Warna Utama

### Primary Colors
- **Navy Blue**: `#1F2933` - Warna utama (sidebar, header, tombol primary)
- **Blue Accent**: `#3B82F6` - Warna aksen (tombol secondary, highlights)
- **Success Green**: `#10B981` - Untuk tombol sukses, status approved
- **Warning Orange**: `#F59E0B` - Untuk warning, status pending
- **Danger Red**: `#EF4444` - Untuk tombol hapus, status rejected

### Text Colors
- **Text Primary**: `#1F2933` - Untuk heading dan teks utama
- **Text Secondary**: `#6B7280` - Untuk subtitle dan teks sekunder
- **Text Muted**: `#9CA3AF` - Untuk placeholder dan teks tidak aktif

### Background
- **BG Primary**: `#FFFFFF` - Background putih bersih
- **BG Secondary**: `#F9FAFB` - Background abu-abu terang untuk cards
- **BG Tertiary**: `#F3F4F6` - Background hover states

## 🔘 Komponen Buttons

### Cara Pakai:

```html
<!-- Primary Button (Navy) -->
<button class="btn btn-modern-primary">
    <i class="fas fa-save me-2"></i>Simpan
</button>

<!-- Secondary Button (Blue) -->
<button class="btn btn-modern-secondary">
    <i class="fas fa-edit me-2"></i>Edit
</button>

<!-- Success Button (Green) -->
<button class="btn btn-modern-success">
    <i class="fas fa-check me-2"></i>Approve
</button>

<!-- Warning Button (Orange) -->
<button class="btn btn-modern-warning">
    <i class="fas fa-clock me-2"></i>Pending
</button>

<!-- Danger Button (Red) -->
<button class="btn btn-modern-danger">
    <i class="fas fa-trash me-2"></i>Hapus
</button>

<!-- Outline Buttons -->
<button class="btn btn-modern-outline-primary">Outline Primary</button>
<button class="btn btn-modern-outline-secondary">Outline Secondary</button>
```

## 🎴 Cards

```html
<div class="card-modern">
    <div class="card-header">
        <i class="fas fa-table me-2"></i>
        Judul Card
    </div>
    <div class="card-body">
        <!-- Konten card -->
    </div>
</div>
```

## 📢 Alerts

```html
<!-- Success Alert -->
<div class="alert-modern-success">
    <i class="fas fa-check-circle me-2"></i>
    Data berhasil disimpan!
</div>

<!-- Warning Alert -->
<div class="alert-modern-warning">
    <i class="fas fa-exclamation-triangle me-2"></i>
    Perhatian! Ada yang perlu diperhatikan.
</div>

<!-- Danger Alert -->
<div class="alert-modern-danger">
    <i class="fas fa-times-circle me-2"></i>
    Terjadi kesalahan!
</div>

<!-- Info Alert -->
<div class="alert-modern-info">
    <i class="fas fa-info-circle me-2"></i>
    Informasi penting.
</div>
```

## 🏷️ Badges

```html
<span class="badge-modern-primary">Primary</span>
<span class="badge-modern-secondary">Secondary</span>
<span class="badge-modern-success">Success</span>
<span class="badge-modern-warning">Warning</span>
<span class="badge-modern-danger">Danger</span>
```

## 📝 Form Elements

```html
<!-- Input -->
<input type="text" class="input-modern" placeholder="Masukkan teks...">

<!-- Select -->
<select class="select-modern">
    <option>Pilih opsi</option>
</select>
```

## 📊 Tables

```html
<table class="table table-modern">
    <thead>
        <tr>
            <th>Header 1</th>
            <th>Header 2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Data 1</td>
            <td>Data 2</td>
        </tr>
    </tbody>
</table>
```

## 🎭 Particles Background

Untuk halaman dengan particles background:

```html
<!-- Particles Container -->
<div id="particles-js"></div>

<!-- Content Wrapper -->
<div class="container-fluid particles-content">
    <!-- Your content here -->
</div>
```

Script particles (di @section('scripts')):

```javascript
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
particlesJS('particles-js', {
    particles: {
        number: { value: 60, density: { enable: true, value_area: 800 } },
        color: { value: ['#1F2933', '#3B82F6', '#6B7280'] },
        shape: { type: 'circle' },
        opacity: { value: 0.5, random: true },
        size: { value: 4, random: true },
        line_linked: { 
            enable: true, 
            distance: 150, 
            color: '#6B7280', 
            opacity: 0.2, 
            width: 1 
        },
        move: { enable: true, speed: 2 }
    },
    interactivity: {
        events: {
            onhover: { enable: true, mode: 'grab' },
            onclick: { enable: true, mode: 'push' }
        }
    }
});
</script>
```

## 📐 Konsistensi Design

### Typography
- **Font Family**: Inter, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto
- **Heading Font**: Merriweather (serif) untuk judul utama
- **Base Font Size**: 0.95rem (15.2px)
- **Font Weights**: 
  - Normal: 400-500
  - Medium: 500-600
  - Bold: 600-700

### Spacing
- **Base Unit**: 0.25rem (4px)
- **Small Spacing**: 0.5rem (8px)
- **Medium Spacing**: 1rem (16px)
- **Large Spacing**: 1.5rem (24px)
- **XL Spacing**: 2rem (32px)

### Border Radius
- **Small**: 0.375rem (6px)
- **Medium**: 0.5rem (8px)
- **Large**: 0.75rem (12px)

### Shadows
- **Small**: `0 1px 3px rgba(0, 0, 0, 0.1)`
- **Medium**: `0 4px 6px rgba(0, 0, 0, 0.1)`
- **Large**: `0 10px 15px rgba(0, 0, 0, 0.1)`

## ✅ Checklist Implementasi

Halaman yang sudah diupdate dengan tema modern:
- ✅ Sidebar Admin (layouts/admin.blade.php)
- ✅ Dashboard (admin/dashboard.blade.php) - *perlu update warna*
- ✅ Events (admin/events/index.blade.php) - *perlu update warna*
- ✅ Special Tickets (admin/special-tickets/index.blade.php) - *perlu update warna*
- ✅ Settings (admin/settings/index.blade.php) - *perlu update warna*
- ⏳ Stats (admin/stats.blade.php) - *pending*
- ⏳ Login (admin/login.blade.php) - *pending*

## 🔧 Cara Update Halaman Existing

Untuk halaman yang masih menggunakan warna lama (yellow #FFD400, black #0b0b0b):

1. **Update CSS Variables:**
```css
/* LAMA */
:root {
    --mg-yellow: #FFD400;
    --mg-black: #0b0b0b;
}

/* BARU */
:root {
    --primary-color: #1F2933;
    --secondary-color: #3B82F6;
    --success-color: #10B981;
}
```

2. **Update Button Classes:**
```html
<!-- LAMA -->
<button class="btn" style="background: #FFD400; color: #0b0b0b;">

<!-- BARU -->
<button class="btn btn-modern-primary">
```

3. **Update Card Headers:**
```html
<!-- LAMA -->
<div class="card-header" style="background: linear-gradient(135deg, #FFD400, #ffc107);">

<!-- BARU -->
<div class="card-header" style="background: #1F2933; color: white;">
```

4. **Update Particles Colors:**
```javascript
// LAMA
color: { value: ['#FFD400', '#6c6c6c', '#0b0b0b'] }

// BARU
color: { value: ['#1F2933', '#3B82F6', '#6B7280'] }
```

## 📱 Responsive Design

Semua komponen sudah responsive. Breakpoints:
- **Mobile**: < 768px
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

## 🎓 Best Practices

1. **Gunakan class modern theme** daripada inline styles
2. **Konsisten dengan spacing system** (kelipatan 4px)
3. **Hover states** selalu ada untuk interactive elements
4. **Icons** menggunakan Font Awesome atau Bootstrap Icons
5. **Shadow dan border-radius** yang consistent
6. **Color contrast** yang baik untuk accessibility

## 📞 Support

Jika ada komponen baru yang perlu ditambahkan atau ada pertanyaan tentang tema, silakan update file `admin-modern-theme.css`.
