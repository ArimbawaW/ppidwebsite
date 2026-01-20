/* ===== ADMIN CUSTOM SCRIPTS ===== */

$(document).ready(function() {
    
    // CSRF Token Setup
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // AUTO CONVERT BADGE BERDASARKAN TEXT - WARNA BERBEDA
    convertBadgeColors();
    
});

// Function untuk convert badge colors
function convertBadgeColors() {
    $('.badge').each(function() {
        var text = $(this).text().trim().toLowerCase();
        
        // Hapus semua class warna dulu
        $(this).removeClass('bg-warning bg-success bg-danger bg-secondary bg-info bg-primary');
        
        // Assign warna berdasarkan status
        if(text === 'selesai') {
            $(this).addClass('status-selesai bg-success');
        } 
        else if(text === 'pending' || text === 'menunggu') {
            $(this).addClass('status-pending bg-warning');
        } 
        else if(text === 'diproses' || text === 'sedang diproses') {
            $(this).addClass('status-diproses');
        } 
        else if(text === 'ditolak' || text === 'reject') {
            $(this).addClass('status-ditolak bg-danger');
        } 
        else if(text === 'menunggu verifikasi' || text === 'verifikasi') {
            $(this).addClass('status-verifikasi');
        } 
        else if(text === 'perlu perbaikan' || text === 'perbaikan') {
            $(this).addClass('status-perbaikan');
        } 
        else if(text === 'baru') {
            $(this).addClass('status-baru');
        } 
        else if(text === 'dibatalkan' || text === 'cancel') {
            $(this).addClass('status-dibatalkan bg-secondary');
        }
    });
}