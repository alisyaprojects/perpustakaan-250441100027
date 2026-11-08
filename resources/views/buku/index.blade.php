@extends('layouts.main')

@section('title', 'Daftar Buku - Perpustakaan Digital')

@section('content')
    <style>
        .hal-buku .judul-halaman { color: #4a2c11; margin-bottom: 20px; text-align: center; }
        .hal-buku .judul-tabel { color: #4a2c11; margin: 6px 0 14px; }

        .hal-buku .kartu-form {
            max-width: 900px;
            margin: 0 auto 30px;
            padding: 38px 42px 34px;
            border-radius: 18px;
            background: linear-gradient(180deg, #ffffff 0%, #fcfaf7 100%);
            border: 1px solid #eae5df;
            box-shadow: 0 10px 30px rgba(74, 44, 17, 0.08);
            display: block;
        }
        .hal-buku .kepala-form { text-align: center; margin-bottom: 30px; }
        .hal-buku .eyebrow {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #8b5a2b;
            margin-bottom: 8px;
        }
        .hal-buku #form-title {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 2rem;
            font-weight: 700;
            color: #4a2c11;
            margin: 0 0 8px;
        }
        .hal-buku .subjudul { color: #6b5a4a; font-size: 0.95rem; }

        .hal-buku .grid-form {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px 26px;
        }
        .hal-buku .penuh { grid-column: 1 / -1; }
        .hal-buku .grup label {
            display: block;
            font-weight: 700;
            font-size: 0.82rem;
            margin-bottom: 8px;
            color: #4a2c11;
        }
        .hal-buku .wajib { color: #c0392b; }
        .hal-buku .grup input,
        .hal-buku .grup select,
        .hal-buku .grup textarea {
            width: 100%;
            padding: 13px 16px;
            border: 1px solid #e3d9ce;
            border-radius: 10px;
            font: inherit;
            font-size: 0.95rem;
            color: #333;
            box-sizing: border-box;
            background: #fdfaf6;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .hal-buku .grup textarea { resize: vertical; min-height: 130px; }
        .hal-buku .grup ::placeholder { color: #a89a8b; }
        .hal-buku .grup input:focus,
        .hal-buku .grup select:focus,
        .hal-buku .grup textarea:focus {
            outline: none;
            background: #fff;
            border-color: #8b5a2b;
            box-shadow: 0 0 0 3px rgba(139, 90, 43, 0.15);
        }
        .hal-buku .grup input[type="file"] { padding: 9px 12px; cursor: pointer; }
        .hal-buku .grup input[type="file"]::file-selector-button {
            margin-right: 12px;
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            background: #e8d8c8;
            color: #4a2c11;
            font: inherit;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
        }
        .hal-buku .grup input[type="file"]::file-selector-button:hover { background: #dcc7b2; }
        .hal-buku .grup small { display: block; min-height: 18px; margin-top: 4px; color: #c0392b; font-size: 0.82rem; }
        .hal-buku .grup small.petunjuk { min-height: 0; margin-top: 8px; color: #8a7b6c; font-size: 0.78rem; }
        .hal-buku .baris-tombol { display: flex; justify-content: center; gap: 12px; margin-top: 14px; }
        .hal-buku .baris-tombol .tbl { padding: 12px 30px; font-weight: 600; }

        .hal-buku .tbl {
            display: inline-block;
            padding: 9px 18px;
            border: none;
            border-radius: 6px;
            font: inherit;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
            line-height: 1.2;
            transition: opacity 0.15s;
        }
        .hal-buku .tbl:hover { opacity: 0.88; }
        .hal-buku .tbl:disabled { opacity: 0.45; cursor: not-allowed; }
        .hal-buku .tbl-utama { background: #8b5a2b; color: #fff; }
        .hal-buku .tbl-utama:hover { background: #6e431f; opacity: 1; }
        .hal-buku .tbl-abu { background: #e4ded7; color: #3a3028; }
        .hal-buku .tbl-ubah { background: #b9770e; color: #fff; }
        .hal-buku .tbl-hapus { background: #c0392b; color: #fff; }
        .hal-buku .tbl-kecil { padding: 6px 12px; font-size: 0.82rem; }

        .hal-buku .bungkus-tabel { overflow-x: auto; padding: 0; }
        .hal-buku .tabel-buku { width: 100%; border-collapse: collapse; }
        .hal-buku .tabel-buku th {
            background: #e8d8c8;
            color: #4a2c11;
            text-align: left;
            padding: 12px 14px;
            font-size: 0.9rem;
            white-space: nowrap;
        }
        .hal-buku .tabel-buku td { padding: 12px 14px; border-bottom: 1px solid #eae5df; vertical-align: middle; }
        .hal-buku .tabel-buku tbody tr:hover { background: #faf6f1; }
        .hal-buku .kolom-aksi { white-space: nowrap; }
        .hal-buku .kolom-aksi .tbl { margin-right: 4px; }
        .hal-buku .tengah { text-align: center; padding: 24px !important; color: #777; }

        .hal-buku .bar-halaman { display: flex; justify-content: space-between; align-items: center; margin: 16px 0 28px; gap: 10px; }
        .hal-buku .bar-halaman span { color: #555; font-size: 0.9rem; text-align: center; }

        @media (max-width: 640px) {
            .hal-buku .grid-form { grid-template-columns: 1fr; }
            .hal-buku .kartu-form { padding: 26px 18px; }
            .hal-buku .bar-halaman { flex-direction: column; }
        }
    </style>

    <div class="hal-buku">
        <h2 class="judul-halaman">Kelola Koleksi Buku</h2>

        <!-- Form Tambah / Ubah Buku (di atas) -->
        <div class="card kartu-form" id="area-form">
            <div class="kepala-form">
                <span class="eyebrow">Kelola Koleksi</span>
                <h3 id="form-title">Tambah Buku</h3>
                <p class="subjudul" id="form-subjudul">Tambahkan koleksi buku baru ke dalam perpustakaan digital melalui form berikut.</p>
            </div>

            <form id="form-buku" novalidate>
                <input type="hidden" id="buku-id">

                <div class="grid-form">
                    <div class="grup">
                        <label for="kategori_id">Kategori <span class="wajib">*</span></label>
                        <select id="kategori_id">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                        <small id="err-kategori_id"></small>
                    </div>
                    <div class="grup">
                        <label for="judul">Judul Buku <span class="wajib">*</span></label>
                        <input type="text" id="judul" placeholder="Masukkan judul buku">
                        <small id="err-judul"></small>
                    </div>
                    <div class="grup">
                        <label for="penulis">Penulis <span class="wajib">*</span></label>
                        <input type="text" id="penulis" placeholder="Masukkan nama penulis">
                        <small id="err-penulis"></small>
                    </div>
                    <div class="grup">
                        <label for="tahun">Tahun Terbit <span class="wajib">*</span></label>
                        <input type="number" id="tahun" placeholder="Masukkan tahun terbit">
                        <small id="err-tahun"></small>
                    </div>
                    <div class="grup penuh">
                        <label for="gambar">Cover Buku <span class="wajib">*</span></label>
                        <input type="file" id="gambar" accept="image/png, image/jpeg, image/webp">
                        <small class="petunjuk">Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.</small>
                        <small id="info-gambar" style="min-height: 0; color: #6b5a4a;"></small>
                        <small id="err-gambar"></small>
                    </div>
                    <div class="grup penuh">
                        <label for="deskripsi">Deskripsi <span class="wajib">*</span></label>
                        <textarea id="deskripsi" rows="5" placeholder="Masukkan deskripsi singkat buku"></textarea>
                        <small id="err-deskripsi"></small>
                    </div>
                </div>

                <div class="baris-tombol">
                    <button type="submit" id="btn-simpan" class="tbl tbl-utama">Simpan Buku</button>
                    <button type="button" class="tbl tbl-abu" onclick="resetForm()">Batal</button>
                </div>
            </form>
        </div>

        <!-- Kotak pesan sukses / error, tepat di antara form dan tabel -->
        <div id="pesan"></div>

        <!-- Tabel Daftar Buku (di bawah) -->
        <h3 class="judul-tabel">Daftar Buku</h3>
        <p id="info-cari" style="margin-bottom: 15px; color: #666;"></p>

        <div class="card bungkus-tabel">
            <table class="tabel-buku">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun Terbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="isi-tabel">
                    <tr><td colspan="6" class="tengah">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>

        <div class="bar-halaman">
            <button type="button" id="btn-sebelumnya" class="tbl tbl-abu">&larr; Sebelumnya</button>
            <span id="info-halaman"></span>
            <button type="button" id="btn-berikutnya" class="tbl tbl-abu">Berikutnya &rarr;</button>
        </div>
    </div>

    <script>
        const API_URL = '/api/buku';

                // Token CSRF otomatis untuk semua fetch (API sekarang memakai sesi login)
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
        const fetchAsli = window.fetch;
        window.fetch = function (url, opsi = {}) {
            opsi.headers = Object.assign({}, opsi.headers || {}, { 'X-CSRF-TOKEN': CSRF_TOKEN });
            return fetchAsli(url, opsi);
        };

        const isiTabel = document.getElementById('isi-tabel');
        const kotakPesan = document.getElementById('pesan');
        const infoHalaman = document.getElementById('info-halaman');
        const tombolSebelumnya = document.getElementById('btn-sebelumnya');
        const tombolBerikutnya = document.getElementById('btn-berikutnya');
        const tombolSimpan = document.getElementById('btn-simpan');
        const formBuku = document.getElementById('form-buku');

        let halaman = 1;
        let timerPesan = null;
        const kataCari = new URLSearchParams(window.location.search).get('search') || '';

        if (kataCari) {
            document.getElementById('info-cari').innerHTML =
                'Menampilkan hasil pencarian untuk: <strong>' + escapeHtml(kataCari) + '</strong> ' +
                '<a href="/buku">(tampilkan semua)</a>';
        }

        // Mengubah karakter khusus agar data dari API tidak dibaca sebagai kode HTML
        function escapeHtml(teks) {
            return String(teks ?? '').replace(/[&<>"']/g, function (c) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
            });
        }

        function tampilkanPesan(teks, jenis = 'error') {
            const warna = jenis === 'error' ? '#c0392b' : '#2e7d32';
            const latar = jenis === 'error' ? '#fdecea' : '#e8f5e9';
            kotakPesan.innerHTML =
                '<div style="margin-bottom: 15px; padding: 12px 15px; border-radius: 8px; border: 1px solid ' + warna +
                '; background: ' + latar + '; color: ' + warna + ';">' + escapeHtml(teks) + '</div>';
            clearTimeout(timerPesan);
            timerPesan = setTimeout(function () { kotakPesan.innerHTML = ''; }, 5000);
        }

        function bersihkanError() {
            document.querySelectorAll('small[id^="err-"]').forEach(function (el) { el.textContent = ''; });
        }

        function resetForm() {
            formBuku.reset();
            document.getElementById('buku-id').value = '';
            document.getElementById('form-title').textContent = 'Tambah Buku';
            document.getElementById('form-subjudul').textContent =
                'Tambahkan koleksi buku baru ke dalam perpustakaan digital melalui form berikut.';
            document.getElementById('info-gambar').textContent = '';
            bersihkanError();
        }

        function tampilkanTabel(daftar, meta) {
            if (daftar.length === 0) {
                isiTabel.innerHTML = '<tr><td colspan="6" class="tengah">Belum ada data buku.</td></tr>';
            } else {
                const nomorAwal = (meta.current_page - 1) * meta.per_page;

                isiTabel.innerHTML = daftar.map(function (buku, i) {
                    return `
                        <tr>
                            <td>${nomorAwal + i + 1}</td>
                            <td><span class="badge">${escapeHtml(buku.kategori)}</span></td>
                            <td>${escapeHtml(buku.judul)}</td>
                            <td>${escapeHtml(buku.penulis)}</td>
                            <td>${escapeHtml(buku.tahun)}</td>
                            <td class="kolom-aksi">
                                <button type="button" class="tbl tbl-ubah tbl-kecil" onclick="ubahBuku(${buku.id})">Ubah</button>
                                <button type="button" class="tbl tbl-hapus tbl-kecil" onclick="hapusBuku(${buku.id})">Hapus</button>
                            </td>
                        </tr>`;
                }).join('');
            }

            infoHalaman.textContent = 'Halaman ' + meta.current_page + ' dari ' + meta.last_page +
                ' (total ' + meta.total + ' buku)';
            tombolSebelumnya.disabled = meta.current_page <= 1;
            tombolBerikutnya.disabled = meta.current_page >= meta.last_page;
        }

        async function muatBuku() {
            try {
                const params = new URLSearchParams({ page: halaman });
                if (kataCari) {
                    params.set('cari', kataCari);
                }

                const response = await fetch(API_URL + '?' + params.toString(), {
                    headers: { 'Accept': 'application/json' },
                });

                if (!response.ok) {
                    throw new Error('Server menjawab dengan status ' + response.status);
                }

                const hasil = await response.json();

                // Kalau halaman ini sudah kosong (misalnya setelah hapus), mundur ke halaman terakhir
                if (hasil.data.length === 0 && halaman > 1) {
                    halaman = hasil.meta.last_page;
                    return muatBuku();
                }

                tampilkanTabel(hasil.data, hasil.meta);
            } catch (error) {
                isiTabel.innerHTML = '<tr><td colspan="6" class="tengah">Data tidak dapat dimuat.</td></tr>';
                tampilkanPesan('Gagal memuat data buku: ' + error.message);
            }
        }

        async function ubahBuku(id) {
            try {
                const response = await fetch(API_URL + '/' + id, {
                    headers: { 'Accept': 'application/json' },
                });

                if (response.status === 404) {
                    throw new Error('Buku tidak ditemukan (mungkin sudah dihapus).');
                }
                if (!response.ok) {
                    throw new Error('Server menjawab dengan status ' + response.status);
                }

                const hasil = await response.json();
                const buku = hasil.data ?? hasil;

                bersihkanError();
                document.getElementById('buku-id').value = buku.id;
                document.getElementById('kategori_id').value = buku.kategori_id ?? '';
                document.getElementById('judul').value = buku.judul ?? '';
                document.getElementById('penulis').value = buku.penulis ?? '';
                document.getElementById('tahun').value = buku.tahun_terbit ?? buku.tahun ?? '';
                document.getElementById('deskripsi').value = buku.deskripsi ?? '';
                document.getElementById('gambar').value = '';
                document.getElementById('info-gambar').textContent = buku.gambar
                    ? 'Gambar saat ini: ' + buku.gambar + ' (kosongkan jika tidak ingin mengganti)'
                    : '';
                document.getElementById('form-title').textContent = 'Ubah Buku';
                document.getElementById('form-subjudul').textContent =
                    'Perbarui data buku yang dipilih, lalu simpan perubahan.';

                document.getElementById('area-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
            } catch (error) {
                tampilkanPesan('Gagal mengambil data buku: ' + error.message);
            }
        }

        async function hapusBuku(id) {
            if (!confirm('Yakin ingin menghapus buku ini?')) {
                return;
            }

            try {
                const response = await fetch(API_URL + '/' + id, {
                    method: 'DELETE',
                    headers: { 'Accept': 'application/json' },
                });

                if (response.status === 404) {
                    throw new Error('Buku tidak ditemukan (mungkin sudah dihapus).');
                }
                if (!response.ok) {
                    throw new Error('Server menjawab dengan status ' + response.status);
                }

                if (document.getElementById('buku-id').value == id) {
                    resetForm();
                }

                await muatBuku();
                tampilkanPesan('Buku berhasil dihapus.', 'sukses');
            } catch (error) {
                tampilkanPesan('Gagal menghapus buku: ' + error.message);
            }
        }

        formBuku.addEventListener('submit', async function (e) {
            e.preventDefault();
            bersihkanError();

            const id = document.getElementById('buku-id').value;
            const sedangUbah = id !== '';

            const data = {
                kategori_id: document.getElementById('kategori_id').value,
                judul: document.getElementById('judul').value,
                penulis: document.getElementById('penulis').value,
                tahun_terbit: document.getElementById('tahun').value,
                deskripsi: document.getElementById('deskripsi').value,
            };
            const fileGambar = document.getElementById('gambar').files[0];

            tombolSimpan.disabled = true;

            try {
                let opsi;

                if (fileGambar) {
                    // Ada berkas cover: kirim sebagai FormData (browser mengatur Content-Type sendiri)
                    const formData = new FormData();
                    Object.keys(data).forEach(function (kunci) { formData.append(kunci, data[kunci]); });
                    formData.append('gambar', fileGambar);
                    if (sedangUbah) { formData.append('_method', 'PUT'); }

                    opsi = { method: 'POST', headers: { 'Accept': 'application/json' }, body: formData };
                } else {
                    // Tanpa berkas: kirim JSON biasa
                    opsi = {
                        method: sedangUbah ? 'PUT' : 'POST',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                        body: JSON.stringify(data),
                    };
                }

                const response = await fetch(sedangUbah ? API_URL + '/' + id : API_URL, opsi);

                if (response.status === 422) {
                    const hasil = await response.json();
                    Object.keys(hasil.errors || {}).forEach(function (field) {
                        const idError = field === 'tahun_terbit' ? 'err-tahun' : 'err-' + field;
                        const el = document.getElementById(idError);
                        if (el) { el.textContent = hasil.errors[field][0]; }
                    });
                    tampilkanPesan('Data belum valid, periksa isian form.');
                    return;
                }

                if (response.status === 404) {
                    throw new Error('Buku tidak ditemukan.');
                }
                if (!response.ok) {
                    throw new Error('Server menjawab dengan status ' + response.status);
                }

                const hasil = await response.json();
                const pesan = hasil.message || (sedangUbah ? 'Buku berhasil diubah.' : 'Buku berhasil ditambahkan.');

                resetForm();
                if (!sedangUbah) { halaman = 1; }
                await muatBuku();
                tampilkanPesan(pesan, 'sukses');
            } catch (error) {
                tampilkanPesan('Gagal menyimpan buku: ' + error.message);
            } finally {
                tombolSimpan.disabled = false;
            }
        });

        tombolSebelumnya.addEventListener('click', function () { halaman--; muatBuku(); });
        tombolBerikutnya.addEventListener('click', function () { halaman++; muatBuku(); });

        muatBuku();
    </script>
@endsection