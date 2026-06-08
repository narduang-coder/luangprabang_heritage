<?php
// ============================================
// ໜ້າສະແດງລາຍລະອຽດເຮືອນມໍລະດົກ
// ============================================
?>
<!DOCTYPE html>
<html lang="lo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>ລາຍລະອຽດເຮືອນມໍລະດົກ | Heritage Detail</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        * { font-family: 'Noto Sans Lao', 'Phetsarath OT', sans-serif; }
        body { background: linear-gradient(135deg, #f5f0e8 0%, #e8e0d5 100%); min-height: 100vh; }
        .hero-section { position: relative; background: linear-gradient(135deg, #1a472a, #2d6a4f); color: white; padding: 60px 20px; text-align: center; margin-bottom: -50px; border-radius: 0 0 50px 50px; overflow: hidden; }
        .hero-section::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); z-index: 1; }
        .hero-section h1, .hero-section .subtitle, .hero-section .qr-badge { position: relative; z-index: 2; }
        .hero-section h1 { font-size: 2.5rem; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.2); margin-bottom: 10px; }
        .hero-section qr-badge { position: absolute; bottom: -25px; left: 50%; transform: translateX(-50%); background: white; color: #2d6a4f; padding: 10px 20px; border-radius: 50px; font-size: 0.85rem; font-weight: bold; box-shadow: 0 4px 15px rgba(0,0,0,0.2); z-index: 3; }
        .heritage-card { background: white; border-radius: 30px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1); margin-top: 60px; margin-bottom: 30px; }
        
        /* ສ່ວນຂອງ Slider ສຳລັບຫຼາຍຮູບ */
        .main-slider-container { position: relative; width: 100%; height: 500px; overflow: hidden; background: #1a1a1a; }
        .slide { display: none; width: 100%; height: 100%; }
        .slide.active { display: block; }
        .slide img { width: 100%; height: 100%; object-fit: cover; object-position: center; }
        .slider-btn { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.6); color: white; border: none; width: 45px; height: 45px; border-radius: 50%; cursor: pointer; transition: all 0.3s; z-index: 10; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
        .slider-btn:hover { background: rgba(0,0,0,0.9); transform: scale(1.1); }
        .slider-prev { left: 15px; }
        .slider-next { right: 15px; }
        .slide-dots { position: absolute; bottom: 20px; left: 0; right: 0; text-align: center; z-index: 10; }
        .dot { display: inline-block; width: 10px; height: 10px; margin: 0 5px; background: rgba(255,255,255,0.5); border-radius: 50%; cursor: pointer; transition: all 0.3s; }
        .dot.active { background: white; width: 25px; border-radius: 10px; }
        .fullscreen-btn { position: absolute; bottom: 20px; right: 20px; background: rgba(0,0,0,0.6); color: white; border: none; width: 45px; height: 45px; border-radius: 50%; cursor: pointer; transition: all 0.3s; z-index: 10; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
        .fullscreen-btn:hover { background: rgba(0,0,0,0.8); transform: scale(1.1); }
        
        .thumbnail-gallery { display: flex; gap: 12px; overflow-x: auto; padding: 15px 20px; background: #f8f9fa; scrollbar-width: thin; }
        .thumbnail-gallery::-webkit-scrollbar { height: 5px; }
        .thumbnail-gallery::-webkit-scrollbar-track { background: #e9ecef; border-radius: 10px; }
        .thumbnail-gallery::-webkit-scrollbar-thumb { background: #2d6a4f; border-radius: 10px; }
        .thumbnail { width: 100px; height: 80px; object-fit: cover; border-radius: 12px; cursor: pointer; transition: all 0.3s; border: 3px solid transparent; flex-shrink: 0; }
        .thumbnail:hover { transform: scale(1.05); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        .thumbnail.active { border-color: #2d6a4f; box-shadow: 0 0 0 3px rgba(45,106,79,0.3); }
        
        /* Modal Fullscreen */
        .image-modal-full { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.95); z-index: 9999; display: flex; align-items: center; justify-content: center; cursor: pointer; opacity: 0; visibility: hidden; transition: all 0.3s; }
        .image-modal-full.active { opacity: 1; visibility: visible; }
        .image-modal-full img { max-width: 90%; max-height: 85%; object-fit: contain; cursor: default; }
        .image-modal-full .close-modal { position: absolute; top: 20px; right: 30px; color: white; font-size: 40px; cursor: pointer; z-index: 10000; background: rgba(0,0,0,0.5); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s; }
        .image-modal-full .close-modal:hover { background: rgba(255,255,255,0.2); transform: scale(1.1); }
        .modal-caption { position: absolute; bottom: 30px; left: 0; right: 0; text-align: center; color: white; background: rgba(0,0,0,0.6); padding: 10px; font-size: 0.9rem; }
        .fullscreen-prev { left: 20px; top: 50%; position: absolute; }
        .fullscreen-next { right: 20px; top: 50%; position: absolute; }
        
        .info-section { padding: 25px 30px; border-bottom: 1px solid #eee; transition: all 0.3s; }
        .info-section:hover { background: #fafaf5; }
        .info-icon { width: 45px; height: 45px; background: linear-gradient(135deg, #2d6a4f, #1a472a); border-radius: 15px; display: inline-flex; align-items: center; justify-content: center; margin-right: 15px; color: white; font-size: 1.2rem; }
        .info-title { font-weight: 700; color: #2d6a4f; font-size: 1.1rem; margin-bottom: 10px; }
        .info-content { color: #333; line-height: 1.7; font-size: 1rem; }
        .style-badge { display: inline-block; background: linear-gradient(135deg, #d4a373, #b5835a); color: white; padding: 8px 20px; border-radius: 50px; font-size: 0.9rem; font-weight: 500; margin: 15px 0; }
        .map-container { border-radius: 20px; overflow: hidden; margin-top: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .share-section { padding: 20px 30px; text-align: center; background: #f8f9fa; }
        .share-btn { width: 45px; height: 45px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin: 0 8px; transition: all 0.3s; text-decoration: none; font-size: 1.2rem; }
        .share-btn.facebook { background: #1877f2; color: white; }
        .share-btn.twitter { background: #1da1f2; color: white; }
        .share-btn.line { background: #06c755; color: white; }
        .share-btn.copy { background: #6c757d; color: white; }
        .share-btn:hover { transform: translateY(-3px); filter: brightness(0.9); }
        .back-button { display: inline-flex; align-items: center; gap: 10px; background: #2d6a4f; color: white; padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: 500; transition: all 0.3s; margin: 20px 0; }
        .back-button:hover { background: #1a472a; color: white; transform: translateX(-5px); }
        .loading-container { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 400px; }
        .loading-spinner { width: 60px; height: 60px; border: 4px solid #e9ecef; border-top-color: #2d6a4f; border-radius: 50%; animation: spin 1s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .error-section { text-align: center; padding: 60px 20px; background: white; border-radius: 30px; margin: 40px 0; }
        .error-icon { font-size: 5rem; color: #dc3545; margin-bottom: 20px; }
        .custom-divider { width: 60px; height: 3px; background: linear-gradient(90deg, #d4a373, #2d6a4f); margin: 20px 0; border-radius: 3px; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in-up { animation: fadeInUp 0.6s ease-out; }
        @media (max-width: 768px) {
            .hero-section h1 { font-size: 1.5rem; }
            .main-slider-container { height: 300px; }
            .thumbnail { width: 80px; height: 60px; }
            .info-section { padding: 18px 20px; }
            .info-icon { width: 35px; height: 35px; font-size: 0.9rem; }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div id="detail-content" class="fade-in-up"><div class="loading-container"><div class="loading-spinner"></div><p class="mt-3 text-muted">ກຳລັງໂຫຼດຂໍ້ມູນ...</p></div></div>
        <div class="text-center"><a href="index.php" class="back-button" id="back-btn"><i class="fas fa-arrow-left"></i> <span id="back-text">ກັບຄືນ</span></a></div>
    </div>
    
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        let qrId = urlParams.get('id');
        const lang = urlParams.get('lang') || 'lo';
        
        function extractIdFromUrl(input) {
            if (input && input.includes('heritage_detail.php')) {
                const match = input.match(/[?&]id=([^&]+)/);
                return match ? match[1] : input;
            }
            return input;
        }
        qrId = extractIdFromUrl(qrId);
        
        let currentSlideIndex = 0;
        let allImages = [];
        let slideInterval;
        
        $(document).ready(function() { loadHeritageDetail(); $('#back-text').text(lang === 'lo' ? 'ກັບຄືນ' : 'Back'); });
        
        function loadHeritageDetail() {
            $.ajax({
                url: 'api/get_heritage.php',
                method: 'POST',
                data: { qr_code: qrId, lang: lang },
                dataType: 'json',
                success: function(response) {
                    if (response.success) { displayDetail(response.data); logVisit(response.data.house_id); }
                    else { showError(response.message); }
                },
                error: function() { showError('ບໍ່ສາມາດໂຫຼດຂໍ້ມູນໄດ້ | Cannot load data'); }
            });
        }
        
        function displayDetail(data) {
            const isLao = lang === 'lo';
            const houseName = isLao ? data.house_name_lo : data.house_name_en;
            const ownerName = isLao ? data.owner_name_lo : data.owner_name_en;
            const architecturalStyle = isLao ? data.architectural_style_lo : data.architectural_style_en;
            const historicalSignificance = isLao ? data.historical_significance_lo : data.historical_significance_en;
            const description = isLao ? data.description_lo : data.description_en;
            
            allImages = [];
            if (data.image_main && data.image_main !== '') {
                allImages.push({ src: `uploads/${data.image_main}`, caption: isLao ? 'ຮູບຫຼັກ' : 'Main Image' });
            }
            if (data.images && data.images.length > 0) {
                data.images.forEach(img => {
                    allImages.push({ src: `uploads/${img.image_path}`, caption: isLao ? img.image_caption_lo : img.image_caption_en });
                });
            }
            if (allImages.length === 0) {
                allImages.push({ src: 'https://placehold.co/800x500/2d6a4f/white?text=ມໍລະດົກຫຼວງພະບາງ', caption: '' });
            }
            
            let html = `<div class="hero-section"><h1>${escapeHtml(houseName || data.house_number || 'ເຮືອນມໍລະດົກຫຼວງພະບາງ')}</h1>${data.house_number ? `<p class="subtitle"><i class="fas fa-map-pin"></i> ເລກທີ່ ${data.house_number}</p>` : ''}<div class="qr-badge"><i class="fas fa-qrcode"></i> ${data.qr_code}</div></div>
                        <div class="heritage-card">
                        <div class="main-slider-container" id="mainSlider">`;
            
            for (let i = 0; i < allImages.length; i++) {
                html += `<div class="slide ${i === 0 ? 'active' : ''}" data-index="${i}">
                            <img src="${allImages[i].src}" alt="Slide ${i+1}" onclick="openFullscreen()">
                         </div>`;
            }
            if (allImages.length > 1) {
                html += `<button class="slider-btn slider-prev" onclick="changeSlide(-1)"><i class="fas fa-chevron-left"></i></button>
                         <button class="slider-btn slider-next" onclick="changeSlide(1)"><i class="fas fa-chevron-right"></i></button>
                         <div class="slide-dots" id="slideDots">`;
                for (let i = 0; i < allImages.length; i++) {
                    html += `<span class="dot ${i === 0 ? 'active' : ''}" onclick="goToSlide(${i})"></span>`;
                }
                html += `</div>`;
            }
            html += `<button class="fullscreen-btn" onclick="openFullscreen()"><i class="fas fa-expand"></i></button>
                    </div>`;
            
            if (allImages.length > 1) {
                html += `<div class="thumbnail-gallery" id="thumbnailGallery">`;
                for (let i = 0; i < allImages.length; i++) {
                    html += `<img src="${allImages[i].src}" class="thumbnail ${i === 0 ? 'active' : ''}" onclick="goToSlide(${i})" data-index="${i}">`;
                }
                html += `</div>`;
            }
            
            if (architecturalStyle) html += `<div class="text-center"><span class="style-badge"><i class="fas fa-building"></i> ${escapeHtml(architecturalStyle)}</span></div>`;
            if (ownerName) html += `<div class="info-section"><div class="d-flex align-items-center"><div class="info-icon"><i class="fas fa-user"></i></div><div><div class="info-title">${isLao ? 'ເຈົ້າຂອງ' : 'Owner'}</div><div class="info-content">${escapeHtml(ownerName)}</div></div></div></div>`;
            if (data.construction_year) html += `<div class="info-section"><div class="d-flex align-items-center"><div class="info-icon"><i class="fas fa-calendar-alt"></i></div><div><div class="info-title">${isLao ? 'ປີກໍ່ສ້າງ' : 'Year Built'}</div><div class="info-content">${data.construction_year} ${isLao ? 'ຄ.ສ.' : 'CE'}</div></div></div></div>`;
            if (historicalSignificance) html += `<div class="info-section"><div class="d-flex align-items-start"><div class="info-icon"><i class="fas fa-history"></i></div><div><div class="info-title">${isLao ? 'ຄວາມສຳຄັນທາງປະຫວັດສາດ' : 'Historical Significance'}</div><div class="info-content">${escapeHtml(historicalSignificance)}</div></div></div></div>`;
            if (description) html += `<div class="info-section"><div class="d-flex align-items-start"><div class="info-icon"><i class="fas fa-align-left"></i></div><div><div class="info-title">${isLao ? 'ລາຍລະອຽດ' : 'Description'}</div><div class="info-content">${escapeHtml(description)}</div></div></div></div>`;
            
            if (data.latitude && data.longitude && data.latitude != 0 && data.longitude != 0) {
                html += `<div class="info-section"><div class="d-flex align-items-start"><div class="info-icon"><i class="fas fa-map-marker-alt"></i></div><div style="flex:1"><div class="info-title">${isLao ? 'ທີ່ຕັ້ງ' : 'Location'}</div><div class="map-container"><iframe width="100%" height="250" frameborder="0" style="border:0; border-radius: 15px;" src="https://www.openstreetmap.org/export/embed.html?bbox=${data.longitude-0.005},${data.latitude-0.005},${data.longitude+0.005},${data.latitude+0.005}&layer=mapnik&marker=${data.latitude},${data.longitude}" allowfullscreen></iframe></div><div class="mt-2"><a href="https://maps.google.com/?q=${data.latitude},${data.longitude}" target="_blank" class="btn btn-outline-success btn-sm"><i class="fas fa-external-link-alt"></i> ${isLao ? 'ເບິ່ງໃນ Google Maps' : 'View on Google Maps'}</a></div></div></div></div>`;
            }
            
            html += `<div class="share-section"><div class="info-title mb-3"><i class="fas fa-share-alt"></i> ແບ່ງປັນ</div>
                   
                    <a href="#" class="share-btn copy" onclick="copyToClipboard(); return false;"><i class="fas fa-link"></i></a>
                    </div></div>`;
            
            $('#detail-content').html(html);
            document.title = `${houseName || 'ມໍລະດົກ'} - ມໍລະດົກຫຼວງພະບາງ`;
            
            if (allImages.length > 1) {
                startAutoSlide();
            }
        }
        
        function changeSlide(direction) {
            stopAutoSlide();
            let newIndex = currentSlideIndex + direction;
            if (newIndex < 0) newIndex = allImages.length - 1;
            if (newIndex >= allImages.length) newIndex = 0;
            goToSlide(newIndex);
            startAutoSlide();
        }
        
        function goToSlide(index) {
            if (index === currentSlideIndex) return;
            
            $('.slide').removeClass('active');
            $(`.slide[data-index="${index}"]`).addClass('active');
            $('.dot').removeClass('active');
            $('.dot').eq(index).addClass('active');
            $('.thumbnail').removeClass('active');
            $('.thumbnail').eq(index).addClass('active');
            currentSlideIndex = index;
        }
        
        function startAutoSlide() {
            if (slideInterval) clearInterval(slideInterval);
            if (allImages.length > 1) {
                slideInterval = setInterval(() => {
                    let nextIndex = currentSlideIndex + 1;
                    if (nextIndex >= allImages.length) nextIndex = 0;
                    goToSlide(nextIndex);
                }, 4000);
            }
        }
        
        function stopAutoSlide() {
            if (slideInterval) {
                clearInterval(slideInterval);
                slideInterval = null;
            }
        }
        
        function openFullscreen() {
            stopAutoSlide();
            let imageSrc = allImages[currentSlideIndex].src;
            let fullscreenModal = document.getElementById('fullscreenModal');
            
            if (!fullscreenModal) {
                fullscreenModal = document.createElement('div');
                fullscreenModal.id = 'fullscreenModal';
                fullscreenModal.className = 'image-modal-full';
                fullscreenModal.innerHTML = `
                    <span class="close-modal">&times;</span>
                    <img id="fullscreenImage" src="">
                    <div class="modal-caption" id="modalCaptionFull"></div>
                    <button class="slider-btn fullscreen-prev" id="fullscreenPrev"><i class="fas fa-chevron-left"></i></button>
                    <button class="slider-btn fullscreen-next" id="fullscreenNext"><i class="fas fa-chevron-right"></i></button>
                `;
                document.body.appendChild(fullscreenModal);
                
                fullscreenModal.addEventListener('click', function(e) { 
                    if (e.target === fullscreenModal || e.target.classList.contains('close-modal')) {
                        fullscreenModal.classList.remove('active');
                        startAutoSlide();
                    }
                });
                
                document.getElementById('fullscreenPrev').addEventListener('click', function(e) {
                    e.stopPropagation();
                    let newIndex = currentSlideIndex - 1;
                    if (newIndex < 0) newIndex = allImages.length - 1;
                    goToSlide(newIndex);
                    document.getElementById('fullscreenImage').src = allImages[currentSlideIndex].src;
                    document.getElementById('modalCaptionFull').textContent = allImages[currentSlideIndex].caption || '';
                });
                
                document.getElementById('fullscreenNext').addEventListener('click', function(e) {
                    e.stopPropagation();
                    let newIndex = currentSlideIndex + 1;
                    if (newIndex >= allImages.length) newIndex = 0;
                    goToSlide(newIndex);
                    document.getElementById('fullscreenImage').src = allImages[currentSlideIndex].src;
                    document.getElementById('modalCaptionFull').textContent = allImages[currentSlideIndex].caption || '';
                });
                
                document.addEventListener('keydown', function(e) { 
                    if (fullscreenModal.classList.contains('active')) {
                        if (e.key === 'Escape') {
                            fullscreenModal.classList.remove('active');
                            startAutoSlide();
                        } else if (e.key === 'ArrowLeft') {
                            let newIndex = currentSlideIndex - 1;
                            if (newIndex < 0) newIndex = allImages.length - 1;
                            goToSlide(newIndex);
                            document.getElementById('fullscreenImage').src = allImages[currentSlideIndex].src;
                            document.getElementById('modalCaptionFull').textContent = allImages[currentSlideIndex].caption || '';
                        } else if (e.key === 'ArrowRight') {
                            let newIndex = currentSlideIndex + 1;
                            if (newIndex >= allImages.length) newIndex = 0;
                            goToSlide(newIndex);
                            document.getElementById('fullscreenImage').src = allImages[currentSlideIndex].src;
                            document.getElementById('modalCaptionFull').textContent = allImages[currentSlideIndex].caption || '';
                        }
                    }
                });
            }
            
            document.getElementById('fullscreenImage').src = imageSrc;
            document.getElementById('modalCaptionFull').textContent = allImages[currentSlideIndex].caption || '';
            fullscreenModal.classList.add('active');
        }
        
        function showError(message) { 
            const isLao = lang === 'lo'; 
            $('#detail-content').html(`<div class="error-section">
            <div class="error-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <h3 class="text-danger">${isLao ? 'ບໍ່ພົບຂໍ້ມູນ' : 'Data Not Found'}</h3>
            <p class="text-muted">${escapeHtml(message)}</p>
            <p class="mt-3">${isLao ? 'ກະລຸນາກວດສອບ QR Code ແລະລອງໃໝ່ອີກຄັ້ງ' : 'Please check the QR Code and try again'}</p>
            <div class="custom-divider"></div>
            <a href="index.php" class="back-button mt-3" style="display: inline-flex;"><i class="fas fa-home"></i> ${isLao ? 'ໜ້າຫຼັກ' : 'Home'}</a></div>`); 
        }
        
        function logVisit(houseId) { $.ajax({ url: 'api/log_visit.php', method: 'POST', data: { house_id: houseId } }); }
        function copyToClipboard() { navigator.clipboard.writeText(window.location.href).then(() => { Swal.fire({ icon: 'success', title: lang === 'lo' ? 'ສຳເນົາສຳເລັດ' : 'Copied!', text: lang === 'lo' ? 'ລິ້ງຖືກສຳເນົາໃສ່ Clipboard ແລ້ວ' : 'Link copied to clipboard', timer: 2000, showConfirmButton: false }); }); }
       
        function escapeHtml(str) { if (!str) return ''; return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/\n/g, '<br>'); }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>