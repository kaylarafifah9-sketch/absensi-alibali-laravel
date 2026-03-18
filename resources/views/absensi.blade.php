<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Absensi — {{ $karyawan->nama }}</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Segoe UI',sans-serif;background:#F0F4F8;min-height:100vh;display:flex;justify-content:center;padding:24px 12px}
.phone{width:390px;background:#fff;border-radius:32px;box-shadow:0 4px 24px rgba(0,0,0,0.10);overflow:hidden;display:flex;flex-direction:column}
.hdr{padding:16px;background:#1A73E8;color:#fff;display:flex;justify-content:space-between;align-items:center}
.hdr h2{font-size:15px;font-weight:600}
.hdr p{font-size:11px;opacity:.85}
.logout{background:rgba(255,255,255,.2);border:none;color:#fff;font-size:11px;cursor:pointer;padding:5px 10px;border-radius:6px}
.nav{display:flex;border-bottom:1px solid #E8EAED;background:#fff}
.nav button{flex:1;padding:10px 0;font-size:12px;border:none;background:transparent;cursor:pointer;color:#5F6368;border-bottom:2px solid transparent}
.nav button.active{color:#1A73E8;border-bottom-color:#1A73E8;font-weight:600}
.tab{display:none;padding:14px;flex-direction:column;gap:10px}
.tab.active{display:flex}
.card{background:#fff;border:1px solid #E8EAED;border-radius:14px;padding:14px}
.big-time{font-size:28px;font-weight:600;color:#1A73E8;text-align:center}
.date-txt{font-size:12px;color:#5F6368;text-align:center;margin-top:2px}
.lbl{font-size:11px;color:#5F6368;margin-bottom:4px}
.gps-txt{font-size:11px;font-family:monospace;margin-top:4px;line-height:1.8}
.badge{display:inline-block;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:500}
.bg{background:#E6F4EA;color:#137333}
.br{background:#FCE8E6;color:#A50E0E}
.bb{background:#E8F0FE;color:#1558B0}
.btn{width:100%;padding:11px;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;color:#fff}
.btn-g{background:#34A853}
.btn-r{background:#EA4335}
.btn-dis{background:#BDC1C6;cursor:not-allowed}
.alert{padding:10px 12px;border-radius:10px;font-size:12px;margin-top:4px}
.a-ok{background:#E6F4EA;color:#137333}
.a-err{background:#FCE8E6;color:#A50E0E}
.cam-box{width:100%;aspect-ratio:4/3;background:#111;border-radius:10px;overflow:hidden;position:relative}
.cam-box video{position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover}
.cam-overlay{position:absolute;bottom:0;left:0;right:0;padding:10px;display:flex;justify-content:center;background:rgba(0,0,0,.4)}
.btn-sm{padding:7px 14px;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;color:#fff;background:#1A73E8}
.snap-preview{width:100%;aspect-ratio:4/3;border-radius:10px;overflow:hidden;position:relative}
.snap-preview img{width:100%;height:100%;object-fit:cover}
.riwayat-row{display:flex;gap:10px;align-items:flex-start;padding:9px 0;border-bottom:1px solid #F1F3F4}
.riwayat-row:last-child{border-bottom:none}
.thumb{width:38px;height:38px;border-radius:8px;object-fit:cover}
.thumb-empty{width:38px;height:38px;border-radius:8px;background:#F1F3F4;display:flex;align-items:center;justify-content:center;font-size:16px}
</style>
</head>
<body>
<div class="phone">
  <div class="hdr">
    <div>
      <h2>{{ $karyawan->nama }}</h2>
      <p>{{ $karyawan->jabatan }} · {{ $karyawan->employee_id }}</p>
    </div>
    <a href="/logout"><button class="logout">Keluar</button></a>
  </div>
  <div class="nav">
    <button class="active" onclick="tab('absen',this)">Absensi</button>
    <button onclick="tab('riwayat',this)">Riwayat</button>
    <button onclick="tab('profil',this)">Profil</button>
  </div>

  <!-- Tab Absensi -->
  <div class="tab active" id="tab-absen">
    <div class="card">
      <div class="big-time" id="jam">--:--:--</div>
      <div class="date-txt" id="tgl"></div>
    </div>
    <div class="card">
      <div class="lbl">📍 Lokasi GPS</div>
      <div class="gps-txt" id="gps-txt">Mendeteksi lokasi...</div>
      <div id="gps-badge" style="margin-top:6px"></div>
    </div>
    <div class="card" id="cam-section" style="display:none">
      <div class="lbl" style="margin-bottom:8px;font-weight:600">📸 Foto Wajah — Absen Masuk</div>
      <div class="cam-box" id="cam-box">
        <video id="vid" autoplay playsinline muted></video>
        <div class="cam-overlay">
          <button class="btn-sm" onclick="ambilFoto()">📷 Ambil Foto</button>
        </div>
      </div>
      <div id="preview-wrap" style="display:none;margin-top:10px">
        <div class="snap-preview">
          <img id="foto-preview" src="">
        </div>
        <div style="display:flex;gap:8px;margin-top:8px">
          <button class="btn-sm" style="flex:1;background:#9AA0A6" onclick="ulangi()">🔄 Ulangi</button>
          <button class="btn-sm" style="flex:1" onclick="konfirmasiMasuk()">✅ Konfirmasi</button>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="lbl">Status Kehadiran</div>
      <div style="display:flex;align-items:center;gap:8px;margin-top:6px">
        <div id="dot" style="width:10px;height:10px;border-radius:50%;background:#BDC1C6"></div>
        <div style="font-size:13px;font-weight:600" id="status-txt">
          @if($absensiHariIni && $absensiHariIni->jam_masuk)
            Hadir — masuk {{ $absensiHariIni->jam_masuk }}
          @else
            Belum absen
          @endif
        </div>
      </div>
      <div id="durasi" style="font-size:11px;color:#5F6368;margin-top:4px"></div>
    </div>
    @if($absensiHariIni && $absensiHariIni->jam_masuk)
      <button class="btn btn-dis" disabled>✅ Sudah Absen Masuk</button>
      @if(!$absensiHariIni->jam_pulang)
        <button class="btn btn-r" id="btn-pulang" onclick="absenPulang()">🔚 Absen Pulang</button>
      @else
        <button class="btn btn-dis" disabled>✅ Sudah Absen Pulang</button>
      @endif
    @else
      <button class="btn btn-g" id="btn-masuk" onclick="mulaiKamera()">📸 Absen Masuk</button>
      <button class="btn btn-dis" disabled>🔚 Absen Pulang</button>
    @endif
    <div id="alert-box" style="display:none" class="alert"></div>
  </div>

  <!-- Tab Riwayat -->
  <div class="tab" id="tab-riwayat">
    <div class="card">
      <div style="font-size:11px;font-weight:700;color:#5F6368;margin-bottom:8px">RIWAYAT ABSEN</div>
      <div id="riwayat-list">
        <div style="font-size:12px;color:#5F6368">Memuat...</div>
      </div>
    </div>
  </div>

  <!-- Tab Profil -->
  <div class="tab" id="tab-profil">
    <div class="card">
      <div style="display:flex;align-items:center;gap:14px;margin-bottom:14px">
        <div style="width:50px;height:50px;border-radius:50%;background:#E8F0FE;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:#1558B0">
          {{ strtoupper(substr($karyawan->nama,0,2)) }}
        </div>
        <div>
          <div style="font-weight:700;font-size:15px">{{ $karyawan->nama }}</div>
          <div style="font-size:12px;color:#5F6368">{{ $karyawan->jabatan }}</div>
        </div>
      </div>
      <div style="border-top:1px solid #F1F3F4;padding-top:10px">
        <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #F1F3F4">
          <span style="font-size:12px;color:#5F6368">ID Karyawan</span>
          <span style="font-size:12px;font-weight:700">{{ $karyawan->employee_id }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;padding:8px 0">
          <span style="font-size:12px;color:#5F6368">Radius Absen</span>
          <span class="badge bb">100 meter</span>
        </div>
      </div>
    </div>
    <a href="/logout"><button style="width:100%;padding:10px;border:1px solid #DADCE0;background:transparent;border-radius:10px;font-size:13px;cursor:pointer">Keluar dari Akun</button></a>
  </div>
</div>

<script>
const KANTOR_LAT = -8.6478, KANTOR_LON = 115.2191, RADIUS = 100;
let dalamRadius = false, stream = null, fotoData = null, tMasuk = null;

function tab(name, btn) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.nav button').forEach(b => b.classList.remove('active'));
  document.getElementById('tab-' + name).classList.add('active');
  btn.classList.add('active');
  if (name === 'riwayat') muatRiwayat();
}

function startJam() {
  setInterval(() => {
    const n = new Date();
    document.getElementById('jam').textContent = n.toLocaleTimeString('id-ID');
    document.getElementById('tgl').textContent = n.toLocaleDateString('id-ID', {weekday:'long',day:'numeric',month:'long',year:'numeric'});
  }, 1000);
}

function hitungJarak(lat1, lon1, lat2, lon2) {
  const R = 6371000;
  const dLat = (lat2-lat1) * Math.PI/180;
  const dLon = (lon2-lon1) * Math.PI/180;
  const a = Math.sin(dLat/2)*Math.sin(dLat/2) + Math.cos(lat1*Math.PI/180)*Math.cos(lat2*Math.PI/180)*Math.sin(dLon/2)*Math.sin(dLon/2);
  return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
}

function startGPS() {
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(pos => {
      const lat = pos.coords.latitude, lon = pos.coords.longitude;
      const dist = Math.round(hitungJarak(lat, lon, KANTOR_LAT, KANTOR_LON));
      dalamRadius = dist <= RADIUS;
      document.getElementById('gps-txt').innerHTML = `Lat: ${lat.toFixed(6)}&nbsp;&nbsp;Lon: ${lon.toFixed(6)}<br>Kantor: Jl. Nusakambangan, Denpasar`;
      document.getElementById('gps-badge').innerHTML = dalamRadius
        ? `<span class="badge bg">✅ Dalam radius (${dist} m)</span>`
        : `<span class="badge br">❌ Di luar radius (${dist} m)</span>`;
    }, () => {
      document.getElementById('gps-txt').textContent = 'GPS tidak tersedia';
      dalamRadius = true; // fallback untuk testing
    });
  }
}

async function mulaiKamera() {
  document.getElementById('cam-section').style.display = 'block';
  try {
    stream = await navigator.mediaDevices.getUserMedia({video:{facingMode:'user'},audio:false});
    document.getElementById('vid').srcObject = stream;
  } catch(e) {
    showAlert('err', 'Kamera tidak tersedia');
  }
}

function ambilFoto() {
  const v = document.getElementById('vid');
  const c = document.createElement('canvas');
  c.width = v.videoWidth; c.height = v.videoHeight;
  c.getContext('2d').drawImage(v, 0, 0);
  fotoData = c.toDataURL('image/jpeg', 0.75);
  document.getElementById('foto-preview').src = fotoData;
  document.getElementById('preview-wrap').style.display = 'block';
  document.getElementById('cam-box').style.display = 'none';
  if (stream) stream.getTracks().forEach(t => t.stop());
}

function ulangi() {
  document.getElementById('cam-box').style.display = 'block';
  document.getElementById('preview-wrap').style.display = 'none';
  mulaiKamera();
}

async function konfirmasiMasuk() {
  const res = await fetch('/absensi/masuk', {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN': '{{ csrf_token() }}'},
    body: JSON.stringify({foto: fotoData, latitude: KANTOR_LAT, longitude: KANTOR_LON})
  });
  const data = await res.json();
  if (data.success) {
    showAlert('ok', '✅ Absen masuk berhasil! ' + data.waktu);
    document.getElementById('cam-section').style.display = 'none';
    document.getElementById('status-txt').textContent = 'Hadir — masuk ' + data.waktu;
    document.getElementById('dot').style.background = '#34A853';
    tMasuk = Date.now();
    document.getElementById('btn-masuk').className = 'btn btn-dis';
    document.getElementById('btn-masuk').disabled = true;
  }
}

async function absenPulang() {
  const res = await fetch('/absensi/pulang', {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN': '{{ csrf_token() }}'},
    body: JSON.stringify({})
  });
  const data = await res.json();
  if (data.success) {
    showAlert('ok', '✅ Absen pulang berhasil! ' + data.waktu);
    document.getElementById('btn-pulang').className = 'btn btn-dis';
    document.getElementById('btn-pulang').disabled = true;
  }
}

async function muatRiwayat() {
  const res = await fetch('/absensi/riwayat');
  const data = await res.json();
  const el = document.getElementById('riwayat-list');
  if (!data.length) { el.innerHTML = '<div style="font-size:12px;color:#5F6368">Belum ada riwayat.</div>'; return; }
  el.innerHTML = '';
  data.forEach(r => {
    const row = document.createElement('div');
    row.className = 'riwayat-row';
    const foto = r.foto_masuk ? `<img class="thumb" src="/foto/${r.foto_masuk}">` : `<div class="thumb-empty">📷</div>`;
    row.innerHTML = `${foto}<div style="flex:1"><div style="font-size:13px;font-weight:600">${r.tanggal}</div><div style="font-size:11px;color:#5F6368">Masuk: ${r.jam_masuk||'-'} · Pulang: ${r.jam_pulang||'-'}</div></div>`;
    el.appendChild(row);
  });
}

function showAlert(t, m) {
  const el = document.getElementById('alert-box');
  el.className = 'alert ' + (t==='ok'?'a-ok':'a-err');
  el.textContent = m; el.style.display = 'block';
  setTimeout(() => el.style.display = 'none', 4000);
}

startJam(); startGPS();
</script>
</body>
</html>