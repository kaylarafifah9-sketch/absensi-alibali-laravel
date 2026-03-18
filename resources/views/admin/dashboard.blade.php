<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard HRD — Ali Bali Express</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Segoe UI',sans-serif;background:#F0F4F8;min-height:100vh;display:flex;justify-content:center;padding:24px 12px}
.phone{width:390px;background:#fff;border-radius:32px;box-shadow:0 4px 24px rgba(0,0,0,0.10);overflow:hidden}
.hdr{padding:16px;background:#1558B0;color:#fff;display:flex;justify-content:space-between;align-items:center}
.hdr h2{font-size:15px;font-weight:600}
.hdr p{font-size:11px;opacity:.85}
.logout{background:rgba(255,255,255,.2);border:none;color:#fff;font-size:11px;cursor:pointer;padding:5px 10px;border-radius:6px}
.body{padding:14px;display:flex;flex-direction:column;gap:10px}
.metric-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
.metric{border-radius:10px;padding:12px;text-align:center;border:1px solid #E8EAED}
.metric-val{font-size:22px;font-weight:700}
.metric-lbl{font-size:10px;color:#5F6368;margin-top:2px}
.card{background:#fff;border:1px solid #E8EAED;border-radius:14px;padding:14px}
.sec{font-size:11px;font-weight:700;color:#5F6368;margin-bottom:8px;text-transform:uppercase;letter-spacing:.5px}
.row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #F1F3F4}
.row:last-child{border-bottom:none}
.av{width:34px;height:34px;border-radius:50%;background:#E8F0FE;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#1558B0;flex-shrink:0}
.badge{display:inline-block;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:500}
.bg{background:#E6F4EA;color:#137333}
.bb{background:#E8F0FE;color:#1558B0}
.bgr{background:#F1F3F4;color:#5F6368}
.report-row{display:flex;gap:10px;align-items:flex-start;padding:9px 0;border-bottom:1px solid #F1F3F4}
.report-row:last-child{border-bottom:none}
.thumb{width:38px;height:38px;border-radius:8px;object-fit:cover}
.thumb-av{width:38px;height:38px;border-radius:8px;background:#E8F0FE;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#1558B0;flex-shrink:0}
</style>
</head>
<body>
<div class="phone">
  <div class="hdr">
    <div>
      <h2>Dashboard HRD</h2>
      <p>PT Ali Bali Express</p>
    </div>
    <a href="/logout"><button class="logout">Keluar</button></a>
  </div>
  <div class="body">

    <!-- Metrik -->
    <div class="metric-grid">
      <div class="metric">
        <div class="metric-val" style="color:#1A73E8">{{ $totalKaryawan }}</div>
        <div class="metric-lbl">Total</div>
      </div>
      <div class="metric">
        <div class="metric-val" style="color:#34A853">{{ $hadirHariIni }}</div>
        <div class="metric-lbl">Hadir</div>
      </div>
      <div class="metric">
        <div class="metric-val" style="color:#EA4335">{{ $belumAbsen }}</div>
        <div class="metric-lbl">Belum</div>
      </div>
    </div>

    <!-- Laporan Absensi -->
    <div class="card">
      <div class="sec">Laporan Absensi Hari Ini</div>
      @forelse($semuaKaryawan as $k)
        @php
          $absensi = $logAbsensi->where('karyawan_id', $k->id)->first();
        @endphp
        <div class="report-row">
          @if($absensi && $absensi->foto_masuk)
            <img class="thumb" src="/foto/{{ $absensi->foto_masuk }}">
          @else
            <div class="thumb-av">{{ strtoupper(substr($k->nama,0,2)) }}</div>
          @endif
          <div style="flex:1">
            <div style="display:flex;justify-content:space-between;align-items:center">
              <span style="font-size:13px;font-weight:600">{{ $k->nama }}</span>
              <span class="badge {{ $absensi ? 'bg' : 'bgr' }}">
                {{ $absensi ? 'Hadir' : 'Belum absen' }}
              </span>
            </div>
            <div style="font-size:11px;color:#5F6368;margin-top:3px">
              Masuk: {{ $absensi->jam_masuk ?? '-' }}
              · Pulang: {{ $absensi->jam_pulang ?? '-' }}
            </div>
          </div>
        </div>
      @empty
        <div style="font-size:12px;color:#5F6368">Belum ada karyawan.</div>
      @endforelse
    </div>

    <!-- Log Real-time -->
    <div class="card">
      <div class="sec">Log Real-time</div>
      @forelse($logAbsensi as $log)
        <div class="row">
          <div style="display:flex;align-items:center;gap:8px">
            <div class="av">{{ strtoupper(substr($log->karyawan->nama,0,2)) }}</div>
            <div>
              <div style="font-size:13px;font-weight:600">{{ $log->karyawan->nama }}</div>
              <div style="font-size:10px;color:#5F6368">{{ $log->jam_masuk }}</div>
            </div>
          </div>
          <span class="badge bb">MASUK</span>
        </div>
      @empty
        <div style="font-size:12px;color:#5F6368">Belum ada aktivitas.</div>
      @endforelse
    </div>

    <!-- Geofence -->
    <div class="card">
      <div class="sec">Pengaturan Geofence</div>
      <div style="font-family:monospace;font-size:11px;color:#5F6368;line-height:2.2">
        Koordinat : -8.6478, 115.2191<br>
        Alamat : Jl. Nusakambangan, Denpasar<br>
        Radius : <span class="badge bb">100 meter</span>
      </div>
    </div>

  </div>
</div>
</body>
</html>
```

Simpan **Ctrl+S** lalu jalankan di browser:
```
http://localhost:8000