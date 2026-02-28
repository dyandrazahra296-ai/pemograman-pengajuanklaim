const dataKaryawan = window.karyawanData || [];
let index = 0;
let chart;

if(dataKaryawan.length) loadKaryawan(0);

function loadKaryawan(i){
    const d = dataKaryawan[i];
    if(!d) return;

    document.getElementById('namaKaryawan').innerText = d.nama;

    const tanggal = d.klaim.map(x=>x.tanggal);
    const totals  = d.klaim.map(x=>x.total);
    const totalNominal = totals.reduce((a,b)=>a+b,0);

    document.getElementById('totalKlaim').innerText = totals.length;
    document.getElementById('totalNominal').innerText = 'Rp '+totalNominal.toLocaleString('id-ID');
    document.getElementById('limitKlaim').innerText = 'Rp '+d.limit.toLocaleString('id-ID');

    // ===============================
    // HITUNG PERSENTASE
    // ===============================
    const persen = d.limit > 0 ? (totalNominal / d.limit) * 100 : 0;

    const totalBox = document.querySelector('.stat-box.total');
    const progressFill = document.getElementById('limitProgressFill');
    const persenText = document.getElementById('limitPersenText');

    totalBox.classList.remove('warning','danger');

    let progressColor = '#6366f1';

    if(persen >= 100){
        totalBox.classList.add('danger');
        progressColor = '#b71c1c';
        persenText.innerText = 'Limit Terlampaui ('+persen.toFixed(1)+'%)';
    } 
    else if(persen >= 80){
        totalBox.classList.add('warning');
        progressColor = '#e53935';
        persenText.innerText = 'Mendekati Limit ('+persen.toFixed(1)+'%)';
    } 
    else{
        persenText.innerText = 'Pemakaian '+persen.toFixed(1)+'% dari limit';
    }

    // Update Progress Bar
    progressFill.style.width = Math.min(persen,100)+'%';
    progressFill.style.backgroundColor = progressColor;

    // ===============================
    // WARNA CHART
    // ===============================
    const colors = totals.map(v=>{
        if(v >= d.limit){
            return '#b71c1c';
        } else if(v >= d.limit * 0.8){
            return '#e53935';
        } else {
            return '#6366f1';
        }
    });

    if(chart) chart.destroy();

    chart = new Chart(document.getElementById('chartKaryawan'),{
        type:'bar',
        data:{
            labels:tanggal,
            datasets:[{
                label:'Nominal Klaim',
                data:totals,
                backgroundColor:colors,
                borderRadius:8
            }]
        },
        options:{
            responsive:true,
            plugins:{legend:{display:false}},
            scales:{
                y:{
                    beginAtZero:true,
                    ticks:{
                        callback:v=>'Rp '+v.toLocaleString('id-ID')
                    }
                }
            }
        }
    });
}

function nextKaryawan(){ 
    index=(index+1)%dataKaryawan.length; 
    loadKaryawan(index); 
}

function prevKaryawan(){ 
    index=(index-1+dataKaryawan.length)%dataKaryawan.length; 
    loadKaryawan(index); 
}

function showPopup(message){
    const overlay = document.getElementById('popupOverlay');
    const popup = document.getElementById('modernPopup');
    document.getElementById('popupMessage').innerText = message;
    overlay.style.display = 'block';
    setTimeout(()=>popup.classList.add('show'), 10);
}

function closePopup(){
    const overlay = document.getElementById('popupOverlay');
    const popup = document.getElementById('modernPopup');
    popup.classList.remove('show');
    setTimeout(()=>overlay.style.display='none', 300);
}

function searchKaryawan(){
    const keyword = document.getElementById('searchNama').value.toLowerCase();
    const found = dataKaryawan.findIndex(x=>x.nama.toLowerCase().includes(keyword));
    if(found>=0){ 
        index=found; 
        loadKaryawan(index); 
    }
    else{ 
        showPopup('Nama tidak ditemukan!'); 
    }
}

document.getElementById('popupOverlay').addEventListener('click', function(e){
    if(e.target === this) closePopup();
});
